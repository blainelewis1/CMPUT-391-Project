<?php



getPDOInstance() {

	$username = "XXXX";
	$password = "XXXX";
	$dbname = "XXXX";
	$host = "XXXX";
	$dbtype = "XXXX";

	static $instance = new PDO(".$dbtype.":host=".$host.";dbname=".$dbname.";charset=utf8", $username, $password);
	return $instance;
}



?>