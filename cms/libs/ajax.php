<?php

session_start();
require('redbean.php');
require('../../config.php');
require_once('Smarty.class.php');
require_once('functions.php');


$action = $_POST['action'];

if (logInCheck() == FALSE) {
    $output = array("status" => "NOK", "message" => "You must be logged in to perform this action");
} else {
		
		##########################################################################
		### category functions
		if ($action == "category_page_move") {
			
			#An admin only function
			if (!login_role_check('Admin')) {
				$output = array("status" => "OK", "message" => "only admins may call this function" );
				
			} else {
			
				$category_id = intval($_POST['category_id']);
				$page_id     = intval($_POST['page_id'    ]);
				
				R::exec("UPDATE divs SET category_id = ? WHERE id = ? LIMIT 1", array($category_id, $page_id) );
				$output = array("status" => "OK", "message" => "{$page_id} moved" );
			}
		}
	
		##########################################################################
    if ($action == "pageinfo") {
        $id = intval($_POST['id']);
        $info = R::getRow("SELECT * FROM divs WHERE id = " . $id);
        $output = array("status" => "OK", "id" => $id, "name" => $info['name'], "name_encoded" => $info['name_encoded']);
    }
    
    ##########################################################################
    if ($action == "userinfo") {
        $id = intval($_POST['id']);
        $info = R::getRow("SELECT * FROM users WHERE id = " . $id);
        $output = array("status" => "OK", "id" => $id, "name" => $info['username']);
    }
    
    ##########################################################################
    if ($action == "deletepage") {
    
    	#An admin only function
			if (!login_role_check('Admin')) {
				$output = array("status" => "OK", "message" => "only admins may call this function" );
				
			} else {
        $id = intval($_POST['id']);
        R::exec("DELETE FROM divs WHERE id = " . $id);
        $output = array("status" => "OK", "message" => "Page deleted", "id" => $id);
      }
    }
    
    ##########################################################################
    if ($action == "deleteuser") {
    	
    	#An admin only function
			if (!login_role_check('Admin')) {
				$output = array("status" => "OK", "message" => "only admins may call this function" );
				
			} else {
        $id = intval($_POST['id']);
        $user = R::getRow("SELECT * FROM users WHERE id = " . $id);
        $check = R::getAll("SELECT * FROM users WHERE function = 'Admin'");
        $count = count($check);
        if (($count <= 1) && ($user['function'] == 'Admin')) {
            $output = array("status" => "NOK", "message" => "Can't delete user. There must be at least 1 admin");
        } else {
            R::exec("DELETE FROM users WHERE id = " . $id);
            $output = array("status" => "OK", "message" => "User deleted", "id" => $id);
        }
      }
    }

    ##########################################################################
    if ($action == "activate") {
        $id = intval($_POST['id']);
        $check = R::getRow("SELECT * FROM divs WHERE id = " . $id);

        if ($check['active'] == true) {
            R::exec("UPDATE divs SET active = FALSE WHERE id = " . $id);
            $output = array("status" => "OK", "message" => "'" . $check['name'] . "' deactivated", "id" => $id);
        } else {
            R::exec("UPDATE divs SET active = TRUE WHERE id = " . $id);
            $output = array("status" => "OK", "message" => "'" . $check['name'] . "' activated", "id" => $id);
        }
    }

    ##########################################################################
    if ($action == "reset_settings") {
    	
    	#An admin only function
			if (!login_role_check('Admin')) {
				$output = array("status" => "OK", "message" => "only admins may call this function" );
				
			} else {
        $old = R::getRow("SELECT * FROM settings WHERE id = 1");
        if ($old['setting'] != "logo.png") {
            unlink("../img/user_img/" . $old['setting']);
        }
        R::exec("UPDATE settings SET setting = 'logo.png' WHERE id = 1");
        $output = array("status" => "OK");
      }
    }

    ##########################################################################
    if ($action == "activate_user") {
        $id = intval($_POST['id']);
        $user = R::getRow("SELECT * FROM users WHERE id = " . $id);
        $check = R::getAll("SELECT * FROM users WHERE function = 'Admin'");
        $count = count($check);
        if (($count <= 1) && ($user['function'] == 'Admin')) {
            if ($user['active'] == true) {
                $output = array("status" => "NOK", "message" => "Cannot de-activate user. There must be at least one active admin.");
            }
        } else {
            if ($user['active'] == true) {
                R::exec("UPDATE users SET active = FALSE WHERE id = " . $id);
                $output = array("status" => "OK", "message" => "'" . $user['username'] . "' deactivated", "id" => $id);
            } else {
                R::exec("UPDATE users SET active = TRUE WHERE id = " . $id);
                $output = array("status" => "OK", "message" => "'" . $user['username'] . "' activated", "id" => $id);
            }
        }
    }
    ##########################################################################
}
echo json_encode($output);
?>