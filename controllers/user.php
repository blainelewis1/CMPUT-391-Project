<?php

function validatePassword() {

	if(empty($_POST[User::PASSWORD])) {
		return "Password cannot be empty <br />";
	}

	return "";
}

?>
