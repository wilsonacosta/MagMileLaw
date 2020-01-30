<?php
session_start();

$server = $_SERVER["SCRIPT_FILENAME"];
$server = str_replace("index.php", "", $server);
$templates_c = $server . 'templates_c';
if (!is_writable($templates_c )) {
    echo 'Please make sure the folder install/templates_c and cms/templates_c is writable. In Filezilla -> right click the folder -> file permissions -> 777. For more instructions check the Dropkick documentation';
}
require('../cms/libs/redbean.php');
require('../config.php');
require_once('../cms/libs/Smarty.class.php');
require_once('../cms/libs/functions.php');

$smarty = new Smarty();

    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = "install";
    }
    

include('php/' . $page . '.php');
?>

