<html>

<?php 

$title = "User Management";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>
	<?php include("user_management_sub_nav.php"); ?>
	<div id="content">
	
	<h3>
		<a href="edit_user.php">
			<span class="button">
				Create User
			</span>
		</a>

	</h3>

	<table class="users">
		<th>
			Person ID
		</th>
		
		<th>
			User Name
		</th>
		
		<th>
			Class
		</th>
		
		<th>
			Registration Date
		</th>

		<?php foreach($users as $user ): ?>
			
			<tr>
				<td>
					<?= $user->person_id; ?>
				</td>

				<td>
					<?= $user->user_name; ?>
				</td>

				<td>
					<?= $user->class; ?>
				</td>
				<td>
					<?= $user->date_registered; ?>
				</td>

				<td>
					<a href="edit_user.php?<?= User::USER_NAME.'='.$user->user_name; ?>">
						edit
					</a>
				</td>
			</tr>

		<?php endforeach; ?>

	</table>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>