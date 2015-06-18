<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_services extends CI_Controller {
  
    function __construct()  
    {
            parent::__construct();
            _authenticateAdmin();
            //$this->load->model('db_transact_model');
            $this->load->model('admin_model');
            $this->load->model('mdgeneraldml');
            $this->load->library('form_validation');
            $this->load->library('pagination');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }


function index() 
    { 
        $tbl = 'tbl_service_limits';       
        $data['service_List'] = $this->mdgeneraldml->select('*', $tbl);
        
       //Get Plan Details
        $tbl1 = 'tbl_subscription_plans';       
        $data['plan_List'] = $this->mdgeneraldml->select('*', $tbl1);
        $data['basic_plan_name']=$data['plan_List'][0]['subs_plan_name'];
        $data['premium_plan_name']=$data['plan_List'][1]['subs_plan_name'];
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/manage_services_view',$data);
        $this->load->view('admin/includes/footer');		
    }
    
    function edit($service_id=NULL)
    {
        //Get Plan Details            
        if (($service_id != NULL) && ($this->admin_model->isRecordExist('tbl_service_limits', array('service_id' => $service_id)))) {
                        
            $tbl = 'tbl_service_limits';          
            $where=array('service_id'=>$service_id);
            $serviceInfo = $this->mdgeneraldml->select('*', $tbl, $where);
            
            
            $info=$serviceInfo[0];
            $data=array(
                        'service_id'            =>$service_id,
                        'service_name'        => $info['service_name'],
                        'service_basic_limit'=>$info['service_basic_limit'],
                        'service_premium_limit'=>$info['service_premium_limit'],
                        'service_description'=>$info['service_description'],                
                        'action'=>'Edit',
                        'btnName'=>'Save'
                  );
            $tbl1 = 'tbl_subscription_plans';
            $data['plan_List'] = $this->mdgeneraldml->select('*', $tbl1);
            $data['basic_plan_name'] = $data['plan_List'][0]['subs_plan_name'];
            $data['premium_plan_name'] = $data['plan_List'][1]['subs_plan_name'];
            $this->form_validation->set_rules('service_name', 'Service Name', 'xss_clean|trim|required');
            $this->form_validation->set_rules('service_description', 'Service Description', 'xss_clean|trim|required');
            

            if ($this->form_validation->run() == FALSE)
            {               
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/manage_services_edit_view',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                $updateData=array(
                    'service_name' => $this->input->post('service_name'),
                    'service_basic_limit' => $this->input->post('service_basic_limit'),
                    'service_premium_limit' => $this->input->post('service_premium_limit'),
                    'service_description' => $this->input->post('service_description'),
                    'service_updated_on' => _getDateAndTime()
                  );

               $tableName = 'tbl_service_limits';
               $where = array('service_id' => $service_id);
               $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
               $this->session->set_flashdata('success', 'Service has been successfully updated.');
               redirect(ADMIN_FOLDER_NAME.'/manage_services');
            }
        }
        else
        {
            $this->session->set_flashdata('error', '!! Service not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_services');
        }
    }
    
     function change_status_basic($service_id=NULL, $status=NULL) 
    {
        if (($service_id != NULL) && ($this->admin_model->isRecordExist('tbl_service_limits', array('service_id' => $service_id)))) {
            $updateData = array(
                'service_basic_status' => $status,
                'service_updated_on' => _getDateAndTime()
            );
            $tableName = 'tbl_service_limits';
            $where = array('service_id' => $service_id);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Status has been successfully changed.');
            redirect(ADMIN_FOLDER_NAME.'/manage_services/');
        }else {
            $this->session->set_flashdata('error', '!! Service not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_services');
        }
    }
    
         function change_status_premium($service_id=NULL, $status=NULL) 
    {
        if (($service_id != NULL) && ($this->admin_model->isRecordExist('tbl_service_limits', array('service_id' => $service_id)))) {
            $updateData = array(
                'service_premium_status' => $status,
                'service_updated_on' => _getDateAndTime()
            );
            $tableName = 'tbl_service_limits';
            $where = array('service_id' => $service_id);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Status has been successfully changed.');
            redirect(ADMIN_FOLDER_NAME.'/manage_services/');
        }else {
            $this->session->set_flashdata('error', '!! Service not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_services');
        }
    }
}