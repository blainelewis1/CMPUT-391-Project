<?php

include("models/user.php");

User::logout();

header("Location: login.php");

?>