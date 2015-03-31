<?php

/*
	Allows a radiologist to upload a single image. 
	The record that is being uploaded to is stored as a GET parameter

	Upon success the action depends on which button was clicked, either the user is
	redirected to create another record, or they can upload another image
*/
include_once('misc/utils.php');
include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('models/pacs_image.php');
include_once('controllers/pacs_image.php');

$user = User::getLoggedInUser();

//Ensure the user is a radiologist
$user->isRadiologist();

$record;

$message = "";


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

	$message = applyAndValidatePacsImage($pacs_image);

	if($message == ""){


		$pacs_image->insert();

		if(!empty($_POST[PACSImage::SUBMIT_ANOTHER])){

			addNotice("Image uploaded!");

			header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$pacs_image->record_id);
			die();
		} else {

			addNotice("Record completed!");

			header('Location: record.php');
			die();
		}
	}
}

$message .= getNotices();

$title = "Upload Image";
$content = "views/forms/upload.php";

include("views/templates/template.php");


?>