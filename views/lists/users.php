<?php include("views/templates/user_management_sub_nav.php"); ?>

<h3>
	<a href="user.php">
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
	<th></th>

	<?php foreach($users as $user ): $user = (object) $user; ?>
		
		<tr>
			<td>
				<?php echo  $user->PERSON_ID; ?>
			</td>

			<td>
				<?php echo  $user->USER_NAME; ?>
			</td>

			<td>
				<?php echo  $user->CLASS_NAME; ?>
			</td>
			<td>
				<?php echo  $user->DATE_REGISTERED; ?>
			</td>

			<td class="icon">
				<a href="edit_user.php?<?php echo  User::USER_NAME.'='.$user->USER_NAME; ?>">
					<img src="/~blaine1/images/edit.png" />
				</a>
			</td>
			<td class="icon">
				<a href="manage_users.php?<?php echo  User::USER_NAME.'='.$user->USER_NAME; ?>">
					<img src="/~blaine1/images/delete.png" />
				</a>
			</td>
		</tr>

	<?php endforeach; ?>

</table>

<?php endif; ?>