
<div class="box box-primary">
	<div class="box-header with-border">
		<h3 class="box-title">Your Examination schedules</h3>
	</div>
	<!-- /.box-header -->
	<div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Exam Name</th>
            <th>Year</th>
            <th>Classroom</th>
            <th>Duration</th>
            <th>Status</th>
        </tr>
        </thead>
        <tbody>
        <?php
            foreach ($exams as $exam) {
                echo "<tr>
                        <td><a href='admin/exam/$exam->id'>$exam->title</a></td>
                        <td>$exam->year</td>
                        <td>$exam->class_title - $exam->division</td>
                        <td>$exam->start / $exam->end</td>
                        <td><label class='label label-success'>Active</label></td>
                    </tr>";
            }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <th>Exam Name</th>
            <th>Year</th>
            <th>Classroom</th>
            <th>Duration</th>
            <th>Status</th>
        </tr>
        </tfoot>
    </table>
</div>
</div>