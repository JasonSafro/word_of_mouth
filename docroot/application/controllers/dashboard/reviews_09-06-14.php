<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Reviews extends CI_Controller {

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
        # Pagination Starts Here -
        $base_url_address = 'dashboard/reviews/index/';

        //get and set pagination config variables
        $url_segment = 6;
        //$limit = ADMIN_PAGING_LIMIT;
        $limit = 100;
        
           
        $where=array('rvwBusinessUserId'=>$userId,'rvwStatus !='=>'Deleted');
        //$where="(rvwBusinessUserId=$userId OR rvwReviewerId=$userId) AND rvwStatus!='Deleted'";
        $data = _getPagingVaiables('tbl_business_reviews', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where); 
        
        $whereReview="WHERE rvwBusinessUserId=$userId AND rvwStatus!='Deleted'";
        $data['reviewList']=$this->WGModel->getBusinessReviews($whereReview,$sort_by,$sort_type,$limit,$offset);
        
        $where2=array('rvwBusinessUserId'=>$userId,'rvwStatus !='=>'Deleted');
        $data2 = _getPagingVaiables('tbl_business_reviews', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where2); 
        
        $whereReview2="WHERE rvwReviewerId=$userId AND rvwStatus!='Deleted'";
        $data['myReviewList']=$this->WGModel->getBusinessReviews($whereReview2,$sort_by,$sort_type,$limit,$offset);
        
        $this->load->view('includes/header');
        $this->load->view('dashboard/business_reviews_list_vw', $data);
        $this->load->view('includes/footer');
    }
    
    function view_details($rvwId='',$sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
         $userId=$this->session->userdata('user_id');
        //$where=array('rvwBusinessUserId'=>$userId,'rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
         $where="(rvwBusinessUserId=$userId OR rvwReviewerId=$userId) AND rvwId=$rvwId AND rvwStatus!='Deleted'";
        if($rvwId!='' && _isRecordExist('tbl_business_reviews',$where))
        {
            $whereReview="WHERE rvwStatus!='Deleted' AND rvwId=$rvwId";
            $data['review']=$this->WGModel->getBusinessReviews($whereReview);
            //echo '<pre>'; print_r($data['review']); die;
            $this->load->view('includes/header');
            $this->load->view('dashboard/business_review_detailed_vw', $data);
            $this->load->view('includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect('dashboard/reviews');
        }        
    }
    
    function save_satus($rvwId=NULL)
    {
        //echo '<pre>'; print_r($_POST); die;
        $userId=$this->session->userdata('user_id');
        $where=array('rvwBusinessUserId'=>$userId,'rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!=NULL && _isRecordExist('tbl_business_reviews',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('rvwStatus'=>$status,'rvwUpdatedOn'=>_getDateAndTime());
            
            if($status=="Disputed"){
                $updataeData['rvwDesputedReason']=$this->input->post('rvwDesputedReason');
                
                //send disputed email to sub-admin
                $subAdmins=$this->mdgeneraldml->select('adm_full_name,adm_email','tbl_administrators',array('adm_usertype'=>'SA','adm_status'=>'A'));
                if(!empty($subAdmins)){
                    //get review info
                    $whereReview="WHERE rvwStatus!='Deleted' AND rvwId=$rvwId";
                    $reviewInfo=$this->WGModel->getBusinessReviews($whereReview);
                    $bussName=$reviewInfo[0]['buss_name'];
                    //$bussUserEmail=$this->session->userdata('user_email');
                    $bussUserName=$this->session->userdata('user_name');
                    
                    //get disputed email content
                    $emailInfo=$this->mdgeneraldml->select('emailSubject,emailBody','tbl_email_contents',array('emailId'=>115));
                    $subject=$emailInfo[0]['emailSubject'];
                    $emilTemplet=$emailInfo[0]['emailBody'];
                    foreach($subAdmins as $key=>$val){
                        $adminName=$val['adm_full_name'];
                        $adminEmail=$val['adm_email'];
                        
                        $emailBody=str_replace ("[[SUB_ADMIN_NAME]]", $adminName, $emilTemplet);
                        $emailBody=str_replace ("[[BUSINESS_NAME]]", $bussName, $emilTemplet);
                        $emailBody=str_replace ("[[BUSINESS_USER_NAME]]", $bussUserName, $emilTemplet);
                        $emailBody=str_replace ("[[REVIEW_ID]]", $rvwId, $emilTemplet);
                        
                        @send_email($adminEmail,$subject,$emailBody);
                    }
                    
                }
            }
            
            $this->mdgeneraldml->update($where, 'tbl_business_reviews', $updataeData);
            $this->session->set_flashdata('success',"Review has been changed successfully as $status.");
            redirect('dashboard/reviews');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect('dashboard/reviews');
        }      
    }
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */