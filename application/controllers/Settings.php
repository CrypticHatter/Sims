<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller{
	public function __construct() 
	{
		parent::__construct();
		$this->load->model('Batch_model');
		$this->load->model('Class_model');
		$this->load->model('Admin_model');
		$this->load->model('Subject_model');
    }

    public function index()
    {
    	$this->load->config('provinces');
    	$data['heading'] = "General Settings";
    	$admins = $this->Admin_model->get_many_by('role', 'admin');
		$data['content'] = $this->load->view('general', array('active' => 'settings_general', 'admins' => $admins), true);
		$this->load->view('admin/core', $data);
    }
	
	public function batch()
	{
		$data['heading'] = "Batch";
		$batches = $this->Batch_model->get_all();
		$data['content'] = $this->load->view('batches', array('active' => 'batches', 'batches' => $batches), true);
		$this->load->view('admin/core', $data);
	}
	
	public function getBatchByID($id){
		if($this->input->is_ajax_request())
		{
			$data = $this->Batch_model->get($id);
			if($data){
				echo json_encode(array('status' => 'ok', 'message' => $data));
				exit;
			}else{
				echo json_encode(array('status' => 'error', 'message' => 'Invalid Input'));
				exit;
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function batchRegister()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Class title', 'required|trim');
			$this->form_validation->set_rules('start', 'Strat date', 'required|trim');
			$this->form_validation->set_rules('end', 'End date', 'required|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				if($data['start'] > $data['end']){
					echo json_encode(array('error' => 'failed', 'message' => 'Please set valid batch start/end date'));
					exit();
				}
				else
				{
					$data['created'] = date('Y-m-d h:i:s');
					if($this->Batch_model->insert($data)){
						echo json_encode(array('status' => 'ok', 'message' => 'Batch registration success'));
						exit();
					}
					else
					{
						echo json_encode(array('error' => 'failed', 'message' => 'Batch registration failed'));
						exit();
					}
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function batchUpdate()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Class title', 'required|trim');
			$this->form_validation->set_rules('start', 'Strat date', 'required|trim');
			$this->form_validation->set_rules('end', 'End date', 'required|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				if($data['start'] > $data['end']){
					echo json_encode(array('error' => 'failed', 'message' => 'Please set valid batch start/end date'));
					exit();
				}
				else
				{
					if($this->Batch_model->update($data['id'], $data)){
						echo json_encode(array('status' => 'ok', 'message' => 'Batch modification success'));
						exit();
					}
					else
					{
						echo json_encode(array('error' => 'failed', 'message' => 'Batch modification failed'));
						exit();
					}
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function batchDelete($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Batch_model->delete($id)){
				echo json_encode(array('status' => 'ok', 'message' => 'Batch was deleted'));
				exit();
			}
			else
			{
				echo json_encode(array('error' => 'failed', 'message' => 'Batch deletion failed'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function batchActivate($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Batch_model->activate($id)){
				$this->session->set_userdata('batch', $id);
				echo json_encode(array('status' => 'ok', 'message' => 'Batch activated'));
				exit();
			}
			else
			{
				echo json_encode(array('error' => 'failed', 'message' => 'Batch activation failed'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function classroom()
	{
		$data['heading'] = "Classes";
		$this->load->model('Subject_model');
		$batch = $this->session->userdata('batch');
		$classes= $this->Class_model->get_all();
		$subjects = $this->Subject_model->get_all();
		$data['content'] = $this->load->view('config_class', array('active' => 'classes', 'classes' => $classes, 'subjects'=>$subjects), true);
		$this->load->view('admin/core', $data);
	}

	public function getClassById($id){
		if($this->input->is_ajax_request())
		{
			$this->load->model('Subject_class_model');
			$class = $this->Class_model->get($id);
			$subjects = $this->Subject_class_model->get_many_by('class_id', $class->id);
			foreach ($subjects as $sub) {
				$subs[]=$sub->subject_id;
			}
			
			if($class){
				echo json_encode(array('status' => 'ok', 'message' => array('class' => $class, 'subjects' => $subs)));
				exit;
			}else{
				echo json_encode(array('status' => 'error', 'message' => 'Invalid Input'));
				exit;
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function registerClass()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('division', 'Class division', 'required|trim');
			$this->form_validation->set_rules('subjects[]', 'Subjects', 'required|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				$subs = $data['subjects'];
				unset($data['subjects']);
				$data['batch'] = $this->session->userdata('batch');
				$data['created'] = date('Y-m-d h:i:s');
				if($this->Class_model->create($data, $subs)){
					echo json_encode(array('status' => 'ok', 'message' => 'Classroom registration success'));
					exit();
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Classroom registration failed'));
					exit();
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function updateClass()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Title', 'required|trim');
			$this->form_validation->set_rules('division', 'Class division', 'required|trim');
			$this->form_validation->set_rules('subjects[]', 'Subjects', 'required|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				$subs = $data['subjects'];
				unset($data['subjects']);
				if($this->Class_model->modify($data, $subs)){
					echo json_encode(array('status' => 'ok', 'message' => 'Classroom modification success'));
					exit();
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Classroom modification failed'));
					exit();
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function deleteClass($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Class_model->remove($id)){
				echo json_encode(array('status' => 'ok', 'message' => 'Classroom deleted successfully'));
				exit();
			}else{
				echo json_encode(array('error' => 'failed', 'message' => 'Classroom deletion failed'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function payments()
	{
		$this->load->model('Class_model');
		$this->load->model('Payment_model');
		$data['heading'] = "Payment Configuration";
		$payments = $this->Payment_model->paymentsByBatch($this->session->userdata('batch'));
		$classes = $this->Class_model->classByBatch($this->session->userdata('batch'));
		$data['content'] = $this->load->view('config_payment', array('classes' => $classes, 'pays' => $payments, 'active' => 'settings-payments'), true);
		$this->load->view('admin/core', $data);
	}

	public function getPaymentByID($id)
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Payment_model');
			$data = $this->Payment_model->get($id);
			if($data){
				echo json_encode(array('status' => 'ok', 'message' => $data));
				exit;
			}else{
				echo json_encode(array('status' => 'error', 'message' => 'Invalid Input'));
				exit;
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function createPayment()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Payment_model');
			$this->form_validation->set_rules('class', 'Classroom', 'required|trim');
			$this->form_validation->set_rules('annual', 'Annual Payment', 'required|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				$data['total'] = $data['annual']+$data['practical']+$data['exam']+$data['other'];
				$ext = $this->Payment_model->get_by('class', $data['class']);
				if(empty($ext)){
					if($this->Payment_model->insert($data))
						echo json_encode(array('status' => 'ok', 'message' => 'New payment record created'));
					else
						echo json_encode(array('error' => 'failed', 'message' => 'Internal Error'));
				}else{
					if($this->Payment_model->update($ext->id, $data))
						echo json_encode(array('status' => 'ok', 'message' => 'Excisting payment record updated'));
					else
						echo json_encode(array('error' => 'failed', 'message' => 'Internal Error'));
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function updatePayment()
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Payment_model');
			$this->form_validation->set_rules('class', 'Classroom', 'required|trim');
			$this->form_validation->set_rules('annual', 'Annual Payment', 'required|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				$data['total'] = $data['annual']+$data['practical']+$data['exam'];
				if($this->Payment_model->update($data['id'], $data)){
					echo json_encode(array('status' => 'ok', 'message' => 'Payment values updated'));
					exit();
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Internal Error'));
					exit();
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function deletePayment($id)
	{
		if($this->input->is_ajax_request())
		{
			$this->load->model('Payment_model');
			if($this->Payment_model->delete($id)){
				echo json_encode(array('status' => 'ok', 'message' => 'Payment record deleted'));
				exit();
			}else{
				echo json_encode(array('error' => 'failed', 'message' => 'Internal Error'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function adminRegister()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First Name', 'required|max_length[50]|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'required|max_length[50]|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[admin.email]|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$this->load->helper('send_email');
				$data = $this->input->post();
				$this->load->helper('string');
				$password =  random_string('alnum', 10);
				$data['password'] = password_hash($password, PASSWORD_BCRYPT);
				$data['created'] = date('Y-m-d h:i:s');
				$data['created_by'] = $this->session->id;
				if($this->Admin_model->insert($data)){
					$data['password'] = $password;
					registrationMail($data);
					echo json_encode(array('status' => 'ok', 'message' => 'New admin user registered'));
					exit();
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Admin user registration failed'));
					exit();
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function getAdminByID($id)
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->Admin_model->get($id);
			if($data){
				echo json_encode(array('status' => 'ok', 'message' => $data));
				exit;
			}else{
				echo json_encode(array('status' => 'error', 'message' => 'Invalid Input'));
				exit;
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function adminUpdate()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First Name', 'required|min_length[3]|max_length[50]|trim');
			$this->form_validation->set_rules('lastname', 'Last Name', 'min_length[3]|max_length[50]|trim');
			if($this->form_validation->run() == false)
			{
				if(validation_errors())
				{
					echo json_encode(array('status' => 'failed', 'message' => array_filter(explode("\n",validation_errors()))));
					exit;
				}
				else
				{
					echo json_encode(array('status' => 'failed', 'message' => 'Invalid request'));
					exit();
				}
			}
			else
			{
				$data = $this->input->post();
				if($this->Admin_model->update($data['id'], $data)){
					echo json_encode(array('status' => 'ok', 'message' => 'Admin user updated'));
					exit();
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Internal error'));
					exit();
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	public function adminAccess()
	{
		if($this->input->is_ajax_request())
		{
			$data = $this->input->post();
			if($this->Admin_model->update($data['id'], $data)){
				echo json_encode(array('status' => 'ok', 'message' => 'Admin status updated'));
				exit;
			}else{
				echo json_encode(array('status' => 'error', 'message' => 'Invalid Input'));
				exit;
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	//subject module
	public function subjects()
	{
		$data['heading'] = "Subjects";
		$subjects = $this->Subject_model->get_all();
		$data['content'] = $this->load->view('config_subjects', array('active' => 'subjects', 'subjects' => $subjects), true);
		$this->load->view('admin/core', $data);
	}

	public function getSubjectById($id){
		if($this->input->is_ajax_request())
		{
			$data = $this->Subject_model->get($id);
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

	public function createSubject()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Subject title', 'required|trim');
			$this->form_validation->set_rules('short_code', 'Short code', 'required|trim');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				$data['created'] = date('Y-m-d h:i:s');
				if($this->Subject_model->insert($data)){
					send_response('Subject registration success');
				}
				else
				{
					send_error_response('Subject registration failed');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function updateSubject()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('title', 'Subject title', 'required|trim');
			$this->form_validation->set_rules('short_code', 'Short code', 'required|trim');
			if($this->form_validation->run() == false)
			{
				$error = array_filter(explode("\n",validation_errors()));
				send_error_response($error[0]);
			}
			else
			{
				$data = $this->input->post();
				if($this->Subject_model->update($data['id'], $data)){
					send_response('Subject updated success');
				}
				else
				{
					send_error_response('Subject modification failed');
				}
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
	
	public function deleteSubject($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Subject_model->delete($id)){
				send_response('Subject deleted successfully');
			}else{
				send_error_response('Subject deletion failed');
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}

	//signout function
	public function signOut(){
		if ($this->session->userdata('is_logged')) {
			$this->session->sess_destroy();
			redirect('admin');
		}
	}
}