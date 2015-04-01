<?php

session_start();

include_once("misc/database.php");
include_once("misc/utils.php");

/*
	This file represents a row from the users table and manipulates that table

	It allows for:
		login
		selecting all users
		updating
		inserting
		selecting by username
		deletion


	Can be instantiated as User::getLoggedInUser(), User::fromUserName($user_name) resulting in an update
	or normally resulting in an insert
*/

//TODO: changing your username means that you login as a different person

class User {

	//Used for POST and GET names

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
	
	const INSERT = "INSERT INTO users 
					(person_id, user_name, class, password, date_registered)
					VALUES (:person_id, :user_name, :class, :password, SYSDATE)";

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

	//Fields corresponding to the database row
	
	public $class;
	public $user_name = "";
	public $person_id;

	//Used to determine if a user should be updated or inserted
	
	private $new = false; 
	
	//Gets all the users
	public static function getAllUsers() {
		$db = getPDOInstance();

		$query = oci_parse($db, User::SELECT_ALL_USERS_QUERY);
		oci_execute($query);	

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	//Return a new user populated using the user_name
	public static function fromUsername($user_name) {
		$user = new User();


		$user->user_name = $user_name;
		$user->selectFromUsername();
		$user->new = false;

		return $user;
	}

	//Returns a User based on the logged in user.
	//Redirects if there is none logged in
	public static function getLoggedInUser(){

		User::ensureUserLoggedIn();
		$user = User::fromUsername($_SESSION[User::USER_NAME]);
		return $user;

	}

	//Determines if a user is logged in without redirection
	public static function isUserLoggedIn() {
		return isset($_SESSION[User::USER_NAME]);
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


	public static function logout() {
		unset($_SESSION[User::USER_NAME]);
	}

	//Deletes a user with the given user_name
	public static function deleteRecord($user_name) {
		$db = getPDOInstance();

		$query = oci_parse($db, User::DELETE);
		oci_bind_by_name($query, ":user_name", $user_name);

		oci_execute($query);
	}


	public function __construct() {
		$this->new = true;
	}

	/*
		Saves the record to the database, choosing whether
		It should be inserted or updated.

		Returns false if the row was a duplicate or another error occurred
	*/
	public function saveToDatabase() {
		if($this->new){
			return $this->insert();
		} else {
			return $this->update();
		}
	}

	public function isNew() {
		return $this->new;
	}

	/*
		Selects based on the set user_name
	*/

	private function selectFromUsername() {
		$db = getPDOInstance();

		$query = oci_parse($db, User::SELECT_FROM_USER_NAME);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		
		oci_execute($query);	

		$row = oci_fetch_object($query);
		
		$this->populateFromRow($row);
	}

	// Populates all fields of the class

	private function populateFromRow($row) {
		$this->class = $row->CLASS;
		$this->user_name = $row->USER_NAME;
		$this->person_id = $row->PERSON_ID;
	}
	
	//Update the row in the database
	private function update(){
		$db = getPDOInstance();

		$query = oci_parse($db, User::UPDATE);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_bind_by_name($query, ":old_user_name", $this->old_user_name);
		oci_bind_by_name($query, ":class", $this->class);
		
		return @oci_execute($query);
	}

	//Insert this as a new row
	private function insert(){
		$db = getPDOInstance();

		$query = oci_parse($db, User::INSERT);

		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_bind_by_name($query, ":class", $this->class);
		oci_bind_by_name($query, ":person_id", $this->person_id);
		oci_bind_by_name($query, ":password", $this->password);
		
		return @oci_execute($query);
	}

	//Update the password for this user
	public function updatePassword($password){
		$db = getPDOInstance();

		$query = oci_parse($db, User::CHANGE_PASSWORD_QUERY);
		oci_bind_by_name($query, ":user_name", $this->user_name);
		oci_bind_by_name($query, ":password", $password);
		oci_execute($query);
	}

	public function getUserName() {
		return $this->user_name;
	}


	/*
		Tests if the user is a certain class
		redirect will give an access denied page

	*/
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

	/*
		These fuctions test if the user is a certain class
		Seems boilerplate but it decouples those hardcoded class ids
	*/

	public function isAdmin($redirect=true) {
		return $this->isClass("a", $redirect);
	}

	public function isRadiologist($redirect=true) {
		return $this->isClass("r", $redirect);
	}

	public function isDoctor($redirect=true) {
		return $this->isClass("d", $redirect);
	}
	
	public function isPatient($redirect=true) {
		return $this->isClass("p", $redirect);
	}

}


?>
