<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_Deals extends CI_Controller {

    function __construct() {
         parent::__construct();
        _authenticateAdmin();
        $this->load->model('admin_model');
        $this->load->model('mdgeneraldml');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='dealId', $sort_type='DESC', $offset=0)
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_deals/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        
        //countTotalDeals   
        $whereDeal="WHERE d.dealStatus !='Deleted'";
        $totalRows=$this->admin_model->countTotalDeals($whereDeal);
        //echo $this->db->last_query(); die;
        $data = _getPagingVaiablesByCount($totalRows, $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type);
                
        $data['dealList'] = $this->admin_model->getDealList($whereDeal,$sort_by,$sort_type,$limit,$offset);
        
       
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/manage_deals_vw',$data);
        $this->load->view('admin/includes/footer');
        
        
    }
    
    function view($dealId='',$sort_by='dealId', $sort_type='DESC', $offset=0)
    {
        $where=array('dealStatus !='=>'Deleted','dealId'=>$dealId);
        if($dealId!='' && _isRecordExist('tbl_deals',$where))
        {
            $whereDeal="WHERE dealStatus !='Deleted' AND dealId=$dealId";
            $data['dealInfo']=$this->admin_model->getDealList($whereDeal);
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/manage_deals_detailpage_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_deals/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }  
    }
    
    function deals_list()
    {
        //echo 'hello'; die;
        $this->index();
    }
    
    function add($sort_by='dealId', $sort_type='DESC', $offset=0)
    {
        $data=array('action'=>'new','dealId'=>'','dealBusinessId'=>'','dealOverview'=>'','dealDetails'=>'','dealValue'=>'',
            'dealDiscounts'=>'','dealSavings'=>'','dealFinalPrice'=>'','dealLimit'=>'','dealExpirationDate'=>'','dealImage'=>'','newImageError'=>'');
        
        $this->form_validation->set_rules('dealBusinessId', 'Business Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealOverview', 'Ovewview', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealDetails', 'Details', 'xss_clean|trim|required');
        $this->form_validation->set_rules('dealValue', 'Value', 'xss_clean|trim|numeric|required');
        $this->form_validation->set_rules('dealDiscounts', 'Discount', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealSavings', 'Saving', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealFinalPrice', 'Final Price', 'xss_clean|numeric');
        $this->form_validation->set_rules('dealExpirationDate', 'Expity date', 'xss_clean|required');
        $this->form_validation->set_rules('dealLimit', 'Limits', 'xss_clean');
        
        if ($this->form_validation->run() == FALSE){
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/manage_deals_add_edit_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{            
            $fileName=$_FILES['dealImage']['name'];
            $ulpadFlag=true;
                
            $re['upload_response'] = $this->do_upload($forcedWidth=361, $forcedHeight=214);
            if(isset($re['upload_response']['error'])){
                $ulpadFlag=false;
            }else{
               $dealImage=$re['upload_response']['resized_imageName'];
            }
            
           if($ulpadFlag==false)
           {
               $data['newImageError'] = $re['upload_response']['error'];
               $this->load->view('admin/includes/header');	
                $this->load->view('admin/manage_deals_add_edit_vw',$data);
                $this->load->view('admin/includes/footer');
           }else{    
               
            //get user id
            $selecteBusinessId=$this->input->post('dealBusinessId');
            $BusinessInfo=$this->mdgeneraldml->select('user_id','tbl_business_info',array('buss_id'=>$selecteBusinessId));
            $businessUserId=$BusinessInfo[0]['user_id'];
            
               $insertData=array(
                   'dealUserId'=>$businessUserId,
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
                   'dealCreatedOn'=>_getDateAndTime(),
                   'dealUpdatedOn'=>_getDateAndTime(),
               );

               $response=$this->mdgeneraldml->insert('tbl_deals',$insertData);//last_insertId
               $this->session->set_flashdata('success','Deal has been added successfully.');
               redirect(ADMIN_FOLDER_NAME.'/manage_deals/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
           }
        }
    }
    
    function edit($dealId='',$sort_by='dealId', $sort_type='DESC', $offset=0)
    {
        $where=array('dealStatus !='=>'Deleted','dealId'=>$dealId);
        if($dealId!='' && _isRecordExist('tbl_deals',$where))
        {
            $whereDeal="WHERE dealStatus !='Deleted' AND dealId=$dealId";
            $dealInfo=$this->admin_model->getDealList($whereDeal);
            $info=$dealInfo[0];
            $data=array('action'=>'edit','dealId'=>$info['dealId'],'dealBusinessId'=>$info['dealBusinessId'],'dealOverview'=>$info['dealOverview'],
                'dealDetails'=>$info['dealDetails'],'dealValue'=>$info['dealValue'],'dealDiscounts'=>$info['dealDiscounts'],
                'dealSavings'=>$info['dealSavings'],'dealFinalPrice'=>$info['dealFinalPrice'],'dealLimit'=>$info['dealLimit'],
                'dealExpirationDate'=>$info['dealExpirationDate'],'dealImage'=>$info['dealImage'],'newImageError'=>'','editImageError');

            $this->form_validation->set_rules('dealBusinessId', 'Business Name', 'xss_clean|trim|required');
            $this->form_validation->set_rules('dealOverview', 'Ovewview', 'xss_clean|trim|required');
            $this->form_validation->set_rules('dealDetails', 'Details', 'xss_clean|trim|required');
            $this->form_validation->set_rules('dealValue', 'Value', 'xss_clean|trim|numeric|required');
            $this->form_validation->set_rules('dealDiscounts', 'Discount', 'xss_clean|numeric');
            $this->form_validation->set_rules('dealSavings', 'Saving', 'xss_clean|numeric');
            $this->form_validation->set_rules('dealFinalPrice', 'Final Price', 'xss_clean|numeric');
            $this->form_validation->set_rules('dealExpirationDate', 'Expity date', 'xss_clean|required');
            $this->form_validation->set_rules('dealLimit', 'Limits', 'xss_clean');
            if ($this->form_validation->run() == FALSE){                
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/manage_deals_add_edit_vw',$data);
                $this->load->view('admin/includes/footer');
            }else{
                //get user id
                $selecteBusinessId=$this->input->post('dealBusinessId');
                $BusinessInfo=$this->mdgeneraldml->select('user_id','tbl_business_info',array('buss_id'=>$selecteBusinessId));
                $businessUserId=$BusinessInfo[0]['user_id'];
                $insertData=array(   
                       'dealUserId'=>$businessUserId,
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

                
                    $fileName=$_FILES['dealImage']['name'];
                    $ulpadFlag=true;
                    if($fileName!="")
                    {    
                        $re['upload_response'] = $this->do_upload($forcedWidth=361, $forcedHeight=214);
                        if(isset($re['upload_response']['error'])){
                            $ulpadFlag=false;
                        }else{
                            $dealImage=$re['upload_response']['resized_imageName'];
                            $insertData['dealImage']=$dealImage;
                        }
                    }

                   if($ulpadFlag==false)
                   {
                       $data['newImageError'] = $re['upload_response']['error'];                      
                       $this->load->view('admin/includes/header');	
                        $this->load->view('admin/manage_deals_add_edit_vw',$data);
                        $this->load->view('admin/includes/footer');
                   }else{                       
                       $this->mdgeneraldml->update($where,'tbl_deals',$insertData);                       
                       $this->session->set_flashdata('success','Deal has been successfully updated.');
                       redirect(ADMIN_FOLDER_NAME.'/manage_deals/edit/'.$dealId.'/'.$sort_by.'/'.$sort_type.'/'.$offset);
                   }
            }        
        }
        else{
            $this->session->set_flashdata('error','Deal not exit.');
           redirect(ADMIN_FOLDER_NAME.'/manage_deals');
        }
    }   
    
    function getDeal($dealId)
    {
        $user_id=$this->session->userdata('user_id');
        if($dealId!='' && _isRecordExist('tbl_deals',array('dealUserId'=>$user_id,'dealId'=>$dealId)))
        { 
            $where="WHERE d.dealUserId=$user_id AND dealId=$dealId";
            $dealList = $this->admin_model->getDealList($where);
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
            $result['status']='success';
            echo json_encode($result);
        }else{
            $result['status']='fail';
            echo json_encode($result);
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
        $config['max_height'] = '300';
        $config['min_height'] = '285';
        $config['min_weight'] = '240';*/
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
            
            $config['width'] = $forcedWidth; //$finalWidth;
            $config['height'] = $forcedHeight; //$finalHeight;

            $uploadedImageWidth=$sourceSize[0];
            $uploadedImageHeight=$sourceSize[1];
            
            if($uploadedImageWidth<$forcedWidth || $uploadedImageHeight<$forcedHeight)
            {
                @unlink($sourceImage);
                return array('error' => "Please upload the image with the min width $forcedWidth and min height $forcedHeight");
            }
            
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
    
    
    function delete($dealId='',$sort_by='dealId', $sort_type='DESC', $offset=0)
    {
        $where=array('dealStatus !='=>'Deleted','dealId'=>$dealId);
        if($dealId!='' && _isRecordExist('tbl_deals',$where))
        {
            $status=$this->input->post('status');            
            $updataeData=array('dealStatus'=>'Deleted','dealUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_deals', $updataeData);
            $this->session->set_flashdata('success',"Deal deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_deals/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_deals/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        } 
    }
    
    function delete_selected($sort_by='dealId', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST))
        {            
            $whereIn=array('column'=>'dealId','fields'=>$_POST['chkmsg']);
            $updataeData=array('dealStatus'=>'Deleted','dealUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update_in('tbl_deals', $updataeData,'',$whereIn);
            //echo $this->db->last_query();
            $this->session->set_flashdata('success',"selected deals has been deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_deals/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Please select at list single record.');
            redirect(ADMIN_FOLDER_NAME.'/manage_deals/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }    
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */