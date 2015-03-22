<?php
include_once("views/form_utils.php");
include_once('models/person.php');
?>
<form action="" method="POST">


	<?=
	    selectPerson('Patient',
	    	RadiologyRecord::PATIENT_ID, 
		Person::getAllByClass(Person::PATIENT), 
		$record->patient_id); 
	?>

	<?=
	    selectPerson('Doctor',
		    RadiologyRecord::DOCTOR_ID, 
			Person::getAllByClass(Person::DOCTOR), 
			$record->doctor_id); 
	?>

	<?= 
		selectPerson('Radiologist',
			RadiologyRecord::RADIOLOGIST_ID, 
			Person::getAllByClass(Person::RADIOLOGIST), 
			$record->radiologist_id); 
	?>

	<?= 
		textInput('Test Type', 
			RadiologyRecord::TEST_TYPE, 
			$record->test_type); 
	?>


	<?= 
		dateInput('Prescribing Date', 
			RadiologyRecord::PRESCRIBING_DATE, 
			$record->prescribing_date); 
	?>

	<?= 
		dateInput('Test Date', 
			RadiologyRecord::TEST_DATE, 
			$record->test_date); 
	?>

	<?= 
		textInput('Diagnosis', 
			RadiologyRecord::DIAGNOSIS, 
			$record->diagnosis); 
	?>

	<?= 
		textArea('Description', 
			RadiologyRecord::DESCRIPTION, 
			$record->description); 
	?>
	<input type="submit" name="<?= RadiologyRecord::SUBMIT; ?>" value="Submit" />
</form>