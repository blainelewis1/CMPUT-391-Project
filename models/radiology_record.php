<?php 

class RadiologyRecord {
	
	const RECORD_ID = "record_id";
	const PATIENT_ID = "patient_id";
	const DOCTOR_ID = "doctor_id";
	const RADIOLOGIST_ID = "radiologist_id";
	const TEST_TYPE = "test_type";
	const PRESCRIBING_DATE = "prescribing_date";
	const TEST_DATE = "test_date";
	const DIAGNOSIS = "diagnosis";
	const DESCRIPTION = "description";

	const SUBMIT = "submit";


	const SELECT_BY_ID = "SELECT DISTINCT radiology_record.record_id,
								 radiology_record.patient_id,
								 radiology_record.doctor_id,
								 radiology_record.radiologist_id,
								 radiology_record.test_type,
								 radiology_record.prescribing_date,
								 radiology_record.test_date,
								 radiology_record.diagnosis,
								 radiology_record.description
						  FROM radiology_record
						  WHERE radiology_record.record_id = :record_id
						  GROUP BY persons.person_id";

	const INSERT = "INSERT INTO radiology_record (patient_id,
					doctor_id, radiologist_id, test_type, 
					prescribing_date, test_date, diagnosis,
					description)
					VALUES (:patient_id, :doctor_id,
					:radiologist_id, :test_type, :prescribing_date,
					:test_date, :diagnosis, :description)";

	public $record_id;

	public $patient_id;
	public $doctor_id;
	public $radiologist_id;
	public $test_type;
	public $prescribing_date;
	public $test_date;
	public $diagnosis;
	public $description;

	private $new;

	public static function fromId($record_id) {
		$record = new RadiologyRecord();
		$record->new = false;
		$record->record_id = $record_id;
		$record->selectFromId();

	}

	public function __construct() {
		$this->new = true;
	}

	public function savetoDatabase() {
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

	private function insert() {
		$db = getPDOInstance();
		$query = $db->prepare(RadiologyRecord::INSERT);

		$query->bindValue("patient_id", $this->patient_id);
		$query->bindValue("doctor_id", $this->doctor_id);
		$query->bindValue("radiologist_id", $this->radiologist_id);
		$query->bindValue("test_type", $this->test_type);
		$query->bindValue("test_date", $this->test_date);
		$query->bindValue("prescribing_date", $this->prescribing_date);
		$query->bindValue("diagnosis", $this->diagnosis);
		$query->bindValue("description", $this->description);

		$query->execute();

		$this->record_id = $query->lastInsertId();
	}

	private function selectFromId() {
		$db = getPDOInstance();
		$query = $db->prepare(RadiologyRecord::SELECT_BY_ID);

		$query->bindValue("record_id", $this->record_id);
		$query->execute();

		$row = $query->fetch();

		populateFromRow($row);

	}

	private function populateFromRow($row) {
		$this->record_id = $row->record_id;
		$this->patient_id = $row->patient_id;
		$this->doctor_id = $row->doctor_id;
		$this->radiologist_id = $row->radiologist_id;
		$this->test_type = $row->test_type;
		$this->prescribing_date = $row->prescribing_date;
		$this->test_date = $row->test_date;
		$this->diagnosis = $row->diagnosis;
		$this->description = $row->description;
	}
}

?>