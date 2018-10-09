<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/select2.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>

<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
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
					<th>Batch</th>
					<th>Fee</th>
					<th class='text-center'>Actions</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($grades as $grade) {
				echo  " <tr>
							<td>{$grade->title}</td>
							<td>{$grade->batch}</td>
							<td>{$grade->fee}</td>
							<td class='text-center'>
							<div class='btn-group' data-id='{$grade->id}'>
							<button type='button' data-toggle='modal' data-target='#classModal' class='btn btn-sm btn-primary edit'><i class='fa fa-edit'></i></button>
							<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-sm btn-danger delete'><i class='fa fa-times'></i></button>
							</div>
							</td>
						</tr>";
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<th>Title</th>
					<th>Batch</th>
					<th>Fee</th>
					<th class='text-center'>Actions</th>
				</tr>
			</tfoot>
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
			<form id="grade-form" role="form" onsubmit="return false;">
				<div class="box-body">
					<div class="form-group">
						<div class="row">
							<div class="col-sm-6">
								<label>Title</label>
								<input type="text" name="title" class="form-control">
							</div>
							<div class="col-sm-6">
								<label>Batch</label>
								<select name="batch" class="form-control" readonly>
									<?php
									foreach($batches as $batch){
									if($batch->id == $this->session->userdata('batch'))
									$prop = "selected";
									else
									$prop = "";

									echo "<option value='{$batch->id}' {$prop}>{$batch->title}</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Term Fee</label>
						<input type="text" name="fee" class="form-control">
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary pull-right">Submit data</button>
				</div>
			</form>
		</div>

	</div>
</div>
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
	   'aTargets' : [ 3 ]
	 }]
	});
	
	$('button.edit').on('click', function(){
		ObjCommon.getCall('settings/getGradeById/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data, function( index, value ) {
				$('#grade-form').find('[name="'+index+'"]').val(value);
			});
			$('#grade-form').off();
			$('#grade-form').on('submit', function(){
				ObjCommon.postCall('settings/gradeUpdate',  $(this).serialize()+'&id='+data.id, true);
			});
		});
	});
	
	$('#create-btn').on('click', function(){
		$('#grade-form').on('submit', function(){
			ObjCommon.postCall('settings/gradeRegister',  $(this).serialize(), true);
		});
	});
	
	$('.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('settings/gradeDelete/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});
});
</script>