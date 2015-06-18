<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Setting extends CI_Controller {

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

    function index() 
    {   
        $setting = $this->mdgeneraldml->select('*','tbl_admin_setting');
        $data['setting'] = $setting[0];
        //echo '<pre>'; print_r($data['setting']);      
        $this->form_validation->set_rules('contactusAddress', 'Address', 'trim|required');        
        $this->form_validation->set_rules('contactusPhoneNumber', 'Phone number', 'trim|required');  
        $this->form_validation->set_rules('contactusFAXNumber', 'FAX number', 'trim|required');
        $this->form_validation->set_rules('contactusEmailAddress', 'Email', 'trim|required|valid_email');        
        $this->form_validation->set_rules('headerFooterPhoneNo', 'Header Footer Phone', 'trim|required');        

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/setting_contactus_vw',$data);
            $this->load->view('admin/includes/footer');
        }else
        {
           $tableName = 'tbl_admin_setting';
            $where = array('settingId' => $this->input->post('settingId'));
            $updateData = array( 
                'contactusAddress' => $this->input->post('contactusAddress'),
                'contactusPhoneNumber' => $this->input->post('contactusPhoneNumber'),
                'contactusFAXNumber'    => $this->input->post('contactusFAXNumber'),
                'contactusEmailAddress' => $this->input->post('contactusEmailAddress'),
                'headerFooterPhoneNo' => $this->input->post('headerFooterPhoneNo'),
                'settingUpdatedOn'=>_getDateAndTime()
            );
            $this->mdgeneraldml->update($where, $tableName, $updateData);            
            $this->session->set_flashdata('success','Contacus info has been updated successfully.');
            redirect(ADMIN_FOLDER_NAME.'/setting');
        }
    }  

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */