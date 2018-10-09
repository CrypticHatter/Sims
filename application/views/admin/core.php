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
<link rel="stylesheet" href="plugins/datatables/extensions/buttons/css/buttons.bootstrap.min.css">
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
<script src="plugins/datatables/extensions/buttons/js/buttons.html5.min.js"></script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
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
<!-- Messages: style can be found in dropdown.less-->
<!--<li class="dropdown messages-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-envelope-o"></i>
<span class="label label-success">4</span>
</a>
<ul class="dropdown-menu">
<li class="header">You have 4 messages</li>
<li>
<ul class="menu">
<li>
<a href="#">
<div class="pull-left">
<img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
</div>
<h4>
Support Team
<small><i class="fa fa-clock-o"></i> 5 mins</small>
</h4>
<p>Why not buy a new awesome theme?</p>
</a>
</li>
<li>
<a href="#">
<div class="pull-left">
<img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
</div>
<h4>
AdminLTE Design Team
<small><i class="fa fa-clock-o"></i> 2 hours</small>
</h4>
<p>Why not buy a new awesome theme?</p>
</a>
</li>
<li>
<a href="#">
<div class="pull-left">
<img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
</div>
<h4>
Developers
<small><i class="fa fa-clock-o"></i> Today</small>
</h4>
<p>Why not buy a new awesome theme?</p>
</a>
</li>
<li>
<a href="#">
<div class="pull-left">
<img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
</div>
<h4>
Sales Department
<small><i class="fa fa-clock-o"></i> Yesterday</small>
</h4>
<p>Why not buy a new awesome theme?</p>
</a>
</li>
<li>
<a href="#">
<div class="pull-left">
<img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
</div>
<h4>
Reviewers
<small><i class="fa fa-clock-o"></i> 2 days</small>
</h4>
<p>Why not buy a new awesome theme?</p>
</a>
</li>
</ul>
</li>
<li class="footer"><a href="#">See All Messages</a></li>
</ul>
</li>-->
<!-- Notifications: style can be found in dropdown.less -->
<!--<li class="dropdown notifications-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<i class="fa fa-bell-o"></i>
<span class="label label-warning">10</span>
</a>
<ul class="dropdown-menu">
<li class="header">You have 10 notifications</li>
<li>

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
</li>-->
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

<!-- Menu Footer-->
<li class="user-footer">
<div class="pull-left">
<a href="admin/profile" class="btn btn-default btn-flat">Profile</a>
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
	<!-- sidebar menu: : style can be found in sidebar.less -->
	<ul class="sidebar-menu">
		<li class="header">MAIN NAVIGATION</li>
		<li>
		<a href="" data-page="dashboard"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
		</li>
		<li>
		<a href="admin/timeline" data-page="timeline"><i class="fa fa-calendar"></i> <span>Timeline</span></a>
		</li>
		<li class="treeview">
		<a href="#">
		<i class="fa fa-wrench"></i> <span>Payments</span>
		<span class="pull-right-container">
		<i class="fa fa-angle-left pull-right"></i>
		</span>
		</a>
		<ul class="treeview-menu">
		<li><a href="admin/payments_pending" data-page="pay_pending"><i class="fa fa-circle-o"></i> Pending</a></li>
		<li><a href="admin/payments_completed" data-page="pay_completed"><i class="fa fa-circle-o"></i> Completed</a></li>
		</ul>
		</li>
		<li class="treeview">
		<a href="#">
		<i class="fa fa-edit"></i> <span>Examination</span>
		<span class="pull-right-container">
		<i class="fa fa-angle-left pull-right"></i>
		</span>
		</a>
		<ul class="treeview-menu">
		<li><a href="admin/exam" data-page="exam_schedule"><i class="fa fa-circle-o"></i> Schedules</a></li>
		<li><a href="admin/examResult" data-page="exam_results"><i class="fa fa-circle-o"></i> Results</a></li>
		</ul>
		</li>
		<li class="treeview">
		<a href="#">
		<i class="fa fa-edit"></i> <span>Attendence</span>
		<span class="pull-right-container">
		<i class="fa fa-angle-left pull-right"></i>
		</span>
		</a>
		<ul class="treeview-menu">
		<li><a href="admin/attendance" data-page="att-mark"><i class="fa fa-circle-o"></i> Mark Attendence</a></li>
		<li><a href="admin/attReport"  data-page="att-report"><i class="fa fa-circle-o"></i> Attendence Report</a></li>
		</ul>
		</li>
		<li>
		<a href="admin/students" data-page="students"><i class="fa fa-user"></i> <span>Students</span></a>
		</li>
		<li>
		<a href="admin/teachers" data-page="teachers"><i class="fa fa-graduation-cap"></i>Teachers</a>
		</li>
		<li class="treeview">
		<a href="#">
		<i class="fa fa-wrench"></i> <span>Settings</span>
		<span class="pull-right-container">
		<i class="fa fa-angle-left pull-right"></i>
		</span>
		</a>
		<ul class="treeview-menu">
		<li><a href="settings" data-page="settings_general"><i class="fa fa-circle-o"></i> User management</a></li>
		<li><a href="settings/batch" data-page="batches"><i class="fa fa-circle-o"></i> Batches/Year</a></li>
		<li><a href="settings/subjects" data-page="subjects"><i class="fa fa-circle-o"></i> Subjects</a></li>
		<li><a href="settings/classroom" data-page="classes"><i class="fa fa-circle-o"></i> Classrooms</a></li>
		<li><a href="settings/payments" data-page="settings-payments"><i class="fa fa-circle-o"></i> Payments</a></li>
		</ul>
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
<li class="active"><?php echo $heading;?></li>
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
<b>Version</b> 2.3.6
</div>
<strong>Copyright &copy; 2017 <a href="#">St. Mary's college</a>.</strong> All rights
reserved.
</footer>

<!-- /.control-sidebar -->
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

<!-- ./wrapper -->
<script type="text/javascript">
$(document).ready(function(){
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