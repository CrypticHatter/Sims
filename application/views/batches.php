<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
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
			<th>Batch</th>
			<th>Start</th>
			<th>End</th>
			<th class='text-center'>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($batches as $batch) {
			if($batch->active == 1)
				$btn = "disabled";
			else
				$btn = "";
            echo  " <tr>
                      <td>{$batch->title}</td>
                      <td>{$batch->start}</td>
                      <td>{$batch->end}</td>
                      <td class='text-center'>
						<div class='btn-group' data-id='{$batch->id}'>
							<button type='button' title='Activate' class='btn btn-sm btn-success activate {$btn}'><i class='fa fa-power-off'></i></button>
							<button type='button' title='Edit' data-toggle='modal' data-target='#classModal' class='btn btn-sm btn-primary edit'><i class='fa fa-edit'></i></button>
							<button type='button' title='Delete' data-toggle='modal' data-target='#deleteModal' class='btn btn-sm btn-danger delete'><i class='fa fa-times'></i></button>
						</div>
					  </td>
                    </tr>";
          }
        ?>
      </tbody>
      <tfoot>
        <tr>
			<th>Batch</th>
			<th>Start</th>
			<th>End</th>
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
        <h4 class="modal-title">Batch/Year</h4>
      </div>
      <form id="batch-form" class="form-borderd" role="form" onsubmit="return false;">
			<div class="box-body">
				<div class="form-group">
					<label>Title</label>
					<input type="text" name="title" id="title" class="form-control">
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label>Start Date</label>
							<input type="text" class="form-control datepicker" name="start" id="start" value="<?php echo date('Y-m-d'); ?>">
						</div>
						<div class="col-sm-6">
							<label>End Date</label>
							<input type="text" class="form-control datepicker" name="end" id="end">
						</div>
					</div>
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
<script>
$(function () {
	//Date picker
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});
	
	$("#example1").DataTable({
	 "aoColumnDefs" : [
	 {
	   'bSortable' : false,
	   'aTargets' : [ 3 ]
	 }]
	});
	
	$('button.edit').on('click', function(){
		ObjCommon.getCall('settings/getBatchByID/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data, function( index, value ) {
				$('#batch-form').find('[name="'+index+'"]').val(value);
			})
			$('#batch-form').off();
			$('#batch-form').on('submit', function(){
				ObjCommon.postCall('settings/batchUpdate',  $(this).serialize()+'&id='+data.id, true);
			});
		});
	});
	
	$('#create-btn').on('click', function(){
		$('#batch-form').on('submit', function(){
			ObjCommon.postCall('settings/batchRegister',  $(this).serialize(), true);
		});
	});
	
	$('button.activate').on('click', function(){
		var elem = $(this);
		ObjCommon.getCall('settings/batchActivate/'+ elem.closest('div.btn-group').attr('data-id'), function(data){
			ObjCommon.setSuccessMsg(data);
			$('button.activate').removeClass('disabled');
			elem.addClass('disabled');
		});
	});
	
	$('.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('settings/batchDelete/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});
});
</script>