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
<!-- form start -->
<form id="update-form" role="form" onsubmit="return false">
<div class="box-body">

<input type="hidden" name="id" value="<?php echo $exam->id; ?>">
<div class="form-group">
<div class="row">
<div class="col-sm-4">
<label class="control-label">Schedule Name</label>
<input type="text" name="title" class="form-control" value="<?php echo $exam->title; ?>">
</div>
<div class="col-sm-4">
<label class="control-label">Classroom(s)</label>
<select class="form-control select2" name="classroom[]" multiple="multiple" id="class-list" data-placeholder="Select Classes" style="width: 100%;">
	<?php
		$sel = explode(',', $exam->classroom);
		foreach ($classes as $class) {
			$selected = (in_array($class->id, $sel))? 'selected':'';
			echo "<option value='$class->id' $selected>$class->title - $class->division</option>";
		}
	?>
</select>
</div>
<div class="col-sm-4">
<label class="control-label" for="date">Exam Date Range</label>
<div class="input-group date">
<div class="input-group-addon">
<i class="fa fa-calendar"></i>
</div>
<input type="text" class="form-control pull-right" name="daterange" id="range-picker" disabled>
</div>
</div>
</div>
</div>
<div id="dynamic_fields">
<?php
$key = 0;
foreach ($rows as $key => $row) {
	$key++;
	$subs = "";
	foreach ($subjects as $subject) {
		$sel = ($subject->id == $row->subject)?'selected':'';
		$subs .= "<option value='{$subject->id}' $sel>{$subject->title}</option>";
	}
	$days = "";
	foreach($daterange as $date){
		$sel = ($date->format('Y-m-d') == $row->day)?'selected':'';
		$days .= "<option value='{$date->format('Y-m-d')}' $sel>{$date->format('F-d')}</option>"; 
	}

	echo "<div class='form-group'>
			<div class='row'>
				<div class='col-sm-3'>
					<label class='control-label'>Date</label>
					<select class='form-control' name='subject[$key][day]'>
					$days
					</select>
				</div>
				<div class='col-sm-4'>
					<label class='control-label'>Subject</label>
					<select class='form-control' name='subject[$key][subject]'>
					$subs
					</select>
				</div>
				<div class='col-sm-2'>
					<div class='bootstrap-timepicker'>
						<label class='control-label'>Exam start</label>
						<input type='text' name='subject[$key][start]' class='form-control timepicker' value='$row->start'>
					</div>
				</div>
				<div class='col-sm-2'>
					<div class='bootstrap-timepicker'>
						<label class='control-label'>Exam ends</label>
						<input type='text' name='subject[$key][end]' class='form-control timepicker' value='$row->end'>
					</div>
				</div>
				<div class='col-sm-1'>
					<a href='javascript:void(0);' class='btn btn-sm delete-sub btn-danger' style='margin-top:25px;'><i class='fa fa-times'></i></a>
				</div>
			</div>
		</div>";
}
?>
</div>
<!-- /.box-body -->

<div class="box-footer">
<div class="row">
	<div class="col-sm-6">
		<button type='button' class='btn btn-sm btn-success new-line'>
		<i class='fa fa-plus'></i> New Line</button>
	</div>
	<div class="col-sm-6">
		<button type="submit" id="saveBtn" class="btn btn-primary pull-right">Update Schedule</button>
	</div>
</div>
</div>
</form>
</div>
<!-- Select2 -->
<script src="plugins/select2/select2.full.min.js"></script>
<script type="text/javascript">
	function dynamic(){
		$('.delete-sub').click(function(){
			$(this).closest('div.form-group').remove();
		});

		$(".timepicker").timepicker({
	      showInputs: false
	    });
	}
	$(function () {
		//Initialize Select2 Elements
	    $(".select2").select2({
			placeholder: 'Select an option'
		});
		dynamic();
		var start= "<?php echo date('m-d-Y', strtotime($exam->start)); ?>";
    	var end= "<?php echo date('m-d-Y', strtotime($exam->end)); ?>";
		$('#range-picker').daterangepicker(
		{
			startDate: start,
    		endDate: end
		});

		var key = <?php echo $key; ?>;
		$('.new-line').on('click', function(){
	  		key=key+1;
			ObjCommon.postCall('admin/subjectsByClass', {start:moment(start).format('YYYY-MM-DD'), end:moment(end).format('YYYY-MM-DD'),key:key,class:$('#class-list').val()}, false, function(data){
				$('#dynamic_fields').append(data);
				dynamic();
				//Timepicker
			    $(".timepicker").timepicker({
			      showInputs: false
			    });
			});
		});

		$('#update-form').on('submit', function(){
			ObjCommon.postCall('admin/updateSchedule', $(this).serialize(), true);
		});


		$(".timepicker").timepicker({
	      showInputs: false
	    });
	});
</script>