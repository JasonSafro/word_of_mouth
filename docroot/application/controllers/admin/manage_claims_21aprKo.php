<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_claims extends CI_Controller {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();        
        _authenticateAdmin();        
        $this->load->model('admin_model');        
        $this->load->model('mdgeneraldml');        
        $this->load->library('pagination');
         $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='crId', $sort_type='DESC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_claims/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT; ;
		       
        $data = _getPagingVaiables('tbl_cliam_requests', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type);       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        
        $where = array('crStatus !='=>'Deleted');
        $data['claimList'] = $this->mdgeneraldml->select('*','tbl_cliam_requests' ,$where, $order_by, $limit, $offset);
       
        $this->load->view('admin/includes/header');
        $this->load->view('admin/claims_listing_vw',$data);
        $this->load->view('admin/includes/footer');
    }
       
    function view($crId='',$sort_by='crId', $sort_type='DESC', $offset=0)
    {
        $where=array('crStatus !='=>'Deleted','crId'=>$crId);
        if($crId!='' && _isRecordExist('tbl_cliam_requests',$where))
        {
            $whereRequest="WHERE crStatus!='Deleted' AND crId=$crId";
            $request=$this->admin_model->getClaimRequests($whereRequest);
            $data['request']=$request[0];
            
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/claim_listing_detail_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }  
    }
    
    function save_satus($crId='',$sort_by='crId', $sort_type='DESC', $offset=0){
        $where=array('crStatus !='=>'Deleted','crId'=>$crId);
        if($crId!='' && _isRecordExist('tbl_cliam_requests',$where))
        {
            $status=$this->input->post('status');
            if($status=="")
            {
                $this->session->set_flashdata('error','Please select the status.');
                redirect(ADMIN_FOLDER_NAME.'/manage_claims/view/'.$crId);
            }    
           
            $whereRequest="WHERE crStatus!='Deleted' AND crId=$crId";
            $request=$this->admin_model->getClaimRequests($whereRequest);
            $request=$request[0];
            
            $emailId=$request['crBussOfficialEmail'];
            
            $updateData=array('crStatus'=>$status,'crUpdatedOn'=>_getDateAndTime());

            if($status=='Approved'){
                $where_Id=array('emailId'=>'109');
                $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                
                $emilTemplet=$emailinfo[0]['emailBody'];
                $emilTempletSubject=$emailinfo[0]['emailSubject'];

                $link=anchor('claim/proceed_claim/'.$crId,'Click');
                $emailBody=str_replace ("[[LINK]]", $link, $emilTemplet);
                //$emailBody="Dear customer' <br/><br/>Your request has been approved for the business claim. Please click on the following link to 
                   // complete the preocess.<br/>".anchor('claim/proceed_claim/'.$crId,'Click');
                //$subject="Claim request approved";
                @send_email($emailId,$emilTempletSubject,$emailBody);
                echo $emailBody;
            }
            
            if($status=='Rejected'){
                /*$emailBody="Dear customer' <br/><br/>Your request has been rejected for the business claim. Please click on the following link
                    .<br/>".anchor('claim/business/'.$request['crBusinessId'],'Click');
                $subject="Claim request rejected";*/
                $where_Id=array('emailId'=>'110');
                $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                
                $emilTemplet=$emailinfo[0]['emailBody'];
                $emilTempletSubject=$emailinfo[0]['emailSubject'];
                $link=anchor('claim/business/'.$request['crBusinessId'],'Click');
                $emailBody=str_replace ("[[LINK]]", $link, $emilTemplet);
                @send_email($emailId,$emilTempletSubject,$emailBody);
                
                echo $emailBody;
            }
            
            $this->mdgeneraldml->update($where,'tbl_cliam_requests',$updateData);
            //$this->session->set_flashdata('error','Claim request has been successfully '.$status);
            //redirect(ADMIN_FOLDER_NAME.'/manage_claims');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_claims');
        }
    }
    
    function delete($crId){
        $where=array('crStatus !='=>'Deleted','crId'=>$crId);
        if($crId!='' && _isRecordExist('tbl_cliam_requests',$where))
        {
            $updateData=array('crStatus'=>'Deleted','crUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where,'tbl_cliam_requests',$updateData);
            $this->session->set_flashdata('success','Claim requiest has been deleted succssfully.');
            redirect(ADMIN_FOLDER_NAME.'/manage_claims');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_claims');
        }
    }
}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */