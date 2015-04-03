<?php

include_once('misc/database.php');

/*
	This class represents a row in family_doctor

	It allows for editting, insertion, deletion and selecting all such records

	It can be instantiated as a new record normally, meaning upon
	saving it will be inserted

	Or you can use FamilyDoctors::fromIds($patient, $doctor) which means the record will be
	updated upon saving

*/

//TODO: add order by clauses everywhere

class FamilyDoctor {

	// Constants to be used by POST or GET

	const SUBMIT = "submit";
	const PATIENT_ID = "patient_id";
	const DOCTOR_ID = "doctor_id";
	


	//Various self explanatory queries
	const INSERT = "INSERT INTO family_doctor
						   (patient_id, doctor_id) 
					VALUES (:patient_id, :doctor_id)";

	const UPDATE = "UPDATE family_doctor
					SET patient_id = :patient_id, doctor_id = :doctor_id 
					WHERE patient_id = :old_patient_id AND doctor_id=:old_doctor_id";

	const DELETE = "DELETE FROM family_doctor
					WHERE patient_id = :patient_id AND doctor_id=:doctor_id";

	const SELECT_ALL = "SELECT doctor_id, patient_id, 
						patient.first_name || ' ' || patient.last_name patient_name,
						doctor.first_name || ' ' || doctor.last_name  doctor_name 
						FROM family_doctor
						JOIN persons doctor ON doctor_id=doctor.person_id 
						JOIN persons patient ON patient_id=patient.person_id";


    //Used to determine whether we need to insert or update						
	private $new;
	
	// "old" values are given in case we need to update
	private $old_patient_id;
	private $old_doctor_id;


	//Returns all fo the family doctors

	public static function getAllFamilyDoctors() {
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::SELECT_ALL);
		oci_execute($query);	

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	//Returns a new instance from an old pair of ids

	public static function fromIds($patient, $doctor) {
		$family_doctor = new FamilyDoctor();
		$family_doctor->old_doctor_id = $doctor;
		$family_doctor->old_patient_id = $patient;

		$family_doctor->doctor_id = $doctor;
		$family_doctor->patient_id = $patient;

		$family_doctor->new = false;

		return $family_doctor;
	}

	//Default to being a new record

	public function __construct() {
		$this->new = true;
	}

	// Either updates or inserts depending on how the record was created
	// If the function returns false, there is a duplicate entry

	public function saveToDatabase() {

		if($this->new){
			return $this->insert();
		} else {
			return $this->update();
		}
		
	}


	//Insert the relationship, return false if it is a duplicate entry

	private function insert() {
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::INSERT);

		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		
		return @oci_execute($query);
	}

	//Update the relationship based on old_XXX and old_XXX, return false if it is a duplicate entry

	private function update(){
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::UPDATE);

		oci_bind_by_name($query, ":old_patient_id", $this->old_patient_id);
		oci_bind_by_name($query, ":old_doctor_id", $this->old_doctor_id);
		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		
		return @oci_execute($query);
	}

	//Delete this record from the database

	public function deleteRecord() {
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::DELETE);

		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		
		oci_execute($query);
	}

}


?>