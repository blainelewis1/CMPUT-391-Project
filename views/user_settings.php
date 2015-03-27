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
	
	<div class="light-separator"></div>
	
	<?php include('views/change_password.php'); ?>
</div>