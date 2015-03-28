<?php
include('misc/form_utils.php'); 
include('form_error.php');
include_once('models/person.php');
?>
<form action="" method="POST">


	<?php echo 
	    selectPerson('Patient',
	    	RadiologyRecord::PATIENT_ID, 
		Person::getAllByClass(Person::PATIENT), 
		$record->patient_id); 
	?>

	<?php echo 
	    selectPerson('Doctor',
		    RadiologyRecord::DOCTOR_ID, 
			Person::getAllByClass(Person::DOCTOR), 
			$record->doctor_id); 
	?>

	<?php echo  
		selectPerson('Radiologist',
			RadiologyRecord::RADIOLOGIST_ID, 
			Person::getAllByClass(Person::RADIOLOGIST), 
			$record->radiologist_id); 
	?>

	<?php echo  
		textInput('Test Type', 
			RadiologyRecord::TEST_TYPE, 
			$record->test_type,
			24); 
	?>


	<?php echo  
		dateInput('Prescribing Date', 
			RadiologyRecord::PRESCRIBING_DATE, 
			$record->prescribing_date); 
	?>

	<?php echo  
		dateInput('Test Date', 
			RadiologyRecord::TEST_DATE, 
			$record->test_date); 
	?>

	<?php echo  
		textInput('Diagnosis', 
			RadiologyRecord::DIAGNOSIS, 
			$record->diagnosis,
			128); 
	?>

	<?php echo  
		textArea('Description', 
			RadiologyRecord::DESCRIPTION, 
			$record->description,
			1024); 
	?>
	<input type="submit" name="<?php echo  RadiologyRecord::SUBMIT; ?>" value="Submit" />
</form>