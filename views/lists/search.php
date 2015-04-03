<?php include_once('misc/form_utils.php'); ?>
<?php include_once('models/pacs_image.php'); ?>
<form action="" method="GET">

	<?php echo  
		textInput('Search', 
			RadiologyRecord::SEARCH_TERM, 
			$search_term,
			256,
			"ifSearchTerm(this)"); 
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
	<?php echo 
		selectItems('Sorted By',
			RadiologyRecord::ORDER,
			array_keys(RadiologyRecord::$SEARCH_ORDERS),
			$search_order); 

	?>
	<input type="submit" name="<?php echo  RadiologyRecord::SEARCH; ?>" value="Search" />
</form>		

<script type="text/javascript">
	function ifSearchTerm(search_term) {
		var selectRelevance = document.querySelectorAll("option[value=Relevance]")[0];
		selectRelevance.style.display = search_term.value == "" ? 'none' : 'block';
		if(search_term.value == ""){
			var select = document.querySelectorAll("select")[0];
			if(select.options[select.selectedIndex] == 0) {
				select.options[select.selectedIndex]++;
			}
		}
	}
	
	var selectRelevance = document.querySelectorAll("option[value=Relevance]")[0];
	selectRelevance.style.display = <?php echo $search_term == "" ? '"none"' : '"block"'; ?>;
	var select = document.querySelectorAll("select")[0];
	if(select.options[select.selectedIndex] == 0) {
		select.options[select.selectedIndex]++;
	}

</script>

</div>
<div class="light-separator"></div>

<?php if(sizeof($records) == 0): ?>
	<div class="error">Sorry no records were found!</div>
<?php else: ?>

<table class="records">
	<th>
		Record ID
	</th>
	
	<th>
		Patient
	</th>
	
	<th>
		Doctor
	</th>
	
	<th>
		Radiologist
	</th>

	<th>
		Test Type
	</th>

	<th> 
		Prescribing Date
	</th>

	<th>
		Test Date
	</th>

	<th>
		Diagnosis
	</th>

	<th>
		Description
	</th>

	<th>
		Thumbnail List
	</th>
	<?php foreach($records as $record ): $record = (object) $record?>
		
		<tr>
			<td>
				<?php echo  $record->RECORD_ID; ?>
			</td>

			<td>
				<?php echo  $record->PATIENT_FIRST_NAME . ' ' . $record->PATIENT_LAST_NAME.' - '.$record->PATIENT_ID; ?>
			</td>
			<td>
				<?php echo  $record->DOCTOR_FIRST_NAME . ' ' . $record->DOCTOR_LAST_NAME.' - '.$record->DOCTOR_ID; ?>
			</td>
			<td>
				<?php echo  $record->RADIOLOGIST_FIRST_NAME . ' ' . $record->RADIOLOGIST_LAST_NAME.' - '.$record->RADIOLOGIST_ID; ?>
			</td>
			<td>
				<?php echo  $record->TEST_TYPE; ?>
			</td>
			<td>
				<?php echo  $record->PRESCRIBING_DATE; ?>
			</td>

			<td>
				<?php echo  $record->TEST_DATE; ?>
			</td>

			<td>
				<?php echo  $record->DIAGNOSIS; ?>
			</td>
			<td>
				<?php echo  $record->DESCRIPTION; ?>
			</td>
			<td>
				<?php 
					foreach(explode(',', $record->IMAGES) as $image_id) {
						echo PACSImage::getThumbnail($image_id, PACSImage::THUMBNAIL); 
					} 
				?>
			</td>
		</tr>

	<?php endforeach; ?>

</table>
<?php endif; ?>
