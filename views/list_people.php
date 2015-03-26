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

		<a href="edit_person.php">
			<span class="button">
				Create Person
			</span>
		</a>
	</h3>

	<table class="users">
		<th>
			Person ID
		</th>
		<th>
			First Name
		</th>
		<th>
			Last Name
		</th>
		<th>
			Edit
		</th>

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
					<a href="edit_person.php?<?= Person::PERSON_ID.'='.$person->person_id; ?>">
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