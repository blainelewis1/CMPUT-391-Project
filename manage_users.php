<?php

include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

if(!$user->isAdmin()){
	include("views/denied.php");
	die();
}

if(isset($_GET[User::USER_NAME])) {
	User::deleteRecord($_GET[User::USER_NAME]);
}

$users = User::getAllUsers();

include("views/list_users.php");

?>