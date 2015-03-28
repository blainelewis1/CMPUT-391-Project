<form action="" method="POST">

	<div class="row">
		<div class="label">
			<label>Password: </label>
		</div>

		<input type="password" name="<?php echo  User::PASSWORD; ?>" />	
	</div>
	<input type="submit" name="<?php echo  User::CHANGE_PASSWORD; ?>" value="Change Password" />
</form>