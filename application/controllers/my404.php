<?php 
class my404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
        $this->output->set_status_header('404');
        $data['heading'] = "404 Page not found";
        $data['content'] = $this->load->view('error_404', '', true); // View name 
        $this->load->view('core',$data);//loading in my template 
    } 
} 
?> 