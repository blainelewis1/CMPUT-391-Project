<?php

class FamilyDoctor {
//TODO: add order by clauses everywhere

	const SUBMIT = "submit";
	const INSERT = "INSERT INTO family_doctor
						   (patient_id, doctor_id) 
					VALUES (:patient_id, :doctor_id)";

	const UPDATE = "UPDATE IGNORE family_doctor
					SET patient_id = :patient_id, doctor_id = :doctor_id 
					WHERE patient_id = :old_patient_id AND doctor_id=:old_doctor_id;
					DELETE FROM family_doctor WHERE patient_id = :old_patient_id AND doctor_id=:old_doctor_id";

	const DELETE = "DELETE FROM family_doctor
					WHERE patient_id = :patient_id AND doctor_id=:doctor_id";

	const SELECT_ALL = "SELECT doctor_id, patient_id, 
						patient.first_name || ' ' || patient.last_name patient_name,
						doctor.first_name || ' ' || doctor.last_name  doctor_name 
						FROM family_doctor
						JOIN persons doctor ON doctor_id=doctor.person_id 
						JOIN persons patient ON patient_id=patient.person_id";

	const PATIENT_ID = "patient_id";
	const DOCTOR_ID = "doctor_id";

	private $new;
	private $old_patient_id;
	private $old_doctor_id;

	public static function getAllFamilyDoctors() {
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::SELECT_ALL);
		oci_execute($query);	

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	public static function fromIds($patient, $doctor) {
		$family_doctor = new FamilyDoctor();
		$family_doctor->old_doctor_id = $doctor;
		$family_doctor->old_patient_id = $patient;

		$family_doctor->doctor_id = $doctor;
		$family_doctor->patient_id = $patient;

		$family_doctor->new = false;

		return $family_doctor;
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
			} else {
				throw($e);
			}
		}
	}

	private function insert() {
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::INSERT);

		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		
		oci_execute($query);
	}

	private function update(){
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::UPDATE);

		oci_bind_by_name($query, ":old_patient_id", $this->old_patient_id);
		oci_bind_by_name($query, ":old_doctor_id", $this->old_doctor_id);
		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		
		oci_execute($query);
	}

	public function deleteRecord() {
		$db = getPDOInstance();

		$query = oci_parse($db, FamilyDoctor::DELETE);

		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		
		oci_execute($query);
	}

}


?>