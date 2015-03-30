<?php

/*
	Allows a radiologist to upload a single image. 
	The record that is being uploaded to is stored as a GET parameter

	Upon success the action depends on which button was clicked, either the user is
	redirected to create another record, or they can upload another image
*/

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('models/pacs_image.php');
include_once('controllers/pacs_image.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

//Ensure the user is a radiologist
$user->isRadiologist();

$record;

if(!isset($_GET[RadiologyRecord::RECORD_ID])){
	//TODO: 404?
	print('Not editting a record');
	die();
} else {
	//TODO: what if the record does not exist
	$pacs_image = new PACSImage();
	$pacs_image->record_id = $_GET[RadiologyRecord::RECORD_ID];
}

if(isset($_POST[PACSImage::SUBMIT]) || isset($_POST[PACSImage::SUBMIT_ANOTHER])) {
	//TODO: validation
	$message = "";

	$pacs_image->image = $_FILES[PACSImage::IMAGE]["tmp_name"];

	$message = validatePacsImage($pacs_image->image);

	if($message == ""){


		$pacs_image->insert();
		//TODO: what if the insert fails

		if(!empty($_POST[PACSImage::SUBMIT_ANOTHER])){

			addNotice("Image uploaded!");

			//TODO: redirect somewhere?
			header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$pacs_image->record_id);
			die();
		} else {

			addNotice("Record completed!");

			//TODO: this won't work in the future
			header('Location: record.php');
			die();
		}
	}
}

$title = "Upload Image";
$content = "views/forms/upload.php";

include("views/templates/template.php");


?>