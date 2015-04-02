<?php

include_once("models/user.php");
include_once("misc/utils.php");

$title = "Help";

$user_management = array("createuser", "edituser", "usermanagement");

$content = "views/help/";

if(in_array($_GET['page'], $user_management)){
	$content .= 'user_management.php';
} else {
	$content .= $_GET['page'].'.php';
}


include("views/templates/help_template.php");

?>