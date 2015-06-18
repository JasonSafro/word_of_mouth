<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_overview extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index(){

        $tbl_business_info = 'tbl_business_info';
        $where_user = array('user_id' => $this->session->userdata('user_id'));
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_business_info, $where_user);
        $info = $bus_Info[0];
        $data['info'] = $info;
        $this->load->view('includes/header');
        $this->load->view('dashboard/business_overview_view', $data);
        $this->load->view('includes/footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */