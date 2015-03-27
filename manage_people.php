<?php

include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

$user->isAdmin();

$people = Person::getAllPeople();

$content = "views/list_people.php";
include("views/template.php");

?>