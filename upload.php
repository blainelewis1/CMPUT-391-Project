<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('models/pacs_image.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

$user->isRadiologist();

$record;

if(!isset($_GET[RadiologyRecord::RECORD_ID])){
	print('An unknown error occurred sorry bro.');
	die();
} else {
	$pacs_image = new PACSImage();
	$pacs_image->record_id = $_GET[RadiologyRecord::RECORD_ID];
}

if(isset($_POST[PACSImage::SUBMIT]) || isset($_POST[PACSImage::SUBMIT_ANOTHER])) {
	//TODO: validation
	$message = "";

	if($message == ""){
		$pacs_image->image = $_FILES[PACSImage::IMAGE]["tmp_name"];

		if($pacs_image->insert()) {

			if(isset($_POST[PACSImage::SUBMIT_ANOTHER])){
				//TODO: redirect somewhere?
				header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$record->record_id);
				die();
			} else {

				//TODO: this won't work in the future
				header('Location: edit_record.php');
				die();
			}

		}
		
	}
}

$content = "views/forms/upload.php";

include("views/templates/template.php");


?>