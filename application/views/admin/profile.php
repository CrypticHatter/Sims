<div class="row">
	<div class="col-md-3">

	  <!-- Profile Image -->
	  <div class="box box-primary">
		<div class="box-body box-profile">
		  <img class="profile-user-img img-responsive img-circle" src="./dist/img/user1-128x128.jpg" alt="User profile picture">

		  <h3 class="profile-username text-center"><?php echo $this->session->userdata('name'); ?></h3>

		  <p class="text-muted text-center"><?php echo $this->session->role; ?></p>

		  <ul class="list-group list-group-unbordered">
			<li class="list-group-item">
			  <b>Joined</b> <a class="pull-right"><?php echo date('dS F Y', strtotime($admin->created)); ?></a>
			</li>
			<li class="list-group-item">
			  <b>Role</b> <a class="pull-right"><?php echo $admin->role; ?></a>
			</li>
		  </ul>
		  <label for="inputImage">
		  	<input type="file" name="image" class="hide" id="inputImage">
		  	<button class="btn btn-primary btn-block"><b>Change Image</b></button>
		  </label>
		</div>
		<!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
	<!-- /.col -->
	<div class="col-md-9">
	  <div class="nav-tabs-custom">
		<ul class="nav nav-tabs">
		  <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
		  <li><a href="#change-pass" data-toggle="tab">Change Password</a></li>
		</ul>
		<div class="tab-content">
		  <div class="active tab-pane" id="profile">
			<form id="admin-profile">
				<div class="form-group">
				<div class="row">
					<input type="hidden" name="id" value="<?php echo $admin->id; ?>">
					<div class="col-sm-6">
						<label for="inputName" class="control-label">Firstname</label>
						<input type="text" name="firstname" class="form-control" placeholder="Firstname" value="<?php echo $admin->firstname; ?>">
					</div>
					<div class="col-sm-6">
						<label for="inputName" class="control-label">Lastname</label>
						<input type="text"  name="lastname" class="form-control" placeholder="Lastname" value="<?php echo $admin->lastname; ?>">
					</div>
				</div>
				</div>

				<div class="form-group">
					<div class="row">
						<div class="col-sm-6">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $admin->email; ?>">
						</div>
						<div class="col-sm-3">
							<label>Gender</label>
							<select class="form-control" name="gender">
								<option selected disabled>Select Gender</option>
								<option value="1" <?php echo ($admin->gender == 1)?'selected':''; ?>>Male</option>
								<option value="2" <?php echo ($admin->gender == 2)?'selected':''; ?>>Female</option>
							</select>
						</div>
						<div class="col-sm-3">
							<label>Phone</label>
							<div class="input-group">
								<div class="input-group-addon">
									<i class="fa fa-phone"></i>
								</div>
								<input type="text" class="form-control" name="phone" value="<?php echo $admin->phone; ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label>Address</label>
					<input type="text" name="address" class="form-control" placeholder="Address line" value="<?php echo $admin->address; ?>">
				</div>
				
				<div class="form-group">
					<button type="submit" class="btn btn-danger">Save changes</button>
				</div>
			</form>
		  </div>
		<!-- /.tab-pane -->
		<div class="tab-pane" id="change-pass">
			<form id="admin-change-pass">
				<div class="row">
					<div class="col-sm-8 col-sm-offset-2">
						<div class="form-group">
							<label>Current Password</label>
							<input type="password" name="current_password" class="form-control" placeholder="Enter Current Password">
						</div>
						<div class="form-group">
							<label>New Password</label>
							<input type="password" name="new_password" class="form-control" placeholder="Enter New Password">
						</div>
						<div class="form-group">
							<label>Repeat New Password</label>
							<input type="password" name="confirm_password" class="form-control" placeholder="Confirm New Password">
						</div>
						<div class="form-group">
							<button type="submit" class="btn btn-danger pull-right">Change Password</button>
						</div>
					</div>
				</div>
			</form>
		</div>
		<!-- /.tab-pane -->

		  <div class="tab-pane" id="settings">
			
		  </div>
		  <!-- /.tab-pane -->
		</div>
		<!-- /.tab-content -->
	  </div>
	  <!-- /.nav-tabs-custom -->
	</div>
	<!-- /.col -->
  </div>
  <!-- /.row -->
  <script type="text/javascript">
  	$(document).ready(function(){
  		$('#admin-profile').on('submit', function(e){
  			ObjCommon.postCall('admin/updateProfile', $(this).serialize(), false);
  			e.preventDefault();
  		});

  		$('#admin-change-pass').on('submit', function(e){
  			e.preventDefault();
  			ObjCommon.postCall('admin/changePassword', $(this).serialize(), true);
  		});
  	});
  </script>