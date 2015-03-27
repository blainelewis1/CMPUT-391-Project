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

	<?php if(sizeof($users) == 0): ?>
		<div class="failure">Sorry no users were found!</div>
	<?php else: ?>

	<table>
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

		<th></th>

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

				<td class="icon">
					<a href="edit_user.php?<?= User::USER_NAME.'='.$user->user_name; ?>">
						<img src="/images/edit.png" />
					</a>
				</td>
				<td class="icon">
					<a href="manage_users.php?<?= User::USER_NAME.'='.$user->user_name; ?>">
						<img src="/images/edit.png" />
					</a>
				</td>
			</tr>

		<?php endforeach; ?>

	</table>

	<?php endif; ?>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>