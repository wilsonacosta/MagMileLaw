<?php

#############################################################################>
/**
 * add a new category
 */
function page_run( $smarty, $user_array ) {

	#must be an admin or editor
	if ( !(($user_array['function'] == "Admin") or ($user_array['function'] == "Editor")) ) {
		$smarty->display('templates/404.tpl');
		exit;
	}
	
	#add to database
	$category_name = "";
	
	if (isset($_POST['e_category_name'])) {
	 	 
		$category_name = $_POST['e_category_name'];
		
		if (\is_string($category_name) and (strlen(trim($category_name)) > 0)) {
		 
			$category_name = trim($category_name);
			
			#make sure no duplicates
			$count = R::getRow("SELECT COUNT(*) AS counter FROM category WHERE name=?", array($category_name) );
			$count = intval($count['counter']);
			
			#insert into database
			if ($count == 0) {
				$category = R::dispense('category');
				$category->name       = htmlentities(addslashes($category_name));
				$category->created_on = date( 'Y-m-d H:i:s');
				$category->updated_on = date( 'Y-m-d H:i:s');
				R::store($category);
				
				header( "Location: index.php?page=category_list");
				exit;
			} else {
				errorUserResponse($smarty, "This category already exists", "category_add.tpl");
			}
		} else {
			errorUserResponse($smarty, "Please add a category", "category_add.tpl");
		}
	}
	
	#show the page
	$smarty->assign('e_category_name', $category_name );
	
	$smarty->assign('e_email_grav', $user_array['email']);
	$smarty->display('templates/category_add.tpl');
}
#############################################################################>
# run the page
page_run( $smarty, $user_array );
#############################################################################>
