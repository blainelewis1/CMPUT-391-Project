<?php

include_once('models/user.php');

ensureUserLoggedIn();

if(!isRadiologist()){
	include("views/denied.php");
	die();
}

include("views/uploading.php");

?>