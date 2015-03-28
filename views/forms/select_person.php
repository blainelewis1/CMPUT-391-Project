<select name="<?php echo  $patient ?>">
	<?php foreach($people  as $person): ?>
		<option 
		<?php echo  $person->person_id == $person_id ? "selected" : "";?>
		value="<?php echo  $person->person_id; ?>">
			<?php echo  $person->person_id.' - '.$person->first_name.', '.$person->last_name; ?>
		</option>
	<?php endforeach; ?>
</select>