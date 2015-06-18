<?php

/**
 * General Database Model
 * 
 * Its use for the send contact us(feedbacks) to admin
 *
 * @package	Codeigniter
 * @subpackage	Model
 * @category	model
 * @author	Bhagwnt Bhadange
 */
class website_general_model extends CI_Model {

    /**
     * Constructor
     */
    function website_general_model() {
        parent::__construct();
        $this->load->database();
    }
   
    //Fetch records by query
    function sqlQuery($sql)
    {
         return $this->db->query($sql)->result_array();
    }
    
    //update Query
    function sqlUpdate($sql)
    {
        return $this->db->query($sql);
    }
    
    //delete Query
    function sqlDelete($sql)
    {
        return $this->db->query($sql);
    }
    
    function getDealList($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        if($where!=""){
            $where.=" AND bussStatus='Active'";
        }else{
            $where=" WHERE bussStatus='Active'";
        }
        
        $orderString="";
        /*if($sortBy!=NULL && $sortType!=NULL)        
            $orderString=" ORDER BY $sortBy $sortType";
        else*/
            $orderString=" ORDER BY b.buss_avg_ratings DESC , b.buss_name ASC";
        
        $limitstring="";
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $orderString.=$limitstring;
        $where.=$orderString;
        
        
        /*$sql="SELECT d.*,b.buss_id,b.buss_name,b.buss_address,b.buss_avg_ratings,b.buss_addr_addon,b.buss_city,b.buss_zip_code,b.buss_phone,b.buss_category,
        b.buss_social_media_channel_1,b.buss_social_media_channel_2,b.buss_social_media_channel_3,b.buss_social_media_channel_4,b.buss_web_address,c.catName,
        s.state_name as stateName,ctr.country_name as countryName 
            FROM tbl_deals as d 
            JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
             $where";*/
        $sql="SELECT d.*,b.buss_id,b.buss_name,b.buss_address,b.buss_avg_ratings,b.buss_addr_addon,b.buss_city,b.buss_zip_code,b.buss_phone,b.buss_category,
        b.buss_social_media_channel_1,b.buss_social_media_channel_2,b.buss_social_media_channel_3,b.buss_social_media_channel_4,b.buss_web_address,
        s.state_name as stateName,ctr.country_name as countryName 
            FROM tbl_deals as d 
            JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
            
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
             $where";
        //echo "query:=>".$sql;die;//
        return $this->db->query($sql)->result_array();
    }
    
    function countTotalDeals($where=NULL)
    {
        if($where!=""){
            $where.=" AND bussStatus='Active'";
        }else{
            $where=" WHERE bussStatus='Active'";
        }
        
        $sql="SELECT count(*) as totalRecords
             FROM tbl_deals as d 
             JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId             
             $where";
        
        $result= $this->db->query($sql)->result_array();
        return $result[0]['totalRecords'];
    }
    
    function countTotalRecords($tblName,$where=NULL)//where should be an array
    {
        if($where!="")
            $this->db->where($where);
            
        $this->db->from($tblName);
        return $this->db->count_all_results();
    }
        
    function getJobList($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $limitstring="";
        $orderByString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else
            $orderByString=" ORDER BY jobId DESC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $where.=$limitstring;
        
        /*$sql="SELECT j.*,b.buss_name,b.buss_logo,t.jobType,c.catName,c.catImageName,c.catId,s.state_name as stateName,ctr.country_name as countryName
            FROM tbl_jobs as j 
            JOIN tbl_business_info as b ON b.buss_id=j.jobBusinessId
            JOIN tbl_job_types as t ON t.jobTypeId=j.jobTypeId
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            $where";*/
        $sql="SELECT j.*,b.buss_name,b.buss_logo,t.jobType,s.state_name as stateName,ctr.country_name as countryName
            FROM tbl_jobs as j 
            JOIN tbl_business_info as b ON b.buss_id=j.jobBusinessId
            JOIN tbl_job_types as t ON t.jobTypeId=j.jobTypeId            
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            $where";
        
        return $this->db->query($sql)->result_array();
    }
    
    
    function getBusinessReviews($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $limitstring="";
         $orderByString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else
            $orderByString=" ORDER BY rvwId DESC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $where.=$limitstring;
        
        //tbl_business_reviews
        
        /*$sql="SELECT r.*,b.buss_name,b.buss_city,b.buss_addr_addon,b.buss_logo,c.catName 
            FROM tbl_business_reviews as r 
            JOIN tbl_business_info as b ON b.buss_id=r.rvwBusinessId
            LEFT JOIN tbl_category as c ON c.catId=r.rvwCategoryId
            $where";*/
        $sql="SELECT r.*,b.buss_name,b.buss_city,b.buss_addr_addon,b.buss_logo
            FROM tbl_business_reviews as r 
            JOIN tbl_business_info as b ON b.buss_id=r.rvwBusinessId          
            $where";
        return $this->db->query($sql)->result_array();
    }
    
    function getBusinessInfoList($where,$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $limitstring="";
         $orderByString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else
            $orderByString=" ORDER BY buss_avg_ratings DESC , buss_name ASC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $where.=$limitstring; //tbl_business_info
        
         /*$sql="SELECT b.*,c.catName,c.catImageName,s.state_name as stateName,ctr.country_name as countryName 
            FROM tbl_business_info as b             
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            $where";*/
         $sql="SELECT b.*,s.state_name as stateName,ctr.country_name as countryName 
            FROM tbl_business_info as b                         
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            $where";
        
        return $this->db->query($sql)->result_array();
        
    }
    
    function getBusinessListHavingJobs($where,$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $limitstring="";
         $orderByString="";
        /*if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else*/
            $orderByString=" ORDER BY buss_avg_ratings DESC , buss_name ASC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $where.=$limitstring; //tbl_business_info
        
         $sql="SELECT b.*,c.catName,c.catImageName,s.state_name as stateName,ctr.country_name as countryName 
            FROM tbl_business_info as b             
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_jobs as j ON j.jobBusinessId=b.buss_id
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            $where";
        
        
        
        return $this->db->query($sql)->result_array();
        
    }
    
    function countBusinessListHavingJobs($where)
    { 
         $sql="SELECT COUNT(*) AS totalRecords
            FROM tbl_business_info as b             
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_jobs as j ON j.jobBusinessId=b.buss_id
            $where";
         
        
        $res= $this->db->query($sql)->result_array();
        return sizeof($res);
        
    }
    
    function getJobApplications($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $limitstring="";
        $orderByString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else
            $orderByString=" ORDER BY jAppId DESC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $where.=$limitstring;
        
        $sql="SELECT ja.*,b.buss_name,b.buss_logo,c.catName,c.catImageName,j.jobTitle
            FROM tbl_job_applications as ja            
            JOIN tbl_business_info as b ON b.buss_id=ja.jAppBusinessId            
            LEFT JOIN tbl_category as c ON c.catId=ja.jAppCatId
            LEFT JOIN tbl_jobs as j ON j.jobId=ja.jAppJobId
            $where";
        
        return $this->db->query($sql)->result_array();
        
    }
    
    function countReviewersReviews($userId)
    {
        $sql="SELECT count(rvwBusinessUserId) as reviewsCount FROM tbl_business_reviews where rvwBusinessUserId=$userId AND rvwStatus='Published'";
        $result = $this->db->query($sql)->result_array();
        return $result[0]['reviewsCount'];
    }
    
    function countReviewersExpertReviews($userId)
    {
        $sql="SELECT r.rvwCategoryId, count(r.rvwCategoryId) AS reviewsCount,c.catName 
        FROM tbl_business_reviews as r,tbl_category as c
        where rvwBusinessUserId=$userId AND r.rvwCategoryId=c.catId AND rvwStatus='Published' GROUP BY rvwCategoryId";
        return $this->db->query($sql)->result_array();
        
    }
    
    function countReferrals($userId){
        $sql="SELECT count(refUserId) as referralCount FROM tbl_referral
              WHERE refUserId=$userId AND CAST(refCreatedOn as date) BETWEEN DATE_SUB(CURDATE(), INTERVAL 3 MONTH) AND CURDATE()";
        $result = $this->db->query($sql)->result_array();
        return $result[0]['referralCount'];
    }
	
	//PRITAM 3 DEC 2013
	function insertquery($tbl,$data)
	{
		$last_id = $this->db->insert($tbl,$data);
		return $last_id;
	}
	//PRITAM 3 DEC 2013
	function select($select, $from, $where=NULL, $orderBy=NULL, $num=NULL, $offset=NULL) 
	{
        $this->db->select($select);
        $this->db->from($from);

       
        //if there is no any where criteria..............
        if ($where != NULL) {
            $this->db->where($where);
        }
       //if result want sorted 
       if ($orderBy != NULL) {
           $this->db->order_by($orderBy['colname'], $orderBy['type']);
       }
        //chk fror pagination pages......................
        if ($num != NULL or $offset != NULL) {
            $this->db->limit($num, $offset);
        }

        return $this->db->get()->result_array();
    }
    
    function getDealViewList($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL,$groupby='')
    {
        
        $orderString="";
		
		 if($groupby!=NULL)        
           $orderString=" GROUP BY $groupby"; 
			
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderString.=" ORDER BY max($sortBy) $sortType";
       
        
        $limitstring="";
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $orderString.=$limitstring;
		$where = 
		
        $where.=$orderString;

/*     	 $sql="SELECT distinct(v.bvwDealId),d.*,b.buss_name,b.buss_id,b.buss_avg_ratings,b.buss_address,b.buss_addr_addon,b.buss_city,b.buss_zip_code,b.buss_phone,b.buss_category,c.catName,s.state_name as stateName,ctr.country_name as countryName
            FROM tbl_business_view as v 
            JOIN tbl_deals as d ON d.dealId=v.bvwDealId
            LEFT JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
             $where"; */       
    
     	 $sql="SELECT distinct(v.bvwDealId),d.*,b.buss_name,b.buss_id,b.buss_avg_ratings,b.buss_address,b.buss_addr_addon,b.buss_city,b.buss_zip_code,b.buss_phone,b.buss_category,c.catName,s.state_name as stateName,ctr.country_name as countryName
            FROM tbl_business_view as v 
            JOIN tbl_deals as d ON d.dealId=v.bvwDealId
            LEFT JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
            LEFT JOIN tbl_category as c ON c.catId=b.buss_category
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state WHERE d.dealStatus !='Deleted' AND b.buss_id IS NOT NULL
             $where";
//			 echo "$sql";
//			 exit;
			 return $this->db->query($sql)->result_array();
			 
		
    }
    
    function getClaimRequests($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $orderString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderString=" ORDER BY $sortBy $sortType";
        else
            $orderString=" ORDER BY crId DESC";
        
        $limitstring="";
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $orderString.=$limitstring;
        $where.=$orderString;
        
        
        $sql="SELECT c.*,CONCAT(u.user_fname,' ',u.user_lname) as userFullName
              FROM tbl_cliam_requests as c 
              LEFT JOIN tbl_user as u ON u.user_id=c.crRequesterUserId
             $where";
        
        return $this->db->query($sql)->result_array();
        
    }
    
    function getBussCategoryNamesByBusinessId($businessId){
        $sql="SELECT c.catName
            FROM tbl_business_categories as bc             
            LEFT JOIN tbl_category as c ON c.catId=bc.cat_id            
            WHERE bc.buss_id=$businessId";        
        $result=$this->db->query($sql)->result_array();
        
        $response=array();
        foreach($result as $key=>$val)
            $response[]=$val['catName'];
        
        return implode(',', $response);
    }
    
    function getCategoryForBusiness($where=""){
        $sql="SELECT bc.buss_id
            FROM tbl_business_categories as bc             
            LEFT JOIN tbl_category as c ON c.catId=bc.cat_id $where";        
        $result=$this->db->query($sql)->result_array();
        
        $response=array();
        foreach($result as $key=>$val)
            $response[]=$val['buss_id'];
        
        return implode(',', $response);
    }
    
    function getFavoriteBusinessList($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL,$groupby='')
    {
        ///buss_favorite_id
        $orderString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderString=" ORDER BY $sortBy $sortType";
        else
            $orderString=" ORDER BY buss_favorite_id DESC";
        
        $limitstring="";
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $orderString.=$limitstring;
        $where.=$orderString;
        
    
     	 $sql="SELECT f.*,b.buss_name,b.buss_logo,b.bussStatus
            FROM tbl_user_favorite_business as f 
            LEFT JOIN tbl_business_info as b ON b.buss_id=f.business_id
             $where";
         return $this->db->query($sql)->result_array();
		
    }
}

/* End of file mdgeneraldml.php */
/* Location: ./application/models/mdgeneraldml.php */
