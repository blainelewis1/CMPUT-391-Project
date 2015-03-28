<?php

include('validation_utils.php');
include('models/family_doctor.php');

//TODO: validate that the doctor patient are actually in the given list
function applyAndValidateFamilyDoctorFields($family_doctor) {
	$message = "";

	$message .= notEmpty($_POST, FamilyDoctor::DOCTOR_ID, 'Doctor');
	$message .= notEmpty($_POST, FamilyDoctor::PATIENT_ID, 'First name');

		
	$family_doctor->patient_id = $_POST[FamilyDoctor::PATIENT_ID];
	$family_doctor->doctor_id = $_POST[FamilyDoctor::DOCTOR_ID];

	return $message;
}

?>