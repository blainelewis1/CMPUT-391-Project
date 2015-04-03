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

$rows = array();

if(sizeOf($columnNames) != 1) {
	$rows = RadiologyRecord::analyze($columns, $real_drill_level);
} 


//TODO: make those checkboxes look nice
//TODO: remove drill level if date isn't selected...

$title = "Data Analysis";
$content = 'views/lists/data_analysis.php';

include("views/templates/template.php");

?>