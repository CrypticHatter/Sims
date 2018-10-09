<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'payment';
    }

    public function paymentsByBatch($batch)
	{
		$this->db->select('payment.*, classroom.title, classroom.division');
		$this->db->from($this->_table);
		$this->db->join('student_class', 'student_class.class_id = payment.class', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
		$this->db->where('student_class.batch_id', $batch);
		$this->db->group_by('classroom.id');
		$query = $this->db->get();
		return $query->result();
	}

	public function paymentsByClass($class)
	{
		$this->db->select('payment.*, classroom.title, classroom.division');
		$this->db->from($this->_table);
		$this->db->join('student_class', 'student_class.class_id = payment.class', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
		$this->db->where('classroom.id', $class);
		$query = $this->db->get();
		return $query->result();
	}

	public function paymentsByUser($id)
	{
		$this->_table = 'transaction';
		$this->db->select('transaction.*, CONCAT(admin.firstname," ", admin.lastname) as name');
		$this->db->from($this->_table);
		$this->db->join('admin', 'admin.id=transaction.admin_id', 'left');
		$this->db->where('std_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function checkPending($batch=null){
		$sql = "SELECT payment.id, payment.total, classroom.title, classroom.division, CONCAT(student.firstname, ' ' , student.lastname) AS name, student.id as std_id FROM payment LEFT JOIN student_class ON student_class.class_id=payment.class LEFT JOIN classroom ON classroom.id=student_class.class_id LEFT JOIN student ON student.id=student_class.std_id WHERE student_class.batch_id=$batch AND student.id NOT IN (SELECT std_id FROM transaction)";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getCompletedList($batch){
		$this->db->select('transaction.*, classroom.title, classroom.division, CONCAT(student.firstname, " ", student.lastname) AS name, student.id as std_id');
		$this->db->from('transaction');
		$this->db->join('student', 'student.id=transaction.std_id', 'left');
		$this->db->join('student_class', 'student_class.std_id = student.id', 'left');
        $this->db->join('classroom', 'classroom.id = student_class.class_id', 'left');
		$this->db->where('student_class.batch_id', $batch);
		$query = $this->db->get();
		return $query->result();
	}

	public function pay($data){
		$this->_table = "transaction";
		$this->insert($data);
		if($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}

	public function cancelPay($data){
		$this->_table = "transaction";
		$this->delete_by($data);
		if($this->db->affected_rows() > 0)
			return true;
		else
			return false;
	}
}