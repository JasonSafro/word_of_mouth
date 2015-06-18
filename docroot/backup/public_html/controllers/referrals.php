<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Referrals extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');        
    }

    function index() 
    {  
        redirect('home');
    }
    
    function code($userReferralCode=NULL)
    {
        $where=array('user_referralCode'=>$userReferralCode);
        $userId=$this->session->userdata('user_id');
        if($userReferralCode!=NULL && _isRecordExist('tbl_user',$where))
        {
            if($userId=='')
                $this->session->set_userdata('referralCode',$userReferralCode);
            
            redirect('home');
        }else{
           $this->session->set_flashdata('error','Invalid call');
           redirect('home');
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */