<?php

include_once("misc/validation_utils.php");

/*
	Takes a user and validates all incoming fields to it and 
	applies them	

	If fields are invalid it returns a styled message explaining the error
*/

function applyAndValidateUserFields($user) {

	$message = "";

	if($user->isNew()) {
		$message .= notEmpty($_POST, User::PASSWORD, 'Password');
		$message .= notEmpty($_POST, Person::PERSON_ID, 'Person');

		$message .= maxLength($_POST[User::PASSWORD], 24, 'Password');
	}

	$message .= notEmpty($_POST, User::CLASS_NAME, 'Class');
	$message .= oneOf($_POST[User::CLASS_NAME], array('d','a','r','p'), 'Class');

	$message .= notEmpty($_POST, User::USER_NAME, 'User name');

	$user->class = $_POST[User::CLASS_NAME];
	$user->user_name = $_POST[User::USER_NAME];

	if($user->isNew()) {
		$user->password = $_POST[User::PASSWORD];
		$user->person_id = $_POST[Person::PERSON_ID];
	}

	return $message;
}

/*
	Used when changing password to validate that the password is valid
*/

function validatePassword() {

	if(empty($_POST[User::PASSWORD])) {
		return '<div class="error">Password cannot be empty</div>';
	}

	return "";
}

?>
