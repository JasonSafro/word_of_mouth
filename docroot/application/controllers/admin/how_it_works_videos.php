<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class How_it_works_videos extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateAdmin();
        $this->load->model('admin_model');
        $this->load->model('mdgeneraldml');
        $this->load->model('website_general_model', 'WGModel');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='buss_id', $sort_type='DESC', $offset=0) {
        $where=array('hwId'=>1);
        $info = $this->mdgeneraldml->select('*','tbl_how_it_work_videos', $where);
        $info=$info[0];
        $data=array('hwId'=>$info['hwId'],'hwVideo1'=>$info['hwVideo1'],'hwVideo2'=>$info['hwVideo2'],'hwVideo1Error'=>'','hwVideo2Error'=>'');
        $this->load->view('admin/includes/header');
        $this->load->view('admin/how_it_works_videos_edit_vw', $data);
        $this->load->view('admin/includes/footer');
    }
   
    function edit($videoFieldName='hwVideo1') {        
            
        $where=array('hwId'=>1);
        $info = $this->mdgeneraldml->select('*','tbl_how_it_work_videos', $where);
        $info=$info[0];
        $data=array('hwId'=>$info['hwId'],'hwVideo1'=>$info['hwVideo1'],'hwVideo2'=>$info['hwVideo2'],'hwVideo1Error'=>'','hwVideo2Error'=>'');
        if($videoFieldName=='hwVideo1')
            $this->form_validation->set_rules('hwVideo1','Video','callback_checkForVideo1');
        else
            $this->form_validation->set_rules('hwVideo2','Video','callback_checkForVideo2');
        
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/how_it_works_videos_edit_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {  
            
            
                if (!file_exists("./sitedata/how_it_works_videos"))                
                    mkdir('./sitedata/how_it_works_videos/', 0777, true);
                
                $response=$this->uploadVideo($videoFieldName);
                //echo '<pre>'; print_r($response); die;
                if($response['error']!=""){
                    $data[$videoFieldName.'Error']=$response['error'];
                    $this->load->view('admin/includes/header');
                    $this->load->view('admin/how_it_works_videos_edit_vw', $data);
                    $this->load->view('admin/includes/footer');
                }else{
                   $oldVideoName=$data[$videoFieldName];                
                   $updateFields=array(
                      $videoFieldName=>$response['fileName'],
                      'hwUpdatedOn'=>_getDateAndTime()
                   );
                   $this->mdgeneraldml->update($where, 'tbl_how_it_work_videos', $updateFields);
                   $this->session->set_flashdata('success','Video has been updated successfully.');
                   redirect('admin/how_it_works_videos');
                }
        }
    }

    
    
   
    
    function uploadVideo($fileFieldName){
                $config['upload_path'] = "./sitedata/how_it_works_videos/";
                $config['allowed_types'] = "*";            
                //$config['allowed_types'] = "mp4|MP4";                
                $config['max_size'] = '8388608';
                $config['overwrite'] = FALSE;
                $config['quality'] = 100;
                $this->load->library('upload');
                $this->upload->initialize($config); 
                $data1 = array('error'=>'','fileName'=>'');
                if (!$this->upload->do_upload($fileFieldName)) {                                       
                    $data1['error']=$this->upload->display_errors();                    
                }else {
                    $res = array('upload_data' => $this->upload->data());
                    $data1['fileName']=$res['upload_data']['file_name'];
                }
                return $data1;
    }
    
  function checkForVideo1(){
        
        $files=$_FILES['hwVideo1'];
        //echo sizeof($files['name']);
        if($files['name']==""){
            $this->form_validation->set_message('checkForVideo1', 'Please select video file to uload.');
            return FALSE;
        }else{
            $fileName=$files['name'];
            $requiredExtentions=array('mp4','MP4');
            $typeArray=explode(".", $fileName);
            $extention=$typeArray[1];
            if(!in_array($extention, $requiredExtentions))
            {
                $this->form_validation->set_message('checkForVideo1', 'You can only upload mp4 video file.');
                return FALSE;
            }else
                return TRUE;
        }
    }
    
  function checkForVideo2(){
        
        $files=$_FILES['hwVideo2'];
        //echo sizeof($files['name']);
        if($files['name']==""){
            $this->form_validation->set_message('checkForVideo2', 'Please select video file to upload.');
            return FALSE;
        }else{
            $fileName=$files['name'];
            $requiredExtentions=array('mp4','MP4');
            $typeArray=explode(".", $fileName);
            $extention=$typeArray[1];
            if(!in_array($extention, $requiredExtentions))
            {
                $this->form_validation->set_message('checkForVideo2', 'You can only upload mp4 video file.');
                return FALSE;
            }else
                return TRUE;
        }
    }
    
  function uploadMultipleVideos($inputFileName="",$mediaFileNames)
    {
       $this->load->library('upload'); // Load Library

       $this->upload->initialize(array( // takes an array of initialization options
           "upload_path" => "./sitedata/business_videos/",
           "overwrite" => FALSE,
           "encrypt_name" => TRUE,
           "remove_spaces" => TRUE,
           "allowed_types" => "*",
           //"max_size" => 300,
           "xss_clean" => FALSE
       )); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean

       if ($this->upload->do_multi_upload($inputFileName)) { // use same as you did in the input field
            $result2=$this->upload->get_multi_upload_data(); 
            
            $fileNames="";
            $fileNameArray=array();
            $mediaFileNamesArray=explode(',', $mediaFileNames);
            foreach($result2 as $key=>$val)
            {
                if(!in_array($val['file_name'], $mediaFileNamesArray))
                    $fileNameArray[]=$val['file_name'];
            }

            
            $fileNames=implode(',', $fileNameArray);
            //echo $fileNames;
            //echo '<pre>'; print_r($result2); die;
            return $fileNames; 
                
       }
    }

    function up(){
        
        $target_path = "./sitedata/how_it_works_videos/";

        $target_path = $target_path . basename( $_FILES['hwVideo2']['name']); 

        if(move_uploaded_file($_FILES['hwVideo2']['tmp_name'], $target_path)) {
            echo "The file ".  basename( $_FILES['hwVideo2']['name']). 
            " has been uploaded";
        } else{
            echo "There was an error uploading the file, please try again!";
        }
        
    }
    
    function ajajEdit($videoFieldName='hwVideo1'){     
            
        $where=array('hwId'=>1);
        $info = $this->mdgeneraldml->select('*','tbl_how_it_work_videos', $where);
        $info=$info[0];
        $data=array('hwId'=>$info['hwId'],'hwVideo1'=>$info['hwVideo1'],'hwVideo2'=>$info['hwVideo2'],'hwVideo1Error'=>'','hwVideo2Error'=>'');
        
        $response1=$this->checkForVideoForAjax($videoFieldName);
        if($response1['status']=='fail')
        {
            echo "fail=".$response1['message'];
        }
        else{
            $response=$this->uploadVideo($videoFieldName);
            if($response['error']!=""){
                echo "fail=".$response['error'];                
            }else{
               $oldVideoName=$data[$videoFieldName];                
               $updateFields=array(
                  $videoFieldName=>$response['fileName'],
                  'hwUpdatedOn'=>_getDateAndTime()
               );
               $this->mdgeneraldml->update($where, 'tbl_how_it_work_videos', $updateFields);
               echo "success=Video has been updated successfully.";
            }    
        }
    }
    
    function checkForVideoForAjax($fileFieldName='NULL'){
        
        $files=$_FILES[$fileFieldName];
        
        
        if($files['name']==""){
            $response=array('status'=>'fail','message'=>'Please select video file to upload.');            
        }else{
            $fileName=$files['name'];
            $requiredExtentions=array('mp4','MP4');
            $typeArray=explode(".", $fileName);
            $extention=$typeArray[1];
            if(!in_array($extention, $requiredExtentions))
            {
                $response=array('status'=>'fail','message'=>'You can only upload mp4 video file.');                 
            }else
                $response=array('status'=>'success','message'=>'Video has been uploaded successfully.');
        }
        return $response;
    }
}
