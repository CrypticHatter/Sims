<div class="box box-success">
	<div class="box-header with-border">
		<h3 class="box-title">My Attendance</h3>
	</div>
	<div class="box-body">
		<form onsubmit="return false">
        <div class="form-group">
            <div class="row">
            <div class="col-sm-5 col-sm-offset-2">
            <label>Month</label>
            <select name="month" class="form-control">
                <option value='1'>Jan</option>
                <option value='2'>Feb</option>
                <option value='3'>Mar</option>
                <option value='4'>Apr</option>
                <option value='5'>May</option>
                <option value='6'>June</option>
                <option value='7'>July</option>
                <option value='8'>Aug</option>
                <option value='9'>Sep</option>
                <option value='10'>Oct</option>
                <option value='11'>Nov</option>
                <option value='12'>Dec</option>
            </select>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-primary" style="margin-top:20px">Submit</button>
            </div>
            </div>
        </div>
        </form>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th>Date</th>
					<th>Day name</th>
					<th class='text-center'>Attendance</th>
				</tr>
			</thead>
			<tbody id="attendace-data">
				<?php
				foreach($results as $result){
					$day = date('l', strtotime($result->date));
					switch($result->status){
						case 'present':
							$status = "<label class='label label-danger'>Absent</label>";
						break;
						case 'leave':
							$status = "<label class='label label-warning'>Leave</label>";
						break;
						default:
							$status = "<label class='label label-success'>Present</label>";
						break;
					}
					echo "<tr>
							<td>$result->date</td>
							<td>$day</td>
							<td class='text-center'>$status</td>
						</tr>";
				}
				?>
			</tbody>
		</table>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('form').on('submit', function(){
			ObjCommon.postCall('user/attendance_report', $(this).serialize(), false,function(data){
				$('#attendace-data').html(data);
			});
		});
	});
</script>