<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model
        $this->load->library("geozip");
        $this->load->model('website_general_model', 'WGModel');
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');        
    }

    public function index() {        
        $where = array('catStatus' => 'Active');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        $this->load->view('includes/header', $data);
        $this->load->view('home_view');
        $this->load->view('includes/footer');
    }
    
    function business_list($cat_id=NULL, $num=9,$providername='all')
    {  
        //Get All businesses by category ID          
        $tbl_business_info = 'tbl_business_info';
        $where_cat_id = array('buss_category' => $cat_id);

        if ($num == NULL)
        {
            $num = 0;           
        }
        else
        {
            $num = $num;          
        }
            
       $join[1]=array('tableName' => 'tbl_ratings', 'columnNames' => 'tbl_ratings.buss_id = tbl_business_info.buss_id','jType'=>'LEFT');
       $bus_Info = $this->mdgeneraldml->select1('tbl_business_info.*, tbl_ratings.user_id as rat_uid , tbl_ratings.rat_id,tbl_ratings.rat_stars', $tbl_business_info, $where_cat_id, '',$num,0,$join,1);
      // echo $this->db->last_query();
      // die;
        $data['bus_list'] = $bus_Info;
        $data['current_count'] = count($bus_Info);
        //echo '<pre>'; print_r($data['bus_list']); die;
        //Total Count
        $all_bus_Info = $this->mdgeneraldml->select('*', $tbl_business_info, $where_cat_id);
        $data['total_count'] = count($all_bus_Info);


        //Get Category Name        
        $cnd = "catId = '" . $cat_id . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['catId'] = $cat_name[0]['catId'];
        $data['buss_category'] = $cat_name[0]['catName'];
        
         //Get User Ratings for busness      
        if (($this->session->userdata('user_id') != "")){
             $where_user_id = "user_id = '" . $this->session->userdata('user_id') . "' ";
             $ratings_by_user_id = $this->mdgeneraldml->select('*', 'tbl_ratings', $where_user_id);
             $data['ratings_by_user']=$ratings_by_user_id;
        }
        else
        {
            $data['ratings_by_user']='';
        }
        
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }        
        
        $data['myZipCode']=$myZipCode;
        
        //Load $data in view
        $this->load->view('includes/header');
        $this->load->view('business_lists_view', $data);
        $this->load->view('includes/footer');
    }
    
     function search_by_zipcode($limit=9)
    {
       
        $zipCode=$this->session->userdata('homeSrhBussZipCode');
        if(!empty($_POST))
        {   
            $zipCode=$_POST['srhBussZipcode'];
            $this->session->set_userdata('homeSrhBussZipCode',$zipCode);
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Zip','sthFromPage'=>'business','srhKeywords'=>$zipCode,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
                $this->mdgeneraldml->insert('tbl_search',$inserSearchData);
            }
        }
        
        if($zipCode!=""){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $whereSearchBusiness="WHERE buss_zip_code in($zipCodesString)";
            }else{
                $whereSearchBusiness="WHERE buss_zip_code=$zipCode";
            }
            //echo '<pre>'; print_r($zipCodesArray);
        }else{
            $whereSearchBusiness="";
        }
        
       $bus_Info=$this->WGModel->getBusinessInfoList($whereSearchBusiness,'','',$limit,0);
       //echo $this->db->last_query();
       //echo '<pre>'; print_r($bus_Info); die;
       
        $data['bus_list'] = $bus_Info;
        $data['current_count'] = count($bus_Info);

        //Total Count
        $businessCount=$this->WGModel->sqlQuery("SELECT count(*) as totalBusiness from tbl_business_info $whereSearchBusiness");
        $data['total_count'] =$businessCount[0]['totalBusiness'];

        //Get Category Name        
        /*$cnd = "catId = '" . $catId . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['catId'] = $cat_name[0]['catId'];
        $data['buss_category'] = $cat_name[0]['catName'];*/
        
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }        
        
        $data['myZipCode']=$myZipCode;
        //Load $data in view
        $this->load->view('includes/header');
        $this->load->view('search/business_listing_search_for_home_vw', $data);
        $this->load->view('includes/footer');
           
    }
    
    function search_by_provider($limit=9)
    {   
        $propertySearchText=$this->session->userdata('homePropertySearchText');
        if(!empty($_POST))
        {   
            $propertySearchText=$_POST['propertySearchText'];
            $this->session->set_userdata('homePropertySearchText',$propertySearchText);
            
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Privider','sthFromPage'=>'business','srhKeywords'=>$propertySearchText,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
                $this->mdgeneraldml->insert('tbl_search',$inserSearchData);
            }
        }
        
        if($propertySearchText!=""){
            $whereSearchBusiness="WHERE buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%'";            
        }else{
            $whereSearchBusiness="WHERE buss_category=$catId";
        }
        
       $bus_Info=$this->WGModel->getBusinessInfoList($whereSearchBusiness,'','',$limit,0);
       //echo $this->db->last_query();
       //echo '<pre>'; print_r($bus_Info); die;
       
        $data['bus_list'] = $bus_Info;
        $data['current_count'] = count($bus_Info);

        //Total Count
        $businessCount=$this->WGModel->sqlQuery("SELECT count(*) as totalBusiness from tbl_business_info $whereSearchBusiness");
        $data['total_count'] =$businessCount[0]['totalBusiness'];

        //Get Category Name        
       /* $cnd = "catId = '" . $catId . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['catId'] = $cat_name[0]['catId'];
        $data['buss_category'] = $cat_name[0]['catName'];*/
        
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }        
        
        $data['myZipCode']=$myZipCode;
        //Load $data in view
        $this->load->view('includes/header');
        $this->load->view('search/business_listing_search_for_home_vw', $data);
        $this->load->view('includes/footer');
           
    }
    public function business_details($bus_id=NULL,$id='')
    {
        $data=$this->__getBusinessDetails($bus_id);
        $user_login_id = $this->session->userdata('user_id');
        $where_bus_id = array('business_id' => $bus_id,'user_id'=>$user_login_id);
        $data['fav_Info'] = $this->mdgeneraldml->select('*', 'tbl_user_favorite_business', $where_bus_id);
        $data['id'] = $id;
        $data['bus_id'] = $bus_id;
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }        
        
        $data['myZipCode']=$myZipCode;
        
        $this->load->view('includes/header');
        $this->load->view('business_details_view', $data);
        $this->load->view('includes/footer');
    }
    function add_into_favorite()
	{
		$user_login_id = $this->session->userdata('user_id');
		 $insertData = array('business_id'=>$_POST['business_id'],'business_user_id'=>$_POST['b_user_id'],'user_id'=>$user_login_id,'status'=>'1','created_date'=>date('Y-m-d h:i:s'));
		 $this->mdgeneraldml->insert('tbl_user_favorite_business', $insertData);
		 $out_arr['frm_status'] = 'true';
     	echo json_encode($out_arr);
	}
    function review_details($rvwId=NULL)
    {
        $where=array('rvwId'=>$rvwId,'rvwStatus !='=>'Deleted');
        if($rvwId!=NULL && _isRecordExist('tbl_business_reviews',$where))
        {  
            $data['info']=$this->WGModel->getBusinessReviews("WHERE rvwId=$rvwId");
            $this->load->view('includes/header');
            $this->load->view('review_details_vw', $data);
            $this->load->view('includes/footer');
        }else{
            $this->session->set_flashdata('error','Review not exist');
            redirect('home');
        }   
    }
    
    function __getBusinessDetails($bus_id){
        
        $data=array(            
            'businessId'=>$bus_id,
            'rvwReviewerName'=>'Enter Reviewer Contact Name',
            'rvwPhoneNo'=>'Enter Your Phone Number',
            'rvwEmail'=>'Enter Reviewer Email Address',
            'rvwDetails'=>'Write your experience here'           
        );
        $tbl_business_info = 'tbl_business_info';
        $where_bus_id = array('buss_id' => $bus_id);
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_business_info, $where_bus_id);
        $info = $bus_Info[0];
        $data['info'] = $info;
       

        //Get Category Name
        $cnd = "catId = '" . $info['buss_category'] . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['buss_category'] = $cat_name[0]['catName'];

        //get deals
        $whereDeals="WHERE dealBusinessId=$bus_id";
        $data['dealList'] = $this->WGModel->getDealList($whereDeals);
        
        //get jobs
        $whereJobs="WHERE jobBusinessId=$bus_id AND jobStatus!='Deleted'";
        $data['jobList']=$this->WGModel->getJobList($whereJobs);
        
        //get reviews
        $whereReviews="WHERE rvwBusinessId=$bus_id AND rvwStatus='Active'";
        $data['reviewList']=$this->WGModel->getBusinessReviews($whereReviews);
      
        return $data;
    }
    

    function add_business_review($bus_id){    
        
        $this->form_validation->set_error_delimiters('<span class="businessReviewFormError">', '</span>');
        
        $data=$this->__getBusinessDetails($bus_id);
        
        $this->form_validation->set_rules('rvwBusinessId', 'Business Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('rvwCategoryId', 'Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('rvwReviewerName', 'Reviewer Name', 'xss_clean|trim|required|callback_rvwReviewerNameChk');
        $this->form_validation->set_rules('rvwPhoneNo', 'Phone number', 'xss_clean|trim|required|callback_rvwPhoneChk');
        $this->form_validation->set_rules('rvwEmail', 'Email address', 'xss_clean|trim|required|valid_email|callback_rvwEmailAddressChk');
        $this->form_validation->set_rules('rvwRatingProfessionalism', 'Professionalism', 'xss_clean|trim|required');
        $this->form_validation->set_rules('rvwRatingDependability', 'Dependability', 'xss_clean|trim|required');
        $this->form_validation->set_rules('rvwRatingPrice', 'Price', 'xss_clean|trim|required');
        $this->form_validation->set_rules('rvwRatingOverall', 'Overall', 'xss_clean|trim|required');        
        $this->form_validation->set_rules('rvwDetails', 'Details', 'xss_clean|trim|required|callback_rvwDetailsChk');   
        if($this->form_validation->run() == FALSE){            
            $this->load->view('includes/header');
            $this->load->view('business_details_view', $data);
            $this->load->view('includes/footer');             
        }else{
            $inserData=array(
                'rvwBusinessId'=>$bus_id,
                'rvwBusinessUserId'=>$data['info']['user_id'],
                'rvwCategoryId'=>$data['info']['buss_category'],
                'rvwReviewerName'=>$this->input->post('rvwReviewerName'),
                'rvwPhoneNo'=>$this->input->post('rvwPhoneNo'),
                'rvwEmail'=>$this->input->post('rvwEmail'),
                'rvwRatingProfessionalism'=>$this->input->post('rvwRatingProfessionalism'),
                'rvwRatingDependability'=>$this->input->post('rvwRatingDependability'),
                'rvwRatingPrice'=>$this->input->post('rvwRatingPrice'),
                'rvwRatingOverall'=>$this->input->post('rvwRatingOverall'),
                'rvwDetails'=>$this->input->post('rvwDetails'),
                'rvwStatus'=>'Pending',
                'rvwCreatedOn'=>_getDateAndTime(),                
            );
            $this->mdgeneraldml->insert('tbl_business_reviews', $inserData);

            //send Email
            $bussiness_name =$data['info']['buss_name'];
            $reviwer_name =$this->input->post('rvwReviewerName');
            $rev_phno =$this->input->post('rvwPhoneNo');
            $rev_email =$this->input->post('rvwEmail');
            $rate_pro=$this->input->post('rvwRatingProfessionalism');
            $rate_depend=$this->input->post('rvwRatingDependability');
            $rate_price=$this->input->post('rvwRatingPrice');
            $rate_overall=$this->input->post('rvwRatingOverall');
            $rate_details=$this->input->post('rvwDetails');

            $where_Id=array('emailId'=>'114');
            $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                    
            $emilTemplet=$emailinfo[0]['emailBody'];
            $emilTempletSubject=$emailinfo[0]['emailSubject'];
            $bussiness_name;
            $emailBody=str_replace ("[[REVIWER_NAME]]", $reviwer_name, $emilTemplet);
            $emailBody=str_replace ("[[BUSSINESS_NAME]]", $bussiness_name, $emailBody);
            $emailBody=str_replace ("[[PHONE_NUMBER]]", $rev_phno, $emailBody);
            $emailBody=str_replace ("[[EMAIL_ADDRESS]]", $rev_email, $emailBody);
            $emailBody=str_replace ("[[RATE_PROF]]", $rate_pro, $emailBody);
            $emailBody=str_replace ("[[RATE_DEPEND]]", $rate_depend, $emailBody);
            $emailBody=str_replace ("[[RATE_PRICE]]", $rate_price, $emailBody);
            $emailBody=str_replace ("[[RATE_OVERALL]]", $rate_overall, $emailBody);
            $emailBody=str_replace ("[[REV_DETAILS]]", $rate_details, $emailBody);
            @send_email(ADMIN_EMAIL,$emilTempletSubject,$emailBody);

            $where_userId=array('user_id'=> $data['info']['user_id']);
            $userinfo=$this->mdgeneraldml->select('*','tbl_user',$where_userId);
            $user_name=$userinfo[0]['user_name'];
            $user_email=$userinfo[0]['user_email'];

            if($userinfo)
            {
                $where_Id=array('emailId'=>'113');
                $emailuserinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                    
                $emilTemplet=$emailuserinfo[0]['emailBody'];
                $emilTempletSubject=$emailuserinfo[0]['emailSubject'];

                $emailBody=str_replace ("[[REVIWER_NAME]]", $reviwer_name, $emilTemplet);
                $emailBody=str_replace ("[[USER_NAME]]", $user_name, $emailBody);
                $emailBody=str_replace ("[[BUSSINESS_NAME]]", $bussiness_name, $emailBody);
                $emailBody=str_replace ("[[PHONE_NUMBER]]", $rev_phno, $emailBody);
                $emailBody=str_replace ("[[EMAIL_ADDRESS]]", $rev_email, $emailBody);
                $emailBody=str_replace ("[[RATE_PROF]]", $rate_pro, $emailBody);
                $emailBody=str_replace ("[[RATE_DEPEND]]", $rate_depend, $emailBody);
                $emailBody=str_replace ("[[RATE_PRICE]]", $rate_price, $emailBody);
                $emailBody=str_replace ("[[RATE_OVERALL]]", $rate_overall, $emailBody);
                $emailBody=str_replace ("[[REV_DETAILS]]", $rate_details, $emailBody);
               
                @send_email($user_email,$emilTempletSubject,$emailBody);
            }
             $this->session->set_flashdata('success','Your review has been added successfully. It will go live within 24 hours following Verification');
            redirect('home/business_details/'.$bus_id.'/#success');
        }
    }
    
    function rvwReviewerNameChk($str){
        if ($str == 'Enter Reviewer Contact Name'){            
            $this->form_validation->set_message('rvwReviewerNameChk', 'Reviewer name field is required');
            return FALSE;
        }
        else
            return TRUE;
    }
    
    function rvwPhoneChk($str){
        if ($str == 'Enter Your Phone Number'){
            $this->form_validation->set_message('rvwPhoneChk', 'Phone number field is required');
            return FALSE;
        }
        else
            return TRUE;
    }
    
    function rvwEmailAddressChk($str){
        if ($str == 'Enter Reviewer Email Address'){
            $this->form_validation->set_message('rvwEmailAddressChk', 'Email address field is required');
            return FALSE;
        }
        else
            return TRUE;
    }
    
   function rvwDetailsChk($str){
        if ($str == 'Write your experience here'){
            $this->form_validation->set_message('rvwDetailsChk', 'Details field is required');
            return FALSE;
        }
        else
            return TRUE;
    }
    
    function job_view($jobId=NULL)
    {
        $where=array('jobId'=>$jobId,'jobStatus !='=>'Deleted');
        if($jobId!=NULL && _isRecordExist('tbl_jobs',$where))
        {  
            $data=$this->__getJobInfo($jobId);
            $this->load->view('includes/header');
            $this->load->view('job_details_vw', $data);
            $this->load->view('includes/footer');
        }else{
            $this->session->set_flashdata('error','Job not exist');
            redirect('home');
        }   
    }
    
    function apply_today($jobId=NULL)
    {
        $where=array('jobId'=>$jobId,'jobStatus !='=>'Deleted');
        if($jobId!=NULL && _isRecordExist('tbl_jobs',$where))
        {  
            $data=$this->__getJobInfo($jobId);
            //echo '<pre>'; print_r($data); die;
              
               
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
            
            $this->form_validation->set_rules('jAppApplicantFullName', 'Full Name', 'xss_clean|trim|required|max_length[60]');
            $this->form_validation->set_rules('jAppApplicantAddress', 'Address', 'xss_clean|trim|required|max_length[120]');
            $this->form_validation->set_rules('jAppApplicantCity', 'City', 'xss_clean|trim|required|alpha|max_length[40]');
            $this->form_validation->set_rules('jAppApplicantState', 'State', 'xss_clean|trim|required|alpha|max_length[40]');
            $this->form_validation->set_rules('jAppApplicantZipCode', 'Zip Code', 'xss_clean|trim|required|numeric|max_length[8]');
            $this->form_validation->set_rules('jAppApplicantPhone', 'Phone Number', 'xss_clean|trim|required|max_length[10]');
            $this->form_validation->set_rules('jAppApplicantFax', 'Fax', 'xss_clean|trim|numeric|max_length[10]');
            $this->form_validation->set_rules('jAppApplicantEmail', 'Email', 'xss_clean|trim|required|valid_email|max_length[60]');
            $this->form_validation->set_rules('jAppApplicantResume', 'Resume', 'xss_clean');
            $this->form_validation->set_rules('jAppApplicantCoverLetter', 'Cover Letter', 'xss_clean');
            if($this->form_validation->run() == FALSE){
                $this->load->view('includes/header');
                $this->load->view('job_details_vw', $data);
                $this->load->view('includes/footer');
            }
            else{
                
                $businessId=$data['companyInfo'][0]['buss_id'];
                $business_email=$data['companyInfo'][0]['buss_email'];
                $categoryId=$data['companyInfo'][0]['buss_category'];
                $userId=$this->session->userdata('user_id');
                //echo '<pre>';
                //  print_r($_POST);
                $insertData=array(
                    'jAppJobId'             =>$jobId,
                    'jAppBusinessId'        =>$businessId,
                    'jAppCatId'             =>$categoryId,
                    'jAppApplicantUserId'   =>$userId,
                    'jAppApplicantFullName' =>$this->input->post('jAppApplicantFullName'),
                    'jAppApplicantAddress'  =>$this->input->post('jAppApplicantAddress'),
                    'jAppApplicantCity'     =>$this->input->post('jAppApplicantCity'),
                    'jAppApplicantState'    =>$this->input->post('jAppApplicantState'),
                    'jAppApplicantZipCode'  =>$this->input->post('jAppApplicantZipCode'),
                    'jAppApplicantPhone'    =>$this->input->post('jAppApplicantPhone'),
                    'jAppApplicantFax'      =>$this->input->post('jAppApplicantFax'),
                    'jAppApplicantEmail'    =>$this->input->post('jAppApplicantEmail'),
                    'jAppApplicantResume'   =>'',
                    'jAppApplicantCoverLetter'=>'',
                    'jAppCreatedOn'         =>_getDateAndTime(),
                    'jAppUpdatedOn'         =>_getDateAndTime()                    
                );
                
               $response=$this->mdgeneraldml->insert('tbl_job_applications',$insertData);//last_insertId

               //send email
               $businessname=$data['companyInfo'][0]['buss_name'];
               $jobtitle=$data['jobList'][0]['jobTitle'];
               $jAppApplicantFullName=$this->input->post('jAppApplicantFullName');
               $jAppApplicantEmail=$this->input->post('jAppApplicantEmail');
               $jAppApplicantPhone=$this->input->post('jAppApplicantPhone');

                $where_Id=array('emailId'=>'112');
                $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
                        
                $emilTemplet=$emailinfo[0]['emailBody'];
                $emilTempletSubject=$emailinfo[0]['emailSubject'];
                
                $emailBody=str_replace ("[[USER_FULL_NAME]]", $jAppApplicantFullName, $emilTemplet);
                $emailBody=str_replace ("[[BUSS_NAME]]", $businessname, $emailBody);
                $emailBody=str_replace ("[[JOB_TITLE]]", $jobtitle, $emailBody);
                $emailBody=str_replace ("[[USER_PHONE_NUMBER]]", $jAppApplicantEmail, $emailBody);
                $emailBody=str_replace ("[[EMAIL_ADDRESS]]", $jAppApplicantPhone, $emailBody);
                @send_email($business_email,$emilTempletSubject,$emailBody);
               
               $this->session->set_flashdata('success','Your have successfully applied for this job.');
               redirect('home/job_view/'.$jobId.'#success');
            }
        }else{
            $this->session->set_flashdata('error','Job not exist');
            redirect('home');
        } 
    }
    
    function __getJobInfo($jobId){
        
        $data=array('jAppApplicantFullName'=>'','jAppApplicantAddress'=>'','jAppApplicantCity'=>'','jAppApplicantState'=>'',
            'jAppApplicantZipCode'=>'','jAppApplicantPhone'=>'','jAppApplicantFax'=>'','jAppApplicantEmail'=>'','jAppApplicantResume'=>'',
            'jAppApplicantCoverLetter'=>'');
        
        //get single job info
        $where="WHERE jobStatus!='Deleted' AND jobId=$jobId";
        $data['jobList'] = $this->WGModel->getJobList($where);

        $businessId=$data['jobList'][0]['jobBusinessId'];
        
        //get compony and category info
        $where="WHERE buss_id=$businessId";
        $data['companyInfo'] = $this->WGModel->getBusinessInfoList($where);
        
        //get job list og simillar jobs
        //$where=array(''=>$data['companyInfo'][0]['buss_category']);
        //$data['similarJobList'] = $this->WGModel->getJobList($where);
        return $data;
    }

    //Services Page
    public function services() {               //Get subscription plans
        $tbl_subscription_plans = 'tbl_subscription_plans';
        $data['plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_plans);

        $data['basic_plan_name'] = $data['plan_details'][0]['subs_plan_name'];
        $data['prem_plan_name'] = $data['plan_details'][1]['subs_plan_name'];



        //Get sub-subscription plans
        $tbl_subscription_sub_plans = 'tbl_subscription_sub_plans';
        $data['sub_plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_sub_plans);

        //basic Annually 
        $data['basic_plan_annual_name'] = $data['sub_plan_details'][0]['subs_sub_plan_name'];
        $data['basic_plan_annual_price'] = $data['sub_plan_details'][0]['subs_sub_plan_price'];
        //basic Monthly
        $data['basic_plan_monthly_name'] = $data['sub_plan_details'][1]['subs_sub_plan_name'];
        $data['basic_plan_monthly_price'] = $data['sub_plan_details'][1]['subs_sub_plan_price'];
        //premium Annually                                
        $data['prem_plan_annual_name'] = $data['sub_plan_details'][2]['subs_sub_plan_name'];
        $data['prem_plan_annual_price'] = $data['sub_plan_details'][2]['subs_sub_plan_price'];
        //premium Monthly
        $data['prem_plan_monthly_name'] = $data['sub_plan_details'][3]['subs_sub_plan_name'];
        $data['prem_plan_monthly_price'] = $data['sub_plan_details'][3]['subs_sub_plan_price'];


        //Get service limit Details
        $tbl_service_limits = 'tbl_service_limits';
        $in_para = array('service_id');
        $where_not_in = array('service_id' => array(13, 14));
        $data['service_limits'] = $this->mdgeneraldml->select_not_in('*', $tbl_service_limits, $in_para, $where_not_in);
        // echo $this->db->last_query(); die;
        // echo '<pre>'; print_r($data); die;

        $this->load->view('includes/header');
        $this->load->view('services_view', $data);
        $this->load->view('includes/footer');
    }

    //Deals And Coupons Page
    public function deals_coupons() {
        $this->load->view('includes/header');
        $this->load->view('deals_coupons_view');
        $this->load->view('includes/footer');
    }

    //We Are Hiring Page  
    public function we_are_hiring() {
        $this->load->view('includes/header');
        $this->load->view('we_are_hiring_view');
        $this->load->view('includes/footer');
    }

    //FAQ Page
    public function faq() {
        $sql = "SELECT pageContent FROM tbl_static_pages WHERE pageId=100";
        $where = array('pageId' => '100');
        $data['pageInfo'] = $this->mdgeneraldml->select('*', 'tbl_static_pages', $where);
        $this->load->view('includes/header');
        $this->load->view('faq_view', $data);
        $this->load->view('includes/footer');
    }

    //Contact us Page
    public function contact_us() {
        $this->load->view('includes/header');
        $this->load->view('contact_us_view');
        $this->load->view('includes/footer');
    }

    //User Registration
    public function register() {
        //echo 'hellow im here....'; exit;
        $sess_arr = array(
            "uname" => $_POST['uname'],
            "email" => $_POST['email']);
        $this->session->set_userdata($sess_arr);
        $field_data = array('user_name' => $this->input->post('uname'),
            'user_email' => $this->input->post('email'),
            'user_password' => MD5($this->input->post('password')),
            'user_registered_date' => date('Y-m-d'),
            'user_update_date' => date('Y-m-d'),
            'user_acc_status' => "I",
            'act_link_click_status' => 1,
            'user_plan' => '',
            'user_type' => "site_user"
        );
        $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
        $last_ins_id = $data['last_insertId'];

        //Send Email
        $uname = $this->input->post('uname');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        /*  $subject = "Registration Details";
          $msg = "Hello " . $uname . ",<br><br>";
          $msg.= "Thanks for Registration" . "<br><br>";
          $msg.= "Your Deatils are : " . "<br><br>";
          $msg.= "User Name: " . $uname . "<br>";
          $msg.="Email: " . $email . "<br>";
          $msg.="Password: " . $password . "<br>"; */

        $encryption_str = $uname . "/" . $data['last_insertId'];
        $enc_text = base64_encode($encryption_str);
        /*  $msg.= "Thanks" . ".<br>";
          $msg.= "WOM Team " . ",<br>";
          $msg.="Login and Activate Your Account From The Given Link:  " . "<br>";
          $msg.="<a href='".base_url()."user/activated_user/".$enc_text."' target='_blank'> Activate Me </a>";
          sendEmail($uname, $email, $subject, $msg); */
        if ($data !== 0) {
            echo "true," . base_url() . "user/activated_user/" . $enc_text;
        } else {
            echo "false";
        }
    }

    //User Registration Step 2
    public function register_step2() {
        if (isset($_POST['submit'])) {
            if (isset($_POST['inter'])) {
                $inter = implode(",", $_POST['inter']);
            } else {
                $inter = "";
            }

            if ($_POST['subscr'] == 'on') {
                $subscr = 1;
            } else {
                $subscr = 0;
            }


            $field_data = array('user_fname' => $this->input->post('fname'),
                'user_lname' => $this->input->post('lname'),
                'user_phone' => $this->input->post('phone'),
                'user_city' => $this->input->post('city'),
                'user_address' => $this->input->post('uaddress'),
                'user_address_addon' => $this->input->post('uaddressaddon'),
                'user_zipcode' => $this->input->post('uzipcode'),
                'user_state' => $this->input->post('state'),
                'user_country' => $this->input->post('country'),
                'user_interest' => $inter,
                'user_newslet_sub' => $subscr
            );

            $where = array("user_email" => $this->session->userdata('email'));
            $data = $this->mdgeneraldml->update($where, 'tbl_user', $field_data);
            if ($data !== 0) {
                $this->session->unset_userdata('uname');
                $this->session->unset_userdata('email');
                $url = base_url() . 'user/home';
                echo "<script>alert('Account Information Updated Successfully.');window.location.href='$url'</script>";
                //echo "<script>document.getElementById('light_step2').style.display='block';document.getElementById('fade').style.display='block';</script>";                         
            }
        }
        if (isset($_POST['skip'])) {
            $this->session->unset_userdata('uname');
            $this->session->unset_userdata('email');
            redirect(base_url() . 'user/home');
        }
    }

    //Activate user                
    function activated_user($act_enc_text_return) {

        //Decrypt the url (User_Name and user_id)
        $act_decrypt_str = base64_decode($act_enc_text_return);
        $act_user_info_arr = explode("/", $act_decrypt_str);
        // echo $act_decrypt_str;
        //Get users ID
        $tbl = "tbl_user";
        $cnd = "user_id = '" . $act_user_info_arr[1] . "' ";
        $res_id_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        if (count($res_id_chk) > 0) {
            if ($res_id_chk[0]['act_link_click_status'] == 0) {
                echo "Link Expired";
            } else {
                if ($act_user_info_arr[1] == $res_id_chk[0]['user_id']) {

                    $sess_arr = array(
                        "user_id" => $res_id_chk[0]['user_id'],
                        "user_email" => $res_id_chk[0]['user_email'],
                        "user_name" => $res_id_chk[0]['user_name']
                    );
                    $this->session->set_userdata($sess_arr);
                    //Update Link Status to 0 (0 is for Link Expired)
                    $uid = $res_id_chk[0]['user_id'];
                    $uid_select = array("user_id" => $uid);
                    $tbl1 = "tbl_user";
                    $where = $uid_select;
                    $link_st = array("act_link_click_status" => 0);
                    $this->mdgeneraldml->update($where, $tbl1, $link_st);
                    $change_status = array("user_acc_status" => 'A', "user_last_login_on" => date('Y-m-d H:i:s'));
                    $this->mdgeneraldml->update($where, $tbl1, $change_status);
                    // redirect(base_url().'user/home');
                    redirect(base_url() . 'dashboard/account_overview');
                }
            }
        } else {
            echo "ERROR : NO ACCOUNT INFO AVAILABLE";
        }
    }

    // Check Duplicate Email
    public function check_email_dup() {
        $tbl = "tbl_user";
        $cnd = "user_email = '" . $this->input->post('email') . "' ";
        $res_mail_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
        if (count($res_mail_chk) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    // Check Duplicate Username
    public function check_uname_dup() {
        $tbl = "tbl_user";
        $cnd = "user_name = '" . $this->input->post('uname') . "' ";
        $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
        if (count($res_name_chk) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    //Login user
    public function login_user() {
        $userfield = $this->input->post('uemail');
        $userpwd = $this->input->post('upassword');

        if (!filter_var($userfield, FILTER_VALIDATE_EMAIL)) {
            $username = $userfield;
            $tbl = "tbl_user";
            $cnd = "user_name = '" . $username . "'";
            $db_det = $this->db_transact_model->get_single_record($tbl, $cnd);
            //print_r($_POST);print_r($db_det);die;
            if (!empty($db_det)) {
                if ($db_det[0]['user_acc_status'] == "A") {
                    if ($db_det[0]['user_password'] == MD5($userpwd)) {
                        $sess_arr = array(
                            "user_id" => $db_det[0]['user_id'],
                            "user_email" => $db_det[0]['user_email'],
                            "user_name" => $db_det[0]['user_name'],
                            "user_type" => $db_det[0]['user_type']
                        );
                        $this->session->set_userdata($sess_arr);

                        //  echo $this->session->userdata('user_id');die;
                        if ($this->input->post('rem_check', true)) {
                            $val = $db_det[0]['user_email'] . "/" . $userpwd;
                            $cookie = array(
                                'name' => 'mem_login_info',
                                'value' => $val,
                                'expire' => '604800');
                            $this->input->set_cookie($cookie);
                        }
                        //Update Login user Date and Time
                        $uid_select = array("user_id" => $db_det[0]['user_id']);
                        $where = $uid_select;
                        $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                        $this->mdgeneraldml->update($where, $tbl, $change_login_time);
                        // redirect(base_url().'user/home');   
                        // redirect(base_url() . 'dashboard/account_overview'); 
                        //echo "true,ok";   
                        if ($this->session->userdata('user_type') == 'buss_user')
                            echo "true_bus_user,ok";
                        else
                            echo "true_site_user,ok";
                    }
                    else {
                        /* $url= base_url().'user/home';   
                          echo "<script>alert('Your Password Not Matching!');window.location.href='$url'</script>"; */
                        echo "false,Your Password Not Matching!";
                    }
                } else {
                    /* $url= base_url().'user/home';   
                      echo "<script>alert('Your Account is Not Acivated Yet!');window.location.href='$url'</script>"; */
                    echo "false1,Your Account is Not Acivated Yet!";
                }
            } else {
                /* $url= base_url().'user/home';   
                  echo "<script>alert('Your Email Not Matching!');window.location.href='$url'</script>"; */
                echo "false2,Your User Name Not Matching!";
            }
        } else {
            $useremail = $userfield;
            $tbl = "tbl_user";
            $cnd = "user_email = '".$useremail."'";
            $db_det = $this->db_transact_model->get_single_record($tbl, $cnd);
            //print_r($_POST);print_r($db_det);die;
            if (!empty($db_det)) {
                if ($db_det[0]['user_acc_status'] == "A") {
                    if ($db_det[0]['user_password'] == MD5($userpwd)) {
                        $sess_arr = array(
                            "user_id" => $db_det[0]['user_id'],
                            "user_email" => $db_det[0]['user_email'],
                            "user_name" => $db_det[0]['user_name'],
                            "user_type" => $db_det[0]['user_type']
                        );
                        $this->session->set_userdata($sess_arr);
                        if ($this->input->post('rem_check', true)) {
                            $val = $useremail . "/" . $userpwd;
                            $cookie = array(
                                'name' => 'mem_login_info',
                                'value' => $val,
                                'expire' => '604800');
                            $this->input->set_cookie($cookie);
                        }
                        //Update Login user Date and Time
                        $uid_select = array("user_id" => $db_det[0]['user_id']);
                        $where = $uid_select;
                        $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                        $this->mdgeneraldml->update($where, $tbl, $change_login_time);
                        // redirect(base_url().'user/home');  
                        //   redirect(base_url() . 'dashboard/account_overview');
                        echo "true,ok";
                    } else {
                        /* $url= base_url().'user/home';   
                          echo "<script>alert('Your Password Not Matching!');window.location.href='$url'</script>"; */
                        echo "false,Your Password Not Matching!";
                    }
                } else {
                    /* $url= base_url().'user/home';   
                      echo "<script>alert('Your Account is Not Acivated Yet!');window.location.href='$url'</script>"; */
                    echo "false1,Your Account is Not Acivated Yet!";
                }
            } else {
                /* $url= base_url().'user/home';   
                  echo "<script>alert('Your Email Not Matching!');window.location.href='$url'</script>"; */
                echo "false2,Your User Name Not Matching!";
            }
        }
    }

    //Check user Present or not
    public function check_user_present() {
        $tbl = "tbl_user";

        //Get UserName
        $cnd = "user_name = '" . $this->input->post('uemail') . "' ";
        $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        //Get Email
        $cnd1 = "user_email = '" . $this->input->post('uemail') . "' ";
        $res_name_chk1 = $this->db_transact_model->get_single_record($tbl, $cnd1);

        if (count($res_name_chk) > 0) {
            if ($res_name_chk[0]['user_acc_status'] == "A") {
                echo "true";
            } else {
                echo "false";
            }
        } else if (count($res_name_chk1) > 0) {
            if ($res_name_chk1[0]['user_acc_status'] == "A") {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    public function check_user_active(){
        $tbl = "tbl_user";
        //Get UserName
        $cnd = "user_name = '" . $this->input->post('uemail') . "' ";
        $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        //Get Email
        $cnd1 = "user_email = '" . $this->input->post('uemail') . "' ";
        $res_name_chk1 = $this->db_transact_model->get_single_record($tbl, $cnd1);

        if (count($res_name_chk) > 0 || count($res_name_chk1) > 0) {
            if ($res_name_chk[0]['user_acc_status'] == "A" || $res_name_chk1[0]['user_acc_status'] == "A") {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }
    }

    //Check User Password
    public function check_user_password(){
        //Get DATA by Email
        $tbl = "tbl_user";
        $select = 'tbl_user.*';
        $uemail = $this->input->post('uemail');
        $upassword = $this->input->post('upassword');
        $cnd = array('tbl_user.user_email = ' => $uemail);
        $get_pass = $this->mdgeneraldml->select($select, $tbl, $cnd);

        //Get DATA by Username
        $cnd1 = array('tbl_user.user_name = ' => $uemail);
        $get_pass1 = $this->mdgeneraldml->select($select, $tbl, $cnd1);

        echo $uemail;
        echo "\n";
        echo $get_pass[0]['user_password'];
        echo "\n";
        echo $get_pass1[0]['user_password'];
        echo "\n";
        echo MD5($upassword);
        echo "\n";

        if (count($get_pass) > 0 || count($get_pass1)) {
            if ($get_pass[0]['user_password'] == MD5($upassword) || $get_pass1[0]['user_password'] == MD5($upassword)) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }
    }

    function connect(){
        $redirect_uri = site_url('fsignup.php'); //'http://server.ashoresystems.com/~adsmarke/fsignup.php';
        $url = "https://www.facebook.com/dialog/oauth?client_id=448194741967917&redirect_uri=$redirect_uri&scope=email,offline_access,user_birthday,status_update,publish_stream,manage_pages";
        redirect($url);
    }

    public function logout(){
        //$this->session->unset_userdata('mem_id','mem_email');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_type');

        delete_cookie('mem_login_info');
        redirect(base_url() . 'user/home');
    }

    function getCountrys(){
        $countryList = _getCountryList();
        $responseArray = array();

        foreach ($countryList as $key => $val) {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }
        echo json_encode($responseArray);
    }

    function getStateList($countryCode){
        //$st='id="userState" class="items"';//stateHolder
        // echo form_dropdown('userState', _getStateList($countryCode),set_value('userState'),'id="userState" class="items"'); 
        $stateList = _getStateList($countryCode);
        foreach ($stateList as $key => $val) {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */