<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Advance_search extends CI_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model	
        $this->load->model('mdgeneraldml');
        $this->load->model('website_general_model', 'WGModel');
        $this->load->library("geozip");
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index()
    {  
        $data=array(
            'zipCode'=>'','country'=>'','state'=>'','city'=>'',
            'radius'=>'','hasImage'=>'no','hasVideo'=>'no','hasOffers'=>'no','minRating'=>'',
        );
        $this->load->view('includes/header');
        $this->load->view('advance_search_vw', $data);
        $this->load->view('includes/footer');
    }
    
    function do_search()
    {
        $this->session->set_userdata('homePropertySearchText','');
        $this->session->set_userdata('homeSrhBussZipCode','');
       
		$data=array(
            'zipCode'=>'','country'=>'','state'=>'','city'=>'',
            'radius'=>'','hasImage'=>'no','hasVideo'=>'no','hasOffers'=>'no','minRating'=>'',
        );
        $zipCode    =$this->input->post('zipCode');
        $country    =$this->input->post('country');
        $state      =$this->input->post('state');
        $city       =$this->input->post('city');
        $radius     =$this->input->post('radius');
        $hasImage   =$this->input->post('hasImage');
        $hasVideo   =$this->input->post('hasVideo');
        $hasOffers  =$this->input->post('hasOffers');
        $minRating  =$this->input->post('minRating');
	$AdditionalInfo  =$this->input->post('hasAdditionalInfo');
		
		
		
        
        $whereSearchBusiness="WHERE bussStatus='Active' ";
        if($zipCode!=""){
            $miles=$radius;
            if($miles==""){
                $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
                $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            }
            
            
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                $whereSearchBusiness.="AND buss_zip_code in($zipCodesString)";
            }else{
                $whereSearchBusiness.="AND buss_zip_code=$zipCode";
            }
            //echo '<pre>'; print_r($zipCodesArray);
        }
        
        if($hasVideo=="yes"){           
                $whereSearchBusiness.=" AND buss_video !=''";
        }elseif($hasVideo=="no"){            
                $whereSearchBusiness.=" AND buss_video is null";
        }
        
        if($hasImage=="yes"){
            $whereSearchBusiness.=" AND buss_media_copy !=''";
        }elseif($hasImage=="no"){
            $whereSearchBusiness.=" AND buss_media_copy is null";
        }
        
        if($country!=""){
            $whereSearchBusiness.=" AND buss_country='".$country."'";
        }
        
        if($state!=""){
            $whereSearchBusiness.=" AND buss_state='".$state."'";
        }
        
        if($city!=""){
            $whereSearchBusiness.=" AND buss_city='".$city."'";
        }
        
        if($minRating!="" && $minRating!=0){
            $whereSearchBusiness.=" AND buss_avg_ratings >=$minRating";
        }
        
        if($hasOffers=="yes"){
            $whereSearchBusiness.=" AND bussHasDeal ='Yes'";
        }elseif($hasOffers=="no"){
            $whereSearchBusiness.=" AND bussHasDeal='No'";
        }
        
        $bus_Info=$this->WGModel->getBusinessInfoList($whereSearchBusiness);
        $data['bus_list'] = $bus_Info;
        $data['current_count'] = count($bus_Info);
        //echo $this->db->last_query(); die;
        //echo $whereSearchBusiness; die;
        //Total Count
        $businessCount=$this->WGModel->sqlQuery("SELECT count(*) as totalBusiness from tbl_business_info $whereSearchBusiness");
        $data['total_count'] =$businessCount[0]['totalBusiness'];
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }        
        
        $data['myZipCode']=$myZipCode;
		if(!empty($zipCode) || !empty($country) || !empty($state) || !empty($city)|| !empty($radius) || !empty($hasImage) || !empty($hasVideo) || !empty($AdditionalInfo) || !empty($hasOffers) || !empty($minRating))
		{
			$insertData=array(
           'user_id'=>$this->session->userdata('user_id'), 'zip_code'=>$zipCode,'country'=>$country,'state'=>$state,'city'=>$city,
            'radius'=>$radius,'hasImage'=>$hasImage,'hasVideo'=>$hasVideo,'additional_info'=>$AdditionalInfo,'hasOffers'=>$hasOffers,'minRating'=>$minRating
        );
			$tableName = 'tbl_advance_search';              
        	$result = $this->mdgeneraldml->insert($tableName, $insertData);
		}
        //Load $data in view
		
         //get all categories
         $where = array('catStatus' => 'Active', 'catAdminAdded' => '1');
         $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
       	 $this->load->view('includes/header');
       	 $this->load->view('search/business_listing_search_for_home_vw', $data);
       	 $this->load->view('includes/footer');
		
    }	

    
    function search_by_zipcode($catId=NULL,$limit=9)
    {
        if($catId==NULL){
            redirect('home');
        }
        
        $zipCode=$this->session->userdata('srhBussZipCode');
        if(!empty($_POST))
        {   
            $zipCode=$_POST['srhBussZipcode'];
            $this->session->set_userdata('srhBussZipCode',$zipCode);
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Zip','sthFromPage'=>'cat_wise business','srhKeywords'=>$zipCode,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
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
                $whereSearchBusiness="WHERE buss_zip_code in($zipCodesString) and buss_category=$catId";
            }else{
                $whereSearchBusiness="WHERE buss_zip_code=$zipCode AND buss_category=$catId";
            }
            //echo '<pre>'; print_r($zipCodesArray);
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
        $cnd = "catId = '" . $catId . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['catId'] = $cat_name[0]['catId'];
        $data['buss_category'] = $cat_name[0]['catName'];
        
        
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
        $this->load->view('search/business_listing_search_vw', $data);
        $this->load->view('includes/footer');
           
    }
    
    function search_by_provider($catId=NULL,$limit=9)
    {
        if($catId==NULL){
            redirect('home');
        }
        
        $propertySearchText=$this->session->userdata('propertySearchText');
        if(!empty($_POST))
        {   
            $propertySearchText=$_POST['propertySearchText'];
            $this->session->set_userdata('propertySearchText',$propertySearchText);
            
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Privider','sthFromPage'=>'cat_wise business','srhKeywords'=>$propertySearchText,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
                $this->mdgeneraldml->insert('tbl_search',$inserSearchData);
            }
        }
        
        if($propertySearchText!=""){
            $whereSearchBusiness="WHERE buss_category=$catId AND (buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%')";            
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
        $cnd = "catId = '" . $catId . "' ";
        $cat_name = $this->db_transact_model->get_single_record('tbl_category', $cnd);
        $data['catId'] = $cat_name[0]['catId'];
        $data['buss_category'] = $cat_name[0]['catName'];
        
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }        
        
        $data['myZipCode']=$myZipCode;
	//	if($_POST['']);
        //Load $data in view
        $this->load->view('includes/header');
        $this->load->view('search/business_listing_search_vw', $data);
        $this->load->view('includes/footer');
           
    }

}

/* End of file home.php */
/* Location: ./application/controllers/dashboard/business_lists.php */