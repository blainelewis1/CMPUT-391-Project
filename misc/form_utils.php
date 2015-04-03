<?php 

//TODO: these can all be collapsed

function selectPerson($label, $name, $people, $default) { ?>
<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<select name="<?php echo  $name ?>">
	<?php foreach($people  as $person): $person = (object) $person; ?>
		<option 
		<?php echo  $person->PERSON_ID == $default ? "selected" : "";?>
		value="<?php echo  $person->PERSON_ID; ?>">
			<?php echo  $person->PERSON_ID.' - '.$person->FIRST_NAME.', '.$person->LAST_NAME; ?>
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
		<label><?php echo  $label.' (YYYY-MM-DD):' ?></label>
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
<?php } 


function selectItems($label, $name, $items, $default) { ?>
<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
<select name="<?php echo  $name ?>">
	<?php foreach($items  as $item): ?>
		<option 
		<?php echo  $item == $default ? "selected" : "";?>
		value="<?php echo  $item; ?>">
			<?php echo  $item; ?>
		</option>
	<?php endforeach; ?>
</select>
</div>
<?php }

function checkboxes($label, $name, $items, $default) { ?>
<div class="row">
	<div class="label">
		<label><?php echo  $label.':' ?></label>
	</div>
	<?php foreach($items  as $item): ?>
		<label><?php echo $item; ?></label>
		<input type="checkbox" name="<?php echo $name; ?>[]" value="<?php echo $item; ?>" <?php echo in_array($item, $default) ? "checked" : "";?> />
		<br />
	<?php endforeach; ?>
</div>
<?php } ?>

