<?php
/*
	This can be called with
	
	<img src="<?= PACSImage::SIZE.'='.PACSImage::FULL.'&'.PACSImage::IMAGE_ID.'='.$image->id?>" />

*/


include('models/pacs_image.php');

//TODO: validation
$image = new PACSImage($_GET[PACSImage::IMAGE_ID]);

$size = isset($_GET[PACSImage::SIZE]) ? $_GET[PACSImage::SIZE] : PACSImage::FULL;

$image = $image->getImage($size);


#header("Content-Type: image/jpeg");

print($image);


?>