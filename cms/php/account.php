<?php
if (isset($_POST['e_username'])) {
    if (empty($_POST['e_username'])) {
        $smarty->assign('e_email_grav', $user_array['email']);
        errorUserResponse($smarty, "Please fill in a username", "account.tpl");
    } elseif (empty($_POST['e_email'])) {
        $smarty->assign('e_email_grav', $user_array['email']);
        errorUserResponse($smarty, "Please fill in a valid email address", "account.tpl");
    } else {
        if (check_email_address($_POST['e_email']) == false) {
            $smarty->assign('e_email_grav', $user_array['email']);
            errorUserResponse($smarty, "This is not a valid email address", "account.tpl");
        } else {
            if (validate_username($_POST['e_username']) == false) {
        		$smarty->assign('e_email_grav', $user_array['email']);
                errorUserResponse($smarty, "Usernames can only be alphanumeric and may not contain spaces", "account.tpl");
            } else {
                if (empty($_POST['e_password'])) {
                    $smarty->assign('e_email_grav', $user_array['email']);
                    errorUserResponse($smarty, "Please fill in a password", "account.tpl");
                } else {
                    if ($_POST['e_password'] != $_POST['e_password2']) {
                       $smarty->assign('e_email_grav', $user_array['email']);
                       errorUserResponse($smarty, "Passwords do not match", "account.tpl");
                    } else { 
                       updateUserResponse($smarty, $_POST['e_username'], 
                       $_POST['e_password'], $_POST['e_email'], $user_array['id'], "account.tpl", $smarty->assign('e_email_grav', $user_array['email']));                       
                    }
                }
            }
        }
    }
} else {
    $user = R::getRow("SELECT * FROM users WHERE id = " . $user_array['id']);
    $smarty->assign('e_email', $user_array['email']);
    $smarty->assign('e_email_grav', $user_array['email']);
    $smarty->assign('e_username', $user_array['username']);
    $smarty->display('templates/account.tpl');
}
?>

