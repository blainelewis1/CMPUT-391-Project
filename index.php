<?php

phpinfo();

include_once('models/user.php');

$user = User::getLoggedInUser();

$content = "views/landing.php";
include("views/templates/template.php");

?>