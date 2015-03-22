<html>

<?php 

$title = "User Settings";

include("views/head.php");

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

			<?php include("views/edit_person.php"); ?>
			
			<hr />
			
			<?php include('views/change_password.php'); ?>
		</div>

	</div>

	<?php include("views/footer.php"); ?>

</body>
</html>