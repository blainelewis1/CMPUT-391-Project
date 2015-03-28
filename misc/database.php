<?php



function getPDOInstance() {

	static $instance = null;
	
	if(!$instance) {
		include_once("dbpass.php");
		
		$instance = oci_connect($username, $password);
		if (!$conn) {
		   $e = oci_error();
		   #trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}

		#$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		#$instance->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	}


	return $instance;
}



?>