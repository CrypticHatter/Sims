<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller{
	public function __construct() 
	{
		parent::__construct();
        $this->load->model('Student_model');
        if(!$this->session->is_logged){
			$this->session->set_flashdata('error_flash', 'You need to login to access this page.');
			redirect('auth');
			exit;
		}
		
		if($this->session->is_admin){
			$this->session->set_flashdata('error_flash', 'You can not access user area.');
			redirect('admin');
			exit;
		}
    }
	
	public function index(){
		$data['heading'] = "Dashboard";
		$this->load->model('Admin_model');
		$counts=$this->Admin_model->row_count();
		$bdays = $this->Student_model->birthdays(date('m'));
		$data['content'] = $this->load->view('dashboard', array('active' => 'dashboard', 'counts' => $counts, 'bdays' => $bdays), true);
		$this->load->view('core', $data);
	}

	//profile module
	public function profile(){
		$this->load->model('Student_model');
		$data['heading'] = "My Profile";
		$admin = $this->Student_model->get($this->session->id);
		$data['content'] = $this->load->view('profile', array('active' => 'profile', 'admin' => $admin), true);
		$this->load->view('core', $data);
	}

	//payments module
	public function payments()
	{
		$this->load->model('Payment_model');
		$data['heading'] = "Fee Manegement";
		$payments = $this->Payment_model->paymentsByUser($this->session->id);
		$data['content'] = $this->load->view('payments', array('payments' => $payments,'active' => 'payments'), true);
		$this->load->view('core', $data);
	}

	//student examination module
	public function Exam($id=null){
		$this->load->model('Class_model');
		$this->load->model('Exam_model');
		$this->load->model('Subject_model');
		if($id==null){
			$data['heading'] = "Exam Schedule";
			$exams = $this->Exam_model->get_report();
			$data['content'] = $this->load->view('exam_schedule', ['active'=>'exam', 'exams'=>$exams], true);
		}else{
			$exam = $this->Exam_model->get($id);
			$rows = $this->Exam_model->exam_results($id, $this->session->id);
			$data['heading'] = "Examination View";
			$data['content'] = $this->load->view('result_view', ['active'=>'exam', 'exam'=> $exam, 'rows'=>$rows], true);
		}
		
		$this->load->view('core', $data);
	}

	//student attendance module
	public function attendance()
	{
		$this->load->model('Attendance_model');
		$data['heading'] = "Attendance";
		$month=6;
		$results = $this->Attendance_model->get_by_month($this->session->batch_title, $month, $this->session->id);
		$data['content'] = $this->load->view('attendance', array('active' => 'attendance', 'results' => $results), true);
		$this->load->view('core', $data);
	}

	public function attendance_report(){
		$this->load->model('Attendance_model');
		$month = $this->input->post('month');
		$results = $this->Attendance_model->get_by_month($this->session->batch_title, $month, $this->session->id);
		$tbody ="";
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
			$tbody .=  "<tr>
					<td>$result->date</td>
					<td>$day</td>
					<td class='text-center'>$status</td>
				</tr>";
		}
		echo json_encode(array('status' => 'ok', 'message' => $tbody));
	}

	
    //timeline
    public function timeline(){
    	$this->load->model('News_model');
    	$data['heading'] = "Timeline";
    	$user = $this->Student_model->get($this->session->id);
    	$news = $this->News_model->get_posts();
		$data['content'] = $this->load->view('user_timeline', array('active' => 'timeline', 'user' => $user, 'news' => $news), true);
		$this->load->view('core', $data);
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
			$user = $this->Student_model->get($this->session->id);
			if(password_verify($this->input->post('current_password'), $user->password)){
				$password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
				if($this->Student_model->update($this->session->id, ['password' => $password])){
					send_response('Password successfully changed');
				}else{
					send_error_response('Unable to change the password');
				}
			}else{
				send_error_response('Your current password is wrong');
			}
		}
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
				if($this->Student_model->update($data['id'], $data)){
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
	
	public function signOut(){
		if ($this->session->userdata('is_logged')) {
			$this->session->sess_destroy();
			redirect('auth');
		}
	}
	
}
?>