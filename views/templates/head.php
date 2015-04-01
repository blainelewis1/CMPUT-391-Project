<?php
/*
	Takes a $title and sets it as the page title

	Also includes the css
*/
?>

<head>
	<title>
		<?php echo isset($title) ? $title: "TITLE NOT SET" ?>
	</title>

	<link rel="stylesheet" type="text/css" href="/~blaine1/style/main.css" />
</head>