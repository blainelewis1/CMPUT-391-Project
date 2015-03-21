	<form action="" method="POST">

	<?php
			 if($editting_user->isNew()): ?>

	<div class="row">
		<div class="label">
			<label>Person: </label>
		</div>

		<?php
			$person_id = $editting_user->person_id;
			include('select_person.php');
		?>


	</div>

	<?php endif; ?>

	
	<div class="row">

		<div class="label">
			<label>Username: </label>
		</div>

		<input type="text" name="<?= User::USER_NAME; ?>" value="<?= isset($editting_user->user_name) ? $editting_user->user_name : '' ?>" />	
	</div>

	<div class="row">

		
		<div class="label">
			<label>Class: </label>
		</div>

		<select name="<?= User::CLASS_NAME; ?>">

		  <option <?= $editting_user->class == "p" ? "selected" : "";?> value="p">
		  	Patient
		  </option>
		  <option <?= $editting_user->class == "d" ? "selected" : "";?> value="d">
		  	Doctor
		  </option>
		  <option <?= $editting_user->class == "r" ? "selected" : "";?> value="r">
		  	Radiologist
		  </option>
		  <option <?= $editting_user->class == "a" ? "selected" : "";?> value="a">
		  	Admin
		  </option>
		</select>

		<?php if($editting_user->isNew()): ?>
			<div class="row">
				<div class="label">
					<label>Password: </label>
				</div>	

				<input type="password" name="<?= User::PASSWORD; ?>" />	
			</div>
		<?php endif; ?>
	
	</div>

	<input type="submit" name="<?= User::SUBMIT; ?>" value="Submit" />

	<?php if(!$editting_user->isNew()) include('change_password.php') ?>


</form>