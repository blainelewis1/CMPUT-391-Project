<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('models/pacs_image.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

if(!$user->isRadiologist()){
	include("views/denied.php");
	die();
}

$record;

if(!isset($_GET[RadiologyRecord::RECORD_ID])){
	print('An unknown error occurred sorry bro.');
	die();
} else {
	$pacs_image = new PACSImage();
}

if(isset($_POST[PACSImage::SUBMIT]) || isset($_POST[PACSImage::SUBMIT_ANOTHER])) {

	if($message == ""){
		if($pacs_image->saveToDatabase()) {
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

include("views/upload.php");


?>