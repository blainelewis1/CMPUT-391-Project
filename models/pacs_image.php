<?php

include_once('misc/database.php');

class PACSImage {

	const INSERT = "INSERT INTO pacs_images 
			(pacs_images.record_id, pacs_images.thumbnail, pacs_images.regular_size, pacs_images.full_size)
			VALUES (:record_id, :thumbnail, :regular_size, :full_size)";
	const UPDATE = "UPDATE pacs_image";

	const SELECT_IMAGE = "SELECT pacs_images.:image_size
						  FROM pacs_images
						  WHERE pacs_images.image_id = :image_id";

	const REGULAR = "regular_size";
	const THUMBNAIL = "thumbnail";
	const FULL = "full_size";

	const IMAGE_ID = "image_id";
	const SIZE = "size";

	const SUBMIT = "submit";
	const SUBMIT_ANOTHER = "submit";

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
		$query = $db->prepare(PACSImage::SELECT_IMAGE);

		$query->bindValue("image_id", $this->image_id);
		$query->bindValue("image_size", $size);
		$query->execute();

		//http://php.net/manual/en/pdo.lobs.php [03/21/2015 blaine1]
		$image;

		$query->bindColumn(1, $image, PDO::PARAM_LOB);
		$query->fetch(PDO::FETCH_BOUND);

		return $image;
	}

	public function insert() {

		$thumb = resize($this->image, PACSImage::MAX_THUMB_WIDTH);
		$regular = resize($this->image, PACSImage::MAX_REGULAR_WIDTH);
		$full = $this->image;

		$db = getPDOInstance();
		$query = $db->prepare(PACSImage::INSERT);

		$query->bindValue("record_id", $this->record_id);
		$query->bindValue("thumbnail", $thumb, PDO::PARAM_LOB);
		$query->bindValue("regular_size", $regular, PDO::PARAM_LOB);
		$query->bindValue("full_size", $full, PDO::PARAM_LOB);
		
		$query->execute();
	}

	private function resize($image, $width) {
		
	}


}

?>