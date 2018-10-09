<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#all-teachers" data-toggle="tab">All Teachers</a></li>
		<li><a href="#teacher-add" data-toggle="tab"><i class='fa fa-plus-circle fa-lg'></i> Register Teacher</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane" id="all-teachers">
			<form id="search" role="form">
				<div class="box-body">
					<div class="form-group">
						<div class="row">
						<div class="col-sm-3">
						<label>ID</label>
						<input type="number" class="form-control" name="id" placeholder="Teacher ID">
						</div>
						<div class="col-sm-3">
						<label>Name</label>
						<input type="text" class="form-control" name="name" placeholder="Teacher Name">
						</div>
						<div class="col-sm-3">
						<label>Gender</label>
						<select class="form-control" name="gender">
							<option value="">-- Select One --</option>
							<opton value='1'>Male</opton>
							<opton value='0'>Female</opton>
						</select>
						</div>
						<div class="col-sm-3">
						<label>Status</label>
						<select class="form-control" name="status">
							<option value="1">Active</option>
							<option value="0">Inactive</option>
						</select>
						</div>
						</div>
					</div>
				</div>
				<div class="box-footer">
					<button type="submit" class="btn btn-primary">Search</button>
					<button type="reset" class="btn btn-default">Reset</button>
				</div>
			</form>
			<div class="box-body">
		    <table id="results-table" class="table table-bordered table-striped">
		      <thead>
		        <tr>
		        	<th>ID</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Gender</th>
					<th>Actions</th>
		        </tr>
		      </thead>
		      <tbody>
		       <?php
		       		foreach ($teachers as $row) {
			  			echo "<tr>
			  						<td><a href='./teacher/$row->id'>$row->id</a></td>
			  						<td>$row->firstname $row->lastname</td>
			  						<td>$row->email</td>
			  						<td>$row->gender</td>
			  						<td>
			  							<div class='btn-group' data-id='{$row->id}'>
										<button type='button' data-toggle='modal' data-target='#teacherModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
										<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-xs btn-danger delete'><i class='fa fa-times'></i></button>
										</div>
									</td>
			  					</tr>";
			  		}
		       ?>
		      </tbody>
		      <tfoot>
		        <tr>
		        	<th>ID</th>
					<th>Full Name</th>
					<th>Email</th>
					<th>Gender</th>
					<th>Actions</th>
		        </tr>
		      </tfoot>
		    </table>
		    </div>
	  	</div>
	  	<div class="tab-pane" id="teacher-add">
	  		<form id="admission-form" role="form" onsubmit="return false;">
				<div class="box-body">
					<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
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
						<div class="col-sm-8">
							<div class="form-group">
								<label>Address</label>
								<input type="text" class="form-control" name="address" placeholder="Full address">	
							</div>
						</div>
						<div class="col-sm-4">
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
						<div class="col-sm-9">
							<div class="form-group">
								<label>Email</label>
								<input type="email" class="form-control" name="email" placeholder="Your Email">
							</div>
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

<!-- Modal -->
<div id="teacherModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Teacher Details</h4>
			</div>
			<div class="modal-body">
				<form id="teacher-form" onsubmit="return false;">
					<input type="hidden" name="id">
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
						<textarea class="form-control" name="address" placeholder="Complete address"></textarea>
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
function dynamic(){
	$('button.edit').on('click', function(){
		ObjCommon.getCall('admin/getTeacherById/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data, function( index, value ) {
				if(index != 'gender')
					$('#teacher-form').find('[name="'+index+'"]').val(value);
				else
					$('#teacher-form').find('#'+value).iCheck('check');
			});
		});
	});

	$('.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('admin/deleteTeacher/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				ObjCommon.setSuccessMsg(data);
				elem.closest('tr').remove();
			});
		});
	});

}
$(function () {
	dynamic();
	//Date picker
	$('#datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});

	$("[data-mask]").inputmask();
	$("table").DataTable({pageLength:25});
	$('#search').on('submit', function(e){
		e.preventDefault();
		$('#results-table').DataTable().destroy();
		 $('#results-table').find('tbody').empty();
		$.post('admin/teacherSearch', $(this).serialize(), function(response){
			$('#results-table').find('tbody').html(response);
			$('#results-table').DataTable({
				"pageLength": 25
			});
			dynamic();
		});
	});

	
	$('#admission-form').on('submit', function(){
		ObjCommon.postCall('admin/createTeacher', $(this).serialize(), true);
	});
	
	$('#teacher-form').on('submit', function(){
		ObjCommon.postCall('admin/updateTeacher',  $(this).serialize(), true);
	});
	
});
</script>