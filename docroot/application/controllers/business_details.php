<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_details extends CI_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
         $this->load->model('db_transact_model'); // This model is use to common quries defined into this model	
        $this->load->model('mdgeneraldml');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index()
    {
        if (($this->session->userdata('user_id') == ""))
        {
            redirect('home');
        }
        else
        {
            $tbl_business_info = 'tbl_business_info';
            $where_user = array('user_id' => $this->session->userdata('user_id'));
            $bus_Info = $this->mdgeneraldml->select('*', $tbl_business_info, $where_user);
            $info = $bus_Info[0];
            $data['info'] = $info;
            
            //Get Category Namet
            $cnd = "catId = '" . $info['buss_category'] . "' ";
            $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
            $data['buss_category']=$cat_name[0]['catName'];
            
            $this->load->view('includes/header');
            $this->load->view('business_details_view', $data);
            $this->load->view('includes/footer');
        }
    }
    
    
    public function bus_info($bus_id=NULL)
    {
        $tbl_business_info = 'tbl_business_info';
        $where_bus_id = array('buss_id' => $bus_id);
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_business_info, $where_bus_id);
        $info = $bus_Info[0];
        $data['info'] = $info;
        print_r($data['info']);

        //Get Category Name
        $cnd = "catId = '" . $info['buss_category'] . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['buss_category'] = $cat_name[0]['catName'];

       /* $user_id = "catId = '" . $info['buss_category'] . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['buss_category'] = $cat_name[0]['catName']; */

        $this->load->view('includes/header');
        $this->load->view('business_details_view', $data);
        $this->load->view('includes/footer');
    }
    
}

/* End of file home.php */
/* Location: ./application/controllers/dashboard/business_details.php */