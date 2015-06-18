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

class Upgrade_subscription extends CI_Controller {

    function __construct()
    {
        parent::__construct();
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
    public function index($type='basic')
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
        
        $data['error'] = '';
        $data['p_error'] = '';
        if ($type == 'basic')
        {
           $this->_basic($data);
        }else
        {
           $this->_premium($data);
        }
    }
   
    //Step 2 of basic form
    function _basic($data)
    {
       $user_id=$this->session->userdata('user_id');
        
        $this->form_validation->set_rules('basicHiddenPaymentType', 'Hidden payment type', 'xss_clean|trim');
        $this->form_validation->set_rules('b_acc_type', 'Plan type', 'xss_clean|trim|required');  
       
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
            $this->load->view('dashboard/upgrade_subscription_vw', $data);
        }
        else
        {  
            $formaData['subscriptionInfo']=$this->__getBasicPromocodeCalculatedAmount();            
            $formaData['user_plan']=$this->input->post('b_acc_type');
            $formaData['currentSessionUSerId']=$user_id;
            $this->session->set_userdata('formData',$formaData);
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
                $responce = __authorisedPayment($infoArray);
                if ($responce['status'] == 'fail')
                    $processFlag = false;
                else
                    $processFlag = true;
            }
            
            if ($processFlag == false)
            {
                $data['error'] = $responce['errorData'];
                $this->load->view('dashboard/upgrade_subscription_vw', $data);
                //redirect(base_url() . 'services/show_err/');
            }
            else
            { 
               $tranId=(isset($responce['transactionId'])?$responce['transactionId']:'');
               $this->__saveFormData($tranId);
               $this->session->unset_userdata('formData');
                
               //send subscription email to admin
               $this->_sendSubscriptionMailToAdmin($user_id);
               $this->session->set_flashdata('success','Your subscription plan has been successfully updated.');
               redirect('dashboard/manage_subscription');
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
            return array('subscription_plan_id'=>$subscription_plan_id,'subscription_sub_plan_id'=>$subscription_sub_plan_id,'amount'=>$amount);
    }
    
    function __saveFormData($payPalTransactionId){
        
                $form=$this->session->userdata('formData');
                $subscription_plan_id       =$form['subscriptionInfo']['subscription_plan_id'];
                $subscription_sub_plan_id   =$form['subscriptionInfo']['subscription_sub_plan_id'];
                $amount                     =$form['subscriptionInfo']['amount'];
                $user_id                    =$form['currentSessionUSerId'];
                $user_plan                  =$form['user_plan'];
               
                //Update user account to bussiness user
                $user_info_data = array(
                    'user_plan' => $user_plan,
                    'user_type' => "buss_user"
                );
                $where = array('user_id' => $user_id);
                $user_info_updated = $this->mdgeneraldml->update($where, 'tbl_user', $user_info_data);
                
                
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
                if ($user_plan == 'bm')                
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+1 month");
                elseif($user_plan == 'ba')
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+12 month");
                elseif($user_plan == 'pm')                
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+1 month");
                else
                    $end_datemonth = strtotime(date("Y-m-d", strtotime($today)) . "+12 month");
                
                $end_date = date('Y-m-d', $end_datemonth);
                
                 $subscription_info = array(
                    'user_id' => $user_id,
                    'sub_plan_id' => $subscription_plan_id,
                    'sub_subplan_id' => $subscription_sub_plan_id,
                    'sub_start_date' => $today,
                    'sub_end_date' => $end_date
                );
                 
                $where=array('user_id'=>$user_id);
                if(_isRecordExist('tbl_user_subscription_plan_info',$where)){
                   $this->mdgeneraldml->update($where, 'tbl_user_subscription_plan_info', $subscription_info);
                }else{
                   $this->mdgeneraldml->insert('tbl_user_subscription_plan_info', $subscription_info);
                } 
    }

    
    //Step 2 of premium form
    function _premium($data)
    {  
       
        $this->form_validation->set_rules('p_acc_type1', 'Plan type', 'xss_clean|trim|required'); 
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
            $this->load->view('dashboard/upgrade_subscription_vw', $data);
        }
        else
        {
            
            $user_id = $this->session->userdata('user_id');
            $formaData['subscriptionInfo']=$this->__getPremiumPromocodeCalculatedAmount();            
            $formaData['user_plan']=$this->input->post('p_acc_type1');
            $formaData['currentSessionUSerId']=$user_id;
            $this->session->set_userdata('formData',$formaData);

            
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
                'amount' => $formaData['subscriptionInfo']['amount']
            );
            // print_r($infoArray);die;
            $authTransactionId="";
            $processFlag = true;
            //$responce = $this->__doCreditCardPayment($infoArray);
            $responce = __authorisedPayment($infoArray);
            if ($responce['status'] == 'fail')
                $processFlag = false;
            else
            {
                $processFlag = true;
                $authTransactionId=$responce['transactionId'];
            }
            
            if ($processFlag == false)
            {
                $data['p_error'] = $responce['errorData'];
                $this->load->view('dashboard/upgrade_subscription_vw', $data);                
            }
            else
            {
                
                $tranId=$authTransactionId;
               $this->__saveFormData($tranId);
               $this->session->unset_userdata('formData');
               
               //send subscription email to admin
               $this->_sendSubscriptionMailToAdmin($user_id);
                    
               $this->session->set_flashdata('success','Your subscription plan has been successfully updated.');
               redirect('dashboard/manage_subscription');
            }
        }
    }
    
    function __getPremiumPromocodeCalculatedAmount(){
        // echo $user_id; die;
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
            return array('subscription_plan_id'=>$subscription_plan_id,'subscription_sub_plan_id'=>$subscription_sub_plan_id,'amount'=>$amount);
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
     
   
     public function terms_and_condition() {
        $where = array('pageId' => '104');
        $data['pageInfo'] = $this->mdgeneraldml->select('*', 'tbl_static_pages', $where);
        //$data['pageInfo']= $this->WGModel->sqlQuery($sql);
        $this->load->view('includes/header');
        $this->load->view('terms_and_condition_view', $data);
        $this->load->view('includes/footer');
    }
    
    function _sendSubscriptionMailToAdmin($userId){
        //send email to admin regarding subscription purchased by user.
        $where_Id=array('emailId'=>'119');
        $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);

        $userInfo=$this->mdgeneraldml->select('user_fname,user_lname,user_plan','tbl_email_contents',array('user_id'=>$userId));
        $userName=$userInfo[0]['user_fname'].' '.$userInfo[0]['user_lname'];
        $userPlan=$userInfo[0]['user_plan'];//plan can be bm,ba,pm and pa

        $planArray=array('bm'=>'Monthly Basic','ba'=>'Annually Basic','pm'=>'Monthly Premium','pa'=>'Annually Premium');
        $packageName=$planArray[$userPlan];

        $emilTemplet=$emailinfo[0]['emailBody'];
        $emilTempletSubject=$emailinfo[0]['emailSubject'];

        $emailBody=str_replace ("[[USER_FULL_NAME]]", $userName, $emailBody);
        $emailBody=str_replace ("[[PACKAGE_NAME]]", $packageName, $emailBody);
        //send email to admin
        @send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody);
    }
    
}

/* End of file services.php */
/* Location: ./application/controllers/services.php */