<?php 
include('misc/form_utils.php'); 
include('form_error.php');
?>

<form action="" method="POST">

	<?php
	 if($editting_user->isNew()) { 

		selectPerson('Person',
			Person::PERSON_ID, 
			Person::getAllPeople(), 
			$editting_user->person_id); 
	}
	?>

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
	</div>
	<?= 
		textInput('Username', 
			User::USER_NAME, 
			$editting_user->user_name,
			24); 
	?>


		<?php if($editting_user->isNew()){
			passwordInput('Password', 
					 User::PASSWORD, 
					 $user->password, 
					 24);
			}
		?>
	
	<input type="submit" name="<?= User::SUBMIT; ?>" value="Submit" />
</form>

<?php if(!$editting_user->isNew()) include('change_password.php') ?>
