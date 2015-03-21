<?php

function applyAndValidateUserFields($user) {

	$message = "";

	if($user->isNew() && empty($_POST[User::PASSWORD])) {
		$message .= "Password cannot be empty <br />";
	}

	if($user->isNew() && empty($_POST[Person::PERSON_ID])) {
		$message .= "Person cannot be empty <br />";
	}

	//TODO: validate class is valid as well
	if(empty($_POST[User::CLASS_NAME])){
		$message .= "Class cannot be empty <br />";
	}

	//TODO: validate user is unique
	if(empty($_POST[User::USER_NAME])){
		$message .= "User cannot be empty <br />";
	}


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
