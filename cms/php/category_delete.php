<?php

#############################################################################>
/**
 * delete an existing category
 */
function page_run( $smarty, $user_array ) {

	#must be an admin or editor
	if ( !(($user_array['function'] == "Admin") or ($user_array['function'] == "Editor")) ) {
		$smarty->display('templates/404.tpl');
		exit;
	}
	
	#category to delete
	$category_id = "";
	
	if (isset($_GET['id'])) {
	 	 
		$category_id = $_GET['id'];
		
		if (\is_string($category_id) and (strlen(trim($category_id)) > 0)) {
		 
			$category_id = trim($category_id);
			
			$datum = R::getRow("SELECT * FROM category WHERE id=?", array($category_id) );
			
			if (strcasecmp($datum['name'], 'top level') !== 0) { #cant delete top level category
			
				#nuke
				R::exec("DELETE FROM category WHERE id=? LIMIT 1", array($category_id) );
			}
		}
	}
	
	#show the list page
	header( "Location: index.php?page=category_list");
	exit;
}
#############################################################################>
# run the page
page_run( $smarty, $user_array );
#############################################################################>
