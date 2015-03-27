<?php 
include('form_utils.php'); 
include('form_error.php');
?>
<form action="" method="POST">

	<?=
		selectPerson('Doctor',
			FamilyDoctor::DOCTOR_ID, 
			Person::getAllByClass(Person::DOCTOR), 
			isset($family_doctor->doctor_id) ? $family_doctor->doctor_id : "");	
	?>

	<?=
		selectPerson('Patient',
			FamilyDoctor::PATIENT_ID,
			Person::getAllByClass(Person::PATIENT), 
			isset($family_doctor->patient_id) ? $family_doctor->patient_id : ""); 
	?>

	<input type="submit" name="<?= FamilyDoctor::SUBMIT; ?>" value="Submit" />

</form>