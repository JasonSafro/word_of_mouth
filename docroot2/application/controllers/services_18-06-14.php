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

class Services extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        //echo date('Y-m-d',strtotime('+1 day',strtotime(date('Y-m-d'))));die;
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
        $this->load->library('session');     //  This Library is use to When session get created.	
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->library('upload');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        //echo $this->session->userdata('user_id'); die;
    }

    //Services Page
    public function index($type='basic', $step='1')
    {   //Get subscription plans
       
        //$s=$this->session->all_userdata(); echo '<pre>'; print_r($s); die;
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
        if ($this->session->userdata('user_id') != '')
        {
            $tbl = "tbl_user";
            $select = 'tbl_user.*';
            $cnd = array('tbl_user.user_id = ' => $this->session->userdata('user_id'));
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
        // echo $this->db->last_query(); die;
        // echo '<pre>'; print_r($data); die;

        /*  $this->load->view('includes/header');
          $this->load->view('services_view',$data);
          $this->load->view('includes/footer'); */
        // $this->load->view('includes/header');
        //$this->load->view('services_view_html2',$data);
        //$this->load->view('includes/footer');
        $data['error'] = '';
        $data['p_error'] = '';
        if ($type == 'basic')
        {
            if ($step == 1)
                $this->submitForm_basic($data);
            else
            {   
                $this->submitForm_buss_basic($data);
            }
        }else
        {
            if ($step == 1)
                $this->submitForm_prem($data);
            else
                $this->submitForm_buss_prem($data);
        }
    }
   
    //basic step 1
    public function submitForm_basic($data)
    {
        $this->form_validation->set_rules('username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|is_unique[tbl_user.user_name]');
        $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
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
            $this->load->view('services_view_html2', $data);
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
                "email_announc" => $email_announc,
                
            );
            $this->session->set_userdata($sess_user_info);

            if ($this->session->userdata('user_id') != '')
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
                $where = array('user_id' => $this->session->userdata('user_id'));
                $data = $this->mdgeneraldml->update($where, 'tbl_user', $field_data);
                $sess_user_id = array('buss_user_id' => $this->session->userdata('user_id'));
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

                $where_Id=array('emailId'=>'104');
                $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                        
                $emilTemplet=$emailinfo[0]['emailBody'];
                $emilTempletSubject=$emailinfo[0]['emailSubject'];
                
                $emailBody=str_replace ("[[USER_FULL_NAME]]", $uname, $emilTemplet);
                //$emailBody=str_replace ("[[LINK]]", $activation_url, $emailBody);
                @send_email($email,$emilTempletSubject,$emailBody); 
                              
                $sess_user_id = array('buss_user_id' => $last_ins_user_id,'activation_url'=>$activation_url);// Remove activation_url when email starts
                $this->session->set_userdata($sess_user_id);
            }
            if (count($sess_user_info) != 0)
                redirect('services#address11');
            else
                redirect('services#address10');
        }
    }

    //Step 2 of basic form
    function submitForm_buss_basic($data)
    {
       
        //echo '<pre>';print_r($_FILES['upload_photos']); die; 
        $this->form_validation->set_rules('buss_name', 'Business Name', 'xss_clean|trim|required|min_length[2]|max_length[125]|callback_alpha_dash_space');
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
		$this->form_validation->set_rules('c_phone_no', 'Phone No', 'xss_clean|trim|numeric');
       
        $this->form_validation->set_rules('buss_sco_one', 'Twitter url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('buss_sco_two', 'Facebook url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('buss_sco_three', 'Pinterest url', 'xss_clean|trim|callback_validateUrl');   
        $this->form_validation->set_rules('buss_sco_four', 'LinkedIn url', 'xss_clean|trim|callback_validateUrl');  
        
        $this->form_validation->set_rules('b_acc_type', 'Plan type', 'xss_clean|trim|required');  
        /*if($this->input->post('userCategory')!=""){
        echo '<pre>'; print_r($this->input->post('userCategory')); 
        foreach($this->input->post('userCategory') as $key=>$val)
                echo $val.'= ';
        die;}*/
        $tmpCat=$this->input->post('userCategory');
        if(!empty($tmpCat)){
            if(in_array('other', $this->input->post('userCategory')))
                $this->form_validation->set_rules('otherCategory', 'Other Category', 'xss_clean|trim|required|max_length[15]|is_unique[tbl_category.catName]');
        }
        
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
        


        if($this->input->post('basicHiddenPaymentType')!='paypalImg'){
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
        }


        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('services_view_html2', $data);
        }
        else
        { 
            

            //echo '<pre>'; print_r($_POST); 
            //echo '<pre>';print_r($_FILES['upload_photos']); die;
            if ($this->session->userdata('user_id') != '')
                $user_id = $this->session->userdata('user_id');
            else if ($this->session->userdata('buss_user_id') != '')
                $user_id = $this->session->userdata('buss_user_id');
            else
                redirect('services#address10');
            

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
				$this->load->view('services_view_html2', $data);
                
            }
            else
            { 
                //echo "over here"; exit;

				$activationURL=$this->session->userdata('activation_url');
                //$tranId=(isset($responce['payPalTransactionId'])?$responce['payPalTransactionId']:'');
                $tranId=(isset($responce['transactionId'])?$responce['transactionId']:'');
                
                $businessId=$this->__saveBasicFormData($tranId);
                
                //destroy previous session
                 delete_cookie('mem_login_info');
                
                $this->session->unset_userdata('basicFormData');
                //$this->session->sess_destroy();   
               
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
                
                //$successString = 'You have registered to Word Of Mouth successfully! Please copy and paste this link \n'.$activationURL;
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
            return array('subscription_plan_id'=>$subscription_plan_id,'subscription_sub_plan_id'=>$subscription_sub_plan_id,'amount'=>$amount, 'promo_code'=>$this->input->post('b_promocode'));
    }
    
    function __saveBasicFormData($payPalTransactionId){
        
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
                    $addr_addon = $_POST['buss_addr_addon'];
                else
                    $addr_addon = "--";
                
                //create category if user has selected other
                $category=$form['userCategory'];
                if(in_array("other",$category))
                {
                   $newCatName=$form['otherCategory'];
                   $insertCatInfo = $this->mdgeneraldml->insert('tbl_category', array('catName'=>$newCatName,'catImageName'=>'default_category_image.png','catCreatedOn'=>_getDateAndTime(),'catStatus'=>'Active'));  
                   $category[]=$insertCatInfo['last_insertId'];
                }  
                
                
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
                    //'buss_category'=>$categoryId, 
                    'buss_license_num' => $form['buss_lice_num'],
                    'buss_social_media_channel_1' => $form['buss_sco_one'],
                    'buss_social_media_channel_2' => $form['buss_sco_two'],
                    'buss_social_media_channel_3' => $form['buss_sco_three'],
                    'buss_social_media_channel_4' => $form['buss_sco_four'],
                    'buss_media_copy' => $mediaCoppyFileNames,
                    'buss_logo' => $logoImageName,
                    'buss_license_docs' => $bussLicenseDocsNames,
                    'bussCreatedOn' => _getDateAndTime(),
                    'bussUpdatedOn' => _getDateAndTime()
                );
                //  'buss_category'=>, 
                $data = $this->mdgeneraldml->insert('tbl_business_info', $field_data);
                
                $businessId=$data['last_insertId'];
                foreach($category as $key=>$categoryId){
                    if($categoryId!="other"){
                        $businessCat_data=array('buss_id'=>$businessId,'cat_id'=>$categoryId);
                        $this->mdgeneraldml->insert('tbl_business_categories', $businessCat_data);
                     }
                }
                
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
                    
                    return $businessId;
    }

    //Step 1 of Premium Form
    public function submitForm_prem($data)
    {
        $this->form_validation->set_rules('p_username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|is_unique[tbl_user.user_name]');
        $this->form_validation->set_rules('p_user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
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
            $this->load->view('services_view_html2', $data);
        }
        else
        {
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

            if ($this->session->userdata('user_id') != '')
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
                    'user_acc_status'=> "A",
                    'act_link_click_status'=> 0,
                    'user_type'=> "site_user",
                    'user_plan'=> '',
                );
                $where = array('user_id' => $this->session->userdata('user_id'));
                $data = $this->mdgeneraldml->update($where, 'tbl_user', $field_data);
                $sess_user_id = array('buss_user_id' => $this->session->userdata('user_id'));
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
				
				$where_Id=array('emailId'=>'104');
                $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                        
                $emilTemplet=$emailinfo[0]['emailBody'];
                $emilTempletSubject=$emailinfo[0]['emailSubject'];
                
                $emailBody=str_replace ("[[USER_FULL_NAME]]", $uname, $emilTemplet);
                //$emailBody=str_replace ("[[LINK]]", $activation_url, $emailBody);
                @send_email($email,$emilTempletSubject,$emailBody);
				
                $sess_user_id = array('buss_user_id' => $last_ins_user_id,'activation_url'=>$activation_url);// Remove activation_url when email starts
                
                $this->session->set_userdata($sess_user_id);                
            }
           
            if (count($sess_user_info) != 0)
                redirect('services#address13');
            else
                redirect('services#address12');
        }
    }
   
    //Step 2 of premium form
    public function submitForm_buss_prem($data)
    {
        $this->form_validation->set_rules('p_buss_name', 'Business Name', 'xss_clean|trim|required|min_length[2]|max_length[125]|callback_alpha_dash_space');
        $this->form_validation->set_rules('p_buss_cont_name', 'Contact Name', 'xss_clean|trim||max_length[125]');
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
        
        $tmpCat=$this->input->post('p_userCategory');
        if(!empty($tmpCat)){
            if(in_array('other', $this->input->post('p_userCategory')))
                $this->form_validation->set_rules('p_otherCategory', 'Other Category', 'xss_clean|trim|required|max_length[15]|callback_validateAlphabetsWithSpace|is_unique[tbl_category.catName]');
        }
        
        
        /*File Upload Validations*/
        
        if($_FILES['p_upload_logo']['name']!=""){
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
            $this->load->view('services_view_html2', $data);
        }
        else
        {
            
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
            
          
              
            
            
            
            if ($this->session->userdata('user_id') != '')
                $user_id = $this->session->userdata('user_id');
            else if ($this->session->userdata('buss_user_id') != '')
                $user_id = $this->session->userdata('buss_user_id');
            else
                redirect('services#address12');

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
                {
                    $processFlag = false;                
                }
                else
                {
                    $processFlag = true;
                    $authTransactionId=$responce['transactionId'];
                }
            }
            
            if ($processFlag == false)
            {
                $data['p_error'] = $responce['errorData'];
                $this->load->view('services_view_html2', $data);
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
                
                                
                $category=$this->input->post('p_userCategory');
                if(in_array("other",$category))
                {
                   $newCatName=$this->input->post('p_otherCategory');
                   $insertCatInfo = $this->mdgeneraldml->insert('tbl_category', array('catName'=>$newCatName,'catImageName'=>'default_category_image.png','catCreatedOn'=>_getDateAndTime(),'catStatus'=>'Active'));  
                   $category[]=$insertCatInfo['last_insertId'];
                }  

                 $field_data = array('user_id' => $user_id,
                    'buss_name' => $this->input->post('p_buss_name'),
                    'buss_cont_name' => $this->input->post('p_buss_cont_name'),
                    'buss_address' => $this->input->post('p_buss_addr'),
                    'buss_addr_addon' => $addr_addon,
                    'buss_country' => $this->input->post('p_buss_country'),
                    'buss_state' => $this->input->post('p_buss_state'),
                    'buss_city' => $this->input->post('p_buss_city'),
                    'buss_zip_code' => $this->input->post('p_buss_zipcode'),
                    'buss_phone' => $this->input->post('p_buss_phone'),
                    'buss_fax' => $this->input->post('p_buss_fax'),
                    'buss_web_address' => $this->input->post('p_buss_web_addr'),
                    'buss_email' => $this->input->post('p_buss_email_addr'),
                    //'buss_category'=>$categoryId, 
                    'buss_license_num' => $this->input->post('p_buss_lice_num'),
                    'buss_social_media_channel_1' => $this->input->post('p_buss_sco_one'),
                    'buss_social_media_channel_2' => $this->input->post('p_buss_sco_two'),
                    'buss_social_media_channel_3' => $this->input->post('p_buss_sco_three'),
                    'buss_social_media_channel_4' => $this->input->post('p_buss_sco_four'),
                    'buss_media_copy' => $mediaCoppyFileNames,
                    'buss_license_docs' => $businessLicensesDocsNames,
                    'buss_logo' => $bussLogo,
                    'buss_comp_email'=>$this->input->post('addition_email'),
                    'buss_comp_quot'=>$comp_quot,
                    'mon_d_and_s'=>$mon_d_and_s,
                    'we_r_hir'=>$we_r_hir,
                    'bussCreatedOn' => _getDateAndTime(),
                    'bussUpdatedOn' => _getDateAndTime()
                );
                //  'buss_category'=>, 
                $data = $this->mdgeneraldml->insert('tbl_business_info', $field_data);
               
               $businessId=$data['last_insertId'];
                foreach($category as $key=>$categoryId){
                    if($categoryId!="other"){
                        $businessCat_data=array('buss_id'=>$businessId,'cat_id'=>$categoryId);
                        $this->mdgeneraldml->insert('tbl_business_categories', $businessCat_data);
                     }
                }
                
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
                    $this->session->set_userdata($newSessionData);
                    
                    //send subscription email to admin
                    $this->_sendSubscriptionMailToAdmin($user_id,$this->input->post('p_buss_name'),$this->input->post('p_promocode1'),$amount);
                    
                    $activationURL=$this->session->userdata('activation_url');
                    $url = site_url('dashboard/business_listing/view/'.$businessId);
                    
                    //$successString = 'You have registered to Word Of Mouth successfully! Please copy and paste this link \n'.$activationURL;
                    $successString = 'You have registered to Word Of Mouth successfully.';
                    echo "<script>alert('".$successString."');window.location.href='$url'</script>";
                }
            }
        }
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
    
    function getState($countryCode)
    {
        $get_user_state = "SELECT user_state FROM tbl_user WHERE tbl_user.user_id='" . $this->session->userdata('user_id') . "'";
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
        //echo '<pre>';print_r($_FILES['license_docs']); die;
        $files=$_FILES['license_docs'];
        //echo sizeof($files['name']);
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
        //echo '<pre>';print_r($_FILES['license_docs']); die;
        $files=$_FILES['p_license_docs'];
        //echo sizeof($files['name']);
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
    
     // Check Duplicate Username
    public function check_uname_dup()
    {
        if ($this->session->userdata('user_id') != '')
        {
            $str_id = $this->session->userdata('user_id');
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
        if ($this->session->userdata('user_id') != '')
        {
            $str_id = $this->session->userdata('user_id');
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
                $this->form_validation->set_message('checkForPremiumMediaCopy', 'You can only upload the image file.');
                return FALSE;
            }
        }
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
    
    function do_MultipleUpload($inputFileName="")
    {
       $this->load->library('upload'); // Load Library

       $this->upload->initialize(array( // takes an array of initialization options
           "upload_path" => "./Media_Copy/",
           "overwrite" => FALSE,
           "encrypt_name" => TRUE,
           "remove_spaces" => TRUE,
           "allowed_types" => "gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG",
           //"allowed_types" => "*",
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
           "encrypt_name" => TRUE,
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
    
    

     public function terms_and_condition() {
        $where = array('pageId' => '104');
        $data['pageInfo'] = $this->mdgeneraldml->select('*', 'tbl_static_pages', $where);
        //$data['pageInfo']= $this->WGModel->sqlQuery($sql);
        $this->load->view('includes/header');
        $this->load->view('terms_and_condition_view', $data);
        $this->load->view('includes/footer');
    }
    
    function download()
    {            
         /////Download Zip File 
        $file_path = "downloads_business_license/business_license_copy.pdf";
        header('Content-Type: application/pdf');
        header('Content-disposition: attachment; filename=business_license_copy.pdf');
        header('Content-Length: ' . filesize($file_path));
        readfile($file_path);
        //END
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
		if(!empty($hasPromoCode)) {
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