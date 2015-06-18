<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends CI_Controller 
{
	public function __construct()
	{ 	parent::__construct();	                
		$this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
		$this->load->library('session');	    //  This Library is use to When session get created.	
	}
	public function index()
	{
		if($this->session->userdata('a_user_name') != '' || $this->session->userdata('a_id') != '' || $this->session->userdata('logged_in') != '')
		{		 
	 		redirect('admin/home');
		}
		else
		{
		   $this->load->view('admin/login_view'); // call the login_view.php files (View file)
		}
		 
	}
	public function login()
	{		  		
			$this->load->library('form_validation'); // Loading form_validation Library
			$this->load->helper('security'); 		//  Loading security Library
			 
 			$data=array('username'=>$this->security->xss_clean($this->input->post('username')),'password'=>$this->security->xss_clean($this->input->post('password')));
			
			$this->form_validation->set_rules('username', 'Username', 'required');
			$this->form_validation->set_rules('password', 'Password', 'required');
			
			if ($this->form_validation->run() == FALSE)
			{			
				 
				$this->load->view('admin/login_view',$data); // call the login_view.php files (View file)
			}
			else
			{
				$a_username = $this->security->xss_clean($this->input->post('username'));
				$a_password = $this->security->xss_clean($this->input->post('password'));
				
				$tbl = "tbl_admin_login"; // login table
				$cnd="a_user_name ='".$a_username."' and a_password ='".md5($a_password)."'";  
				// condition of username and password
				$result = $this->db_transact_model->get_single_record($tbl,$cnd);
				$record_count = count($result);
				
				if($record_count != 0)
				{					
					//if record_count grater then 0 then session will get created for thet user
					$admin_data = array('a_user_name' => $result[0]['a_user_name'],
					'a_email' => $result[0]['a_email'],'a_id'=> $result[0]['a_id'],'logged_in' => TRUE);
					$this->session->set_userdata($admin_data);
					$this->session->set_flashdata('item', 'You have Logged-in successfully.');
					redirect("admin/home"); // After successfully log-ed In will redirect to home controller
					
				}
				else
				{	
					$this->session->set_flashdata('item', 'Invalid username/Password.');
					redirect('admin/');				
				}		 
			}
								
		 		 
	} 
	public function logout()
	{ 	
		//unset session values 
		$admin_data = array('a_id' => '','a_user_name'=>'','a_email'=>'','logged_in' => FALSE);
		$this->session->unset_userdata($admin_data);		
		$this->session->sess_destroy();
		$this->session->set_flashdata('item', 'You are logged out successfully.');
		redirect('admin');
		 
	}
	public function forgot()
	{
		redirect('admin/welcome');		
	}		
	
}
