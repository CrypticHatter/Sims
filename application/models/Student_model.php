<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Student_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'student';
		$this->load->library('Email');
    }

    public function getStudentData($batch)
    {
    	$this->db->select("student.*, CONCAT(classroom.title,'-' ,classroom.division) as class");
		$this->db->from($this->_table);
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
		$this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
		$this->db->where('student_class.batch_id', $batch);
		$query = $this->db->get();
		return $query->result();
    }
	
	public function getDataByid($id){
		$this->db->select("student.*, student_class.class_id, guardian.id as gid, guardian.name as gname, guardian.relation, guardian.email as gmail, guardian.phone as gphone");
		$this->db->from($this->_table);
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
		$this->db->join('guardian', 'guardian.student = student_class.std_id', 'left');
		$this->db->where('student.id', $id);
		$query = $this->db->get();
		return $query->row();
	}

    public function search($data=['status'=>1, 'name'=>null,'id'=>null,'class'=>null]){
        $this->db->select('std.*, concat(class.title," - ", class.division) as classroom');
        $this->db->from('student std');
        $this->db->join('student_class', 'student_class.std_id = std.id', 'left');
        $this->db->join('classroom class', 'class.id = student_class.class_id', 'left');
        $this->db->where('student_class.batch_id', $this->session->userdata('batch'));
        $this->db->where('std.active', $data['status']);
        if($data['name'] <> null)
            $this->db->like('CONCAT(firstname," ", lastname)', $data['name']);
        if($data['id'] <> null)
            $this->db->where('std.id', $data['id']);
        if($data['class'] <> null)
            $this->db->where('class_id', $data['class']);
        $query = $this->db->get();
        return $query->result();
    }

    public function create($data, $parent, $map){
    	$this->db->trans_start();
        $this->db->insert($this->_table, $data);
		$insert_id = $this->db->insert_id();
		$guardian = array_merge($parent, array('student' => $insert_id));
        $map = array_merge($map, array('std_id' => $insert_id));
        $this->db->insert('guardian', $guardian);
        $this->db->insert('student_class', $map);
        $this->db->trans_complete();
    	if($this->db->affected_rows() == -1)
			return false;
		else
			return true;
    }

	public function birthdays($month=null){
		$this->db->select('student.id, CONCAT(student.firstname," ",student.lastname) as name, student.dob, CONCAT(classroom.title,"-",classroom.division) as class');
		$this->db->from($this->_table);
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
        if($month <> null)
		  $this->db->where('month(student.dob)', $month);
		$query=$this->db->get();
		return $query->result();
	}

    public function birthdayEvents($class=null){
        $this->db->select('CONCAT(student.firstname," ",student.lastname) as title, student.dob as start');
        $this->db->from($this->_table);
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
        if($class <> null)
          $this->db->where('classroom.id', $class);
        $query=$this->db->get();
        return $query->result();
    }

    public function latest($limit=4){
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->order_by('created', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

     public function get_class_count(){
        $this->db->select('count(student.id) value, CONCAT(classroom.title,"-",classroom.division) as label');
        $this->db->from($this->_table);
         $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
        $this->db->group_by('student_class.class_id');
        $query = $this->db->get();
        return $query->result();
    }

    public function studentsByClass($class){
        $this->db->select('student.*');
        $this->db->from($this->_table);
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->where('student_class.class_id', $class);
        $query = $this->db->get();
        return $query->result();
    }
	
	 public function modify($data, $parent, $map){
    	$this->db->trans_start();
		$this->db->update($this->_table, $data, array('id' => $data['id']));
		$guardian = array_merge($parent, array('student' => $data['id']));
		$this->db->update('guardian', $guardian, array('student' => $data['id']));
        $this->db->update('student_class', $map, array('std_id' => $data['id'], 'batch_id'=>$map['batch_id']));
        $this->db->trans_complete();
    	if($this->db->affected_rows() == -1)
			return false;
		else
			return true;
    }
	
	 public function remove($id){
    	$this->db->trans_start();
        $this->db->delete('student_class', array('std_id' => $id)); 
		$this->db->delete('parents', array('student' => $id)); 
		$this->db->delete($this->_table, array('id' => $id)); 
        $this->db->trans_complete();
    	if($this->db->affected_rows() == -1)
			return false;
		else
			return true;
    }

    public function getAttendance($data)
    {
    	$this->db->select('student.id, student.firstname, student.lastname, student.email, classroom.title, classroom.division, attendance.status');
    	$this->db->from($this->_table);
    	$this->db->join('attendance', 'attendance.std_id=student.id', 'left');
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
        if($data['class']<>0)
    	   $this->db->where('student_class.class_id', $data['class']);
    	$this->db->where('attendance.date', $data['date']);
    	$query = $this->db->get();
    	return $query->result();
    }

    public function attByDateRange($class, $from, $to)
    {
    	$this->db->select('student.id, student.firstname, student.lastname, attendance.status, attendance.date');
    	$this->db->from($this->_table);
    	$this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('attendance', 'attendance.std_id=student_class.std_id', 'left');
        $this->db->where('attendance.date >=', $from);
        $this->db->where('attendance.date <=', $to);
        if($class <> 0)
           $this->db->where('student_class.class_id', $class);
    	$query = $this->db->get();
    	return $query->result();
    }

    public function attByDate($class, $date)
    {
        $this->db->select('student.id,attendance.status, attendance.date');
        $this->db->from($this->_table);
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('attendance', 'attendance.std_id=student.id', 'left');
        $this->db->where('attendance.date', $date);
        if($class <> 0)
           $this->db->where('student_class.class_id', $class);
        $this->db->group_by('student.id'); 
        $query = $this->db->get();
        return $query->result();
    }
}