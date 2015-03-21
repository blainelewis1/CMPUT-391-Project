<?php

include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

if(!$user->isAdmin()){
	include("views/denied.php");
	die();
}

$people = Person::getAllPeople();

include("views/list_people.php");

?>