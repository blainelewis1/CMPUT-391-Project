<?php include('misc/form_utils.php'); ?>

<form action="" method="GET">
	<?php echo checkboxes('Analyze', 
			RadiologyRecord::ANALYZE_LEVEL,
			RadiologyRecord::$ANALYZE_OPTIONS,
			$columnNames);
	?>

	<?php echo selectItems('Drill To',
				RadiologyRecord::DRILL_LEVEL,
				RadiologyRecord::$DRILL_LEVELS,
				$drill_level);
	?>
	<input type="submit" name="<?php echo RadiologyRecord::SEARCH;?>" value="Search" />
</form>

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