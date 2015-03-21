<html>

<?php 

$title = "User Settings";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>

	<div id="content">

		<?php
			if (!empty($message)):
		?>
		
			<div class="failure">
				<?= $message ?>
			</div>
		
		<?php
			endif;
		?>

		<div id="personal_information">

			<!-- TODO: autofocus the errored field -->

				<?php include("edit_person.php"); ?>
			
				<hr />
			<form action="" method="POST">

				<div class="row">
					<div class="label">
						<label>Password: </label>
					</div>

					<input type="password" name="<?= User::PASSWORD; ?>" />	
				</div>
				<input type="submit" name="<?= User::CHANGE_PASSWORD; ?>" value="Change Password" />

			</form>
		</div>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>