<?php 
/*
	Takes a $person to prefill all the fields
*/

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
	<?php echo  
		textInput('First Name', 
			Person::FIRST_NAME, 
			$person->first_name,
			24); 
	?>
	
	<?php echo  
		textInput('Last Name', 
			Person::LAST_NAME, 
			$person->last_name,
			24); 
	?>
	
	<?php echo  
		textArea('Address', 
			Person::ADDRESS, 
			$person->address,
			128); 
	?>
	
	<?php echo  
		textInput('Phone', 
			Person::PHONE, 
			$person->phone,
			10); 
	?>

	
	<?php echo  
		emailInput('Email', 
			Person::EMAIL, 
			$person->email); 
	?>


	<input type="submit" name="<?php echo  Person::SUBMIT; ?>" value="Submit" />
</form>