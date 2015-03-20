<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

if($user->isAdmin()){

	include("views/denied.php");
	die();
	
}

include("views/data_analysis.php");

?>