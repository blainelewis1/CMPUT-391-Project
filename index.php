<?php

/*
	Basic landing page
*/

include_once('models/user.php');

$user = User::getLoggedInUser();

$title = "Radiology Information System";

$content = "views/landing.php";
include("views/templates/template.php");

?>