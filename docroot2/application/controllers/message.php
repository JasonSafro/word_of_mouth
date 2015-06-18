<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Message extends CI_Controller {

     function __construct() {
        parent::__construct();          
    }
    
    public function index()
    {
        $data=array();
        $this->load->view('includes/header');
        $this->load->view('display_message_vw', $data);
        $this->load->view('includes/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */