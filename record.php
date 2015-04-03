<?php

/*
	This page allows a radiologist to create a record although it could also be used to edit
	a record 

	All parameters are passed via POST except in the case of editting in which case a record id
	is passed via GET

	After the record is succesfully created the radiologist is sent to a page
	to upload images to the record.

	
*/

include_once('misc/utils.php');
include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

$user = User::getLoggedInUser();

$user->isRadiologist();

$record;
$message = "";
$title;

if(isset($_GET[RadiologyRecord::RECORD_ID])){
	
	$title = "Edit record";
	$record = RadiologyRecord::fromId($_GET[RadiologyRecord::RECORD_ID]);

} else {
	
	$title = "Create record";
	$record = new RadiologyRecord();
}


if(isset($_POST[RadiologyRecord::SUBMIT])) {

	$message = applyAndValidateRecordFields($record);

	$record->radiologist_id = $user->person_id;

	if($message == ""){

		if($record->saveToDatabase()) {

			addNotice("Record created successfully!");

			header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$record->record_id);
			die();
		}

	}
}

$message .= getNotices();

$content = "views/forms/record.php";
include("views/templates/template.php");


?>