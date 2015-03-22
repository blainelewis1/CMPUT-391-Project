<?php

include_once('models/user.php');
include_once('models/person.php');
include_once('controllers/person.php');
include_once('controllers/user.php');


$user = User::getLoggedInUser();
$person = Person::fromUsername($user->getUserName());


if(isset($_POST[Person::SUBMIT])) {
	$message = applyAndValidatePersonFields($person);

	if($message == ""){
		$person->update();
	}

} else if(isset($_POST[User::CHANGE_PASSWORD])) {
	$message = validatePassword();
	if($message == "") {
		$user->updatePassword($_POST[User::PASSWORD]);
	}
}


include("views/user_settings.php");



?>