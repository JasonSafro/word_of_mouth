<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class We_are_hiring extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
        $this->load->library("geozip");
        $this->load->library('form_validation');
    }

    public function index($limit=9) {
       
        $offset=0;
        $sortBy="buss_id";
        $sortType="DESC";
        
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        
        $where="WHERE j.jobStatus !='Deleted'";
        $myZipCode="";
        if($this->session->userdata('user_id')!="")
        {
            $userId=$this->session->userdata('user_id');
            $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
            $myZipCode=$myZipInfo[0]['user_zipcode'];
            
            $zipCodesString=$this->getMyZipCodeInRage($myZipCode);
            if($zipCodesString!="")
               $where.=" AND b.buss_zip_code IN($zipCodesString)";
        }  
        $data['myZipCode']=$myZipCode;
        
        $where.=" GROUP BY j.jobBusinessId ";
        $data['businessList'] = $this->WGModel->getBusinessListHavingJobs($where,$sortBy,$sortType,$limit,$offset);
        //echo $this->db->last_query(); die;
        //echo '<pre>'; print_r($data['businessList']); die;
        $data['showingRecords']=sizeof($data['businessList']);
       
        $data['totalRecotds']= $this->WGModel->countBusinessListHavingJobs($where);
        
       
        
        $this->load->view('includes/header');
        $this->load->view('we_are_hiring_view',$data);
        $this->load->view('includes/footer');
    }

    function search($limit=9){
        $offset=0;
        $sortBy="buss_id";
        $sortType="DESC";
        
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        $whereSearchBusiness="";
        
        if(!empty($_POST))
        {   
            $zipCode=$this->input->post('srhBussZipcode',true);
            $this->session->set_userdata('jobsSrhBussZipCode',$zipCode);
            
            $propertySearchText=$this->input->post('propertySearchText',true);
            $this->session->set_userdata('jobsPropertySearchText',$propertySearchText);
        }else{
           $zipCode=$this->session->userdata('jobsSrhBussZipCode'); 
           $propertySearchText=$this->session->userdata('jobsPropertySearchText'); 
        }
        
        if($propertySearchText!="" && $propertySearchText!="Search for your provider"){
            $whereSearchBusiness="(buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%')";
        }
        
        if($zipCode!="Search by zipcode" && $zipCode!=""){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $whereSearchBusiness=($whereSearchBusiness!=""?$whereSearchBusiness." AND ":"");
            
            $zipCodesArray=array();
            if(!empty($zipcodesWithMilesDistance)){
                $zipCodesArray=array_keys($zipcodesWithMilesDistance);
                $zipCodesString=implode(',', $zipCodesArray);
                $zipCodesString=$zipCodesString.','.$zipCode;
                $whereSearchBusiness.="buss_zip_code in($zipCodesString)";
            }else{
                $whereSearchBusiness.="buss_zip_code=$zipCode";
            }            
        }
        
        $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE $whereSearchBusiness AND j.jobStatus !='Deleted' GROUP BY j.jobBusinessId":"WHERE j.jobStatus !='Deleted' GROUP BY j.jobBusinessId");
        $data['businessList'] = $this->WGModel->getBusinessListHavingJobs($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        
       $data['showingRecords']=sizeof($data['businessList']);
       
       $data['totalRecotds']= $this->WGModel->countBusinessListHavingJobs($whereSearchBusiness);
        
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
       $this->load->view('search/we_are_hiring_search_vw',$data);
       $this->load->view('includes/footer');
    }
    
   function search_by_zipcode($limit=9)
    {
        $offset=0;
        $sortBy="buss_id";
        $sortType="DESC";
        
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        $zipCode=$this->session->userdata('jobsSrhBussZipCode');
        if(!empty($_POST))
        {   
            $zipCode=$_POST['srhBussZipcode'];
            $this->session->set_userdata('jobsSrhBussZipCode',$zipCode);
            
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Zip','sthFromPage'=>'job','srhKeywords'=>$zipCode,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
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
                $whereSearchBusiness="WHERE buss_zip_code in($zipCodesString) AND j.jobStatus !='Deleted' GROUP BY j.jobBusinessId";
            }else{
                $whereSearchBusiness="WHERE buss_zip_code=$zipCode AND j.jobStatus !='Deleted' GROUP BY j.jobBusinessId";
            }            
        }else{
            $whereSearchBusiness="j.jobStatus !='Deleted' GROUP BY j.jobBusinessId";
        }
        
        $data['businessList'] = $this->WGModel->getBusinessListHavingJobs($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        
       $data['showingRecords']=sizeof($data['businessList']);
       
       $data['totalRecotds']= $this->WGModel->countBusinessListHavingJobs($whereSearchBusiness);
        
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
       $this->load->view('search/we_are_hiring_search_vw',$data);
       $this->load->view('includes/footer');
    }
    
    function search_by_provider($limit=9)
    {   
        $offset=0;
        $sortBy="buss_id";
        $sortType="DESC";
        
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        $propertySearchText=$this->session->userdata('jobsPropertySearchText');
        if(!empty($_POST))
        {   
            $propertySearchText=$_POST['propertySearchText'];
            $this->session->set_userdata('jobsPropertySearchText',$propertySearchText);
            
            //store search
            if($this->session->userdata('user_id')!=""){
                $sessionUserId=$this->session->userdata('user_id');
                $inserSearchData=array('srhType'=>'Privider','sthFromPage'=>'job','srhKeywords'=>$propertySearchText,'srhUserId'=>$sessionUserId,'srhCreatedOn'=>_getDateAndTime());
                $this->mdgeneraldml->insert('tbl_search',$inserSearchData);
            }
        }
        
        if($propertySearchText!=""){
            $whereSearchBusiness="WHERE (buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%') AND j.jobStatus !='Deleted' GROUP BY j.jobBusinessId";
        }else{
            $whereSearchBusiness="j.jobStatus !='Deleted' GROUP BY j.jobBusinessId";
        }
        
       $data['businessList'] = $this->WGModel->getBusinessListHavingJobs($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
       
       $data['showingRecords']=sizeof($data['businessList']);
       
       $data['totalRecotds']= $this->WGModel->countBusinessListHavingJobs($whereSearchBusiness);
       //echo $this->db->last_query();
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
       $this->load->view('search/we_are_hiring_search_vw',$data);
       $this->load->view('includes/footer');
           
    }
    
    function jobs_by_category($catId=NULL,$limit=9){
       
        $offset=0;
        $sortBy="buss_id";
        $sortType="DESC";
        
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        $where = array('catStatus' => 'Active','catId'=>$catId);
        $catInfo = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        if(!empty($catInfo)){
            $data['catInfo']=$catInfo[0];

            //$where="WHERE b.buss_category=$catId AND j.jobStatus !='Deleted'";
            $catsBusiness=_getBusinessIdsByCategory($catId);
            $bussIdsString=implode(',',$catsBusiness);
            
            if($bussIdsString!="")
                $where="WHERE b.buss_id IN($bussIdsString) AND j.jobStatus !='Deleted'";
            else
                $where="WHERE b.buss_category=$catId  AND j.jobStatus !='Deleted'";
            
            $myZipCode="";
            if($this->session->userdata('user_id')!="")
            {
                $userId=$this->session->userdata('user_id');
                $myZipInfo=$this->WGModel->sqlQuery("SELECT user_zipcode from tbl_user WHERE user_id=$userId");
                $myZipCode=$myZipInfo[0]['user_zipcode'];
                
                
                $zipCodesString=$this->getMyZipCodeInRage($myZipCode);
                if($zipCodesString!="")
                    $zipCodesString.=','.$myZipCode;
                else
                     $zipCodesString=$myZipCode;
                 
                 if($zipCodesString!="")
                   $where.=" AND b.buss_zip_code IN($zipCodesString)";
            }  
            $data['myZipCode']=$myZipCode;

            $where.=" GROUP BY j.jobBusinessId ";
            $data['businessList'] = $this->WGModel->getBusinessListHavingJobs($where,$sortBy,$sortType,$limit,$offset);
            //echo $this->db->last_query(); die;
            //echo '<pre>'; print_r($data['businessList']); die;
            $data['showingRecords']=sizeof($data['businessList']);

            $data['totalRecotds']= $this->WGModel->countBusinessListHavingJobs($where);



            $this->load->view('includes/header');
            $this->load->view('we_are_hiring_by_category_view',$data);
            $this->load->view('includes/footer');
        }
        else{
            $this->session->set_flashdata('error','Sorry! Record not found.');
            redirect('we_are_hiring');
        }
    }
    
    function category_search($catId=NULL,$limit=9){
        $offset=0;
        $sortBy="buss_id";
        $sortType="DESC";
        
        $where = array('catStatus' => 'Active','catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        $where = array('catStatus' => 'Active','catId'=>$catId);
        $catInfo = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        if(empty($catInfo)){
            $this->session->set_flashdata('error','Sorry! Record not found.');
            redirect('we_are_hiring');
        }else{
            $data['catInfo']=$catInfo[0];
        }
            
        
        $whereSearchBusiness="";
        
        if(!empty($_POST))
        {   
            $zipCode=$this->input->post('srhBussZipcode',true);
            $this->session->set_userdata('cat_jobsSrhBussZipCode',$zipCode);
            
            $propertySearchText=$this->input->post('propertySearchText',true);
            $this->session->set_userdata('cat_jobsPropertySearchText',$propertySearchText);
            
        }else{
           $zipCode=$this->session->userdata('cat_jobsSrhBussZipCode'); 
           $propertySearchText=$this->session->userdata('cat_jobsPropertySearchText'); 
        }
        
        if($propertySearchText!="" && $propertySearchText!="Search for your provider"){
            $whereSearchBusiness="(buss_name LIKE '%".$propertySearchText."%' OR buss_address LIKE '%".$propertySearchText."%' OR buss_city LIKE '%".$propertySearchText."%' OR catName LIKE '".$propertySearchText."' OR catDescription LIKE '%".$propertySearchText."%')";
        }
        
        if($zipCode!="Search by zipcode" && $zipCode!=""){
            $defaultRange = $this->mdgeneraldml->select('settingMilesRange', 'tbl_admin_setting');
            $miles=($defaultRange[0]['settingMilesRange']!=""?$defaultRange[0]['settingMilesRange']:10);
            $zipcodesWithMilesDistance = $this->geozip->get_zips_in_range($zipCode, $miles, SORT_BY_ZIP_ASC, false);
            
            $whereSearchBusiness=($whereSearchBusiness!=""?$whereSearchBusiness." AND ":"");
            
            $zipCodesArray=array();
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
            $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE $whereSearchBusiness AND buss_id in($bussIdsString) AND j.jobStatus !='Deleted' GROUP BY j.jobBusinessId":"WHERE j.jobStatus !='Deleted' AND cat_id=$catId GROUP BY j.jobBusinessId");
        else
            $whereSearchBusiness=($whereSearchBusiness!=""?"WHERE $whereSearchBusiness AND j.jobStatus !='Deleted' GROUP BY j.jobBusinessId":"WHERE j.jobStatus !='Deleted' AND cat_id=$catId GROUP BY j.jobBusinessId");
        
        $data['businessList'] = $this->WGModel->getBusinessListHavingJobs($whereSearchBusiness,$sortBy,$sortType,$limit,$offset);
        //echo $this->db->last_query(); die;
       $data['showingRecords']=sizeof($data['businessList']);
       
       $data['totalRecotds']= $this->WGModel->countBusinessListHavingJobs($whereSearchBusiness);
        
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
       $this->load->view('we_are_hiring_by_category_view',$data);
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */