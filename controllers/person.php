<?php

/*
	
	This poorly named function takes a person and applies
	the fields to it.

*/

//TODO: More data validation?

function applyAndValidatePersonFields($person) {
	$message = "";
	if(empty($_POST[Person::FIRST_NAME])){
		$message .= "First name cannot be empty <br />";
	}

	if(empty($_POST[Person::LAST_NAME])){
		$message .= "Last name cannot be empty <br />";
	}

	if(empty($_POST[Person::ADDRESS])){
		$message .= "Address cannot be empty <br />";
	}

	if(empty($_POST[Person::PHONE])){
		$message .= "Phone cannot be empty <br />";
	}

	if(empty($_POST[Person::EMAIL])){
		$message .= "Email cannot be empty <br />";
	}

	if($person->isNew()){
		//TODO: validate it is a number
		if(empty($_POST[Person::PERSON_ID])){
			$message .= "Person ID cannot be empty <br />";
		}
	}

	if(!$message){
		$person->first_name = $_POST[Person::FIRST_NAME];
		$person->last_name = $_POST[Person::LAST_NAME];
		$person->address = $_POST[PERSON::ADDRESS];
		$person->phone = $_POST[Person::PHONE];
		$person->email = $_POST[Person::EMAIL];

		if($person->isNew()){
			$person->person_id = $_POST[Person::PERSON_ID];
		}
	}

	return $message;
}

?>