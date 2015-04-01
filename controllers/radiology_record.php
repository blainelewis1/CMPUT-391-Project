<?php

include_once("misc/validation_utils.php");

function applyAndValidateRecordFields($record) {
	
	$message = '';

	//TODO: test that patient, doctor etc. are valid

	$message .= notEmpty($_POST, RadiologyRecord::PATIENT_ID, 'Patient');
	$message .= notEmpty($_POST, RadiologyRecord::DOCTOR_ID, 'Doctor');
	$message .= notEmpty($_POST, RadiologyRecord::RADIOLOGIST_ID, 'Radiologist');
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
	$record->radiologist_id = $_POST[RadiologyRecord::RADIOLOGIST_ID];
	$record->test_type = $_POST[RadiologyRecord::TEST_TYPE];
	$record->prescribing_date = $_POST[RadiologyRecord::PRESCRIBING_DATE];
	$record->test_date = $_POST[RadiologyRecord::TEST_DATE];
	$record->diagnosis = $_POST[RadiologyRecord::DIAGNOSIS];
	$record->description = $_POST[RadiologyRecord::DESCRIPTION];

	return $message;
}

function validateDiagnosisFormFields(){

	/*TODO: 
		Empty diagnosis should display all records between the two dates.
		Empty start date should display all records up until end_date
		Empty end date should display all records after start date*/


	$message = "";

	$message .= notEmpty($_POST, RadiologyRecord::DIAGNOSIS, 'diagnosis');
	$message .= notEmpty($_POST, RadiologyRecord::TEST_START_DATE, 'start date');
	$message .= notEmpty($_POST, RadiologyRecord::TEST_END_DATE, 'end date');

	return $message;
}

function validateSearchFormFields(){

	/*if dates are empty, should still show search results. Therefore
	only check search term*/


	$message = "";

	$message .= notEmpty($_POST, RadiologyRecord::SEARCH_TERM, 'search term');
	
	return $message;
}

?>
