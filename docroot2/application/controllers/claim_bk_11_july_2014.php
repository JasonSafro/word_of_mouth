<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

use PayPal\Api\Address;
use PayPal\Api\Amount;
use PayPal\Api\CreditCard;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\FundingInstrument;
use PayPal\Api\Transaction;
//for direct paypal (all above plus bellow)
use PayPal\Api\RedirectUrls;
//when direct paypal redirect requires following files 
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
//to make payment using saved creadit card
use PayPal\Api\CreditCardToken;
use PayPal\Auth\OAuthTokenCredential;

session_start();

class Claim extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model
        $this->load->model('website_general_model', 'WGModel');
        $this->load->library("geozip");
        $this->load->library('session');//  This Library is use to When session get created.	
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->library('upload');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

   function business($businessId=NULL)
    {  
        $this->form_validation->set_error_delimiters('<span style="float:left;color: #EE0101 !important;">', '</span>');
        $where=array('buss_id'=>$businessId,'isThisBusinessAddedByAdmin'=>'Yes');
        if($businessId==NULL || !_isRecordExist('tbl_business_info',$where))
        { 
            $this->session->set_userdata('error','You can not claim this business.');
            redirect('home');
        }
        
        $this->load->helper('recaptcha_helper');
        $captcha_arr = array();
        $publickey = "6LcXzcgSAAAAAEtPB9l9RrHg7BrC-FTa6UzjuuND"; // you got this from the signup page	
        $privatekey = "6LcXzcgSAAAAACxyujcV7sn8w7NmvN6KUYnLDJKV";
        $captcha_arr = recaptcha_get_html($publickey);		
        $data['cap_img'] = $captcha_arr;
        $data['recaptcha_response_field'] = '';
        $recaptcha_response_field="";
        $error ='';


        //business info
        $bus_Info = $this->mdgeneraldml->select('*', 'tbl_business_info',  array('buss_id' => $businessId));
        $data['info'] = $bus_Info[0];
        //echo '<pre>'; print_r($data['info']); die;
        if($_POST)
        {
            //CAPTCHA VALIDATION
            $resp = recaptcha_check_answer ($privatekey,$_SERVER["REMOTE_ADDR"],$_POST["recaptcha_challenge_field"],$_POST["recaptcha_response_field"]);
            if (!$resp->is_valid)
            {
                    $capResult = true;					
            }else
            {
                    $capResult = false;				
            }

            $capcha_arr = recaptcha_get_html($publickey,$error);
            //print_r($capcha_arr);

            $this->form_validation->set_rules('haveAcccount', 'Account', 'xss_clean|trim|required');
            if($this->input->post('haveAcccount')=='yes'){
                $this->form_validation->set_rules('userName', 'Username or email', 'xss_clean|trim|required');
                $this->form_validation->set_rules('userPassword', 'Password', 'xss_clean|trim|required|callback_checkUserIsExist');
            }
            $this->form_validation->set_rules('crBussPhoneNo', 'Business phone number', 'xss_clean|trim|required');
            $this->form_validation->set_rules('crBussOfficeAddress', 'Business official address', 'xss_clean|trim|required');
            $this->form_validation->set_rules('crBussOfficialEmail', 'Business official email address', 'xss_clean|trim|required|valid_email');
            //$this->form_validation->set_rules('crBussAdditionalInfo', 'Additional information', 'xss_clean|trim|required');


            if ($this->form_validation->run() == FALSE or $capResult)
            { 
                $data['captcha_error'] = 'Invalid Captcha';
                $this->load->view('includes/header');
                $this->load->view('cliam_a_business_vw',$data);
                $this->load->view('includes/footer');
            }else{
                
                $crRequesterUserId=0;
                if($this->input->post('haveAcccount')=='yes'){
                    $userName=$this->input->post('userName');
                    $userPassword=md5($this->input->post('userPassword'));
                    $where="SELECT user_id FROM tbl_user WHERE user_password='".$userPassword."' AND (user_name='".$userName."' OR user_email='".$userName."')";
                    $r=$this->WGModel->sqlQuery($where);                
                    if(!empty($r))
                        $crRequesterUserId=$r[0]['user_id'];
                }
                
                $crBussPhoneNo=$this->input->post('crBussPhoneNo');
                $crBussOfficeAddress=$this->input->post('crBussOfficeAddress');
                $crBussOfficialEmail=$this->input->post('crBussOfficialEmail');			
                $crBussAdditionalInfo=$this->input->post('crBussAdditionalInfo');

                $insertData=array(
                   'crRequesterUserId'=>$crRequesterUserId,'crBusinessId'=>$businessId,
                   'crBussPhoneNo'=>$crBussPhoneNo,'crBussOfficeAddress'=>$crBussOfficeAddress,'crBussOfficialEmail'=>$crBussOfficialEmail,
                   'crBussAdditionalInfo'=>$crBussAdditionalInfo,'crCreatedOn'=>_getDateAndTime(),'crUpdatedOn'=>_getDateAndTime());

                $clmRes=$this->mdgeneraldml->insert('tbl_cliam_requests',$insertData);
                $claimId=$clmRes['last_insertId'];
                //admin/manage_claims/view
                
                //send claim request to admin
                $where_Id=array('emailId'=>'117');
                $emailinfo=$this->mdgeneraldml->select('emailBody,emailSubject','tbl_email_contents',$where_Id);
                        
                $emilTemplet=$emailinfo[0]['emailBody'];
                $emilTempletSubject=$emailinfo[0]['emailSubject'];
                
                $businessName=$data['info']['buss_name'];
                //$businessLink=anchor('home/business_details/'.$businessId,'Click Here');
                //$claimLink=anchor('admin/manage_claims/view/'.$claimId,'Click Here');
                
                $bLink=site_url('home/business_details/'.$businessId);
                $businessLink='<a href="'.$bLink.'">Click Here</a>';
                
                $cLink=site_url('admin/manage_claims/view/'.$claimId);
                $claimLink='<a href="'.$cLink.'">Click Here</a>';
                
                $emailBody=str_replace ("[[BUSINESS_NAME]]", $businessName, $emilTemplet);
                $emailBody=str_replace ("[[BUSINESS_LINK]]", $businessLink, $emailBody);
                $emailBody=str_replace ("[[CLAIM_LINK]]", $claimLink, $emailBody);
                @send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody); 
                
                //echo $emailBody; die;
                
                $this->session->set_flashdata('success','Your claim request sent successfully.');
                redirect('claim/business/'.$businessId);
            }     
        }   
        else
        {
            $this->load->view('includes/header');
            $this->load->view('cliam_a_business_vw',$data);
            $this->load->view('includes/footer');

        }
            
    }
    
    function checkUserIsExist($password)
    {
        $password=md5($password);
        $userName=$this->input->post('userName');
        $where="SELECT count(*) as numUsers FROM tbl_user WHERE user_password='".$password."' AND (user_name='".$userName."' OR user_email='".$userName."')";
        $r=$this->WGModel->sqlQuery($where);
        if($r[0]['numUsers']==1){
            return TRUE;
        }else{
            $this->form_validation->set_message('checkUserIsExist', 'Invalid username or password.');
            return FALSE;
        }
    }
    
    function proceed_claim($crId='')
    {
        //echo $this->session->userdata('claimRequestId'); die;
        $where=array('crStatus'=>'Approved','crId'=>$crId);
        if($crId!='' && _isRecordExist('tbl_cliam_requests',$where))
        {
            $whereRequest="WHERE crStatus='Approved' AND crId=$crId";
            $request=$this->WGModel->getClaimRequests($whereRequest);
            $request=$request[0];
            $businessId=$request['crBusinessId'];
            //echo '<pre>'; print_r($request); die;
            //create session for claim request id
            $this->session->set_userdata('claimRequestId',$crId);
            
            //create session for business id
            $this->session->set_userdata('claimBusinessId',$businessId);
                
            if($request['userFullName']!="")
            { 
                //get user information
                $userId=$request['crRequesterUserId'];
                $userInfo = $this->mdgeneraldml->select('user_plan,user_type,user_acc_status', 'tbl_user',  array('user_id' => $userId));
                $userType=$userInfo[0]['user_type'];
                $userPlan=$userInfo[0]['user_plan'];
                $userStatus=$userInfo[0]['user_acc_status'];//'A', 'I', 'C', 'D'
                
                 //create session for user id
                $this->session->set_userdata('claimRequestedUserId',$userId);
                
                if($userInfo[0]['user_type']=="buss_user")
                {
                    $this->checkUserActiveStatus($userStatus);
                    //it means user have registeration on this site, so he donnt need to fill up the payment information
                   
                    //get count of business listing
                    $countResult=$this->WGModel->sqlQuery("SELECT count(*) as numBusiness FROM tbl_business_info WHERE user_id=$userId");
                    if($userPlan=="ba" || $userPlan=="bm"){
                        //if menas user has basic plan then we need to check the limit
                        $limit=2;
                        if($countResult[0]['numBusiness']>$limit)
                        {
                            $this->session->set_flashdata('error','You have exeed the business limit so you cannot claim for this business.');
                            redirect('claim/error_page');
                        }else{
                            //update claim and business user
                           /*
						   $this->_updateBusinessAndClaim($crId,$businessId);
                            //send claim process complete email to admin                              
                            $this->_sendClaimEmail($userId,$businessId,$crId);                            
                            echo "Your business claim has been completed successfully. ".anchor('home/business_details/'.$businessId,'Click here').' to see the business details.';
							
							Commented on 07-05-14
							*/
                            //echo $this->session->userdata('claimRequestedUserId'); echo '==here:1';die;
                                                        $this->checkUserActiveStatus($userStatus);
							redirect('claim/registeration'); // changes 07-05-14 after changes in clients requirements. Also commented above 3 lines and replace with this line
                        }    
                    }else{
                        //update claim and business user
						/*
						$this->_updateBusinessAndClaim($crId,$businessId);
                        //send claim process complete email to admin                              
                        $this->_sendClaimEmail($userId,$businessId,$crId);
                        
                        echo "Your business claim has been completed successfully. ".anchor('home/business_details/'.$businessId,'Click here').' to see the business details.';
						
						Commented on 07-05-14
						*/
                        //echo $this->session->userdata('claimRequestedUserId'); echo '==here:2';die;
                                                $this->checkUserActiveStatus($userStatus);
						redirect('claim/registeration'); // changes 07-05-14 after changes in clients requirements. Also commented above 3 lines and replace with this line
						
                    }
                    
                }else{
                    //echo $this->session->userdata('claimRequestedUserId'); echo '==here:3';die;
                    $this->checkUserActiveStatus($userStatus);
                    //it means he is the site user but not have purchase a plan so he need to fill up payment information only
                    redirect('claim/registeration');
                    //echo "it means he is the site user but not have purchase a plan so he need to full up payment information only";
                    
                }
            }else{
                //echo $this->session->userdata('claimRequestedUserId'); echo '==here:4';die;
                //it means user dont have registeration so, he need to fill up both forms
                redirect('claim/registeration');
                //echo 'it means user dont have registeration so, he need to fill up both forms';
            }    
        }
    }
    
    function checkUserActiveStatus($userStatus)
    {       
        if($userStatus=='A')//Active
            return true;
        else{
            $this->session->set_flashdata('error','Your account is not active so you can not proceed.');
            redirect('claim/error_page');
        }
    }
    
    function _updateBusinessAndClaim($crId,$businessId,$claimRequestedUserId){
        //update claim 
        $where=array('crStatus'=>'Approved','crId'=>$crId);
        $updateData=array('crStatus'=>'Complete','priority'=>4,'crUpdatedOn'=>_getDateAndTime());
        $this->mdgeneraldml->update($where,'tbl_cliam_requests',$updateData);

        //update business
        $userId=$claimRequestedUserId;
        $where=array('buss_id'=>$businessId);
        $updateData=array('user_id'=>$userId,'isThisBusinessAddedByAdmin'=>'No','bussUpdatedOn'=>_getDateAndTime());
        $this->mdgeneraldml->update($where,'tbl_business_info',$updateData);
        
        
        // destroy following session variables
        $array_items = array('claimRequestId' => '', 'claimBusinessId' => '','claimRequestedUserId'=>'');
        $this->session->unset_userdata($array_items);
        //claimRequestId claimBusinessId claimRequestedUserId
    }
    
    function error_page(){
        echo $this->session->flashdata('error');
    }
    
    function _getBusinessInfo($businessId)
    {
        $businessInfo = $this->mdgeneraldml->select('*', 'tbl_business_info',array('buss_id'=>$businessId));        
        $businessInfo=$businessInfo[0];
        
        $info=array(
            'tmp_buss_id'=>$businessInfo['buss_id'],
            'tmp_buss_name'=>$businessInfo['buss_name'],
            'tmp_buss_cont_name'=>$businessInfo['buss_cont_name'],
            'tmp_buss_address'=>$businessInfo['buss_address'],
            'tmp_buss_addr_addon'=>$businessInfo['buss_addr_addon'],
            'tmp_buss_country'=>($businessInfo['buss_country']!=""?$businessInfo['buss_country']:'USA'),
            'tmp_buss_state'=>$businessInfo['buss_state'],            
            'tmp_buss_city'=>$businessInfo['buss_city'],
            'tmp_buss_zip_code'=>$businessInfo['buss_zip_code'],
            'tmp_buss_phone'=>$businessInfo['buss_phone'],
            'tmp_buss_fax'=>$businessInfo['buss_fax'],
            'tmp_buss_web_address'=>$businessInfo['buss_web_address'],
            'tmp_buss_email'=>$businessInfo['buss_email'],
            'tmp_buss_category'=>'',//$businessInfo['buss_category'],
            'tmp_buss_license_num'=>$businessInfo['buss_license_num'],            
            'tmp_buss_social_media_channel_1'=>$businessInfo['buss_social_media_channel_1'],
            'tmp_buss_social_media_channel_2'=>$businessInfo['buss_social_media_channel_2'],
            'tmp_buss_social_media_channel_3'=>$businessInfo['buss_social_media_channel_3'],
            'tmp_buss_social_media_channel_4'=>$businessInfo['buss_social_media_channel_4'],
            'tmp_buss_media_copy'=>$businessInfo['buss_media_copy'],
            'tmp_buss_logo'=>$businessInfo['buss_logo'],
            'tmp_buss_comp_quot'=>$businessInfo['buss_comp_quot'],
            'tmp_mon_d_and_s'=>$businessInfo['mon_d_and_s'],
            'tmp_we_r_hir'=>$businessInfo['we_r_hir'],
            'tmp_buss_tag_line'=>$businessInfo['buss_tag_line'],
            'tmp_buss_description'=>$businessInfo['buss_description'],
        );
        
        return $info;
    }
    
    function _checkClaimStatusForRegistration($crId){
         $where=array('crStatus'=>'Approved','crId'=>$crId);
        if($crId!='' && _isRecordExist('tbl_cliam_requests',$where))
        {
            $whereRequest="WHERE crStatus='Approved' AND crId=$crId";
            $request=$this->WGModel->getClaimRequests($whereRequest);
            $request=$request[0];
            $businessId=$request['crBusinessId'];
            return array('claimRequestId'=>$request['crId'],'claimBusinessId'=>$request['crBusinessId'],'claimRequestedUserId'=>$request['crRequesterUserId'],);
            
        }else{
            $this->session->set_flashdata('error','You can not access this link directly.');
            redirect('claim/error_page');
        }
    }
    
    function registeration($type='basic', $step='1',$crId=NULL)
    {    
        if($crId==NULL){//it means its a first call so we need to check session for that
            if($this->session->userdata('claimRequestId')==""){
                $this->session->set_flashdata('error','You can not access registration link directly.');
                redirect('claim/error_page');
            }else{
                //check claim status
                $crId=$this->session->userdata('claimRequestId');
                $claimRes=$this->_checkClaimStatusForRegistration($crId);
            }
        }else{
            //check claim status            
            $claimRes=$this->_checkClaimStatusForRegistration($crId);
        }
        //these session are created in proceed_claim() function
        $claimRequestId         =$claimRes['claimRequestId'];
        $claimBusinessId        =$claimRes['claimBusinessId'];
        $claimRequestedUserId   =$claimRes['claimRequestedUserId'];
        
        
        if(!_isRecordExist('tbl_business_info',array('buss_id'=>$claimBusinessId)))
        {
            $this->session->set_flashdata('error',"Your claim request won't be complete because of the requested business is not available on WOM.");
            redirect('claim/error_page');
        }
        
        //get business information
        $data=$this->_getBusinessInfo($claimBusinessId);
        
        
        
        
        //Get subscription plans
        $tbl_subscription_plans = 'tbl_subscription_plans';
        $data['plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_plans);

        $data['basic_plan_name'] = $data['plan_details'][0]['subs_plan_name'];
        $data['prem_plan_name'] = $data['plan_details'][1]['subs_plan_name'];

        //Get sub-subscription plans
        $tbl_subscription_sub_plans = 'tbl_subscription_sub_plans';
        $data['sub_plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_sub_plans);

        //basic Annually 
        $data['basic_plan_annual_name'] = $data['sub_plan_details'][0]['subs_sub_plan_name'];
        $data['basic_plan_annual_price'] = $data['sub_plan_details'][0]['subs_sub_plan_price'];
        //basic Monthly
        $data['basic_plan_monthly_name'] = $data['sub_plan_details'][1]['subs_sub_plan_name'];
        $data['basic_plan_monthly_price'] = $data['sub_plan_details'][1]['subs_sub_plan_price'];
        //premium Annually                                
        $data['prem_plan_annual_name'] = $data['sub_plan_details'][2]['subs_sub_plan_name'];
        $data['prem_plan_annual_price'] = $data['sub_plan_details'][2]['subs_sub_plan_price'];
        //premium Monthly
        $data['prem_plan_monthly_name'] = $data['sub_plan_details'][3]['subs_sub_plan_name'];
        $data['prem_plan_monthly_price'] = $data['sub_plan_details'][3]['subs_sub_plan_price'];

        //Get service limit Details
        $tbl_service_limits = 'tbl_service_limits';
        $in_para = array('service_id');
        $where_not_in = array('service_id' => array(13, 14));
        $data['service_limits'] = $this->mdgeneraldml->select_not_in('*', $tbl_service_limits, $in_para, $where_not_in);
        //Get User Info if user is logged in
        
        if ($claimRequestedUserId != '' && $claimRequestedUserId != 0)
        {
            $tbl = "tbl_user";
            $select = 'tbl_user.*';
            $cnd = array('tbl_user.user_id' => $claimRequestedUserId);
            $data['user_data_info'] = $this->mdgeneraldml->select($select, $tbl, $cnd);
            $info = $data['user_data_info'][0];
            $data['user_info_array'] = array('user_name' => $info['user_name'],
                'user_email' => $info['user_email'],
                'user_password' => '',
                'user_fname' => $info['user_fname'],
                'user_lname' => $info['user_lname'],
                'user_city' => $info['user_city'],
                'user_country' => $info['user_country'],
                'user_state' => $info['user_state'],
                'user_address' => $info['user_address'],
                'user_address_addon' => $info['user_address_addon'],
                'user_zipcode' => $info['user_zipcode'],
                'user_email_anno_check' => $info['user_email_anno_check'],
                'user_plan' => $info['user_plan'],
                'user_type' => $info['user_type']
            );
             //Get User State
        $where_state_id = array('state_id' => $info['user_state']);
        $get_state = $this->mdgeneraldml->select('state_name', 'tbl_state', $where_state_id);
        if (count($get_state) > 0)
            $data['user_state'] = $get_state[0]['state_name'];
        else
            $data['user_state'] = '';
        }
        else
        {
            $data['user_info_array'] = array('user_name' => '',
                'user_email' => '',
                'user_password' => '',
                'user_fname' => '',
                'user_lname' => '',
                'user_city' => '',
                'user_country' => '',
                'user_state' => '',
                'user_address' => '',
                'user_address_addon' => '',
                'user_zipcode' => '',
                'user_email_anno_check' => '',
                'user_plan' => '',
                'user_type' => ''
            );
        }
        
        $data['error'] = '';
        $data['p_error'] = '';
        
        $data['claimRequestId'] = $claimRequestId;
        $data['claimBusinessId'] = $claimBusinessId;
        $data['claimRequestedUserId'] =$claimRequestedUserId;
        //claimRequestId claimBusinessId claimRequestedUserId
        
        //echo $step; die;
        if ($type == 'basic')
        {
            if ($step == 1)
                $this->submitForm_basic($data);
            else
                $this->submitForm_buss_basic($data);
        }else
        {
            if ($step == 1)
                $this->submitForm_prem($data);
            else
                $this->submitForm_buss_prem($data);
        }
       
    }
    
    public function submitForm_basic($data)
    {
        
        //echo "<pre>";print_r($data);die;
        if(isset($data['user_data_info']))
        {
        $this->form_validation->set_rules('username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]');
        $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email');
        }
        else
        {
                $this->form_validation->set_rules('username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|is_unique[tbl_user.user_name]');
        $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
        }
        
        $claimRequestId=$data['claimRequestId'];
        $claimRequestedUserId=$data['claimRequestedUserId'];
        $claimBusinessId=$data['claimBusinessId'];
        //claimRequestId claimBusinessId claimRequestedUserId
        
        $this->form_validation->set_rules('user_password', 'Password', 'xss_clean|trim|required|alpha_numeric|min_length[6]|max_length[12]|matches[cpassword]');
        $this->form_validation->set_rules('cpassword', 'Confirm Password', 'xss_clean|trim|required|matches[user_password]');
        $this->form_validation->set_rules('fname', 'First Name', 'xss_clean|trim|required|alpha|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('lname', 'Last Name', 'xss_clean|trim|required|alpha|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('zip_code', 'Zip Code', 'xss_clean|trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('city', 'City', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('Items', 'Country', 'xss_clean|trim|required');
        $this->form_validation->set_rules('userState', 'State', 'xss_clean|trim|required');
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('claim_a_business_process_forms', $data);
        }
        else
        {
            if (isset($_POST['email_announc']))
            {
                $email_announc = 1;
            }
            else
            {
                $email_announc = 0;
            }
            if (isset($_POST['addr_addon']))
            {
                $addr_addon = $_POST['addr_addon'];
            }
            else
            {
                $addr_addon = "--";
            }
            $user_password = md5($_POST['user_password']);

            $sess_user_info = array(
                "username" => $_POST['username'],
                "user_email" => $_POST['user_email'],
                "user_password" => $user_password,
                /*"acc_type" => $_POST['acc_type'],*/
                "fname" => $_POST['fname'],
                "lname" => $_POST['lname'],
                "address" => $_POST['address'],
                "addr_addon" => $addr_addon,
                "Items" => $_POST['Items'],
                "userState" => $_POST['userState'],
                "zip_code" => $_POST['zip_code'],
                "city" => $_POST['city'],
                "email_announc" => $email_announc
            );
            $this->session->set_userdata($sess_user_info);
            //claimRequestId claimBusinessId claimRequestedUserId
            //$claimRequestedUserId=$this->session->userdata('claimRequestedUserId');
           
            if ($claimRequestedUserId != '' && $claimRequestedUserId!=0)
            {
                //Store User information in tbl_user
                $field_data = array('user_name' => $this->input->post('username'),
                    'user_email' => $this->input->post('user_email'),
                    'user_password' => md5($this->input->post('user_password')),
                    'user_fname' => $this->input->post('fname'),
                    'user_lname' => $this->input->post('lname'),
                    'user_city' => $this->input->post('city'),
                    'user_country' => $this->input->post('Items'),
                    'user_state' => $this->input->post('userState'),
                    'user_address' => $this->input->post('address'),
                    'user_address_addon' => $addr_addon,
                    'user_zipcode' => $this->input->post('zip_code'),
                    'user_email_anno_check' => $email_announc,
                    /*'user_plan' => $this->input->post('acc_type'),*/
                    'user_registered_date' => _getDateAndTime(),
                    'user_update_date' => _getDateAndTime(),
                    'user_acc_status' => "A",
                    'act_link_click_status' => 0,
                    'user_type' => "site_user",
                    'user_plan' => '',
                );
                $where = array('user_id' => $claimRequestedUserId);
                $data = $this->mdgeneraldml->update($where, 'tbl_user', $field_data);
                $sess_user_id = array('buss_user_id' => $claimRequestedUserId);
            }
            else
            {
                //Store User information in tbl_user
                $field_data = array('user_name' => $this->input->post('username'),
                    'user_email' => $this->input->post('user_email'),
                    'user_password' => md5($this->input->post('user_password')),
                    'user_fname' => $this->input->post('fname'),
                    'user_lname' => $this->input->post('lname'),
                    'user_city' => $this->input->post('city'),
                    'user_country' => $this->input->post('Items'),
                    'user_state' => $this->input->post('userState'),
                    'user_address' => $this->input->post('address'),
                    'user_address_addon' => $addr_addon,
                    'user_zipcode' => $this->input->post('zip_code'),
                    'user_email_anno_check' => $email_announc,
                    'user_registered_date' => _getDateAndTime(),
                    'user_update_date' => _getDateAndTime(),
                    'user_acc_status' => "A",
                    'act_link_click_status' => 0,
                    'user_type' => "site_user",
                    'user_plan' => ''
                );
                $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
                $last_ins_user_id = $data['last_insertId'];
               // $sess_user_id = array('buss_user_id' => $last_ins_user_id);
                //Send Email
                $uname = $this->input->post('username');
                $email = $this->input->post('user_email');
                $password = $this->input->post('user_password');
                $encryption_str = $uname . "/" . $data['last_insertId'];
                $enc_text = base64_encode($encryption_str);
                $activation_url=base_url() . "user/activated_user/" . $enc_text;                
                $sess_user_id = array('buss_user_id' => $last_ins_user_id,'activation_url'=>$activation_url);// Remove activation_url when email starts
                $this->session->set_userdata($sess_user_id);
                
                //update claim claim user
                $whereClaim=array('crId'=>$claimRequestId);
                $data = $this->mdgeneraldml->update($whereClaim, 'tbl_cliam_requests', array('crRequesterUserId'=>$last_ins_user_id));
            }
            if (count($sess_user_info) != 0)
                redirect('claim/registeration/basic/2/'.$claimRequestId.'#address11');
            else
                redirect('claim/registeration/basic/1/'.$claimRequestId.'#address10');
        }
    }
    
     //Step 2 of basic form
    function submitForm_buss_basic($data)
    { 
        
        //echo $this->session->userdata('claimRequestedUserId'); die;
         //$this->form_validation->set_rules('buss_name', 'Business Name', 'xss_clean|trim|required|min_length[2]|max_length[125]|callback_alpha_dash_space');
         $this->form_validation->set_rules('buss_name', 'Business Name', 'xss_clean|trim|required|min_length[2]|max_length[125]');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim|max_length[125]');
        $this->form_validation->set_rules('buss_addr', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_addr_addon', 'Address add on', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_country', 'country', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_state', 'State', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('buss_zipcode', 'Zip code', 'xss_clean|trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_fax', 'Fax', 'xss_clean|trim|numeric');
        $this->form_validation->set_rules('buss_web_addr', 'Web Address', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_email_addr', 'Email', 'xss_clean|trim|valid_email|required');
        $this->form_validation->set_rules('buss_lice_num', 'License Number', 'xss_clean|trim');
        $this->form_validation->set_rules('userCategory[]', 'Business Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('basicHiddenPaymentType', 'Hidden payment type', 'xss_clean|trim');
       
        $this->form_validation->set_rules('buss_sco_one', 'Twitter url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('buss_sco_two', 'Facebook url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('buss_sco_three', 'Pinterest url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('buss_sco_four', 'LinkedIn url', 'xss_clean|trim|callback_validateUrl');  
        
        $this->form_validation->set_rules('b_acc_type', 'Plan type', 'xss_clean|trim|required'); 
        
        $claimRequestId=$data['claimRequestId'];
        $claimRequestedUserId=$data['claimRequestedUserId'];
        $claimBusinessId=$data['claimBusinessId'];
        //claimRequestId claimBusinessId claimRequestedUserId
        
        /*File Upload Validations*/
        if(!empty($_FILES['upload_logo'])){
            if($_FILES['upload_logo']['name']!="")
                $this->form_validation->set_rules('upload_logo','LOGO','file_min_size[10KB]|file_max_size[3072KB]|file_allowed_type[image]|file_image_mindim[50,50]|file_image_maxdim[1024,768]|file_required');
        }
        
        //$this->form_validation->set_rules('upload_photos','Media Copy','file_min_size[10KB]|file_max_size[1000KB]|file_allowed_type[image]|file_image_mindim[50,50]|file_image_maxdim[1024,768]|file_required');
        if(!empty($_FILES['upload_photos']) && $_FILES['upload_photos']['name'][0]!=""){              
            $this->form_validation->set_rules('upload_photos[]','Media Copy','callback_checkForBasicMediaCopy');
        }
        
        if(!empty($_FILES['license_docs'])){              
            $this->form_validation->set_rules('license_docs[]','Business license','callback_checkForBasicLicenseDocs');
        }

        //echo $this->input->post('basicHiddenPaymentType');
        //if($this->input->post('basicHiddenPaymentType')!='paypalImg'){
            //Card Validations        
            $this->form_validation->set_rules('nameOnCard', 'Name on card', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
            $this->form_validation->set_rules('c_address_1', 'Address Line 1', 'xss_clean|trim|required|callback_alpha_dash_space');
            //$this->form_validation->set_rules('c_address_2', 'Address Line 2', 'xss_clean|trim|callback_alpha_dash_space');
            $this->form_validation->set_rules('c_address_2', 'Address Line 2', 'xss_clean|trim');
            $this->form_validation->set_rules('c_city', 'City', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
            $this->form_validation->set_rules('c_state', 'State', 'xss_clean|trim|required');
            $this->form_validation->set_rules('c_Items', 'Country', 'required');
            $this->form_validation->set_rules('c_email', 'Email', 'xss_clean|trim|valid_email');
            $this->form_validation->set_rules('c_phone_no', 'Phone No', 'xss_clean|trim');
            $this->form_validation->set_rules('cardType', 'Card Type', 'trim|required');
            $this->form_validation->set_rules('c_card_num', 'Card Number', 'xss_clean|trim|required|numeric');
            $this->form_validation->set_rules('c_secu_code', 'Security Code', 'xss_clean|trim|required|numeric');
            $this->form_validation->set_rules('c_zip_code', 'Zip Code', 'trim|required|numeric|max_lenght[8]');
            $this->form_validation->set_rules('c_cvv2_no', 'CVV2 Number', 'trim|numeric');
            $this->form_validation->set_rules('expiryMonth', 'Expiration Month', 'trim|required');
            $this->form_validation->set_rules('expiryYear', 'Expiration Date', 'trim|required');
        //}

           
        if ($this->form_validation->run() == FALSE)
        {//echo 'here am1'; die;
            $this->load->view('claim_a_business_process_forms', $data);
        }
        else
        { //echo 'here am2'; die;
             
            if ($claimRequestedUserId != '' && $claimRequestedUserId!=0)
                $user_id = $claimRequestedUserId;
            else
                redirect('claim/registeration');

            //upload files
                //File Upload Media Photos
                 //create directory if not exist
                 if (!file_exists("./Media_Copy"))                
                    mkdir('./Media_Copy/', 0777, true);
                
                $mediaCoppyFileNames=$this->do_MultipleUpload('upload_photos');                
                //End
                
                
                
                //File Upload LOGO
                if (!file_exists("./LOGO"))
                {
                    mkdir('./LOGO/', 0777, true);
                }
                
                $logoImageName="default_logo.jpg";
                if($_FILES['upload_logo']['name']!="")
                {    
                    $logInfo=$this->_uploadLogo('upload_logo');
                    $logoImageName=$logInfo['fileName'];
                    $error=$logInfo['error'];
                }    
                
                //upload multiple docs
                //create directory if not exist
                if (!file_exists("./sitedata/bisiness_license_docs"))                
                    mkdir('./sitedata/bisiness_license_docs/', 0777, true);
                
                $businessLicensesDocsNames=$this->uploadMultipleDocs('license_docs',$mediaCoppyFileNames);
           
            //subscription_plan_id subscription_sub_plan_id amount 
            $formaData=$_POST;
            $formaData['uploadedImagesArray']['mediaCoppyFileNames']=$mediaCoppyFileNames;
            $formaData['uploadedImagesArray']['logoFileNames']=$logoImageName;            
            $formaData['uploadedImagesArray']['buss_license_docs']=$businessLicensesDocsNames;
            $formaData['subscriptionInfo']=$this->__getBasicPromocodeCalculatedAmount();            
            $formaData['currentSessionUSerId']=$user_id;
            $this->session->set_userdata('basicFormData',$formaData);
            //echo '<pre>'; print_r($this->session->userdata('basicFormData')); die;
            
            if($this->input->post('basicHiddenPaymentType')!='paypalImg'){
                

                //Make Payment (Send Info to __doCreditCardPayment function)
                $infoArray = array('address1' => $this->input->post('c_address_1'),
                    'address2' => $this->input->post('c_address_2'),
                    'city' => $this->input->post('c_city'),
                    'state' => $this->input->post('c_state'),
                    'zip' => $this->input->post('c_zip_code'),
                    'phone' => $this->input->post('c_phone_no'),
                    'cardType' => $this->input->post('cardType'),
                    'creditCardNumber' => $this->input->post('c_card_num'),
                    'expDateMonth' => $this->input->post('expiryMonth'),
                    'expDateYear' => $this->input->post('expiryYear'),
                    'cvv2Number' => $this->input->post('c_secu_code'),
                    'firstName' => $this->session->userdata('fname'),
                    'lastName' => $this->session->userdata('lname'),
                    'amount' => $formaData['subscriptionInfo']['amount']
                );
            }
            
            // print_r($infoArray);die;
             
            $processFlag = true;
            $responce['errorData']="";
            if($this->input->post('basicHiddenPaymentType')!='paypalImg'){
                //$responce = $this->__doCreditCardPayment($infoArray);
                //new condition added by Bhagwan dated on 21-April-2014 (now user can registred if registration fee is 0 also. 
                //but here we avoid payment option)
                if($infoArray['amount']>0){
                    $responce = __authorisedPayment($infoArray);                   
                    if ($responce['status'] == 'fail')
                        $processFlag = false;
                }     
            }
            
            if ($processFlag == false)
            {
                $data['error'] = $responce['errorData'];
                $this->load->view('claim_a_business_process_forms', $data);                
            }
            else
            {      //claimRequestId claimBusinessId claimRequestedUserId                           
                //send claim process complete email to admin
                $businessId=$claimBusinessId;
                $this->_sendClaimEmail($user_id,$businessId,$claimRequestId);
                                
                $activationURL=$this->session->userdata('activation_url');
                $tranId=(isset($responce['transactionId'])?$responce['transactionId']:'');
                $this->__saveBasicFormData($tranId,$claimRequestId,$claimBusinessId);
                
                
                
                //destroy previous session
                 delete_cookie('mem_login_info');
                
                $this->session->unset_userdata('basicFormData');
                //$this->session->sess_destroy();   
                // 
                //set new session
                $newUSerInfo=$this->mdgeneraldml->select('user_name,user_fname,user_fname,user_lname,user_email,user_type','tbl_user',array('user_id'=>$user_id));
                $newSessionData=array('user_id'=>$user_id);
                if(!empty($newUSerInfo)){
                    $newSessionData=array(
                        'user_id'=>$user_id,
                        'user_email'=>$newUSerInfo[0]['user_email'],
                        'user_name'=>$newUSerInfo[0]['user_name'],
                        'user_type'=>$newUSerInfo[0]['user_type']                       
                    );
                }
                
                
                
                $this->session->set_userdata($newSessionData);
                
                //send subscription email to admin
                $this->_sendSubscriptionMailToAdmin($user_id,$this->input->post('buss_name'), $formaData['subscriptionInfo']['promo_code'], $formaData['subscriptionInfo']['amount']);
                
                $url = site_url('dashboard/business_listing/view/'.$businessId);           
                $successString = 'You have registered to Word Of Mouth successfully.';
                echo "<script>alert('".$successString."');window.location.href='$url'</script>";
            }
        }
    }
    
     
    function __getBasicPromocodeCalculatedAmount(){
        // echo $user_id; die;
            //Get sub-subscription plans
            $tbl_subscription_sub_plans = 'tbl_subscription_sub_plans';
            $data['sub_plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_sub_plans);

            //Get Plan Info
            if ($this->input->post('b_acc_type') == 'bm')
            {
                $subscription_plan_id = $data['sub_plan_details'][1]['subs_plan_id'];
                $subscription_sub_plan_id = $data['sub_plan_details'][1]['subs_sub_plan_id'];
                //$amount = $data['sub_plan_details'][1]['subs_sub_plan_price'];
                
                //Get Promocode for Basic Monthly
                $amount_before = $data['sub_plan_details'][1]['subs_sub_plan_price']; 
                $tbl_promo_codes = "tbl_promo_codes";
                $cnd_tbl_promo_codes = "pc_code = '" . $this->input->post('b_promocode') . "' and pc_plan_type_id ='" . $subscription_sub_plan_id . "' ";
                $db_pro_code = $this->db_transact_model->get_single_record($tbl_promo_codes, $cnd_tbl_promo_codes);
                 if (!empty($db_pro_code))
                {
                    if ($db_pro_code[0]['pc_status'] == 'A')
                    {  $discount = $db_pro_code[0]['pc_discount'];
                        $basic_total_cost = $amount_before - $discount;
                        $amount = number_format($basic_total_cost,2,'.','');
                    }
                    else
                    {
                        $amount = $data['sub_plan_details'][1]['subs_sub_plan_price'];
                    }
                }
                else
                {
                    $amount = $data['sub_plan_details'][1]['subs_sub_plan_price'];
                }
                //End                
            }
            else
            {
                $subscription_plan_id = $data['sub_plan_details'][0]['subs_plan_id'];
                $subscription_sub_plan_id = $data['sub_plan_details'][0]['subs_sub_plan_id'];
                //$amount = $data['sub_plan_details'][0]['subs_sub_plan_price'];
                
                 //Get Promocode for Basic Annually
                $amount_before = $data['sub_plan_details'][0]['subs_sub_plan_price'];
                $tbl_promo_codes = "tbl_promo_codes";
                $cnd_tbl_promo_codes = "pc_code = '" . $this->input->post('b_promocode') . "' and pc_plan_type_id ='" . $subscription_sub_plan_id . "' ";
                $db_pro_code = $this->db_transact_model->get_single_record($tbl_promo_codes, $cnd_tbl_promo_codes);
                 if (!empty($db_pro_code))
                {
                    if ($db_pro_code[0]['pc_status'] == 'A')
                    {  $discount = $db_pro_code[0]['pc_discount'];
                        $basic_total_cost = $amount_before - $discount;
                        $amount = number_format($basic_total_cost,2,'.','');
                    }
                    else
                    {
                        $amount = $data['sub_plan_details'][0]['subs_sub_plan_price'];
                    }
                }
                else
                {
                    $amount = $data['sub_plan_details'][0]['subs_sub_plan_price'];
                }
                //End  
            }
            return array('subscription_plan_id'=>$subscription_plan_id,'subscription_sub_plan_id'=>$subscription_sub_plan_id,'amount'=>$amount,'promo_code'=>$this->input->post('b_promocode'));
    }
    
    function __saveBasicFormData($payPalTransactionId,$claimRequestId,$claimBusinessId){
        ////claimRequestId claimBusinessId claimRequestedUserId       
        $form=$this->session->userdata('basicFormData');
        $mediaCoppyFileNames        =$form['uploadedImagesArray']['mediaCoppyFileNames'];
        $logoImageName              =$form['uploadedImagesArray']['logoFileNames'];
        $bussLicenseDocsNames       =$form['uploadedImagesArray']['buss_license_docs'];
        $subscription_plan_id       =$form['subscriptionInfo']['subscription_plan_id'];
        $subscription_sub_plan_id   =$form['subscriptionInfo']['subscription_sub_plan_id'];
        $amount                     =$form['subscriptionInfo']['amount'];
        $user_id                    =$form['currentSessionUSerId'];
        
                // echo "<pre>";print_r($_POST);die;    
                if (isset($form['buss_addr_addon']))
                    $addr_addon = $form['buss_addr_addon'];
                else
                    $addr_addon = "--";
                
                
              
                //Store User information in tbl_business_info
                $field_data = array('user_id' => $user_id,
                    'buss_name' => $form['buss_name'],
                    'buss_cont_name' => $form['buss_cont_name'],
                    'buss_address' => $form['buss_addr'],
                    'buss_addr_addon' => $addr_addon,
                    'buss_country' => $form['buss_country'],
                    'buss_state' => $form['buss_state'],
                    'buss_city' => $form['buss_city'],
                    'buss_zip_code' => $form['buss_zipcode'],
                    'buss_phone' => $form['buss_phone'],
                    'buss_fax' => $form['buss_fax'],
                    'buss_web_address' => $form['buss_web_addr'],
                    'buss_email' => $form['buss_email_addr'],                    
                    'buss_license_num' => $form['buss_lice_num'],
                    'buss_social_media_channel_1' => $form['buss_sco_one'],
                    'buss_social_media_channel_2' => $form['buss_sco_two'],
                    'buss_social_media_channel_3' => $form['buss_sco_three'],
                    'buss_social_media_channel_4' => $form['buss_sco_four'],                                               
                    'bussUpdatedOn' => _getDateAndTime()
                );
                     
                if($mediaCoppyFileNames!="")
                    $field_data['buss_media_copy']=$mediaCoppyFileNames;
                if($logoImageName!="")
                    $field_data['buss_logo']=$logoImageName;
                if($bussLicenseDocsNames!="")
                    $field_data['buss_license_docs']=$bussLicenseDocsNames;
                        
                //update business
                //$claimBusinessId        =$this->session->userdata('claimBusinessId');
                $whereBusiness=array('buss_id'=>$claimBusinessId);
                $data = $this->mdgeneraldml->update($whereBusiness, 'tbl_business_info', $field_data);

                //create category if user has selected other
                $category=$form['userCategory'];
                //delete previous business cats those are assigned to this business               
                $this->mdgeneraldml->delete(array('buss_id'=>$claimBusinessId),'tbl_business_categories');
                
                //assign new categories to the business
                foreach($category as $key=>$categoryId){
                    if($categoryId!="other"){
                        $businessCat_data=array('buss_id'=>$claimBusinessId,'cat_id'=>$categoryId);
                        $this->mdgeneraldml->insert('tbl_business_categories', $businessCat_data);
                     }
                }
                
                
                //update claim and business
                //$claimRequestId =$this->session->userdata('claimRequestId');
                  
                //Update user account to bussiness user
                $user_info_data = array(
                    'user_plan' => $form['b_acc_type'],
                    'user_type' => "buss_user"
                );
                $where = array('user_id' => $user_id);
                $user_info_updated = $this->mdgeneraldml->update($where, 'tbl_user', $user_info_data);
                
                if($form['basicHiddenPaymentType']!='paypalImg'){
                    //Insert Data in tbl_user_credit_card_info
                    //Take Only last 4 digits of Credit card
                    $creditCardNo = $form['c_card_num'];
                    $first = substr($creditCardNo, 0, -4);
                    $last4Digits = substr($creditCardNo, -4);
                    $chunks = str_split(str_repeat('X', strlen($first)), 4);
                    $ccNoForDB = implode('-', $chunks) . (strlen($creditCardNo) >= 16 ? '-' : '') . $last4Digits;
                    
                    $cardInfo = array(
                        'ccUserId' => $user_id,
                        'paypal_cardId' => $payPalTransactionId,
                        'ccNameOnCard' => $form['nameOnCard'],
                        'ccAddress' => $form['c_address_1'],
                        'ccAddress2' => $form['c_address_2'],
                        'ccCity' => $form['c_city'],
                        'ccState' => $form['c_state'],
                        'ccPostalCode' => $form['c_zip_code'],
                        'ccCountryCode' => $form['c_Items'],
                        'ccEmail' => $form['c_email'],
                        'ccPhoneNumber' => $form['c_phone_no'],
                        'ccType' => $form['cardType'],
                        'ccCardNumber' => $ccNoForDB,
                        'ccSecurityCode' => $form['c_secu_code'],
                        'ccExpiryMonth' => $form['expiryMonth'],
                        'ccExpiryYear' => $form['expiryYear'],
                        'ccCreatedOn' => _getDateAndTime(),
                        'ccUpdatedOn' => _getDateAndTime()
                    );
                    $data = $this->mdgeneraldml->insert('tbl_user_credit_card_info', $cardInfo);
                }
                //Insert Data in tbl_transaction_history
                $transInfo = array(
                    'user_id' => $user_id,
                    'tran_hist_amount' => $amount,
                    'tran_hist_transaction_id' => $payPalTransactionId,
                    'tran_subscription_plan_id' => $subscription_plan_id,
                    'tran_subscription_sub_plan_id' => $subscription_sub_plan_id,
                    'tran_hist_date' => _getDateAndTime()
                );
                
                $data = $this->mdgeneraldml->insert('tbl_transaction_history', $transInfo);
                
                $today = _getDate();
                if ($this->input->post('b_acc_type') == 'bm')
                {
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+1 month");
                    $end_date = date('Y-m-d', $end_datemonth);
                }
                else
                {
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+12 month");
                    $end_date = date('Y-m-d', $end_datemonth);
                }
                
                //Insert Subscription info
                $subscription_info = array(
                    'user_id' => $user_id,
                    'sub_plan_id' => $subscription_plan_id,
                    'sub_subplan_id' => $subscription_sub_plan_id,
                    'sub_start_date' => $today,
                    'sub_end_date' => $end_date
                );
                
                $data = $this->mdgeneraldml->insert('tbl_user_subscription_plan_info', $subscription_info);
                
                    $sess_user_info = array("username" => '',"user_email" => '',"user_password" => '',"acc_type" => '',"fname" => '',"lname" => '',
                        "address" => '',"addr_addon" => '',"zip_code" => '',"city" => '',"email_announc" => '',"buss_user_id" => '');
                    
                    delete_cookie('mem_login_info');
                    
                    $this->session->unset_userdata($sess_user_info);
                    $this->session->unset_userdata('basicFormData');
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');
                    $this->session->unset_userdata('user_type');
    }
    
    // Check Duplicate Username
    public function check_uname_dup()
    {
        if ($this->session->userdata('claimRequestedUserId') != '')
        {
            $str_id = $this->session->userdata('claimRequestedUserId');
            $str = $this->input->post('username');
            $sql_q = "SELECT user_id, user_name FROM tbl_user WHERE user_name = '$str' AND user_id != '$str_id'";
            $execute_q = $this->admin_model->sqlQuery($sql_q);
            $record_count = count($execute_q);
            if ($record_count > 0)
            {
                echo "false";
            }
            else
            {
                echo "true";
            }
        }
        else
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
    }

    // Check Duplicate Email
    public function check_email_dup()
    {
        $claimRequestedUserId=$this->session->userdata('claimRequestedUserId');
        if ($claimRequestedUserId != '')
        {
            $str_id = $claimRequestedUserId;
            $str = $this->input->post('user_email');
            $sql_q = "SELECT user_id, user_email FROM tbl_user WHERE user_email = '$str' AND user_id != '$str_id'";
            $execute_q = $this->admin_model->sqlQuery($sql_q);
            $record_count = count($execute_q);
            if ($record_count > 0)
            {
                echo "false";
            }
            else
            {
                echo "true";
            }
        }
        else
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
    }

    
    function checkForBasicMediaCopy()
    {        
        $files=$_FILES['upload_photos'];
        if(sizeof($files['name'])>2){
            $this->form_validation->set_message('checkForBasicMediaCopy', 'You can not upload more than two files.');
            return FALSE;
        }else{
            $types=$files['type'];
            $flag=true;
            foreach($types as $key=>$val)
            {
                if($val!="")
                {
                    $typeArray=explode("/", $val);
                    if($typeArray[0]!='image')
                        $flag=false;
                }else{
                    $this->form_validation->set_message('checkForBasicMediaCopy', 'You can only upload the image file.');
                    return FALSE;
                }
            }
            
            if($flag==true)
            {
                
                return TRUE;
            }
            else{
                $this->form_validation->set_message('checkForBasicMediaCopy', 'You can only select upload the image file.');
                return FALSE;
            }
        }
    }
    
    function checkForBasicLicenseDocs()
    {     
        $files=$_FILES['license_docs'];        
        if(sizeof($files['name'])>5){
            $this->form_validation->set_message('checkForBasicLicenseDocs', 'You can not upload more than five files.');
            return FALSE;
        }else{
            $types=$files['name'];
            $flag=true;
            if($types[0]!="")
            {    
                $requiredExtentions=array('PDF','pdf','DOC','doc','DOCX','docx');
                foreach($types as $key=>$val)
                {
                    if($val!="")
                    {
                        $typeArray=explode(".", $val);
                        $extention=$typeArray[1];
                        if(!in_array($extention, $requiredExtentions))
                            $flag=false;
                    }else{
                        $this->form_validation->set_message('checkForBasicLicenseDocs', 'You can only upload pdf or doc file.');
                        return FALSE;
                    }
                }
            }
            else
                $flag=true;
            
            if($flag==true)
            {
                
                return TRUE;
            }
            else{
                $this->form_validation->set_message('checkForBasicLicenseDocs', 'You can only upload pdf or doc file');
                return FALSE;
            }
        }
    }
    
     function checkForPreLicenseDocs()
     {        
        $files=$_FILES['p_license_docs'];      
        if(sizeof($files['name'])>5){
            $this->form_validation->set_message('checkForPreLicenseDocs', 'You can not upload more than five files.');
            return FALSE;
        }else{
            $types=$files['name'];
            $flag=true;
            if($types[0]!="")
            {    
                $requiredExtentions=array('PDF','pdf','DOC','doc','DOCX','docx');
                foreach($types as $key=>$val)
                {
                    if($val!="")
                    {
                        $typeArray=explode(".", $val);
                        $extention=$typeArray[1];
                        if(!in_array($extention, $requiredExtentions))
                            $flag=false;
                    }else{
                        $this->form_validation->set_message('checkForPreLicenseDocs', 'You can only upload pdf or doc file.');
                        return FALSE;
                    }
                }
            }
            else
                $flag=true;
            
            if($flag==true)
            {
                
                return TRUE;
            }
            else{
                $this->form_validation->set_message('checkForPreLicenseDocs', 'You can only upload pdf or doc file');
                return FALSE;
            }
        }
    }
    
    function do_MultipleUpload($inputFileName="")
    {
       $this->load->library('upload'); // Load Library

       $this->upload->initialize(array( // takes an array of initialization options
           "upload_path" => "./Media_Copy/",
           "overwrite" => FALSE,
           "encrypt_name" => TRUE,
           "remove_spaces" => TRUE,
           "allowed_types" => "*",
           "max_size" => 300,
           "xss_clean" => FALSE
       )); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean

       if ($this->upload->do_multi_upload($inputFileName)) { // use same as you did in the input field
            $result=$this->upload->get_multi_upload_data(); 
            
            $fileNames="";
            $fileNameArray=array();
            foreach($result as $key=>$val)
                $fileNameArray[]=$val['file_name'];

            $fileNames=implode(',', $fileNameArray);
                return $fileNames; 
       }
    }

   function uploadMultipleDocs($inputFileName="",$mediaFileNames)
    {
       $this->load->library('upload'); // Load Library

       $this->upload->initialize(array( // takes an array of initialization options
           "upload_path" => "./sitedata/bisiness_license_docs/",
           "overwrite" => FALSE,
           "encrypt_name" => FALSE,
           "remove_spaces" => TRUE,
           "allowed_types" => "*",
           //"max_size" => 300,
           "xss_clean" => FALSE
       )); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean

       if ($this->upload->do_multi_upload($inputFileName)) { // use same as you did in the input field
            $result2=$this->upload->get_multi_upload_data(); 
            
            $fileNames="";
            $fileNameArray=array();
            $mediaFileNamesArray=explode(',', $mediaFileNames);
            foreach($result2 as $key=>$val)
            {
                if(!in_array($val['file_name'], $mediaFileNamesArray))
                    $fileNameArray[]=$val['file_name'];
            }

            
            $fileNames=implode(',', $fileNameArray);
            //echo $fileNames;
            //echo '<pre>'; print_r($result2); die;
            return $fileNames; 
                
       }
    }

    //Step 1 of Premium Form
    public function submitForm_prem($data)
    {
        
        $claimRequestId=$data['claimRequestId'];
        $claimRequestedUserId=$data['claimRequestedUserId'];
        $claimBusinessId=$data['claimBusinessId'];
        //claimRequestId claimBusinessId claimRequestedUserId
        
        if(isset($data['user_data_info']))
        {
            $this->form_validation->set_rules('p_username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]');
            $this->form_validation->set_rules('p_user_email', 'Email', 'xss_clean|trim|required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('p_username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|is_unique[tbl_user.user_name]');
            $this->form_validation->set_rules('p_user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
        }
		
        $this->form_validation->set_rules('p_user_password', 'Password', 'xss_clean|trim|required|alpha_numeric|min_length[6]|max_length[12]|matches[p_cpassword]');
        $this->form_validation->set_rules('p_cpassword', 'Confirm Password', 'xss_clean|trim|required|matches[p_user_password]');
        $this->form_validation->set_rules('p_fname', 'First Name', 'xss_clean|trim|required|alpha|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('p_lname', 'Last Name', 'xss_clean|trim|required|alpha|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('p_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_zip_code', 'Zip Code', 'xss_clean|trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('p_city', 'City', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('p_Items', 'country', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_userState', 'state', 'xss_clean|trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('claim_a_business_process_forms', $data);
        }
        else
        {
            //echo '<pre>'; print_r($_POST); die;
            if (isset($_POST['p_email_announc']))
            {
                $email_announc = 1;
            }
            else
            {
                $email_announc = 0;
            }
            if (isset($_POST['p_addr_addon']))
            {
                $addr_addon = $_POST['p_addr_addon'];
            }
            else
            {
                $addr_addon = "--";
            }
            $user_password = md5($_POST['p_user_password']);

            $sess_user_info = array(
                "username" => $_POST['p_username'],
                "user_email" => $_POST['p_user_email'],
                "user_password" => $user_password,
                /*"acc_type" => $_POST['p_acc_type'],*/
                "fname" => $_POST['p_fname'],
                "lname" => $_POST['p_lname'],
                "address" => $_POST['p_address'],
                "addr_addon" => $addr_addon,
                "Items" => $_POST['p_Items'],
                "userState" => $_POST['p_userState'],
                "zip_code" => $_POST['p_zip_code'],
                "city" => $_POST['p_city'],
                "email_announc" => $email_announc
            );
            // "Items" => $_POST['Items'],"userState" => $_POST['userState'],
            $this->session->set_userdata($sess_user_info);
            
            
            
            if ($claimRequestedUserId!= '')
            {
                //Store User information in tbl_user
                $field_data = array('user_name' => $this->input->post('p_username'),
                    'user_email' => $this->input->post('p_user_email'),
                    'user_password' => md5($this->input->post('p_user_password')),
                    'user_fname' => $this->input->post('p_fname'),
                    'user_lname' => $this->input->post('p_lname'),
                    'user_city' => $this->input->post('p_city'),
                    'user_country' => $this->input->post('p_Items'),
                    'user_state' => $this->input->post('p_userState'),
                    'user_address' => $this->input->post('p_address'),
                    'user_address_addon' => $addr_addon,
                    'user_zipcode' => $this->input->post('p_zip_code'),
                    'user_email_anno_check' => $email_announc,
                   /* 'user_plan' => $this->input->post('p_acc_type'),*/
                    'user_registered_date' => _getDateAndTime(),
                    'user_update_date' => _getDateAndTime(),
                    'user_acc_status' => "A",
                    'act_link_click_status' => 0,
                    'user_type' => "site_user",
                    'user_plan' => '',
                );
                $where = array('user_id' => $claimRequestedUserId);
                $data = $this->mdgeneraldml->update($where, 'tbl_user', $field_data);
                $sess_user_id = array('buss_user_id' => $claimRequestedUserId);
            }
            else
            {
                //Store User information in tbl_user
                $field_data = array('user_name' => $this->input->post('p_username'),
                    'user_email' => $this->input->post('p_user_email'),
                    'user_password' => md5($this->input->post('p_user_password')),
                    'user_fname' => $this->input->post('p_fname'),
                    'user_lname' => $this->input->post('p_lname'),
                    'user_city' => $this->input->post('p_city'),
                    'user_country' => $this->input->post('p_Items'),
                    'user_state' => $this->input->post('p_userState'),
                    'user_address' => $this->input->post('p_address'),
                    'user_address_addon' => $addr_addon,
                    'user_zipcode' => $this->input->post('p_zip_code'),
                    'user_email_anno_check' => $email_announc,
                    'user_registered_date' => _getDateAndTime(),
                    'user_update_date' => _getDateAndTime(),
                    'user_acc_status' => "A",
                    'act_link_click_status' => 0,
                    'user_type' => "site_user",
                    'user_plan' => ''
                );
                $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
                $last_ins_user_id = $data['last_insertId'];
               // $sess_user_id = array('buss_user_id' => $last_ins_user_id);
                //Send Email
                $uname = $this->input->post('p_username');
                $email = $this->input->post('p_user_email');
                $password = $this->input->post('p_user_password');
                $encryption_str = $uname . "/" . $data['last_insertId'];
                $enc_text = base64_encode($encryption_str);
                $activation_url=base_url() . "user/activated_user/" . $enc_text;                
                $sess_user_id = array('buss_user_id' => $last_ins_user_id,'activation_url'=>$activation_url);// Remove activation_url when email starts
                
                $this->session->set_userdata($sess_user_id);  
                
                
                //update claim claim user
                $whereClaim=array('crId'=>$claimRequestId);
                $data = $this->mdgeneraldml->update($whereClaim, 'tbl_cliam_requests', array('crRequesterUserId'=>$last_ins_user_id));
            }
           
            //$all=$this->session->all_userdata();
            //echo '<pre>'; print_r($all); die;
            if (count($sess_user_info) != 0)
                redirect('claim/registeration/prem/2/'.$claimRequestId.'#address13');
            else
                redirect('claim/registeration/prem/1/'.$claimRequestId.'#address12');
        }
    }

    
    function checkForPremiumMediaCopy()
    {
        ini_set('memory_limit','-1');
        //echo '<pre>';print_r($_FILES['p_upload_photos']); die;
        $files=$_FILES['p_upload_photos'];
        //echo sizeof($files['name']);
        if(sizeof($files['name'])>6){
            $this->form_validation->set_message('checkForPremiumMediaCopy', 'You can not upload more than six files.');
            return FALSE;
        }else{
            $types=$files['type'];
            $flag=true;
            foreach($types as $key=>$val)
            {
                if($val!="")
                {
                    $typeArray=explode("/", $val);
                    if($typeArray[0]!='image')
                        $flag=false;
                }else{
                    $this->form_validation->set_message('checkForPremiumMediaCopy', 'You can only upload the image file.');
                    return FALSE;
                }
            }
            
            if($flag==true)
                return TRUE;
            else{
                $this->form_validation->set_message('checkForPremiumMediaCopy', 'You can only select upload the image file.');
                return FALSE;
            }
        }
    }
    //Step 2 of premium form
    public function submitForm_buss_prem($data)
    {    
        
        $claimRequestId=$data['claimRequestId'];
        $claimRequestedUserId=$data['claimRequestedUserId'];
        $claimBusinessId=$data['claimBusinessId'];
        //claimRequestId claimBusinessId claimRequestedUserId
        
      // $this->form_validation->set_rules('p_buss_name', 'Business Name', 'xss_clean|trim|required|min_length[2]|max_length[125]|callback_alpha_dash_space');
       $this->form_validation->set_rules('p_buss_name', 'Business Name', 'xss_clean|trim|required|min_length[2]|max_length[125]');
        $this->form_validation->set_rules('p_buss_cont_name', 'Contact Name', 'xss_clean|trim|max_length[125]');
        $this->form_validation->set_rules('p_buss_addr', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_buss_addr_addon', 'Address add on', 'xss_clean|trim');
        $this->form_validation->set_rules('p_buss_country', 'country', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_buss_state', 'State', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_buss_city', 'City', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('p_buss_zipcode', 'Zip code', 'xss_clean|trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('p_buss_phone', 'Phone', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_buss_fax', 'Fax', 'xss_clean|trim|numeric');
        $this->form_validation->set_rules('p_buss_web_addr', 'Web Address', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('p_buss_email_addr', 'Email', 'xss_clean|trim|valid_email|required');
        $this->form_validation->set_rules('p_buss_lice_num', 'License Number', 'xss_clean|trim');       
        $this->form_validation->set_rules('p_userCategory[]', 'Business Category', 'xss_clean|trim|required');
        
        $this->form_validation->set_rules('p_buss_sco_one', 'Twitter url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('p_buss_sco_two', 'Facebook url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('p_buss_sco_three', 'Pinterest url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('p_buss_sco_four', 'LinkedIn url', 'xss_clean|trim|callback_validateUrl');   
       
        $this->form_validation->set_rules('p_acc_type1', 'Plan type', 'xss_clean|trim|required');  
        
        $this->form_validation->set_rules('we_r_hir', "We're hiring", '');   
        $this->form_validation->set_rules('comp_quot', 'Competitive quotes', '');   
        if($this->input->post('comp_quot')!="")
        {
            //echo $this->input->post('comp_quot'); die;
            $this->form_validation->set_rules('addition_email', 'Email', 'xss_clean|trim|required|valid_email');
        }
        
        /*File Upload Validations*/
        
        if(@$_FILES['p_upload_logo']['name']!=""){
            $this->form_validation->set_rules('p_upload_logo','LOGO','file_min_size[10KB]|file_max_size[3072KB]|file_allowed_type[image]|file_image_mindim[50,50]|file_image_maxdim[1024,768]|file_required');
        }
        
        if(!empty($_FILES['p_upload_photos']) && $_FILES['p_upload_photos']['name'][0]!="")
        {    
            $this->form_validation->set_rules('p_upload_photos[]','Media Copy','callback_checkForPremiumMediaCopy');
        }
        
         if(!empty($_FILES['p_license_docs']) && $_FILES['p_license_docs']['name'][0]!=""){              
            $this->form_validation->set_rules('p_license_docs[]','Business license','callback_checkForPreLicenseDocs');
        }
        
        //Card Validations        
        $this->form_validation->set_rules('p_nameOnCard', 'Name on card', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('p_c_address_1', 'Address Line 1', 'xss_clean|trim|required|callback_alpha_dash_space');
        //$this->form_validation->set_rules('p_c_address_2', 'Address Line 2', 'xss_clean|trim|required|callback_alpha_dash_space');
        $this->form_validation->set_rules('p_c_address_2', 'Address Line 2', 'xss_clean|trim');
        $this->form_validation->set_rules('p_c_city', 'City', 'xss_clean|trim|required|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('p_c_state', 'State', 'xss_clean|trim|required');
        $this->form_validation->set_rules('p_c_Items', 'Country', 'required');
        $this->form_validation->set_rules('p_c_email', 'Email', 'xss_clean|trim|valid_email');
        $this->form_validation->set_rules('p_c_phone_no', 'Phone No', 'xss_clean|trim|numeric');
        $this->form_validation->set_rules('p_cardType', 'Card Type', 'trim|required');
        $this->form_validation->set_rules('p_c_card_num', 'Card Number', 'xss_clean|trim|required|numeric');
        $this->form_validation->set_rules('p_c_secu_code', 'Security Code', 'xss_clean|trim|required|numeric');
        $this->form_validation->set_rules('p_c_zip_code', 'Zip Code', 'trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('p_c_cvv2_no', 'CVV2 Number', 'trim|numeric');
        $this->form_validation->set_rules('p_expiryMonth', 'Expiration Month', 'trim|required');
        $this->form_validation->set_rules('p_expiryYear', 'Expiration Date', 'trim|required');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('claim_a_business_process_forms', $data);
        }
        else
        {
         // $all=$this->session->all_userdata();
        //echo '<pre>'; print_r($data); die;  
        if (isset($_POST['comp_quot']))
                $comp_quot = 1;
            else
                $comp_quot=0;
             if (isset($_POST['mon_d_and_s']))
                $mon_d_and_s = 1;
            else
                $mon_d_and_s=0;
             if (isset($_POST['we_r_hir']))
                $we_r_hir = 1;
            else
                $we_r_hir=0;
            
            //claimRequestId claimBusinessId claimRequestedUserId
            if ($claimRequestedUserId != '')
                $user_id = $claimRequestedUserId;
            else
            {
                $this->session->flashdata('session expire from premium step 2');
                redirect('claim/error_page');
            }
            
            //echo '<br/> claimRequestedUserId exist.';
            //Get sub-subscription plans
            $tbl_subscription_sub_plans = 'tbl_subscription_sub_plans';
            $data['sub_plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_sub_plans);

            //Get Amount
            if ($this->input->post('p_acc_type1') == 'pm')
            {
                $subscription_plan_id = $data['sub_plan_details'][3]['subs_plan_id'];
                $subscription_sub_plan_id = $data['sub_plan_details'][3]['subs_sub_plan_id'];
                //$amount = $data['sub_plan_details'][3]['subs_sub_plan_price'];
                
                 //Get Promocode for Prem Monthly
                $amount_before = $data['sub_plan_details'][3]['subs_sub_plan_price'];
                $tbl_promo_codes = "tbl_promo_codes";
                $cnd_tbl_promo_codes = "pc_code = '" . $this->input->post('p_promocode1') . "' and pc_plan_type_id ='" . $subscription_sub_plan_id . "' ";
                $db_pro_code = $this->db_transact_model->get_single_record($tbl_promo_codes, $cnd_tbl_promo_codes);
                 if (!empty($db_pro_code))
                {
                    if ($db_pro_code[0]['pc_status'] == 'A')
                    {  $discount = $db_pro_code[0]['pc_discount'];
                        $premium_total_cost = $amount_before - $discount;
                        $amount = number_format($premium_total_cost,2,'.','');
                    }
                    else
                    {
                        $amount = $data['sub_plan_details'][3]['subs_sub_plan_price'];
                    }
                }
                else
                {
                    $amount = $data['sub_plan_details'][3]['subs_sub_plan_price'];
                }
                //End  
                
                
            }
            else
            {
                $subscription_plan_id = $data['sub_plan_details'][2]['subs_plan_id'];
                $subscription_sub_plan_id = $data['sub_plan_details'][2]['subs_sub_plan_id'];
                //$amount = $data['sub_plan_details'][2]['subs_sub_plan_price'];
                               
                //Get Promocode for Prem Annually
                $amount_before = $data['sub_plan_details'][2]['subs_sub_plan_price'];
                $tbl_promo_codes = "tbl_promo_codes";
                $cnd_tbl_promo_codes = "pc_code = '" . $this->input->post('p_promocode1') . "' and pc_plan_type_id ='" . $subscription_sub_plan_id . "' ";
                $db_pro_code = $this->db_transact_model->get_single_record($tbl_promo_codes, $cnd_tbl_promo_codes);
                 if (!empty($db_pro_code))
                {
                    if ($db_pro_code[0]['pc_status'] == 'A')
                    {  $discount = $db_pro_code[0]['pc_discount'];
                        $premium_total_cost = $amount_before - $discount;
                        $amount = number_format($premium_total_cost,2,'.','');
                    }
                    else
                    {
                        $amount = $data['sub_plan_details'][2]['subs_sub_plan_price'];
                    }
                }
                else
                {
                    $amount = $data['sub_plan_details'][2]['subs_sub_plan_price'];
                }
                //End 
                
            }

            //Take Only last 4 digits of Credit card
            $creditCardNo = $this->input->post('p_c_card_num');
            $first = substr($creditCardNo, 0, -4);
            $last4Digits = substr($creditCardNo, -4);
            $chunks = str_split(str_repeat('X', strlen($first)), 4);
            $ccNoForDB = implode('-', $chunks) . (strlen($creditCardNo) >= 16 ? '-' : '') . $last4Digits;

            //Make Payment (Send Info to __doCreditCardPayment function)
            $infoArray = array('address1' => $this->input->post('p_c_address_1'),
                'address2' => $this->input->post('p_c_address_2'),
                'city' => $this->input->post('p_c_city'),
                'state' => $this->input->post('p_c_state'),
                'zip' => $this->input->post('p_c_zip_code'),
                'phone' => $this->input->post('p_c_phone_no'),
                'cardType' => $this->input->post('p_cardType'),
                'creditCardNumber' => $this->input->post('p_c_card_num'),
                'expDateMonth' => $this->input->post('p_expiryMonth'),
                'expDateYear' => $this->input->post('p_expiryYear'),
                'cvv2Number' => $this->input->post('p_c_secu_code'),
                'firstName' => $this->session->userdata('p_fname'),
                'lastName' => $this->session->userdata('p_lname'),
                'amount' => $amount
            );
            // print_r($infoArray);die;
            $authTransactionId="";
            $processFlag = true;
            //$responce = $this->__doCreditCardPayment($infoArray);
            //new condition added by Bhagwan dated on 21-April-2014 (now user can registred if registration fee is 0 also. 
            //but here we avoid payment option)
            if($amount>0){
                $responce = __authorisedPayment($infoArray);
                if ($responce['status'] == 'fail')
                    $processFlag = false;            
                else            
                {
                    $processFlag = true;
                    $authTransactionId=$responce['transactionId'];
                }
            }     
            
            if ($processFlag == false)
            {
                $data['p_error'] = $responce['errorData'];
                //echo '<br/> payment fail.'; die;
                $this->load->view('claim_a_business_process_forms', $data);
                //redirect(base_url() . 'services/show_err/');
            }
            else
            {
               //File Upload Media Photos
                if (!file_exists("./Media_Copy"))
                {
                    mkdir('./Media_Copy/', 0777, true);
                }
                $mediaCoppyFileNames=$this->do_MultipleUpload('p_upload_photos'); 
                //End
                
                //upload multiple docs
                //create directory if not exist
                if (!file_exists("./sitedata/bisiness_license_docs"))                
                    mkdir('./sitedata/bisiness_license_docs/', 0777, true);
                
                $businessLicensesDocsNames=$this->uploadMultipleDocs('p_license_docs',$mediaCoppyFileNames);
                
                //File Upload LOGO
                if (!file_exists("./LOGO"))
                {
                    mkdir('./LOGO/', 0777, true);
                }
                
                $bussLogo="default_logo.jpg";
                $error="";
                if($_FILES['p_upload_logo']['name']!="")
                {    
                    $logInfo=$this->_uploadLogo('p_upload_logo');
                    $bussLogo=$logInfo['fileName'];
                    $error=$logInfo['error'];
                }
                //End

                if (isset($_POST['p_buss_addr_addon']))
                    $addr_addon = $_POST['p_buss_addr_addon'];
                else
                    $addr_addon = "--";
               


                //Store User information in tbl_user
                $field_data = array('user_id' => $user_id,
                    'buss_name' => $this->input->post('p_buss_name'),
                    'buss_cont_name' => $this->input->post('p_buss_cont_name'),
                    'buss_address' => $this->input->post('p_buss_addr'),
                    'buss_addr_addon' => $addr_addon,
                    //'buss_country' => $this->input->post('p_buss_country'),
                    'buss_state' => $this->input->post('p_buss_state'),
                    'buss_city' => $this->input->post('p_buss_city'),
                    'buss_zip_code' => $this->input->post('p_buss_zipcode'),
                    'buss_phone' => $this->input->post('p_buss_phone'),
                    'buss_fax' => $this->input->post('p_buss_fax'),
                    'buss_web_address' => $this->input->post('p_buss_web_addr'),
                    'buss_email' => $this->input->post('p_buss_email_addr'),                    
                    'buss_license_num' => $this->input->post('p_buss_lice_num'),
                    'buss_social_media_channel_1' => $this->input->post('p_buss_sco_one'),
                    'buss_social_media_channel_2' => $this->input->post('p_buss_sco_two'),
                    'buss_social_media_channel_3' => $this->input->post('p_buss_sco_three'),
                    'buss_social_media_channel_4' => $this->input->post('p_buss_sco_four'),  
                    'buss_comp_email'=>$this->input->post('addition_email'),
                    'buss_comp_quot'=>$comp_quot,
                    'mon_d_and_s'=>$mon_d_and_s,
                    'we_r_hir'=>$we_r_hir
                );
                
                if($mediaCoppyFileNames!="")
                    $field_data['buss_media_copy']=$mediaCoppyFileNames;
                if($bussLogo!="")
                    $field_data['buss_logo']=$bussLogo;
                if($businessLicensesDocsNames!="")
                    $field_data['buss_license_docs']=$businessLicensesDocsNames;
                
                
                //update business                
                $whereBusiness=array('buss_id'=>$claimBusinessId);
                $data = $this->mdgeneraldml->update($whereBusiness, 'tbl_business_info', $field_data);
                
                //create category if user has selected other
                $category=$this->input->post('p_userCategory');
                //delete previous business cats those are assigned to this business               
                $this->mdgeneraldml->delete(array('buss_id'=>$claimBusinessId),'tbl_business_categories');
                
                //assign new categories to the business
                foreach($category as $key=>$categoryId){
                    if($categoryId!="other"){
                        $businessCat_data=array('buss_id'=>$claimBusinessId,'cat_id'=>$categoryId);
                        $this->mdgeneraldml->insert('tbl_business_categories', $businessCat_data);
                     }
                }
                
                //update claim and business                
                $this->_updateBusinessAndClaim($claimRequestId,$claimBusinessId,$claimRequestedUserId);                
                
                //Update user account to bussiness user
                $user_info_data = array(
                    'user_plan' => $this->input->post('p_acc_type1'),
                    'user_type' => "buss_user"
                );
                $where = array('user_id' => $user_id);
                $user_info_updated = $this->mdgeneraldml->update($where, 'tbl_user', $user_info_data);
                
                //Insert Data in tbl_user_credit_card_info
                $cardInfo = array(
                    'ccUserId' => $user_id,
                    'paypal_cardId' => $authTransactionId,
                    'ccNameOnCard' => $this->input->post('p_nameOnCard'),
                    'ccAddress' => $this->input->post('p_c_address_1'),
                    'ccAddress2' => $this->input->post('p_c_address_2'),
                    'ccCity' => $this->input->post('p_c_city'),
                    'ccState' => $this->input->post('p_c_state'),
                    'ccPostalCode' => $this->input->post('p_c_zip_code'),
                    'ccCountryCode' => $this->input->post('p_c_Items'),
                    'ccEmail' => $this->input->post('p_c_email'),
                    'ccPhoneNumber' => $this->input->post('p_c_phone_no'),
                    'ccType' => $this->input->post('p_cardType'),
                    'ccCardNumber' => $ccNoForDB,
                    'ccSecurityCode' => $this->input->post('p_c_secu_code'),
                    'ccExpiryMonth' => $this->input->post('p_expiryMonth'),
                    'ccExpiryYear' => $this->input->post('p_expiryYear'),
                    'ccCreatedOn' => _getDateAndTime(),
                    'ccUpdatedOn' => _getDateAndTime()
                );
                $data = $this->mdgeneraldml->insert('tbl_user_credit_card_info', $cardInfo);
               
                //Insert Data in tbl_transaction_history
                $transInfo = array(
                    'user_id' => $user_id,
                    'tran_hist_amount' => $amount,
                    'tran_hist_transaction_id' => $authTransactionId,
                    'tran_subscription_plan_id' => $subscription_plan_id,
                    'tran_subscription_sub_plan_id' => $subscription_sub_plan_id,
                    'tran_hist_date' => _getDateAndTime()
                );
                $data = $this->mdgeneraldml->insert('tbl_transaction_history', $transInfo);
                
                $today = _getDate();
                if ($this->input->post('p_acc_type1') == 'pm')
                {
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+1 month");
                    $end_date = date('Y-m-d', $end_datemonth);
                }
                else
                {
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+12 month");
                    $end_date = date('Y-m-d', $end_datemonth);
                }
                
                //Insert Subscription info
                $subscription_info = array(
                    'user_id' => $user_id,
                    'sub_plan_id' => $subscription_plan_id,
                    'sub_subplan_id' => $subscription_sub_plan_id,
                    'sub_start_date' => $today,
                    'sub_end_date' => $end_date
                );
                $data = $this->mdgeneraldml->insert('tbl_user_subscription_plan_info', $subscription_info);                

                if ($data !== 0)
                {
                     $sess_user_info = array("username" => '',"user_email" => '',"user_password" => '',"acc_type" => '',"fname" => '',"lname" => '',
                        "address" => '',"addr_addon" => '',"zip_code" => '',"city" => '',"email_announc" => '',"buss_user_id" => '');
                    $this->session->unset_userdata($sess_user_info);
                    $this->session->unset_userdata('user_id');
                    $this->session->unset_userdata('user_email');
                    $this->session->unset_userdata('user_name');
                    $this->session->unset_userdata('user_type');
                    delete_cookie('mem_login_info');
                    //destroy session
                    //$this->session->sess_destroy();
                    
                    //create new session and do logged in to the new registered user.
                    //set new session
                    $newUSerInfo=$this->mdgeneraldml->select('user_name,user_fname,user_fname,user_lname,user_email,user_type','tbl_user',array('user_id'=>$user_id));
                    $newSessionData=array('user_id'=>$user_id);
                    if(!empty($newUSerInfo)){
                        $newSessionData=array(
                            'user_id'=>$user_id,
                            'user_email'=>$newUSerInfo[0]['user_email'],
                            'user_name'=>$newUSerInfo[0]['user_name'],
                            'user_type'=>$newUSerInfo[0]['user_type']                       
                        );
                    }
                    $this->session->set_userdata($newSessionData);
                    
                    //send claim process complete email to admin                              
                    $this->_sendClaimEmail($user_id,$claimBusinessId,$claimRequestId);
                    
                    //send subscription email to admin
                    $this->_sendSubscriptionMailToAdmin($user_id,$this->input->post('p_buss_name'), $this->input->post('p_promocode1'), $amount);
                    
                    $activationURL=$this->session->userdata('activation_url');
                    $url = site_url('dashboard/business_listing/view/'.$claimBusinessId);          
                    $successString = 'You have registered to Word Of Mouth successfully.';
                    echo "<script>alert('".$successString."');window.location.href='$url'</script>";
                }
            }
        }
    }

    function getCountrys()
    {
        $countryList = _getCountryList();
        $responseArray = array();

        foreach ($countryList as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }

    function getStateList($countryCode)
    {
        //$st='id="userState" class="items"';//stateHolder
        // echo form_dropdown('userState', _getStateList($countryCode),set_value('userState'),'id="userState" class="items"'); 
        $stateList = _getStateList($countryCode);
        foreach ($stateList as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }

    function __doCreditCardPayment($infoArray)
    {
        require APPPATH . 'third_party/paypal/bootstrap.php';

        // ### Address
        // Base Address object used as shipping or billing
        // address in a payment. [Optional]
        $addr = new Address();
        $addr->setLine1($infoArray['address1']);

        if ($infoArray['address2'] != "")
            $addr->setLine2($infoArray['address2']);

        $addr->setCity($infoArray['city']);
        $addr->setState($infoArray['state']);
        $addr->setPostal_code($infoArray['zip']);
        //$addr->setCountry_code($infoArray['country']);
        $addr->setCountry_code('US');

        if ($infoArray['phone'] != "")
            $addr->setPhone($infoArray['phone']);

        // ### CreditCard
        // A resource representing a credit card that can be
        // used to fund a payment.
        $card = new CreditCard();
        $card->setType($infoArray['cardType']);
        $card->setNumber($infoArray['creditCardNumber']);
        $card->setExpire_month($infoArray['expDateMonth']);
        $card->setExpire_year($infoArray['expDateYear']);
        $card->setCvv2($infoArray['cvv2Number']);
        $card->setFirst_name($infoArray['firstName']);

        if ($infoArray['lastName'] != "")
            $card->setLast_name($infoArray['lastName']);

        $card->setBilling_address($addr);

        // ### FundingInstrument
        // A resource representing a Payer's funding instrument.
        // Use a Payer ID (A unique identifier of the payer generated
        // and provided by the facilitator. This is required when
        // creating or using a tokenized funding instrument)
        // and the `CreditCardDetails`
        $fi = new FundingInstrument();
        $fi->setCredit_card($card);

        // ### Payer
        // A resource representing a Payer that funds a payment
        // Use the List of `FundingInstrument` and the Payment Method
        // as 'credit_card'
        $payer = new Payer();
        $payer->setPayment_method("credit_card");
        $payer->setFunding_instruments(array($fi));

        // ### Amount
        // Let's you specify a payment amount.
        $amount = new Amount();
        $amount->setCurrency("USD");
        $amount->setTotal($infoArray['amount']);

        // ### Transaction
        // A transaction defines the contract of a
        // payment - what is the payment for and who
        // is fulfilling it. Transaction is created with
        // a `Payee` and `Amount` types
        $transaction = new Transaction();
        $transaction->setAmount($amount);
        $transaction->setDescription("This is the payment description.");

        // ### Payment
        // A Payment Resource; create one using
        // the above types and intent as 'sale'
        $payment = new Payment();
        $payment->setIntent("sale");
        $payment->setPayer($payer);
        $payment->setTransactions(array($transaction));



        // ### Create Payment
        // Create a payment by posting to the APIService
        // using a valid ApiContext (See bootstrap.php for more on `ApiContext`)
        // The return object contains the status;

        $returnInfo = array('status' => '', 'successData' => '', 'payPalTransactionId' => '', 'errorData' => '', 'errorExceptionMessage' => '');
        try
        {
            $payment->create($apiContext);
        }
        catch (PayPal\Exception\PPConnectionException $ex)
        {
            $returnInfo['status'] = 'fail';
            $returnInfo['errorData'] = $ex->getData();
            $returnInfo['errorExceptionMessage'] = $ex->getMessage() . PHP_EOL;

            //echo "Exception: " . $ex->getMessage().PHP_EOL;
            //echo '<pre>'; print_r($ex->getData());
            return $returnInfo;
            exit(1);
        }

        $returnInfo['status'] = 'success';
        $returnInfo['payPalTransactionId'] = $payment->getId();
        $returnInfo['successData'] = $payment->toArray();
        return $returnInfo;
        //echo $payment->getId();
        //echo '<pre>'; print_r($payment->toArray());
    }

    public function show_err()
    {
        $this->load->view('transaction_fail_view');
    }
    function getState($countryCode)
    {
        $get_user_state = "SELECT user_state FROM tbl_user WHERE tbl_user.user_id='" . $this->session->userdata('claimRequestedUserId') . "'";
        $result_user_state = $this->db->query($get_user_state)->result_array();

        $get_state = "SELECT state_id,state_name FROM tbl_state WHERE state_id='" . $result_user_state[0]['user_state'] . "'";
        
        $result_state = $this->db->query($get_state)->result_array();

        foreach ($result_state as $key => $val)
        {
            $list[$val['state_id']] = $val['state_name'];
        }


        foreach ($list as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }
    
    function _uploadLogo($inputFileName){
                $config['upload_path'] = './LOGO';
                /*$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                $config['max_size'] = '1000';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';*/
                $imageName=date('YmdHms').'.jpg';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                $config['max_size'] = 0;
                $config['max_width'] = 0;
                $config['max_height'] = 0;
                $config['file_name'] = $imageName;//$this->input->post('upload_logo');
                $config['overwrite'] = TRUE;
                //$config['quality'] = 100;
                $this->load->library('upload');
                $this->upload->initialize($config);
                $error="";
                $data_logo=array('error'=>'','fileName'=>'default_logo.jpg');                
                if(!$this->upload->do_upload($inputFileName))
                {
                    $data_logo['error']=$this->upload->display_errors();                    
                }
                else
                {
                    $sucessInfo= $this->upload->data();
                    $data_logo['fileName']=$sucessInfo['file_name'];
                }
                return $data_logo;
    }
    
    function alpha_dash_space($str_in)
    {
        if (!preg_match("/^([-a-z0-9_ ])+$/i", $str_in))
        {
            $this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain Alpha-Numeric Characters, Spaces, Underscores, and Dashes.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }
    
    function validateAlphabetsWithSpace($string){
         //alphbets with space allowed
        $rex = '/^[a-zA-Z][a-zA-Z ]*$/';
       if (preg_match($rex, $string)){
           return TRUE;
        }
        else
        {
            $this->form_validation->set_message('validateAlphabetsWithSpace', 'Numbers and special characters are not allowed.');
            return FALSE;
        }
    }
    
    function validateUrl($string){
       if(trim($string)=="") 
           return TRUE;
       
       //echo prep_url($string); die;
       
       if (filter_var($string, FILTER_VALIDATE_URL)){
           return TRUE;
        }
        else
        {
            $this->form_validation->set_message('validateUrl', 'Please enter valid url. (Ex: http://www.example.com).');
            return FALSE;
        }

    }
    
    function _sendClaimEmail($userId,$businessId,$claimId){
        //send claim process completed email to admin
        
        //get user info
        $sql="SELECT CONCAT(u.user_fname,' ',u.user_lname) as userFullName,b.buss_name FROM tbl_user as u,tbl_business_info as b WHERE u.user_id=$userId AND b.buss_id=$businessId";
        $res=$this->WGModel->sqlQuery($sql);   
        
        
        $where_Id=array('emailId'=>'118');
        $emailinfo=$this->mdgeneraldml->select('emailBody,emailSubject','tbl_email_contents',$where_Id);

        $emilTemplet=$emailinfo[0]['emailBody'];
        $emilTempletSubject=$emailinfo[0]['emailSubject'];

        $userFullName=$res[0]['userFullName'];
        $businessName=$res[0]['buss_name'];
        $businessLink=anchor('home/business_details/'.$businessId,'Click Here');
        $claimLink=anchor('admin/manage_claims/view/'.$claimId,'Click Here');
        $userProfileLink=anchor('admin/user/view_details/'.$userId,'Click Here');

        $emailBody=str_replace ("[[BUSINESS_USER_FULL_NAME]]", $userFullName, $emilTemplet);
        $emailBody=str_replace ("[[BUSINESS_NAME]]", $businessName, $emailBody);
        $emailBody=str_replace ("[[BUSINESS_LINK]]", $businessLink, $emailBody);
        $emailBody=str_replace ("[[USER_PROFILE_LINK]]", $userProfileLink, $emailBody);
        $emailBody=str_replace ("[[CLAIM_LINK]]", $claimLink, $emailBody);
		@send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody); 
    }
    
    function _sendSubscriptionMailToAdmin($userId,$bussName,$promo_code,$amount){
        //send email to admin regarding subscription purchased by user.
        $where_Id=array('emailId'=>'119');
        $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);

        $userInfo=$this->mdgeneraldml->select('user_fname,user_lname,user_plan','tbl_user',array('user_id'=>$userId));
        $userName=$userInfo[0]['user_fname'].' '.$userInfo[0]['user_lname'];
        $userPlan=$userInfo[0]['user_plan'];//plan can be bm,ba,pm and pa

        $planArray=array('bm'=>'Monthly Basic','ba'=>'Annually Basic','pm'=>'Monthly Premium','pa'=>'Annually Premium');
        $packageName=$planArray[$userPlan];

        $emilTemplet=$emailinfo[0]['emailBody'];
        $emilTempletSubject=$emailinfo[0]['emailSubject'];

        $emailBody=str_replace ("[[USER_FULL_NAME]]", $userName, $emilTemplet);
        $emailBody=str_replace ("[[PACKAGE_NAME]]", $packageName, $emailBody);
		$emailBody=str_replace ("[[BUSS_NAME]]", $bussName, $emailBody);
		if(!empty($promo_code)) {
			$emailBody=str_replace ("[[HAS_USED_PROMO_CODE]]", $promo_code, $emailBody);
		}
		else {
			$emailBody=str_replace ("[[HAS_USED_PROMO_CODE]]", 'Promo Code has not been used', $emailBody);
		}
		$emailBody=str_replace ("[[AMOUNT_PAID]]", $amount, $emailBody);

        //send email to admin
        @send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody);
    }
}

/* End of file services.php */
/* Location: ./application/controllers/services.php */