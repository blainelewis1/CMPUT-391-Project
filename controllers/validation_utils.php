<?php

//If we pass by reference to not empty it might just make it empty.....

function notEmpty($source, $index, $name) {
	if(!isset($source[$index]) || $source[$index] == "") {
		print($source[$index]. "yo yo yo");
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