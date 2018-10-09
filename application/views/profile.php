<div class="row">
	<div class="col-md-3">

	  <!-- Profile Image -->
	  <div class="box box-primary">
		<div class="box-body box-profile">
		  <img class="profile-user-img img-responsive img-circle" src="./dist/img/user4-128x128.jpg" alt="User profile picture">

		  <h3 class="profile-username text-center"><?php echo $this->session->userdata('name'); ?></h3>

		  <p class="text-muted text-center"><?php echo $this->session->role; ?></p>

		  <ul class="list-group list-group-unbordered">
			<li class="list-group-item">
			  <b>Birthday</b> <a class="pull-right"><?php echo date('dS F Y', strtotime($admin->dob)); ?></a>
			</li>
			<li class="list-group-item">
			  <b>Gender</b> <a class="pull-right"><?php echo $admin->gender==1?'Male':'Female'; ?></a>
			</li>
			<li class="list-group-item">
			  <b>Joined</b> <a class="pull-right"><?php echo date('dS F Y', strtotime($admin->created)); ?></a>
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
			<form id="my-profile" onsubmit="return false;">
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
						<div class="col-sm-5">
							<label>Email</label>
							<input type="email" name="email" class="form-control" placeholder="Email" value="<?php echo $admin->email; ?>">
						</div>
						<div class="col-sm-4">
							<div class="form-group">
								<label>Birthday</label>
								<div class="input-group date">
									<div class="input-group-addon">
										<i class="fa fa-calendar"></i>
									</div>
									<input type="text" class="form-control pull-right datepicker" name="dob" value="<?php echo $admin->dob;?>">
								</div>
							</div>
						</div>
						<div class="col-sm-3">
							<label>Gender</label>
							<select class="form-control" name="gender">
								<option selected disabled>Select Gender</option>
								<option value="1" <?php echo ($admin->gender == 1)?'selected':''; ?>>Male</option>
								<option value="2" <?php echo ($admin->gender == 2)?'selected':''; ?>>Female</option>
							</select>
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
			<form id="change-pass-form">
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
  		$('#my-profile').on('submit', function(e){
  			e.preventDefault();
  			ObjCommon.postCall('user/updateProfile', $(this).serialize(), false);
  		});

  		$('#change-pass-form').on('submit', function(e){
  			e.preventDefault();
  			ObjCommon.postCall('user/changePassword', $(this).serialize(), true);
  		});

  	});
  </script>