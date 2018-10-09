<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'news';
    }

    public function get_posts(){
    	$this->db->select('news.*, admin.id as user, CONCAT(admin.firstname," ", admin.lastname) as name,admin.image as profile');
    	$this->db->from($this->_table);
    	$this->db->join('admin', 'admin.id=news.created_by', 'left');
    	$query = $this->db->get();
    	return $query->result();
    }

    public function insert_comment($data){
    	$this->_table="news_comments";
    	$this->insert($data);
    }
}