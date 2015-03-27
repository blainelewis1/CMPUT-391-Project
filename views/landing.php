<h3>
	<a href="user_settings.php">User</a>
</h3>

<?php if($user->isAdmin()): ?>

<h3>
	<a href="user_management.php">User Management</a>
</h3>


<h3>
	<a href="report_generating.php">Report Generating</a>
</h3>

<h3>
	<a href="data_analysis.php">Data Analysis</a>
</h3>

<?php endif; ?>

<?php if($user->isRadiologist()): ?>

<h3>
	<a href="uploading.php">Uploading</a>
</h3>

<?php endif; ?>

<h3>
	<a href="search.php">Search</a>
</h3>