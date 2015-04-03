<?php

/*
	From this page a user can edit their personal details or change their password.

	All information is passed via post and can be found in the person controller.

*/


include_once('models/user.php');
include_once('models/person.php');
include_once('controllers/person.php');
include_once('controllers/user.php');



$user = User::getLoggedInUser();

$person = Person::fromUsername($user->getUserName());

//Test if the form(s) have been submitted.

if(isset($_POST[Person::SUBMIT])) {
	$message = applyAndValidatePersonFields($person);

	if($message == ""){
		$person->saveToDatabase();
		$message = '<div class="notice">Details successfully changed!</div>';
	}

} else if(isset($_POST[User::CHANGE_PASSWORD])) {

	$message = validatePassword();
	if($message == "") {
		$user->updatePassword($_POST[User::PASSWORD]);
		$message = '<div class="notice">Password successfully changed!</div>';
	} 
}

//Display the results

$title = "User Settings";
$content = "views/forms/user_settings.php";
include("views/templates/template.php");


?>