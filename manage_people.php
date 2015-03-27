<?php

include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$people = Person::getAllPeople();

$content = "views/lists/people.php";
include("views/templates/template.php");

?>