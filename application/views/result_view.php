 <!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- Bootstrap time Picker -->
 <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<div class="box box-primary">
<div class="box-header with-border">
<h3 class="box-title"><?php echo $exam->title; ?></h3>
</div>
<!-- /.box-header -->
<div class="box-body">
<div class="col-sm-10 col-sm-offset-1">
<table id="result-table" class="table table-bordered table-striped">
	<thead>
	<tr>
		<th>Subject</th>
		<th>Marks</th>
		<th>Grade</th>
	</tr>
	</thead>
	<tbody>
	<?php
		foreach ($rows as $key => $row) {
			$grade = ($row->marks>60)?"Pass":"Fail";
			echo "<tr>
					<td>$row->sub</td>
					<td>$row->marks</td>
					<td>$grade</td>
				</tr>";
		}
	?>
	</tbody>
	</table>
</div>
</div>