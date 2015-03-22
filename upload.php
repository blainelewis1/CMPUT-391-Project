<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('model/pacs_image.php');
include_once('controllers/pacs_image.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

if(!$user->isRadiologist()){
	include("views/denied.php");
	die();
}

$record;


if(isset($_GET[PACSImage::RECORD_ID])){
	throw404();
} else {
	$pacs_image = new PACSImage();
}

if(isset($_POST[PACSImage::SUBMIT]) || isset($_POST[PACSImage::SUBMIT_ANOTHER])) {

	$message = applyAndValidateRecordFields($record);

	if($message == ""){
		if($record->saveToDatabase()) {
			if(isset($_POST[PACSImage::SUBMIT_ANOTHER])){
				//TODO: redirect somewhere?
				header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$record->record_id);
				die();
			} else {
				//TODO: this won't work in the future
				header('Location: localhost');
				die();
			}

		}
		
	}
}

include("views/record.php");


?>