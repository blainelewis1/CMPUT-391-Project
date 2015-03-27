<?php
include('misc/form_utils.php'); 
include('form_error.php');
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
			$record->test_type,
			24); 
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
			$record->diagnosis,
			128); 
	?>

	<?= 
		textArea('Description', 
			RadiologyRecord::DESCRIPTION, 
			$record->description,
			1024); 
	?>
	<input type="submit" name="<?= RadiologyRecord::SUBMIT; ?>" value="Submit" />
</form>