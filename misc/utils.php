<?php

/*
	Uses a session to redirect wherever the
	redirect point was set
*/

function redirect($default = "index.php"){
	$new_location = isset($_SESSION['REDIRECT_TO']) ? $_SESSION['REDIRECT_TO'] : $default;

	header('Location: '.$new_location);
}

/*
	Sets a redirect point for later use
*/

function setRedirect($location){
	$_SESSION['REDIRECT_TO'] = $location;
}

?>