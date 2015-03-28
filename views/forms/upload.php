<?php
	if (!empty($message)):
?>

	<div class="failure">
		<?php echo  $message ?>
	</div>

<?php
	endif;
?>

<form method="post" action="" enctype="multipart/form-data">

	<input type="file" name="<?php echo  PACSImage::IMAGE ?>" />

	<input type="submit" name="<?php echo  PACSImage::SUBMIT_ANOTHER ?>" value="Submit Another">
	<input type="submit" name="<?php echo  PACSImage::SUBMIT ?>" value="Submit and Finish">
</form>