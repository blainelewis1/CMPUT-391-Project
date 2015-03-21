<form action="" method="POST">
	
<?php if($person->isNew()): ?>
	<div class="row">

		<div class="label">
			<label>Person ID: </label>
		</div>

		<input type="text" name="<?= Person::PERSON_ID; ?>" value="<?= isset($person->person_id) ? $person->person_id : '' ?>" />	
	</div>
<?php endif; ?>
	<div class="row">

		<div class="label">
			<label>First Name: </label>
		</div>

		<input type="text" name="<?= Person::FIRST_NAME; ?>" value="<?= isset($person->first_name) ? $person->first_name : '' ?>" />	
	</div>
	
	<div class="row">

		<div class="label">
			<label>Last Name: </label>
		</div>

		<input type="text" name="<?= Person::LAST_NAME; ?>" value="<?= isset($person->last_name) ? $person->last_name : '' ?>" />	
	</div>

	<div class="row">

		<div class="label">
			<label>Address: </label>
		</div>

		<input type="text" name="<?= Person::ADDRESS; ?>" value="<?= isset($person->address) ? $person->address : '' ?>" />	
	</div>

	<div class="row">

		<div class="label">
			<label>Phone: </label>
		</div>

		<input type="text" name="<?= Person::PHONE; ?>" value="<?= isset($person->phone) ? $person->phone : '' ?>" />	
	</div>
	
	<div class="row">

		<div class="label">
			<label>Email: </label>
		</div>

		<input type="text" name="<?= Person::EMAIL; ?>" value="<?= isset($person->email) ? $person->email: '' ?>" />	
	</div>


	<input type="submit" name="<?= Person::SUBMIT; ?>" value="Submit" />
</form>