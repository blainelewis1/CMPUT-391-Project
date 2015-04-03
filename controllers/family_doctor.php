<?php

include_once("misc/validation_utils.php");
include('models/family_doctor.php');



/*
	Takes an instance of family doctor, validates the fields for a
	family doctor and applies them to the given doctor

	If fields are invalid it returns a styled message explaining the error
*/

function applyAndValidateFamilyDoctorFields($family_doctor) {
	$message = "";

	$message .= notEmpty($_POST, FamilyDoctor::DOCTOR_ID, 'Doctor');
	$message .= notEmpty($_POST, FamilyDoctor::PATIENT_ID, 'First name');

		
	$family_doctor->patient_id = $_POST[FamilyDoctor::PATIENT_ID];
	$family_doctor->doctor_id = $_POST[FamilyDoctor::DOCTOR_ID];

	return $message;
}

?>