<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Services2 extends CI_Controller {
    	function __construct() 
	{	  
		parent::__construct();		
		$this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
		$this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
		$this->load->library('session');	    //  This Library is use to When session get created.	
		$this->load->library('email');		// Email library to send mail
		$this->load->helper('url');
		$this->load->helper('cookie');
                                $this->load->helper('captcha');                               
                                $this->load->library('form_validation');                                
		
 	}
    
        //Services Page
                 public function index()
                {               //Get subscription plans
                                $tbl_subscription_plans = 'tbl_subscription_plans';
                                $data['plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_plans);
                                
                                $data['basic_plan_name']=$data['plan_details'][0]['subs_plan_name']; 
                                $data['prem_plan_name']=$data['plan_details'][1]['subs_plan_name']; 
                                
                              
                                
                                 //Get sub-subscription plans
                                $tbl_subscription_sub_plans = 'tbl_subscription_sub_plans';
                                $data['sub_plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_sub_plans);
                                
                                //basic Annually 
                                $data['basic_plan_annual_name']=$data['sub_plan_details'][0]['subs_sub_plan_name']; 
                                $data['basic_plan_annual_price']=$data['sub_plan_details'][0]['subs_sub_plan_price'];
                                //basic Monthly
                                $data['basic_plan_monthly_name']=$data['sub_plan_details'][1]['subs_sub_plan_name']; 
                                 $data['basic_plan_monthly_price']=$data['sub_plan_details'][1]['subs_sub_plan_price'];
                                //premium Annually                                
                                $data['prem_plan_annual_name']=$data['sub_plan_details'][2]['subs_sub_plan_name']; 
                                $data['prem_plan_annual_price']=$data['sub_plan_details'][2]['subs_sub_plan_price']; 
                                //premium Monthly
                                $data['prem_plan_monthly_name']=$data['sub_plan_details'][3]['subs_sub_plan_name']; 
                                $data['prem_plan_monthly_price']=$data['sub_plan_details'][3]['subs_sub_plan_price']; 
                                
                     
                                //Get service limit Details
                                $tbl_service_limits = 'tbl_service_limits';
                                $in_para=array('service_id');
                                $where_not_in=array('service_id'=>array(13,14));
                                $data['service_limits'] = $this->mdgeneraldml->select_not_in('*', $tbl_service_limits,$in_para,$where_not_in);
                               // echo $this->db->last_query(); die;
                               // echo '<pre>'; print_r($data); die;
                                
                             /*  $this->load->view('includes/header');
                                $this->load->view('services_view',$data);
                                $this->load->view('includes/footer');*/
                               // $this->load->view('includes/header');
                               $this->load->view('services_view_html3',$data);
                                 //$this->load->view('includes/footer');
                }
                
                
                 // Check Duplicate Username
                public function check_uname_dup()
                {
                    $tbl = "tbl_user";
                    $cnd = "user_name = '" . $this->input->post('username') . "' ";
                    $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
                    if (count($res_name_chk) > 0)
                    {
                        echo "false";
                    }
                    else
                    {
                        echo "true";
                    }
                }
                
                   // Check Duplicate Email
                public function check_email_dup()
                {
                    $tbl = "tbl_user";
                    $cnd = "user_email = '" . $this->input->post('user_email') . "' ";
                    $res_mail_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
                    if (count($res_mail_chk) > 0)
                    {
                        echo "false";
                    }
                    else
                    {
                        echo "true";
                    }
                }
                
                public function submitForm_basic()   
                {
                    print_r($_POST);
                }
                
                function getCountrys()
                {
                    $countryList= _getCountryList();
                    $responseArray=array();
                    
                    foreach($countryList as $key=>$val)
                    {
                        if($key!=="")
                            $responseArray[]=array('val'=>$key,'text'=>$val);
                    }
                    
                    echo json_encode($responseArray);
                }
                
                function getStateList($countryCode)
                {
                     //$st='id="userState" class="items"';//stateHolder
                    // echo form_dropdown('userState', _getStateList($countryCode),set_value('userState'),'id="userState" class="items"'); 
                    $stateList= _getStateList($countryCode);
                    foreach($stateList as $key=>$val)
                    {
                        if($key!=="")
                            $responseArray[]=array('val'=>$key,'text'=>$val);
                    }
                    
                    echo json_encode($responseArray);
                }
                
              
}

/* End of file services.php */
/* Location: ./application/controllers/services.php */