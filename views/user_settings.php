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
			
			<?php include('change_password.php'); ?>
		</div>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>