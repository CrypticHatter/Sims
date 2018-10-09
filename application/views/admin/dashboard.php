
<!-- Small boxes (Stat box) -->
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
        <div class="inner">
        <h3><?php echo $counts->stdcount; ?></h3>
        <p>Total Students</p>
        </div>
        <div class="icon">
        <i class="fa fa-users"></i>
        </div>
        <a href="admin/students" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
        <div class="inner">
        <h3><?php echo $counts->staffcount; ?></h3>
        <p>Total Staff</p>
        </div>
        <div class="icon">
        <i class="ion ion-stats-bars"></i>
        </div>
        <a href="settings" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
        <div class="inner">
        <h3><?php echo nice_number($counts->total); ?></h3>
        <p>Earnings</p>
        </div>
        <div class="icon">
        <i class="ion ion-pie-graph"></i>
        </div>
        <a href="admin/payments_completed" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
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
        <a href="settings/classroom" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <!-- ./col -->
</div>
<div class="row">
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
    <div class="col-sm-6">
        <!-- DONUT CHART -->
          <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">Classroom Overview</h3>
            </div>
            <div class="box-body">
              <canvas id="pieChart" style="height:250px"></canvas>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">New Staff</h3>
            </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Joined</th>
                </tr>
                <?php
                    foreach($new as $row){
                        $joined = date('d-m-Y', strtotime($row->created));
                        echo "<tr>
                                <td>$row->id</td>
                                <td>$row->firstname</td>
                                <td>$row->role</td>
                                <td>$joined</td>
                            </tr>";
                    }
                ?>
            </table>
        </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">New Students</h3>
            </div>
        <!-- /.box-header -->
        <div class="box-body">
            <table class="table table-bordered">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Name</th>
                  <th>Role</th>
                  <th>Joined</th>
                </tr>
                <?php
                    foreach($students as $row){
                        $joined = date('d-m-Y', strtotime($row->created));
                        echo "<tr>
                                <td>$row->id</td>
                                <td>$row->firstname</td>
                                <td>$row->dob</td>
                                <td>$joined</td>
                            </tr>";
                    }
                ?>
            </table>
        </div>
        </div>
    </div>
</div>
</section>
<!-- ChartJS 1.0.1 -->
<script src="plugins/chartjs/Chart.min.js"></script>
<!-- /.content -->
<script type="text/javascript">
    $(document).ready(function(){
        var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
        var pieChart = new Chart(pieChartCanvas);
        var PieData = <?php echo $results; ?>;
        var pieOptions = {
          //Boolean - Whether we should show a stroke on each segment
          segmentShowStroke: true,
          //String - The colour of each segment stroke
          segmentStrokeColor: "#fff",
          //Number - The width of each segment stroke
          segmentStrokeWidth: 2,
          //Number - The percentage of the chart that we cut out of the middle
          percentageInnerCutout: 50, // This is 0 for Pie charts
          //Number - Amount of animation steps
          animationSteps: 100,
          //String - Animation easing effect
          animationEasing: "easeOutBounce",
          //Boolean - Whether we animate the rotation of the Doughnut
          animateRotate: true,
          //Boolean - Whether we animate scaling the Doughnut from the centre
          animateScale: false,
          //Boolean - whether to make the chart responsive to window resizing
          responsive: true,
          // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
          maintainAspectRatio: true,
          //String - A legend template
          legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
        };

         // You can switch between pie and douhnut using the method below.
        pieChart.Doughnut(PieData, pieOptions);
    });
</script>
