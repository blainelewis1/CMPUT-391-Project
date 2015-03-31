<?php
/*
	From here a user can search for any record
*/
include_once('models/user.php');
include_once('models/radiology_record.php');
include_once('controllers/radiology_record.php');

$user = User::getLoggedInUser();

//$user->isAdmin();

$records = array();

$search_term = isset($_GET[RadiologyRecord::SEARCH_TERM]) ? 
				   $_GET[RadiologyRecord::SEARCH_TERM] : "";

$start_date = isset($_GET[RadiologyRecord::TEST_START_DATE]) ? 
					$_GET[RadiologyRecord::TEST_START_DATE] : "";

$end_date = isset($_GET[RadiologyRecord::TEST_END_DATE]) ? 
			      $_GET[RadiologyRecord::TEST_END_DATE] : "";

$message = validateSearchFormFields($records);

$records = RadiologyRecord::selectBySearch($search_term, $start_date, $end_date);

//$user->isAdmin() and $user->isRadiologist 
/*
display certain records depending on user type

a patient can only view his/her own records; 
a doctor can only view records of their patients; 
a radiologist can only review records conducted by oneself;
an administrator can view any records;
*/
$title = "Search";
$content = "views/search.php";

include("views/templates/template.php");

?>
