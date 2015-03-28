<?php 

//TODO: these can all be collapsed

function selectPerson($label, $name, $people, $default) { ?>
<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<select name="<?php echo  $name ?>">
	<?php foreach($people  as $person): ?>
		<option 
		<?php echo  $person->person_id == $default ? "selected" : "";?>
		value="<?php echo  $person->person_id; ?>">
			<?php echo  $person->person_id.' - '.$person->first_name.', '.$person->last_name; ?>
		</option>
	<?php endforeach; ?>
</select>
</div>
<?php } 

function textInput($label, $name, &$default, $maxlength=24){ ?>
<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<input type="text" name="<?php echo  $name; ?>" maxlength="<?php echo  $maxlength ?>" value="<?php echo  $default ?>" />
</div>
<?php } 

function numberInput($label, $name, &$default){ ?>
<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<input type="number" name="<?php echo  $name; ?>" value="<?php echo  $default ?>" />
</div>
<?php } 


function emailInput($label, $name, &$default){ ?>

<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<input type="email" name="<?php echo  $name; ?>" value="<?php echo  $default ?>" />
</div>
<?php } 


function dateInput($label, $name, &$default){ ?>

<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<input type="date" name="<?php echo  $name; ?>" value="<?php echo  $default ?>" />
</div>
<?php } 

function textArea($label, $name, &$default, $maxlength=1024){ ?>

<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<textarea maxlength="<?php echo  $maxlength ?>" name="<?php echo  $name; ?>"><?php echo  $default ?></textarea>
</div>
<?php } 

function passwordInput($label, $name, &$default, $maxlength=24){ ?>

<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<input type="password" name="<?php echo  $name; ?>" value="<?php echo  $default ?>" />
</div>
<?php } ?>