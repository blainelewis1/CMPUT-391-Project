<div id="header">
	<h1>
		 Radiology Information System
	</h1>
	<!-- TODO: This will not work from subfolders.. Oh well? -->
	
	<?php if(isset($user)): ?>
		<a href="logout.php">logout</a>
		<span class="username">
		<?= $user->getUserName() ?>
		</span>
	<?php endif; ?>

	<?php include("navigation.php") ?>

</div>