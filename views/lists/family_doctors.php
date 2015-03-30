<?php include("views/templates/user_management_sub_nav.php"); ?>

<?php include("views/forms/form_error.php"); ?>

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

	<?php foreach($family_doctors as $family_doctor): $family_doctor = (object) $family_doctor; ?>
		
		<tr>
			<td>
				<?php echo  $family_doctor->DOCTOR_NAME; ?>
			</td>

			<td>
				<?php echo  $family_doctor->PATIENT_NAME; ?>
			</td>

			<td class="icon">
				<a href="family_doctor.php?<?php echo  FamilyDoctor::PATIENT_ID.'='.$family_doctor->PATIENT_ID.'&'.FamilyDoctor::DOCTOR_ID.'='.$family_doctor->doctor_id; ?>">
					<img src="/~blaine1/images/edit.png" />
				</a>
			</td>
			<td class="icon">
				<a href="manage_family_doctors.php?<?php echo  '&'.FamilyDoctor::PATIENT_ID.'='.$family_doctor->PATIENT_ID.'&'.FamilyDoctor::DOCTOR_ID.'='.$family_doctor->doctor_id; ?>">
					<img src="/~blaine1/images/delete.png" />
				</a>
			</td>
		</tr>

	<?php endforeach; ?>

</table>

<?php endif; ?>