<?php

$token = $_GET['token'];

$check = R::getRow("SELECT * FROM users WHERE request_token = '" . $token . "'");

 $html = '<form id="login" action="" method="POST">
                    <div class="wc_content">
                        <div class="wc_header">Password</div>
                        <div class="wc_content"><input type="password" name="e_password"/></div>
                        <div class="wc_header">Retype Password</div>
                        <div class="wc_content"><input type="password" name="e_password2"/></div>
                        <div class="wc_header"><input type="submit" class="red_button" value="Save">
                    </div>
                    </form>';

if (empty($check)) {
    $smarty->assign('error', "Token is not valid. Request a new password");
} else {
    if (time() >= ($check['request_time'] + 86400)) {
        $smarty->assign('error', "Token is not valid anymore. Request a new password");
    } else {
        if (isset($_POST['e_password'])) {
            if (empty($_POST['e_password'])) {
                $smarty->assign('error', "Please fill in a password");
                $smarty->assign('passwordform', $html);
            } else {
                if ($_POST['e_password'] != $_POST['e_password2']) {
                    $smarty->assign('error', "Passwords do not match");
                    $smarty->assign('passwordform', $html);
                } else {
                    $hash_password = hash("sha256", hash("sha256", $_POST['e_password']));
                    $query = "UPDATE users SET password='" . $hash_password . "', request_token='0',  request_time=0 WHERE request_token = '" . $token . "'";
                    R::exec($query);
                    $smarty->assign('good', "Your password has been reset");
                }
            }
        } else {
            $smarty->assign('passwordform', $html);
        }
    }
}


if (isset($_POST['email'])) {
    
}


$smarty->display('templates/reset.tpl');
?>