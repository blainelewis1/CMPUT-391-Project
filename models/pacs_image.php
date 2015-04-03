<?php

include_once('misc/database.php');

/*
	This class represents a row in pacs_image and provides the ability
	to insert and select an image. 

	It can resize an image into thumbnails as well as select only a certain size


	images can be viewed via /pacs_image.php (see for more info)
*/

class PACSImage {


	//Insert an image using empty blobs as place holders and returning
	//descriptors to put new ones in
	const INSERT = "INSERT INTO pacs_images 
			(pacs_images.record_id, pacs_images.thumbnail, pacs_images.regular_size, pacs_images.full_size)
			VALUES (:record_id, EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB())
			RETURNING pacs_images.thumbnail, pacs_images.regular_size, pacs_images.full_size 
			INTO :thumbnail, :regular_size, :full_size";

	const SELECT_IMAGE = "SELECT pacs_images.image_size
						  FROM pacs_images
						  WHERE pacs_images.image_id = :image_id";


    //Constants for POST and GET names
	const REGULAR = "regular_size";
	const THUMBNAIL = "thumbnail";
	const FULL = "full_size";

	const IMAGE = "image";

	const IMAGE_ID = "image_id";
	const SIZE = "size";

	const SUBMIT = "submit";
	const SUBMIT_ANOTHER = "submit_another";

	//Sizes for thumbnails and regular sized images, full size is just that, full size
	
	const THUMB_WIDTH = 200;
	const THUMB_HEIGHT = 150;
	const REGULAR_WIDTH = 400;
	const REGULAR_HEIGHT = 300;


	//Fields in the database
	public $record_id;
	public $image_id;

	private $thumbnail;
	private $regular_size;
	private $full_size;


	//A filename to the basei image
	public $image;

	//Utility function to get an image URL 
	public static function getURL($image_id, $image_size) {
		return 'pacs_image.php?image_id='.$image_id.'&image_size='.$image_size;
	}
	//Utility function to get an actual image tag filled in
	public static function getThumbnail($image_id){
		return '<a href="'.PACSImage::getURL($image_id, PACSImage::FULL).'">
					<img src="'.PACSImage::getURL($image_id, PACSImage::THUMBNAIL).'" />
				<a>';
	}

	public function __construct($image_id = null) {
		$this->image_id = $image_id;

		print($this->image_id);
	}

	//Selects an image of size based on the image_id given in the constructor
	public function getImage($size) {
		return $this->selectImage($size);
	}

	//Selects an image in and returns the image's bytes
	private function selectImage($size) {
		$db = getPDOInstance();
		
		$select = PACSImage::SELECT_IMAGE;
		$select = str_replace('image_size', $size, $select);

		$query = oci_parse($db, $select);

		oci_bind_by_name($query, ":image_id", $this->image_id);
		oci_execute($query);
		print($this->image_id);

		$row = oci_fetch_array($query, OCI_RETURN_LOBS);

		print_r($row);

		return $row;
	}


	//Resize and insert an image into the database
	public function insert() {
		
		//Resize the images and get the filenames of resized images

		$thumb = $this->resize($this->image, PACSImage::THUMB_WIDTH, PACSImage::THUMB_HEIGHT);
		$regular = $this->resize($this->image, PACSImage::REGULAR_WIDTH, PACSImage::REGULAR_HEIGHT);
		$full = $this->image;

		$db = getPDOInstance();
		$query = oci_parse($db, PACSImage::INSERT);

		//Descriptors for the different sized images
		$thumb_clob = oci_new_descriptor($db, OCI_D_LOB);
		$regular_clob = oci_new_descriptor($db, OCI_D_LOB);
		$full_clob = oci_new_descriptor($db, OCI_D_LOB);

		//Bind descriptors etc.
		oci_bind_by_name($query, ":record_id", $this->record_id);
		oci_bind_by_name($query, ":thumbnail", $thumb_clob, -1, OCI_B_BLOB);
		oci_bind_by_name($query, ":regular_size", $regular_clob, -1, OCI_B_BLOB);
		oci_bind_by_name($query, ":full_size", $full_clob, -1, OCI_B_BLOB);

		oci_execute($query, OCI_DEFAULT);

		//Now we import the images in
		$thumb_clob->import($thumb);
		$regular_clob->import($regular);
		$full_clob->import($full);

		oci_commit($db);

		//Cleanup the images
		@unlink($thumb);
		@unlink($regular);
		@unlink($full);

	}

	//Resize an image into the given aspect ratio by first cropping and then scaling
	//Saves it and returns the file name
	private function resize($image, $newwidth, $newheight) {


		//http://php.net/manual/en/function.imagecopyresized.php [22/03/2015] blaine1

		// Get sizes
		list($width, $height) = getimagesize($image);

		//Build ratios
		$ratio = $width/$height;
		$newratio = $newwidth/$newheight;

		//Load the original image and create a placeholder for the new one
		$newimage = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($image);

		//If it is wider than the given ratio, we need to crop width off before resizing
		if($ratio > $newratio) {
		
			$cropwidth = $newratio * $height;
			$xoffset = ($width - $cropwidth) / 2;

			imagecopyresized($newimage, $source, 0, 0, $xoffset, 0, $newwidth, $newheight, $cropwidth, $height);
			
		} else {
			//Otherwise we crop height off then resize

			$cropheight = $width / $newratio;
			$yoffset = ($height - $cropheight) / 2;

			imagecopyresized($newimage, $source, 0, 0, 0, $yoffset, $newwidth, $newheight, $width, $cropheight);

		}

		//Save the image 
		imagejpeg($newimage, $image.$newwidth);

		//Return the new images filename
		return $image.$newwidth;
	}


}

?>