<?php

function xscape($in) {
    $out = addslashes($in);
    return($out);
}

function nameEnc($in) {
    $out = strip_tags(html_entity_decode($in));
    $out = preg_replace("/[^A-Za-z0-9 ]/", '', $out);
    $out = substr($out, 0, 15);
    $out = str_replace(" ", "_", $out);
    return($out);
}

/**
 * a logged in user - checks the session
 */
function logInCheck() {
    if (isset($_SESSION['user'])) {
        $u = $_SESSION['user'];

        if ($u['timestamp'] < (time() - 7200)) {
            return FALSE;
        } else {
            $query = "SELECT salt FROM users WHERE id = " . $u['id'];
            $user = R::getRow($query);
            $ip = $_SERVER['REMOTE_ADDR'];
            $session_token = hash("sha256", $ip . $u['timestamp'] . $user['salt']);

            if ($u['session_token'] != $session_token) {
                return FALSE;
            } else {
                $time = time();
                $session_token = hash("sha256", $ip . $time . $user['salt']);
                $_SESSION['user'] = array("timestamp" => $time, "id" => $u['id'], "session_token" => $session_token, "function" => $u['function']);
                return TRUE;
            }
        }
    } else {
        return FALSE;
    }
}

/**
 * login
 */
function LogIn($username, $password, $sha256 = FALSE) {
    if (empty($username)) {
        $output = array("status" => "NOK", "message" => "Please fill in a username");
    } elseif (empty($password)) {
        $output = array("status" => "NOK", "message" => "Please fill in a password");
    } else {
        if ($sha256 == FALSE) {
            $hash_password = hash("sha256", hash("sha256", $password));
        }
        if ($sha256 == TRUE) {
            $hash_password = hash("sha256", $password);
        }
        $query = "SELECT * FROM users WHERE username = '" . $username . "' AND password = '" . $hash_password . "' AND active = TRUE";
        $user = R::getRow($query);
        if (empty($user)) {
            $output = array("status" => "NOK", "message" => "Invalid combination username and password");
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
            $time = time();
            $session_token = hash("sha256", $ip . $time . $user['salt']);
            $_SESSION['user'] = array("timestamp" => $time, "id" => $user['id'], "session_token" => $session_token, "function" => $user['function']);
            R::exec("UPDATE users SET timestamp = " . time() . " WHERE id = " . $user['id']);
            $output = array("status" => "OK", "message" => "You shall pass!");
        }
    }
    return($output);
}

/**
 * a logged in user - acl role check
 */
function login_role_check( $role ) {
	
	$result = false;
	
	if (isset($role) and \is_string($role) and isset($_SESSION['user']) and isset($_SESSION['user']['function']) and is_string($_SESSION['user']['function'])) {
		
		$result = (strcasecmp($role, $_SESSION['user']['function']) == 0);
	}
	
	return $result;
}

function check_email_address($email) {
    // First, we check that there's one @ symbol, and that the lengths are right
    if (!preg_match("/^[^@]{1,64}@[^@]{1,255}$/", $email)) {
        // Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
        return false;
    }
    // Split it into sections to make life easier
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if (!preg_match("/^(([A-Za-z0-9!#$%&'*+\/=?^_`{|}~-][A-Za-z0-9!#$%&'*+\/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/", $local_array[$i])) {
            return false;
        }
    }
    if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1])) { // Check if domain is IP. If not, it should be valid domain name
        $domain_array = explode(".", $email_array[1]);
        if (sizeof($domain_array) < 2) {
            return false; // Not enough parts to domain
        }
        for ($i = 0; $i < sizeof($domain_array); $i++) {
            if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i])) {
                return false;
            }
        }
    }

    return true;
}

function validate_username($str) {
    $allowed = array(".", "-", "_");
    if (ctype_alnum(str_replace($allowed, '', $str))) {
        return true;
    } else {
        return false;
    }
}

function errorUserResponse($smarty, $error, $template) {
    $smarty->assign('e_error', $error);
    $smarty->assign('e_email',    $_POST['e_email']);
    $smarty->assign('e_username', $_POST['e_username']);
    if (isset($_POST['e_rights']) and ($_POST['e_rights'] == "Admin")) {
        $smarty->assign('e_admin', "SELECTED");
    }
    if (isset($_POST['e_rights']) and ($_POST['e_rights'] == "Editor")) {
        $smarty->assign('e_admin', "SELECTED");
    }
    $smarty->display('templates/' . $template);
}

function goodUserResponse($smarty, $username, $email, $function, $id, $template) {
    $query = "UPDATE users SET username='" . $username . "', email='" . $email . "', function = '" . $function . "' WHERE id = " . $id;
    R::exec($query);
    $edit_user = R::getRow("SELECT * FROM users WHERE id = " . $id);
    $smarty->assign('e_good', "User was updated!");
    $smarty->assign('e_email', $email);
    $smarty->assign('e_username', $username);
    if ($function == "Admin") {
        $smarty->assign('e_admin', "SELECTED");
    }
    if ($function == "Editor") {
        $smarty->assign('e_editor', "SELECTED");
    }
    $smarty->display('templates/' . $template);
}

function newUserResponse($smarty, $username, $password, $email, $function) {
    $salt = hash("sha256", $username . $email . time());
    $hash_password = hash("sha256", hash("sha256", $password));

    $div = R::dispense('users');
    $div->username = $username;
    $div->password = $hash_password;
    $div->salt = $salt;
    $div->email = $email;
    $div->function = $function;
    $div->timestamp = time();
    $div->active = true;
    $id = R::store($div);

    return $id;
}

function updateUserResponse($smarty, $username, $password, $email, $id, $template) {
    $hash_password = hash("sha256", hash("sha256", $password));
    $query = "UPDATE users SET username='" . $username . "', password='" . $hash_password . "', email='" . $email . "' WHERE id = " . $id;
    R::exec($query);
    $smarty->assign('e_good', "Your account has been updated!");
    $smarty->assign('e_email', $email);
    $smarty->assign('e_username', $username);
    $smarty->display('templates/' . $template);
}

function bruteForceProtect() {
    $next_time = time() - 600;
    $query = "SELECT * FROM banned WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'";
    $check_ban = R::getRow($query);
    if (!empty($check_ban)) {
        if ($check_ban['timestamp'] < $next_time) {
            R::exec("DELETE FROM banned WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'");
        } else {
            exit("Your IP has been blocked for 10 minutes.");
        }
    }
    if (isset($_SESSION['ipcheck'])) {
        $new_count = $_SESSION['ipcheck']['count'] + 1;
        $_SESSION['ipcheck'] = array("count" => $new_count, "timestamp" => $_SESSION['ipcheck']['timestamp']);
        $maxtime = time() - 10;
        if ($maxtime < $_SESSION['ipcheck']['timestamp']) {
            if ($_SESSION['ipcheck']['count'] > 100) {
                //block this IP
                $div = R::dispense('banned');
                $div->ip = $_SERVER['REMOTE_ADDR'];
                $div->timestamp = time();
                $id = R::store($div);
            }
        } else {
            $_SESSION['ipcheck'] = array("count" => 1, "timestamp" => time());
        }
    } else {
        $_SESSION['ipcheck'] = array("count" => 1, "timestamp" => time());
    }
}

?>
