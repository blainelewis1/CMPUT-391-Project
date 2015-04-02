<?php

include_once("models/user.php");
include_once("misc/utils.php");

$user = User::getLoggedInUser();

$title = "Help";

$user_management = array("createuser", "edituser", "manageusers", "managepeople", "managefamilydoctors", "createfamilydoctor","editfamilydoctor","edituser", "editperson");

$content = "views/help/";

if (empty($_GET['page']) || $_GET['page'] == "radiologyinformationsystem") {
	$content .= "help.php";
} else if(in_array($_GET['page'], $user_management)) {
	$content .= 'manageusers.php';
}  else {
	$content .= $_GET['page'].'.php';
}


include("views/templates/help_template.php");

?>