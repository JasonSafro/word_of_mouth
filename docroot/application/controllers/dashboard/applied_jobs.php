<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applied_jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index(){
        $userId=$this->session->userdata('user_id');
        
        $where="WHERE jAppApplicantUserId=$userId AND jAppStaus != 'Deleted'";
        $data['jobApplications']=$this->WGModel->getJobApplications($where);
        //echo '<pre>'; print_r($data['jobApplicationInfo']); die;
        //echo $this->db->last_query(); die;
        $data['user_id'] = $userId;
        $this->load->view('includes/header');
        $this->load->view('dashboard/applied_jobs_list_vw.php', $data);
        $this->load->view('includes/footer');
    }
    
    function view_details($jAppId)
    {
        $userId=$this->session->userdata('user_id');
        $where=array('jAppId'=>$jAppId,'jAppApplicantUserId'=>$userId,'jAppStaus !='=>'Deleted');
        if($jAppId!='' && _isRecordExist('tbl_job_applications',$where))
        {
            $where="WHERE jAppId=$jAppId AND jAppStaus != 'Deleted'";
            $data['jobApplicationInfo']=$this->WGModel->getJobApplications($where);
            //echo '<pre>'; print_r($data['jobApplicationInfo']); die;
            
            $this->load->view('includes/header');
            $this->load->view('dashboard/applied_job_detailes_vw.php', $data);
            $this->load->view('includes/footer');
            
        }else{
           $this->session->set_flashdata('error','Application not exit.');
           redirect('dashboard/applied_jobs'); 
        }
    }
    
    function delete_job_application($jAppId)
    {
        $userId=$this->session->userdata('user_id');
         $where=array('jAppId'=>$jAppId,'jAppApplicantUserId'=>$userId);
        if($jAppId!='' && _isRecordExist('tbl_job_applications',$where))
        {
            $updateInfo=array('jAppStaus'=>'Deleted','jAppUpdatedOn'=>_getDateAndTime());
            $where=array('jAppId'=>$jAppId,'jAppApplicantUserId'=>$userId);
            $this->mdgeneraldml->update($where,'tbl_job_applications',$updateInfo);
            
            $this->session->set_flashdata('success','Application has been deleted successfully.');
            redirect('dashboard/applied_jobs');
            
        }else{
           $this->session->set_flashdata('error','Application not exit.');
           redirect('dashboard/applied_jobs'); 
        }
    }
    
     function download_resume($applicationId,$docName){
        $file_path = "sitedata/resume/".$docName; 
        header('Content-Type: application/*');
        header('Content-disposition: attachment; filename='.$docName);
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
    }
    
     function download_coverlatter($applicationId,$docName){
       $file_path = "sitedata/cover_letters/".$docName; 
        header('Content-Type: application/*');
        header('Content-disposition: attachment; filename='.$docName);
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */