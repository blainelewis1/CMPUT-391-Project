<?php

function validatePacsImage($filename) {
	$tokens = split(".", $filename);

	print_r($tokens);

	if(!($tokens[sizeof($tokens) - 1] == "jpg" || $tokens[sizeof($tokens) - ] == "jpeg")) {
		return '<div class="error">File extension not supported. Only jpg is supported.</div>';
	}

	return "";	
}

?>