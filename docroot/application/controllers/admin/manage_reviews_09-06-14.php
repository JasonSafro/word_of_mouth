<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_Reviews extends CI_Controller {
  
    function __construct()  
    {
            parent::__construct();
            _authenticateAdmin();
            $this->load->model('admin_model');
            $this->load->model('mdgeneraldml');
            $this->load->library('form_validation');
            $this->load->library('pagination');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='rvwId', $sort_type='DESC', $offset=0) 
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_reviews/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        
           
        $where=array('rvwStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_business_reviews', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where); 
        
        $whereReview="WHERE rvwStatus!='Deleted'";
        $data['reviewList']=$this->admin_model->getBusinessReviews($whereReview,$sort_by,$sort_type,$limit,$offset);
        
       
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/manage_reviews_vw',$data);
        $this->load->view('admin/includes/footer');		
    }
    
    function view($rvwId='',$sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
        $where=array('rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!='' && _isRecordExist('tbl_business_reviews',$where))
        {
            $whereReview="WHERE rvwStatus!='Deleted' AND rvwId=$rvwId";
            $data['review']=$this->admin_model->getBusinessReviews($whereReview);
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/manage_reviews_detailpage_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }        
    }
    
    function save_satus($rvwId=NULL)
    {
        $where=array('rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!=NULL && _isRecordExist('tbl_business_reviews',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('rvwStatus'=>$status,'rvwUpdatedOn'=>_getDateAndTime());
            if($status=="Disputed"){
                $updataeData['rvwDesputedReason']=$this->input->post('rvwDesputedReason');
            }
            $this->mdgeneraldml->update($where, 'tbl_business_reviews', $updataeData);
            $this->session->set_flashdata('success',"Review status changed successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }      
    }
    
    function delete($rvwId='',$sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
        $where=array('rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!='' && _isRecordExist('tbl_business_reviews',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('rvwStatus'=>'Deleted','rvwUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_business_reviews', $updataeData);
            $this->session->set_flashdata('success',"Review deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        } 
    }
    
    function delete_selected($sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST))
        {            
            $whereIn=array('column'=>'rvwId','fields'=>$_POST['chkmsg']);
            $updataeData=array('rvwStatus'=>'Deleted','rvwUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update_in('tbl_business_reviews', $updataeData,'',$whereIn);
            //echo $this->db->last_query();
            $this->session->set_flashdata('success',"selected reviews has been deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Please select at list single record.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }    
    }
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */