<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobs extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        _authenticatePrimiumUser();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index(){
        $userId=$this->session->userdata('user_id');
        /*$table = 'tbl_jobs';        
        $where= array('dealUserId' => $userId);
        $data['dealList'] = $this->mdgeneraldml->select('*', $table, $where);*/
        $where="WHERE j.jobUserId=$userId AND jobStatus!='Deleted'";
        $data['jobList'] = $this->WGModel->getJobList($where);
        
        $data['user_id'] = $userId;
        $this->load->view('includes/header');
        $this->load->view('dashboard/jobs_list_vw', $data);
        $this->load->view('includes/footer');
    }
    
    
    function new_job()
    {
        //__myBusinessDropdown

        $userId=$this->session->userdata('user_id');
        $data=array('user_id'=>$userId);
        
        $where="WHERE j.jobUserId=$userId";
        $data['jobList'] = $this->WGModel->getJobList($where);
        
        $this->form_validation->set_rules('jobBusinessId', 'Business Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobPostDate', 'Post date', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobTypeId', 'Job type', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobTitle', 'Job title', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobExperiance', 'Experiance', 'xss_clean|trim|required');//|numeric|callback_numeric_dot');
        $this->form_validation->set_rules('jobDescription', 'Description', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobDutiesAndResponsibilities', 'Duties/Responsibilities', 'xss_clean|trim');
        $this->form_validation->set_rules('jobRequiredQualifications', 'Required qualifications', 'xss_clean|trim');
        $this->form_validation->set_rules('jobDesiredQualifications', 'Desired qualifications', 'xss_clean|trim');
        $this->form_validation->set_rules('jobAdditionalInformation', 'Additional Information', 'xss_clean|trim');
       
       
        if ($this->form_validation->run() == FALSE){            
            $this->load->view('includes/header');
            $this->load->view('dashboard/jobs_list_vw', $data);
            //$this->load->view('dashboard/deal_add_edit_vw', $data);
            $this->load->view('includes/footer');
        }else{
           $insertData=array(
               'jobUserId'=>$userId,
               'jobBusinessId'=>$this->input->post('jobBusinessId'),
               'jobPostDate'=>$this->input->post('jobPostDate'),
               'jobTypeId'=>$this->input->post('jobTypeId'),
               'jobTitle'=>$this->input->post('jobTitle'),
               'jobExperiance'=>$this->input->post('jobExperiance'),
               'jobDescription'=>$this->input->post('jobDescription'),
               'jobDutiesAndResponsibilities'=>$this->input->post('jobDutiesAndResponsibilities'),
               'jobRequiredQualifications'=>$this->input->post('jobRequiredQualifications'),
               'jobDesiredQualifications'=>$this->input->post('jobDesiredQualifications'),
               'jobAdditionalInformation'=>$this->input->post('jobAdditionalInformation'),
               'jobCreatedOn'=>_getDateAndTime(),
               'jobUpdatedOn'=>_getDateAndTime(),
           );
           //echo '<pre>'; print_r($insertData); die;
           $response=$this->mdgeneraldml->insert('tbl_jobs',$insertData);//last_insertId

           //Send email to admin;
           $buss_id=$this->input->post('jobBusinessId');
           $sql="SELECT buss_name from tbl_business_info WHERE buss_id = $buss_id ";
           $bussinfo =$this->WGModel->sqlQuery($sql);
           
           $where=array('emailId'=>'108');
           $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where);
           
           $emilTemplet=$emailinfo[0]['emailBody'];
           $emilTempletSubject=$emailinfo[0]['emailSubject'];
           
           $sql="SELECT CONCAT(user_fname,' ',user_lname) as userFullName from tbl_user WHERE user_id=$userId";
           $publisherInfo=$this->WGModel->sqlQuery($sql);
            
           $emailBody=str_replace ("[[JOB_TITLE]]", $insertData['jobTitle'], $emilTemplet);
           $emailBody=str_replace ("[[BUSINESS_NAME]]", $bussinfo[0]['buss_name'], $emilTemplet);
           $emailBody=str_replace ("[[USER_FULL_NAME]]", $publisherInfo[0]['userFullName'], $emailBody);
           send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody);

           $this->session->set_flashdata('success','Job has been added successfully.');
           redirect('dashboard/jobs#success');
        }
    }
    
    function edit()
    {        
        //__myBusinessDropdown
        $userId=$this->session->userdata('user_id');
        $data=array('user_id'=>$userId);


        $this->form_validation->set_rules('jobId', 'Job Id', 'required');//this is hidden field but it require 
        $this->form_validation->set_rules('jobBusinessId', 'Business Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobPostDate', 'Post date', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobTypeId', 'Job type', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobTitle', 'Job title', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobExperiance', 'Experiance', 'xss_clean|trim|required');//|numeric|callback_numeric_dot');
        $this->form_validation->set_rules('jobDescription', 'Description', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobDutiesAndResponsibilities', 'Duties/Responsibilities', 'xss_clean|trim');
        $this->form_validation->set_rules('jobRequiredQualifications', 'Required qualifications', 'xss_clean|trim');
        $this->form_validation->set_rules('jobDesiredQualifications', 'Desired qualifications', 'xss_clean|trim');
        $this->form_validation->set_rules('jobAdditionalInformation', 'Additional Information', 'xss_clean|trim');
        if ($this->form_validation->run() == FALSE){
            
            $where="WHERE j.jobUserId=$userId";
            $data['jobList'] = $this->WGModel->getJobList($where);
            
            $this->load->view('includes/header');
            $this->load->view('dashboard/jobs_list_vw', $data);
            $this->load->view('includes/footer');
        }else{
           
            $jobId=$this->input->post('jobId');
            $where=array('jobUserId'=>$userId,'jobId'=>$jobId);
            if($jobId!='' && _isRecordExist('tbl_jobs',$where))
            {
               $insertData=array(                                      
                   'jobBusinessId'=>$this->input->post('jobBusinessId'),
                   'jobPostDate'=>$this->input->post('jobPostDate'),
                   'jobTypeId'=>$this->input->post('jobTypeId'),
                   'jobTitle'=>$this->input->post('jobTitle'),
                   'jobExperiance'=>$this->input->post('jobExperiance'),
                   'jobDescription'=>$this->input->post('jobDescription'),
                   'jobDutiesAndResponsibilities'=>$this->input->post('jobDutiesAndResponsibilities'),
                   'jobRequiredQualifications'=>$this->input->post('jobRequiredQualifications'),
                   'jobDesiredQualifications'=>$this->input->post('jobDesiredQualifications'),
                   'jobAdditionalInformation'=>$this->input->post('jobAdditionalInformation'),                  
                   'jobUpdatedOn'=>_getDateAndTime()
               );
               // echo '<pre>'; print_r($insertData); die;
               $this->mdgeneraldml->update($where,'tbl_jobs',$insertData);
               $this->session->set_flashdata('success','Job has been successfully edited.');
               redirect('dashboard/jobs#success');
               
               
            }else{
                $this->session->set_flashdata('error','Job not exit.');
                redirect('dashboard/jobs');
            }
        }        
    }   
    function callback_numeric_dot ($str)
    {
        return preg_match('/^[0-9.]+$/', $str);
    }
    
    function getJob($jobId)
    {
        $userId=$this->session->userdata('user_id');
        $where=array('jobUserId'=>$userId,'jobId'=>$jobId);
        if($jobId!='' && _isRecordExist('tbl_jobs',$where))
        {
            $where="WHERE j.jobUserId=$userId AND jobId=$jobId";
            $jobInfo= $this->WGModel->getJobList($where);
            $jobInfo = $jobInfo[0];
            //echo '<pre>'; print_r($jobInfo); die;
            $result=array(
                   'user_id'=>$userId,
                   'jobBusinessId'=>$jobInfo['jobBusinessId'],
                   'jobPostDate'=>$jobInfo['jobPostDate'],
                   'jobTypeId'=>$jobInfo['jobTypeId'],
                   'jobTitle'=>$jobInfo['jobTitle'],
                   'jobExperiance'=>$jobInfo['jobExperiance'],
                   'jobDescription'=>$jobInfo['jobDescription'],
                   'jobDutiesAndResponsibilities'=>$jobInfo['jobDutiesAndResponsibilities'],
                   'jobRequiredQualifications'=>$jobInfo['jobRequiredQualifications'],
                   'jobDesiredQualifications'=>$jobInfo['jobDesiredQualifications'],
                   'jobAdditionalInformation'=>$jobInfo['jobAdditionalInformation'],
                );
            $result['status']='success';
            echo json_encode($result);
        }else{
            $result['status']='fail';
            echo json_encode($result);
        }
    }
    
    function view_applicants($jobId)
    {
        $userId=$this->session->userdata('user_id');
        $where=array('jobUserId'=>$userId,'jobId'=>$jobId);
        if($jobId!='' && _isRecordExist('tbl_jobs',$where))
        {
            $where="WHERE j.jobUserId=$userId AND jobId=$jobId";
            $data['jobInfo']= $this->WGModel->getJobList($where);
            //echo '<pre>'; print_r($data['jobInfo']); die;
            
            $where="WHERE jAppJobId=$jobId AND jAppStaus != 'Deleted'";
            $data['jobApplications']=$this->WGModel->getJobApplications($where);
            //echo '<pre>'; print_r($data['jobApplications']); die;
            
            $this->load->view('includes/header');
            $this->load->view('dashboard/job_applications_list_vw', $data);
            $this->load->view('includes/footer');
            
        }else{
           $this->session->set_flashdata('error','Job not exit.');
           redirect('dashboard/jobs'); 
        }
    }
    
    function view_applicant_details($jAppId)
    {
        //$userId=$this->session->userdata('user_id');
        $where=array('jAppId'=>$jAppId);
        if($jAppId!='' && _isRecordExist('tbl_job_applications',$where))
        {
            $where="WHERE jAppId=$jAppId AND jAppStaus != 'Deleted'";
            $data['jobApplicationInfo']=$this->WGModel->getJobApplications($where);
            //echo '<pre>'; print_r($data['jobApplicationInfo']); die;
            
            $this->load->view('includes/header');
            $this->load->view('dashboard/job_applicant_detailed_vw', $data);
            $this->load->view('includes/footer');
            
        }else{
           $this->session->set_flashdata('error','Job not exit.');
           redirect('dashboard/jobs'); 
        }
    }
    
    function change_application_status($jAppId)
    {
        $userId=$this->session->userdata('user_id');
        $where=array('jAppId'=>$jAppId,'jAppApplicantUserId'=>$userId);
	    if($jAppId!='' && _isRecordExist('tbl_job_applications',$where))
        {
            $info=$this->mdgeneraldml->select('jAppJobId','tbl_job_applications',$where);
            
            $status=$this->input->post('jAppStaus');
            $updateInfo=array('jAppStaus'=>$status,'jAppUpdatedOn'=>_getDateAndTime());
            
            $this->mdgeneraldml->update($where,'tbl_job_applications',$updateInfo);
            
            $this->session->set_flashdata('success',"Job application has been $status");
            redirect('dashboard/jobs/view_applicant_details/'.$jAppId);
            
        }else{
           $this->session->set_flashdata('error','No application exist');
           redirect('dashboard/jobs'); 
        }
    }
    
    function delete_job_application($jAppId)
    {
        $userId=$this->session->userdata('user_id');
        $where=array('jAppId'=>$jAppId,'jAppBusinessUserId'=>$userId);
        if($jAppId!='' && _isRecordExist('tbl_job_applications',$where))
        {
            $info=$this->mdgeneraldml->select('jAppJobId','tbl_job_applications',$where);
            
            $updateInfo=array('jAppStaus'=>'Deleted','jAppUpdatedOn'=>_getDateAndTime());
            $where=array('jAppId'=>$jAppId,'jAppBusinessUserId'=>$userId);
            $this->mdgeneraldml->update($where,'tbl_job_applications',$updateInfo);
            
            $this->session->set_flashdata('success','Job application has been deleted successfully.');
            redirect('dashboard/jobs/view_applicants/'.$info[0]['jAppJobId']);
            
        }else{
           $this->session->set_flashdata('error','Job not exit.');
           redirect('dashboard/jobs'); 
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