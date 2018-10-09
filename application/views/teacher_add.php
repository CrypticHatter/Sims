<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/select2.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>

<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>

  <!-- Select2 -->
<script src="./plugins/select2/select2.full.min.js"></script>
    <!-- general form elements -->
	<div class="box box-primary">
		<div class="box-header with-border">
			<h3 class="box-title">Personal details</h3>
		</div>
		<!-- /.box-header -->
		 <!-- form start -->
		<form id="admission-form" role="form" onsubmit="return false;">
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
							<label>Address</label>
							<input type="text" class="form-control" name="address" placeholder="Address line 1">	
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>City</label>
							<input type="text" class="form-control" name="city" placeholder="City">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Province</label>
							<input type="text" class="form-control" name="province" placeholder="Province">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Email</label>
							<input type="email" class="form-control" name="email" placeholder="Your Email">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label>Salary</label>
							<input type="text" class="form-control" name="salary" placeholder="Salary">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label>Phone Number</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								<input type="text" class="form-control" name="phone" data-inputmask='"mask": "999-9999999"' data-mask>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right">Submit admission form</button>
			</div>
		</form>
	</div>
<script>
$(function () {
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});
	$("[data-mask]").inputmask();
	//Initialize Select2 Elements
	$(".select2").select2();

	$('#admission-form').on('submit', function(){
		ObjCommon.postCall('teacher/register', $(this).serialize(), true);
	});
});
</script>