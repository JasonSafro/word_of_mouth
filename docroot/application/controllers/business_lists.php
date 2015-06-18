<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Business_lists extends CI_Controller {

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

    /* function index()
      {
      if (($this->session->userdata('user_id') == ""))
      {
      redirect(base_url() . 'user/home');
      }
      else
      {
      }
      } */

    function index($cat_id=NULL, $num=9,$providername='all')
    {  
        
        //Get All businesses by category ID          
        $tbl_business_info = 'tbl_business_info';
        $where_cat_id = array('buss_category' => $cat_id,'bussStatus'=>'Active');

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
        
        //get all categories
        $where = array('catStatus' => 'Active', 'catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        //Load $data in view
        $this->load->view('includes/header');
        $this->load->view('business_lists_view', $data);
        $this->load->view('includes/footer');
    }
    
    function category_search($catId=NULL,$limit=9){
        
        $propertySearchText="";
        $zipCode="";
        $whereSearchBusiness="";
        if(!empty($_POST))
        {   
            if($_POST['propertySearchText']!="")
            {
                $propertySearchText=$this->input->post('propertySearchText',true);
                $this->session->set_userdata('propertySearchText',$propertySearchText);            
            }else{
                $this->session->set_userdata('propertySearchText','Search for your provider');
            }
            
            if($_POST['srhBussZipcode']!="" && $_POST['srhBussZipcode']!="Search by zipcode")
            {
                $zipCode=$this->input->post('srhBussZipcode',true);
                $this->session->set_userdata('srhBussZipCode',$zipCode);
            }else{
                $this->session->set_userdata('srhBussZipCode','Search by zipcode');
            }
        }else{
            $propertySearchText=$this->session->userdata('propertySearchText');
            $zipCode=$this->session->userdata('srhBussZipCode');
        } 
        
        //get category ids from cats
        //$bussIdsString=$this->WGModel->getCategoryForBusiness("WHERE catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%'");
        
        
        $propertySearchText = mysql_real_escape_string($propertySearchText);
        if($propertySearchText!="" && $propertySearchText!="Search for your provider"){
                $whereSearchBusiness="(buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_description LIKE '%".$propertySearchText."%' )";            
        }
        
        //echo $whereSearchBusiness; die;
        if($zipCode!="Search by zipcode" && $zipCode!=""){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            
            $whereSearchBusiness=($whereSearchBusiness!=""?$whereSearchBusiness." AND ":"");
            if(!empty($zipcodesWithMilesDistance)){                
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                $whereSearchBusiness.="buss_zip_code in($zipCodesString)";
            }else{
                $whereSearchBusiness.="buss_zip_code=$zipCode";
            }
        }
        
        $catsBusiness=_getBusinessIdsByCategory($catId);
        $bussIdsString=implode(',',$catsBusiness);
        
        if($bussIdsString!="")
            $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE buss_id in($bussIdsString) AND bussStatus='Active' AND ".$whereSearchBusiness:"WHERE bussStatus='Active' AND buss_category=$catId");
        else    
            $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE bussStatus='Active' AND ".$whereSearchBusiness:"WHERE bussStatus='Active' AND buss_category=$catId");
        //echo $whereSearchBusiness; 
        
       $bus_Info=$this->WGModel->getBusinessInfoList($whereSearchBusiness,'','',$limit,0);
       
       //echo $this->db->last_query();   echo '<pre>'; print_r($bus_Info); die;
       
        $data['bus_list'] = $bus_Info;
        $data['current_count'] = count($bus_Info);

        //Total Count
        $businessCount=$this->WGModel->getBusinessInfoList($whereSearchBusiness);
        //echo '<pre>'; print_r($businessCount); die;
        //$businessCount=$this->WGModel->sqlQuery("SELECT count(*) as totalBusiness from tbl_business_info $whereSearchBusiness");
        //$data['total_count'] =$businessCount[0]['totalBusiness'];
        $data['total_count'] =count($businessCount);

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
        
        //get all categories
        $where = array('catStatus' => 'Active', 'catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        //Load $data in view
        $this->load->view('includes/header');
        $this->load->view('search/business_listing_search_vw', $data);
        $this->load->view('includes/footer');
    }
    function search_by_zipcode($catId=NULL,$limit=9)
    {
        //unset provider search string
        $this->session->set_userdata('propertySearchText','');
        
        if($catId==NULL){
            redirect('home');
        }
       // echo $catId; die;
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
        
        $catsBusiness=_getBusinessIdsByCategory($catId);
        $catsBusinessIds=implode(',',$catsBusiness);
        if($catsBusinessIds!="")
            $catsWhere="WHERE bussStatus='Active' AND buss_id in($catsBusinessIds)";
        else
            $catsWhere="WHERE bussStatus='Active' AND buss_category=$catId";
        
        if($zipCode!=""){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                $whereSearchBusiness=$catsWhere." AND buss_zip_code in($zipCodesString)";
            }else{
                $whereSearchBusiness=$catsWhere." AND buss_zip_code=$zipCode";
            }
            //echo '<pre>'; print_r($zipCodesArray);
        }else{
            $whereSearchBusiness=$catsWhere;
        }
        
       $bus_Info=$this->WGModel->getBusinessInfoList($whereSearchBusiness,'','',$limit,0);
       //echo $this->db->last_query();die;
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
        //unset zip search string
        $this->session->set_userdata('srhBussZipCode','');
        
        
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
        
        $propertySearchText = mysql_real_escape_string($propertySearchText);
		//get category ids from cats
        $bussIdsString=$this->WGModel->getCategoryForBusiness("WHERE catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%'");
        
        
        if($propertySearchText!=""){
            if($bussIdsString!="")
                $whereSearchBusiness="WHERE bussStatus='Active' AND (buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_id in($bussIdsString) OR buss_description LIKE '%".$propertySearchText."%' )";
            else
                $whereSearchBusiness="WHERE bussStatus='Active' AND (buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR buss_description LIKE '%".$propertySearchText."%')";
        }else{
            $whereSearchBusiness="WHERE bussStatus='Active'AND buss_category=$catId";
        }
        
       $bus_Info=$this->WGModel->getBusinessInfoList($whereSearchBusiness,'','',$limit,0);
       /*echo $this->db->last_query();
       echo '<pre>'; print_r($bus_Info); die;*/
       
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

}

/* End of file home.php */
/* Location: ./application/controllers/dashboard/business_lists.php */