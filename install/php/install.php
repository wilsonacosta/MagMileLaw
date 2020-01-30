<?php

#error_reporting(0);
$mysqliConnection = mysqli_connect($host, $user, $password);

if (!$mysqliConnection) {
    $smarty->assign('e_error', "Your database is not yet connected. Before you proceed, make sure that you have correctly filled in your database details in config.php");
} else {
    $smarty->assign('e_good', "Your database is connected. Let's do this!");
    $check = R::getAll("SELECT * FROM menu");
    if (!empty($check)) {
        header('Location: ../cms');
    }
    
    $_SESSION['database'] = array("host" => $host, "user" => $user, "password" => $password, "database" => $database);
}

if (isset($_POST['e_username'])) {
    if (empty($_POST['e_username'])) {
        errorUserResponse($smarty, "Please fill in a username", "install.tpl");
    } elseif (empty($_POST['e_email'])) {
        errorUserResponse($smarty, "Please fill in a valid email address", "install.tpl");
    } else {
        if (check_email_address($_POST['e_email']) == false) {
            errorUserResponse($smarty, "This is not a valid email address", "install.tpl");
        } else {
            if (validate_username($_POST['e_username']) == false) {
                errorUserResponse($smarty, "Usernames can only be alphanumeric and may not contain spaces", "install.tpl");
            } else {
                if (empty($_POST['e_password'])) {
                    errorUserResponse($smarty, "Please fill in a password", "install.tpl");
                } else {
                    if ($_POST['e_password'] != $_POST['e_password2']) {
                        errorUserResponse($smarty, "Passwords do not match", "install.tpl");
                    } else {
                        $hash_password = hash("sha256", hash("sha256", $_POST['e_password']));
                        $_SESSION['reg_user'] = array("username" => $_POST['e_username'], "email" => $_POST['e_email'], "password" => $hash_password);
                        header('Location: index.php?page=install2');
                    }
                }
            }
        }
    }
} else {
    $smarty->display('templates/install.tpl');
}
?>