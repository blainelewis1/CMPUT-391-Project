<?php

function validatePacsImage($filename) {
	$tokens = split(".", $filename);

	if(!($tokens[sizeof($tokens)] == "jpg" || $tokens[sizeof($tokens)] == "jpeg")) {
		return '<div class="error">File extension not supported. Only jpg is supported.</div>';
	}

	return "";	
}

?>