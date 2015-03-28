<?php include("views/templates/user_management_sub_nav.php"); ?>
<h3>

	<a href="person.php">
		<span class="button">
			Create Person
		</span>
	</a>
</h3>

<?php if(sizeof($people) == 0): ?>
	<div class="failure">Sorry no peoples were found!</div>
<?php else: ?>

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
	<th></th>

	<?php foreach($people as $person ): ?>
		
		<tr>
			<td>
				<?php echo  $person->PERSON_ID; ?>
			</td>

			<td>
				<?php echo  $person->FIRST_NAME; ?>
			</td>

			<td>
				<?php echo  $person->LAST_NAME; ?>
			</td>

			<td class="icon">
				<a href="edit_person.php?<?php echo  Person::PERSON_ID.'='.$person->PERSON_ID; ?>">
					<img src="/~blaine1/images/edit.png" />
				</a>
			</td>
		</tr>

	<?php endforeach; ?>

</table>

<?php endif; ?>