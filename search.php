<?php
/*
	From here a user can search for any record
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

$message = validateSearchFormFields($records);

$records = RadiologyRecord::selectBySearch($user, $search_term, $start_date, $end_date);

/*			
//get an array of records the user is authorized to view
if ($user->isAdmin(false)){
	$viewable = $records;
} else if ($user->isRadiologist(false)){
	foreach($records as $record ){
		if ($record->RADIOLOGIST_ID == $user->person_id){
			$viewable .= $record;
		}
	}
} else if ($user->isPatient(false)){
	foreach($records as $record ){
		if ($record->PATIENT_ID == $user->person_id){
			$viewable .= $record;
		}
	}
} else if ($user->isDoctor(false)) {
	foreach($records as $record ){
		if ($record->DOCTOR_ID == $user->person_id){
			$viewable .= $record;
		}
	}
} else {
	//ERROR
}


if($search_term != ""){
	$search_array = explode(' ', $search_term);
	$result_array = array();
			
	//TODO: SEARCH STUFF
	//loop through viewable, and add up frequency of search term using:
	//Rank(record_id) = 6*frequency(patient_name) + 3*frequency(diagnosis) + frequency(description)
}
$records = $viewable;
*/
$title = "Search";
$content = "views/search.php";

include("views/templates/template.php");

?>
