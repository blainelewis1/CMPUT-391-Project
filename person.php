<?php

include_once('misc/utils.php');
include_once('models/user.php');
include_once('models/person.php');
include_once('controllers/person.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

$user->isAdmin();

$person;
$title;

if(isset($_GET[Person::PERSON_ID])){
	$title = "Edit Person";

	$person = Person::fromId($_GET[Person::PERSON_ID]);
} else {
	$title = "Create Person";
	$person = new Person();
}

if(isset($_POST[Person::SUBMIT])) {
	$message = applyAndValidatePersonFields($person);

	if($message == ""){
		if($person->saveToDatabase()) {

			addNotice("Person successfully created!");

			header('Location: manage_people.php');
			die();
		} else {
			$message .= "Person ID already exists!";
		}
		
	}
}


$content = "views/forms/person.php";
include("views/templates/template.php");

?>