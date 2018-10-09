<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_model extends MY_Model
{
	protected $subClass = 'subject_class';
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'subject';
    }

    public function subsByClass($class=[]){
		$this->db->select('subject.*');
		$this->db->from($this->_table);
		$this->db->join('subject_class', 'subject_class.subject_id=subject.id','left');
		$this->db->where_in('subject_class.class_id', $class);
		$this->db->group_by('subject.id');
		$query = $this->db->get();
		return $query->result();
	}
}