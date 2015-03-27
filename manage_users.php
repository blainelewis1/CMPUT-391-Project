<?php

include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

$user->isAdmin();

if(isset($_GET[User::USER_NAME])) {
	User::deleteRecord($_GET[User::USER_NAME]);
}

$users = User::getAllUsers();

$content = "views/lists/users.php";
include("views/templates/template.php");

?>