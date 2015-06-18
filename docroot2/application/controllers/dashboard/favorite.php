<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Favorite extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index($sort_by='buss_favorite_id', $sort_type='DESC', $offset=0) {
        //getFavoriteBusinessList
        $user_login_id = $this->session->userdata('user_id');
        //$where_bus_id = array('user_id' => $user_login_id);
        //$data['fav_Info'] = $this->mdgeneraldml->select('*', 'tbl_user_favorite_business', $where_bus_id);
        
        $where="WHERE f.user_id=$user_login_id AND bussStatus='Active'";
        $data['fav_Info'] = $this->WGModel->getFavoriteBusinessList($where);
        //echo '<pre>'; print_r($data['fav_Info']);die;
        $this->load->view('includes/header');
        $this->load->view('dashboard/favorite_vw', $data);
        $this->load->view('includes/footer');
    }

    function delete($id='') {
        if ($id != NULL) {
            $where = array('buss_favorite_id' => $id);
            $this->mdgeneraldml->delete($where, "tbl_user_favorite_business");
            $this->session->set_flashdata('success', 'Business has been removed from your favorite list.');
            redirect(site_url('dashboard/favorite'));
        } else {
            $this->session->set_flashdata('error', 'Sorry! Record not exist.');
            redirect(site_url('dashboard/favorite'));
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */