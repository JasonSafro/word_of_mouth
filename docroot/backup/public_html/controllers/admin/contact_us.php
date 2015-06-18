<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Contact_us extends CI_Controller {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();        
        _authenticateAdmin();        
        $this->load->model('admin_model');        
        $this->load->model('mdgeneraldml');        
        $this->load->library('pagination');
         $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='cnt_id', $sort_type='DESC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/contact_us/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT; ;
		
		       
        $data = _getPagingVaiables('contact_us_as_per_design', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type);       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
		$tbl = "contact_us_as_per_design,tbl_contact_reasons" ;
		$where = "contact_us_as_per_design.cnt_reason = tbl_contact_reasons.reason_id";    
        $data['listContactus'] = $this->mdgeneraldml->select('*',$tbl ,$where, $order_by, $limit, $offset);
       

        $this->load->view('admin/includes/header');
        $this->load->view('admin/contactus_list_vw',$data);
        $this->load->view('admin/includes/footer');
    }
       
     function delete_contact($cnt_id)
    {
        if (($cnt_id != NULL) && ($this->admin_model->isRecordExist('contact_us_as_per_design', array('cnt_id' => $cnt_id)))) 		{         
            $this->admin_model->sqlDelete("DELETE FROM contact_us_as_per_design WHERE cnt_id=$cnt_id");
            $this->session->set_flashdata('success', 'Contact has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME.'/contact_us/');
        } else {
            $this->session->set_flashdata('error', '!! Contact not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/contact_us/');
        }
    }
    
    

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */