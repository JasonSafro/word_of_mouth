<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account_Overview extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model','WGModel');
        $this->load->model('mdgeneraldml');        
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index() {

        $tbl_user = 'tbl_user';
        $where_user = array('user_id' => $this->session->userdata('user_id'));
        $userInfo = $this->mdgeneraldml->select('*', $tbl_user, $where_user);
        $info = $userInfo[0];
        $data['info'] = $info;

        //Get User State
        $where_state_id = array('state_id' => $info['user_state']);
        $get_state = $this->mdgeneraldml->select('state_name', 'tbl_state', $where_state_id);
        if (count($get_state) > 0)
            $data['user_state'] = $get_state[0]['state_name'];
        else
            $data['user_state'] = '';
        //Get User Country
        $where_country_code = array('country_code' => $info['user_country']);
        $get_country = $this->mdgeneraldml->select('country_name', 'tbl_country', $where_country_code);

        if (count($get_country) > 0)
            $data['user_country'] = $get_country[0]['country_name'];
        else
            $data['user_country'] = '';


        $this->load->view('includes/header');
        $this->load->view('dashboard/dashboard_view', $data);
        $this->load->view('includes/footer');
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */