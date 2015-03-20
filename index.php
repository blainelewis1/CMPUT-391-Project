<?php

include_once('models/user.php');

$user = User::getLoggedInUser();

include("views/landing.php");

?>