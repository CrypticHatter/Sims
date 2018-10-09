<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/select2.min.css">
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<div class="box">
	<form id="attendance-form" class="form-horizontal" onsubmit="return false;">
		<div class="box-body">
			<div class="form-group">
				<div class="row">
				<label class="control-label col-sm-3" for="date">Attendance Date:</label>
				<div class="input-group date col-sm-5">
					<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</div>
					<input type="text" class="form-control pull-right" name="date" id="datepicker" value="<?php echo date('Y-m-d'); ?>">
				</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-3">Select Class:</label>
				<div class="col-sm-5"> 
					<select class="form-control select2" name="class" id="class-id" style="width:100%;height:34px;">
						<?php
							foreach($classes as $class){
								echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
							}
						?>
					</select>
				</div>
				<div class="col-sm-4">
					<button type="submit" class="btn btn-primary">Get Register</button>
				</div>
			</div>
		</div>
	</form>
</div>
<div class="box">
	<div class="box-body">
		<table id="example1" class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Std id</th>
					<th>Name</th>
					<th>Email</th>
					<th class='text-center'>Attendance</th>
				</tr>
			</thead>
			<tbody id="attendace-data">
			
			</tbody>
		</table>
	</div>
</div>
<script>
function inside()
{
	$('button.mark').on('click',function(){
		var status = $(this).attr('data-type');
		ObjCommon.postCall('admin/markAttendance', {std_id:$(this).closest('div').attr('data-id'), status:status, date: $('#datepicker').val()}, false);
		if(status == 'present')
			$(this).closest('tr').removeClass().addClass('present');
		else if(status == 'absent')
			$(this).closest('tr').removeClass().addClass('absent');
		else
			$(this).closest('tr').removeClass().addClass('leave');
	});
}

$(document).ready(function(){
	//Initialize Select2 Elements
	$('.select2').select2({
	  placeholder: 'Select an option'
	});
		
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});

	$('#attendance-form').on('submit', function(){
		ObjCommon.getCall('admin/getAttendanceByClass/'+ $("#class-id").val(), function(data){
			$('#attendace-data').html(data);
			inside();
		});
	});
});
</script>