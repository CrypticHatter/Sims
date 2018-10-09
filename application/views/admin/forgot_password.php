
<div class="login-box">
	<div class="login-logo">
	<a href="index2.html"><b>Forgot</b>Password</a>
	</div>
	<!-- /.login-logo -->
	<div class="login-box-body">
		<p class="login-box-msg">Please Enter Your Email</p>
		<form id="forgot-form" onsubmit="return false">
			<input type="hidden" name="type" value="<?php echo $type; ?>">
			<div class="form-group has-feedback">
				<input type="email" name="email" class="form-control" placeholder="Email">
				<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
			</div>
			<div class="row">
				<!-- /.col -->
				<div class="col-xs-6 col-sm-offset-3">
				<button type="submit" class="btn btn-primary btn-block btn-flat">Send Reset Link</button>
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
