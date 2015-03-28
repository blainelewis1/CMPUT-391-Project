<div id="personal_information">

<?php include('misc/form_utils.php'); ?>
<form action="" method="GET">

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
</div>
<div class="light-separator"></div>

<?php if(sizeof($records) == 0): ?>
	<div class="failure">Sorry no records were found!</div>
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
				<?= $record->FIRST_NAME; ?>
			</td>

			<td>
				<?= $record->ADDRESS; ?>
			</td>

			<td>
				<?= $record->PHONE; ?>
			</td>
			<td>
				<?= $record->TEST_DATE; ?>
			</td>
		</tr>

	<?php endforeach; ?>

</table>
<?php endif; ?>