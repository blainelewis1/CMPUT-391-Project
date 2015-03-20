<html>

<?php 

$title = "User Settings";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>

	<div id="content">

		<?php
			if (isset($failed) && $failed):
		?>
		
			<div class="failure">
				<?= $message ?>
			</div>
		
		<?php
			endif;
		?>

		<div id="login">

			<!-- TODO: autofocus the errored field -->

			<form action="user_settings.php" method="POST">
				<div class="row">

					<div class="label">
						<label>First Name: </label>
					</div>

					<input type="text" autofocus name="first_name" value="<?= isset($personalInformation->first_name) ? $personalInformation->first_name : '' ?>" />	
				</div>
				
				<div class="row">

					<div class="label">
						<label>Last Name: </label>
					</div>

					<input type="text" name="last_name" value="<?= isset($personalInformation->last_name) ? $personalInformation->last_name : '' ?>" />	
				</div>

				<div class="row">

					<div class="label">
						<label>Address: </label>
					</div>

					<input type="text" name="address" value="<?= isset($personalInformation->address) ? $personalInformation->address : '' ?>" />	
				</div>

				<div class="row">

					<div class="label">
						<label>Phone: </label>
					</div>

					<input type="text" name="phone" value="<?= isset($personalInformation->phone) ? $personalInformation->phone : '' ?>" />	
				</div>
				
				<div class="row">

					<div class="label">
						<label>Email: </label>
					</div>

					<input type="text" name="email" value="<?= isset($personalInformation->email) ? $personalInformation->email: '' ?>" />	
				</div>


				<input type="submit" name="submit" value="Submit" />

				<hr />

				<div class="row">
					<div class="label">
						<label>Password: </label>
					</div>

					<input type="password" name="password" />	
				</div>
				<input type="submit" name="change_password" value="Change Password" />

			</form>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>