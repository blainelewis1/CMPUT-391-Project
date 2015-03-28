<?php include("views/templates/user_management_sub_nav.php"); ?>
<h3>
	<a href="family_doctor.php">
		<span class="button">
			Create Family Doctor
		</span>		
	</a>
</h3>

<?php if(sizeof($family_doctors) == 0): ?>
	<div class="failure">Sorry no family doctors were found!</div>
<?php else: ?>

<table>
	<th>
		Doctor
	</th>
	
	<th>
		Patient
	</th>
	
	<th></th>
	
	<th></th>

	<?php foreach($family_doctors as $family_doctor): ?>
		
		<tr>
			<td>
				<?= $family_doctor->doctor_name; ?>
			</td>

			<td>
				<?= $family_doctor->patient_name; ?>
			</td>

			<td class="icon">
				<a href="edit_family_doctor.php?<?= FamilyDoctor::PATIENT_ID.'='.$family_doctor->patient_id.'&'.FamilyDoctor::DOCTOR_ID.'='.$family_doctor->doctor_id; ?>">
					<img src="/images/edit.png" />
				</a>
			</td>
			<td class="icon">
				<a href="manage_family_doctors.php?<?= '&'.FamilyDoctor::PATIENT_ID.'='.$family_doctor->patient_id.'&'.FamilyDoctor::DOCTOR_ID.'='.$family_doctor->doctor_id; ?>">
					<img src="/images/delete.png" />
				</a>
			</td>
		</tr>

	<?php endforeach; ?>

</table>

<?php endif; ?>