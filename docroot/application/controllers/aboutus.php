<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Aboutus extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
       
        $this->load->library('form_validation');
    }

    public function index() {
       
        $sql = "SELECT pageContent FROM tbl_static_pages WHERE pageId=103";
        $where = array('pageId' => '103');
        $data['pageInfo'] = $this->mdgeneraldml->select('*', 'tbl_static_pages', $where);
        //$data['pageInfo']= $this->WGModel->sqlQuery($sql);
        $this->load->view('includes/header');
        $this->load->view('about_us_view', $data);
        $this->load->view('includes/footer');
    }

   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */