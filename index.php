<?php

include('models/user.php');

ensureUserLoggedIn();

$user = getUserName();
include("landing.php");

?>