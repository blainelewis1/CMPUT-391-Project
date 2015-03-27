<?php

include_once('models/user.php');
include_once('models/family_doctor.php');

$user = User::getLoggedInUser();

if(!$user->isAdmin()){
	include("views/denied.php");
	die();
}



if(isset($_GET[FamilyDoctor::DOCTOR_ID]) && isset($_GET[FamilyDoctor::PATIENT_ID])){
	$family_doctor = FamilyDoctor::fromIds($_GET[FamilyDoctor::PATIENT_ID], $_GET[FamilyDoctor::DOCTOR_ID]);
	$family_doctor->deleteRecord();


	//We redirect so that we don't accidentally refresh and delete again
	header("Location: manage_family_doctors.php");
	die();
}

$family_doctors = FamilyDoctor::getAllFamilyDoctors();

include("views/list_family_doctors.php");

?>