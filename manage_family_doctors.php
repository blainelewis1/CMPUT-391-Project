<?php

include_once('models/user.php');
include_once('models/family_doctor.php');

$user = User::getLoggedInUser();

if(!$user->isAdmin()){
	include("views/denied.php");
	die();
}

if(isset($_GET[FamilyDoctor::DELETE])) {

}

$family_doctors = FamilyDoctor::getAllFamilyDoctors();

include("views/list_family_doctors.php");

?>