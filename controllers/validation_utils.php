<?php

//If we pass by reference to not empty it might just make it empty.....

function notEmpty($source, $index, $name) {
	if(!isset($source[$index]) || $source[$index] == "") {
		$source[$index] = "";
		return '<div class="error">'.$name.' cannot be empty.</div>';
	}

	return "";
}

function maxLength($val, $length, $name) {
	if(sizeof($val) > 0 && sizeof($val) > $length) {
		return '<div class="error">'.$name.' must be less than '.$length.' characters long.</div>';
	}
}

function isValidDate($val, $name) {
	return '<div class="error">'.$name.' must be a valid date.</div>';
}

function isNumber($val, $name) {
	if($val != "" && !is_numeric($val)) {
		return '<div class="error">'.$name.' must be a number.</div>';
	}
}

function oneOf($val, $values, $name) {
	if(in_array($val, $values)) {
		return '<div class="error">Not a valid '.$name.'.</div>';
	}
}

?>