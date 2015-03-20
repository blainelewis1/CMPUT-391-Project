<?php

include_once('models/user.php');

ensureUserLoggedIn();

if(!isAdmin()){
	include("views/denied.php");
	die();
}

include("views/user_management.php");

?>