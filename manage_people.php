<?php

include_once('misc/utils.php');
include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$people = Person::getAllPeople();

$message = getNotices();
$title = "Manage People";

$content = "views/lists/people.php";
include("views/templates/template.php");

?>