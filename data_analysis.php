<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$content = 'data_analysis,php';

include("views/template.php");

?>