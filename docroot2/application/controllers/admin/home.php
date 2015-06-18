<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller 
{
	function __construct() 
	{	  
		parent::__construct();	
                _authenticateAdmin();
		$this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
		$this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model		
		$this->load->library('session');	    //  This Library is use to When session get created.	
 	}
	public function index()
	{
            if (($this->session->userdata('adm_id') == ""))
            {
                redirect("admin/welcome/login"); 
            }
            else
            {
                $data['page_tab'] = 'dashboard';
                $data['pageInfo']=$this->mdgeneraldml->select('pageHeading,pageContent','tbl_static_pages',array('pageId'=>'102'));
                $this->load->view('admin/includes/header.php',$data);	
                $this->load->view('admin/home_view');
                $this->load->view('admin/includes/footer.php');
            }
        }
        
        public function sub_admin_home()
        {
            if (($this->session->userdata('sub_adm_id') == ""))
            {
                redirect("admin/welcome/login"); 
            }
            else
            {
                $data['page_tab'] = 'Sub-Admin dashboard';
                $this->load->view('admin/includes/sub_admin_header',$data);	
                $this->load->view('admin/home_view');
                $this->load->view('admin/includes/footer');            
            }
        }
        
        public function sales_mgr_home()
        {
            if (($this->session->userdata('sa_mg_adm_id') == ""))
            {
                redirect("admin/welcome/login"); 
            }
            else
            {
                $data['page_tab'] = 'Sales Manager dashboard';
                $this->load->view('admin/includes/sales_mgr_header',$data);	
                $this->load->view('admin/home_view');
                $this->load->view('admin/includes/footer');            
            }
        }
        
        public function sales_rep_home()
        {
            if (($this->session->userdata('sa_rp_adm_id') == ""))
            {
                redirect("admin/welcome/login"); 
            }
            else
            {
                $data['page_tab'] = 'Sales Representative dashboard';
                $this->load->view('admin/includes/sales_rep_header',$data);	
                $this->load->view('admin/home_view');
                $this->load->view('admin/includes/footer');            
            }
        }
	
}
