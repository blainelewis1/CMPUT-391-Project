<?php
/*
	Takes $user as a parameter to link to the user_setting page

	Shows the nav etc.
*/
?>

<div id="header">

	<a href="/~blaine1">
		<h1>
			 Radiology Information System
		</h1>
	</a>
	
	<div id="login">

		<?php if(isset($user)): ?>
			<div class="username">
				<a href="user_settings.php">
					<?php echo  $user->getUserName() ?>
					<image width="15" src="/~blaine1/images/gear.png" />
				</a>
			</div>
			<a href="logout.php">(logout)</a>
		<?php endif; ?>

	</div>
	<div id="help">
	<a href="help.php?page=<?php echo strtolower(str_replace(" ", "", $title));?>">
	help
	</a>
	</div>

	<?php include("navigation.php") ?>

	<div class="separator"></div>

</div>