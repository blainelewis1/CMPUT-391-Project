<?php

include_once('models/user.php');
include_once('models/personal_information.php');

$user = User::getLoggedInUser();
$personalInformation = new PersonalInformation($user->getUserName());

//TODO: More data validation?

if(isset($_POST['submit'])) {
	$failed = false;
	print("submitted");

	if(empty($_POST['first_name'])){
		$failed = true;
		$message .= "First name cannot be empty <br />";
	}

	if(empty($_POST['last_name'])){
		$failed = true;
		$message .= "Last name cannot be empty <br />";
	}

	if(empty($_POST['address'])){
		$failed = true;
		$message .= "Address cannot be empty <br />";
	}

	if(empty($_POST['phone'])){
		$failed = true;
		$message .= "Phone cannot be empty <br />";
	}

	if(empty($_POST['email'])){
		$failed = true;
		$message .= "Email cannot be empty <br />";
	}

	if(!$failed){
		$personalInformation->first_name = $_POST['first_name'];
		$personalInformation->last_name = $_POST['last_name'];
		$personalInformation->address = $_POST['address'];
		$personalInformation->phone = $_POST['phone'];
		$personalInformation->email = $_POST['email'];
		
		$personalInformation->update();
	}
} else if(isset($_POST['change_password'])) {
	if(empty($_POST['password'])) {
		$failed = true;
		$message .= "Email cannot be empty <br />";
	}

	$user->updatePassword($_POST['password']);
}


include("views/user_settings.php");



?>