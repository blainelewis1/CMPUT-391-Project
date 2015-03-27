<?php

include("validation_utils.php");

function applyAndValidateUserFields($user) {

	$message = "";

	if($user->isNew()) {
		$message .= notEmpty($_POST, User::PASSWORD, 'Password');
		$message .= notEmpty($_POST, Person::PERSON_ID, 'Person');
	}

	//TODO: validate class is valid as well
	$message .= notEmpty($_POST, User::CLASS_NAME, 'Class');

	//TODO: validate user is unique
	$message .= notEmpty($_POST, User::USER_NAME, 'User name');

	//TODO: apply these....
	if($message == ""){
		$user->class = $_POST[User::CLASS_NAME];
		$user->user_name = $_POST[User::USER_NAME];

		if($user->isNew()) {
			$user->password = $_POST[User::PASSWORD];
			$user->person_id = $_POST[Person::PERSON_ID];
		}
	}

	return $message;
}

function validatePassword() {

	if(empty($_POST[User::PASSWORD])) {
		return "Password cannot be empty <br />";
	}

	return "";
}

?>
