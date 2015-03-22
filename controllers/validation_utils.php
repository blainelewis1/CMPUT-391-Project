<?php

function notEmpty($source, $index, $name) {
	if(empty($source[$index])) {
		return '<span class="error">'.$name.' cannot be empty.</span>';
	}

	return "";
}

function maxLength($val, $length, $name) {
	if(sizeof($val) < $length) {
		return '<span class="error">'.$name.' must be less than'.$length.'.</span>';
	}
}

function isValidDate($val, $name) {
	return '<span class="error">'.$name.' must be a valid date.</span>';
}


?>