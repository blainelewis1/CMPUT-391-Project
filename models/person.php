<?php

include_once("misc/database.php");

class Person {
	const FIRST_NAME = "first_name";
	const LAST_NAME = "last_name";
	const ADDRESS = "address";
	const EMAIL = "email";
	const PHONE = "phone";
	const SUBMIT = "submit";
	const DELETE = "delete";
	const PERSON_ID = "person_id";

	const DOCTOR = "d";
	const ADMIN = "a";
	const PATIENT = "p";
	const RADIOLOGIST = "r";

	const SELECT_USER_NAME = "SELECT persons.first_name, 
						   persons.last_name, 
						   persons.address,
						   persons.person_id, 
						   persons.email, 
						   persons.phone
					FROM persons JOIN users 
					ON persons.person_id = users.person_id
					WHERE users.user_name = :user_name
					LIMIT 1";

	const SELECT_ID = "SELECT persons.first_name, 
						   persons.last_name, 
						   persons.address,
						   persons.person_id, 
						   persons.email, 
						   persons.phone
					FROM persons
					WHERE persons.person_id = :person_id
					LIMIT 1";
	
	const UPDATE = "UPDATE persons
					SET first_name = :first_name, 
					    last_name = :last_name, 
					    address = :address, 
					    email = :email, 
					    phone = :phone
					WHERE persons.person_id = :person_id";

	const INSERT = "INSERT INTO persons
					(person_id, first_name, last_name, address, email, phone)
					VALUES (:person_id, :first_name, :last_name, :address, :email, :phone)";

	const DELETE_QUERY = "DELETE FROM persons WHERE persons.person_id = :person_id";

	const SELECT_ALL_QUERY = "SELECT persons.first_name, 
										persons.last_name, 
										persons.person_id
								  FROM persons";
	const SELECT_ALL_BY_CLASS = "SELECT persons.first_name, 
										persons.last_name, 
										persons.person_id
								  FROM persons JOIN users ON persons.person_id = users.person_id
								  WHERE class = :class";

	public $first_name;
	public $last_name;
	public $address; 
	public $email; 
	public $phone; 
	public $person_id;

	private $user_name;
	private $new;


	public static function getAllPeople() {
		$db = getPDOInstance();

		$query = $db->prepare(Person::SELECT_ALL_QUERY);
		$query->execute();	

		return $query->fetchAll();
	}

	public static function getAllByClass($class) {
		$db = getPDOInstance();

		$query = $db->prepare(Person::SELECT_ALL_BY_CLASS);
		$query->bindValue("class", $class);

		$query->execute();	

		return $query->fetchAll();
	}

	public static function fromUserName($user_name) {
		$person = new Person();
		$person->user_name = $user_name;
		$person->selectFromUsername();
		$person->new = false;
	
		return $person;
	}


	public static function fromId($person_id) {
		$person = new Person();
		
		$person->person_id = $person_id;

		$person->selectFromId();
		$person->new = false;

		return $person;
	}

	public function __construct(){
		$this->new = true;
	}


	private function selectFromUsername() {
		$db = getPDOInstance();
		$query = $db->prepare(Person::SELECT_USER_NAME);

		$query->bindValue("user_name", $this->user_name);
		$query->execute();

		$row = $query->fetch();
		populateFromRow($row);

	}

	private function selectFromId() {
		$db = getPDOInstance();
		$query = $db->prepare(Person::SELECT_ID);

		$query->bindValue("person_id", $this->person_id);
		$query->execute();

		$row = $query->fetch();

		$this->populateFromRow($row);

	}

	private function populateFromRow($row) {
		$this->first_name = $row->first_name;
		$this->last_name = $row->last_name;
		$this->address = $row->address;
		$this->email = $row->email;
		$this->phone = $row->phone;
		$this->person_id = $row->person_id;
	}

	public function saveToDatabase() {
		try {
			if($this->new){
				$this->insert();
			} else {
				$this->update();
			}
			return true;
		} catch(PDOException $e) {
			if($e->errorInfo[1] == -803 || $e->errorInfo[1] == 1062){
				return false;
			} 
		}
	}

	private function update(){
		$db = getPDOInstance();

		$query = $db->prepare(Person::UPDATE);

		$query->bindValue("first_name", $this->first_name);
		$query->bindValue("last_name", $this->last_name);
		$query->bindValue("address", $this->address);
		$query->bindValue("email", $this->email);
		$query->bindValue("phone", $this->phone);
		$query->bindValue("person_id", $this->person_id);
		
		$query->execute();
	}

	private function insert(){
		$db = getPDOInstance();

		$query = $db->prepare(Person::INSERT);

		$query->bindValue("person_id", $this->person_id);
		$query->bindValue("first_name", $this->first_name);
		$query->bindValue("last_name", $this->last_name);
		$query->bindValue("address", $this->address);
		$query->bindValue("email", $this->email);
		$query->bindValue("phone", $this->phone);
		
		$query->execute();
	}

	public function isNew() {
		return $this->new;
	}

}


?>