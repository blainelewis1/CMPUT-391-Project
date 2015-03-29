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
		$person->update();
		$message = '<div class="success">Details succesfully changed!</div>';
	}

} else if(isset($_POST[User::CHANGE_PASSWORD])) {

	$message = validatePassword();
	if($message == "") {
		$user->updatePassword($_POST[User::PASSWORD]);
		$message = '<div class="success">Password succesfully changed!</div>';
	} 
}

//Display the results

$content = "views/user_settings.php";
include("views/templates/template.php");


?>