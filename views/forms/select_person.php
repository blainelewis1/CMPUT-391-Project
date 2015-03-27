<select name="<?= $patient ?>">
	<?php foreach($people  as $person): ?>
		<option 
		<?= $person->person_id == $person_id ? "selected" : "";?>
		value="<?= $person->person_id; ?>">
			<?= $person->person_id.' - '.$person->first_name.', '.$person->last_name; ?>
		</option>
	<?php endforeach; ?>
</select>