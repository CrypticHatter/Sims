<div class="login-box">
	<div class="login-logo">
	<a href="index2.html"><b>Reset</b>Password</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Please Enter Your New Password</p>
		<form id="reset-form" onsubmit="return false">
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<div class="form-group has-feedback">
				<input type="password" name="new_password" class="form-control" placeholder="New Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="form-group has-feedback">
				<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
				<span class="glyphicon glyphicon-lock form-control-feedback"></span>
			</div>
			<div class="row">
				<!-- /.col -->
				<div class="col-xs-6 col-sm-offset-3">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Reset Password</button>
				</div>
				<!-- /.col -->
			</div>
		</form>

		<div class="social-auth-links text-center">
		<p>- OR -</p>
		<a href="admin">Log into the system</a>
		</div>
		<!-- /.social-auth-links -->
		
	</div>
	<!-- /.login-box-body -->
</div>
<!-- /.login-box -->