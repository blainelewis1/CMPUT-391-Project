<?php

/*
	From here a user can search for any record

	Takes all parameters via GET
*/

include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

$user = User::getLoggedInUser();

$records = array();
$viewable = array();

$search_term = isset($_GET[RadiologyRecord::SEARCH_TERM]) ? 
				   $_GET[RadiologyRecord::SEARCH_TERM] : "";

$start_date = isset($_GET[RadiologyRecord::TEST_START_DATE]) ? 
					$_GET[RadiologyRecord::TEST_START_DATE] : "";

$end_date = isset($_GET[RadiologyRecord::TEST_END_DATE]) ? 
			      $_GET[RadiologyRecord::TEST_END_DATE] : "";

$search_order = isset($_GET[RadiologyRecord::ORDER]) ? 
			      $_GET[RadiologyRecord::ORDER] : "";

if(!($search_term == "" && $start_date == "" && $$end_date == "")){
	$records = RadiologyRecord::search($user, $search_term, $start_date, $end_date, $search_order);
}

$title = "Search";
$content = "views/lists/search.php";

include("views/templates/template.php");

?>
