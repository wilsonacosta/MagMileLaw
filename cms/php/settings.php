<?php

if ($user_array['function'] != "Admin") {
    $smarty->display('templates/404.tpl');
} else {
    if (isset($_FILES['logo']) and isset($_FILES['logo']['name']) and (strlen($_FILES['logo']['name']) > 0)) {
        $allowedExts = array("gif", "jpeg", "jpg", "png", "JPG", "PNG", "JPEG", "GIF");
        $extension = end(explode(".", $_FILES["logo"]["name"]));
        if ((($_FILES["logo"]["type"] == "image/gif")
                || ($_FILES["logo"]["type"] == "image/jpeg")
                || ($_FILES["logo"]["type"] == "image/jpg")
                || ($_FILES["logo"]["type"] == "image/pjpeg")
                || ($_FILES["logo"]["type"] == "image/x-png")
                || ($_FILES["logo"]["type"] == "image/png"))
                && ($_FILES["logo"]["size"] < 2000000)
                && in_array($extension, $allowedExts)) {
            if ($_FILES["logo"]["error"] > 0) {
                $smarty->assign('e_error', "Error: " . $_FILES["logo"]["error"]);
                $smarty->display('templates/settings.tpl');
            } else {
                if (file_exists("img/user_img/" . $_FILES["logo"]["name"])) {
                    unlink("img/user_img/" . $_FILES["logo"]["name"]);
                    move_uploaded_file($_FILES["logo"]["tmp_name"], "img/user_img/" . $_FILES["logo"]["name"]);
                    R::exec("UPDATE settings SET setting = '" . $_FILES["logo"]["name"] . "' WHERE id = 1");
                    header('Location: index.php?page=settings');
                } else {
                    $old = R::getRow("SELECT * FROM settings WHERE id = 1");
                    if ($old['setting'] != "logo.png") {
                        unlink("img/user_img/" . $old['setting']);
                    }
                    move_uploaded_file($_FILES["logo"]["tmp_name"], "img/user_img/" . $_FILES["logo"]["name"]);
                    R::exec("UPDATE settings SET setting = '" . $_FILES["logo"]["name"] . "'");
                    header('Location: index.php?page=settings');
                }
            }
        } else {
            $smarty->assign('e_error', "Invalid file");
            $smarty->assign('e_email_grav', $user_array['email']);
            $smarty->display('templates/settings.tpl');
        }
    } else {
        $smarty->assign('e_email_grav', $user_array['email']);
        $smarty->display('templates/settings.tpl');
    }
}
?>

