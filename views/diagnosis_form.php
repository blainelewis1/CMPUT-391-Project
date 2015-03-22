<?php include('form_utils.php'); ?>
<form action="" method="POST">

	<?= 
		textInput('Diagnosis', 
			RadiologyRecord::DIAGNOSIS, 
			$diagnosis); 
	?>

	<?=
		dateInput('Start Date',
			RadiologyRecord::TEST_START_DATE,
			$start_date);
	?>

	<?=
		dateInput('End Date',
			RadiologyRecord::TEST_END_DATE,
			$end_date);
	?>
	

	<input type="submit" name="<?= RadiologyRecord::SEARCH; ?>" value="Search" />
</form>