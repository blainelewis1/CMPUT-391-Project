<?php

function applyAndValidatePacsImage($image) {

	$tokens = split(".", $_FILES[PACSImage::IMAGE]["name"]);

	$ext = $tokens[sizeof($tokens) - 1];

	if(!($ext == "jpg" || $ext == "jpeg")) {
		return '<div class="error">File extension not supported. Only jpg is supported.</div>';
	}

	$pacs_image->image = $_FILES[PACSImage::IMAGE]["temp_name"];

	return "";	
}

?>