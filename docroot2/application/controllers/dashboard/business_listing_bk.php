<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_listing extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index(){

        $tbl_business_info = 'tbl_business_info';
        //$where_user = array('user_id' => $this->session->userdata('user_id'));        
        //$data['businessList']= $this->mdgeneraldml->select('*', $tbl_business_info, $where_user);
        $userId=$this->session->userdata('user_id');
        $where= "WHERE user_id=$userId AND bussStatus !='Deleted'";
        $data['businessList']= $this->WGModel->getBusinessInfoList($where);
        
        $this->load->view('includes/header');
        $this->load->view('dashboard/business_list_vw', $data);
        $this->load->view('includes/footer');
    }
    
    function view($businessId=''){
        $userId=$this->session->userdata('user_id');
        $where=array('buss_id'=>$businessId,'user_id'=>$userId);
        if($businessId!='' && _isRecordExist('tbl_business_info',$where))
        {
            //$where_user = array('user_id' => $userId);
            $where= " WHERE buss_id=$businessId AND user_id=$userId";
            //$bus_Info = $this->mdgeneraldml->select('*', 'tbl_business_info', $where);
            $bus_Info = $this->WGModel->getBusinessInfoList($where);
            $info = $bus_Info[0];
            $data['info'] = $info;
            //echo '<pre>'; print_r($info);die;
            $this->load->view('includes/header');
            $this->load->view('dashboard/business_overview_view', $data);
            $this->load->view('includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect('dashboard/business_listing');
        }
    }
    
    function add()
    {
        $myUserType=$this->session->userdata('user_type');
        $userId=$this->session->userdata('user_id');
        $mySubscriptionPlan="";
        if($myUserType=='buss_user'){
            $canIAddNewBusiness=true;
            $numOfBusinessAdded=__numOfUserBusiness($userId);
            $mySubscriptionPlan=__mySubscriptionPlan($userId);
            if(($mySubscriptionPlan=='bm' || $mySubscriptionPlan=='ba') && $numOfBusinessAdded==2)//this means user have basic plan and have reached the creating business limit
                $canIAddNewBusiness=false;

            if($canIAddNewBusiness==false){
               $this->session->set_flashdata('error','You have reached to the limit of listing, you subscription has limit of 2 listings. You can upgrade your account by clicking here.'); 
               redirect('dashboard/business_listing');
            }
        }else{
           $this->session->set_flashdata('error','You can not create business listing.'); 
           redirect('dashboard'); 
        }   
        
        
        
        /*$tbl_user = 'tbl_business_info';
        $where_user = array('user_id' => $userId);
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_user, $where_user);
        $info = $bus_Info[0];*/

        $data = array(
            'subscriptionPlan' => $mySubscriptionPlan,
            'buss_id' => '',
            'buss_name' =>'',
            'buss_category' =>'',
            'buss_cont_name' =>'',
            'buss_address' =>'',
            'buss_addr_addon' =>'',
            'buss_country' => 'USA',
            'buss_state' => '',
            'buss_city' =>'',
            'buss_zip_code' =>'',
            'buss_phone' =>'',
            'buss_fax' =>'',
            'buss_web_address' =>'',
            'buss_email' =>'',
            'buss_license_num' =>'',
            'buss_social_media_channel_1' =>'',
            'buss_social_media_channel_2' =>'',
            'buss_social_media_channel_3' =>'',
            'buss_social_media_channel_4' =>'',
            'buss_tag_line'=>'',
            'buss_description'=>'',
            'buss_media_copy'=>'',
            'buss_video'=>'',
            'buss_license_docs'=>'',
        );
        $data['action']='new';
        $data['error']='';
        $data['error1']='';

        $this->form_validation->set_rules('buss_name', 'Business name', 'xss_clean|trim|required|min_length[2]|max_length[125]');
        $this->form_validation->set_rules('buss_category[]', 'Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_addr_addon', 'Address Add On', 'xss_clean|trim');
         $this->form_validation->set_rules('buss_country', 'Country', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_state', 'State', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required|max_lenght[30]|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('buss_zip_code', 'Zip code', 'xss_clean|trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_fax', 'FAX', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_web_address', 'Web Address', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_email', 'Email', 'xss_clean|trim|valid_email');
        $this->form_validation->set_rules('buss_license_num', 'License Number', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_1','Twitter url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_social_media_channel_2', 'Facebook url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_social_media_channel_3', 'Pinterest url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_social_media_channel_4', 'LinkedIn url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_tag_line', 'Business Tag Line', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_description', 'Business Description', 'xss_clean|trim|max_length[255]');
        
        $tmpCat=$this->input->post('buss_category');
        //echo '<pre>'; print_r($tmpCat);
        if(!empty($tmpCat)){
            if(in_array('other', $this->input->post('buss_category')))
                $this->form_validation->set_rules('otherCategory', 'Other Category', 'xss_clean|trim|required|max_length[15]|is_unique[tbl_category.catName]');
        }
        
        if(!empty($_FILES['image_media'])){              
            if(!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0]!=""){              
                $this->form_validation->set_rules('image_media[]','Media Copy','callback_checkForMediaCopy');
            }
        }

        if(!empty($_FILES['buss_license_docs'])){ 
            if(!empty($_FILES['buss_license_docs']['name']) && $_FILES['buss_license_docs']['name'][0]!=""){        
                $this->form_validation->set_rules('buss_license_docs[]','Business license','callback_checkForBasicLicenseDocs');
            }    
        }

        /*if(!empty($_FILES['buss_video'])){              
            if(!empty($_FILES['buss_video']['name']) && $_FILES['buss_video']['name'][0]!=""){    
                $this->form_validation->set_rules('buss_video[]','Video','callback_checkForVideo');
            }
        }*/
                
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('includes/header');
            $this->load->view('dashboard/business_edit_view', $data);
            $this->load->view('includes/footer');
        }
        else
        {  //print_r($_POST);DIE;
            $updateData = array(
                'user_id' => $userId,
                'buss_name' => $this->input->post('buss_name'),
                'buss_cont_name' => $this->input->post('buss_cont_name'),
                'buss_address' => $this->input->post('buss_address'),
                'buss_addr_addon' => $this->input->post('buss_addr_addon'),
                'buss_country' => $this->input->post('buss_country'),
                'buss_state' => $this->input->post('buss_state'),
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
            $updateData['buss_logo']="default_logo.jpg";
            if (isset($_FILES['image_logo']['name']) && !empty($_FILES['image_logo']['name'])) {
                if($_FILES['image_logo']!=""){
                $uploadPath="./LOGO";
                $allwoedTypes="gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG";
                $uRes=$this->uploadSingalFile($fileFieldName="image_logo",$uploadPath,$allwoedTypes,$uploadFileType="Image",$maxUploadFileSize="3072",$maxWidth="1024",$maxHeight="768");
                
                    if ($uRes['error']!="") {
                        $flag=false;                    
                        $data['error']=$uRes['error'];
                        $this->load->view('includes/header');
                        $this->load->view('dashboard/business_edit_view', $data);
                        $this->load->view('includes/footer');
                    } else {
                        $updateData['buss_logo']=$uRes['fileName'];
                    }
               }//end of $_FILE
            }// end of isset
           
            
             //upload file 
            $mediaCoppyFileNames="";
            if(!empty($_FILES['image_media'])){
                if(!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0]!=""){ 
                    $imageNames=$this->do_MultipleUpload('image_media');
                    if($imageNames!="")
                    {
                       $updateData['buss_media_copy']=$imageNames;
                       $mediaCoppyFileNames=$updateData['buss_media_copy'];
                    }else{
                        $flag=false;                    
                        $data['error1']="Media Image size is too big.";                            
                        $this->load->view('includes/header');
                        $this->load->view('dashboard/business_edit_view', $data);
                        $this->load->view('includes/footer');
                    }
                }
            }
            
            
            if($flag==true)
            {    
                //echo '<pre>'; print_r($_FILES['image_media']);
               /* $mediaCoppyFileNames="";
                if(!empty($_FILES['image_media'])){
                    if(!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0]!=""){ 
                        $imageNames=$this->do_MultipleUpload('image_media');
                        if($imageNames!="")
                        {
                           $updateData['buss_media_copy']=$imageNames;
                           $mediaCoppyFileNames=$updateData['buss_media_copy'];
                        }
                    }
                }*/
           
                //upload multiple docs
                //create directory if not exist
                if (!file_exists("./sitedata/bisiness_license_docs"))                
                    mkdir('./sitedata/bisiness_license_docs/', 0777, true);
                                
                $businessLicensesDocsNames=$this->uploadMultipleDocs('buss_license_docs',$mediaCoppyFileNames);
                if($businessLicensesDocsNames!="")
                {
                    $updateData['buss_license_docs']=$businessLicensesDocsNames;
                }
                
                //upload multiple Videos
                //create directory if not exist
                /*if (!file_exists("./sitedata/business_videos"))                
                    mkdir('./sitedata/business_videos/', 0777, true);
                
                $previousUploadedFileNames=$mediaCoppyFileNames.','.$businessLicensesDocsNames;
                $businessVideoNames=$this->uploadMultipleVideos('buss_video',$previousUploadedFileNames);
                if($businessVideoNames!="")
                {
                    $updateData['buss_video']=$businessVideoNames;
                }*/

                $tableName = 'tbl_business_info';
                $result = $this->mdgeneraldml->insert($tableName, $updateData);
                $businessId=$result['last_insertId'];
                
                //create category if user has selected other
                $category=$this->input->post('buss_category');
                if(in_array("other",$category))
                {
                   $newCatName=$this->input->post('otherCategory');
                   $insertCatInfo = $this->mdgeneraldml->insert('tbl_category', array('catName'=>$newCatName,'catImageName'=>'default_category_image.png','catCreatedOn'=>_getDateAndTime(),'catStatus'=>'Active'));  
                   $category[]=$insertCatInfo['last_insertId'];
                } 
                
                
                foreach($category as $key=>$categoryId){
                    if($categoryId!="other"){
                        $businessCat_data=array('buss_id'=>$businessId,'cat_id'=>$categoryId);
                        $this->mdgeneraldml->insert('tbl_business_categories', $businessCat_data);
                     }
                }

                $this->session->set_flashdata('success','New listing has been added successfully.');
                redirect('dashboard/business_listing');
                //$url = base_url() . 'dashboard/business_listing';
                //echo "<script>alert('New listing has been created successfully.');window.location.href='$url'</script>";
            }    
        }
    }
    
    function edit($businessId)
    {
        $userId=$this->session->userdata('user_id');
        $tbl_user = 'tbl_business_info';
        $where_user = array('user_id' => $userId,'buss_id'=>$businessId);
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_user, $where_user);
        $info = $bus_Info[0];

        $data = array(
            'subscriptionPlan' => __mySubscriptionPlan($userId),
            'buss_id' => $info['buss_id'],
            'buss_name' => $info['buss_name'],
            'buss_category' => _getBusinessCategoryArray($businessId),
            'buss_cont_name' => $info['buss_cont_name'],
            'buss_address' => $info['buss_address'],
            'buss_addr_addon' => $info['buss_addr_addon'],
            'buss_country' => ($info['buss_country']!=""?$info['buss_country']:"USA"),
            'buss_state' => $info['buss_state'],
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
            'buss_media_copy'=>$info['buss_media_copy'],
            'buss_video'=>$info['buss_video'],
            'buss_license_docs'=>$info['buss_license_docs']
        );
        $data['action']='edit';
        $data['error']='';
        $data['error1']='';

        $this->form_validation->set_rules('buss_name', 'Business name', 'xss_clean|trim|required|min_length[2]|max_length[125]');
        $this->form_validation->set_rules('buss_category[]', 'Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_addr_addon', 'Address Add On', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required|max_lenght[30]|callback_validateAlphabetsWithSpace');
        $this->form_validation->set_rules('buss_zip_code', 'Zip code', 'xss_clean|trim|required|numeric|max_lenght[8]');
        $this->form_validation->set_rules('buss_country', 'Country', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_state', 'State', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_fax', 'FAX', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_web_address', 'Web Address', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_email', 'Email', 'xss_clean|trim|valid_email');
        $this->form_validation->set_rules('buss_license_num', 'License Number', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_1','Twitter url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_social_media_channel_2', 'Facebook url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_social_media_channel_3', 'Pinterest url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_social_media_channel_4', 'LinkedIn url', 'xss_clean|trim|callback_validateUrl');
        $this->form_validation->set_rules('buss_tag_line', 'Business Tag Line', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_description', 'Business Description', 'xss_clean|trim|max_length[255]');
        
        $tmpCat=$this->input->post('buss_category');
        if(!empty($tmpCat)){
            if(in_array('other', $this->input->post('buss_category')))
                $this->form_validation->set_rules('otherCategory', 'Other Category', 'xss_clean|trim|required|max_length[15]|is_unique[tbl_category.catName]');
        }
        //echo '<pre>'; print_r($_FILES['image_media']);
        if(!empty($_FILES['image_media'])){              
            if(!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0]!=""){              
                $this->form_validation->set_rules('image_media[]','Media Copy','callback_checkForMediaCopy');
            }
        }
        
        if(!empty($_FILES['buss_license_docs'])){ 
            if(!empty($_FILES['buss_license_docs']['name']) && $_FILES['buss_license_docs']['name'][0]!=""){        
                $this->form_validation->set_rules('buss_license_docs[]','Business license','callback_checkForBasicLicenseDocs');
            }    
        }
        
        if(!empty($_FILES['buss_video'])){              
            if(!empty($_FILES['buss_video']['name']) && $_FILES['buss_video']['name'][0]!=""){    
                $this->form_validation->set_rules('buss_video[]','Video','callback_checkForVideo');
            }
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
                'buss_country' => $this->input->post('buss_country'),
                'buss_state' => $this->input->post('buss_state'),
                'buss_city' => $this->input->post('buss_city'),
                'buss_zip_code' => $this->input->post('buss_zip_code'),
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
                $uploadPath="./LOGO";
                $allwoedTypes="gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG";
                $uRes=$uRes=$this->uploadSingalFile($fileFieldName="image_logo",$uploadPath,$allwoedTypes,$uploadFileType="Image",$maxUploadFileSize="3072",$maxWidth="1024",$maxHeight="768");
                
                    if ($uRes['error']!="") {
                        $flag=false;                    
                        $data['error']=$uRes['error'];
                        $this->load->view('includes/header');
                        $this->load->view('dashboard/business_edit_view', $data);
                        $this->load->view('includes/footer');
                    } else {
                        $updateData['buss_logo']=$uRes['fileName'];
                    }
               }//end of $_FILE
            }// end of isset
        
            
            //upload file
            $oldImages=$data['buss_media_copy'];
            $mediaCoppyFileNames=$oldImages;
            if(!empty($_FILES['image_media'])){
                if(!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0]!=""){ 
                    $imageNames=$this->do_MultipleUpload('image_media');
                    if($imageNames!="")
                    {
                       $updateData['buss_media_copy']=$imageNames.','.$oldImages;
                       $mediaCoppyFileNames=$updateData['buss_media_copy'];
                    }else{
                        $flag=false;                    
                        $data['error1']="Media Image size is too big.";
                        $this->load->view('includes/header');
                        $this->load->view('dashboard/business_edit_view', $data);
                        $this->load->view('includes/footer');
                    }
                }
            }
            
            
        if($flag==true)
         {  
                //upload file
                /*$oldImages=$data['buss_media_copy'];
                $mediaCoppyFileNames=$oldImages;
                if(!empty($_FILES['image_media'])){
                    if(!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0]!=""){ 
                        $imageNames=$this->do_MultipleUpload('image_media');
                        if($imageNames!="")
                        {
                           $updateData['buss_media_copy']=$imageNames.','.$oldImages;
                           $mediaCoppyFileNames=$updateData['buss_media_copy'];
                        }
                    }
                }*/
           
                //upload multiple docs
                //create directory if not exist
                if (!file_exists("./sitedata/bisiness_license_docs"))                
                    mkdir('./sitedata/bisiness_license_docs/', 0777, true);
                
                $oldDocs=$data['buss_license_docs'];
                $businessLicensesDocsNames=$this->uploadMultipleDocs('buss_license_docs',$mediaCoppyFileNames);
                if($businessLicensesDocsNames!="")
                {
                    $updateData['buss_license_docs']=$businessLicensesDocsNames.($oldDocs!=""?','.$oldDocs:"");
                }
                
                //upload multiple Videos
                //create directory if not exist
                if (!file_exists("./sitedata/business_videos"))                
                    mkdir('./sitedata/business_videos/', 0777, true);
                
                $oldVideos=$data['buss_video'];
                $previousUploadedFileNames=$mediaCoppyFileNames.','.$businessLicensesDocsNames;
                $businessVideoNames=$this->uploadMultipleVideos('buss_video',$previousUploadedFileNames);
                //echo 'video:'.$businessVideoNames; die;
                if($businessVideoNames!="")
                {
                    $updateData['buss_video']=$businessVideoNames.($oldVideos!=""?','.$oldVideos:"");
                }
                
                
            
            
                //echo '<pre>'; print_r($updateData); die;
                $tableName = 'tbl_business_info';
                $where = array('user_id' => $this->session->userdata('user_id'),'buss_id'=>$businessId);
                $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                
                //create category if user has selected other
                $category=$this->input->post('buss_category');
                if(in_array("other",$category))
                {
                   $newCatName=$form['otherCategory'];
                   $insertCatInfo = $this->mdgeneraldml->insert('tbl_category', array('catName'=>$newCatName,'catImageName'=>'default_category_image.png','catCreatedOn'=>_getDateAndTime(),'catStatus'=>'Active'));  
                   $category[]=$insertCatInfo['last_insertId'];
                } 

                //delete previous business cats those are assigned to this business               
                $this->mdgeneraldml->delete(array('buss_id'=>$businessId),'tbl_business_categories');
                
                //assign new categories to the business
                foreach($category as $key=>$categoryId){
                    if($categoryId!="other"){
                        $businessCat_data=array('buss_id'=>$businessId,'cat_id'=>$categoryId);
                        $this->mdgeneraldml->insert('tbl_business_categories', $businessCat_data);
                     }
                }
                
                //echo $this->db->last_query(); die;
                //$url = base_url() . 'dashboard/business_listing';
                //echo "<script>alert('List has been updated successfully!');window.location.href='$url'</script>";
                $this->session->set_flashdata('success','List has been updated successfully.');
                redirect('dashboard/business_listing');
            }
        }
    }
    
    function delete($buss_id='') {
        $userId=$this->session->userdata('user_id');
        $where = array('buss_id' => $buss_id,'user_id'=>$userId);
        if($buss_id != '' && _isRecordExist('tbl_business_info', $where)) {                        
            $this->mdgeneraldml->delete($where,'tbl_business_info');
            $this->session->set_flashdata('success','Business has been deleted successfully.');
            redirect("dashboard/business_listing");
        }else{
            $this->session->set_flashdata('error','Sorry, record not found.');
            redirect("dashboard/business_listing");
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
                $this->form_validation->set_message('checkForMediaCopy',"You have exceded the image upload limit. If you wants to upload new images please remove the previous images.");
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
    
    function checkForBasicLicenseDocs()
    {
        //echo '<pre>';print_r($_FILES['license_docs']); die;
        $files=$_FILES['buss_license_docs'];
        //echo sizeof($files['name']);
        if(sizeof($files['name'])>5){
            $this->form_validation->set_message('checkForBasicLicenseDocs', 'You can not upload more than five files.');
            return FALSE;
        }else{
            $types=$files['name'];
            $flag=true;
            if($types[0]!="")
            {    
                $requiredExtentions=array('PDF','pdf','DOC','doc','DOCX','docx');
                foreach($types as $key=>$val)
                {
                    if($val!="")
                    {
                        $typeArray=explode(".", $val);
                        $extention=$typeArray[1];
                        if(!in_array($extention, $requiredExtentions))
                            $flag=false;
                    }else{
                        $this->form_validation->set_message('checkForBasicLicenseDocs', 'You can only upload pdf or doc file.');
                        return FALSE;
                    }
                }
            }
            else
                $flag=true;
            
            if($flag==true)
            {
                
                return TRUE;
            }
            else{
                $this->form_validation->set_message('checkForBasicLicenseDocs', 'You can only upload pdf or doc file');
                return FALSE;
            }
        }
    }
    
    function checkForVideo(){
        //echo '<pre>';print_r($_FILES['buss_video']); die;
        $files=$_FILES['buss_video'];
        //echo sizeof($files['name']);
        if(sizeof($files['name'])>2){
            $this->form_validation->set_message('checkForVideo', 'You can not upload more than two video files.');
            return FALSE;
        }else{
            $types=$files['name'];
            $flag=true;
            if($types[0]!="")
            {    
                $requiredExtentions=array('mp4','MP4');
                foreach($types as $key=>$val)
                {
                    if($val!="")
                    {
                        $typeArray=explode(".", $val);
                        $extention=$typeArray[1];
                        if(!in_array($extention, $requiredExtentions))
                            $flag=false;
                    }else{
                        $this->form_validation->set_message('checkForVideo', 'You can only upload mp4 video file.');
                        return FALSE;
                    }
                }
            }
            else
                $flag=true;
            
            if($flag==true)
            {
                
                return TRUE;
            }
            else{
                $this->form_validation->set_message('checkForVideo', 'You can only upload mp4 video file');
                return FALSE;
            }
        }
    }
    
    function uploadMultipleDocs($inputFileName="",$mediaFileNames)
    {
       $this->load->library('upload'); // Load Library

       $this->upload->initialize(array( // takes an array of initialization options
           "upload_path" => "./sitedata/bisiness_license_docs/",
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
    
    function uploadSingalFile($fileFieldName,$uploadPath,$allwoedTypes,$uploadFileType,$maxUploadFileSize,$maxWidth,$maxHeight){
                
                
                $config['upload_path'] = $uploadPath;
                $config['allowed_types'] = $allwoedTypes;                
                $config['max_size'] = $maxUploadFileSize;
                if($uploadFileType=='Image')
                {    
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';
                }
                
                $config['overwrite'] = FALSE;
                $config['quality'] = 100;
                $this->load->library('upload');
                $this->upload->initialize($config);            

                $data1 = array('error'=>'','fileName'=>'');
                if (!$this->upload->do_upload($fileFieldName)) {                                       
                    $data1['error']=$this->upload->display_errors();                    
                } else {
                    $res = array('upload_data' => $this->upload->data());
                    $data1['fileName']=$res['upload_data']['file_name'];
                }
                return $data1;
    }
    
    function removeBusinessDoc()
    {
        if(!empty($_POST))
        {
            $businessId=$_POST['businessId'];
            $imageName=$_POST['docName'];
            
            $where = array('buss_id' => $businessId);
            $bus_Info = $this->mdgeneraldml->select('buss_license_docs', 'tbl_business_info', $where);
            $dbImageName = $bus_Info[0]['buss_license_docs'];
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
                $updateData=array('buss_license_docs'=>$newImage);
                //echo $newImage;
                $this->mdgeneraldml->update($where, 'tbl_business_info', $updateData);
                unlink('./sitedata/bisiness_license_docs/'.$imageName);
                echo 'success';
           }else{
               echo 'fail';
           }
        }else{
            echo 'fail';
        }
    }
    
    function removeVideo()
    {
        if(!empty($_POST))
        {
            $businessId=$_POST['businessId'];
            $imageName=$_POST['videoName'];
            
            $where = array('buss_id' => $businessId);
            $bus_Info = $this->mdgeneraldml->select('buss_video', 'tbl_business_info', $where);
            $dbImageName = $bus_Info[0]['buss_video'];
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
                $updateData=array('buss_video'=>$newImage);
                //echo $newImage;
                $this->mdgeneraldml->update($where, 'tbl_business_info', $updateData);
                unlink('./sitedata/business_videos/'.$imageName);
                echo 'success';
           }else{
               echo 'fail';
           }
        }else{
            echo 'fail';
        }
    }
    
    function download_doc($buss_id,$docName){
        
        
        //if (!file_exists("./sitedata/bisiness_license_docs/".$docName))
        //{
           
           $file_path = "sitedata/bisiness_license_docs/".$docName; 
            header('Content-Type: application/*');
            header('Content-disposition: attachment; filename='.$docName);
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
        //}    
       
    }
    
    function download_video($buss_id,$videoName){
           $file_path = "sitedata/business_videos/".$videoName; 
            header('Content-Type: application/*');
            header('Content-disposition: attachment; filename='.$videoName);
            header('Content-Length: ' . filesize($file_path));
            readfile($file_path);
    }

    function validateUrl($string){
       if(trim($string)=="") 
           return TRUE;
       
       //echo prep_url($string); die;
       
       if (filter_var($string, FILTER_VALIDATE_URL)){
           return TRUE;
        }
        else
        {
            $this->form_validation->set_message('validateUrl', 'Please enter valid url. (Ex: http://www.example.com).');
            return FALSE;
        }
    }
    
    function validateAlphabetsWithSpace($string){
        //alphbets with space allowed
       $rex = '/^[a-zA-Z][a-zA-Z ]*$/';
       if (preg_match($rex, $string)){
           return TRUE;
        }
        else
        {
            $this->form_validation->set_message('validateAlphabetsWithSpace', 'Numbers and special characters are not allowed.');
            return FALSE;
        }
    }
    
    function getStateList($countryCode)
    {
        $stateList = _getStateList($countryCode);
        foreach ($stateList as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }
    
    function ajaxVideoUpload($bussId){
        $where=array('buss_id'=>$bussId);
        $info = $this->mdgeneraldml->select('buss_video','tbl_business_info', $where);
        $info=$info[0];
        $videoString=$info['buss_video'];
        $videoArray=array();
        if($videoString!=""){
            $videoArray=explode(',',$videoString);
            if(count($videoArray)>=2){
                echo "fail=You can not upload more than two videos.";
                die;
            }
        }
        $videoFieldName="ajax_buss_video";
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
               
               $videoArray[]=$response['fileName'];
               $newName=implode(',',$videoArray);
               
               $updateFields=array('buss_video'=>$newName);
               
               $this->mdgeneraldml->update($where, 'tbl_business_info', $updateFields);
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
    
    function uploadVideo($fileFieldName){
                $config['upload_path'] = "./sitedata/business_videos/";
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
    
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */