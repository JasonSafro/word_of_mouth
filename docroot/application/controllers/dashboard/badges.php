<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Badges extends CI_Controller {

    function __construct() {
        parent::__construct();        
        _authenticateUserLogin();        
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');        
    }

    function index() 
    {         
        $userId=$this->session->userdata('user_id');
        
        
        $reviewsCount=$this->WGModel->countReviewersReviews($userId);
        $expertReviewersResult=$this->WGModel->countReviewersExpertReviews($userId);
        $referralCount=$this->WGModel->countReferrals($userId);
        $data=array('reviewsCount'=>$reviewsCount,'expertReviewersResult'=>$expertReviewersResult,'referralCount'=>$referralCount);
        
        $this->load->view('includes/header');
        $this->load->view('dashboard/badges_vw', $data);
        $this->load->view('includes/footer');
    }
    
   
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */