<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class advance_saved_search extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }
	function index() 
    {  
        
        $data['searchList'] = $this->mdgeneraldml->select('*','tbl_advance_search');
		$this->load->view('includes/header');
        $this->load->view('dashboard/advance_saved_search_view', $data);
        $this->load->view('includes/footer');
    }
	function delete($srhId)
	{
		$where=array('search_id'=>$srhId);
        if($srhId!=NULL && _isRecordExist('tbl_advance_search',$where))
         {
			$this->mdgeneraldml->delete($where, 'tbl_advance_search');
		    $this->session->set_flashdata('success',"deleted successfully.");
            redirect('dashboard/advance_saved_search');
         }else{
            $this->session->set_flashdata('error','Record not exist.');
           redirect('dashboard/advance_saved_search');
         } 
	}
	function delete_selected()
    {
        if(!empty($_POST))
        {            
            $whereIn=array('column'=>'search_id','fields'=>$_POST['chkmsg']);
            
            $this->mdgeneraldml->delete_in('tbl_advance_search',$whereIn);
            //echo $this->db->last_query();
            $this->session->set_flashdata('success',"selected search has been deleted successfully.");
            redirect('dashboard/advance_saved_search');
        }else{
            $this->session->set_flashdata('error','Please select at list single record.');
             redirect('dashboard/advance_saved_search');
        }    
    }
	
}