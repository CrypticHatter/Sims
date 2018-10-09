<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<div class="box">
  <div class="box-header">
    <h3 class="box-title">All classes in the college</h3>
	<a href="#classModal" data-toggle="modal" id="create-btn" class="btn btn-primary pull-right">Add New</a>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th class='text-center'>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($classes as $class) {
            echo  " <tr>
						<td>{$class->title} - {$class->division}</td>
						<td>{$class->description}</td>
						<td class='text-center'>
							<div class='btn-group' data-id='{$class->id}'>
								<button type='button' data-toggle='modal' data-target='#classModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
								<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-xs btn-danger delete'><i class='fa fa-times'></i></button>
							</div>
						</td>
					</tr>";
          }
        ?>
      </tbody>
    </table>
  </div>
  <!-- /.box-body -->
</div>
<!-- Modal -->

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
						<div class="col-sm-6">
							<label>Grade</label>
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
						<div class="col-sm-6">
							<label>Division</label>
							<select name="division" class="form-control">
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="C">C</option>
								<option value="D">D</option>
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
$(function () {
	//Initialize Select2 Elements
    $(".select2").select2({
		placeholder: 'Select an option'
	});
	
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});
	$("[data-mask]").inputmask();
	$("#example1").DataTable({
	 "aoColumnDefs" : [
	 {
	   'bSortable' : false,
	   'aTargets' : [ 2 ]
	 }]
	});
	
	$('button.edit').on('click', function(){
		ObjCommon.getCall('settings/getClassById/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data.class, function( index, value ) {
				$('#class-form').find('[name="'+index+'"]').val(value);
			});
			$(".select2").val(data.subjects);
			$(".select2").select2();
			$('#class-form').off();
			$('#class-form').on('submit', function(){
				ObjCommon.postCall('settings/updateClass',  $(this).serialize()+'&id='+data.class.id, true);
			});
		});
	});
	
	$('#create-btn').on('click', function(){
		$('#class-form').on('submit', function(){
			ObjCommon.postCall('settings/registerClass',  $(this).serialize(), true);
		});
	});
	
	$('.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('settings/deleteClass/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});
});
</script>