<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

$content = "views/landing.php";
include("views/template.php");

?>