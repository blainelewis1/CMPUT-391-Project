<?php

include_once('controllers/family_doctor.php');

include_once('models/family_doctor.php');
include_once('models/user.php');
include_once('models/person.php');


$user = User::getLoggedInUser();

$user->isAdmin();


$family_doctor;

if(isset($_GET[FamilyDoctor::DOCTOR_ID]) && isset($_GET[FamilyDoctor::PATIENT_ID])){
	$family_doctor = FamilyDoctor::fromIds($_GET[FamilyDoctor::PATIENT_ID], $_GET[FamilyDoctor::DOCTOR_ID]);
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
		} else {
			$message = "This relationship already exists";
		}
		
	}
}

$content = 'views/family_doctor.php';

include("views/template.php");
