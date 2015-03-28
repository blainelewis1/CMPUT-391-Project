<?php

include_once('misc/database.php');

class PACSImage {

	const INSERT = "INSERT INTO pacs_images 
			(pacs_images.record_id, pacs_images.thumbnail, pacs_images.regular_size, pacs_images.full_size)
			VALUES (:record_id, EMPTY_BLOB(), EMPTY_BLOB(), EMPTY_BLOB())
			RETURNING pacs_images.thumbnail, pacs_images.regular_size, pacs_images.full_size 
			INTO :thumbnail, :regular_size, :full_size";
	const UPDATE = "UPDATE pacs_image";

	const SELECT_IMAGE = "SELECT pacs_images.image_size
						  FROM pacs_images
						  WHERE pacs_images.image_id = :image_id";

	const REGULAR = "regular_size";
	const THUMBNAIL = "thumbnail";
	const FULL = "full_size";

	const IMAGE = "image";

	const IMAGE_ID = "image_id";
	const SIZE = "size";

	const SUBMIT = "submit";
	const SUBMIT_ANOTHER = "submit_another";

	#const RATIO = 200/150;
	const RATIO = 1.33333333333;
	
	const THUMB_WIDTH = 200;
	const THUMB_HEIGHT = 150;
	const REGULAR_WIDTH = 400;
	const REGULAR_HEIGHT = 300;

	public $record_id;
	public $image_id;

	private $thumbnail;
	private $regular_size;
	private $full_size;

	private $new;

	public $image;

	public function __construct($image_id = null) {
		if($image_id == null) {
			$this->new = true;
		} else {
			$this->image_id = $image_id;
		}
	}

	public function getImage($size) {
		return $this->selectImage($size);
	}


	private function selectImage($size) {
		$db = getPDOInstance();
		
		$select = PACSImage::SELECT_IMAGE;
		$select = str_replace('image_size', $size, $select);

		$query = oci_parse($db, $select);

		oci_bind_by_name($query, ":image_id", $this->image_id);
		oci_execute($query);

		//http://php.net/manual/en/pdo.lobs.php [03/21/2015 blaine1]

		$query->bindColumn(1, $image, PDO::PARAM_LOB);

		$query->fetch(PDO::FETCH_BOUND);

		return $image;
	}

	public function insert() {
		//VALIDATE is a jpeg

		$thumb = fopen($this->resize($this->image, PACSImage::THUMB_WIDTH, PACSImage::THUMB_HEIGHT),'rb');
		$regular = fopen($this->resize($this->image, PACSImage::REGULAR_WIDTH, PACSImage::REGULAR_HEIGHT), 'rb');
		$full = fopen($this->image, 'rb');

		$db = getPDOInstance();
		$query = oci_parse($db, PACSImage::INSERT);

		$thumb_clob = oci_new_descriptor($db, OCI_D_LOB);
		$regular_clob = oci_new_descriptor($db, OCI_D_LOB);
		$full_clob = oci_new_descriptor($db, OCI_D_LOB);



		oci_bind_by_name($query, ":record_id", $this->record_id);
		oci_bind_by_name($query, ":thumbnail", $thumb_clob, -1, OCI_B_BLOB);
		oci_bind_by_name($query, ":regular_size", $regular_clob, -1, OCI_B_BLOB);
		oci_bind_by_name($query, ":full_size", $full_clob, -1, OCI_B_BLOB);

		oci_execute($query, OCI_DEFAULT);
		
		$thumb_clob->save($thumb);
		$regular_clob->save($regular);
		$full_clob->save($full);

		oci_commit($db);

	}

	private function resize($image, $newwidth, $newheight) {
		//TODO: does not work (will also stretch images)

		//New approach. Make the thumb meet the aspect ratio via cropping, then resize
		//Based on the least we'd need to crop

		//http://php.net/manual/en/function.imagecopyresized.php [22/03/2015] blaine1

		// Get sizes
		list($width, $height) = getimagesize($image);

		$ratio = $width/$height;
		$newratio = $newwidth/$newheight;


		$newimage = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($image);


		if($ratio > $newratio) {
		
			$cropwidth = $newratio * $height;
			$xoffset = ($width - $cropwidth) / 2;

			imagecopyresized($newimage, $source, 0, 0, $xoffset, 0, $newwidth, $newheight, $cropwidth, $height);
			
		} else {

			$cropheight = $width / $newratio;
			$yoffset = ($height - $cropheight) / 2;

			imagecopyresized($newimage, $source, 0, 0, 0, $yoffset, $newwidth, $newheight, $width, $cropheight);

		}


		imagejpeg($newimage, $image.$newwidth);

		return $image.$newwidth;
	}


}

?>