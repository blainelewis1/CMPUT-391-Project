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

	const SELECT_ALL_BY_DIAGNOSIS_AND_DATE = "SELECT p.first_name,
							 	p.address, p.phone, r.test_date
						FROM radiology_record r, persons p
						WHERE p.person_id = r.patient_id 
						AND r.diagnosis = :diagnosis 
						AND r.test_date >= TO_DATE(':start_date')
						AND r.test_date <= TO_DATE(':end_date')";

	const SELECT_ALL = "SELECT p.first_name,
							 	p.address, p.phone, r.test_date
						FROM radiology_record r, persons p
						WHERE p.person_id = r.patient_id ";

	const INSERT = "INSERT INTO radiology_record (patient_id,
					doctor_id, radiologist_id, test_type, 
					prescribing_date, test_date, diagnosis,
					description)
					VALUES (:patient_id, :doctor_id,
					:radiologist_id, :test_type, TO_DATE(:prescribing_date, 'YYYY-MM-DD'),
					TO_DATE(:test_date, 'YYYY-MM-DD'), :diagnosis, :description)";

	const LAST_INSERT_ID = "SELECT record_seq.currval FROM dual";


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
				throw $e;
			}
		}
	}

	public static function selectByDiagnosisAndDate($diagnosis, $start_date, $end_date) {
		$db = getPDOInstance();

		$query_string = RadiologyRecord::SELECT_ALL;
		$delimiter = " AND ";

		if($diagnosis != "") {
			$query_string .= $delimiter;
			$query_string .= "r.diagnosis = :diagnosis";

		} 
		if($start_date != "") {

			$query_string .= $delimiter;
			$query_string .= "r.test_date >= TO_DATE(:start_date, 'YYYY-MM-DD')";

		} 
		if($end_date != "") {
			$query_string .= $delimiter;
			$query_string .= "r.test_date <= TO_DATE(:end_date, 'YYYY-MM-DD')";
		}


		$query = oci_parse($db, $query_string);

		if($diagnosis != ""){
			oci_bind_by_name($query, ":diagnosis", $diagnosis);
		}
		
		if($start_date != ""){
			oci_bind_by_name($query, ":start_date", $start_date);
		}
		
		if($end_date != ""){
			oci_bind_by_name($query, ":end_date", $end_date);
		}
		
		oci_execute($query);

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	private function insert() {
		$db = getPDOInstance();
		$query = oci_parse($db, RadiologyRecord::INSERT);

		oci_bind_by_name($query, ":patient_id", $this->patient_id);
		oci_bind_by_name($query, ":doctor_id", $this->doctor_id);
		oci_bind_by_name($query, ":radiologist_id", $this->radiologist_id);
		oci_bind_by_name($query, ":test_type", $this->test_type);
		oci_bind_by_name($query, ":test_date", $this->test_date);
		oci_bind_by_name($query, ":prescribing_date", $this->prescribing_date);
		oci_bind_by_name($query, ":diagnosis", $this->diagnosis);
		oci_bind_by_name($query, ":description", $this->description);

		oci_execute($query);

		$query = oci_parse($db, RadiologyRecord::LAST_INSERT_ID);
		oci_execute($query);

		$row = oci_fetch_row($query);

		print_r($row);

		$this->record_id = $row[0];
	}

	private function selectFromId() {
		$db = getPDOInstance();
		$query = oci_parse($db, RadiologyRecord::SELECT_BY_ID);

		oci_bind_by_name($query, ":record_id", $this->record_id);
		oci_execute($query);


		$row = oci_fetch_object($query);

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