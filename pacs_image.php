<?php
include('models/pacs_image.php');

//TODO: validation
$image = new PACSImage($_GET[PACSImage::IMAGE_ID]);

$size = isset($_GET[PACSImage::SIZE]) ? $_GET[PACSImage::SIZE] : PACSImage::REGULAR;

$image->getImage($size);


header("Content-Type: image/jpeg");

fpassthru($image);


?>