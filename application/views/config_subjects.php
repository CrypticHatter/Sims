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
    <h3 class="box-title">All subjects in the college</h3>
	<a href="#subjectModal" data-toggle="modal" id="create-btn" class="btn btn-primary pull-right">Add New</a>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    <table id="example1" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>Title</th>
          <th>Short Code</th>
          <th class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php
          foreach ($subjects as $subject) {
            echo  " <tr>
						<td>{$subject->title}</td>
						<td>{$subject->short_code}</td>
						<td class='text-center'>
							<div class='btn-group' data-id='{$subject->id}'>
								<button type='button' data-toggle='modal' data-target='#subjectModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
								<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-xs btn-danger delete'><i class='fa fa-times'></i></button>
							</div>
						</td>
                    </tr>";
          }
        ?>
      </tbody>
      <tfoot>
		<tr>
			<th>Title</th>
			<th>Short Code</th>
			<th class="text-center">Actions</th>
		</tr>
      </tfoot>
    </table>
  </div>
  <!-- /.box-body -->
</div>

<!-- Modal -->
<div id="subjectModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">subject Details</h4>
			</div>
			<div class="modal-body">
				<form id="subject-form" onsubmit="return false;">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Title</label>
								<input type="text" class="form-control" name="title" placeholder="Title">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Short Code</label>
								<input type="text" class="form-control" name="short_code" placeholder="Short Name">
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea rows="4" name="description" class="form-control" placeholder="Subject description"></textarea>
					</div>
					<div class="form-group form-actions">
						<button type="submit" class="btn btn-primary pull-right">Submit</button>
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</form>
			</div>
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
	
	$('#create-btn').on('click', function(){
		$('#subject-edit').attr('id', 'subject-form');
		$('#subject-form')[0].reset();
		$('#subject-form').on('submit', function(){
			ObjCommon.postCall('settings/createSubject',  $(this).serialize(), true);
		});
	});
	
	$('button.edit').on('click', function(){
		$('#subject-form').attr('id', 'subject-edit');
		ObjCommon.getCall('settings/getSubjectById/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data, function( index, value ) {
				$('#subject-edit').find('[name="'+index+'"]').val(value);
			});
			$('#subject-edit').off();
			$('#subject-edit').on('submit', function(){
				ObjCommon.postCall('settings/updateSubject',  $(this).serialize()+"&id="+data.id, true);
			});
		});
	});
	
	$('.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('settings/deleteSubject/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});
});
</script>