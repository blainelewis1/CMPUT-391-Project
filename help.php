<?php

include_once("models/user.php");
include_once("misc/utils.php");

$title = "Help";



$content = "views/help/";
$content .= $_GET['page'].'.php';

include("views/templates/help_template.php");

?>