<?php

include_once("models/user.php");
include_once("misc/utils.php");

//Check if we are currently submitting, if we are try logging in
//If it succeeds redirect to wherever you started
//Otherwise we want to set the login view to the failed state and 

if(User::isUserLoggedIn()){
	redirect("index.php");
}


if(isset($_POST['submit'])){

	if(User::login($_POST['username'], $_POST['password'])){

		redirect("index.php");

	} else {
		//TODO: this should be out of scope... why isn't it

		//Auto fill the username
		$username = $_POST['username'];
		$failed = true;

	}
} 

include("views/login.php");

?>