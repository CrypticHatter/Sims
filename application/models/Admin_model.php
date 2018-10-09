<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'admin';
    }

    public function latest($limit=4){
        $this->db->select('*');
        $this->db->from($this->_table);
        $this->db->order_by('created', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        return $query->result();
    }

    public function row_count(){
        $query = $this->db->query('SELECT (SELECT COUNT(id) FROM student) as stdcount,(SELECT COUNT(id) FROM admin) as staffcount, (SELECT COUNT(id) FROM classroom) as classcount, (SELECT SUM(amount) FROM transaction) as total');
        return $query->row();
    }

    public function search($data=['status'=>1, 'name'=>null,'gender'=>null]){
        $this->db->select('*');
        $this->db->from('admin');
        $this->db->where('role', 'teacher');
        $this->db->where('status', $data['status']);
        if($data['name'] <> null)
            $this->db->like('CONCAT(firstname," ", lastname)', $data['name']);
        if($data['gender'] <> null)
            $this->db->where('gender', $data['gender']);
        $query = $this->db->get();
        return $query->result();
    }
}