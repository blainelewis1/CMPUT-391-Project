<?php

include_once('models/user.php');

ensureUserLoggedIn();

$admin = isAdmin();
$radiologist = isRadiologist();

include("views/landing.php");

?>