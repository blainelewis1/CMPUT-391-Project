<?php

include_once('models/user.php');
include_once('models/radiology_record.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$columnNames = isset($_GET[RadiologyRecord::DRILL_LEVEL]) ? 
				   $_GET[RadiologyRecord::DRILL_LEVEL] : "";

$start_date = isset($_GET[RadiologyRecord::TEST_START_DATE]) ? 
				   $_GET[RadiologyRecord::TEST_START_DATE] : "";

$end_date = isset($_GET[RadiologyRecord::TEST_END_DATE]) ? 
				   $_GET[RadiologyRecord::TEST_END_DATE] : "";

$columnNames = isset($_GET[RadiologyRecord::ANALYZE_LEVEL]) ? 
				   $_GET[RadiologyRecord::ANALYZE_LEVEL] : array();

print_r($columnNames);

$columns = array();

foreach ($columnNames as $columnName) {
	$columns[] = RadiologyRecord::$ANALYZE_COLUMNS[$columnName];
}

$rows = RadiologyRecord::analyze($columns, $start_date, $end_date, strtolower($drill_level));

$title = "Data Analysis";
$content = 'views/data_analysis.php';

include("views/templates/template.php");

?>