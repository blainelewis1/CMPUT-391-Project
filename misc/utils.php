<?php

/*
	Uses a session to redirect wherever the
	redirect point was set
*/

function redirect($default = "index.php"){
	$new_location = isset($_SESSION['REDIRECT_TO']) ? $_SESSION['REDIRECT_TO'] : $default;

	header('Location: '.$new_location);
	die();
}

/*
	Sets a redirect point for later use
*/

function setRedirect($location){
	$_SESSION['REDIRECT_TO'] = $location;
}



function addNotice($notice){
	if(!isset($_SESSION['NOTICES'])){
		$_SESSION['NOTICES'] = "";
	}

	$_SESSION['NOTICES'] .= '<div class="notice">'.$notice.'</div>';
}

function getNotices() {
	if(!isset($_SESSION['NOTICES'])) {
		return '';
	}

	$notices = 	$_SESSION['NOTICES'];
	unset($_SESSION['NOTICES']);

	return $notices;
}

?>