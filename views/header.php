<div id="header">
	<h1>
		Radiology thing
	</h1>
	<!-- TODO: This will not work from subfolders.. Oh well? -->
	<a href="logout.php">logout</a>
	<?= isset($_SESSION['USER']) ? $_SESSION['USER'] : "not logged in"; ?>
</div>