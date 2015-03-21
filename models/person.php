<?php

include_once("misc/database.php");

class Person {
	const FIRST_NAME = "first_name";
	const LAST_NAME = "last_name";
	const ADDRESS = "address";
	const EMAIL = "email";
	const PHONE = "phone";
	const SUBMIT = "submit";


	const SELECT = "SELECT persons.first_name, 
						   persons.last_name, 
						   persons.address,
						   persons.person_id, 
						   persons.email, 
						   persons.phone
					FROM persons JOIN users 
					ON persons.person_id = users.person_id
					WHERE users.user_name = :user_name
					LIMIT 1";
	
	const UPDATE = "UPDATE persons
					SET first_name = :first_name, 
					    last_name = :last_name, 
					    address = :address, 
					    email = :email, 
					    phone = :phone
					WHERE persons.person_id = :person_id";

	const INSERT = "INSERT INTO persons
					(first_name, last_name, address, email, phone)
					VALUES (:first_name, :last_name, :address, :email, :phone)";

	public $first_name;
	public $last_name;
	public $address; 
	public $email; 
	public $phone; 
	public $person_id;

	private $user_name;

	public function __construct($user_name){
		$this->user_name = $user_name;
		$this->select();
	}

	private function select() {
		$db = getPDOInstance();
		$query = $db->prepare(Person::SELECT);

		$query->bindValue("user_name", $this->user_name);
		$query->execute();

		$row = $query->fetch();

		$this->first_name = $row->first_name;
		$this->last_name = $row->last_name;
		$this->address = $row->address;
		$this->email = $row->email;
		$this->phone = $row->phone;
		$this->person_id = $row->person_id;

	}

	public function update(){
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

	public function insert(){
		$db = getPDOInstance();

		$query = $db->prepare(Person::INSERT);

		$query->bindValue("first_name", $this->first_name);
		$query->bindValue("last_name", $this->last_name);
		$query->bindValue("address", $this->address);
		$query->bindValue("email", $this->email);
		$query->bindValue("phone", $this->phone);
		
		$query->execute();
	}

}


?>