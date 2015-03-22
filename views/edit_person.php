<?php include('form_utils.php'); ?>
<form action="" method="POST">

	<?php
		if($person->isNew()){
			textInput('Person ID', 
				Person::PERSON_ID, 
				$person->person_id); 
		}
	?>
	<?= 
		textInput('First Name', 
			Person::FIRST_NAME, 
			$person->first_name); 
	?>
	
	<?= 
		textInput('Last Name', 
			Person::LAST_NAME, 
			$person->last_name); 
	?>
	
	<?= 
		textInput('Address', 
			Person::ADDRESS, 
			$person->address); 
	?>
	
	<?= 
		textInput('Phone', 
			Person::PHONE, 
			$person->phone); 
	?>

	
	<?= 
		emailInput('Email', 
			Person::EMAIL, 
			$person->email); 
	?>


	<input type="submit" name="<?= Person::SUBMIT; ?>" value="Submit" />
</form>