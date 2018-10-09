<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>SMS | <?php echo $heading; ?></title>
		<base href="<?php echo base_url(); ?>">
		<!-- Tell the browser to be responsive to screen width -->
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<!-- Bootstrap 3.3.6 -->
		<link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">
		<!-- Font Awesome -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
		<!-- Ionicons -->
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
		<!-- Theme style -->
		<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
		<!-- iCheck -->
		<link rel="stylesheet" href="plugins/iCheck/square/blue.css">
		<style type="text/css">
		/*custom css code*/
		.alert{
		width: 25%;
		position: fixed;
		top:20px;
		right: 20px;
		display: none;
		z-index: 1500;
		}
		</style>
	</head>
	<body class="hold-transition login-page">
		<div id="success_alert" class="alert alert-success alert-dismissible">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		  <h4><i class="icon fa fa-check"></i> Success!</h4>
		  <span id="success_msg"></span>
		</div>
		<div id="fail_alert" class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Failed!</h4>
			<span id="fail_msg"></span>
		</div>
		<?php echo $content;?>
		<!-- jQuery 2.2.3 -->
		<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
		<!-- Bootstrap 3.3.6 -->
		<script src="dist/bootstrap/js/bootstrap.min.js"></script>
		<!-- iCheck -->
		<script src="plugins/iCheck/icheck.min.js"></script>
		<!-- iCheck -->
		<script src="dist/js/common.js"></script>
		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
				});

				<?php if($this->session->flashdata('error_flash')){?>
				ObjCommon.setErrorMsg("<?php echo $this->session->flashdata('error_flash'); ?>");
				<?php } ?>
				
				$('#forgot-form').on('submit', function(){
					ObjCommon.postCall('auth/resetRequest', $(this).serialize(), true);
				});

				$('#reset-form').on('submit', function(){
					ObjCommon.postCall('auth/resetPassword', $(this).serialize(), true);
				});

				$('#admin-login').on('submit', function(){
					ObjCommon.postCall('auth/adminAuthenticate', $(this).serialize(), true);
				});

				$('#login-form').on('submit', function(){
					ObjCommon.postCall('auth/userAuthenticate', $(this).serialize(), true);
				});
			});
		</script>
	</body>
</html>
