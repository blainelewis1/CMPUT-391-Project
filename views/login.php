<html>

<?php 

$title = "Login";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>

	<div id="content">
		
		<?php
			if (isset($failed) && $failed):
		?>
		
			<div class="failure">
				Incorrect username or password
			</div>
		
		<?php
			endif;
		?>

		<div id="login">

			<form action="login.php" method="POST">
				<div class="row">

					<div class="label">
						<label>Username: </label>
					</div>

					<input type="text" autofocus name="username" value="<?= isset($username) ? $username : '' ?>" />	
				</div>
				
				<div class="row">

					<div class="label">
						<label>Password: </label>
					</div>	

					<input type="password" name="password" />

					</div>

				<input type="submit" name="submit" value="submit" />

			</form>
		</div>
	</div>

	<?php include("footer.php"); ?>

</body>
</html>