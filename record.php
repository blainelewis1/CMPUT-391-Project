<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

//TODO: check error conditions, eg. invalid id

$user = User::getLoggedInUser();

$user->isRadiologist();

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
			#header('Location: upload.php?'.RadiologyRecord::RECORD_ID.'='.$record->record_id);
			#die();
		}
		print($message);
		
	}
}
$content = "views/forms/record.php";
include("views/templates/template.php");


?>