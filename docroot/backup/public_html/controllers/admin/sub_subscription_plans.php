<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Sub_subscription_plans extends CI_Controller {
  
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
        //Get Sub-Plan Details
        $tbl = 'tbl_subscription_sub_plans';       
        $data['sub_plan_List'] = $this->mdgeneraldml->select('*', $tbl);
        
        //Get Plan Details
        $tbl1 = 'tbl_subscription_plans';       
        $data['plan_List'] = $this->mdgeneraldml->select('*', $tbl1);
        $data['basic_plan_name']=$data['plan_List'][0]['subs_plan_name'];
         $data['premium_plan_name']=$data['plan_List'][1]['subs_plan_name'];
       // print_r($data);die;
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/sub_subscription_plans_view',$data);
        $this->load->view('admin/includes/footer');		
    }
    
    function edit($subs_sub_plan_id=NULL)
    {
        
        if (($subs_sub_plan_id != NULL) && ($this->admin_model->isRecordExist('tbl_subscription_sub_plans', array('subs_sub_plan_id' => $subs_sub_plan_id)))) {
                        
            $tbl = 'tbl_subscription_sub_plans';          
            $where=array('subs_sub_plan_id'=>$subs_sub_plan_id);
            $sub_planInfo = $this->mdgeneraldml->select('*', $tbl, $where);
            $info=$sub_planInfo[0];
            $data=array(
                        'subs_sub_plan_id'            =>$subs_sub_plan_id,
                        'subs_sub_plan_price'        => $info['subs_sub_plan_price'],    
                         'subs_sub_plan_period'        => $info['subs_sub_plan_period'],    
                        'action'=>'Edit',
                        'btnName'=>'Save'
                  );

            $this->form_validation->set_rules('subs_sub_plan_price', 'Subscription Plan Price', 'xss_clean|trim|required');            

            if ($this->form_validation->run() == FALSE)
            {               
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/sub_subscription_plans_edit_view',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                $updateData=array(
                        'subs_sub_plan_price'     =>$this->input->post('subs_sub_plan_price'),                                       
                        'subs_sub_plan_updated_on'     =>_getDateAndTime()
                  );

               $tableName = 'tbl_subscription_sub_plans';
               $where = array('subs_sub_plan_id' => $subs_sub_plan_id);
               $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
               $this->session->set_flashdata('success', 'Plan has been successfully updated.');
               redirect(ADMIN_FOLDER_NAME.'/sub_subscription_plans');
            }
        }
        else
        {
            $this->session->set_flashdata('error', '!! Plan not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/sub_subscription_plans');
        }
    }
    /*
     function change_status($subs_plan_id=NULL, $status=NULL) 
    {
        if (($subs_plan_id != NULL) && ($this->admin_model->isRecordExist('tbl_subscription_plans', array('subs_plan_id' => $subs_plan_id)))) {
            $updateData = array(
                'subs_plan_status' => $status,
                'subs_plan_updated_on' => _getDateAndTime()
            );
            $tableName = 'tbl_subscription_plans';
            $where = array('subs_plan_id' => $subs_plan_id);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Status has been successfully changed.');
            redirect(ADMIN_FOLDER_NAME.'/subscription_plans/');
        }else {
            $this->session->set_flashdata('error', '!! Plan not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/subscription_plans');
        }
    }*/
}