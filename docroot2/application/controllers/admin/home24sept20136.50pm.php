<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller 
{
	function __construct() 
	{	  
		parent::__construct();	
                _authenticateAdmin();
		$this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
		$this->load->library('session');	    //  This Library is use to When session get created.	
 	}
	public function index()
	{  
            $data['page_tab'] = 'dashboard';
            $this->load->view('admin/includes/header.php',$data);	
            $this->load->view('admin/home_view');
            $this->load->view('admin/includes/footer.php');
	}
	
}
