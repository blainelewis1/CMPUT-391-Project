<?php

include_once('models/user.php');
include_once('models/radiology_record.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$drill_level = isset($_GET[RadiologyRecord::DRILL_LEVEL]) ? 
				   $_GET[RadiologyRecord::DRILL_LEVEL] : "";

$columnNames = isset($_GET[RadiologyRecord::ANALYZE_LEVEL]) ? 
				   $_GET[RadiologyRecord::ANALYZE_LEVEL] : array();

$columns = array();

foreach ($columnNames as $columnName) {
	$columns[] = RadiologyRecord::$ANALYZE_COLUMNS[$columnName];
}

$columnNames[] = "Image Count";

$real_drill_level = RadiologyRecord::$DRILL_VALUES[$drill_level];

$rows = RadiologyRecord::analyze($columns, $start_date, $end_date, $real_drill_level);

$title = "Data Analysis";
$content = 'views/data_analysis.php';

include("views/templates/template.php");

?>