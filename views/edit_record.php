<?php
include_once("views/form_utils.php");
include_once('models/person.php');
?>
<form action="" method="POST">


	<?=
	    selectPerson('Patien',
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
		textInput('Test Type', 
			RadiologyRecord::TEST_TYPE, 
			$record->test_type); 
	?>
	<?= 
		textInput('Test Type', 
			RadiologyRecord::TEST_TYPE, 
			$record->test_type); 
	?>
	<?= 
		textInput('Test Type', 
			RadiologyRecord::TEST_TYPE, 
			$record->test_type); 
	?>
	<?= 
		textInput('Test Type', 
			RadiologyRecord::TEST_TYPE, 
			$record->test_type); 
	?>
</form>