<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller{
	public function __construct() 
	{
		parent::__construct();
        $this->load->model('Student_model');
        if($this->session->is_logged){
			$this->session->set_flashdata('success_flash', "You are already logged in");
			redirect();
			exit;
		}
		$this->load->helper('send_email');
    }

	public function index()
	{
		$data['heading'] = "Member Login";
		$data['content'] = $this->load->view('login', $data, true);
		$this->load->view('theme', $data);
	}

	public function adminLogin()
	{
		$data['heading'] = "Admin Login";
		$data['content'] = $this->load->view('admin/login', $data, true);
		$this->load->view('theme', $data);
	}

	public function forgotPassword($type='std')
	{
		$data['heading'] = "Forgot Password";
		$data['content'] = $this->load->view('admin/forgot_password', ['type' => $type], true);
		$this->load->view('theme', $data);
	}
	
	//authenticate member
	public function userAuthenticate(){
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if($this->form_validation->run() == false)
			{
				$errors = array_filter(explode("\n",validation_errors()));
				send_error_response($errors[0]);
			}
			else
			{
				$data = $this->input->post();
				$this->load->model('Batch_model');
				$student = $this->Student_model->get_by('email', $data['email']);
				$batch = $this->Batch_model->get_by('active', 1);
				if($student){
					if(password_verify($data['password'], $student->password)){
						$this->session->set_userdata
						(
							array('is_logged' => true, 'id' => $student->id, 'name' => $student->firstname." ".$student->lastname, 'batch' => $batch->id, 'batch_title'=>$batch->title)
						);
						send_response('Successfully logged in');
					}else{
						send_error_response('Your password is incorrect');
					}
				}else{
					send_error_response('Email does not excist');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	//Authenticate admin user
	public function adminAuthenticate(){
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
			$this->form_validation->set_rules('password', 'Password', 'trim|required');
			if($this->form_validation->run() == false)
			{
				$errors = array_filter(explode("\n",validation_errors()));
				send_error_response($errors[0]);
			}
			else
			{
				$data = $this->input->post();
				$this->load->model('Admin_model');
				$this->load->model('Batch_model');
				$admin = $this->Admin_model->get_by('email', $data['email']);
				$batch = $this->Batch_model->get_by('active', 1);
				if($admin){
					if(password_verify($data['password'], $admin->password)){
						$this->session->set_userdata
						(
							array('is_logged' => true, 'is_admin' => true, 'id' => $admin->id, 'name' => $admin->firstname." ".$admin->lastname, 'batch' => $batch->id, 'batch_title'=>$batch->title, 'role' => $admin->role)
						);
						send_response('Successfully logged in');
					}else{
						send_error_response('Your password is incorrect');
					}
				}else{
					send_error_response('Email address not exsist');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	
	// Validate and save new user information
	public function resetRequest()
	{
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|xss_clean');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run() == FALSE){
			$errors = array_filter(explode("\n",validation_errors()));
			send_error_response($errors[0]);
		}else{
			$this->load->model('Admin_model');
			$this->load->model('Student_model');
			$this->load->helper('string');
			$email = $this->input->post('email');
			if($this->input->post('type') == 'admin')
				$user = $this->Admin_model->get_by('email', $email);
			else
				$user = $this->Student_model->get_by('email', $email);
			if($user){
				$activation_code = random_string('alnum', 10);
				$this->session->forgot_email = $user->email;
				$this->session->activation_code = $activation_code;
				$this->session->type = $this->input->post('type');
				if(admin_pass_reset($user->email, $activation_code, $user->firstname)){
					send_response('Forgot password recovery email sent.');
				}else{
					send_error_response('Failed to send forgot password recovery email.');
				}
			}else{
				send_error_response('Account not found.');
			}
		}
	}


	public function resetView($code)
	{
		if($this->session->activation_code == $code){
			$data['heading'] = "Reset Password";
			$data['content'] = $this->load->view('admin/reset_password', ['type' => $this->session->type], true);
			$this->load->view('theme', $data);
		}else{
			$this->session->set_flashdata('error_flash', 'Invalid Reset Link');
			redirect('auth');
		}
	}

	public function resetPassword(){
		$this->form_validation->set_rules('new_password', 'New password', 'required|min_length[5]|trim');
		$this->form_validation->set_rules('confirm_password', 'Confirm password', 'required|trim|matches[new_password]');
		$this->form_validation->set_error_delimiters('', '');
		if($this->form_validation->run() == FALSE){
			$errors = array_filter(explode("\n",validation_errors()));
			send_error_response($errors[0]);
		}else{
			$this->load->model('Admin_model');
			$this->load->model('Student_model');
			$email = $this->session->forgot_email;
			$password = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
			$this->session->sess_destroy();
			if($this->input->post('type') == 'admin'){
				if($this->Admin_model->update_by(['email' => $email], ['password' => $password])){
					send_response('Your Password Successfully Changed');
				}else{
					send_error_response('Cannot reset password');
				}
			}else{
				if($this->Student_model->update_by(['email' => $email], ['password' => $password])){
					send_response('Your Password Successfully Changed');
				}else{
					send_error_response('Cannot reset password');
				}
			}
		}
	}

	public function test(){
		$this->load->model('Admin_model');
		$data = [];
		$data['firstname'] = 'Alex';
		$data['lastname'] = 'Hales';
		$data['email'] = 'user@email.com';
		$data['password'] = password_hash('password', PASSWORD_BCRYPT);
		$this->Admin_model->insert($data);
	}
}
?>