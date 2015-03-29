<?php

/*
	This page allows a radiologist to create a record although it could also be used to edit
	a record 

	All parameters are passed via POST except in the case of editting in which case a record id
	is passed via GET

	After the record is succesfully created the radiologist is sent to a page
	to upload images to the record.

	
*/

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

$user->isRadiologist();

$record;


if(isset($_GET[RadiologyRecord::RECORD_ID])){
	
	$title = "Edit record";
	$record = RadiologyRecord::fromId($_GET[RadiologyRecord::RECORD_ID]);

} else {
	
	$title = "Create record";
	$record = new RadiologyRecord();
}


if(isset($_POST[RadiologyRecord::SUBMIT])) {

	$message = applyAndValidateRecordFields($record);

	if($message == ""){

		if($record->saveToDatabase()) {

			header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$record->record_id);
			die();
		}

	}
}

$content = "views/forms/record.php";
include("views/templates/template.php");


?>