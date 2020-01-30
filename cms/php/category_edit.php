<?php

#############################################################################>
/**
 * edit an existing category
 */
function page_run( $smarty, $user_array ) {

	#must be an admin or editor
	if ( !(($user_array['function'] == "Admin") or ($user_array['function'] == "Editor")) ) {
		$smarty->display('templates/404.tpl');
		exit;
	}
	
	#load from database
	$category_id   = "";
	$category_name = "";
	
	if (isset($_GET['id'])) {
		$category_id = \intval($_GET['id']);
	}
	if (isset($_POST['id'])) {
		$category_id = \intval($_POST['id']);
	}
	
	if (intval($category_id) > 0) {
	
		$datum = R::getRow("SELECT * FROM category WHERE id=?", array($category_id) );
		
		$category_name = $datum['name'];
		
		#edit
		if (isset($_POST['e_category_name'])) {
			 
			$category_name = $_POST['e_category_name'];
			
			if (\is_string($category_name) and (strlen(trim($category_name)) > 0)) {
			 
				$category_name = trim($category_name);
				
				#make sure no duplicates
				$count = R::getRow("SELECT COUNT(*) AS counter FROM category WHERE name=?", array($category_name) );
				$count = intval($count['counter']);
				
				#update the database
				if ($count == 0) {
					R::exec("UPDATE category SET name=? WHERE id=? LIMIT 1", array($category_name, $category_id) );
					
					header( "Location: index.php?page=category_list");
					exit;
				} else {
					errorUserResponse($smarty, "This category already exists", "category_edit.tpl");
				}
			} else {
				errorUserResponse($smarty, "Please add a category", "category_edit.tpl");
			}
		}
	} else {
		errorUserResponse($smarty, "Please add a category ID", "category_edit.tpl");
	}
	
	#show the page
	$smarty->assign('e_category_id',   $category_id   );
	$smarty->assign('e_category_name', $category_name );
	
	$smarty->assign('e_email_grav', $user_array['email']);
	$smarty->display('templates/category_edit.tpl');
}
#############################################################################>
# run the page
page_run( $smarty, $user_array );
#############################################################################>
