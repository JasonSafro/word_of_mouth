<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends CI_Controller {

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
        $this->load->library('upload');
    }

    function index($sort_by='catId', $sort_type='ASC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/category/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;     
        $where=array('catStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_category', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where);       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['listCategory'] = $this->mdgeneraldml->select('*','tbl_category' ,$where, $order_by, $limit, $offset);
       

        $this->load->view('admin/includes/header.php');
        $this->load->view('admin/category_vw',$data);
        $this->load->view('admin/includes/footer.php');
    }

    
    function add_new($sort_by='catId', $sort_type='DESC', $offset=0)
    {
        $data=array('action'=>'New','catId'=>'','catName'=>'','catDescription'=>'','catImageName'=>'','btnName'=>'Save');
        
        $this->form_validation->set_rules('catName', 'Category Name', 'trim|xss_clean|required|max_lenght[30]'); 
        $this->form_validation->set_rules('catDescription', 'Category Description', 'trim|xss_clean|max_lenght[50]');

        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header.php', $data);
            $this->load->view('admin/category_add_edit_vw');
            $this->load->view('admin/includes/footer.php');
        } else { 
                                    
                                      $cat_id=$this->input->post('catName');
                                      mkdir('category_images/' . $cat_id, 0777, true);
                                      
                                      
                                    
                                $config['upload_path'] = 'category_images/'. $cat_id;
		$config['allowed_types'] = 'png';
		$config['max_size']	= '1000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);
		//$data = array('upload_data' => $this->upload->data());
                
                
                if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
                                                print_r($error); die;
			
		}
		else
		{
			$data = array('upload_data' => $this->upload->data());
                                                   print_r($data);die;
			
		}
                
                
                
               // print_r($data);die;

			
		
            
            $insertData = array(               
                'catName' => str_replace('"', " ",$this->input->post('catName')),
                'catDescription' =>$this->input->post('catDescription'),
                'catCreatedOn' => _getDateAndTime(),
                'catUpdatedOn' => _getDateAndTime()
            );
            $this->mdgeneraldml->insert('tbl_category', $insertData);
            
            
            $this->session->set_flashdata('success','New category has been created successfully');
            redirect(ADMIN_FOLDER_NAME.'/category/add_new/' . $sort_by.'/'. $sort_type.'/'.$offset );
        }
    }
    
   function edit($catId=NULL, $sort_by='catId', $sort_type='DESC', $offset=0) {
       
       if (($catId == NULL) or (!$this->admin_model->isRecordExist('tbl_category', array('catId' => $catId)))) {
          $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
          redirect(ADMIN_FOLDER_NAME.'/category');
       }
       
        $sql="SELECT catId,catName,catDescription FROM tbl_category WHERE catId=$catId";
        $conInfo= $this->admin_model->sqlQuery($sql);        
        $data=array('action'=>'Edit','catId'=>$conInfo[0]['catId'],'catName'=>$conInfo[0]['catName'],'catDescription'=>$conInfo[0]['catDescription'],'btnName'=>'Save Changes');
        
        $this->form_validation->set_rules('catName', 'Category Name', 'trim|xss_clean|required|max_lenght[30]'); 
        $this->form_validation->set_rules('catDescription', 'Category Description', 'trim|xss_clean|max_lenght[50]');

        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/category_add_edit_vw');
            $this->load->view('admin/includes/footer.php');
        } else {
            $tableName = 'tbl_category';
            $where = array('catId' => $catId);
            $updateData = array(               
                'catName' => str_replace('"', " ",$this->input->post('catName')),
                'catDescription' =>$this->input->post('catDescription'),
                'catCreatedOn' => _getDateAndTime(),
                'catUpdatedOn' => _getDateAndTime()
            );

            $this->mdgeneraldml->update($where, $tableName, $updateData);            
            $this->session->set_flashdata('success','Category has been updated.');
            redirect(ADMIN_FOLDER_NAME.'/category/edit/'.$catId.'/' . $sort_by.'/'. $sort_type.'/'.$offset );
        }
    }

    function delete($catId=NULL, $sort_by='catId', $sort_type='DESC', $offset=0) 
    {
        if (($catId != NULL) && ($this->admin_model->isRecordExist('tbl_category', array('catId' => $catId)))) {
            $tableName = 'tbl_category';
            $where = array('catId' => $catId);
            $updateData = array(               
                'catName' => $this->input->post('catName'),               
                'catStatus' => 'Deleted',
                'catUpdatedOn' => _getDateAndTime(),
            );
            
            $this->mdgeneraldml->update($where, $tableName, $updateData);     
            $this->session->set_flashdata('success', 'User has been Deleted successfully.');
            
            redirect(ADMIN_FOLDER_NAME.'/category/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/category');
        }
    }
    
     function delete_selected($sort_by='catId', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST['chkmsg']))
        {
            $catIds=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlUpdate("Update tbl_category SET catStatus='Deleted',catUpdatedOn='"._getDateAndTime()."' WHERE catId in($catIds)");
            $this->session->set_flashdata('success', 'Category has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/category/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single category to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/category'); 
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */