<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Referral extends CI_Controller {

    function __construct() {
        parent::__construct();        
        _authenticateUserLogin();        
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');        
    }

    function index($sort_by='rvwId', $sort_type='DESC', $offset=0) 
    {  
        $userId=$this->session->userdata('user_id');
        $where=array('user_id'=>$userId);
        $info=$this->mdgeneraldml->select('user_fname,user_lname,user_referralCode','tbl_user',$where);
        
        $userInfo=array('userFullName'=>$info[0]['user_fname'].' '.$info[0]['user_lname'],'referralCode'=>$info[0]['user_referralCode']);
        //update referral code if not exit
        if($info[0]['user_referralCode']=="")
        {
            $user_referralCode=md5($userId);
            $this->mdgeneraldml->update($where,'tbl_user',array('user_referralCode'=>$user_referralCode));
            $userInfo['referralCode']=$user_referralCode;
        }
        
        $data['userInfo']=$userInfo;
        //echo '<pre>'; print_r($data); die;
        $this->load->view('includes/header');
        $this->load->view('dashboard/referral_vw', $data);
        $this->load->view('includes/footer');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */