<?php
//database details
#error_reporting(0);

$host     = 'localhost';
$user     = 'dev';
$password = 'Rockville1';
$database = 'magmile';

R::setup('mysql:host='.$host.';dbname='.$database.'', ''.$user.'', ''.$password.'');

#default for connection to make sure that tests for (!$mysqliConnection) is false
$mysqliConnection = null;

#handle exception if PDO cant connect to the database
try {
	$mysqliConnection = new PDO( "mysql:host={$host};dbname={$database}", $user, $password );
} catch (PDOException $eee) {
	
}

?>