<?php
/*
	Easiest way to display an image is using the PACSImage model. There are static methods
	that return URLs for a given image
*/

include('models/user.php');
include('models/pacs_image.php');

header("Content-Type: image/jpeg");


if(!User::isUserLoggedIn()){
	//TODO: permissions could be tightened

	$file = fopen('images/denied.png', 'rb');
	fpassthru($file);

	die();
}

$image = new PACSImage($_GET[PACSImage::IMAGE_ID]);

$size = isset($_GET[PACSImage::SIZE]) ? $_GET[PACSImage::SIZE] : PACSImage::FULL;

$image = $image->getImage($size);

if($image === false) {

	$file = fopen('images/notfound.png', 'rb');
	fpassthru($file);

	die();
}


print($image);


?>