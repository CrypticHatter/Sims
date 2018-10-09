 <!-- Daterange picker -->
<link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
<!-- Bootstrap time Picker -->
 <link rel="stylesheet" href="plugins/timepicker/bootstrap-timepicker.min.css">
<!-- bootstrap time picker -->
<script src="plugins/timepicker/bootstrap-timepicker.min.js"></script>
<div class="box box-primary">
<div class="box-header with-border">
    <h3 class="box-title">Completed exam results</h3>
</div>
    <div class="box-body">
        <form id="result-filter" onsubmit="return false">
            <div class="form-group">
                <div class="row">
                    <input type='hidden' name='exam' value='<?php echo $exam_id; ?>'>
                    <div class="col-sm-4 col-sm-offset-1">
                        <label>Select Student</label>
                        <select class="form-control" name="student">
                            <option value="">All students</option>
                            <?php
                            foreach ($students as $std) {
                                echo "<option value='$std->id'>$std->name</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label>Select Subject</label>
                        <select class="form-control" name="subject">
                            <option value="">All subjects</option>
                            <?php
                            foreach ($subs as $sub) {
                                echo "<option value='$sub->id'>$sub->title</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-success" style="margin-top: 25px;">Filter</button>
                    </div>
                </div>
            </div>
        </form>
        <form id="marks-form" onsubmit="return false">
            <table id="exam-result" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Classroom</th>
                    <th>Subject</th>
                    <th width='10%'>Marks</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($records as $key => $record){
                            echo "<tr>
                                        <input type='hidden' name='row[$key][student]' value='$record->id'>
                                        <input type='hidden' name='row[$key][subject]' value='$record->sub_id'>
                                        <td>$record->name</td>
                                        <td>$record->class</td>
                                        <td>$record->subject</td>
                                        <td><input type='number' name='row[$key][marks]' class='form-control' max='100' value='$record->marks'></td>
                                    </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="box-footer">
            <button class="btn btn-primary pull-right">Update Marks</button>
        </div>
    </form>
</div>
<script>
$(document).ready(function(){
    $('#exam-result').DataTable();

    $('#result-filter').on('submit', function(){
        var elem = $(this);
        $('#exam-result').DataTable().destroy();
        $.post('admin/filter_exam_results', elem.serialize(), function(data){
            $('#exam-result').find('tbody').html(data);
            $('#exam-result').DataTable();
        });
    });

     $('#marks-form').on('submit', function(){
        ObjCommon.postCall('admin/updateExamResults', $(this).serialize(),false);
    });
});
</script>