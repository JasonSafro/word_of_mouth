<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Subscription_plans extends CI_Controller {
  
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
        //Get Plan Details
        $tbl = 'tbl_subscription_plans';       
        $data['plan_List'] = $this->mdgeneraldml->select('*', $tbl);
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/subscription_plans_view',$data);
        $this->load->view('admin/includes/footer');		
    }
    
     function view_details($subs_plan_id=NULL)
    {
        if($subs_plan_id!=NULL && ($this->admin_model->isRecordExist('tbl_subscription_plans', array('subs_plan_id' => $subs_plan_id))))
        {
           $data['plan_view']= $this->mdgeneraldml->select("*","tbl_subscription_plans",array("subs_plan_id"=>$subs_plan_id));           
            $data['subs_plan_id']=$subs_plan_id;
            $data['sub_plan_view']= $this->mdgeneraldml->select("*","tbl_subscription_sub_plans",array("subs_plan_id"=>$subs_plan_id));  
            
          //  echo '<pre>'; print_r($data); die;
            $data['plan_name']=$data['plan_view'][0]['subs_plan_name']; 
            
            $data['ann_price']= $data['sub_plan_view'][0]['subs_sub_plan_price'];             
            $data['ann_price_period']= $data['sub_plan_view'][0]['subs_sub_plan_period']; 
            $data['ann_price_created_date']= $data['sub_plan_view'][0]['subs_sub_plan_created_on']; 
            $data['ann_price_updated_date']= $data['sub_plan_view'][0]['subs_sub_plan_updated_on']; 
            
            $data['mon_price']=  $data['sub_plan_view'][1]['subs_sub_plan_price'];
            $data['mon_price_period']=  $data['sub_plan_view'][1]['subs_sub_plan_period']; 
            $data['mon_price_created_date']=  $data['sub_plan_view'][1]['subs_sub_plan_created_on']; 
            $data['mon_price_updated_date']=  $data['sub_plan_view'][1]['subs_sub_plan_updated_on']; 
             
            $this->load->view('admin/includes/header');
            $this->load->view('admin/subscription_plans_details_view',$data);
           $this->load->view('admin/includes/footer');
           
        }else{
             $this->session->set_flashdata('error', '!! Plan not exist.!!');
             redirect(ADMIN_FOLDER_NAME.'/subscription_plans');
        } 
    }
    
    function edit($subs_plan_id=NULL)
    {
        
        if (($subs_plan_id != NULL) && ($this->admin_model->isRecordExist('tbl_subscription_plans', array('subs_plan_id' => $subs_plan_id)))) {
                        
            $tbl = 'tbl_subscription_plans';          
            $where=array('subs_plan_id'=>$subs_plan_id);
            $planInfo = $this->mdgeneraldml->select('*', $tbl, $where);
            $info=$planInfo[0];
            $data=array(
                        'subs_plan_id'            =>$subs_plan_id,
                        'subs_plan_name'        => $info['subs_plan_name'],                                                    
                        'action'=>'Edit',
                        'btnName'=>'Save'
                  );

            $this->form_validation->set_rules('subs_plan_name', 'Subscription Plan Name', 'xss_clean|trim|required');            

            if ($this->form_validation->run() == FALSE)
            {               
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/subscription_plans_edit_view',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                $updateData=array(
                        'subs_plan_name'     =>$this->input->post('subs_plan_name'),                                       
                        'subs_plan_updated_on'     =>_getDateAndTime()
                  );

               $tableName = 'tbl_subscription_plans';
               $where = array('subs_plan_id' => $subs_plan_id);
               $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
               $this->session->set_flashdata('success', 'Plan has been successfully updated.');
               redirect(ADMIN_FOLDER_NAME.'/subscription_plans');
            }
        }
        else
        {
            $this->session->set_flashdata('error', '!! Plan not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/subscription_plans');
        }
    }
    
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
    }
}