<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Email_Content extends CI_Controller {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();        
        _authenticateAdmin();        
        $this->load->model('admin_model');        
        $this->load->model('mdgeneraldml');
        $this->load->helper('ckeditor_helper');
        $this->load->library('pagination');
         $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='emailId', $sort_type='ASC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/email_content/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;        
        $data = _getPagingVaiables('tbl_email_contents', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, '');       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['emailContent'] = $this->mdgeneraldml->select('*','tbl_email_contents' , '', $order_by, $limit, $offset);
        
        $this->load->view('admin/includes/header.php');
        $this->load->view('admin/email_content_view',$data);
        $this->load->view('admin/includes/footer.php');
    }

   function edit($emailId=NULL, $sort_by='emailId', $sort_type='DESC', $offset=0) {
       
       if (($emailId == NULL) or (!$this->admin_model->isRecordExist('tbl_email_contents', array('emailId' => $emailId)))) {
          $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
          redirect(ADMIN_FOLDER_NAME.'/email_content');
       }
       
        $sql="SELECT emailId,emailName,emailSubject,emailBody FROM tbl_email_contents WHERE emailId=$emailId";
        $data['content']= $this->admin_model->sqlQuery($sql);
        //sqlQuery
                
        $this->form_validation->set_rules('emailSubject', 'Email Subject', 'xss_clean|trim|required');
        $this->form_validation->set_rules('emailBody', 'Email Body', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/edit_email_content_view');
            $this->load->view('admin/includes/footer');
        } else {
            $tableName = 'tbl_email_contents';
            $where = array('emailId' => $emailId);
            $updateData = array(               
                'emailSubject' => $this->input->post('emailSubject'),
                'emailBody' => $this->input->post('emailBody'),
                'emailUpdatedOn' => _getDateAndTime()
            );

            $this->mdgeneraldml->update($where, $tableName, $updateData);
            $page_name = $this->input->post('emailName');
            $this->session->set_flashdata('success', $page_name . 'Contents has been successfully updated.');
            redirect(ADMIN_FOLDER_NAME.'/email_content/edit/' . $emailId);
        }
    }

   

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */