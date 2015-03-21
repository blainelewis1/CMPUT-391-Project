<?php

include_once('models/user.php');
include_once('models/person.php');
include_once('controllers/user.php');

//TODO: check error conditions, eg. invalid id
//TODO: change user name reject if not unique


$user = User::getLoggedInUser();

if(!$user->isAdmin()){
	include("views/denied.php");
	die();
}

$editting_user;


if(isset($_GET[User::USER_NAME])){
	$editting_user = User::fromUserName($_GET[User::USER_NAME]);
} else {
	//TODO: dropdown in new user table
	$editting_user = new User();
}

if(isset($_POST[User::SUBMIT])) {
	$message = applyAndValidateUserFields($editting_user);

	if($message == ""){
		if($editting_user->saveToDatabase()) {
			header('Location: manage_users.php');
			die();
		} else {
			$message .= "Username already exists!";
		}
		

	}
}

include("views/user.php");

?>