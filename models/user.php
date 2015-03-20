<?php

session_start();

include_once("misc/utils.php");

/*
	Ensures there is a user currently logged in
	If there is not then we redirect
	But we remember the page and set a redirect point
*/
function ensureUserLoggedIn() {
	if(!isset($_SESSION['USER'])) {

		setRedirect($_SERVER['REQUEST_URI']);
		header('Location: login.php');

	} 
}

function isUserLoggedIn() {
	return isset($_SESSION['USER']);
}

/*
	Extracts the username from the session
*/

function getUserName() {
	return $_SESSION['USER'];
}


/*
	Returns true if the login succeeds, false if it doesn't
*/

function login($user_name, $password) {
	//TODO: simple where clause
	$_SESSION['USER'] = "blaine";
	return true;
}

function logout() {
	unset($_SESSION['USER']);
}

function isAdmin() {
	//TODO: return a real value here
	return true;
}

function isRadiologist() {
	return true;
}

?>