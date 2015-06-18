<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_slider extends CI_Controller {

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

    function index($sort_by='sldrId', $sort_type='ASC', $offset=0) 
    {               
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_slider/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;     
        //$where=array('sizeStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_slider_contents', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,'');       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['sliderList'] = $this->mdgeneraldml->select('*','tbl_slider_contents' ,'', $order_by, $limit, $offset);
       

        $this->load->view('admin/includes/header');
        $this->load->view('admin/slider_vw',$data);
        $this->load->view('admin/includes/footer');
    }

    
    function add_new($sort_by='sldrId', $sort_type='DESC', $offset=0)
    {
        $data=array('action'=>'New','sldrId'=>'','sldrImage'=>'','sldrTitle'=>'','sldrSubTitle'=>'','sldrDescription'=>'', 'btnName'=>'Save','error'=>'');
        
        $this->form_validation->set_rules('sldrImage', 'Image', '');        
        $this->form_validation->set_rules('sldrTitle', 'Title', 'required|max_length[20]');       
        $this->form_validation->set_rules('sldrSubTitle', 'Sub title', 'required|max_length[150]');
        
        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/slider_add_edit_vw');
            $this->load->view('admin/includes/footer');
        } else {
            
            $re['upload_response'] = $this->do_upload_new($maxHeight='350',$maxWidth='520');
             if (isset($re['upload_response']['error'])) {
                        $data['error'] = $re['upload_response']['error'];
                        $data['offset'] = $offset;
                        $data['sort_by'] = $sort_by;
                        $data['sort_type'] = $sort_type;
                        $this->load->view('admin/includes/header.php');
                        $this->load->view('admin/slider_add_edit_vw', $data);
                        $this->load->view('admin/includes/footer.php');
                    }else{
            
                    $insertData = array(               
                        'sldrImage' => $re['upload_response']['resized_imageName'],
                        'sldrTitle' => $this->input->post('sldrTitle'),
                        'sldrSubTitle' => $this->input->post('sldrSubTitle'),              
                        'sldrCreatedOn' => _getDateAndTime(),
                        'sldrUpdatedOn' => _getDateAndTime()
                    );
                    $this->mdgeneraldml->insert('tbl_slider_contents', $insertData);

                    $this->session->set_flashdata('success','New size has been created successfully');
                    redirect(ADMIN_FOLDER_NAME.'/manage_slider/add_new/' . $sort_by.'/'. $sort_type.'/'.$offset );
            
            }
        }
    }
    
   function edit($sldrId=NULL, $sort_by='sldrId', $sort_type='DESC', $offset=0) {
       
       if (($sldrId == NULL) or (!$this->admin_model->isRecordExist('tbl_slider_contents', array('sldrId' => $sldrId)))) {
          $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
          redirect(ADMIN_FOLDER_NAME.'/manage_slider');
       }
       
        $sql="SELECT sldrId,sldrImage,sldrTitle,sldrSubTitle,sldrDescription FROM tbl_slider_contents WHERE sldrId=$sldrId";
        $sliderInfo= $this->admin_model->sqlQuery($sql);        
        $data=array('action'=>'Edit','sldrId'=>$sliderInfo[0]['sldrId'],'sldrImage'=>$sliderInfo[0]['sldrImage'],
                    'sldrTitle'=>$sliderInfo[0]['sldrTitle'],'sldrSubTitle'=>$sliderInfo[0]['sldrSubTitle'],
                    'sldrDescription'=>$sliderInfo[0]['sldrDescription'],'btnName'=>'Save Changes','error'=>'');
        
        //$this->form_validation->set_rules('sldrImage', 'Image', '');        
        $this->form_validation->set_rules('sldrTitle', 'Title', 'xss_clean|required|max_length[20]');       
        $this->form_validation->set_rules('sldrSubTitle', 'Sub title', 'xss_clean|required|max_length[150]');       
       

        if ($this->form_validation->run() == FALSE) {
            //echo '<pre>'; print_r($_FILES); die;
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header.php', $data);
            $this->load->view('admin/slider_add_edit_vw');
            $this->load->view('admin/includes/footer.php');
        } else {
            
            $flag=true;
            if ($_FILES['sldrImage']['name'] != "") {
                //echo $_FILES['sldrImage']['name']; die;
            $re['upload_response'] = $this->do_upload_new($maxHeight='350',$maxWidth='520');
             if (isset($re['upload_response']['error'])) {
                        $data['error'] = $re['upload_response']['error'];
                        $data['offset'] = $offset;
                        $data['sort_by'] = $sort_by;
                        $data['sort_type'] = $sort_type;
                        $flag=false;
                        $this->load->view('admin/includes/header.php');
                        $this->load->view('admin/slider_add_edit_vw', $data);
                        $this->load->view('admin/includes/footer.php');
                    }
            }
            
            if($flag==true)
            {
                $tableName = 'tbl_slider_contents';
                $where = array('sldrId' => $sldrId);
                $updateData = array(  
                    'sldrTitle' => $this->input->post('sldrTitle'),
                    'sldrSubTitle' => $this->input->post('sldrSubTitle'),
                    'sldrUpdatedOn' => _getDateAndTime()
                );

                  if (isset($re['upload_response']['resized_imageName']))
                  {
                      //unlink previous image
                      $path= BASEPATH.'../'.'sitedata/slider_images/'.$data['sldrImage'];                     
                      @unlink($path);
                      $updateData['sldrImage'] = $re['upload_response']['resized_imageName'];
                  }
                  //echo BASEPATH.'<br>'.$path; die;  
                $this->mdgeneraldml->update($where, $tableName, $updateData);            
                $this->session->set_flashdata('success','Slider has been updated.');
                redirect(ADMIN_FOLDER_NAME.'/manage_slider/edit/'.$sldrId.'/' . $sort_by.'/'. $sort_type.'/'.$offset );
            }    
                       

        }
    }

    
     function do_upload_new($maxHeight='350',$maxWidth='520') {        
        $config['upload_path'] = './sitedata/slider_images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';// '*'
        //$config['max_size'] = '2048';      
        $config['max_height'] = $maxHeight;
        $config['max_width'] = $maxWidth;        
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
       
        $this->load->library('upload',$config);
        
        if (!$this->upload->do_upload('sldrImage')) {
            $error = array('error' => $this->upload->display_errors());
           // echo '<pre>'; print_r($error); die;
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return array('resized_imageName' => $data['upload_data']['file_name']);           
        }
    }
    
    function delete($sldrId=NULL, $sort_by='sldrId', $sort_type='DESC', $offset=0) 
    {
        if (($sldrId != NULL) && ($this->admin_model->isRecordExist('tbl_slider_contents', array('sldrId' => $sldrId)))) {
            $tableName = 'tbl_slider_contents';
            $where = array('sldrId' => $sldrId);            
            
            $this->mdgeneraldml->delete($where, $tableName);
            $this->session->set_flashdata('success', 'Slider has been Deleted successfully.');
            
            redirect(ADMIN_FOLDER_NAME.'/manage_slider/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! Record not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_slider');
        }
    }
    
    function delete_selected($sort_by='sldrId', $sort_type='DESC', $offset=0)
    {        
        if(!empty($_POST['chkmsg']))
        {
            $sldrIds=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlDelete("DELETE FROM tbl_slider_contents WHERE sldrId in($sldrIds)");
            $this->session->set_flashdata('success', 'Selected slider has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/manage_slider/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single slider to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/manage_slider'); 
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */