<?php

#must be an admin or editor
if ( !(($user_array['function'] == "Admin") or ($user_array['function'] == "Editor")) ) {
	$smarty->display('templates/404.tpl');
	exit;
}

#process
    if (isset($_POST['e_title'])) {
        $title = (strlen($_POST['e_title']) > 60) ? substr(strip_tags(html_entity_decode($_POST['e_title'])),0,60).'...' : $_POST['e_title'];
        $content = htmlentities(addslashes($_POST['e_content']));

        if (empty($title)) {
            errorUserResponse($smarty, "Please fill in a page title", "newpage.tpl");
        } else {
            
            $div = R::dispense('divs');
            $div->name = htmlentities(addslashes($title));
            $div->name_encoded = uniqid();
            $div->content = $content;
            $div->timestamp = time();
            $div->active = true;
            $id = R::store($div);
            
            header('Location: index.php?page=pages');
            
        }
    } else {
        $smarty->assign('e_email_grav', $user_array['email']);
        $smarty->display('templates/newpage.tpl');
    }
?>