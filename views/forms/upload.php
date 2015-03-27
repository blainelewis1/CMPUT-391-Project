<?php
	if (!empty($message)):
?>

	<div class="failure">
		<?= $message ?>
	</div>

<?php
	endif;
?>

<form method="post" action="" enctype="multipart/form-data">

	<input type="file" name="<?= PACSImage::IMAGE ?>" />

	<input type="submit" name="<?= PACSImage::SUBMIT_ANOTHER ?>" value="Submit Another">
	<input type="submit" name="<?= PACSImage::SUBMIT ?>" value="Submit and Finish">
</form>