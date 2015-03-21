<form action="" method="POST">
	<div class="row">

		<div class="label">
			<label>First Name: </label>
		</div>

		<input type="text" autofocus name="<?= Person::FIRST_NAME; ?>" value="<?= isset($person->first_name) ? $person->first_name : '' ?>" />	
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