<?php

include('models/user.php');

userLoggedIn();

$user = getUserName();

showView("landing.php");

?>