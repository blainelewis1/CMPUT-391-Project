<html>

<?php 

$title = "Hub";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>

	<div id="content">
		<?php
			if ($failed):
		?>
			<div class="failure">
				Incorrect username or password
			</div>
		<?php
			endif;
		?>

		<form action="login.php" method="POST">
			
			<label>Username: </label>

			<input type="text" name="username" value="<?= $username ?>" />	

			<label>Password: </label>
			
			<input type="password" name="password" />

			<input type="submit" name="submit" value="submit" />

		</form>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>