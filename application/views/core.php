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
<!-- AdminLTE Skins. Choose a skin from the css/skins
folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
<!-- iCheck -->
<link rel="stylesheet" href="plugins/iCheck/square/blue.css">

<!-- jvectormap -->
<link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
<!-- Date Picker -->
<link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

<!-- bootstrap wysihtml5 - text editor -->
<link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="dist/css/AdminLTE.min.css">
<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
$.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="dist/bootstrap/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<!-- daterangepicker -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
<script src="plugins/daterangepicker/daterangepicker.js"></script>
<!-- Sparkline -->
<script src="plugins/sparkline/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="plugins/knob/jquery.knob.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>
<!-- common js file -->
<script src="dist/js/common.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- iCheck -->
<script src="plugins/iCheck/icheck.min.js"></script>
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="plugins/datatables/extensions/buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables/extensions/buttons/js/buttons.print.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.3.1/js/buttons.colVis.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
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

tr.present {
    background-color:#87D37C !important;
}
tr.absent {
    background-color:#E68364 !important;
}
tr.leave {
    background-color:#F5D76E !important;
}
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
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
<header class="main-header">
<!-- Logo -->
<a href="index2.html" class="logo">
<!-- mini logo for sidebar mini 50x50 pixels -->
<span class="logo-mini"><b>S</b>MS</span>
<!-- logo for regular state and mobile devices -->
<span class="logo-lg"><b>Student</b>Manager</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
<!-- Sidebar toggle button-->
<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
<span class="sr-only">Toggle navigation</span>
</a>

<div class="navbar-custom-menu">
<ul class="nav navbar-nav">

<!-- Notifications: style can be found in dropdown.less -->
<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-bell-o"></i>
<span class="label label-warning">10</span>
</a>
<ul class="dropdown-menu">
<li class="header">You have 10 notifications</li>
<li>
<!-- inner menu: contains the actual data -->
<ul class="menu">
<li>
<a href="#">
<i class="fa fa-users text-aqua"></i> 5 new members joined today
</a>
</li>
<li>
<a href="#">
<i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
page and may cause design problems
</a>
</li>
<li>
<a href="#">
<i class="fa fa-users text-red"></i> 5 new members joined
</a>
</li>
<li>
<a href="#">
<i class="fa fa-shopping-cart text-green"></i> 25 sales made
</a>
</li>
<li>
<a href="#">
<i class="fa fa-user text-red"></i> You changed your username
</a>
</li>
</ul>
</li>
<li class="footer"><a href="#">View all</a></li>
</ul>
</li>
<li class="dropdown user user-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
<span class="hidden-xs"><?php echo $this->session->userdata('name');?></span>
</a>
<ul class="dropdown-menu">
<!-- User image -->
<li class="user-header">
<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">

<p>
<?php echo $this->session->name ." - ". $this->session->role; ?>
<small>Member since Nov. 2012</small>
</p>
</li>
<!--
<li class="user-body">
<div class="row">
<div class="col-xs-4 text-center">
<a href="#">Followers</a>
</div>
<div class="col-xs-4 text-center">
<a href="#">Sales</a>
</div>
<div class="col-xs-4 text-center">
<a href="#">Friends</a>
</div>
</div>
</li>
-->
<!-- Menu Footer-->
<li class="user-footer">
<div class="pull-left">
<a href="user/profile" class="btn btn-default btn-flat">Profile</a>
</div>
<div class="pull-right">
<a href="settings/signOut" class="btn btn-default btn-flat">Sign out</a>
</div>
</li>
</ul>
</li>
</ul>
</div>
</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<!-- Sidebar user panel -->
<div class="user-panel">
<div class="pull-left image">
<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
</div>
<div class="pull-left info">
<p><?php echo $this->session->name; ?></p>
<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
</div>
</div>

	<ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
		<li>
		<a href="user" data-page="dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
		</li>
		<li>
		<a href="user/timeline" data-page="timeline"><i class="fa fa-calendar"></i> <span>Timeline</span></a>
		</li>
		<li>
		<a href="user/payments" data-page="payments"><i class="fa fa-wrench"></i> <span>Payments</span></a>
		</li>
		<li>
		<a href="user/exam" data-page="exam"><i class="fa fa-book"></i> <span>Examination</span></a>
		</li>
		<li>
		<a href="user/attendance" data-page="attendance"><i class="fa fa-bar-chart"></i> <span>Attendance</span></a>
		</li>
		<li>
		<a href="user/profile" data-page="settings"><i class="fa fa-wrench"></i> <span>Settings</span></a>
		</li>
	</ul> 
</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
<h1>
<?php echo $heading;?>
<small><?php echo $this->session->batch_title; ?> Batch</small>
</h1>
<ol class="breadcrumb">
<li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
<li class="active"><?php echo $active; ?></li>
</ol>
</section>

<!-- Main content -->
<section class="content">
<?php echo $content; ?>
</section>
</div>
<!-- /.content-wrapper -->
<footer class="main-footer">
<div class="pull-right hidden-xs">
<b>Version</b> 1.0.0
</div>
<strong>Copyright &copy; <?php echo date('Y'); ?> <a href="http://almsaeedstudio.com">St. Mary's college</a>.</strong> All rights
reserved.
</footer>
<!-- Add the sidebar's background. This div must be placed
immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
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
<!-- datepicker -->
<script src="plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- ./wrapper -->
<script type="text/javascript">
$(document).ready(function(){
	//Date picker
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',
		autoclose: true
	});

	$('input').iCheck({
		checkboxClass: 'icheckbox_square-blue',
		radioClass: 'iradio_square-blue',
		increaseArea: '20%' // optional
	});

	var elem =  $('a[data-page="<?php echo $active; ?>"]');
	if(elem.parents("li.treeview").length){
		elem.closest('li.treeview').addClass('active');
		elem.closest('li').addClass('active');
	}else{
		elem.closest('li').addClass('active');
	}
});
</script>
</body>
</html>