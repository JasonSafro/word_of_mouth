<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_newsletter extends CI_Controller {
  
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
	function index($sort_by='newsId', $sort_type='DESC', $offset=0)
	{
	   # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_newsletter/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
		
		$where=array('newsStatus !='=>'deleted');
        $data = _getPagingVaiables('tbl_newsletter', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where);         
     
	 	$where="WHERE newsStatus!='deleted'";
        $data['newsletterList'] = $this->admin_model->get_newsletter_list($where,$sort_by,$sort_type,$limit,$offset);
	    $this->load->view('admin/includes/header');	
        $this->load->view('admin/manage_newsletter_vw',$data);
        $this->load->view('admin/includes/footer');	
	}
	
	function add()
	{  		 
		 $data=array('action'=>'new','newsId'=>'','newsSubject'=>'','newsMessageBody'=>'',
            'newsCreatedOn'=>'','newsUpdatedOn'=>'');
		 $this->form_validation->set_rules('newsSubject', 'News Subject', 'xss_clean|trim|required');        
         $this->form_validation->set_rules('newsMessageBody', 'News Message Body', 'xss_clean|trim|required');
		
		 if ($this->form_validation->run() == FALSE)
		 {            
             $this->load->view('admin/includes/header');	
			 $this->load->view('admin/manage_newsletter_add_edit_vw',$data);
			 $this->load->view('admin/includes/footer');
         }
		 else
		 {
		    $insertdata=array('newsSubject'		=>$this->input->post('newsSubject'),
		   			          'newsMessageBody'	=>$this->input->post('newsMessageBody'),
		                      'newsCreatedOn'	=>_getDateAndTime(),
		                      'newsUpdatedOn'	=>_getDateAndTime());
			//print_r($insertdata);
			$response=$this->mdgeneraldml->insert('tbl_newsletter',$insertdata);
			$this->session->set_flashdata('success','NewsLetter has been added successfully.');
			redirect(ADMIN_FOLDER_NAME.'/manage_newsletter');
	     }
		
	}
	function edit($newsId='',$sort_by='newsId', $sort_type='DESC', $offset=0)
	{  		 
		 $where=array('newsStatus !='=>'deleted','newsId'=>$newsId);
		 if($newsId!=NULL && _isRecordExist('tbl_newsletter',$where))
         {
		     $newsletterinfo=$this->mdgeneraldml->select('*','tbl_newsletter',$where);
			 $info=$newsletterinfo[0];
		
			 $data=array('action'=>'edit','newsId'=>$info['newsId'],'newsSubject'=>$info['newsSubject'],
				 		'newsMessageBody'=>$info['newsMessageBody'],
						'newsCreatedOn'=>$info['newsCreatedOn'],'newsUpdatedOn'=>$info['newsUpdatedOn']);
			 $this->form_validation->set_rules('newsSubject', 'News Subject', 'xss_clean|trim|required');        
			 $this->form_validation->set_rules('newsMessageBody', 'News Message Body', 'xss_clean|trim|required');
	
		 if ($this->form_validation->run() == FALSE)
		 {            
             $this->load->view('admin/includes/header');	
			 $this->load->view('admin/manage_newsletter_add_edit_vw',$data);
			 $this->load->view('admin/includes/footer');
         }
		 else
		 {
		    $updatedata=array('newsSubject'		=>$this->input->post('newsSubject'),
		   			          'newsMessageBody'	=>$this->input->post('newsMessageBody'),
		                      'newsUpdatedOn'	=>_getDateAndTime());
			$where=array('newsId'=>$newsId);
			$response=$this->mdgeneraldml->update($where,'tbl_newsletter',$updatedata);
			$this->session->set_flashdata('success','NewsLetter has been Updated successfully.');
			 redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
	     }
		}else{
            $this->session->set_flashdata('error','Record not exist.');
             redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        } 
	}
	function delete($newsId='',$sort_by='newsId', $sort_type='DESC', $offset=0)
    {	
        $where=array('newsStatus !='=>'deleted','newsId'=>$newsId);
        if($newsId!=NULL && _isRecordExist('tbl_newsletter',$where))
         {
		    $updataeData=array('newsStatus'=>'deleted','newsUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_newsletter', $updataeData);
		  
            $this->session->set_flashdata('success',"News Letter deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
         }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
         } 
    }
	function delete_selected($sort_by='newsId', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST))
        {            
            $whereIn=array('column'=>'newsId','fields'=>$_POST['chkmsg']);
            $updataeData=array('newsStatus'=>'deleted','newsUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update_in('tbl_newsletter', $updataeData,'',$whereIn);
            //echo $this->db->last_query();
            $this->session->set_flashdata('success',"selected News Letter has been deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Please select at list single record.');
            redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }    
    }
	function view($newsId='',$sort_by='newsId', $sort_type='DESC', $offset=0)
    {
        $where=array('newsStatus !='=>'deleted','newsId'=>$newsId);
        if($newsId!=NULL && _isRecordExist('tbl_newsletter',$where))
         {
            $wherenews="WHERE newsStatus!='deleted' AND newsId=$newsId";
            $data['newsInfo']=$this->admin_model->get_newsletter_list($wherenews);
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/manage_news_detailspage_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }        
    }
	function send_news_mail($newsId,$sort_by='newsId', $sort_type='DESC', $offset=0)
	{
		 $where=array('newsStatus !='=>'deleted','newsId'=>$newsId);
		 if($newsId!=NULL && _isRecordExist('tbl_newsletter',$where))
         {
		     $newsletterinfo = $this->mdgeneraldml->select('*','tbl_newsletter',$where);
			 $info=$newsletterinfo[0];
		
			 $data= array('newsId'=>$info['newsId'],'newsSubject'=>$info['newsSubject'],'newsSendStatus'=>$info['newsSendStatus'],
				 		'newsMessageBody'=>$info['newsMessageBody'],
						'newsCreatedOn'=>$info['newsCreatedOn'],'newsUpdatedOn'=>$info['newsUpdatedOn']);
						
			 $info= $this->admin_model->get_userinfo();
			 $this->form_validation->set_rules('newsSubject', 'News Subject', 'xss_clean|trim|required');        
			 $this->form_validation->set_rules('newsMessageBody', 'News Message Body', 'xss_clean|trim|required');
			 $this->form_validation->set_rules('status', 'staus', 'xss_clean|trim|required');
			 //$this->form_validation->set_rules('Email', 'Email', 'valid_email');
			 if ($this->form_validation->run() == FALSE)
			 {            
				 $this->load->view('admin/includes/header');	
				 $this->load->view('admin/manage_news_sendmail_vw',$data);
				 $this->load->view('admin/includes/footer');
			 }
			 else
			 {
				 $subject=$this->input->post('newsSubject');
				 $message=$this->input->post('newsMessageBody');
				 $status=$this->input->post('status');
				 $email=$this->input->post('Email');
				 $extra_email= explode(',',$email);
				
				 if($status == 'Yes')
				 {
					foreach($info as $value)
						{
							array_push($extra_email,$value['user_email']);
						}
						if($extra_email)
						{
							echo $extra_email= implode(',',$extra_email);
							send_email($useremails, $subject, $message);
						}
				 }
				 else
				 {
					send_email($email, $subject, $message);
				 }
				 $updatedata=array('newsSendStatus'=>'1');
				 $where=array('newsId'=>$newsId);
				 $response=$this->mdgeneraldml->update($where,'tbl_newsletter',$updatedata);
				 $this->session->set_flashdata('success',"News Letter has been sent successfully.");
				 redirect(ADMIN_FOLDER_NAME.'/manage_newsletter/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
			 }
		}
	}
}
?>