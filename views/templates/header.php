<div id="header">
	<!-- TODO: won't work with ~blaine1 prefix -->
	<a href="/">
		<h1>
			 Radiology Information System
		</h1>
	</a>
	<!-- TODO: This will not work from subfolders.. Oh well? -->
	
	<div id="login">

		<?php if(isset($user)): ?>
			<span class="username">
				<a href="user_settings.php">
					<?= $user->getUserName() ?>
				</a>
			</span>
			<a href="logout.php">(logout)</a>
		<?php endif; ?>

	</div>

	<?php include("navigation.php") ?>

	<div class="separator"></div>

</div>