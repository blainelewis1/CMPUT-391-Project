<?php 

/*
	This class represents a row in radiology_record and gives
	access to selecting, searching, inserting, updating and
	analyzing


	Can be instantiated either normally or using RadiologyRecord::fromId($id)
*/


class RadiologyRecord {
	
	// Constants to be used as GET and POST names
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

	//Data analysis options
	public static $ANALYZE_OPTIONS = array("Test Type", "Patient", "Test Date");

	public static $DRILL_LEVELS = array("Week", "Month", "Year");

	public static $DRILL_VALUES = array("Week" => "IW", "Month" => "Month", "Year" => "YYYY");

	//If test_date is used, drill level MUST be filled in
	public static $ANALYZE_COLUMNS = array("Test Type" => "test_type", 
		"Patient" => "patient_id", 
		"Test Date" => "to_char(to_date(test_date), 'drill_level')");


	const ANALYZE_LEVEL = "analyze_level";
	const DRILL_LEVEL = "drill_level";


	//Various queries

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


	//Searches for records
/*	const SELECT_SEARCH = "SELECT *
							FROM radiology_record r JOIN 
							 pacs_images p ON r.record_id = p.record_id";
*/

const SELECT_SEARCH =
"SELECT radiology_record.record_id, 
	6*(SCORE(3) + SCORE(4)) + 3*SCORE(1) + SCORE(2) myrank, 
	image_agg.images,
	radiologist.first_name radiologist_first_name, radiologist.last_name radiologist_last_name, radiologist.person_id radiologist_id,
	doctor.first_name doctor_first_name, doctor.last_name doctor_last_name, doctor.person_id doctor_id,
	patient.first_name patient_first_name, patient.last_name patient_last_name, patient.person_id patient_id,
	radiology_record.test_type,
	radiology_record.test_date,
	radiology_record.prescribing_date,
	radiology_record.diagnosis,
	radiology_record.description
FROM radiology_record JOIN 
persons doctor ON radiology_record.doctor_id = doctor.person_id JOIN
persons radiologist ON radiology_record.doctor_id = radiologist.person_id JOIN
persons patient ON radiology_record.patient_id = patient.person_id JOIN 
	(SELECT LISTAGG(pacs_images.image_id, ',') WITHIN GROUP (ORDER BY pacs_images.image_id) images, 
			pacs_images.record_id  
		FROM pacs_images 
		GROUP BY pacs_images.record_id
	) image_agg ON image_agg.record_id = radiology_record.record_id 
WHERE (CONTAINS(radiology_record.diagnosis, :diagnosis, 1) > 0 OR 
	CONTAINS(radiology_record.description, :description, 2) > 0 OR 
	CONTAINS(patient.first_name, :first_name, 3) > 0 OR 
	CONTAINS(patient.last_name, :last_name, 4) > 0)
	SECURITY
ORDER BY myrank";

	public static $SEARCH_SECURITY = 
	array("a" => "", 
		"d" => " AND :doctor_id IN (SELECT doctor_id FROM family_doctor WHERE family_doctor.patient_id = radiology_record.patient_id) ", 
		"p" => " AND radiology_record.patient_id = :patient_id ", 
		"r" => " AND radiology_record.radiologist_id = :radiologist_id ");


#select record_id, LISTAGG(image_id, ',') WITHIN GROUP (ORDER BY image_id) "images"  FROM pacs_images GROUP BY record_id

						
	const INSERT = "INSERT INTO radiology_record (patient_id,
					doctor_id, radiologist_id, test_type, 
					prescribing_date, test_date, diagnosis,
					description)
					VALUES (:patient_id, :doctor_id,
					:radiologist_id, :test_type, TO_DATE(:prescribing_date, 'YYYY-MM-DD'),
					TO_DATE(:test_date, 'YYYY-MM-DD'), :diagnosis, :description)";

	//Gets the last insert id
	const LAST_INSERT_ID = "SELECT record_seq.currval FROM dual";


	//For data analysis, columns must be filled in with the columns needed, can't
	//Be passed as params because they are columns
	const SELECT_ROLLUP = "SELECT columns, COUNT(*) 
							FROM radiology_record JOIN 
							pacs_images ON radiology_record.record_id = pacs_images.record_id 
							GROUP BY ROLLUP (columns)
							ORDER BY COUNT(*) DESC";
	
	//These correspond directly to the columns in the table
	public $record_id;
	public $patient_id;
	public $doctor_id;
	public $radiologist_id;
	public $test_type;
	public $prescribing_date;
	public $test_date;
	public $diagnosis;
	public $description;

	//Determines whether we insert or update the record
	private $new;


	//Get a filled in record based on the id
	public static function fromId($record_id) {

		$record = new RadiologyRecord();
		$record->new = false;
		$record->record_id = $record_id;
		$record->selectFromId();

	}

	//Automatically labels as a new record for insertion
	public function __construct() {
		$this->new  = true;	
	}

	//Saves the record as it is to the database either updating or
	//Inserting as needed
	public function savetoDatabase() {

		if($this->new){
			$this->insert();
		} else {
			//Throws exception, currently unsupported
			$this->update();
		}
		return true;
	}


	/*
	 * Given a list of columns to group by and a level to drill down to as shown in the constants
	 * above this returns the number of images for each combination of columns
	 */
	public static function analyze($columns, $drill_level) {
		
		$db = getPDOInstance();
		
		$query_string = str_replace('columns', implode(", ", $columns), RadiologyRecord::SELECT_ROLLUP);
		$query_string = str_replace('drill_level', $drill_level, $query_string);

		$query = oci_parse($db, $query_string);

		oci_execute($query);

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	/*
	 * Selects all records with a test date before start_date, after end_date and with the given diagnosis
	 * Any of these can be empty and it will be ignored 
	*/

	public static function selectByDiagnosisAndDate($diagnosis, $start_date, $end_date) {
		$db = getPDOInstance();

		$query_string = RadiologyRecord::SELECT_ALL;
		$delimiter = " AND ";

		//Because there are optional parameters we need to add them manually

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

		//Only apply parameters if they are set

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
	
	//Please fill me in
	
	public static function selectBySearch($user, $search_term, $start_date, $end_date){
		$db = getPDOInstance();
		
		$query_string = RadiologyRecord::SELECT_SEARCH;

		$query_string = str_replace("SECURITY", RadiologyRecord::$SEARCH_SECURITY[$user->getClass()], $query_string);

		$query = oci_parse($db, $query_string);

		if($user->getClass() == "d"){
			oci_bind_by_name($query, ":doctor_id", $user->person_id);
		}
		if($user->getClass() == "p"){
			oci_bind_by_name($query, ":patient_id", $user->person_id);
		}

		if(trim($user->getClass()) == "r"){
			print($user->person_id);
			oci_bind_by_name($query, ":radiologist_id", $user->person_id, -1, OCI_B_INT);
		}
 
		oci_bind_by_name($query, ":diagnosis", $search_term);
		oci_bind_by_name($query, ":description", $search_term);
		oci_bind_by_name($query, ":first_name", $search_term);
		oci_bind_by_name($query, ":last_name", $search_term);


		oci_execute($query);

		print($query_string);

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;

/*
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
*/		
		oci_execute($query);

		$results;
		oci_fetch_all($query, $results, null, null, OCI_ASSOC + OCI_FETCHSTATEMENT_BY_ROW);
		return $results;
	}

	/*
	 * Inserts the current record into the database, and sets record_id to
	 * the assigned id
	*/

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

	/*
	 *	Selects a record into the object based on the record_id that is set
	 */

	private function selectFromId() {
		$db = getPDOInstance();
		$query = oci_parse($db, RadiologyRecord::SELECT_BY_ID);

		oci_bind_by_name($query, ":record_id", $this->record_id);
		oci_execute($query);


		$row = oci_fetch_object($query);

		populateFromRow($row);

	}

	/*
	 * Given a row from a query it applies all the fields to it
	 */

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
