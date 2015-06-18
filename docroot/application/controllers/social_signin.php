<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Social_signin extends CI_Controller {
	
    function __construct() {
        parent::__construct();          
        $this->load->model('mdgeneraldml');
        $this->load->model('website_general_model','WGModel');  
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }
    
    function index(){
        $this->session->set_flashdata('error','Sorry! You can not access this link directly.');
        redirect('message');
    }
    
    function register(){
        
        if($this->session->userdata('social_name')==""){
            $this->session->set_flashdata('error','Sorry! You can not access this link directly.');
            redirect('message');
        }
        
        $name=$this->session->userdata('social_name');
        $nameSplit=explode(' ',$name);
        
         $data = array(
            'user_name' => $this->session->userdata('social_username'),
            'user_fname' => (isset($nameSplit[0])?$nameSplit[0]:''),
            'user_lname' => (isset($nameSplit[1])?$nameSplit[1]:''),            
            'user_city' => $this->session->userdata('social_city'),
            'user_email'=>''
        );
         
        $this->form_validation->set_rules('user_fname', 'First name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('user_lname', 'Last name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('user_name', 'Username', 'xss_clean|trim|required|is_unique[tbl_user.user_name]');
        $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
        $this->form_validation->set_rules('user_password', 'Password', 'xss_clean|trim|required|alpha_numeric|min_length[6]|max_length[12]|matches[c_password]');
        $this->form_validation->set_rules('c_password', 'Confirm Password', 'xss_clean|trim|required|matches[user_password]');        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('includes/header');
            $this->load->view('social_media_registration_vw', $data);
            $this->load->view('includes/footer');
        }
        else
        {            
            $insertData = array(
                'user_fname' => $this->input->post('user_fname'),
                'user_lname' => $this->input->post('user_lname'),                
                'user_email' => $this->input->post('user_email'),                
                'user_password' => md5($this->input->post('user_password')),
                'user_name' => $this->input->post('user_name'),
                'user_city' => $data['user_city'],
                'user_type' => "site_user",
                'user_acc_status' => "I",
                'act_link_click_status' => 1,
                'user_update_date' => _getDate(),
                'user_registered_date' => _getDate(),
            );
            //echo '<pre>'; print_r($field_data);
            $InsertInfo = $this->mdgeneraldml->insert('tbl_user', $insertData);
            $lastInsertId = $InsertInfo['last_insertId'];
            
            
            $fullName = $insertData['user_fname'].' '.$insertData['user_lname'];
            $email = $this->input->post('user_email');
            $password = $this->input->post('user_password');
            $encryption_str = $insertData['user_name'] . "/" . $lastInsertId;
            $enc_text = base64_encode($encryption_str);
            $activation_url=base_url() . "user/activated_user/" . $enc_text; 

            $where_Id=array('emailId'=>'104');
            $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);

            $emilTemplet=$emailinfo[0]['emailBody'];
            $emilTempletSubject=$emailinfo[0]['emailSubject'];

            $emailBody=str_replace ("[[USER_FULL_NAME]]", $fullName, $emilTemplet);
            $emailBody=str_replace ("[[LINK]]", $activation_url, $emailBody);
            @send_email($email,$emilTempletSubject,$emailBody); 

            //destroy session
            $this->session->unset_userdata('social_username');
            $this->session->unset_userdata('social_name');
            $this->session->unset_userdata('social_city');
        
            $this->session->set_flashdata('success',"You have successfully registered to the site. Please check your email for activation link. (Activation Link: $activation_url)");
            redirect('message');
        }
         
    }
    
}    