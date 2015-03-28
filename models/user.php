<?php

session_start();

include_once("misc/database.php");
include_once("misc/utils.php");

//TODO: changing your username means that you login as a different person

class User {

	const PASSWORD = "password";
	const USER_NAME = "user_name";
	const CLASS_NAME = "class";
	const CHANGE_PASSWORD = "change_password";
	const LOGIN = "login";
	const SUBMIT = "submit";

	const LOGIN_QUERY = "SELECT users.user_name 
				   		 FROM users
						 WHERE users.user_name = :user_name AND 
						       users.password = :password";

	const CHANGE_PASSWORD_QUERY = "UPDATE users
							 SET password = :password
							 WHERE users.user_name = :user_name";

	const SELECT_ALL_USERS_QUERY = "SELECT users.user_name,
										   users.person_id,
										   classes.class_name,
										   users.date_registered
									FROM users JOIN classes ON classes.class_id = users.class";
	
	//TODO: CURDATE will probably cause problems when moving to oracle									
	const INSERT = "INSERT INTO users 
					(person_id, user_name, class, password, date_registered)
					VALUES (:person_id, :user_name, :class, :password, CURDATE())";

	const UPDATE = "UPDATE users 
					SET user_name = :user_name,
					class = :class
					WHERE users.user_name = :old_user_name";

	const SELECT_FROM_USER_NAME = "SELECT users.user_name,
										   users.person_id,
										   users.class,
										   users.date_registered
									FROM users
									WHERE users.user_name = :user_name
									";

	const DELETE = "DELETE FROM users WHERE users.user_name = :user_name";

	public $class;
	public $user_name = "";
	private $new = false; 
	public $person_id;

	public static function getAllUsers() {
		$db = getPDOInstance();

		$query = oci_parse($db, User::SELECT_ALL_USERS_QUERY);
		oci_execute($query);	

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	public static function fromUsername($user_name) {
		$user = new User();


		$user->user_name = $user_name;
		$user->selectFromUsername();

		return $user;
	}
	/*
	public static function fromPersonIdNew($person_id){
		$user = new User();
		$user->new = true;
		$user->person_id = $person_id;
	}
	*/

	public static function getLoggedInUser(){

		User::ensureUserLoggedIn();
		$user = User::fromUsername($_SESSION[User::USER_NAME]);
		return $user;

	}


	public static function isUserLoggedIn() {
		return isset($_SESSION[User::USER_NAME]);
	}	

	public function __construct() {
		$this->new = true;
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

	public function isNew() {
		return $this->new;
	}

	private function selectFromUsername() {
		$db = getPDOInstance();

		$query = oci_parse($db, User::SELECT_FROM_USER_NAME);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		
		oci_execute($query);	

		$this->new = false;

		$row = oci_fetch_object($query);
		
		$this->populateFromRow($row);
	}

	private function populateFromRow($row) {
		$this->class = $row->CLASS;
		$this->user_name = $row->USER_NAME;
		$this->person_id = $row->PERSON_ID;
	}
	
	private function update(){
		$db = getPDOInstance();

		$query = oci_parse($db, User::UPDATE);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_bind_by_name($query, ":old_user_name", $this->old_user_name);
		oci_bind_by_name($query, ":class", $this->class);
		
		oci_execute($query);
	}

	private function insert(){
		$db = getPDOInstance();

		$query = oci_parse($db, User::INSERT);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_bind_by_name($query, ":class", $this->class);
		oci_bind_by_name($query, ":person_id", $this->person_id);
		oci_bind_by_name($query, ":password", $this->password);
		
		oci_execute($query);
	}

	/*
		Ensures there is a user currently logged in
		If there is not then we redirect
		But we remember the page and set a redirect point
	*/
	private static function ensureUserLoggedIn() {
		if(!isset($_SESSION[User::USER_NAME])) {

			setRedirect($_SERVER['REQUEST_URI']);
			header('Location: login.php');
			die();

		} 
	}

	public function updatePassword($password){
		$db = getPDOInstance();

		$query = oci_parse($db, User::CHANGE_PASSWORD_QUERY);
		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_bind_by_name($query, ":password", $password);
		oci_execute($query);
	}

	public static function deleteRecord($user_name) {
		$db = getPDOInstance();

		$query = oci_parse($db, User::DELETE);
		oci_bind_by_name($query, ":user_name", $user_name);

		oci_execute($query);
	}

	/*
		Returns true if the login succeeds, false if it doesn't
	*/

	public static function login($user_name, $password) {
		$db = getPDOInstance();

		$query = oci_parse($db, User::LOGIN_QUERY);
		oci_bind_by_name($query, ":user_name", $user_name);
		oci_bind_by_name($query, ":password", $password);
		oci_execute($query);

		if(oci_fetch($query)) {

			$_SESSION[User::USER_NAME] = $user_name;
			return true;

		}

		return false;
	}

	private function isClass($class, $redirect=true){
	
		if($this->class == $class) {
			return true;
		} else if($redirect == false) {
			return false;
		} else {
			$user = $this;
			$content = "views/denied.php";
			include("views/templates/template.php");
			die();

		}

	}

	public function isAdmin($redirect=true) {
		return $this->isClass("a", $redirect);
	}

	public function isRadiologist($redirect=true) {
		return $this->isClass("r", $redirect);
	}

	public function getUserName() {
		return $this->user_name;
	}

	public static function logout() {
		unset($_SESSION[User::USER_NAME]);
	}

}


?>