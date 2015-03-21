<html>

<?php 

$title = "User Management";

include("head.php");

?>

<body>

	<?php include("header.php"); ?>

	<div id="content">
	
	<h3>
		<a href="edit_person.php">
			Create User
		</a>
	</h3>

	<table class="users">
		<th>
			First Name
		</th>
		<th>
			Last Name
		</th>
		<th>
			Accounts
		</th>
		<th>
			Edit
		</th>
		<!-- TODO: is delete required? 
		<th>
			Delete
		</th>
		-->

		<?php foreach($people as $person ): ?>
			
			<tr>
				<td>
					<?= $person->person_id; ?>
				</td>

				<td>
					<?= $person->first_name; ?>
				</td>

				<td>
					<?= $person->last_name; ?>
				</td>

				<td>
					<?php 
					$classes = explode(",", $person->class_names);
					$user_names = explode(",", $person->user_names);
					
					for($i = 0; $i < sizeof($classes); $i++) {
						
						print($user_names[$i].'('.$classes[$i].')');
						
						if($i != sizeof($classes) - 1) {
							print(",");
						}

					}

					?>
				</td>

				<td>
					<a href="edit_person.php?<?= Person::PERSON_ID.'='.$person->person_id; ?>">
						edit
					</a>
				</td>
				<!-- TODO: is delete required 
				<td>
					<a href="user_management.php?<?= Person::DELETE.'='.$person->person_id; ?>">
						delete
					</a>
				</td>
				-->
			</tr>

		<?php endforeach; ?>

	</table>

	</div>

	<?php include("footer.php"); ?>

</body>
</html>