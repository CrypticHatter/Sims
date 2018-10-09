
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- InputMask -->
<script src="plugins/input-mask/jquery.inputmask.js"></script>
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<div class="nav-tabs-custom">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#all-students" data-toggle="tab">All Students</a></li>
		<li><a href="#register" data-toggle="tab"><i class='fa fa-plus-circle fa-lg'></i> Register Student</a></li>
	</ul>
	<div class="tab-content">
		<div class="active tab-pane" id="all-students">
			<form id="search" role="form">
				<div class="box-body">
					<div class="form-group">
						<div class="row">
						<div class="col-sm-3">
						<label>ID</label>
						<input type="number" class="form-control" name="id" placeholder="Student ID">
						</div>
						<div class="col-sm-3">
						<label>Name</label>
						<input type="text" class="form-control" name="name" placeholder="Name">
						</div>
						<div class="col-sm-3">
						<label>Classroom</label>
						<select class="form-control" name="class">
							<option value="">-- Select One --</option>
							<?php
								foreach ($classes as $class) {
									echo "<option value='$class->id'>$class->title - $class->division</option>";
								}
							?>
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
						<th>Birthday</th>
						<th>Email</th>
						<th>Address</th>
						<th>Classroom</th>
						<th>Actions</th>
			        </tr>
			      </thead>
			      <tbody>
			        <?php
			        	foreach ($students as $row) {
				  			echo "<tr>
				  						<td>$row->id</td>
				  						<td><a href='./student/$row->id'>$row->firstname $row->lastname</a></td>
				  						<td>$row->dob</td>
				  						<td>$row->email</td>
				  						<td>$row->address</td>
				  						<td>$row->classroom</td>
				  						<td>
				  							<div class='btn-group' data-id='{$row->id}'>
											<button type='button' data-toggle='modal' data-target='#studentModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
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
						<th>Birthday</th>
						<th>Email</th>
						<th>Address</th>
						<th>Classroom</th>
						<th>Actions</th>
			        </tr>
			      </tfoot>
			    </table>
			</div>
		</div>
		<div class="tab-pane" id="register">
			<form id="admission-form" role="form" onsubmit="return false;">
				<div class="box box-primary">
					<div class="box-header with-border">
					<h3 class="box-title">Personal details</h3>
					</div>
					<!-- /.box-header -->
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
					                <label>Select Classroom</label>
					                <select class="form-control select2" name="class_id" style="width: 100%;">
					                	<?php
					                		foreach ($classes as $class) {
					                			echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
					                		}
					                 	?>
					                </select>
					            </div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Birthday</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										<input type="text" class="form-control pull-right datepicker" name="dob">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="box box-danger">
							<div class="box-header with-border">
								<h3 class="box-title">Contact Details</h3>
							</div>
							<div class="box-body">
								<div class="row">
								<div class="col-sm-8">
								<div class="form-group">
									<label>Email</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-envelope"></i>
										</div>
										<input type="email" class="form-control" name="email">
									</div>
								</div>
								</div>
								<div class="col-sm-4">
								<div class="form-group" name="gphone">
									<label>Telephone</label>
									<div class="input-group">
										<div class="input-group-addon">
											<i class="fa fa-phone"></i>
										</div>
										<input type="text" class="form-control" name="gphone" data-inputmask='"mask": "999-9999999"' data-mask>
									</div>
								</div>
								</div>
								</div>
								<div class="form-group">
									<label>Address</label>
									<textarea class="form-control" name="address"></textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="box box-success">
							<div class="box-header with-border">
								<h3 class="box-title">Guardian Details</h3>
							</div>
							<div class="box-body">
								<div class="form-group">
									<label>Guardian Fullname</label>
									<input type="text" name="gname" class="form-control">
								</div>
								<div class="form-group">
									<div class="row">
									<div class="col-sm-4">
									<label>Relation</label>
									<select class="form-control" name="relation">
										<option value="1">Father</option>
										<option value="2">Mother</option>
										<option value="3">Brother</option>
										<option value="4">Sister</option>
										<option value="5">Uncle</option>
										<option value="6">Aunt</option>
										<option value="7">Other</option>
									</select>
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<label>Guardian Email</label>
											<div class="input-group">
												<div class="input-group-addon">
													<i class="fa fa-envelope"></i>
												</div>
												<input type="email" name="gmail" class="form-control">
											</div>
										</div>
									</div>
									</div>
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
  	</div>
</div>

<!-- Modal -->
<div id="studentModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Update student details</h4>
			</div>
			<div class="modal-body">
				<form id="student-form" onsubmit="return false;">
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
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Select Class</label>
								<select class="form-control select2" name="class_id" style="width: 100%;">
				                	<?php
				                		foreach ($classes as $class) {
				                			echo "<option value='{$class->id}'>{$class->title}-{$class->division}</option>";
				                		}
				                 	?>
				                </select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Birthday</label>
								<div class="input-group date">
									<div class="input-group-addon">
									<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control datepicker pull-right " name="dob">
								</div>
							</div>
						</div>
					</div>
					<div class="form-group">
						<label>Address</label>
						<textarea class="form-control" name="address"></textarea>
					</div>
					<div class="form-group">
						<label>Guardian Fullname</label>
						<input type="text" name="gname" class="form-control">
					</div>
					<div class="form-group">
						<label>Relation</label>
						<select class="form-control" name="relation">
							<option value="1">Father</option>
							<option value="2">Mother</option>
							<option value="3">Brother</option>
							<option value="4">Sister</option>
							<option value="5">Uncle</option>
							<option value="6">Aunt</option>
							<option value="7">Other</option>
						</select>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label>Guardian Phone</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-phone"></i>
									</div>
									<input type="text" class="form-control" name="gphone" data-inputmask='"mask": "999-9999999"' data-mask>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label>Guardian Email</label>
								<div class="input-group">
									<div class="input-group-addon">
										<i class="fa fa-envelope"></i>
									</div>
									<input type="email" name="gmail" class="form-control">
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

<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<script>
function dynamic(){
	$('button.edit').on('click', function(){
		ObjCommon.getCall('admin/getStudentById/'+$(this).closest('div.btn-group').attr('data-id'), function(data){
			$.each(data, function( index, value ) {
				$('#student-form').find('[name="'+index+'"]').val(value);
			})

			//Initialize Select2 Elements
		    $(".select2").select2({
				placeholder: 'Select a classroom'
			});
		});
	});

	$('button.delete').on('click', function(){
		var elem = $(this).closest('div.btn-group');
		$('#delete-btn').off();
		$('#delete-btn').on('click', function(){
			ObjCommon.getCall('admin/deleteStudent/' + elem.attr('data-id'), function(data){
				$('#deleteModal').modal('hide');
				elem.closest('tr').remove();
				ObjCommon.setSuccessMsg(data);
			});
		});
	});
}
$(function () {
	dynamic();
	
	$("[data-mask]").inputmask();
	$("table").DataTable({pageLength:25});

	$('#admission-form').on('submit', function(){
		ObjCommon.postCall('admin/createStudent', $(this).serialize(), true);
	});
	
	

	$('#search').on('submit', function(e){
		e.preventDefault();
		$('#results-table').DataTable().destroy();
		 $('#results-table').find('tbody').empty();
		$.post('admin/studentSearch', $(this).serialize(), function(response){
			$('#results-table').find('tbody').html(response);
			$('#results-table').DataTable({
				"pageLength": 25
			});
			dynamic();
		});
	});
	
	$('#student-form').on('submit', function(){
		ObjCommon.postCall('admin/updateStudent',  $(this).serialize(), true);
	});
});
</script>