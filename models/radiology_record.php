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
	const TEST_START_DATE = "test_start_date";
	const TEST_END_DATE = "test_end_date";

	const SUBMIT = "submit";
	const SEARCH = "search";


	const SELECT_BY_ID = "SELECT DISTINCT radiology_records.record_id,
								 radiology_records.patient_id,
								 radiology_records.doctor_id,
								 radiology_records.radiologist_id,
								 radiology_records.test_type,
								 radiology_records.prescribing_date,
								 radiology_records.test_date,
								 radiology_records.diagnosis,
								 radiology_records.description
						  FROM radiology_records
						  WHERE radiology_records.record_id = :record_id
						  GROUP BY persons.person_id";

	const SELECT_ALL_BY_DIAGNOSIS_AND_DATE = "SELECT p.first_name,
							 	p.address, p.phone, t.test_date
						FROM radiology_records r, persons p
						WHERE p.person_id = r.patient_id 
						AND r.diagnosis = :diagnosis 
						AND r.test_date >= :start_date 
						AND r.test_date <= :end_date";

	public $record_id;
	public $patient_id;
	public $doctor_id;
	public $radiologist_id;
	public $test_type;
	public $prescribing_date;
	public $test_date;
	public $diagnosis;
	public $description;

	public $start_date;
	public $end_date;

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

	}

	public static function selectByDiagnosisAndDate($diagnosis, $start_date, $end_date) {
		$db = getPDOInstance();

		$query = $db->prepare(RadiologyRecord::SELECT_ALL_BY_DIAGNOSIS_AND_DATE);

		$query->bindValue("diagnosis", $diagnosis);
		$query->bindValue("start_date", $start_date);
		$query->bindValue("end_date", $end_date);
		
		$query->execute();	

		return $query->fetchAll();
	//	$this->populateFromRow($query->fetch());
	}

	private function insert() {
		$db = getPDOInstance();
		$query = $db->prepare(RadiologyRecord::INSERT);

		$query->bindValue("record_id", $this->record_id);
		$query->execute();
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