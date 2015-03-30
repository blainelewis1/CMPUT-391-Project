<?php

function validatePacsImage($filename) {
	$tokens = split(".", $filename);

	print_r($tokens);

	$ext = $tokens[sizeof($tokens) - 1];

	if(!($ext == "jpg" || $ext == "jpeg")) {
		return '<div class="error">File extension not supported. Only jpg is supported.</div>';
	}

	return "";	
}

?>