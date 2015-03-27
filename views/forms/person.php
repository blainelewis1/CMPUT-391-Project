<?php 
include('misc/form_utils.php'); 
include('form_error.php');
?>
<form action="" method="POST">

	<?php
		if($person->isNew()){
			numberInput('Person ID', 
				Person::PERSON_ID, 
				$person->person_id); 
		}
	?>
	<?= 
		textInput('First Name', 
			Person::FIRST_NAME, 
			$person->first_name,
			24); 
	?>
	
	<?= 
		textInput('Last Name', 
			Person::LAST_NAME, 
			$person->last_name,
			24); 
	?>
	
	<?= 
		textArea('Address', 
			Person::ADDRESS, 
			$person->address,
			128); 
	?>
	
	<?= 
		textInput('Phone', 
			Person::PHONE, 
			$person->phone,
			10); 
	?>

	
	<?= 
		emailInput('Email', 
			Person::EMAIL, 
			$person->email); 
	?>


	<input type="submit" name="<?= Person::SUBMIT; ?>" value="Submit" />
</form>