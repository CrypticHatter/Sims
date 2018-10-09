<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subject_class_model extends MY_Model
{
    public function __construct() 
	{
		parent::__construct();
        $this->_table = 'subject_class';
    }
}