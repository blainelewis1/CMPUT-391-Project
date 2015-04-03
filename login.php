<?php

include_once("models/user.php");
include_once("misc/utils.php");

//Check if we are currently submitting, if we are try logging in
//If it succeeds redirect to wherever you started
//Otherwise we want to set the login view to the failed state and 

if(User::isUserLoggedIn()){
	redirect("index.php");
}


if(isset($_POST[User::LOGIN])){

	if(User::login($_POST[User::USER_NAME], $_POST[User::PASSWORD])){

		redirect("index.php");

	} else {

		//Auto fill the username
		$username = $_POST[User::USER_NAME];
		$failed = true;

	}
} 

$title = "Login";
$content = "views/forms/login.php";
include("views/templates/template.php");

?>