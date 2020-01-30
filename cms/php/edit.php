<?php

$id = xscape($_GET['editID']);
$edit_page = R::getRow("SELECT * FROM divs WHERE id = " . $id);

if (empty($edit_page)) {
    $smarty->display('templates/404.tpl');
} else {
    if (isset($_POST['e_title'])) {
        $title = (strlen($_POST['e_title']) > 60) ? substr(strip_tags(html_entity_decode($_POST['e_title'])),0,60).'...' : $_POST['e_title'];
        $content = htmlentities(addslashes($_POST['e_content']));

        if (empty($title)) {
            $smarty->assign('e_error', "Please fill in a title");
            $smarty->assign('e_email_grav', $user_array['email']);
            $smarty->assign('e_name_encoded', htmlentities("<!--{" . $edit_page['name_encoded'] . "}-->"));
            $smarty->assign('e_title', stripslashes(strip_tags($edit_page['name'])));
            $smarty->assign('e_content', stripslashes(html_entity_decode($edit_page['content'])));
            $smarty->display('templates/edit.tpl');
        } else {                       
            R::exec("UPDATE divs SET name='" . htmlentities(addslashes($title)) . "', content='" . $content . "', timestamp = ".time()." WHERE id = " . $id);
            $edit_page = R::getRow("SELECT * FROM divs WHERE id = " . $id);
            $smarty->assign('e_email_grav', $user_array['email']);
            $smarty->assign('e_good', "Page was updated!");
            $smarty->assign('e_name_encoded', htmlentities("<!--{" . $edit_page['name_encoded'] . "}-->"));
            $smarty->assign('e_title', stripslashes(strip_tags($edit_page['name'])));
            $smarty->assign('e_content', stripslashes(html_entity_decode($edit_page['content'])));
            $smarty->display('templates/edit.tpl');
        }
    } else {
        $smarty->assign('e_email_grav', $user_array['email']);
        $smarty->assign('e_name_encoded', htmlentities("<!--{" . $edit_page['name_encoded'] . "}-->"));
        $smarty->assign('e_title', stripslashes(strip_tags($edit_page['name'])));
        $smarty->assign('e_content', stripslashes(html_entity_decode($edit_page['content'])));
        $smarty->display('templates/edit.tpl');
    }
}
?>
