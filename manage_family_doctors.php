<?php

/*
	Lists all family_doctors and allows for creation and deletion
*/


include_once('misc/utils.php');
include_once('models/user.php');
include_once('models/family_doctor.php');

$user = User::getLoggedInUser();

$user->isAdmin();


if(isset($_GET[FamilyDoctor::DOCTOR_ID]) && isset($_GET[FamilyDoctor::PATIENT_ID])){
	$family_doctor = FamilyDoctor::fromIds($_GET[FamilyDoctor::PATIENT_ID], $_GET[FamilyDoctor::DOCTOR_ID]);
	$family_doctor->deleteRecord();

	addNotice("Successfully deleted!");

	//We redirect so that we don't accidentally refresh and delete again
	header("Location: manage_family_doctors.php");
	die();
}

$family_doctors = FamilyDoctor::getAllFamilyDoctors();


$message = getNotices();
$title = "Manage Family Doctors";

$content = "views/lists/family_doctors.php";
include("views/templates/template.php");

?>