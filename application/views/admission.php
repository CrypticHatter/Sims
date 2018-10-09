<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>

<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>

 <!-- form start -->
<form id="admission-form" role="form" onsubmit="return false;">
	<div class="box box-primary">
		<div class="box-header with-border">
		<h3 class="box-title">Personal details</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
					<label>First Name</label>
					<input type="text" class="form-control" name="firstname" placeholder="First Name">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
					<label>Last Name</label>
					<input type="text" class="form-control" name="lastname" placeholder="Last Name">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
		                <label>Select Classroom</label>
		                <select class="form-control select2" name="class_id" style="width: 100%;">
		                	<?php
		                		foreach ($classes as $class) {
		                			echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
		                		}
		                 	?>
		                </select>
		            </div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Birthday</label>
						<div class="input-group date">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" name="dob" id="datepicker">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Contact Details</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Email</label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-envelope"></i>
							</div>
							<input type="email" class="form-control" name="email">
						</div>
					</div>	
					<div class="form-group">
						<label>Address</label>
						<input type="text" class="form-control" name="address">
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>City</label>
								<input type="text" class="form-control" name="city">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Province</label>
								<input type="text" class="form-control" name="province">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">Guardian Details</h3>
				</div>
				<div class="box-body">
					<div class="form-group">
						<label>Guardian Fullname</label>
						<input type="text" name="gname" class="form-control">
					</div>
					<div class="form-group">
						<label>Relation</label>
						<select class="form-control" name="relation">
							<option value="1">Father</option>
							<option value="2">Mother</option>
							<option value="3">Brother</option>
							<option value="4">Sister</option>
							<option value="5">Uncle</option>
							<option value="6">Aunt</option>
							<option value="7">Other</option>
						</select>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group" name="gphone">
								<label>Guardian Phone</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-phone"></i>
									</div>
									<input type="text" class="form-control" name="gphone" data-inputmask='"mask": "999-9999999"' data-mask>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label>Guardian Email</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</div>
									<input type="email" name="gmail" class="form-control">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


	<div class="box-footer">
		<button type="submit" class="btn btn-primary pull-right">Submit admission form</button>
	</div>
</form>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<script>
$(function () {
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});
	$("[data-mask]").inputmask();

	//Initialize Select2 Elements
    $(".select2").select2({
		placeholder: 'Select a classroom'
	});

	$('#admission-form').on('submit', function(){
		ObjCommon.postCall('student/register', $(this).serialize(), true);
	});
});
</script>