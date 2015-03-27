<?php 
include("misc/form_utils.php")
?>
<?php
	//TODO: adopt message style
	if (isset($failed) && $failed):
?>

	<div class="failure">
		Incorrect username or password
	</div>

<?php
	endif;
?>

<form action="" method="POST">
	
	<?= 
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

	<input type="submit" name="<?= User::LOGIN?>" value="Login!" />

</form>