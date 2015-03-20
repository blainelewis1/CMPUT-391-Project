<?php

include_once('models/user.php');

$user = User::getLoggedInUser();


include("views/user_settings.php");



?>