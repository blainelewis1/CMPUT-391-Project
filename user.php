<?php

/*
	This page allows a single user to be editted (by an admin)

	It uses POST for all data submission but receives a GET username to determine who's details to change

	If no GET is passed then it is assumed it is a new user
*/

include_once('models/user.php');
include_once('models/person.php');
include_once('controllers/user.php');

//TODO: check error conditions, eg. invalid id
//TODO: change user name reject if not unique
//TODO: we need to give success messages everywhere.....

$user = User::getLoggedInUser();


//Ensur the user has the proper priveleges
$user->isAdmin();

$editting_user;

//Attempt to prefill the field if we are editting a user

if(isset($_GET[User::USER_NAME])){
	$editting_user = User::fromUserName($_GET[User::USER_NAME]);
	$editting_user->old_user_name = $_GET[User::USER_NAME];
} else {
	$editting_user = new User();
}


//Test if there is any data being submitted
if(isset($_POST[User::SUBMIT])) {
	$message = applyAndValidateUserFields($editting_user);

	if($message == ""){
		if($editting_user->saveToDatabase()) {
			//Redirect to manage users if the user was editted/created
			header('Location: manage_users.php');
			die();
		} else {
			$message .= "Username already exists!";
		}
	}
} else if(isset($_POST[User::CHANGE_PASSWORD])) {
	//In cases where the user exists changing the password is done via a separate field

	$message = validatePassword();
	if($message == "") {
		$user->updatePassword($_POST[User::PASSWORD]);
		$message = '<div class="success">Password succesfully changed!</div>';
	}
}


$content = "views/forms/user.php";
include("views/templates/template.php");

?>