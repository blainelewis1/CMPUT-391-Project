<?php include('misc/form_utils.php'); ?>

<form action="" method="GET">
	<?php echo checkboxes('Analyze', 
			RadiologyRecord::ANALYZE_LEVEL,
			array_keys(RadiologyRecord::$ANALYZE_COLUMNS),
			$columnNames);
	?>

	<?php echo selectItems('Drill To',
				RadiologyRecord::DRILL_LEVEL,
				array_keys(RadiologyRecord::$DRILL_VALUES),
				$drill_level);
	?>
	<input type="submit" name="<?php echo RadiologyRecord::SEARCH;?>" value="Search" />
</form>

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