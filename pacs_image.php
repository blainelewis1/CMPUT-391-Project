<?php
/*
	This can be called with
	
	<img src="<?= PACSImage::SIZE.'='.PACSImage::FULL.'&'.PACSImage::IMAGE_ID.'='.$image->id?>" />

*/


include('models/pacs_image.php');

#header("Content-Type: image/jpeg");


if(!User::isUserLoggedIn()){
	//TODO: permissions could be tightened

	$file = fopen('images/denied.png', 'rb');
	fpassthru($file);

	die();
}

$image = new PACSImage($_GET[PACSImage::IMAGE_ID]);

$size = isset($_GET[PACSImage::SIZE]) ? $_GET[PACSImage::SIZE] : PACSImage::FULL;

$image = $image->getImage($size);

if(!$image) {

	$file = fopen('images/notfound.png', 'rb');
	fpassthru($file);

	die();
}


print($image);


?>