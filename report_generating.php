<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

if($user->isRadiologist()){
	include("views/denied.php");
	die();
}

include("views/report_generating.php");

?>