<?php

/*
	Lists all users to an admin. If a user is set in the GET parameter it is deleted. We redirect upon completion in 
	order to avoid duplicate deletion

*/

include_once('misc/utils.php');
include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

$user->isAdmin();

if(isset($_GET[User::USER_NAME])) {
	User::deleteRecord($_GET[User::USER_NAME]);
	addNotice("User successfully deleted!");
		
	//We redirect so that we don't accidentally refresh and delete again
	header("Location: manage_users.php");
	die();
}

$message = getNotices();
$title = "Manage Users";

$users = User::getAllUsers();

$content = "views/lists/users.php";
include("views/templates/template.php");

?>