<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_Jobs extends CI_Controller {
  
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

    function index($sort_by='jobId', $sort_type='DESC', $offset=0)
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_jobs/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        
           
        $where=array('jobStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_jobs', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where);         
        
        
        $whereJobs="WHERE jobStatus!='Deleted'";
        $data['jobList'] = $this->admin_model->getJobList($whereJobs,$sort_by,$sort_type,$limit,$offset);
        //echo $this->db->last_query(); die;
        //echo '<pre>'; print_r($data['jobList']); die;
       
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/manage_jobs_vw',$data);
        $this->load->view('admin/includes/footer');		
    }
    
    function view($jobId='',$sort_by='jobId', $sort_type='DESC', $offset=0)
    {
        $where=array('jobStatus !='=>'Deleted','jobId'=>$jobId);
        if($jobId!='' && _isRecordExist('tbl_jobs',$where))
        {
            $whereJob="WHERE jobStatus!='Deleted' AND jobId=$jobId";
            $data['jobInfo']=$this->admin_model->getJobList($whereJob);
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/manage_jobs_detailpage_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }        
    }
    
    function add()
    {
        $data=array(
            'action'=>'new','jobId'=>'','jobBusinessId'=>'','jobUserId'=>'','jobPostDate'=>'',
            'jobTypeId'=>'','jobTitle'=>'','jobExperiance'=>'','jobDescription'=>'','jobDutiesAndResponsibilities'=>'',
            'jobRequiredQualifications'=>'','jobDesiredQualifications'=>'','jobAdditionalInformation'=>''
        );
        
        $this->form_validation->set_rules('jobBusinessId', 'Business Name', 'xss_clean|trim|required');        
        $this->form_validation->set_rules('jobPostDate', 'Post date', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobTypeId', 'Job type', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobTitle', 'Job title', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobExperiance', 'Experiance', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobDescription', 'Description', 'xss_clean|trim|required');
        $this->form_validation->set_rules('jobDutiesAndResponsibilities', 'Duties/Responsibilities', 'xss_clean|trim');
        $this->form_validation->set_rules('jobRequiredQualifications', 'Required qualifications', 'xss_clean|trim');
        $this->form_validation->set_rules('jobDesiredQualifications', 'Desired qualifications', 'xss_clean|trim');
        $this->form_validation->set_rules('jobAdditionalInformation', 'Additional Information', 'xss_clean|trim');
       
       
        if ($this->form_validation->run() == FALSE){            
             $this->load->view('admin/includes/header');	
             $this->load->view('admin/manage_jobs_add_edit_vw',$data);
             $this->load->view('admin/includes/footer');
        }else{
            
            //get user id
            $selecteBusinessId=$this->input->post('jobBusinessId');
            $BusinessInfo=$this->mdgeneraldml->select('user_id','tbl_business_info',array('buss_id'=>$selecteBusinessId));
            $businessUserId=$BusinessInfo[0]['user_id'];
            
           $insertData=array(
               'jobUserId'=>$businessUserId,
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
           $this->session->set_flashdata('success','Job has been added successfully.');
           redirect(ADMIN_FOLDER_NAME.'/manage_jobs');
        }   
    }
    
    
    function edit($jobId='',$sort_by='jobId', $sort_type='DESC', $offset=0)
    {
        $where=array('jobStatus !='=>'Deleted','jobId'=>$jobId);
        if($jobId!=NULL && _isRecordExist('tbl_jobs',$where))
        {
            
            $jobInfo=$this->mdgeneraldml->select('*','tbl_jobs',$where);
            $info=$jobInfo[0];
        
            $data=array(
                'action'=>'edit','jobId'=>$jobId,'jobBusinessId'=>$info['jobBusinessId'],'jobUserId'=>$info['jobUserId'],'jobPostDate'=>$info['jobPostDate'],
                'jobTypeId'=>$info['jobTypeId'],'jobTitle'=>$info['jobTitle'],'jobExperiance'=>$info['jobExperiance'],'jobDescription'=>$info['jobDescription'],'jobDutiesAndResponsibilities'=>$info['jobDutiesAndResponsibilities'],
                'jobRequiredQualifications'=>$info['jobRequiredQualifications'],'jobDesiredQualifications'=>$info['jobDesiredQualifications'],'jobAdditionalInformation'=>$info['jobAdditionalInformation']
            );

            $this->form_validation->set_rules('jobBusinessId', 'Business Name', 'xss_clean|trim|required');        
            $this->form_validation->set_rules('jobPostDate', 'Post date', 'xss_clean|trim|required');
            $this->form_validation->set_rules('jobTypeId', 'Job type', 'xss_clean|trim|required');
            $this->form_validation->set_rules('jobTitle', 'Job title', 'xss_clean|trim|required');
            $this->form_validation->set_rules('jobExperiance', 'Experiance', 'xss_clean|trim|required');
            $this->form_validation->set_rules('jobDescription', 'Description', 'xss_clean|trim|required');
            $this->form_validation->set_rules('jobDutiesAndResponsibilities', 'Duties/Responsibilities', 'xss_clean|trim');
            $this->form_validation->set_rules('jobRequiredQualifications', 'Required qualifications', 'xss_clean|trim');
            $this->form_validation->set_rules('jobDesiredQualifications', 'Desired qualifications', 'xss_clean|trim');
            $this->form_validation->set_rules('jobAdditionalInformation', 'Additional Information', 'xss_clean|trim');


            if ($this->form_validation->run() == FALSE){            
                 $this->load->view('admin/includes/header');	
                 $this->load->view('admin/manage_jobs_add_edit_vw',$data);
                 $this->load->view('admin/includes/footer');
            }else{

                //get user id
                $selecteBusinessId=$this->input->post('jobBusinessId');
                $BusinessInfo=$this->mdgeneraldml->select('user_id','tbl_business_info',array('buss_id'=>$selecteBusinessId));
                $businessUserId=$BusinessInfo[0]['user_id'];

               $updataeData=array(
                   'jobUserId'=>$businessUserId,
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
                   'jobUpdatedOn'=>_getDateAndTime(),
               );
               //echo '<pre>'; print_r($insertData); die;
               $where=array('jobId'=>$jobId);
               $response=$this->mdgeneraldml->update($where,'tbl_jobs',$updataeData);//last_insertId
               $this->session->set_flashdata('success','Job has been edited successfully.');
               redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
            }
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }    
    }
    
    function save_satus($jobId=NULL)
    {
        $where=array('jobStatus !='=>'Deleted','jobId'=>$jobId);
        if($jobId!=NULL && _isRecordExist('tbl_jobs',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('jobStatus'=>$status,'jobUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_jobs', $updataeData);
            $this->session->set_flashdata('success',"Review status changed successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs');
        }      
    }
    
    function delete($jobId='',$sort_by='jobId', $sort_type='DESC', $offset=0)
    {
        $where=array('jobStatus !='=>'Deleted','jobId'=>$jobId);
        if($jobId!='' && _isRecordExist('tbl_jobs',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('jobStatus'=>'Deleted','jobUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_jobs', $updataeData);
            $this->session->set_flashdata('success',"Job deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        } 
    }
    
    function delete_selected($sort_by='jobId', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST))
        {            
            $whereIn=array('column'=>'jobId','fields'=>$_POST['chkmsg']);
            $updataeData=array('jobStatus'=>'Deleted','jobUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update_in('tbl_jobs', $updataeData,'',$whereIn);
            //echo $this->db->last_query();
            $this->session->set_flashdata('success',"selected jobs has been deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Please select at list single record.');
            redirect(ADMIN_FOLDER_NAME.'/manage_jobs/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }    
    }
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */