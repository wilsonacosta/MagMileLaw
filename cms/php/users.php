<?php

if ($user_array['function'] != "Admin") {
    $smarty->display('templates/404.tpl');
} else {

    $users = R::getAll("SELECT * FROM users ORDER BY timestamp desc");

    foreach ($users as $k => $v) {
    	
        #$users[$k]['name'   ] = stripslashes(strip_tags(html_entity_decode($v['name'])));
        #$users[$k]['content'] = (strlen($v['content']) > 13) ? substr(stripslashes(strip_tags(html_entity_decode($v['content']))), 0, 60) . '...' : $v['content'];
        $users[$k]['date'   ] = date("d-m-Y H:i:s", $v['timestamp']);

        if ($v['active'] == true) {
            $users[$k]['active'] = "checked";
        }
    }
    $smarty->assign('e_email_grav', $user_array['email']);
    $smarty->assign('users', $users);
    $smarty->display('templates/users.tpl');
}
?>
