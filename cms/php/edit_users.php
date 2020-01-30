<?php

if ($user_array['function'] != "Admin") {
    $smarty->display('templates/404.tpl');
} else {
    $id = xscape($_GET['editID']);
    $edit_user = R::getRow("SELECT * FROM users WHERE id = " . $id);

    if (empty($edit_user)) {
        $smarty->display('templates/404.tpl');
    } else {
        if (isset($_POST['e_username'])) {
            if (empty($_POST['e_username'])) {
                errorUserResponse($smarty, "Please fill in a username", "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
            } elseif (empty($_POST['e_email'])) {
                errorUserResponse($smarty, "Please fill in a valid email address", "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
            } else {
                if (check_email_address($_POST['e_email']) == false) {
                    errorUserResponse($smarty, "This is not a valid email address", "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                } else {
                    if (validate_username($_POST['e_username']) == false) {
                        errorUserResponse($smarty, "Usernames can only be alphanumeric and may not contain spaces", "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                    } else {
                        if ($_POST['e_rights'] == "Editor") {
                            $check = R::getAll("SELECT * FROM users WHERE function = 'Admin'");
                            $count = count($check);
                            if (($count <= 1) && ($edit_user['function'] == 'Admin')) {
                                errorUserResponse($smarty, "There must be at least one Admin", "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                            } else {
                                goodUserResponse($smarty, $_POST['e_username'], $_POST['e_email'], $_POST['e_rights'], $id, "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                            }
                        } else {
                            goodUserResponse($smarty, $_POST['e_username'], $_POST['e_email'], $_POST['e_rights'], $id, "edit_users.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                        }
                    }
                }
            }
        } else {
            $smarty->assign('e_username', $edit_user['username']);
            $smarty->assign('e_email', $edit_user['email']);
            $smarty->assign('e_email_grav', $user_array['email']);
            
            if ($edit_user['function'] == "Admin") {
                $smarty->assign('e_admin', "SELECTED");
            } else if ($edit_user['function'] == "Editor") {
                $smarty->assign('e_editor', "SELECTED");
            } else if ($edit_user['function'] == "User") {
                $smarty->assign('e_user', "SELECTED");
            }
            $smarty->display('templates/edit_users.tpl');
        }
    }
}
?>
