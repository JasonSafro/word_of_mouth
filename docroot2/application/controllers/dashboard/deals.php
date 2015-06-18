<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deals extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        _authenticatePrimiumUser();
        
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('dashboard_model', 'dash');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index(){
        $userId=$this->session->userdata('user_id');
        $data['error_occured'] = "n";$data=array('user_id'=>$userId,'newImageError'=>'','editImageError'=>'','newDealDocumentError'=>'','editDealDocumentError'=>'');
        /*$table = 'tbl_deals';        
        $where= array('dealUserId' => $userId);
        $data['dealList'] = $this->mdgeneraldml->select('*', $table, $where);*/
        $where="WHERE d.dealUserId=$userId AND d.dealStatus !='Deleted'";
        $data['dealList'] = $this->dash->getDealList($where);
        //echo $this->db->last_query(); die;
         
        $this->load->view('includes/header');
        $this->load->view('dashboard/deals_list_vw', $data);
        $this->load->view('includes/footer');
    }
    
    function deals_list()
    {
        //echo 'hello'; die;
        $this->index();
    }
    
    function new_deal()
    {
        //__myBusinessDropdown

        $user_id=$this->session->userdata('user_id');
        $data=array('user_id'=>$user_id,'newImageError'=>'','editImageError'=>'','newDealDocumentError'=>'','editDealDocumentError'=>'');

        $where="WHERE d.dealUserId=$user_id";
        $data['dealList'] = $this->dash->getDealList($where);
        $data['error_occured'] = "n";
        $this->form_validation->set_rules('dealBusinessId', 'Business Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealOverview', 'Ovewview', 'xss_clean|trim|required|max_length[300]');
        $this->form_validation->set_rules('dealDetails', 'Details', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealValue', 'Value', 'xss_clean|trim|numeric|required');
        $this->form_validation->set_rules('dealDiscounts', 'Discount', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealSavings', 'Saving', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealFinalPrice', 'Final Price', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealExpirationDate', 'Expity date', 'xss_clean|required');
        $this->form_validation->set_rules('dealLimit', 'Limits', 'xss_clean');
        
        if ($this->form_validation->run() == FALSE){
        $data['error_occured'] = "y";
            $this->load->view('includes/header');
            $this->load->view('dashboard/deals_list_vw', $data);
            //$this->load->view('dashboard/deal_add_edit_vw', $data);
            $this->load->view('includes/footer');
        }
		else
		{     
		$data['error_occured'] = "n";       
            $fileName=$_FILES['dealImage']['name'];
            $ulpadFlag=true;
            if($fileName!="")
            {    
				$re['upload_response'] = $this->do_upload($forcedWidth=361, $forcedHeight=214);
				if(isset($re['upload_response']['error'])){
					 $data['newImageError'] = $re['upload_response']['error'];
					$ulpadFlag=false;
				}else{
				   $dealImage=$re['upload_response']['resized_imageName'];
				}
			}
			else
			{
				$dealImage = "default_deal_img.png";
			}
            
            //upload deal document 
            $dealDocument="";
            $re = $this->uploadDocument();
            if(isset($re['error'])){
                $data['newDealDocumentError']= $re['error'];
                $ulpadFlag=false;
            }else{
               $dealDocument=$re['uploadedFileName'];
            }
            
           if($ulpadFlag==false)
           {   
               $this->load->view('includes/header');
               $this->load->view('dashboard/deals_list_vw', $data);
               $this->load->view('includes/footer');
           }else{            
               $insertData=array(
                   'dealUserId'=>$user_id,
                   'dealBusinessId'=>$this->input->post('dealBusinessId'),
                   'dealOverview'=>$this->input->post('dealOverview'),
                   'dealDetails'=>$this->input->post('dealDetails'),
                   'dealValue'=>$this->input->post('dealValue'),
                   'dealDiscounts'=>$this->input->post('dealDiscounts'),
                   'dealSavings'=>$this->input->post('dealSavings'),
                   'dealFinalPrice'=>$this->input->post('dealFinalPrice'),
                   'dealExpirationDate'=>$this->input->post('dealExpirationDate'),
                   'dealLimit'=>$this->input->post('dealLimit'),              
                   'dealImage'=>$dealImage,
                   'dealDocument'=>$dealDocument,
                   'dealCreatedOn'=>_getDateAndTime(),
                   'dealUpdatedOn'=>_getDateAndTime(),
               );

               $response=$this->mdgeneraldml->insert('tbl_deals',$insertData);//last_insertId
               $this->session->set_flashdata('success','Deal has been added successfully.');
              
              //Send email to admin;
               $buss_id=$this->input->post('dealBusinessId');
               $sql="SELECT buss_name from tbl_business_info WHERE buss_id = $buss_id ";
               $bussinfo =$this->WGModel->sqlQuery($sql);
               
               $where=array('emailId'=>'107');
               $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where);
               
               $emilTemplet=$emailinfo[0]['emailBody'];
               $emilTempletSubject=$emailinfo[0]['emailSubject'];
               
               $sql="SELECT CONCAT(user_fname,' ',user_lname) as userFullName from tbl_user WHERE user_id=$user_id";
               $publisherInfo=$this->WGModel->sqlQuery($sql);
                
               $emailBody=str_replace ("[[DEAL_NAME]]", $bussinfo[0]['buss_name'], $emilTemplet);
               $emailBody=str_replace ("[[USER_FULL_NAME]]", $publisherInfo[0]['userFullName'], $emailBody);
               send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody);
                
               //update business
               $where=array('buss_id'=>$buss_id);
               $this->mdgeneraldml->update($where,'tbl_business_info',array('bussHasDeal'=>'Yes'));
               $this->session->set_flashdata('success','New deal has been added successfully.');
               redirect('dashboard/deals#success');
           }

        }

    }
    
    function edit()
    {
       
        $user_id=$this->session->userdata('user_id');
        $dealId=$this->input->post('dealId');
        //$data1=$this->getDealInfoForEdit($dealId);
        
        $data=array('user_id'=>$user_id,'newImageError'=>'','editImageError'=>'','newDealDocumentError'=>'','editDealDocumentError'=>'');
        
        //merge both array
        //$data=array_merge($data1,$data2);
        
        $this->form_validation->set_rules('dealId', 'Deal Id', 'xss_clean|trim|required');//this field is hidden in form
        $this->form_validation->set_rules('dealBusinessId', 'Business Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealOverview', 'Ovewview', 'xss_clean|trim|required|max_length[300]');//|less_than[300]');
        $this->form_validation->set_rules('dealDetails', 'Details', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealValue', 'Value', 'xss_clean|trim|numeric|required');
        $this->form_validation->set_rules('dealDiscounts', 'Discount', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealSavings', 'Saving', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealFinalPrice', 'Final Price', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealExpirationDate', 'Expity date', 'xss_clean|required');
        $this->form_validation->set_rules('dealLimit', 'Limits', 'xss_clean');
        if ($this->form_validation->run() == FALSE){
            $where="WHERE d.dealUserId=$user_id";
            $data['dealList'] = $this->dash->getDealList($where);
            $data['error_occured'] = "y";
            $this->load->view('includes/header');
            //$this->load->view('dashboard/deal_add_edit_vw', $data);
            $this->load->view('dashboard/deals_list_vw', $data);
            $this->load->view('includes/footer');
        }else{
            $data['error_occured'] = "n";
            $insertData=array(                   
                   'dealBusinessId'=>$this->input->post('dealBusinessId'),
                   'dealOverview'=>$this->input->post('dealOverview'),
                   'dealDetails'=>$this->input->post('dealDetails'),
                   'dealValue'=>$this->input->post('dealValue'),
                   'dealDiscounts'=>$this->input->post('dealDiscounts'),
                   'dealSavings'=>$this->input->post('dealSavings'),
                   'dealFinalPrice'=>$this->input->post('dealFinalPrice'),
                   'dealExpirationDate'=>$this->input->post('dealExpirationDate'),
                   'dealLimit'=>$this->input->post('dealLimit'),                   
                   'dealUpdatedOn'=>_getDateAndTime(),
               );
             
           
            
            
            $where=array('dealUserId'=>$user_id,'dealId'=>$dealId);
            if($dealId!='' && _isRecordExist('tbl_deals',$where))
            {
            $data['error_occured'] = "n";
                //upload deal image
                $fileName=$_FILES['dealImage']['name'];
                $ulpadFlag=true;
                if($fileName!="")
                {    
                    $re['upload_response'] = $this->do_upload($forcedWidth=361, $forcedHeight=214);
                    if(isset($re['upload_response']['error'])){
                        $data['editImageError'] = $re['upload_response']['error'];
                        $ulpadFlag=false;
                    }else{
                        $dealImage=$re['upload_response']['resized_imageName'];
                        $insertData['dealImage']=$dealImage;
                    }
                }
                
                //upload deal document 
                $fileName=$_FILES['dealDocument']['name'];                
                if($fileName!="")
                {    
                    $re= $this->uploadDocument();
                    if(isset($re['error'])){
                        $ulpadFlag=false;
                        $data['editDealDocumentError']= $re['error'];
                    }else{
                        $dealDocument=$re['uploadedFileName'];
                        $insertData['dealDocument']=$dealDocument;
                    }
                }
               
               if($ulpadFlag==false)
               {  
                   $where="WHERE d.dealUserId=$user_id";
                   $data['dealList'] = $this->dash->getDealList($where);
                    
                   $this->load->view('includes/header');
                   $this->load->view('dashboard/deals_list_vw', $data);
                    $this->load->view('includes/footer');
               }else{
                   $this->mdgeneraldml->update($where,'tbl_deals',$insertData);
                   //unset session currentEditDealId which is created in getDeal() and used in deals_lis_vw page
                   $this->session->set_userdata('currentEditDealId','');
                   
                   $this->session->set_flashdata('success','Deal has been successfully updated.');
                   redirect('dashboard/deals/deals_list#success');
               }
            }else{
                $this->session->set_flashdata('error','Deal not exit.');
                redirect('dashboard/deals');
            }
        }        
    }   
    
    function getDeal($dealId)
    {
        $user_id=$this->session->userdata('user_id');
        if($dealId!='' && _isRecordExist('tbl_deals',array('dealUserId'=>$user_id,'dealId'=>$dealId)))
        { 
            $where="WHERE d.dealUserId=$user_id AND dealId=$dealId";
            $dealList = $this->dash->getDealList($where);
            $dealList = $dealList[0];
            
            $result=array(
                    'user_id'           =>$user_id,
                    'dealBusinessId'    =>$dealList['dealBusinessId'],
                    'dealOverview'      =>$dealList['dealOverview'],
                    'dealDetails'       =>$dealList['dealDetails'],
                    'dealValue'         =>$dealList['dealValue'],
                    'dealDiscounts'     =>$dealList['dealDiscounts'],
                    'dealSavings'       =>$dealList['dealSavings'],
                    'dealFinalPrice'    =>$dealList['dealFinalPrice'],
                    'dealExpirationDate'=>$dealList['dealExpirationDate'],
                    'dealLimit'         =>$dealList['dealLimit'],
                    'dealImage'         =>$dealList['dealImage'],
                    'dealDocument'         =>$dealList['dealDocument']
                );
            $this->session->set_userdata('currentEditDealId',$dealId);
            $result['status']='success';
            echo json_encode($result);
        }else{
            $result['status']='fail';
            echo json_encode($result);
        }
    }
    
     function getDealInfoForEdit($dealId)
    {
        $user_id=$this->session->userdata('user_id');
        if($dealId!='' && _isRecordExist('tbl_deals',array('dealUserId'=>$user_id,'dealId'=>$dealId)))
        { 
            $where="WHERE d.dealUserId=$user_id AND dealId=$dealId";
            $dealList = $this->dash->getDealList($where);
            $dealList = $dealList[0];
            
            $result=array(
                    'user_id'           =>$user_id,
                    'dealBusinessId'    =>$dealList['dealBusinessId'],
                    'dealOverview'      =>$dealList['dealOverview'],
                    'dealDetails'       =>$dealList['dealDetails'],
                    'dealValue'         =>$dealList['dealValue'],
                    'dealDiscounts'     =>$dealList['dealDiscounts'],
                    'dealSavings'       =>$dealList['dealSavings'],
                    'dealFinalPrice'    =>$dealList['dealFinalPrice'],
                    'dealExpirationDate'=>$dealList['dealExpirationDate'],
                    'dealLimit'         =>$dealList['dealLimit']
                );
            return $result;
        }else{
            $result['status']='fail';
            return $result;
        }
    }
    
    function do_upload($forcedWidth=NULL, $forcedHeight=NULL) {
        
        //echo '<pre>'; print_r($_FILES); die;
       
        $config['upload_path'] = './sitedata/images/deal_images/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';//; 
        //$config['allowed_types'] = '*';//; 
        $newName=date('YmdHis').'.png';
        $config['max_size'] = '2048';
        /*$config['max_width'] = '250';
        $config['max_height'] = '300';*/
        $config['min_height'] = $forcedHeight;
        $config['min_weight'] = $forcedWidth;
        $config['file_name'] = $newName;
        $config['overwrite'] = TRUE;
        $config['quality'] = 100;
        $this->load->library('upload');
        $this->upload->initialize($config); 
        if (!$this->upload->do_upload('dealImage')) {
            $error = array('error' => $this->upload->display_errors());           
            return $error;
        } else {
           
            $data = array('upload_data' => $this->upload->data());
            $config['image_library'] = 'gd2';
            $config['source_image'] = './sitedata/images/deal_images/' . $newName;
            //$config['new_image'] = './sitedata/images/profile_images/thumb/' . $data['upload_data']['file_name'];
            $config['new_image'] = './sitedata/images/deal_images/thumbs/' . $newName;
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = FALSE;
            $config['overwrite'] = TRUE;

            $sourceImage = $data['upload_data']['full_path'];
            $sourceSize = getimagesize($sourceImage);
            //echo '<pre>'; print_r($sourceSize); die;
            // For a landscape picture or a square
            $uploadedImageWidth=$sourceSize[0];
            $uploadedImageHeight=$sourceSize[1];
            
            if($uploadedImageWidth<$forcedWidth || $uploadedImageHeight<$forcedHeight)
            {
                @unlink($sourceImage);
                return array('error' => "Please upload the image with the min width $forcedWidth and min height $forcedHeight");
            }
            
            /* if ($sourceSize[0] >= $sourceSize[1])
              {
              $finalWidth = $forcedWidth;
              $finalHeight = ($forcedWidth / $sourceSize[0]) * $sourceSize[1];
              }
              // For a potrait picture
              else
              {
              $finalWidth = ($forcedHeight / $sourceSize[1]) * $sourceSize[0];
              $finalHeight = $forcedHeight;
              } */

           
            $config['width'] = $forcedWidth; //$finalWidth;
            $config['height'] = $forcedHeight; //$finalHeight;

            $this->load->library('image_lib', $config);
            $this->image_lib->display_errors('<p>', '</p>');
            if (!$this->image_lib->resize()) {
                //echo 'resize error:';
                return array('error' => $this->image_lib->display_errors());
            } else {
                return array('resized_imageName' => $data['upload_data']['file_name']);
            }
        }
    }
    
    function uploadDocument() {
        
        //echo '<pre>'; print_r($_FILES); die;
       
        $config['upload_path'] = './sitedata/deal_docs/';
        //$config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';//; 
        $config['allowed_types'] = 'pdf';//; 
        $newName=date('YmdHis').'_doc.pdf';
        $config['max_size'] = '5120';//5mb
        /*$config['max_width'] = '250';
        $config['max_height'] = '300';
        $config['min_height'] = '285';
        $config['min_weight'] = '240';*/
        $config['file_name'] = $newName;
        $config['overwrite'] = TRUE;
        //$config['quality'] = 100;
        $this->load->library('upload');
        $this->upload->initialize($config); 
        if (!$this->upload->do_upload('dealDocument')) {
            $error = array('error' => $this->upload->display_errors());           
            //echo '<pre>'; print_r($error); die;
            return $error;
        } else {
           
            $data = array('upload_data' => $this->upload->data());
            //echo '<pre>'; print_r($data);
            return array('uploadedFileName' => $data['upload_data']['file_name']);
            
        }
    }
    
    function delete($dealId){
    	$user_id=$this->session->userdata('user_id');
        if($dealId!='' && _isRecordExist('tbl_deals',array('dealUserId'=>$user_id,'dealId'=>$dealId)))
        {             
            $where=array('dealUserId'=>$user_id,'dealId'=>$dealId);
            $updataeData=array('dealStatus'=>'Deleted','dealUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_deals', $updataeData);
            $this->session->set_flashdata('success','Deal has been successfully deleted.');
        }else{
        	$this->session->set_flashdata('error','Sorry! you can not delete this deal.');        	
        }    
        
        redirect('dashboard/deals');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */