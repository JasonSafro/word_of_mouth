<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deals_and_coupons extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model	
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model
        $this->load->library("geozip");
    }

    public function index($limit=30){
        
        $offset=0;
        $sortBy="dealId";
        $sortType="DESC";      
        
         //logged in users zipcode
        $myZipCode="";
        $where="WHERE d.dealStatus !='Deleted'";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
            
            $zipCodesString=$this->getMyZipCodeInRage($myZipCode);
            if($zipCodesString!="")
                $where.=" AND b.buss_zip_code IN($zipCodesString) AND b.bussHasDeal='Yes'";
        }  
        $data['myZipCode']=$myZipCode;
        
        $data['dealList'] = $this->WGModel->getDealList($where,$sortBy,$sortType,$limit,$offset);
        //echo "<pre>";
        //print_r($data['dealList']);
        $data['totalRecords']=$this->WGModel->countTotalDeals($where);
        
        $data['limit']=$limit;
        $data['offset']=$offset;
        
        //get categories
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
       
        
        $this->load->view('includes/header');
        $this->load->view('deals_coupons_view',$data);
        $this->load->view('includes/footer');
    }
           
    function view($dealId){
        
        $where="WHERE dealId=$dealId";
        $dealInfo = $this->WGModel->getDealList($where);
        //echo '<pre>'; print_r($dealInfo); die;
		if ($this->session->userdata('user_id') != '')
		{
                    $user_login_id = $this->session->userdata('user_id');


                    $check_duplicate = $this->WGModel->select('bvwId','tbl_business_view',array('bvwDealId'=>$dealId,'bvwLoggedInUserId'=>$user_login_id));



                    if(count($check_duplicate)==0)
                    {
                            $data=array('bvwDealId'=>$dealId,'bvwLoggedInUserId'=>$user_login_id,'bvwUpdatedOn'=>date('Y-m-d h:i:s'));			    $last_id =  $this->WGModel->insertquery('tbl_business_view',$data);
                    }
                    else
                    {
                            $bvwid = $check_duplicate[0]['bvwId'];
                            $query = "Update tbl_business_view SET bvwUpdatedOn ='".date('Y-m-d h:i:s')."' where bvwId = '".$bvwid ."'";
                             $update_record =  $this->WGModel->sqlUpdate($query);

                    }
        }
        if(!empty($dealInfo))
        {    
            $data['dealInfo'] = $dealInfo[0];
            $data['dealList'] = $this->WGModel->getDealViewList('',$sortBy='bvwUpdatedOn',$sortType='DESC',$limit=6,$offset=0,'bvwDealId');
			//echo "<pre>";
            //print_r($data['dealList']);
            
            $myZipCode="";
            if($this->session->userdata('user_id')!="")
            {
                $userId=$this->session->userdata('user_id');
                $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
                $myZipCode=$myZipInfo[0]['user_zipcode'];
            }  
            $data['myZipCode']=$myZipCode;
            
            $this->load->view('includes/header');
            $this->load->view('deal_coupons_detail_vw',$data);
            $this->load->view('includes/footer');
        }else{
            $this->session->set_flashdata('error','Deal does not exist.');
            redirect('deals_and_coupons');
        }    
    }
        
    function deals_by_category($catId,$limit=30)
    {
        $offset=0;
        $sortBy="dealId";
        $sortType="DESC";
        
        //get categories
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        //$where="WHERE buss_category=$catId";
        $where="WHERE buss_id IN(SELECT buss_id FROM tbl_business_categories where cat_id=$catId)";
        $data['dealList'] = $this->WGModel->getDealList($where,$sortBy,$sortType,$limit,$offset);
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($where);
        //echo $this->db->last_query();die;
        
        $data['catId']=$catId;
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        $where=array('catId'=>$catId);
        $data['catagotyInfo']=$this->mdgeneraldml->select('*', 'tbl_category', $where);
        
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
       $this->load->view('deals_by_category_list_vw',$data);
       $this->load->view('includes/footer');
    }
     
    function deals_by_category_search($catId,$limit=30)
    {       
        $offset=0;
        $sortBy="dealId";
        $sortType="DESC";
        
        //get categories
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        //get single category info
        $where=array('catId'=>$catId);
        $data['catagotyInfo']=$this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        //$whereSearchBusiness="WHERE buss_id IN(SELECT buss_id FROM tbl_business_categories where cat_id=$catId)";
        $whereSearchBusiness="";
        if(isset($_POST))
        {   
            $propertySearchText=$this->input->post('propertySearchText',true);
            $this->session->set_userdata('cat_dealsPropertySearchText',$propertySearchText);
            
            $zipCode=$this->input->post('srhBussZipcode',true);
            $this->session->set_userdata('cat_dealsSrhBussZipCode',$zipCode);
        }else{
           $propertySearchText=$this->session->userdata('cat_dealsPropertySearchText'); 
           $zipCode=$this->session->set_userdata('cat_dealsSrhBussZipCode',$zipCode);
        }
        
        $propertySearchText = mysql_real_escape_string($propertySearchText);       
        if($propertySearchText!="" && $propertySearchText!="Search for your provider"){            
                $whereSearchBusiness="(dealOverview LIKE '%".$propertySearchText."%' OR buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_description LIKE '%".$propertySearchText."%')";
        }
        
        
        if($zipCode!="Search by zipcode" && $zipCode!=""){
            //echo $zipCode;
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){                
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                
                $whereSearchBusiness=($whereSearchBusiness!=""?"$whereSearchBusiness AND buss_zip_code in($zipCodesString)":"buss_zip_code in($zipCodesString)");                
            }else{
                $whereSearchBusiness=($whereSearchBusiness!=""?"$whereSearchBusiness AND buss_zip_code=$zipCode":"buss_zip_code=$zipCode");               
            }
        }
        //echo $whereSearchBusiness;
        $secondWhere="buss_id IN(SELECT buss_id FROM tbl_business_categories where cat_id=$catId)";
        $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE ".$whereSearchBusiness." AND ".$secondWhere."":"WHERE $secondWhere");
        $data['dealList'] = $this->WGModel->getDealList($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        //echo $this->db->last_query();die;
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($whereSearchBusiness);
        
        
        
        $data['catId']=$catId;
        $data['limit']=$limit;
        $data['offset']=$offset;   
        
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
       $this->load->view('deals_by_category_list_vw',$data);
       $this->load->view('includes/footer');
        
        
        
        
        
        
        
        
        
        //$where="WHERE buss_category=$catId";
        /*$where="WHERE buss_id IN(SELECT buss_id FROM tbl_business_categories where cat_id=$catId)";
        $data['dealList'] = $this->WGModel->getDealList($where,$sortBy,$sortType,$limit,$offset);
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($where);
        //echo $this->db->last_query();die;
        
        $data['catId']=$catId;
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        $where=array('catId'=>$catId);
        $data['catagotyInfo']=$this->mdgeneraldml->select('*', 'tbl_category', $where);
        
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
       $this->load->view('deals_by_category_list_vw',$data);
       $this->load->view('includes/footer');*/
       
       
       
        
    }
    
    function search($limit=30){
        $offset=0;
        $sortBy="dealId";
        $sortType="DESC";
        
        
        $whereSearchBusiness="";
        if(isset($_POST))
        {   
            $propertySearchText=$this->input->post('propertySearchText',true);
            $this->session->set_userdata('dealsPropertySearchText',$propertySearchText);
            
            $zipCode=$this->input->post('srhBussZipcode',true);
            $this->session->set_userdata('dealsSrhBussZipCode',$zipCode);
        }else{
           $propertySearchText=$this->session->userdata('dealsPropertySearchText'); 
           $zipCode=$this->session->set_userdata('dealsSrhBussZipCode',$zipCode);
        }
        
        $propertySearchText = mysql_real_escape_string($propertySearchText);       
        if($propertySearchText!="" && $propertySearchText!="Search for your provider"){
            
            //get category ids from cats
            $bussIdsString=$this->WGModel->getCategoryForBusiness("WHERE catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%'");
         
            if($bussIdsString!="")
                $whereSearchBusiness="dealOverview LIKE '%".$propertySearchText."%' OR buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_id in($bussIdsString) OR buss_description LIKE '%".$propertySearchText."%' ";
            else
                $whereSearchBusiness="dealOverview LIKE '%".$propertySearchText."%' OR buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_description LIKE '%".$propertySearchText."%'";
        }
        
        
        if($zipCode!="Search by zipcode" && $zipCode!=""){
            //echo $zipCode;
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){                
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                
                $whereSearchBusiness=($whereSearchBusiness!=""?"$whereSearchBusiness AND buss_zip_code in($zipCodesString)":"buss_zip_code in($zipCodesString)");                
            }else{
                $whereSearchBusiness=($whereSearchBusiness!=""?"$whereSearchBusiness AND buss_zip_code=$zipCode":"buss_zip_code=$zipCode");               
            }
        }
        //echo $whereSearchBusiness;
        
        $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE ".$whereSearchBusiness:"");
        $data['dealList'] = $this->WGModel->getDealList($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        //echo $this->db->last_query();die;
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($whereSearchBusiness);
        
        
        
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        
        
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
       $this->load->view('search/deals_search_vw',$data);
       $this->load->view('includes/footer');
    }
       
    function getMyZipCodeInRage($zipCode){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                return $zipCodesString;
            }else{
                return "";
            }
    }
    
    function download($dealId=null){
        $where=array('dealId'=>$dealId);
        if($dealId!=null && _isRecordExist('tbl_deals',$where))
        //mdgeneraldml
        $dealInfo=$this->mdgeneraldml->select('dealDocument','tbl_deals',$where); 
        if(!empty($dealInfo)){
            if($dealInfo[0]['dealDocument']!="")
            {
                $file_path = "sitedata/deal_docs/".$dealInfo[0]['dealDocument'];
                header('Content-Type: application/pdf');
                header('Content-disposition: attachment; filename='.$dealInfo[0]['dealDocument']);
                header('Content-Length: ' . filesize($file_path));
                readfile($file_path);
            }else{
                echo '<h2>Sorry, there is no file to download.</h2>';
            }    
        }else{
            echo '<h2>Sorry, deal not exist.</h2>';
        }
        
    }
    
     function getNextDealsByCategory($catId,$offset=0)
    {
        $limit=30;
        $sortBy="dealId";
        $sortType="DESC";
        $where="WHERE buss_id IN(SELECT buss_id FROM tbl_business_categories where cat_id=$catId)";
        $data['dealList'] = $this->WGModel->getDealList($where,$sortBy,$sortType,$limit,$offset);
        $data['totalRecords']=$this->WGModel->countTotalDeals($where);
        $data['limit']=$limit;
        $data['offset']=$offset;        
        $data['catId']=$catId;
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }  
        $data['myZipCode']=$myZipCode;
        
        echo $this->load->view('ajax_pages/deals_coupons_ajax_vw',$data,true);
    }
    
    function getNextDeals($offset=0){
        
        $limit=30;
        $sortBy="dealId";
        $sortType="DESC";
        $data['dealList'] = $this->WGModel->getDealList('',$sortBy,$sortType,$limit,$offset);
        $data['totalRecords']=$this->WGModel->countTotalRecords('tbl_deals');
        $data['limit']=$limit;
        $data['offset']=$offset;   
        
        //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }  
        $data['myZipCode']=$myZipCode;
        
        echo $this->load->view('ajax_pages/deals_coupons_ajax_vw',$data,true);
    }
    
     function search_by_zipcode($limit=30)
    {
        $offset=0;
        $sortBy="dealId";
        $sortType="DESC";
        
        $zipCode=$this->session->userdata('dealsSrhBussZipCode');
        if(!empty($_POST))
        {   
            $zipCode=$_POST['srhBussZipcode'];
            $this->session->set_userdata('dealsSrhBussZipCode',$zipCode);
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Zip','sthFromPage'=>'deal','srhKeywords'=>$zipCode,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
                $this->mdgeneraldml->insert('tbl_search',$inserSearchData);
            }
        }
        
        if($zipCode!="Search by zipcode" && $zipCode!=""){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                $whereSearchBusiness="WHERE buss_zip_code in($zipCodesString)";
            }else{
                $whereSearchBusiness="WHERE buss_zip_code=$zipCode";
            }
            //echo '<pre>'; print_r($zipCodesArray);
        }else{
            $whereSearchBusiness="";
        }
        
        
        $data['dealList'] = $this->WGModel->getDealList($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($whereSearchBusiness);
        //echo $this->db->last_query();die;
        
        
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        
        
         //logged in users zipcode
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
        }  
        $data['myZipCode']=$myZipCode;
        //$where=array('catId'=>$catId);
        //$data['catagotyInfo']=$this->mdgeneraldml->select('*', 'tbl_category', $where);
        
       $this->load->view('includes/header');
       $this->load->view('search/deals_search_vw',$data);
       $this->load->view('includes/footer');
    }
    
    function search_by_provider($limit=30)
    {   
        $offset=0;
        $sortBy="dealId";
        $sortType="DESC";
        
        $propertySearchText=$this->session->userdata('dealsPropertySearchText');
        if(!empty($_POST))
        {   
            $propertySearchText=$_POST['propertySearchText'];
            $this->session->set_userdata('dealsPropertySearchText',$propertySearchText);
            
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Privider','sthFromPage'=>'deal','srhKeywords'=>$propertySearchText,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
                $this->mdgeneraldml->insert('tbl_search',$inserSearchData);
            }
        }
        
		$propertySearchText = mysql_real_escape_string($propertySearchText);
        //get category ids from cats
        $bussIdsString=$this->WGModel->getCategoryForBusiness("WHERE catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%'");
                
        if($propertySearchText!=""){
            if($bussIdsString!="")
                $whereSearchBusiness="WHERE dealOverview LIKE '%".$propertySearchText."%' OR buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_id in($bussIdsString) OR buss_description LIKE '%".$propertySearchText."%' ";
            else
                $whereSearchBusiness="WHERE dealOverview LIKE '%".$propertySearchText."%' OR buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_description LIKE '%".$propertySearchText."%' ";
        }else{
            $whereSearchBusiness="";
        }
        
        $data['dealList'] = $this->WGModel->getDealList($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($whereSearchBusiness);
        //echo $this->db->last_query();die;
        
        
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        
        
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
       $this->load->view('search/deals_search_vw',$data);
       $this->load->view('includes/footer');
           
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */