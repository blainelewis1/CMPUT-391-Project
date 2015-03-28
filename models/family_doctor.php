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
						CONCAT(patient.first_name, ' ', patient.last_name) as patient_name,
						CONCAT(doctor.first_name, ' ', doctor.last_name)  as doctor_name 
						FROM family_doctor
						JOIN persons as doctor ON doctor_id=doctor.person_id 
						JOIN persons as patient ON patient_id=patient.person_id";

	const PATIENT_ID = "patient_id";
	const DOCTOR_ID = "doctor_id";

	private $new;
	private $old_patient_id;
	private $old_doctor_id;

	public static function getAllFamilyDoctors() {
		$db = getPDOInstance();

		$query = $db->prepare(FamilyDoctor::SELECT_ALL);
		$query->execute();	

		return $query->fetchAll();
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

		$query = $db->prepare(FamilyDoctor::INSERT);

		$query->bindValue("patient_id", $this->patient_id);
		$query->bindValue("doctor_id", $this->doctor_id);
		
		$query->execute();
	}

	private function update(){
		$db = getPDOInstance();

		$query = $db->prepare(FamilyDoctor::UPDATE);

		$query->bindValue("old_patient_id", $this->old_patient_id);
		$query->bindValue("old_doctor_id", $this->old_doctor_id);
		$query->bindValue("patient_id", $this->patient_id);
		$query->bindValue("doctor_id", $this->doctor_id);
		
		$query->execute();
	}

	public function deleteRecord() {
		$db = getPDOInstance();

		$query = $db->prepare(FamilyDoctor::DELETE);

		$query->bindValue("patient_id", $this->patient_id);
		$query->bindValue("doctor_id", $this->doctor_id);
		
		$query->execute();
	}

}


?>