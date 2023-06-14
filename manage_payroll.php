<?php include 'db_connect.php' ?>

<div class="container-fluid">
	<div class="col-lg-12">
		<form id="manage-payroll">
			<div class="form-group">
				<label for="" class="control-label">Employee :</label>
				<!-- <input type = "hidden" name="employee_id"> -->
				<select name="employee" class="custom-select browser-default" id="employee">
					<?php
					$employee_qry = $conn->query("SELECT * FROM employee") or die(mysqli_error($conn));
					while ($row = $employee_qry->fetch_array()) : ?>
						<option> <?php echo $row['lastname'] . ", " . $row['firstname']; ?> </option>
					<?php endwhile;
					?>
				</select>
			</div>
			<input type="hidden" name="id" value="">
			<div class="form-group">
				<label for="" class="control-label mt-4">Date From :</label>
				<input type="date" class="form-control" name="date_from">
			</div>
			<div class="form-group">
				<label for="" class="control-label">Date To :</label>
				<input type="date" class="form-control" name="date_to">
			</div>
			<!-- REMOVE
				<div class="form-group">
					<label for="" class="control-label">Payroll Type :</label>
					<select name="type" class="custom-select browser-default" id="">
						<option value="1">Monthly</option>
						<option value="2">Semi-Monthly</option>
					</select>
				</div>
				 -->
		</form>
	</div>
</div>

<script>
	$('#manage-payroll').submit(function(e) {
		e.preventDefault();
		start_load();
		$.ajax({
			url: 'ajax.php?action=save_payroll',
			method: "POST",
			data: $(this).serialize(),
			error: err => console.log(),
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Payroll successfully saved", "success");
					setTimeout(function() {
						location.reload();
					}, 1000)
				}
			}
		})
	})
</script>