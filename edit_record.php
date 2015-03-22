<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

if(!$user->isRadiologist()){
	include("views/denied.php");
	die();
}

$record;


if(isset($_GET[RadiologyRecord::RECORD_ID])){
	$record = RadiologyRecord::fromId($_GET[RadiologyRecord::RECORD_ID]);
} else {
	$record = new RadiologyRecord();
}

if(isset($_POST[RadiologyRecord::SUBMIT])) {
	//TODO: date conversion

	$message = applyAndValidateRecordFields($record);

	if($message == ""){
		if($record->saveToDatabase()) {
			//TODO: redirect somewhere?
		}
		
	}
}

include("views/record.php");


?>