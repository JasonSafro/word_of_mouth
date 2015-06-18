<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Faq extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
        $this->load->library('session');     //  This Library is use to When session get created.	
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $where = array('faqStatus' => 'Acitive');
        $data['user_faq'] = $this->mdgeneraldml->select('*', 'tbl_faq', $where);
        $this->load->view('includes/header');
        $this->load->view('faq_view', $data);
        $this->load->view('includes/footer');
    }

    public function get_description($faq_id)
    {
        $where = array('faqId' => $faq_id);
        $data['user_faq'] = $this->mdgeneraldml->select('faqDescription', 'tbl_faq', $where);
        echo $data['user_faq'][0]['faqDescription'];
    }

}
