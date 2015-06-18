<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Static_Pages extends CI_Controller {

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

    function index($sort_by='pageId', $sort_type='ASC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/static_pages/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;        
        $data = _getPagingVaiables('tbl_static_pages', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, '');       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['contentPages'] = $this->mdgeneraldml->select('*','tbl_static_pages' , '', $order_by, $limit, $offset);
       

        $this->load->view('admin/includes/header.php');
        $this->load->view('admin/static_pages_view',$data);
        $this->load->view('admin/includes/footer.php');
    }

   function edit($pageId=NULL, $sort_by='pageId', $sort_type='DESC', $offset=0) {
       
       if (($pageId == NULL) or (!$this->admin_model->isRecordExist('tbl_static_pages', array('pageId' => $pageId)))) {
          $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
          redirect(ADMIN_FOLDER_NAME.'/static_pages');
       }
       
        $sql="SELECT pageId,pageName,pageMetaTitle,pageMetaDescription,pageMetaKeywords,pageHeading,pageContent FROM tbl_static_pages WHERE pageId=$pageId";
        $data['content']= $this->admin_model->sqlQuery($sql);
        //sqlQuery
                        
        $this->form_validation->set_rules('pageMetaTitle', 'Meta Title', 'trim|xss_clean|required');
        $this->form_validation->set_rules('pageMetaDescription', 'Meta Description', 'trim|xss_clean');
        $this->form_validation->set_rules('pageMetaKeywords', 'Meta Keywords', 'trim|xss_clean');
        $this->form_validation->set_rules('pageHeading', 'Page Heading', 'trim|xss_clean|required');
        $this->form_validation->set_rules('pageContent', 'Page Content', 'trim|required');

        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header.php', $data);
            $this->load->view('admin/edit_static_page');
            $this->load->view('admin/includes/footer.php');
        } else {
            $tableName = 'tbl_static_pages';
            $where = array('pageId' => $pageId);
            $updateData = array(               
                'pageMetaTitle' => str_replace('"', " ",$this->input->post('pageMetaTitle')),
                'pageMetaDescription' => str_replace('"', " ",$this->input->post('pageMetaDescription')),
                'pageMetaKeywords' => str_replace('"', " ",$this->input->post('pageMetaKeywords')),
                'pageHeading' => $this->input->post('pageHeading'),
                'pageContent' => $this->input->post('pageContent'),
                'pageUpdatedOn' => _getDateAndTime()
            );

            $this->mdgeneraldml->update($where, $tableName, $updateData);
            $page_name = $this->input->post('pageName');
            $this->session->set_flashdata('success', $page_name . 'Contents has been successfully updated.');
            redirect(ADMIN_FOLDER_NAME.'/static_pages/edit/' . $pageId);
        }
    }

   

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */