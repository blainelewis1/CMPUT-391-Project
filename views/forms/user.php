<?php 
include('misc/form_utils.php'); 
include('form_error.php');
?>

<form action="" method="POST">

	<?php
	 if($editing_user->isNew()) { 

		selectPerson('Person',
			Person::PERSON_ID, 
			Person::getAllPeople(), 
			$editing_user->person_id); 
	}
	?>

	<div class="row">
		<div class="label">
			<label>Class: </label>
		</div>

		<select name="<?php echo  User::CLASS_NAME; ?>">

		  <option <?php echo  $editing_user->class == "p" ? "selected" : "";?> value="p">
		  	Patient
		  </option>
		  <option <?php echo  $editing_user->class == "d" ? "selected" : "";?> value="d">
		  	Doctor
		  </option>
		  <option <?php echo  $editing_user->class == "r" ? "selected" : "";?> value="r">
		  	Radiologist
		  </option>
		  <option <?php echo  $editing_user->class == "a" ? "selected" : "";?> value="a">
		  	Admin
		  </option>
		</select>
	</div>
	<?php echo  
		textInput('Username', 
			User::USER_NAME, 
			$editing_user->user_name,
			24); 
	?>


	<?php if($editing_user->isNew()){
		passwordInput('Password', 
				 User::PASSWORD, 
				 $empty, 
				 24);
		}
	?>
	
	<input type="submit" name="<?php echo  User::SUBMIT; ?>" value="Submit" />
</form>

<?php if(!$editing_user->isNew()) include('change_password.php') ?>
