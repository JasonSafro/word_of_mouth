<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_footer_videos extends CI_Controller {

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

    function index($sort_by='fvId', $sort_type='ASC', $offset=0) 
    {          
     
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_footer_videos/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;     
        //$where=array('sizeStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_footer_videos', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,'');       
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['sliderList'] = $this->mdgeneraldml->select('*','tbl_footer_videos' ,'', $order_by, $limit, $offset);
       

        $this->load->view('admin/includes/header');
        $this->load->view('admin/footer_video_vw',$data);
        $this->load->view('admin/includes/footer');
    }

    
    function add_new($sort_by='fvId', $sort_type='DESC', $offset=0)
    {
        $data=array('action'=>'New','fvPageName'=>'','fvId'=>'','fvImage'=>'','fvTitle'=>'','fvYouTubeVideoLink'=>'','fvDescription'=>'','fvReadMoreLink'=>'', 'btnName'=>'Save','error'=>'');
        
        $this->form_validation->set_rules('fvPageName', 'Page', 'required|callback_checkCount');        
        $this->form_validation->set_rules('fvImage', 'Image', '');        
        $this->form_validation->set_rules('fvTitle', 'Title', 'required|max_length[50]');       
        $this->form_validation->set_rules('fvYouTubeVideoLink', 'YouTube video link', 'required|max_length[150]');
        $this->form_validation->set_rules('fvDescription', 'Description', 'required|max_length[300]');
        $this->form_validation->set_rules('fvReadMoreLink', 'Read more link', 'required');
        
        
        if ($this->form_validation->run() == FALSE) {
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/footer_video_add_edit_vw');
            $this->load->view('admin/includes/footer');
        } else {
            
            $re['upload_response'] = $this->do_upload_new($maxHeight='75',$maxWidth='125');
             if (isset($re['upload_response']['error'])) {
                        $data['error'] = $re['upload_response']['error'];
                        $data['offset'] = $offset;
                        $data['sort_by'] = $sort_by;
                        $data['sort_type'] = $sort_type;
                        $this->load->view('admin/includes/header.php');
                        $this->load->view('admin/footer_video_add_edit_vw', $data);
                        $this->load->view('admin/includes/footer.php');
                    }else{
            
                    $insertData = array(               
                        'fvPageName' => $this->input->post('fvPageName'),
                        'fvImage' => $re['upload_response']['resized_imageName'],
                        'fvTitle' => $this->input->post('fvTitle'),                        
                        'fvYouTubeVideoLink' => $this->input->post('fvYouTubeVideoLink'),              
                        'fvDescription' => $this->input->post('fvDescription'),              
                        'fvReadMoreLink' => $this->input->post('fvReadMoreLink'),              
                        'fvCreatedOn' => _getDateAndTime(),
                        'fvUpdatedOn' => _getDateAndTime()
                    );
                   // echo '<pre>'; print_r($insertData); die;
                    $this->mdgeneraldml->insert('tbl_footer_videos', $insertData);

                    $this->session->set_flashdata('success','New footer video has been added successfully');
                    redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos/add_new/' . $sort_by.'/'. $sort_type.'/'.$offset );
            
            }
        }
    }
   
    function checkCount($pageName){
        
        $count=$this->mdgeneraldml->get_table_total_count('tbl_footer_videos',array('fvPageName'=>$pageName));        
        if($count>=3)
        {
            $this->form_validation->set_message('checkCount', "You can not add more than 3 $pageName page footer video.");
            return FALSE;
        }
        else
            return TRUE;
    }
    
   function edit($fvId=NULL, $sort_by='fvId', $sort_type='DESC', $offset=0) {
       
       if (($fvId == NULL) or (!$this->admin_model->isRecordExist('tbl_footer_videos', array('fvId' => $fvId)))) {
          $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
          redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos');
       }
       
        $sql="SELECT fvId,fvPageName,fvImage,fvTitle,fvYouTubeVideoLink,fvDescription,fvReadMoreLink FROM tbl_footer_videos WHERE fvId=$fvId";
        $sliderInfo= $this->admin_model->sqlQuery($sql);        
        $data=array('action'=>'Edit','fvId'=>$sliderInfo[0]['fvId'],'fvPageName'=>$sliderInfo[0]['fvPageName'],'fvImage'=>$sliderInfo[0]['fvImage'],
                    'fvTitle'=>$sliderInfo[0]['fvTitle'],'fvYouTubeVideoLink'=>$sliderInfo[0]['fvYouTubeVideoLink'],
                    'fvDescription'=>$sliderInfo[0]['fvDescription'],'fvReadMoreLink'=>$sliderInfo[0]['fvReadMoreLink'],'btnName'=>'Save Changes','error'=>'');
        
        $this->session->set_userdata('fvPageName',$data['fvPageName']);
        //$this->form_validation->set_rules('fvImage', 'Image', 'trim');        
        $this->form_validation->set_rules('fvPageName', 'Page', 'required|callback_checkCountForEdit');       
        $this->form_validation->set_rules('fvTitle', 'Title', 'required|max_length[50]');       
        $this->form_validation->set_rules('fvYouTubeVideoLink', 'YouTube video link', 'required|max_length[150]');
        $this->form_validation->set_rules('fvDescription', 'Description', 'required|max_length[300]');
        $this->form_validation->set_rules('fvReadMoreLink', 'Read more link', 'required');       
        

        if ($this->form_validation->run() == FALSE) {
            //echo 'here'; die;
            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $this->load->view('admin/includes/header.php', $data);
            $this->load->view('admin/footer_video_add_edit_vw');
            $this->load->view('admin/includes/footer.php');
        } else {
             
            $flag=true;
            if ($_FILES['fvImage']['name'] != "") {
               
            $re['upload_response'] = $this->do_upload_new($maxHeight='75',$maxWidth='125');
             if (isset($re['upload_response']['error'])) {
                        $data['error'] = $re['upload_response']['error'];
                        $data['offset'] = $offset;
                        $data['sort_by'] = $sort_by;
                        $data['sort_type'] = $sort_type;
                        $flag=false;
                        $this->load->view('admin/includes/header.php');
                        $this->load->view('admin/footer_video_add_edit_vw', $data);
                        $this->load->view('admin/includes/footer.php');
                    }
            }
            
            if($flag==true)
            {
                $tableName = 'tbl_footer_videos';
                $where = array('fvId' => $fvId);
                $updateData = array(  
                    'fvPageName' => $this->input->post('fvPageName'),
                    'fvTitle' => $this->input->post('fvTitle'),
                    'fvYouTubeVideoLink' => $this->input->post('fvYouTubeVideoLink'),
                    'fvDescription' => $this->input->post('fvDescription'),
                    'fvReadMoreLink' => $this->input->post('fvReadMoreLink'),
                    'fvUpdatedOn' => _getDateAndTime()
                );

                  if (isset($re['upload_response']['resized_imageName']))
                  {
                      //unlink previous image
                      $path= BASEPATH.'../'.'sitedata/footer_videos_images/'.$data['fvImage'];                     
                      @unlink($path);
                      $updateData['fvImage'] = $re['upload_response']['resized_imageName'];
                  }
                  //echo BASEPATH.'<br>'.$path; die;  
                $this->mdgeneraldml->update($where, $tableName, $updateData);            
                $this->session->set_flashdata('success','Footer video has been updated.');
                redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos/edit/'.$fvId.'/' . $sort_by.'/'. $sort_type.'/'.$offset );
            } 
        }
    }
    
    function checkCountForEdit($pageName){
        
        $count=$this->mdgeneraldml->get_table_total_count('tbl_footer_videos',array('fvPageName'=>$pageName));  
        
        $fvPageName=$this->session->userdata('fvPageName');
        if($fvPageName==$pageName && $count<=3){
            return TRUE;
        }
        elseif($count>=3)
        {
            $this->form_validation->set_message('checkCountForEdit', "You can not add more than 3 $pageName page footer video.");
            return FALSE;
        }
        else
            return TRUE;
    }
    
   function do_upload_new($maxHeight='75',$maxWidth='125') {        
        $config['upload_path'] = './sitedata/footer_videos_images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';// '*'
        //$config['max_size'] = '2048';      
        $config['max_height'] = $maxHeight;
        $config['max_width'] = $maxWidth;        
        $config['encrypt_name'] = TRUE;
        $config['remove_spaces'] = TRUE;
       
        $this->load->library('upload',$config);
        
        if (!$this->upload->do_upload('fvImage')) {
            $error = array('error' => $this->upload->display_errors());
           // echo '<pre>'; print_r($error); die;
            return $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            return array('resized_imageName' => $data['upload_data']['file_name']);           
        }
    }
    
   function delete($fvId=NULL, $sort_by='fvId', $sort_type='DESC', $offset=0) 
    {
        if (($fvId != NULL) && ($this->admin_model->isRecordExist('tbl_footer_videos', array('fvId' => $fvId)))) {
            $tableName = 'tbl_footer_videos';
            $where = array('fvId' => $fvId);            
            
            $this->mdgeneraldml->delete($where, $tableName);
            $this->session->set_flashdata('success', 'Footer video has been Deleted successfully.');
            
            redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! Record not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos');
        }
    }
    
   function delete_selected($sort_by='fvId', $sort_type='DESC', $offset=0)
    {        
        if(!empty($_POST['chkmsg']))
        {
            $fvIds=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlDelete("DELETE FROM tbl_footer_videos WHERE fvId in($fvIds)");
            $this->session->set_flashdata('success', 'Selected footer videos has been deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single slider to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/manage_footer_videos'); 
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */