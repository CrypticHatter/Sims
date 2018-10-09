<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller{
	public function __construct() 
	{
		parent::__construct();
        $this->load->model('Admin_model');
        if(!$this->session->is_logged){
			$this->session->set_flashdata('error_flash', 'You need to login to access this page.');
			redirect('auth/adminLogin');
			exit;
		}
		
		if(!$this->session->is_admin){
			$this->session->set_flashdata('error_flash', 'You can not access admin area.');
			redirect('user');
			exit;
		}
		$this->load->model('Student_model');
		$this->load->helper('send_email');
		$this->load->config('provinces');
    }

    public function index()
    {
    	$data['heading'] = "Dashboard";
		$counts=$this->Admin_model->row_count();
		$new = $this->Admin_model->latest();
		$students = $this->Student_model->latest();
		$bdays = $this->Student_model->birthdays(date('m'));
		$results = json_encode($this->Student_model->get_class_count());
		$data['content'] = $this->load->view('admin/dashboard', array('active' => 'dashboard', 'counts' => $counts,'new' => $new, 'students' => $students, 'bdays' => $bdays, 'results' => $results), true);
		$this->load->view('admin/core', $data);
    }

	//students module
	public function students()
    {
    	$this->load->model('Class_model');
		$data['heading'] = "Students";
		$classes = $this->Class_model->get_all();
		$students = $this->Student_model->search();
		$data['content'] = $this->load->view('students', array('active' => 'students', 'students' => $students, 'classes' => $classes), true);
		$this->load->view('admin/core', $data);
    }

    public function studentSearch()
  	{
  		$this->load->model('Student_model');
  		$data = $this->input->post();
  		$search = $this->Student_model->search($data);
  		$rows = "";
  		foreach ($search as $row) {
  			$rows .= "<tr>
  						<td>$row->id</td>
  						<td><a href='./student/$row->id'>$row->firstname $row->lastname</a></td>
  						<td>$row->dob</td>
  						<td>$row->email</td>
  						<td>$row->address</td>
  						<td>$row->classroom</td>
  						<td>
  							<div class='btn-group' data-id='{$row->id}'>
							<button type='button' data-toggle='modal' data-target='#studentModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
							<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-xs btn-danger delete'><i class='fa fa-times'></i></button>
							</div>
  						</td>
  					</tr>";
  		}
  		echo $rows;
  	}

  	public function teacherSearch()
  	{
  		$data = $this->input->post();
  		$search = $this->Admin_model->search($data);
  		$rows = "";
  		foreach ($search as $row) {
  			$rows .= "<tr>
  						<td><a href='./teacher/$row->id'>$row->id</a></td>
  						<td>$row->firstname $row->lastname</td>
  						<td>$row->email</td>
  						<td>$row->gender</td>
  						<td>
  							<div class='btn-group' data-id='{$row->id}'>
							<button type='button' data-toggle='modal' data-target='#teacherModal' class='btn btn-xs btn-primary edit'><i class='fa fa-edit'></i></button>
							<button type='button' data-toggle='modal' data-target='#deleteModal' class='btn btn-xs btn-danger delete'><i class='fa fa-times'></i></button>
							</div>
						</td>
  					</tr>";
  		}
  		echo $rows;
  	}
	
	public function getStudentById($id){
		if($this->input->is_ajax_request())
		{
			$data = $this->Student_model->getDataByid($id);
			if($data){
				send_response($data);
			}else{
				send_error_response('Invalid Input');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function createStudent()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[student.email]');
			$this->form_validation->set_rules('class_id', 'Classroom', 'required');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n", validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$this->load->helper('string');
				$data = $this->input->post();
				$password = random_string('alnum', 10);
				$data['password'] = password_hash($password, PASSWORD_BCRYPT);
				$data['created'] = date('Y-m-d h:i:s');
				$parent = array('name' => $data['gname'], 'relation' => $data['relation'], 'phone' => $data['gphone'], 'email' => $data['gmail']);
				$map = array('class_id'=>$data['class_id'],'batch_id'=>$this->session->userdata('batch'));
				unset($data['gname'], $data['relation'], $data['gphone'], $data['gmail'], $data['class_id']);
				if($this->Student_model->create($data, $parent, $map)){
					$data['role'] = "Student";
					$data['password'] = $password;
					registrationMail($data);
					send_response('Success, Login details are sent to the account');
				}
				else
				{
					send_error_response('Student registration failed');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	
	public function updateStudent()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			$this->form_validation->set_rules('class_id', 'Classroom', 'required');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n", validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				$parent = array('name' => $data['gname'], 'relation' => $data['relation'], 'student' => $data['id'], 'phone' => $data['gphone'], 'email' => $data['gmail']);
				$map = array('class_id'=>$data['class_id'],'batch_id'=>$this->session->userdata('batch'));
				unset($data['gname'], $data['relation'], $data['gphone'], $data['gmail'], $data['class_id']);
				if($this->Student_model->modify($data, $parent, $map)){
					send_response('Student modification success');
				}
				else
				{
					send_error_response('Student modification failed');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function deleteStudent($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Student_model->delete($id)){
				send_response('Student deleted successfully');
			}else{
				send_error_response('Student deletion failed');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	//Teachers module
	public function teachers()
	{
		$data['heading'] = "Teachers";
		$teachers = $this->Admin_model->search();
		$data['content'] = $this->load->view('teachers', array('active' => 'teachers', 'teachers'=>$teachers), true);
		$this->load->view('admin/core', $data);
	}

	public function getTeacherById($id){
		if($this->input->is_ajax_request())
		{
			$data = $this->Admin_model->get($id);
			if($data){
				send_response($data);
			}else{
				send_error_response('Invalid Input');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function createTeacher()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[admin.email]');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$this->load->helper('string');
				$data = $this->input->post();
				$password = random_string('alnum', 10);
				$data['role'] = 'teacher';
				$data['password'] = password_hash($password, PASSWORD_BCRYPT);
				$data['created_by'] = $this->session->id;
				$data['created'] = date('Y-m-d h:i:s');
				if($this->Admin_model->insert($data)){
					$data['role'] = "Teacher";
					$data['password'] = $password;
					registrationMail($data);
					send_response('Account successfully created. Activation link has been sent.');
				}
				else
				{
					send_error_response('Teacher registration failed, please contact support');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function updateTeacher()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|trim');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				if($this->Admin_model->update($data['id'], $data)){
					send_response('Teacher modification success');
				}
				else
				{
					send_error_response('Teacher modification failed');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function deleteTeacher($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Admin_model->delete($id)){
				send_response('Teacher deleted successfully');
			}else{
				echo json_encode(array('error' => 'failed', 'message' => 'Teacher deletion failed'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	//payments module
	public function payments_pending()
	{
		$this->load->model('Class_model');
		$this->load->model('Payment_model');
		$data['heading'] = "Fee Manegement";
		$pendings = $this->Payment_model->checkPending($this->session->userdata('batch'));
		$classes = $this->Class_model->classByBatch($this->session->userdata('batch'));
		$data['content'] = $this->load->view('admin/pending_pay', array('classes' => $classes, 'pendings' => $pendings,'active' => 'pay_pending'), true);
		$this->load->view('admin/core', $data);
	}

	function pend(){
		$this->load->model('Payment_model');
		$res = $this->Payment_model->checkPending($this->session->userdata('batch'));
		print_r($res);die;
	}


	public function payments_completed()
	{
		$this->load->model('Class_model');
		$this->load->model('Payment_model');
		$data['heading'] = "Fee Manegement";
		$completes = $this->Payment_model->getCompletedList($this->session->userdata('batch'));
		$classes = $this->Class_model->classByBatch($this->session->userdata('batch'));
		$data['content'] = $this->load->view('admin/completed_pay', array('classes' => $classes,'completes' => $completes, 'active' => 'pay_completed'), true);
		$this->load->view('admin/core', $data);
	}

	public function completePayment(){
		if($this->input->is_ajax_request())
		{
			$this->load->model('Payment_model');
			$data = $this->input->post();
			$data['paid'] = date('Y-m-d H:i:s');
			$data['admin_id'] = $this->session->id;
			if($this->Payment_model->pay($data)){
				send_response('Payment processed');
			}
			else
			{
				send_error_response('Internal Error');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	

	public function cancelPayment(){
		if($this->input->is_ajax_request())
		{
			$this->load->model('Payment_model');
			$data = $this->input->post();
			if($this->Payment_model->cancelPay($data)){
				send_response('Payment cancelled');
			}
			else
			{
				send_error_response('Internal Error');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	//Examination module
	public function Exam($id=null){
		$this->load->model('Class_model');
		$this->load->model('Exam_model');
		$this->load->model('Subject_model');
		if($id==null){
			$data['heading'] = "Exam Schedule";
			$classes = $this->Class_model->classByBatch($this->session->batch);
			$exams = $this->Exam_model->get_schedule();
			$data['content'] = $this->load->view('admin/exam_schedule', ['active'=>'exam_schedule', 'classes'=>$classes, 'exams'=>$exams], true);
		}else{
			$exam = $this->Exam_model->get($id);
			$rows = $this->Exam_model->get_sub_by_exam($id);
			$begin = new DateTime($exam->start);
			$end = new DateTime($exam->end);
			$end = $end->modify( '+1 day' ); 

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			$subjects = $this->Subject_model->subsByClass($exam->classroom);
			$data['heading'] = "Examination View";
			$classes = $this->Class_model->classByBatch($this->session->batch);
			$data['content'] = $this->load->view('schedule', ['active'=>'exam_schedule', 'exam'=> $exam, 'classes' => $classes, 'subjects'=>$subjects, 'daterange'=>$daterange, 'rows'=>$rows], true);
		}
		
		$this->load->view('admin/core', $data);
	}

	public function createSchedule(){
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Exam Schedule Title', 'required|trim');
			$this->form_validation->set_rules('classroom[]', 'Classroom', 'required');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				$this->load->model('Exam_model');
				$dates = explode(" - ", $data['daterange']);
				$data['classroom'] = implode(",", $data['classroom']);
		    	$data['start'] = date('Y-m-d', strtotime($dates[0]));
		    	$data['end'] = date('Y-m-d', strtotime($dates[1]));
		    	$data['year'] = $this->session->batch_title;
		    	$data['created_by'] = $this->session->id;
		    	$data['created'] = date('Y-m-d H:i:s');
		    	unset($data['daterange']);
				if($this->Exam_model->create_schedule($data)){
					send_response('New Exam Schedule Created');
				}
				else
				{
					send_error_response('Internal Error');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function updateSchedule(){
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Exam Schedule Title', 'required|trim');
			$this->form_validation->set_rules('classroom[]', 'Classroom', 'required');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				$this->load->model('Exam_model');
				$data['classroom'] = implode(",", $data['classroom']);
		    	$data['year'] = $this->session->batch_title;
		    	$data['created_by'] = $this->session->id;
		    	$data['created'] = date('Y-m-d H:i:s');
		    	unset($data['daterange']);
				if($this->Exam_model->update_schedule($data)){
					send_response('Exam Schedule Updated');
				}
				else
				{
					send_error_response('Internal Error');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function deleteSchedule($id)
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Exam_model');
			if($this->Exam_model->delete($id)){
				send_response('Exam schedule deleted successfully');
			}else{
				send_error_response('Internal Error');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function completeSchedule($id)
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Exam_model');
			if($this->Exam_model->update($id, ['complete' => 1])){
				send_response('Exam schedule completed');
			}else{
				send_error_response('Internal Error');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function subjectsByClass(){
		if($this->input->is_ajax_request())
		{
			$this->load->model('Subject_model');
			$data = $this->input->post();
			$begin = new DateTime($data['start']);
			$end = new DateTime($data['end']);
			$end = $end->modify( '+1 day' ); 

			$interval = new DateInterval('P1D');
			$daterange = new DatePeriod($begin, $interval ,$end);
			$subjects = $this->Subject_model->subsByClass($data['class']);
			if(!empty($subjects)){
				$subs = "";
				foreach ($subjects as $subject) {
					$subs .= "<option value='{$subject->id}'>{$subject->title}</option>";
				}
				$days = "";
				foreach($daterange as $date){
					$days .= "<option value='{$date->format('Y-m-d')}'>{$date->format('F-d')}</option>"; 
				}
				
				$key = $data['key'];
				$dates = "<div class='form-group'>
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
									<input type='text' name='subject[$key][start]' class='form-control timepicker'>
								</div>
							</div>
							<div class='col-sm-2'>
								<div class='bootstrap-timepicker'>
									<label class='control-label'>Exam ends</label>
									<input type='text' name='subject[$key][end]' class='form-control timepicker'>
								</div>
							</div>
							<div class='col-sm-1'>
								<a href='javascript:void(0);' class='btn btn-sm delete-sub btn-danger' style='margin-top:25px;'><i class='fa fa-times'></i></a>
							</div>
						</div>
					</div>";
				send_response($dates);
				die;
			}else{
				send_error_response('please select a classroom');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function examResult($exam=null)
	{
		$this->load->model('Exam_model');
		$this->load->model('Student_model');
		$data['heading'] = "Exam Results";
		if($exam == null){
			$exams = $this->Exam_model->get_report();
			$data['content'] = $this->load->view('admin/exam_results', array('active' => 'exam_results', 'exams' => $exams), true);
		}else{
			$stds = $this->Exam_model->studsByExam($exam);
			$subjects = $this->Exam_model->subsByExam($exam);
			$results = $this->Exam_model->get_student_results($exam);
			$data['content'] = $this->load->view('admin/exam_report', array('active' => 'exam_results','exam_id' => $exam, 'records' => $results, 'students' => $stds, 'subs' => $subjects), true);
		}
		$this->load->view('admin/core', $data);
	}


	public function filter_exam_results(){
		$this->load->model('Exam_model');
		$data=$this->input->post();
		$rows = $this->Exam_model->get_student_results($data['exam'], $data['student'], $data['subject']);
		$tbody = "";
		foreach($rows as $key => $row){
		$tbody .=  "<tr>
						<input type='hidden' name='row[$key][student]' value='$row->id'>
						<input type='hidden' name='row[$key][subject]' value='$row->sub_id'>
						<td>$row->name</td>
						<td>$row->class</td>
						<td>$row->subject</td>
						<td><input type='number' name='row[$key][marks]' class='form-control' value='$row->marks'></td>
					</tr>";
		}
		echo $tbody;
	}

	public function endExam($exam){
		if($this->input->is_ajax_request())
		{
			$this->load->model('Exam_model');
			if($this->Exam_model->update($exam, ['complete' => 1])){
				send_response('Exam schedule Completed successfully');
			}else{
				send_error_response('Internal Error');
			}
			
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}


	public function updateExamResults(){
		if($this->input->is_ajax_request())
		{
			$this->load->model('Exam_model');
			if($this->Exam_model->updateMarks($this->input->post('row'))){
				send_response('Student Marks Updated');
			}else{
				send_error_response('Internal Error');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	

	//profile module
	public function profile(){
		$data['heading'] = "My Profile";
		$admin = $this->Admin_model->get($this->session->id);
		$data['content'] = $this->load->view('admin/profile', array('active' => 'profile', 'admin' => $admin), true);
		$this->load->view('admin/core', $data);
	}

	public function updateProfile()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				if($this->Admin_model->update($data['id'], $data)){
					send_response('Your profile updated');
				}
				else
				{
					send_error_response('Internal error');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function changePassword()
	{
		$this->form_validation->set_rules('current_password', 'Old Password', 'required|trim|xss_clean');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|matches[confirm_password]|trim|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Password Confirmation', 'trim|xss_clean');
		
		$this->form_validation->set_error_delimiters('', '');
		
		if($this->form_validation->run() == FALSE){
			$error = array_filter(explode("\n",validation_errors()));
			send_error_response($error[0]);
		}else{
			$admin = $this->Admin_model->get($this->session->id);
			if(password_verify($this->input->post('current_password'), $admin->password)){
				$password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
				if($this->Admin_model->update($this->session->id, ['password' => $password])){
					send_response('Password successfully changed');
				}else{
					send_error_response('Unable to change the password');
				}
			}else{
				send_error_response('Your current password is wrong');
			}
		}
	}

	//attendance module
	public function attendance(){
		$data['heading'] = "Attendance";
		$this->load->model('Class_model');
		$classes = $this->Class_model->classByBatch($this->session->batch);
		$data['content'] = $this->load->view('admin/attendance', array('active' => 'att-mark', 'classes' => $classes), true);
		$this->load->view('admin/core', $data);
	}

	public function attReport(){
		$data['heading'] = "Attendance sheet";
		$this->load->model('Class_model');
		$classes = $this->Class_model->classByBatch($this->session->batch);
		$data['content'] = $this->load->view('att_sheet', array('active' => 'att-report', 'classes' => $classes), true);
		$this->load->view('admin/core', $data);
	}

	public function getAttendanceByClass($id)
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->Student_model->studentsByClass($id);
			if($data){
				$html ="";
				foreach ($data as $student) {
					$html .="<tr>
								<td>{$student->id}</td>
								<td>{$student->firstname} {$student->lastname}</td>
								<td>{$student->email}</td>
								<td class='text-center'>
									<div class='btn-group' data-id='{$student->id}'>
										<button type='button' class='btn btn-sm btn-success mark' data-type='present'>Present</button>
										<button type='button' class='btn btn-sm btn-danger mark' data-type='absent'>Absent</button>
										<button type='button' class='btn btn-sm btn-warning mark' data-type='leave'>Leave</button>
									</div>
								</td>
							</tr>";
				}
				echo json_encode(array('status' => 'ok', 'message' => $html));
				exit();
			}else{
				echo json_encode(array('error' => 'failed', 'message' => 'Invalid Class'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function attendanceByClass()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->Student_model->getAttendance($this->input->post());
			if($data){
				$html ="";
				foreach ($data as $student) {
					if($student->status == 'present') 
						$status = '<span class="label label-success">Present</span>';
					elseif($student->status == 'leave')
						$status = '<span class="label label-warning">Leave</span>';
					else
						$status = '<span class="label label-danger">Absent</span>';
					$html .="<tr>
								<td>{$student->id}</td>
								<td>{$student->firstname} {$student->lastname}</td>
								<td>{$student->title} - $student->division</td>
								<td>{$student->email}</td>
								<td class='text-center'>
									{$status}
								</td>
							</tr>";
				}
				echo json_encode(array('status' => 'ok', 'message' => $html));
				exit();
			}else{
				$html ="";
				echo json_encode(array('status' => 'ok', 'message' => $html));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function attendanceReport()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post();
			$range = explode(" - ", $data['daterange']);
			$begin = new DateTime($range[0]);
			$end = new DateTime($range[1]);
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			$thead = '<tr><th>Student ID</th><th>Student Name</th>';
			foreach ($period as $date){
				$thead .= "<th>{$date->format('M-d')}</th>";
			}
			$thead .= '</tr>';
			$tbody = '';
			$students = $this->Student_model->attByDateRange($data['class'], $begin->format('Y-m-d'), $end->format('Y-m-d'));
			foreach ($students as $key => $student) {
				$tbody .= "<tr>
							<td>{$student->id}</td>
							<td>{$student->firstname}</td>";
				foreach ($period as $key2=>$date){
					$info=$this->Student_model->attByDate($data['class'], $date->format('Y-m-d'));
					if(!empty($info)){
						$tbody .= "<td>{$info[$key2]->status}</td>";
					}
					else
						$tbody .= "<td>Missed</td>";
				}
				$tbody .="</tr>";
			}
			
			echo json_encode(array('status' => 'ok', 'message' => ['thead' => $thead, 'tbody' => $tbody]));
			exit();
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function markAttendance()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Attendance_model');
			$data = $this->input->post();
			if($this->Attendance_model->mark($data)){
				echo json_encode(array('status' => 'ok', 'message' => 'Attendance updated'));
				exit;
			}else{
				echo json_encode(array('status' => 'error', 'message' => 'Internal Error'));
				exit;
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function getStudentsByClass($class)
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->Student_model->get_many_by('class_id', $class);
			if($data){
				$html ="";
				foreach ($data as $student){
					$html .="<option value='{$student->id}'>{$student->firstname} {$student->lastname}</option>";
				}
				echo json_encode(array('status' => 'ok', 'message' => $html));
				exit();
			}else{
				$html ="<option selected disabled>No Student data</option>";
				echo json_encode(array('status' => 'ok', 'message' => $html));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function import(){
		$data['heading'] = "Import";
		$data['content'] = $this->load->view('admin/import', array('active' => 'import'), true);
		$this->load->view('admin/core', $data);
	}

	function import_students(){
		if($this->input->is_ajax_request())
		{
			$config['upload_path']          = './upload/import';
			$config['allowed_types']        = 'csv|txt';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userfile'))
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$this->load->library('csv');
				$this->load->model('Student_model');
				$result = $this->csv->read($this->upload->data('full_path'));
				if($this->Student_model->insert_many($result)){
					send_response('Student details imported');
				}else{
					send_error_response('Error while importing data');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
    }

	function import_teachers(){
		if($this->input->is_ajax_request())
		{
			$config['upload_path']          = './upload/import';
			$config['allowed_types']        = 'csv|txt';
			$this->load->library('upload', $config);
			if ( ! $this->upload->do_upload('userfile'))
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$this->load->library('csv');
				$this->load->helper('string');
				$this->load->model('Admin_model');
				$data = $this->input->post();
				
				$result =  $this->csv->read($this->upload->data('full_path'));
				$password = random_string('alnum', 10);
				$result['password'] = password_hash($password, PASSWORD_BCRYPT);
				$result['created'] = $this->session->id;
				if($this->Admin_model->insert_many($result)){
					send_response('Teachers Details are imported');
				}else{
					send_error_response('Error while importing data');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
    }

    //timeline
    public function timeline(){
    	$this->load->model('News_model');
    	$data['heading'] = "Timeline";
    	$user = $this->Admin_model->get($this->session->id);
    	$news = $this->News_model->get_posts();
		$data['content'] = $this->load->view('timeline', array('active' => 'timeline', 'user' => $user, 'news' => $news), true);
		$this->load->view('admin/core', $data);
    }


    public function addPost2(){
    	$this->load->helper(array('form', 'url'));
    	$this->load->model('News_model');
    	$this->form_validation->set_rules('title', 'Title', 'required|trim|xss_clean');
		$this->form_validation->set_rules('content', 'Content', 'required|xss_clean');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run() == FALSE){
			$error = array_filter(explode("\n",validation_errors()));
			$this->session->set_flashdata('error_flash', $error[0]);
			redirect('admin/timeline');
		}else{
			if(!empty($_FILES['userfile']['name'])){
                $config['upload_path']  = './uploads';
                $config['allowed_types']  = 'gif|jpg|png';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                if (!$this->upload->do_upload('userfile'))
                {
                	print_r($config);die;
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error_flash', $error);
					redirect('admin/timeline');
                }
                else
                {
                  $data = $this->input->post();

                  $data['image'] = $this->upload->data('file_name');
                  $data['created_by'] = $this->session->id;
                  $data['created'] = date('Y-m-d H:i:s');
                  if(!$this->News_model->insert($data)){
                  	$this->session->set_flashdata('error_flash', 'Internal Error');
					redirect('admin/timeline');
                  }
                }
            }else{
                $data = $this->input->post();
                $data['created_by'] = $this->session->id;
                $data['created'] = date('Y-m-d H:i:s');
				if($this->News_model->insert($data)){
				send_response('Post added successfully');
				}else{
				send_error_response('Internal Error');
				}
            }
		}
    }

    function addPost(){
        $this->load->helper(array('form', 'url'));
     
            
            if(!empty($_FILES['userfile']['name'])){
                $config['upload_path']          = './uploads';
                $config['allowed_types']        = 'gif|jpg|png';
                $config['encrypt_name'] = TRUE;
                $this->load->library('upload', $config);
                //print_r($config);die;
                if ( ! $this->upload->do_upload('userfile'))
                {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error_flash', $error);
					redirect('admin/timeline');
                }
                else
                {
                  $data = $this->input->post();
                  $data['profile_pic'] = $this->upload->data('file_name');
                  if(!$this->User_model->update($data)){
                    
                    $this->session->set_flashdata('error_flash', 'das');
					redirect('admin/timeline');
                  }
                }
            }else{
                $data = $this->input->post();
                if($this->User_model->update($data)){
                    $user = $this->User_model->get($data['id']);
                    $this->session->set_userdata('user_hris', $user);
                    $this->session->set_flashdata('success', "User Profile Updated");
                    redirect('user/profile');
                }else{
                  $this->session->set_flashdata('fail', "Failed");
                  redirect('user/profile');
                }
            }
    }

    public function add_comment(){
    	$this->load->model('News_model');
    	$this->form_validation->set_rules('content', 'content', 'required|trim|xss_clean');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run() == FALSE){
			$error = array_filter(explode("\n",validation_errors()));
			send_error_response($error[0]);
		}else{
			$data = $this->input->post();
			$data['created_by'] = $this->session->id;
			$data['created'] = date('Y-m-d H:i:s');
			if(!$this->News_model->insert_comment($data)){
				send_error_response('Internal Error');
			}
		}
    }

}