<div id="personal_information">

<?php include('misc/form_utils.php'); ?>
<form action="" method="GET">

	<?php echo  
		textInput('Diagnosis', 
			RadiologyRecord::DIAGNOSIS, 
			$diagnosis); 
	?>

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
</div>
<div class="light-separator"></div>

<?php if(sizeof($records) == 0): ?>
	<div class="error">Sorry no records were found!</div>
<?php else: ?>

<table class="records">
	<th>
		Name
	</th>
	
	<th>
		Address
	</th>
	
	<th>
		Phone Number
	</th>
	
	<th>
		Testing Date
	</th>

	<?php foreach($records as $record ): $record = (object) $record?>
		
		<tr>
			<td>
				<?php echo  $record->FIRST_NAME; ?>
			</td>

			<td>
				<?php echo  $record->ADDRESS; ?>
			</td>

			<td>
				<?php echo  $record->PHONE; ?>
			</td>
			<td>
				<?php echo  $record->TEST_DATE; ?>
			</td>
		</tr>

	<?php endforeach; ?>

</table>
<?php endif; ?>