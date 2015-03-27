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
						       users.password = :password
						 LIMIT 1";

	const CHANGE_PASSWORD_QUERY = "UPDATE users
							 SET password = :password
							 WHERE users.user_name = :user_name";

	const SELECT_ALL_USERS_QUERY = "SELECT users.user_name,
										   users.person_id,
										   users.class,
										   users.date_registered
									FROM users";
	
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
									LIMIT 1";

	const DELETE = "DELETE FROM users WHERE users.user_name = :user_name";

	public $class;
	public $user_name = "";
	private $new = false; 
	public $person_id;

	public static function getAllUsers() {
		$db = getPDOInstance();

		$query = $db->prepare(User::SELECT_ALL_USERS_QUERY);
		$query->execute();	

		return $query->fetchAll();
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

		$query = $db->prepare(User::SELECT_FROM_USER_NAME);

		$query->bindValue("user_name", $this->user_name);
		
		$query->execute();	

		$this->new = false;
		$this->populateFromRow($query->fetch());
	}

	private function populateFromRow($row) {
		$this->class = $row->class;
		$this->user_name = $row->user_name;
		$this->person_id = $row->person_id;
	}
	
	private function update(){
		$db = getPDOInstance();

		$query = $db->prepare(User::UPDATE);

		$query->bindValue("user_name", $this->user_name);
		$query->bindValue("old_user_name", $this->old_user_name);
		$query->bindValue("class", $this->class);
		
		$query->execute();
	}

	private function insert(){
		$db = getPDOInstance();

		$query = $db->prepare(User::INSERT);

		$query->bindValue("user_name", $this->user_name);
		$query->bindValue("class", $this->class);
		$query->bindValue("person_id", $this->person_id);
		$query->bindValue("password", $this->password);
		
		$query->execute();
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

		$query = $db->prepare(User::CHANGE_PASSWORD_QUERY);
		$query->bindValue("user_name", $this->user_name);
		$query->bindValue("password", $password);
		$query->execute();
	}

	public static function deleteRecord($user_name) {
		$db = getPDOInstance();

		$query = $db->prepare(User::DELETE);
		$query->bindValue("user_name", $user_name);

		$query->execute();
	}

	/*
		Returns true if the login succeeds, false if it doesn't
	*/

	public static function login($user_name, $password) {
		$db = getPDOInstance();

		$query = $db->prepare(User::LOGIN_QUERY);
		$query->bindValue("user_name", $user_name);
		$query->bindValue("password", $password);
		$query->execute();

		if($query->rowCount()) {

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