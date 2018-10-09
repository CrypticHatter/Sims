
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <li class="active"><a href="#students" data-toggle="tab">Students</a></li>
        <li><a href="#teachers" data-toggle="tab">Teachers</a></li>
        <li><a href="#attendance" data-toggle="tab">Attendance</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active" id="students">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <label>Upload Students File</label>
                        <input type="file" name="userfile" id="std-file" size="20" />
                    </div>
                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary top-buffer" id="upload-std">Upload Students</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="teachers">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <label>Upload Teachers File</label>
                        <input type="file" name="userfile" id="teach-file" size="20" />
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-primary top-buffer" id="upload-teacher">Upload Teachers</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane" id="attendance">
            <div class="form-group">
                <div class="row">
                    <div class="col-sm-4 col-sm-offset-2">
                        <label>Upload Attendance File</label>
                        <input type="file" name="userfile" id="attendace-file" size="20" />
                    </div>
                    <div class="col-sm-2">
                        <button class="btn btn-primary top-buffer" id="upload-attendance">Upload Attendance</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var url = document.location.toString();
		if (url.match('#')) {
		    $('ul.nav-tabs').find('a[href="#' + url.split('#')[1]+'"]').tab('show');
		} //add a suffix

		// Change hash for page-reload
		$('.nav-tabs').find('a').on('shown.bs.tab', function (e) {
		    window.location.hash = e.target.hash;
		})

        $('#upload-std').on('click', function(){
            ObjCommon.postFileUpload('admin/import_students', 'std-file', false);
        });

        $('#upload-teacher').on('click', function(){
            ObjCommon.postFileUpload('admin/import_teachers', 'teach-file', false);
        });
        
	});
</script>