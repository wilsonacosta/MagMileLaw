<?php

#categories
$categories = R::getAll("SELECT * FROM category ORDER BY name ASC");

foreach ($categories as $key => $value) {
	
	#pages
	$pages = R::getAll("SELECT * FROM divs WHERE category_id=? ORDER BY timestamp desc", array($value['id']) );
	
	foreach ($pages as $k=>$v) {
			$pages[$k]['name'] = stripslashes(strip_tags(html_entity_decode($v['name'])));
			$pages[$k]['content'] = (strlen($v['content']) > 13) ? substr(stripslashes(strip_tags(html_entity_decode($v['content']))),0,99).'...' : $v['content'];
			$pages[$k]['code'] = htmlentities("<!--{" . $v['name_encoded'] . "}-->");
			$pages[$k]['date'] = date("d-m-Y H:i:s", $v['timestamp']);
					
			if ($v['active'] == true) {
					$pages[$k]['active'] = "checked";
			}
	}
	
	$categories[$key]['pages'] = $pages;
}

$smarty->assign('categories', $categories );

/*
#pages
$pages = R::getAll("SELECT * FROM divs ORDER BY timestamp desc");

foreach ($pages as $k=>$v) {
    $pages[$k]['name'] = stripslashes(strip_tags(html_entity_decode($v['name'])));
    $pages[$k]['content'] = (strlen($v['content']) > 13) ? substr(stripslashes(strip_tags(html_entity_decode($v['content']))),0,99).'...' : $v['content'];
    $pages[$k]['code'] = htmlentities("<!--{" . $v['name_encoded'] . "}-->");
    $pages[$k]['date'] = date("d-m-Y H:i:s", $v['timestamp']);
        
    if ($v['active'] == true) {
        $pages[$k]['active'] = "checked";
    }
}
*/
$smarty->assign('e_email_grav', $user_array['email']);
#$smarty->assign('pages', $pages);
$smarty->display('templates/pages.tpl');

?>
