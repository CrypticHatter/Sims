<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Attendance_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'attendance';
    }

    public function mark($data){
    	$sql = "INSERT INTO $this->_table (std_id,date,status)
    	VALUES (".$data['std_id'].",'".$data['date']."','".$data['status']."') 
    	 ON DUPLICATE KEY UPDATE status = '".$data['status']."'";
    	$query = $this->db->query($sql);
    	if($this->db->affected_rows() > 0)
    		return true;
    	else
    		return false;
    }

    public function filter($data)
    {
    	$this->db->select('attendance.status, students.firstname, students.lastname, students.email');
    	$this->db->from($this->_table);
    	$this->db->join('students', 'students.id=attendance.std_id', 'left');
        $this->db->join('student_class', 'student_class.std_id = student.id', 'left');
    	$this->db->where('attendance.date', $data['date']);
    	$this->db->where('students.class_id', $data['class']);
    	$query = $this->db->get();
    	return $query->result();
    }

    public function get_by_month($year=null, $month=null, $user=null){
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->where('year(date)', $year);
        $this->db->where('month(date)', $month);
        $this->db->where('std_id', $user);
        $query = $this->db->get();
        return $query->result();
    }
}