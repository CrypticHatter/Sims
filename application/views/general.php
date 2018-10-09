<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- Bootstrap time Picker -->
 <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#schedule" data-toggle="tab">Admin users</a></li>
		<li><a href="#new_schedule" data-toggle="tab">New Admin user</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane" id="schedule">
			 <table id="example1" class="table table-bordered table-striped">
				<thead>
				<tr>
				  <th>Name</th>
				  <th>Email</th>
				  <th>Gender</th>
				  <th>Status</th>
				  <th class='text-center'>Actions</th>
				</tr>
				</thead>
				<tbody>
					<?php
						foreach ($admins as $key => $admin) {
							if($admin->status == 1){
								$status = "<span class='label label-success'>Active</span>";
								$btn = "<button type='button' class='btn btn-sm btn-danger action' data-action='0'>Deactivate</button>";
							}else{
								$status = "<span class='label label-danger'>Inactive</span>";
								$btn = "<button type='button' class='btn btn-sm btn-success action' data-action='1'>Activate</button>";
							}
							echo "<tr>
										<td>{$admin->firstname} {$admin->lastname}</td>
										<td>{$admin->email}</td>
										<td>$admin->gender</td>
										<td>{$status}</td>
										<td class='text-center' data-id='{$admin->id}'>
											{$btn}
											<a href='#edit-modal' data-toggle='modal' class='btn btn-sm btn-primary edit'>Update</a>
										</td>
									</tr>";
						}
					?>
				</tbody>
			</table>
		</div>
		<div class="tab-pane" id="new_schedule">
			<form id="admin-form" role="form" onsubmit="return false;">
				<input type="hidden" name="role" value="staff">
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
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" name="address"></textarea>	
					</div>
					<div class="row">
						<div class="col-sm-3">
							<div class="form-group">
								<label>Gender</label><br>
								<label class="radio-inline">
									<input type="radio" name="gender" value="male" id="male"> Male
								</label>
								<label class="radio-inline">
									<input type="radio" name="gender" value="female" id="female"> Female
								</label>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="email" placeholder="Your Email">
							</div>
						</div>
						<div class="col-sm-3">
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
	                <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
			</form>
		</div>
	</div>
</div>

<div id="edit-modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
	<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h4 class="modal-title">Admin Members</h4>
	</div>
	
	<form id="admin-edit-form" onsubmit="return false;">
		<div class="modal-body">
		<input type="hidden" name="id">
		<input type="hidden" name="role" value="staff">
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
		<div class="form-group">
			<label>Email</label>
			<input type="email" class="form-control" name="email" placeholder="Your Email">
		</div>
		<div class="form-group">
			<label>Address</label>
			<input type="text" class="form-control" name="address" placeholder="Address line 1">
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>City</label>
					<input type="text" class="form-control" name="city" placeholder="City">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
					<label>Province</label>
					<select name="province" class="form-control">
						<?php
							foreach ($this->config->item('provinces') as $key => $value) {
								echo "<option name='{$key}'>{$value}</option>";
							}
						?>
					</select>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<div class="form-group">
					<label>Gender</label><br>
					<label class="radio-inline">
						<input type="radio" name="gender" value="male" id="male"> Male
					</label>
					<label class="radio-inline">
						<input type="radio" name="gender" value="female" id="female"> Female
					</label>
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
		<div class="modal-footer">
			<button type="submit" class="btn btn-primary">Submit</button>
			<button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
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

	//Timepicker
    $(".timepicker").timepicker({
      showInputs: false
    });
	
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});
	$("#example1").DataTable({
	 "aoColumnDefs" : [
	 {
	   'bSortable' : false,
	   'aTargets' : [4]
	 }]
	});

	$('#admin-form').on('submit', function(e){
		e.preventDefault();
		ObjCommon.postCall('settings/adminRegister',  $(this).serialize(), true);
	});
	
	$('a.edit').on('click', function(){
		ObjCommon.getCall('settings/getAdminById/'+$(this).closest('td').attr('data-id'), function(data){
			$.each(data, function( index, value ) {
				if(index != 'gender')
					$('#admin-edit-form').find('[name="'+index+'"]').val(value);
				else
					$('#admin-edit-form').find('#'+value).iCheck('check');
			});
			$('#admin-edit-form').off();
			$('#admin-edit-form').on('submit', function(e){
				e.preventDefault();
				ObjCommon.postCall('settings/adminUpdate',  $(this).serialize()+'&id='+data.id, true);
			});
		});
	});

	$('button.action').on('click', function(){
		ObjCommon.postCall('settings/adminAccess',  {'id':$(this).closest('td').attr('data-id'),'status':$(this).attr('data-action')}, true);
	});

	$('.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('classroom/delete/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});
});
</script>