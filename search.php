<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

$content = "views/search.php";
include("views/templates/template.php");

?>