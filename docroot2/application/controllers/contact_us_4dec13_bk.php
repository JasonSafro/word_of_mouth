<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_us extends CI_Controller {
	
    function __construct() {
        parent::__construct();   
        $this->load->model('mdgeneraldml');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span style="float:left;color: #EE0101 !important;">', '</span>');        
    }
    
    function index()
    {
        //Get Settings of Contact Us       
        $setting = $this->mdgeneraldml->select('contactusAddress,contactusPhoneNumber,contactusEmailAddress,contactusFAXNumber','tbl_admin_setting');       
        $data['setting'] = $setting[0];
        
        
        $this->form_validation->set_rules('cnt_fname', 'First Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('cnt_lname', 'Last Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('cnt_email', 'Email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('cnt_msg', 'Message', 'xss_clean|trim|required');
        
         if ($this->form_validation->run() == FALSE)
        { 
           $this->load->view('includes/header');
            $this->load->view('contact_us_view',$data);
            $this->load->view('includes/footer');
        }else{
           // echo '<pre>'; print_r($_POST);             die;
            $cnt_fname=$this->input->post('cnt_fname');
            $cnt_lname=$this->input->post('cnt_lname');
            $cnt_email=$this->input->post('cnt_email');
            $subject="Contact";
            $cnt_msg=$this->input->post('cnt_msg');
            
            
            send_bcc_email($cnt_email,ADMIN_EMAIL,$subject,$cnt_msg);
            
            $insertData=array(
                'cnt_fname'=>$cnt_fname,'cnt_lname'=>$cnt_lname,'cnt_email'=>$cnt_email,
               'cnt_msg'=>$cnt_msg,'cnt_date'=>_getDateAndTime());
            
            $this->mdgeneraldml->insert('contact_us_as_per_design',$insertData);

            $this->session->set_flashdata('success','Yor contact us request has been send to the WOM support team.');
            
            
            redirect('contact_us');
        }     
            
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */