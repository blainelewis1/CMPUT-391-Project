<select name="<?php echo  $patient ?>">
	<?php foreach($people  as $person): $person = (object) $person; ?>
		<option 
		<?php echo  $person->PERSON_ID == $person_id ? "selected" : "";?>
		value="<?php echo  $person->PERSON_ID; ?>">
			<?php echo  $person->PERSON_ID.' - '.$person->FIRST_NAME.', '.$person->LAST_NAME; ?>
		</option>
	<?php endforeach; ?>
</select>