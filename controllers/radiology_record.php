<?php

include_once("misc/validation_utils.php");

/*
	Takes a radiology record and validates all incoming fields to it and 
	applies them	

	If fields are invalid it returns a styled message explaining the error
*/

function applyAndValidateRecordFields($record) {
	
	$message = '';

	$message .= notEmpty($_POST, RadiologyRecord::PATIENT_ID, 'Patient');
	$message .= notEmpty($_POST, RadiologyRecord::DOCTOR_ID, 'Doctor');
	//$message .= notEmpty($_POST, RadiologyRecord::RADIOLOGIST_ID, 'Radiologist');
	$message .= notEmpty($_POST, RadiologyRecord::TEST_TYPE, 'Test Type');
	$message .= notEmpty($_POST, RadiologyRecord::PRESCRIBING_DATE, 'Prescribing Date');
	$message .= notEmpty($_POST, RadiologyRecord::TEST_DATE, 'Test Date');
	$message .= notEmpty($_POST, RadiologyRecord::DIAGNOSIS, 'Diagnosis');
	$message .= notEmpty($_POST, RadiologyRecord::DESCRIPTION, 'Description');

	$message .= validDate($_POST[RadiologyRecord::PRESCRIBING_DATE], 'Prescribing date');
	$message .= validDate($_POST[RadiologyRecord::TEST_DATE], 'Test date');

	$message .= maxLength($_POST[RadiologyRecord::TEST_TYPE], 24, 'Test type');
	$message .= maxLength($_POST[RadiologyRecord::DIAGNOSIS], 128, 'Diagnosis');
	$message .= maxLength($_POST[RadiologyRecord::DESCRIPTION], 1024, 'Description');

	$record->patient_id = $_POST[RadiologyRecord::PATIENT_ID];
	$record->doctor_id = $_POST[RadiologyRecord::DOCTOR_ID];
	//$record->radiologist_id = $_POST[RadiologyRecord::RADIOLOGIST_ID];
	$record->test_type = $_POST[RadiologyRecord::TEST_TYPE];
	$record->prescribing_date = $_POST[RadiologyRecord::PRESCRIBING_DATE];
	$record->test_date = $_POST[RadiologyRecord::TEST_DATE];
	$record->diagnosis = $_POST[RadiologyRecord::DIAGNOSIS];
	$record->description = $_POST[RadiologyRecord::DESCRIPTION];

	return $message;
}

?>
