<?php if(isset($user)): ?>
<div id="nav">
<ul>
 	<!-- TODO: bold or identify the page you are on now -->

 	<!--
 	<li>
 		<h2>
			<a href="user_settings.php">User</a>
		</h2>
	</li>
	-->

	<?php if($user->isAdmin()): ?>

	<li>
 		<h2>
			<a href="manage_users.php">User Management</a>
		</h2>
	</li>
	
	
	<li>
	 	<h2>
			<a href="report_generating.php">Report Generating</a>
		</h2>
	</li>
	
	<li>
 		<h2>
			<a href="data_analysis.php">Data Analysis</a>
		</h2>
	</li>

	<?php endif; ?>

	<?php if($user->isRadiologist()): ?>

	<li>
 		<h2>
			<a href="edit_record.php">Uploading</a>
		</h2>
	</li>

	<?php endif; ?>
	
	<li>
 		<h2>
			<a href="search.php">Search</a>
		</h2>
	</li>
</div>
<?php endif; ?>