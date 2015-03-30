<?php

include_once('misc/utils.php');

include_once('controllers/family_doctor.php');
include_once('models/family_doctor.php');
include_once('models/user.php');
include_once('models/person.php');


$user = User::getLoggedInUser();

$user->isAdmin();


$family_doctor;
$title;

if(isset($_GET[FamilyDoctor::DOCTOR_ID]) && isset($_GET[FamilyDoctor::PATIENT_ID])){
	
	$title = "Edit Family Doctor";

	$family_doctor = FamilyDoctor::fromIds($_GET[FamilyDoctor::PATIENT_ID], $_GET[FamilyDoctor::DOCTOR_ID]);

} else {
	
	$title = "Create Family Doctor";

	$family_doctor = new FamilyDoctor();
}


if(isset($_POST[FamilyDoctor::SUBMIT])) {

	$message = applyAndValidateFamilyDoctorFields($family_doctor);

	if($message == ""){
		if($family_doctor->saveToDatabase()) {

			if(isset($_GET[FamilyDoctor::DOCTOR_ID])){

				addNotice("Family doctor successfully edited!");
				
			} else {

				addNotice("Family doctor successfully created!");
			}

			header('Location: manage_family_doctors.php');
			die();
			
		} else {
			$message = '<div class="error">This relationship already exists</div>';
		}
		
	}
}

$content = 'views/forms/family_doctor.php';

include("views/templates/template.php");
