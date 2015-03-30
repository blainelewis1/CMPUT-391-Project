<?php include('misc/form_utils.php'); ?>

<form action="" method="GET">

	<?php echo 
		dateInput('Start Date',
			RadiologyRecord::TEST_START_DATE,
			$start_date);
	?>

	<?php echo 
		dateInput('End Date',
			RadiologyRecord::TEST_END_DATE,
			$end_date);
	?>
	

	<input type="submit" name="<?php echo  RadiologyRecord::SEARCH; ?>" value="Search" />
</form>

<div class="button">Drill down</div>
<div class="button">Drill Up</div>

<div class="button">Rotate</div>

<table>
	
</table>