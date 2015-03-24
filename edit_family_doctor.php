<?php

include_once('controllers/family_doctor.php');

include_once('models/family_doctor.php');
include_once('models/user.php');
include_once('models/person.php');


$family_doctor;

if(isset($_GET[FamilyDoctor::DOCTOR_ID]) && isset($_GET[FamilyDoctor::PATIENT_ID])){
	$family_doctor = FamilyDoctor::fromIds($_GET[FamilyDoctor::DOCTOR_ID],$_GET[FamilyDoctor::PATIENT_ID]);
} else {
	$family_doctor = new FamilyDoctor();
}


if(isset($_POST[FamilyDoctor::SUBMIT])) {

	$message = applyAndValidateFamilyDoctorFields($family_doctor);

	if($message == ""){
		if($family_doctor->saveToDatabase()) {
			//TODO: show a success message?
			header('Location: manage_family_doctors.php');
			die();
		}
		
	}
}

include("views/family_doctor.php");
