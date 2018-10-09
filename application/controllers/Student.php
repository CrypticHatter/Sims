<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller{
	public function __construct() 
	{
		parent::__construct();
        $this->load->model('Student_model');
        $this->load->model('Parent_model');
		$this->load->helper('send_email');
    }

    public function index()
    {
    	$this->load->model('Class_model');
		$data['heading'] = "Students";
		$classes = $this->Class_model->get_all();
		$students = $this->Student_model->getStudentData($this->session->userdata('batch'));
		$data['content'] = $this->load->view('students', array('active' => 'students', 'students' => $students, 'classes' => $classes), true);
		$this->load->view('core', $data);
    }

    public function addNew()
    {
    	$this->load->model('Class_model');
    	$data['heading'] = "Student admission";
    	$classes = $this->Class_model->get_all();
		$data['content'] = $this->load->view('admission', array('active' => 'student-add', 'classes' => $classes), true);
		$this->load->view('core', $data);
    }
	
	public function getById($id){
		if($this->input->is_ajax_request())
		{
			$data = $this->Student_model->getDataByid($id);
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

	public function register()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[students.email]');
			$this->form_validation->set_rules('class_id', 'Classroom', 'required');
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
				$this->load->helper('string');
				$data = $this->input->post();
				$password = random_string('alnum', 10);
				$data['batch'] = $this->session->userdata('batch');
				$data['password'] = password_hash($password, PASSWORD_BCRYPT);
				$data['created'] = date('Y-m-d h:i:s');
				$parent = array('name' => $data['gname'], 'relation' => $data['relation'], 'phone' => $data['gphone'], 'email' => $data['gmail']);
				unset($data['gname'], $data['relation'], $data['gphone'], $data['gmail']);
				if($this->Student_model->create($data, $parent)){
					if(studentRegistration($data['email'], $password)){
						echo json_encode(array('status' => 'ok', 'message' => 'Student registration success'));
						exit();
					}else{
						echo json_encode(array('status' => 'failed', 'message' => 'Registration email error'));
						exit();
					}
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Student registration failed'));
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

	
	public function update()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules('firstname', 'First name', 'required|trim');
			$this->form_validation->set_rules('lastname', 'Last name', 'required|trim');
			$this->form_validation->set_rules('class_id', 'Classroom', 'required');
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
				$parent = array('name' => $data['gname'], 'relation' => $data['relation'], 'student' => $data['id'], 'phone' => $data['gphone'], 'email' => $data['gmail']);
				unset($data['gname'], $data['relation'], $data['gphone'], $data['gmail']);
				if($this->Student_model->modify($data, $parent)){
					echo json_encode(array('status' => 'ok', 'message' => 'Student modification success'));
					exit();
				}
				else
				{
					echo json_encode(array('error' => 'failed', 'message' => 'Student modification failed'));
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
	
	public function delete($id)
	{
		if($this->input->is_ajax_request())
		{
			if($this->Student_model->delete($id)){
				echo json_encode(array('status' => 'ok', 'message' => 'Student deleted successfully'));
				exit();
			}else{
				echo json_encode(array('error' => 'failed', 'message' => 'Student deletion failed'));
				exit();
			}
		}
		else
		{
			echo "this is not an ajax request";
			die;
		}
	}
}
?>