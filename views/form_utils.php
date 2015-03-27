

<?php 

//TODO: these can all be collapsed

function selectPerson($label, $name, $people, $default) { ?>
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

function textInput($label, $name, &$default, $maxlength=24){ ?>
<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<input type="text" name="<?= $name; ?>" maxlength="<?= $maxlength ?>" value="<?= $default ?>" />
</div>
<?php } 

function numberInput($label, $name, &$default){ ?>
<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<input type="number" name="<?= $name; ?>" value="<?= $default ?>" />
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

function textArea($label, $name, &$default, $maxlength=1024){ ?>

<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<textarea maxlength="<?= $maxlength ?>" name="<?= $name; ?>"><?= $default ?></textarea>
</div>
<?php } 

function passwordInput($label, $name, &$default, $maxlength=24){ ?>

<div class="row">
	<div class="label">
		<label><?= $label.':' ?></label>
	</div>
<input type="password" name="<?= $name; ?>" value="<?= $default ?>" />
</div>
<?php } ?>