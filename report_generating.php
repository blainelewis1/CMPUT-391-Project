<?php

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$records = array();

$diagnosis = isset($_GET[RadiologyRecord::DIAGNOSIS]) ? 
	$_GET[RadiologyRecord::DIAGNOSIS] : "";
$start_date = isset($_GET[RadiologyRecord::TEST_START_DATE]) ? 
	$_GET[RadiologyRecord::TEST_START_DATE] : "";
$end_date = isset($_GET[RadiologyRecord::TEST_END_DATE]) ? 
	$_GET[RadiologyRecord::TEST_END_DATE] : "";

$message = validateDiagnosisFormFields($records);

$records = RadiologyRecord::selectByDiagnosisAndDate($diagnosis, $start_date, $end_date);

$content = "views/report_generator.php";

include("views/templates/template.php");

?>