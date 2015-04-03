<?php

/*
	From here an admin can display all records between a certain time with a certain diagnosis.

	All parameters are passed via GET because it acts like a search
*/

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

$records = RadiologyRecord::selectByDiagnosisAndDate($diagnosis, $start_date, $end_date);

$title = "Reports";
$content = "views/forms/report_generating.php";

include("views/templates/template.php");

?>