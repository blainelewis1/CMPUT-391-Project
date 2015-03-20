<?php

session_start();

include_once("misc/database.php");
include_once("misc/utils.php");


class User {
	const LOGIN = "SELECT users.user_name 
				   FROM users
				   WHERE users.user_name = :user_name AND 
				         users.password = :password
				   LIMIT 1";

	const CHANGE_PASSWORD = "UPDATE users
							 SET password = :password
							 WHERE users.user_name = :user_name";

	private $username = "";

	public static function getLoggedInUser(){
		return new User();
	}


	public static function isUserLoggedIn() {
		return isset($_SESSION['USER']);
	}	

	private function __construct() {
		$this->ensureUserLoggedIn();
		$this->username = $_SESSION['USER'];
	}

	/*
		Ensures there is a user currently logged in
		If there is not then we redirect
		But we remember the page and set a redirect point
	*/
	private function ensureUserLoggedIn() {
		if(!isset($_SESSION['USER'])) {

			setRedirect($_SERVER['REQUEST_URI']);
			header('Location: login.php');
			die();

		} 
	}

	public function updatePassword($password){
		$db = getPDOInstance();

		$query = $db->prepare(User::CHANGE_PASSWORD);
		$query->bindValue("user_name", $this->username);
		$query->bindValue("password", $password);
		$query->execute();
	}

	/*
		Returns true if the login succeeds, false if it doesn't
	*/

	public static function login($username, $password) {
		$db = getPDOInstance();

		$query = $db->prepare(User::LOGIN);
		$query->bindValue("user_name", $username);
		$query->bindValue("password", $password);
		$query->execute();

		if($query->rowCount()) {

			$_SESSION['USER'] = $username;
			return true;

		}

		return false;
	}

	public function isAdmin() {
		//TODO: return a real value here
		return true;
	}

	public function isRadiologist() {
		//TODO: return a real value here
		return true;
	}

	public function getUserName() {
		return $this->username;
	}

	public static function logout() {
		unset($_SESSION['USER']);
	}

}


?>