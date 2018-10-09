
<script src="dist/js/pages/dashboard.js"></script>

  <div class="row">
    <div class="col-lg-6 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
        <div class="inner">
        <h3><?php echo $counts->stdcount; ?></h3>
        <p>Total Students</p>
        </div>
        <div class="icon">
        <i class="fa fa-users"></i>
        </div>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
        <div class="inner">
        <h3><?php echo $counts->staffcount; ?></h3>
        <p>Total Teachers</p>
        </div>
        <div class="icon">
        <i class="ion ion-stats-bars"></i>
        </div>
        </div>
    </div>
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
        <div class="inner">
        <h3><?php echo $counts->classcount; ?></h3>
        <p>Classrooms</p>
        </div>
        <div class="icon">
        <i class="fa fa-building"></i>
        </div>
        </div>
    </div>
    <!-- ./col -->
</div>
<!-- Main row -->
<div class="row">
  <div class="col-sm-6">
    <div class="row">
      <div class="col-sm-6">
          <a href="user/timeline">
          <div class="small-box bg-red">
          <div class="inner text-center">
          <h3><i class="fa fa-calendar"></i></h3>
          <p>My Timeline</p>
          </div>
          </div>
          </a>
      </div>
      <div class="col-sm-6">
          <a href="user/payments">
          <div class="small-box bg-green">
          <div class="inner text-center">
          <h3><i class="fa fa-money"></i></h3>
          <p>My Payments</p>
          </div>
          </div>
          </a>
      </div>
      <div class="col-sm-6">
          <a href="user/attendance">
          <div class="small-box bg-blue">
          <div class="inner text-center">
          <h3><i class="fa fa-bar-chart"></i></h3>
          <p>My Attendance</p>
          </div>
          </div>
          </a>
      </div>
      <div class="col-sm-6">
          <a href="user/exam">
          <div class="small-box bg-orange">
          <div class="inner text-center">
          <h3><i class="fa fa-book"></i></h3>
          <p>My Examination</p>
          </div>
          </div>
          </a>
      </div>
      <div class="col-sm-12">
        <a href="user/profile">
          <div class="small-box bg-blue">
          <div class="inner text-center">
          <p>My Profile</p>
          </div>
          </div>
          </a>
      </div>
    </div>
  </div>
  <div class="col-sm-6">
  <div class="box box-success">
  <div class="box-header with-border">
  <h3 class="box-title">Student Birthdays</h3>
  </div>
  <!-- /.box-header -->
  <!-- form start -->
  <div class="box-body">
  <table class="table table-bordered">
  <tr>
  <th style="width: 10px">#</th>
  <th>Name</th>
  <th>Classroom</th>
  <th>Birthday</th>
  </tr>
  <?php
  foreach($bdays as $row){
  echo "<tr>
  <td>$row->id</td>
  <td>$row->name</td>
  <td>$row->class</td>
  <td>$row->dob</td>
  </tr>";
  }
  ?>
  </table>
  </div>
  </div>
  </div>
</div>