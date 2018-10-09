<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Batch_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'batch';
    }
	
	public function activate($id)
	{
		$this->db->trans_start();
		$this->db->update($this->_table, array('active' => 0));
		$this->db->update($this->_table, array('active' => 1), array('id' => $id));
		$this->db->trans_complete();
		if($this->db->affected_rows() == -1)
			return false;
		else
			return true;
	}
}