
<?php if(isset($user)): ?>
<div id="nav">
<ul>
 	<li>
		<a href="user_settings.php">User</a>
	</li>
	
	<?php if($user->isAdmin()): ?>

	<li>
		<a href="manage_users.php">User Management</a>
	</li>
	
	
	<li>
		<a href="report_generating.php">Report Generating</a>
	</li>
	
	<li>
		<a href="data_analysis.php">Data Analysis</a>
	</li>

	<?php endif; ?>

	<?php if($user->isRadiologist()): ?>

	<li>
		<a href="uploading.php">Uploading</a>
	</li>

	<?php endif; ?>
	
	<li>
		<a href="search.php">Search</a>
	</li>
</div>
<?php endif; ?>