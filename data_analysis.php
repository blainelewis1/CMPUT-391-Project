<?php

include_once('models/user.php');
include_once('models/radiology_record.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$analyze = array();
$drill = "";
$start_date = "";
$end_date = "";

$content = 'views/data_analysis.php';

include("views/templates/template.php");

?>