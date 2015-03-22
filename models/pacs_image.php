<?php

include_once('misc/database.php');

class PACSImage {

	const INSERT = "INSERT INTO pacs_images 
			(pacs_images.record_id, pacs_images.thumbnail, pacs_images.regular_size, pacs_images.full_size)
			VALUES (:record_id, :thumbnail, :regular_size, :full_size)";
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
	const SUBMIT_ANOTHER = "submit";

	const MAX_THUMB_WIDTH = 250;
	const MAX_REGULAR_WIDTH = 400;

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

		$query = $db->prepare($select);

		$query->bindValue("image_id", $this->image_id);
		$query->execute();

		//http://php.net/manual/en/pdo.lobs.php [03/21/2015 blaine1]

		$query->bindColumn(1, $image, PDO::PARAM_LOB);

		$query->fetch(PDO::FETCH_BOUND);

		return $image;
	}

	public function insert() {
		//VALIDATE is a jpeg

		$thumb = fopen($this->resize($this->image, PACSImage::MAX_THUMB_WIDTH),'rb');
		$regular = fopen($this->resize($this->image, PACSImage::MAX_REGULAR_WIDTH), 'rb');
		$full = fopen($this->image, 'rb');

		$db = getPDOInstance();
		$query = $db->prepare(PACSImage::INSERT);

		$query->bindValue("record_id", $this->record_id);
		$query->bindValue("thumbnail", $thumb, PDO::PARAM_LOB);
		$query->bindValue("regular_size", $regular, PDO::PARAM_LOB);
		$query->bindValue("full_size", $full, PDO::PARAM_LOB);
		
		$query->execute();
	}

	private function resize($image, $newwidth) {
		//http://php.net/manual/en/function.imagecopyresized.php [22/03/2015] blaine1

		// Get new sizes
		list($width, $height) = getimagesize($image);

		$ratio = $width/$height;

		$newheight = $width / $ratio;

		// Load
		$newimage = imagecreatetruecolor($newwidth, $newheight);
		$source = imagecreatefromjpeg($image);

		// Resize
		imagecopyresized($newimage, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

		imagejpeg($newimage, $image.$newwidth);

		return $image.$newwidth;
	}


}

?>