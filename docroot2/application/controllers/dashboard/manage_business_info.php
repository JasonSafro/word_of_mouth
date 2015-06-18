<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_business_info extends CI_Controller {

    function __construct()
    {
        parent::__construct();
         _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index()
    {
        $tbl_user = 'tbl_business_info';
        $where_user = array('user_id' => $this->session->userdata('user_id'));
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_user, $where_user);
        $info = $bus_Info[0];

        $data = array(
            'buss_id' => $info['buss_id'],
            'buss_name' => $info['buss_name'],
            'buss_cont_name' => $info['buss_cont_name'],
            'buss_address' => $info['buss_address'],
            'buss_addr_addon' => $info['buss_addr_addon'],
            'buss_city' => $info['buss_city'],
            'buss_zip_code' => $info['buss_zip_code'],
            'buss_phone' => $info['buss_phone'],
            'buss_fax' => $info['buss_fax'],
            'buss_web_address' => $info['buss_web_address'],
            'buss_email' => $info['buss_email'],
            'buss_license_num' => $info['buss_license_num'],
            'buss_social_media_channel_1' => $info['buss_social_media_channel_1'],
            'buss_social_media_channel_2' => $info['buss_social_media_channel_2'],
            'buss_social_media_channel_3' => $info['buss_social_media_channel_3'],
            'buss_social_media_channel_4' => $info['buss_social_media_channel_4'],
            'buss_tag_line'=>$info['buss_tag_line'],
            'buss_description'=>$info['buss_description'],
            'buss_media_copy'=>$info['buss_media_copy']
        );
        $data['error']='';
        $data['error1']='';

        $this->form_validation->set_rules('buss_name', 'Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_addr_addon', 'Address Add On', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required|max_lenght[30]');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required|is_numeric');
        $this->form_validation->set_rules('buss_fax', 'FAX', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('buss_web_address', 'Web Address', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_email', 'Email', 'xss_clean|trim|valid_email');
        $this->form_validation->set_rules('buss_license_num', 'License Number', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('buss_social_media_channel_1', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_2', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_3', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_4', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_tag_line', 'Business Tag Line', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_description', 'Business Description', 'xss_clean|trim|required|max_length[255]');
        
        if(!empty($_FILES['image_media'])){              
            $this->form_validation->set_rules('image_media[]','Media Copy','callback_checkForMediaCopy');
        }
        
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('includes/header');
            $this->load->view('dashboard/business_edit_view', $data);
            $this->load->view('includes/footer');
        }
        else
        {  //print_r($_POST);DIE;
            $updateData = array(
                'buss_name' => $this->input->post('buss_name'),
                'buss_cont_name' => $this->input->post('buss_cont_name'),
                'buss_address' => $this->input->post('buss_address'),
                'buss_addr_addon' => $this->input->post('buss_addr_addon'),
                'buss_city' => $this->input->post('buss_city'),
                'buss_phone' => $this->input->post('buss_phone'),
                'buss_fax' => $this->input->post('buss_fax'),
                'buss_web_address' => $this->input->post('buss_web_address'),
                'buss_email' => $this->input->post('buss_email'),
                'buss_license_num' => $this->input->post('buss_license_num'),
                'buss_social_media_channel_1' => $this->input->post('buss_social_media_channel_1'),
                'buss_social_media_channel_2' => $this->input->post('buss_social_media_channel_2'),
                'buss_social_media_channel_3' => $this->input->post('buss_social_media_channel_3'),
                'buss_social_media_channel_4' => $this->input->post('buss_social_media_channel_4'),
                'buss_tag_line' => $this->input->post('buss_tag_line'),
                'buss_description' => $this->input->post('buss_description')
            );
            
            $flag=true;



            
            
            //upload file
            if (isset($_FILES['image_logo']['name']) && !empty($_FILES['image_logo']['name'])) {
                if($_FILES['image_logo']!=""){
                $config['upload_path'] = './LOGO';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                $config['max_size'] = '1000';
                $config['max_width'] = '1024';
                $config['max_height'] = '768';
                $config['file_name'] = $this->input->post('image_logo');
                $config['overwrite'] = TRUE;
                $config['quality'] = 100;
                $this->load->library('upload');
                $this->upload->initialize($config);            

                $data1 = array();
                if (!$this->upload->do_upload('image_logo')) {
                    $flag=false;                    
                    $data['error']=$this->upload->display_errors();
                    $this->load->view('includes/header');
                    $this->load->view('dashboard/business_edit_view', $data);
                    $this->load->view('includes/footer');
                } else {
                    $data1 = array('upload_data' => $this->upload->data());
                    $updateData['buss_logo']=$data1['upload_data']['file_name'];
                }
            }//end of $_FILE
        }// end of isset
        
            //upload file
            $oldImages=$data['buss_media_copy'];
            if(!empty($_FILES['image_media'])){
                $imageNames=$this->do_MultipleUpload('image_media');
                if($imageNames!="")
                {
                   $updateData['buss_media_copy']=$imageNames.','.$oldImages;
                }    
            }
           
            
            if($flag==true)
            {
                $tableName = 'tbl_business_info';
                $where = array('user_id' => $this->session->userdata('user_id'));
                $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                $url = base_url() . 'dashboard/business_overview';
                echo "<script>alert('Information Updated Successfully!');window.location.href='$url'</script>";
            }
        }
    }
    
    function checkForMediaCopy()
    {
        $userId=$this->session->userdata('user_id');
        $where = array('user_id' => $userId);
        $userInfo= $this->mdgeneraldml->select('user_plan,user_type', 'tbl_user', $where);
        $numFilesUlpoad=0;
        if($userInfo[0]['user_type']=='buss_user')
        {
            if($userInfo[0]['user_plan']=='pm' || $userInfo[0]['user_plan']=='pa')//pm==premium monthly pa=oremium anual
                $numFilesUlpoad=6;
            else
                $numFilesUlpoad=2;
        }else{
            $this->form_validation->set_message('checkForMediaCopy', 'You can not upload the files.');
            return FALSE;
        }      
        
        
        //check for already uploaded images       
        $bus_Info = $this->mdgeneraldml->select('buss_media_copy', 'tbl_business_info', $where);
        $dbImageName = $bus_Info[0]['buss_media_copy'];
        if($dbImageName!="")
        {
            $imageArray=explode(',', $dbImageName);
            $imagesInDbForthisBusiness=sizeof($imageArray);
            $numFilesUlpoad=($numFilesUlpoad-$imagesInDbForthisBusiness);
            if($numFilesUlpoad<=0)
            {
                $this->form_validation->set_message('checkForMediaCopy', "You have exceded the image upload limit. If you wants to upload new images please remove the previous images.");
                return FALSE;
            }    
       }
           
        
        ini_set('memory_limit','-1');
        //echo '<pre>';print_r($_FILES['p_upload_photos']); die;
        $files=$_FILES['image_media'];
        //echo sizeof($files['name']);
        if(sizeof($files['name'])>$numFilesUlpoad){
            $this->form_validation->set_message('checkForMediaCopy', "You can not upload more than $numFilesUlpoad files.");
            return FALSE;
        }else{
            $types=$files['type'];
            $flag=true;
            foreach($types as $key=>$val)
            {
                if($val!="")
                {
                    $typeArray=explode("/", $val);
                    if($typeArray[0]!='image')
                        $flag=false;
                }else{
                    $this->form_validation->set_message('checkForMediaCopy', 'You can only upload the image file.');
                    return FALSE;
                }
            }
            
            if($flag==true)
                return TRUE;
            else{
                $this->form_validation->set_message('checkForMediaCopy', 'You can only select upload the image file.');
                return FALSE;
            }
        }
    }
    
    function do_MultipleUpload($inputFileName="")
    {
       $this->load->library('upload'); // Load Library

       $this->upload->initialize(array( // takes an array of initialization options
           "upload_path" => "./Media_Copy/",
           "overwrite" => FALSE,
           "encrypt_name" => TRUE,
           "remove_spaces" => TRUE,
           "allowed_types" => "*",
           "max_size" => 300,
           "xss_clean" => FALSE
       )); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean

       if ($this->upload->do_multi_upload($inputFileName)) { // use same as you did in the input field
            $result=$this->upload->get_multi_upload_data(); 
            
            $fileNames="";
            $fileNameArray=array();
            foreach($result as $key=>$val)
                $fileNameArray[]=$val['file_name'];

            $fileNames=implode(',', $fileNameArray);
                return $fileNames; 
       }
    }
    
    function removeMediaImage()
    {
        if(!empty($_POST))
        {
            $businessId=$_POST['businessId'];
            $imageName=$_POST['imageName'];
            
            $where = array('buss_id' => $businessId);
            $bus_Info = $this->mdgeneraldml->select('buss_media_copy', 'tbl_business_info', $where);
            $dbImageName = $bus_Info[0]['buss_media_copy'];
            if($dbImageName!="")
            {
                $imageArray=explode(',', $dbImageName);
                $newImageArray=array();
                foreach($imageArray as $key=>$val){
                    if($val!=$imageName){
                        $newImageArray[]=$val;
                    }   
                }
                
                $newImage=implode(',',$newImageArray);
                $updateData=array('buss_media_copy'=>$newImage);
                //echo $newImage;
                $this->mdgeneraldml->update($where, 'tbl_business_info', $updateData);
                unlink('./Media_Copy/'.$imageName);
                echo 'success';
           }else{
               echo 'fail';
           }
        }else{
            echo 'fail';
        }
    }

}