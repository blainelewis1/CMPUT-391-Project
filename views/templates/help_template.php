<html>

<?php 

/*
	Takes a filename $content to include the main part of the view

	Uses other views that require $user be set

	$title also must be set

	Acts as a template for all other pages
*/

include("head.php");

?>

<body>
	<?php include("header.php"); ?>
	<?php include("help_header.php"); ?>

	<div id="content">
		<?php include($content); ?>
	</div>

<?php include("footer.php"); ?>


</body>
</html>