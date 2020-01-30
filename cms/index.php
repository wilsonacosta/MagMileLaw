<?php
session_start();
require('libs/redbean.php');
require('../config.php');

if (!$mysqliConnection) {
    echo 'Oh oh, database connection failed. If you have installed Dropkick already, check your settings in config.php.<br/> Otherwise, browse to the install folder.';
}

$server = $_SERVER["SCRIPT_FILENAME"];
$server = str_replace("index.php", "", $server);
$templates_c = $server . 'templates_c';
if (!is_writable($templates_c )) {
    echo 'Please make sure the folder install/templates_c and CMS/templates_c is writable. In Filezilla -> right click the folder -> file permissions -> 777. For more instructions check the Dropkick documentation';
}

require_once('libs/Smarty.class.php');
require_once('libs/functions.php');
bruteForceProtect();

$settings = R::getAll("SELECT * FROM settings");

$smarty = new Smarty();

#make a note of acl role
$smarty->assign( 'acl_role_admin',  login_role_check('Admin' ) );
$smarty->assign( 'acl_role_editor', login_role_check('Editor') );
$smarty->assign( 'acl_role_user',   login_role_check('User'  ) );


if (empty($settings)) {
    $smarty->assign('logo', "logo.png");
    $smarty->assign('error', "Dropkick is not yet configured. Please go to <a href='../install/index.php'>install</a>");
}
else {
    $smarty->assign('logo', $settings[0]['setting']);
}


if (logInCheck() == FALSE) {
    if (isset($_GET['page']) and (($_GET['page'] == "forgot") || ($_GET['page'] == "reset"))) {
        $page = $_GET['page'];
    } else {
        $page = "login";
    }
} else {
    $user_array = R::getRow("SELECT * FROM users WHERE id = " . $_SESSION['user']['id']);
    $smarty->assign('username', $user_array['username']);

    //check install folder
    if (file_exists('../install')) {
        $div = '<div id="imp_message">WARNING! For security reasons, please delete the install directory and all its contents</div>';
        $smarty->assign('imp_message', $div);
    }
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "pages";
    }

    //menu 
    if ($user_array['function'] == "Admin") {
        $menu = R::getAll("SELECT * FROM menu");
    } else {
        $menu = R::getAll("SELECT * FROM menu WHERE rights = 'All'");
    }

    foreach ($menu as $k => $v) {
        if ($v['name_encoded'] == $page) {
            $menu[$k]['active'] = 'active';
        }
    }
    $smarty->assign('menu', $menu);
    $smarty->assign('a_' . $page, "active");
}

include('php/' . $page . '.php');
?>

