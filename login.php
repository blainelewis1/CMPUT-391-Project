<?php
include("models/user.php");
include("misc/utils.php");

//Check if we are currently submitting, if we are try logging in
//If it succeeds redirect to wherever you started
//Otherwise we want to set the login view to the failed state and 

if(isUserLoggedIn()){
	redirect();
}

if(isset($_POST['submitted'])){

	if(login($_POST['username'], $_POST['password'])){

		redirect();

	} else {
		
		//Auto fill the username
		$$username = $_POST['user_name'];
		$failed = true;

	}
} 

include("views/login.php");

?>