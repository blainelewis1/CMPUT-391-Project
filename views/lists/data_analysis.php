<?php include('misc/form_utils.php'); ?>

<form action="" method="GET">
	<?php echo checkboxes('Analyze', 
			RadiologyRecord::ANALYZE_LEVEL,
			array_keys(RadiologyRecord::$ANALYZE_COLUMNS),
			$columnNames, 
			"ifDate(this)");
	?>

	<?php echo selectItems('Drill To',
				RadiologyRecord::DRILL_LEVEL,
				array_keys(RadiologyRecord::$DRILL_VALUES),
				$drill_level);
	?>
	<input type="submit" name="<?php echo RadiologyRecord::SEARCH;?>" value="Search" />
</form>

<script type="text/javascript">
	function ifDate(checkbox) {
		if(checkbox.value == "Test Date"){
			var select = document.getElementsByName("<?php echo RadiologyRecord::DRILL_LEVEL; ?>")[0];
			select.parentNode.style.visibility = checkbox.checked ? "false" : "true";
		}
	}
	
	var select = document.getElementsByName("<?php echo RadiologyRecord::DRILL_LEVEL; ?>")[0];
	select.disabled = <?php echo in_array("Test Date", $columnNames) ? '"false"' : '"false"';?>;

</script>

<?php if(sizeof($rows) == 0): ?>
	<div class="error">Sorry no totals were found!</div>
<?php else: ?>

<table>

	<?php foreach($columnNames as $columnName): ?>
		<th><?php echo $columnName;?></th>
	<?php endforeach; ?>

	<?php foreach($rows as $row): ?>
		<tr>
			<?php foreach($row as $column): ?>
				<td><?php echo $column; ?></td>
			<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>

</table>

<?php endif; ?>