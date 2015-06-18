<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {
	
    function __construct() {
        parent::__construct();   
        $this->load->model('mdgeneraldml');
        $this->load->library('form_validation');
		//$this->load->helper('captcha');
		$this->load->helper(array('form', 'url','captcha'));
        $this->form_validation->set_error_delimiters('<span style="float:left;color: #EE0101 !important;">', '</span>');        
    }
    
    function index()
    {
        //Get Settings of Contact Us   

        $setting = $this->mdgeneraldml->select('contactusAddress,contactusPhoneNumber,contactusEmailAddress,contactusFAXNumber','tbl_admin_setting');       
        $data['setting'] = $setting[0];
        
		$this->load->helper('recaptcha_helper');
		$captcha_arr = array();
		$publickey = "6LcXzcgSAAAAAEtPB9l9RrHg7BrC-FTa6UzjuuND"; // you got this from the signup page	
		$privatekey = "6LcXzcgSAAAAACxyujcV7sn8w7NmvN6KUYnLDJKV";
		$captcha_arr = recaptcha_get_html($publickey);		
		$data['cap_img'] = $captcha_arr;
//print_r($data['cap_img']); 
		$data['recaptcha_response_field'] = '';
		$recaptcha_response_field="";
        $error ='';
		
		$tbl = 'tbl_contact_reasons';
        $order_by = array('colname' => 'reason_id', 'type' => 'ASC');
        $data['reasonList'] = $this->mdgeneraldml->select('*', $tbl, $where='', $order_by);
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
			
        $this->form_validation->set_rules('cnt_fname', 'First Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('cnt_lname', 'Last Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('cnt_email', 'Email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('cnt_msg', 'Message', 'xss_clean|trim|required');
		$this->form_validation->set_rules('cnt_reason', 'Reason', 'required');
        
         if ($this->form_validation->run() == FALSE or $capResult)
        { 
			$data['captcha_error'] = 'Invalid Captcha';
			
			  
            $this->load->view('includes/header');
            $this->load->view('contact_us_view',$data);
            $this->load->view('includes/footer');
        }else{
           // echo '<pre>'; print_r($_POST);             die;
            $cnt_fname=$this->input->post('cnt_fname');
            $cnt_lname=$this->input->post('cnt_lname');
            $cnt_email=$this->input->post('cnt_email');
            $cnt_reason=$this->input->post('cnt_reason');
            $cnt_name =$cnt_fname.$cnt_lname;
            $cnt_msg=$this->input->post('cnt_msg');
            if($this->session->userdata('user_id')!='')
                     $userId=$this->session->userdata('user_id');
            else
                $userId = 0;
            
            //get reason                     
            $reasonInfo = $this->mdgeneraldml->select('reason_name', 'tbl_contact_reasons', array('reason_id'=>$cnt_reason));
            $reason=$reasonInfo[0]['reason_name'];
            
            //get email body
           $where=array('emailId'=>'111');
           $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where);
           
           $emilTemplet=$emailinfo[0]['emailBody'];
           $emilTempletSubject=$emailinfo[0]['emailSubject'];
           
           $emailBody=str_replace ("[[USER_FULL_NAME]]", $cnt_name, $emilTemplet);
           $emailBody=str_replace ("[[REASON]]", $reason, $emailBody);
           $emailBody=str_replace ("[[MESSAGE]]", $cnt_msg, $emailBody);
           //send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody);

	   send_bcc_email($cnt_email,ADMIN_EMAIL,$emilTempletSubject,$emailBody); 
	       
            
            $insertData=array('user_id'=> $userId,
                'cnt_fname'=>$cnt_fname,'cnt_lname'=>$cnt_lname,'cnt_email'=>$cnt_email,
               'cnt_msg'=>$cnt_msg,'cnt_date'=>_getDateAndTime(),'cnt_reason'=>$cnt_reason);
            
            $this->mdgeneraldml->insert('contact_us_as_per_design',$insertData);

            $this->session->set_flashdata('success','Thank you for Contacting Us at WOM Referral. We will be in touch within 24 Hours!');
            
            
            redirect('contact_us');
        }     
        }   
		else
		{
			$this->load->view('includes/header');
            $this->load->view('contact_us_view',$data);
            $this->load->view('includes/footer');
		
		}
    }
	function success()
	{
		echo "success";
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */