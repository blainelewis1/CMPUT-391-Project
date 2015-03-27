<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$content = 'views/data_analysis.php';

include("views/templates/template.php");

?>