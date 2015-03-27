<?php

include_once('models/user.php');
include_once('models/person.php');
include_once('controllers/person.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

$user->isAdmin();

$person;


if(isset($_GET[Person::PERSON_ID])){
	$person = Person::fromId($_GET[Person::PERSON_ID]);
} else {
	$person = new Person();
}

if(isset($_POST[Person::SUBMIT])) {
	$message = applyAndValidatePersonFields($person);

	if($message == ""){
		if($person->saveToDatabase()) {
			header('Location: manage_people.php');
			die();
		} else {
			$message .= "Person ID already exists!";
		}
		
	}
}
$content = "views/person.php";
include("views/template.php");

?>