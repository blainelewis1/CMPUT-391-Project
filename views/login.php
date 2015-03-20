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

		<form action="login.php" method="POST">
			
			<label>Username: </label>

			<input type="text" name="username" value="<?= isset($username) ? $username : '' ?>" />	

			<br />

			<label>Password: </label>
			
			<input type="password" name="password" />

			<input type="submit" name="submit" value="submit" />

		</form>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>