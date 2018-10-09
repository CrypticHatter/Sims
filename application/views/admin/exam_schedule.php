<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- Bootstrap time Picker -->
 <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
 <!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#schedule" data-toggle="tab">Exam Schedule</a></li>
		<li><a href="#new_schedule" data-toggle="tab">New Schedule</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane" id="schedule">
			 <table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr>
					<th>Exam Name</th>
					<th>Year</th>
		 			<th>Classroom</th>
		 			<th>Status</th>
		  			<th>Duration</th>
				  	<th class='text-center'>Actions</th>
				</tr>
				</thead>
				<tbody>
				<?php
					foreach ($exams as $exam) {
						$status = ($exam->complete == 1)?"<label class='label label-primary'>Completed</label>":"<label class='label label-success'>Active</label>";
						$btn = ($exam->complete == 0)?"<button class='btn btn-sm btn-success complete'>Complete</button>":"";
						echo "<tr>
								<td><a href='admin/exam/$exam->id'>$exam->title</a></td>
								<td>$exam->year</td>
								<td>$exam->class_title - $exam->division</td>
								<td>$exam->start / $exam->end</td>
								<td>$status</td>
								<td class='text-center' data-id='$exam->id'>
									<div class='btn-group'>
									$btn
									<a href='admin/exam/$exam->id' class='btn btn-sm btn-primary'><i class='fa fa-edit'></i></a>
									<button class='btn btn-sm btn-danger delete'><i class='fa fa-times'></i></button>
									</div>
								</td>
							</tr>";
					}
				?>
				</tbody>
				<tfoot>
				<tr>
				  	<th>Exam Name</th>
				  	<th>Year</th>
		 			<th>Classroom</th>
		 			<th>Status</th>
		  			<th>Duration</th>
				  	<th class='text-center'>Actions</th>
				</tr>
				</tfoot>
			</table>
		</div>
		<div class="tab-pane" id="new_schedule">
			<div class="row">
			<div class="col-sm-10 col-sm-offset-1">
			<form id="examination-form">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Schedule Name</label>
							<input type="text" name="title" class="form-control">
							<span class="help-text">Session of the academic year</span>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Classroom</label>
							<select class="form-control select2" name="classroom[]" multiple="multiple" id="class-list" data-placeholder="Select Classes" style="width: 100%;">
								<?php
									foreach ($classes as $class) {
										echo "<option value='$class->id' $selected>$class->title - $class->division</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label" for="date">Date Range:</label>
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control pull-right" name="daterange" >
					</div>
				</div>
				<div id="dynamic_fields">
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<button type='button' class='btn btn-sm btn-success new-line'>
							<i class='fa fa-plus'></i> New Line</button>
						</div>
						<div class="col-sm-6">
							<button type="submit" class="btn btn-primary pull-right">Create Schedule</button>
						</div>
					</div>
				</div>
			</form>
			</div>
			</div>
		</div>
	</div>
</div>

<div id="classModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Classroom</h4>
      </div>
      <form id="class-form" role="form" onsubmit="return false;">
			<div class="box-body">
				<div class="form-group">
					<div class="row">
						<div class="col-sm-4">
							<label>Title</label>
							<select name="title" class="form-control">
								<option value="Grade 5">Grade 5</option>
								<option value="Grade 6">Grade 6</option>
								<option value="Grade 7">Grade 7</option>
								<option value="Grade 8">Grade 8</option>
								<option value="Grade 9">Grade 9</option>
								<option value="Grade 10">Grade 10</option>
								<option value="Grade 11">Grade 11</option>
							</select>
						</div>
						<div class="col-sm-3">
							<label>Division</label>
							<select name="division" class="form-control">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
							</select>
						</div>
						<div class="col-sm-5">
							<label>Teacher</label>
							<select class="form-control" name="teacher">
								<?php
									foreach ($teachers as $teacher) {
										echo "<option value='{$teacher->id}'>{$teacher->firstname} {$teacher->lastname}</option>";
									}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Desctiption</label>
					<textarea rows="3" name="description" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<label>Subjects</label>
					<select class="form-control select2" name="subjects[]" multiple="multiple" data-placeholder="Select a Subject" style="width: 100%;">
						<?php
							foreach ($subjects as $subject) {
								echo "<option value='{$subject->id}'>{$subject->title}</option>";
							}
						?>
					</select>
				</div>
			</div>
			<div class="box-footer">
				<button type="submit" class="btn btn-primary pull-right">Submit data</button>
			</div>
		</form>
    </div>

  </div>
</div>


<div id="deleteModal" class="modal modal-danger fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete</h4>
      </div>
      <div class="modal-body">
		<div class="form-group">
			<label>Do you really want to delete this record?</label>
		</div>
      </div>
	  <div class="modal-footer">
		<button type="button" class="btn btn-primary" id="delete-btn">Yes</button>
		<button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
	  </div>
    </div>

  </div>
</div>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<script>
function dynamic(){
	$('.delete-sub').click(function(){
		$(this).closest('div.form-group').remove();
	});

	$(".timepicker").timepicker({
      showInputs: false
    });
}
$(function () {
	//Initialize Select2 Elements
    $(".select2").select2({
		placeholder: 'Select an option'
	});

	

	$("#example1").DataTable({
	 "aoColumnDefs" : [
	 {
	   'bSortable' : false,
	   'aTargets' : [ 2 ]
	 }]
	});

	$('input[name="daterange"]').daterangepicker(
	{
	    locale: {
	      format: 'YYYY/MM/DD'
	    }
	}, 
	function(start, end, label) {
		var key = 0;
	  	 ObjCommon.postCall('admin/subjectsByClass', {start:start.format('YYYY-MM-DD'), end:end.format('YYYY-MM-DD'), key:key,class:$('#class-list').val()}, false, function(data){
			$('#dynamic_fields').html(data);
		    dynamic();
		});
	  	$('.new-line').off();
	  	$('.new-line').on('click', function(){
	  		key=key+1;
			ObjCommon.postCall('admin/subjectsByClass', {start:start.format('YYYY-MM-DD'), end:end.format('YYYY-MM-DD'),key:key,class:$('#class-list').val()}, false, function(data){
				$('#dynamic_fields').append(data);
				dynamic();
			});
		});

	});
	
	$('button.edit').on('click', function(){
		ObjCommon.getCall('classroom/getById/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data.class, function( index, value ) {
				$('#class-form').find('[name="'+index+'"]').val(value);
			});
			$(".select2").val(data.subjects);
			$(".select2").select2();
			$('#class-form').off();
			$('#class-form').on('submit', function(){
				ObjCommon.postCall('classroom/update',  $(this).serialize()+'&id='+data.class.id, true);
			});
		});
	});
	
	$('#create-btn').on('click', function(){
		$('#class-form').on('submit', function(){
			ObjCommon.postCall('admin/createSchedule',  $(this).serialize(), false);
		});
	});


	$('#examination-form').on('submit', function(e){
		e.preventDefault();
		ObjCommon.postCall('admin/createSchedule', $(this).serialize(), true);
	});
	
	$('.delete').on('click', function(){
		var elem = $(this).closest('td');
		$('#deleteModal').modal('show');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('admin/deleteSchedule/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});

	$('.complete').on('click', function(){
		ObjCommon.getCall('admin/completeSchedule/'+$(this).closest('td').attr('data-id'), function(data){
			ObjCommon.setSuccessMsgReload(data);
		});
	});

	$('.reset').on('click', function(){
		ObjCommon.getCall('admin/resetSchedule/'+$(this).closest('td').attr('data-id'), function(data){
			ObjCommon.setSuccessMsgReload(data);
		});
	});


});
</script>