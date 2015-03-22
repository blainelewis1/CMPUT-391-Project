<html>

<?php 

$title = "Report Generating";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>
	<div id="content">
	
	<div id="personal_information">

		<?php include("views/diagnosis_form.php"); ?>
			
	</div>
	<hr />
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

	</div>

	<?php include("footer.php"); ?>

</body>
</html>