<?php

/*
	Ensures there is a user currently logged in
*/
function userLoggedIn() {
	if(!isset($_SESSION['USER']){
		$_SESSION['REDIRECT_TO'] = $_SERVER['REQUEST_URI'];
		header('Location: login.php');
	} 
}

function getUserName() {
	return $_SESSION['USER'];
}


?>