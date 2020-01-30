<?php

#############################################################################>
/**
 * list all the available categories
 */
function page_run( $smarty, $user_array ) {

	#must be an admin or editor
	if ( !(($user_array['function'] == "Admin") or ($user_array['function'] == "Editor")) ) {
		$smarty->display('templates/404.tpl');
		exit;
	}
	
	#load the category data
	$categories = R::getAll("SELECT * FROM category ORDER BY name ASC");
	
	$smarty->assign('categories',   $categories );
	$smarty->assign('e_email_grav', $user_array['email']);
	$smarty->display('templates/category_list.tpl');
}
#############################################################################>
# run the page
page_run( $smarty, $user_array );
#############################################################################>
