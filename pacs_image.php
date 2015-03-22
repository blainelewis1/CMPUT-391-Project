<?php
include('models/pacs_image.php');

//TODO: validation
$image = new PACSImage($_GET[PACSImage::RECORD_ID]);
$size = isset($_GET[PACSImage::RECORD_ID]) ? $_GET[PACSImage::RECORD_ID] : PACSImage::REGULARS;
$image->getImage($size);


header("Content-Type: image/jpeg");

fpassthru($image);


?>