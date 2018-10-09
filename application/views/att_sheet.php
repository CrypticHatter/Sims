<link rel="stylesheet" type="text/css" href="plugins/datatables/extensions/Buttons/css/buttons.dataTables.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/select2.min.css">
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#by-class" data-toggle="tab">Report by day</a></li>
		<li><a href="#by-student" data-toggle="tab"> Report by date range</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane" id="by-class">
			
			<form id="by-class-form" class="form-horizontal" onsubmit="return false;">
			
				<div class="box-body">
					<div class="form-group">
						<label class="control-label col-sm-2">Select Class:</label>
						<div class="col-sm-3"> 
							<select class="form-control select2" name="class" id="class-id" style="width:100%;height:34px;">
								<option value="0">All Classes</option>
								<?php
									foreach($classes as $class){
										echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
									}
								?>
							</select>
						</div>
						<label class="control-label col-sm-2" for="date">Attendance Date:</label>
						<div class="input-group date col-sm-3">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" name="date" id="datepicker" value="<?php echo date('Y-m-d'); ?>">
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right">Get Results</button>
				</div>
			</form>
			
			<table id="att-table" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Std id</th>
						<th>Name</th>
						<th>Class</th>
						<th>Email</th>
						<th class='text-center'>Status</th>
					</tr>
				</thead>
				<tbody id="attendace-data">
				
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="by-student">
			<form id="by-std-form" class="form-horizontal" onsubmit="return false;">
				<div class="box-body">
					<div class="form-group">
						<label class="control-label col-sm-3">Select Class:</label>
						<div class="col-sm-5"> 
							<select class="form-control select2" name="class" style="width:100%;height:34px;">
								<option value="0">All Classes</option>
								<?php
									foreach($classes as $class){
										echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
									}
								?>
							</select>
						</div>

						<div class="col-sm-4">
							<button type="submit" class="btn btn-primary">Get Results</button>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-3" for="date">Date Range:</label>
						<div class="input-group date col-sm-5">
							<div class="input-group-addon">
								<i class="fa fa-calendar"></i>
							</div>
							<input type="text" class="form-control pull-right" name="daterange" >
						</div>
					</div>
				</div>
			</form>
			<table id="report-gen" class="table table-bordered table-striped">
				<thead></thead>
				<tbody></tbody>
			</table>
		</div>
	</div>
</div>

<script>
$(document).ready(function(){
	//Initialize Select2 Elements
	$('.select2').select2({
	  placeholder: 'Select an option'
	});

	//Date range picker
    $('#reservation').daterangepicker();
		
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});

	$('input[name="daterange"]').daterangepicker(
	{
	    locale: {
	      format: 'YYYY/MM/DD'
	    },
	    startDate: '<?php echo date('Y-m-d', strtotime("-3 days")); ?>',
    	endDate: '<?php echo date('Y-m-d'); ?>',
    	maxDate: '<?php echo date('Y-m-d', strtotime("1 days")); ?>'
	});

	$('#class-select').on('change', function(){
		ObjCommon.getCall('admin/getStudentsByClass/'+$(this).val(), function(data){
			$('#student-list').html(data);
		});
	});

	$('#by-class-form').on('submit', function(){
		 $('#att-table').DataTable().destroy();
		 //$('#att-table').empty();
		ObjCommon.postCall('admin/attendanceByClass', $(this).serialize(), false, function(data){
			$('#attendace-data').html(data);
			$('#att-table').DataTable({
				dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' );
                                
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                        }
                    },
                    'colvis',
					{
		                extend: 'excelHtml5',
		                title: 'Attendance detail report'
		            }
                    
                ]
			});
		});
	});

	$('#by-std-form').on('submit', function(){
		if (!$('#report-gen').find('thead').is(':empty'))
		  $('#report-gen').DataTable().destroy();
		ObjCommon.postCall('admin/attendanceReport', $(this).serialize(), false, function(data){
			$('#report-gen').find('thead').html(data.thead);
			$('#report-gen').find('tbody').html(data.tbody);
			$('#report-gen').DataTable({
				scrollX: true,
				dom: 'Bfrtip',
                buttons: [
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        },
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' );
                                
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', 'inherit' );
                        }
                    },
                    'colvis',
                    {
		                extend: 'excelHtml5',
		                title: 'Attendance detail report'
		            }
                ]
			});
		});
	});
});
</script>