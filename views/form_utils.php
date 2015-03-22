<?php function selectPerson($label, $name, $people, $default) { ?>
<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<select name="<?= $name ?>">
	<?php foreach($people  as $person): ?>
		<option 
		<?= $person->person_id == $default ? "selected" : "";?>
		value="<?= $person->person_id; ?>">
			<?= $person->person_id.' - '.$person->first_name.', '.$person->last_name; ?>
		</option>
	<?php endforeach; ?>
</select>
</div>
<?php } 

function textInput($label, $name, &$default){ ?>
<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<input type="text" name="<?= $name; ?>" value="<?= $default ?>" />
</div>
<?php } 

function emailInput($label, $name, &$default){ ?>

<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<input type="email" name="<?= $name; ?>" value="<?= $default ?>" />
</div>
<?php } 


function dateInput($label, $name, &$default){ ?>

<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<input type="date" name="<?= $name; ?>" value="<?= $default ?>" />
</div>
<?php } 

function textArea($label, $name, &$default){ ?>

<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<textarea name="<?= $name; ?>"><?= $default ?></textarea>
</div>
<?php } 