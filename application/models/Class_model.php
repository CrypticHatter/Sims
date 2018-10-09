<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Class_model extends MY_Model
{
	protected $subjectClass = 'subject_class';
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'classroom';
    }
	
	public function create($data, $subjects)
	{
		$this->db->trans_begin();
		$this->db->insert($this->_table, $data);
		$id = $this->db->insert_id();
		$subs=[];
		foreach ($subjects as $subject) {
			$subs[]= array('class_id' => $id, 'subject_id' => $subject);
		}
		$this->db->insert_batch('subject_class', $subs);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function modify($data, $subjects)
	{
		$this->db->trans_begin();
		$this->db->update($this->_table, $data, ['id'=>$data['id']]);
		foreach ($subjects as $subject) {
			$subs[]= array('class_id' => $data['id'], 'subject_id' => $subject);
		}
		$this->db->delete('subject_class', array('class_id' => $data['id']));
		$this->db->insert_batch('subject_class', $subs);
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function remove($id)
	{
		$this->db->trans_begin();
		$this->db->delete($this->_table, array('id' => $id));
		$this->db->delete('subject_class', array('class_id' => $id));
		if ($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}

	public function classByID($id){
		$this->db->select('classroom.*, subject_class.subject_id');
		$this->db->from($this->_table);
		$this->db->join('subject_class', 'subject_class.class_id=classroom.id', 'left');
		$this->db->where('subject_class.class_id', $id);
		$query = $this->db->get();
		return $query->result();
	}

	public function classByBatch($id){
		$this->db->select('classroom.*');
		$this->db->from($this->_table);
		$this->db->join('student_class', 'student_class.class_id=classroom.id', 'left');
		$this->db->where('student_class.batch_id', $id);
		$this->db->group_by('classroom.id');
		$query = $this->db->get();
		return $query->result();
	}
}