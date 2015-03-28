<?php 
include('misc/form_utils.php'); 
include('form_error.php');
?>
<form action="" method="POST">

	<?php echo 
		selectPerson('Doctor',
			FamilyDoctor::DOCTOR_ID, 
			Person::getAllByClass(Person::DOCTOR), 
			isset($family_doctor->doctor_id) ? $family_doctor->doctor_id : "");	
	?>

	<?php echo 
		selectPerson('Patient',
			FamilyDoctor::PATIENT_ID,
			Person::getAllByClass(Person::PATIENT), 
			isset($family_doctor->patient_id) ? $family_doctor->patient_id : ""); 
	?>

	<input type="submit" name="<?php echo  FamilyDoctor::SUBMIT; ?>" value="Submit" />

</form>