<?php

/*
	A series of functions for validating a forms input
	Returning styled messages upon failure or empty strings otherwise

	In all cases, name is a readable name for output into the styled message

*/


/*
	Source is an array, index is an index in that array

	eg notEmpty($_POST, "name", "Readable Name")
*/

function notEmpty($source, $index, $name) {
	if(!isset($source[$index]) || trim($source[$index]) == "") {
		$source[$index] = "";
		return '<div class="error">'.$name.' cannot be empty.</div>';
	}

	return "";
}

/*
	Checks val's length is less than length
*/

function maxLength($val, $length, $name) {
	if(sizeof($val) > 0 && sizeof($val) > $length) {
		return '<div class="error">'.$name.' must be less than '.$length.' characters long.</div>';
	}
}

/*
	Checks that val is a valid date of the form YYYY-MM-DD
*/

function validDate($val, $name) {

	if($val != "" && DateTime::createFromFormat('Y-m-d', $val) == false) {
		return '<div class="error">'.$name.' must be a valid date.</div>';
	}
	return "";
	
}

//Checks val is a number

function isNumber($val, $name) {
	if($val != "" && !is_numeric($val)) {
		return '<div class="error">'.$name.' must be a number.</div>';
	}
}

/*
	Checks that val is in values
*/

function oneOf($val, $values, $name) {
	if(!in_array($val, $values)) {
		return '<div class="error">Not a valid '.$name.'.</div>';
	}
}

?>