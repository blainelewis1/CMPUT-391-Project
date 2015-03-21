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

	const GET_ALL_PEOPLE_QUERY = "SELECT persons.first_name, 
										persons.last_name, 
										persons.person_id,
										user_accounts.user_names,
										user_accounts.class_names
				   FROM persons LEFT JOIN
				   (
					  SELECT users.person_id,
					         GROUP_CONCAT(classes.class_name) AS class_names,
					         GROUP_CONCAT(users.user_name) AS user_names
					  FROM users JOIN classes ON users.class = classes.class_id
					  GROUP BY users.person_id

					) as user_accounts
					    ON user_accounts.person_id = persons.person_id";



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

		$query = $db->prepare(Person::GET_ALL_PEOPLE_QUERY);
		$query->execute();	

		return $query->fetchAll();
	}

	//TODO: is delete required
	public static function delete($person_id) {
		$db = getPDOInstance();
		$query = $db->prepare(Person::DELETE_QUERY);

		$query->bindValue("person_id", $person_id);
		$query->execute();
	}

	public static function fromUserName($user_name) {
		$person = new Person();
		$person->user_name = $user_name;
		$person->selectFromUsername();
		$person->new = false;
	}

	public static function fromId($person_id) {
		$person = new Person();
		$person->person_id = $person_id;
		$person->selectFromId();
		$person->new = false;
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

		$query->bindValue("user_name", $this->person_id);
		$query->execute();

		$row = $query->fetch();
		populateFromRow($row);

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
		if($this->new){
			$this->insert();
		} else {
			$this->update();
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