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
					WHERE users.user_name = :user_name";

	const SELECT_ID = "SELECT persons.first_name, 
						   persons.last_name, 
						   persons.address,
						   persons.person_id, 
						   persons.email, 
						   persons.phone
					FROM persons
					WHERE persons.person_id = :person_id
					";
	
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
	const SELECT_ALL_BY_CLASS = "SELECT DISTINCT persons.first_name, 
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

		$query = oci_parse($db, Person::SELECT_ALL_QUERY);
		oci_execute($query);	

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	public static function getAllByClass($class) {
		$db = getPDOInstance();

		$query = oci_parse($db, Person::SELECT_ALL_BY_CLASS);
		oci_bind_by_name($query, ":class", $class);

		oci_execute($query);	

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
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
		$query = oci_parse($db, Person::SELECT_USER_NAME);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_execute($query);

		oci_fetch_object($query);
		$this->populateFromRow($row);

	}

	private function selectFromId() {
		$db = getPDOInstance();
		$query = oci_parse($db, Person::SELECT_ID);

		oci_bind_by_name($query, ":person_id", $this->person_id);
		oci_execute($query);

		oci_fetch_object($query);

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

		$query = oci_parse($db, Person::UPDATE);

		oci_bind_by_name($query, ":first_name", $this->first_name);
		oci_bind_by_name($query, ":last_name", $this->last_name);
		oci_bind_by_name($query, ":address", $this->address);
		oci_bind_by_name($query, ":email", $this->email);
		oci_bind_by_name($query, ":phone", $this->phone);
		oci_bind_by_name($query, ":person_id", $this->person_id);
		
		oci_execute($query);
	}

	private function insert(){
		$db = getPDOInstance();

		$query = oci_parse($db, Person::INSERT);

		oci_bind_by_name($query, ":person_id", $this->person_id);
		oci_bind_by_name($query, ":first_name", $this->first_name);
		oci_bind_by_name($query, ":last_name", $this->last_name);
		oci_bind_by_name($query, ":address", $this->address);
		oci_bind_by_name($query, ":email", $this->email);
		oci_bind_by_name($query, ":phone", $this->phone);
		
		oci_execute($query);
	}

	public function isNew() {
		return $this->new;
	}

}


?>