<?php

include('validation_utils.php');

function applyAndValidateRecordFields($record) {
	//TODO: make me!
	return "";
}

function validateDiagnosisFormFields(){

	$message = "";

	$message .= notEmpty($_POST, RadiologyRecord::DIAGNOSIS, 'diagnosis');
	$message .= notEmpty($_POST, RadiologyRecord::TEST_START_DATE, 'start date');
	$message .= notEmpty($_POST, RadiologyRecord::TEST_END_DATE, 'end date');

	return $message;
}

?>