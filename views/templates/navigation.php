<?php 
/*
	Shows navigation links

	Takes $user as a parameter to determine visiblities of each page
*/
if(isset($user)): 
?>


<div id="nav">

<ul>

	<?php if($user->isAdmin(false)): ?>

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

	<?php if($user->isRadiologist(false)): ?>

	<li>
 		<h2>
			<a href="record.php">Uploading</a>
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