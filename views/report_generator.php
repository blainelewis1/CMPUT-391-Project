<div id="personal_information">

	<?php include("views/diagnosis_form.php"); ?>
		
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

	<?php foreach($records as $record ): ?>
		
		<tr>
			<td>
				<?= $record->first_name; ?>
			</td>

			<td>
				<?= $record->address; ?>
			</td>

			<td>
				<?= $record->phone; ?>
			</td>
			<td>
				<?= $record->test_date; ?>
			</td>
		</tr>

	<?php endforeach; ?>

</table>
<?php endif; ?>