<?php 
/*
	takes $username to prefill the field
*/

include("misc/form_utils.php")
?>
<?php
	if (isset($failed) && $failed):
?>

<div class="error">
	Incorrect username or password
</div>

<?php
	endif;
?>

<form action="" method="POST">
	
	<?php echo  
		textInput('Username', 
			User::USER_NAME, 
			$username); 
	?>
	
	<div class="row">

		<div class="label">
			<label>Password: </label>
		</div>	

		<input type="password" name="password" />

		</div>

	<input type="submit" name="<?php echo  User::LOGIN?>" value="Login!" />

</form>