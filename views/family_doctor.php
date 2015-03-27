<html>

<?php 

$title = "Create or Edit Family Doctor";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>

	<div class="content">
		<?php
			if (!empty($message)):
		?>
		
			<div class="failure">
				<?= $message ?>
			</div>
		
		<?php
			endif;
		?>

		<?php include("views/edit_family_doctor.php"); ?>
		
	</div>

	<?php include("footer.php"); ?>

</body>
</html>