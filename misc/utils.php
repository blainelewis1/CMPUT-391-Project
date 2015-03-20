<?php

/*
	Uses a session to redirect wherever the
	redirect point was set
*/

function redirect(){
	header('Location: '.$_SESSION['REDIRECT_TO']);
}

/*
	Sets a redirect point for later use
*/

function setRedirect($location){
	$_SESSION['REDIRECT_TO'] = $location;
}

?>