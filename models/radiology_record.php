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
	const SEARCH_TERM = "search_term";
	const THUMBNAIL_LIST = "thumbnail_list";

	const SUBMIT = "submit";
	const SEARCH = "search";

	public static $ANALYZE_OPTIONS = array("Test Type", "Patient", "Test Date");


	public static $DRILL_LEVELS = array("Week", "Month", "Year");

	public static $DRILL_VALUES = array("Week" => "IW", "Month" => "Month", "Year" => "YYYY");


	public static $ANALYZE_COLUMNS = array("Test Type" => "test_type", 
		"Patient" => "patient_id", 
		"Test Date" => "to_char(to_date(test_date), 'drill_level')");


	const ANALYZE_LEVEL = "analyze_level";
	const DRILL_LEVEL = "drill_level";


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

	const SELECT_SEARCH = "SELECT *
							FROM radiology_record r JOIN 
							 pacs_images p ON r.record_id = p.record_id";

#select record_id, LISTAGG(image_id, ',') WITHIN GROUP (ORDER BY image_id) "images"  FROM pacs_images GROUP BY record_id

						
	const INSERT = "INSERT INTO radiology_record (patient_id,
					doctor_id, radiologist_id, test_type, 
					prescribing_date, test_date, diagnosis,
					description)
					VALUES (:patient_id, :doctor_id,
					:radiologist_id, :test_type, TO_DATE(:prescribing_date, 'YYYY-MM-DD'),
					TO_DATE(:test_date, 'YYYY-MM-DD'), :diagnosis, :description)";

	const LAST_INSERT_ID = "SELECT record_seq.currval FROM dual";

	const SELECT_ROLLUP = "SELECT columns, COUNT(*) 
							FROM radiology_record JOIN 
							pacs_images ON radiology_record.record_id = pacs_images.record_id 
							GROUP BY ROLLUP (columns)
							ORDER BY COUNT(*) DESC";
						 #WHERE test_date <= :end_date AND test_date >= start_date

	/*const SELECT_CUBE = "SELECT patient_id, test_type, COUNT(*) 
						 FROM radiology_record JOIN pacs_images ON radiology_record.record_id = pacs_images.record_id
						 GROUP BY CUBE (patient_id, test_type)";*/

 //display the number of images for each patient ,  test type, and/or period of time




// patient_id, test_type
// patient_id, test_date
// test_type, test_date
	
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

	public static function analyze($columns, $drill_level) {
		
		$db = getPDOInstance();
		
		$query_string = str_replace('columns', implode(", ", $columns), RadiologyRecord::SELECT_ROLLUP);
		$query_string = str_replace('drill_level', $drill_level, $query_string);


		print($query_string);

		$query = oci_parse($db, $query_string);

		oci_execute($query);

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
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
	
	
	public static function selectBySearch($search_term, $start_date, $end_date){
		$db = getPDOInstance();
		
		$query_string = RadiologyRecord::SELECT_SEARCH;
		$delimiter = " AND ";

		//if($search_term != "") {
			//$query_string .= $delimiter;
		//} 
		if($start_date != "") {

			$query_string .= $delimiter;
			$query_string .= "r.test_date >= TO_DATE(:start_date, 'YYYY-MM-DD')";

		} 
		if($end_date != "") {
			$query_string .= $delimiter;
			$query_string .= "r.test_date <= TO_DATE(:end_date, 'YYYY-MM-DD')";
		}


		$query = oci_parse($db, $query_string);

		if($search_term != ""){
			oci_bind_by_name($query, ":search_term", $search_term);
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
		$this->record_id = $row->RECORD_ID;
		$this->patient_id = $row->PATIENT_ID;
		$this->doctor_id = $row->DOCTOR_ID;
		$this->radiologist_id = $row->RADIOLOGIST_ID;
		$this->test_type = $row->TEST_TYPE;
		$this->prescribing_date = $row->PRESCRIBING_DATE;
		$this->test_date = $row->TEST_DATE;
		$this->diagnosis = $row->DIAGNOSIS;
		$this->description = $row->DESCRIPTION;
	}
}

?>
