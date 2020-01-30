<?php
if (isset($_POST['username'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    //If google crypto is not used, set TRUE to false
    $response = LogIn($username, $password, TRUE);
    
    if ($response['status'] == "NOK") {
        $smarty->assign('error', $response['message']);
        $smarty->assign('username', $username);
    }
    else {
        header('Location: index.php');
    }
}
        $smarty->display('templates/login.tpl');

?>
