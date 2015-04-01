<?php

include_once("misc/validation_utils.php");

/*
	Takes an instance of PACSImage and validates all incoming fields for it.
	Then applies the fields to it

	If fields are invalid it returns a styled message explaining the error
*/

function applyAndValidatePacsImage($image) {

	$tokens = explode(".", $_FILES[PACSImage::IMAGE]["name"]);

	$ext = $tokens[sizeof($tokens) - 1];

	if(!($ext == "jpg" || $ext == "jpeg")) {
		return '<div class="error">File extension not supported. Only jpg is supported.</div>';
	}

	$pacs_image->image = $_FILES[PACSImage::IMAGE]["temp_name"];

	return "";	
}

?>