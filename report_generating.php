<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$records = [];

$diagnosis = isset($_POST[RadiologyRecord::DIAGNOSIS]) ? 
	$_POST[RadiologyRecord::DIAGNOSIS] : "";
$start_date = isset($_POST[RadiologyRecord::TEST_START_DATE]) ? 
	$_POST[RadiologyRecord::TEST_START_DATE] : "";
$end_date = isset($_POST[RadiologyRecord::TEST_END_DATE]) ? 
	$_POST[RadiologyRecord::TEST_END_DATE] : "";

if(isset($_POST[RadiologyRecord::SEARCH])) {
	$message = validateDiagnosisFormFields($records);

	if($message == ""){
		$records = RadiologyRecord::selectByDiagnosisAndDate($diagnosis, $start_date, $end_date);
	}
}

$content = "views/report_generator.php";

include("views/template.php");

?>