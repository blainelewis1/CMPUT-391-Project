<?php



function getPDOInstance() {

	static $instance = null;
	
	if(!$instance) {
		include_once("dbpass.php");

		$conn = $dbtype.":host=".$host.";dbname=".$dbname.";charset=utf8";


		$instance = new PDO($conn, $username, $password);
		$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}


	return $instance;
}



?>