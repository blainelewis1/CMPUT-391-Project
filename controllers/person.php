<?php

include_once('validation_utils.php');

/*
	
	This poorly named function takes a person and applies
	the fields to it.

*/

//TODO: More data validation?

function applyAndValidatePersonFields($person) {
	$message = "";

	$message .= notEmpty($_POST, Person::FIRST_NAME, 'First name');
	$message .= notEmpty($_POST, Person::LAST_NAME, 'Last name');
	$message .= notEmpty($_POST, Person::ADDRESS, 'Address');
	$message .= notEmpty($_POST, Person::PHONE, 'Phone');
	$message .= notEmpty($_POST, Person::EMAIL, 'Email');

	$message .= maxLength($_POST[Person::FIRST_NAME], 24, 'First name');
	$message .= maxLength($_POST[Person::LAST_NAME], 24, 'Last name');
	$message .= maxLength($_POST[Person::ADDRESS], 128, 'Address');
	$message .= maxLength($_POST[Person::EMAIL], 128, 'Email');
	$message .= maxLength($_POST[Person::PHONE], 10, 'Phone');

	if($person->isNew()){
		//TODO: validate it is a number
		$message .= notEmpty($_POST, Person::PERSON_ID, 'Person ID');
		$message .= isNumber($_POST[Person::PERSON_ID], 'Person ID');
	}


	//TODO: we should apply these no matter what 
	$person->first_name = $_POST[Person::FIRST_NAME];
	$person->last_name = $_POST[Person::LAST_NAME];
	$person->address = $_POST[PERSON::ADDRESS];
	$person->phone = $_POST[Person::PHONE];
	$person->email = $_POST[Person::EMAIL];

	if($person->isNew()){
		$person->person_id = $_POST[Person::PERSON_ID];
	}

	return $message;
}

?>