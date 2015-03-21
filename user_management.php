<?php

include_once('models/user.php');
include_once('models/person.php');

$user = User::getLoggedInUser();

if(!$user->isAdmin()){
	include("views/denied.php");
	die();
}

//TODO: is delete required
/*
if(isset($_GET[Person::DELETE])) {
	Person::delete($_GET[Person::DELETE]);
}
*/

$people = Person::getAllPeople();

include("views/list_people.php");

?>