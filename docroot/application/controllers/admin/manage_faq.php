<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_faq extends CI_Controller {

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

    function index($sort_by='faqId', $sort_type='ASC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_faq/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;     
        //$where=array('sizeStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_faq', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,'');       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['faqList'] = $this->mdgeneraldml->select('*','tbl_faq' ,'', $order_by, $limit, $offset);
       

        $this->load->view('admin/includes/header');
        $this->load->view('admin/faq_vw',$data);
        $this->load->view('admin/includes/footer');
    }

    
    function add_new($sort_by='faqId', $sort_type='DESC', $offset=0)
    {
        $data=array('action'=>'New','faqId'=>'','faqTitle'=>'','faqDescription'=>'', 'btnName'=>'Save');
        
        $this->form_validation->set_rules('faqTitle', 'Question', 'trim|xss_clean|required|max_lenght[325]');        
        $this->form_validation->set_rules('faqDescription', 'Description', 'trim|xss_clean|required');
        
        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/faq_add_edit_vw');
            $this->load->view('admin/includes/footer');
        } else {
            
            $insertData = array(               
                'faqTitle' => $this->input->post('faqTitle'),
                'faqDescription' => $this->input->post('faqDescription'),               
                'faqCreatedOn' => _getDateAndTime(),
                'faqUpdatedOn' => _getDateAndTime()
            );
            $this->mdgeneraldml->insert('tbl_faq', $insertData);
            
            
            $this->session->set_flashdata('success','New size has been created successfully');
            redirect(ADMIN_FOLDER_NAME.'/manage_faq/add_new/' . $sort_by.'/'. $sort_type.'/'.$offset );
        }
    }
    
   function edit($faqId=NULL, $sort_by='faqId', $sort_type='DESC', $offset=0) {
       
       if (($faqId == NULL) or (!$this->admin_model->isRecordExist('tbl_faq', array('faqId' => $faqId)))) {
          $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
          redirect(ADMIN_FOLDER_NAME.'/manage_faq');
       }
       
        $sql="SELECT faqId,faqTitle,faqDescription FROM tbl_faq WHERE faqId=$faqId";
        $conInfo= $this->admin_model->sqlQuery($sql);        
        $data=array('action'=>'Edit','faqId'=>$conInfo[0]['faqId'],'faqTitle'=>$conInfo[0]['faqTitle'],'faqDescription'=>$conInfo[0]['faqDescription'],'btnName'=>'Save Changes');
        
        $this->form_validation->set_rules('faqTitle', 'Question', 'trim|xss_clean|required|max_lenght[325]');        
        $this->form_validation->set_rules('faqDescription', 'Description', 'trim|xss_clean|required');       
        

        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header.php', $data);
            $this->load->view('admin/faq_add_edit_vw');
            $this->load->view('admin/includes/footer.php');
        } else {
            $tableName = 'tbl_faq';
            $where = array('faqId' => $faqId);
            $updateData = array(               
                'faqTitle' => $this->input->post('faqTitle'),
                'faqDescription' => $this->input->post('faqDescription'),
                'faqUpdatedOn' => _getDateAndTime()
            );

            $this->mdgeneraldml->update($where, $tableName, $updateData);            
            $this->session->set_flashdata('success','Questions has been updated.');
            redirect(ADMIN_FOLDER_NAME.'/manage_faq/edit/'.$faqId.'/' . $sort_by.'/'. $sort_type.'/'.$offset );
        }
    }

    function delete($faqId=NULL, $sort_by='faqId', $sort_type='DESC', $offset=0) 
    {
        if (($faqId != NULL) && ($this->admin_model->isRecordExist('tbl_faq', array('faqId' => $faqId)))) {
            $tableName = 'tbl_faq';
            $where = array('faqId' => $faqId);            
            
            $this->mdgeneraldml->delete($where, $tableName);
            $this->session->set_flashdata('success', 'Size has been Deleted successfully.');
            
            redirect(ADMIN_FOLDER_NAME.'/manage_faq/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_faq');
        }
    }
    
    function delete_selected($sort_by='faqId', $sort_type='DESC', $offset=0)
    {        
        if(!empty($_POST['chkmsg']))
        {
            $faqIds=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlDelete("DELETE FROM tbl_faq WHERE faqId in($faqIds)");
            $this->session->set_flashdata('success', 'Selected questions has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/manage_faq/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single questions to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/manage_faq'); 
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */