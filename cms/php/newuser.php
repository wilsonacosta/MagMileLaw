<?php

if ($user_array['function'] != "Admin") {
    $smarty->display('templates/404.tpl');
} else {
    if (isset($_POST['e_username'])) {
        if (empty($_POST['e_username'])) {
            errorUserResponse($smarty, "Please fill in a username", "newuser.tpl");
        } elseif (empty($_POST['e_email'])) {
            errorUserResponse($smarty, "Please fill in a valid email address", "newuser.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
        } else {
            if (check_email_address($_POST['e_email']) == false) {
                errorUserResponse($smarty, "This is not a valid email address", "newuser.tpl", $smarty->assign('e_email_grav', $user_array['email']));
            } else {
                if (validate_username($_POST['e_username']) == false) {
                    errorUserResponse($smarty, "Usernames can only be alphanumeric and may not contain spaces", "newuser.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                } else {
                    if (empty($_POST['e_password'])) {
                        errorUserResponse($smarty, "Please fill in a password", "newuser.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                    } else {
                        if ($_POST['e_password'] != $_POST['e_password2']) {
                            errorUserResponse($smarty, "Passwords do not match", "newuser.tpl", $smarty->assign('e_email_grav', $user_array['email'])); 
                        } else {
                            $id = newUserResponse($smarty, $_POST['e_username'], $_POST['e_password'], $_POST['e_email'], $_POST['e_rights']);
                            header('Location: index.php?page=users');
                        }
                    }
                }
            }
        }
    } else {
        $smarty->assign('e_email_grav', $user_array['email']);
        $smarty->display('templates/newuser.tpl');
    }
}
?>

