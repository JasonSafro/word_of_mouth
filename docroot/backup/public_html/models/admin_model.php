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
class admin_model extends CI_Model {

    /**
     * Constructor
     */
    function admin_model() {
        parent::__construct();
        $this->load->database();
    }

    function isRecordExist($tableName, $where) {
        $this->db->from($tableName);
        $this->db->where($where);
        $count=$this->db->count_all_results();
        if ($count > 0)
            return true;
        else
            return false;
    }
    
    function getUserList()
    {
        $sql="SELECT * FROM tbl_users";
        return $this->db->query($sql)->result_array();
    }
    
    
    function deleteUserFromAllTables($userId)
    {        
        $sql="DELETE tbl_users WHERE userId=$userId";
        return $this->db->query($sql);
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
        
        $sql="SELECT r.*,b.buss_name,b.buss_city,b.buss_addr_addon,c.catName 
            FROM tbl_business_reviews as r 
            JOIN tbl_business_info as b ON b.buss_id=r.rvwBusinessId
            LEFT JOIN tbl_category as c ON c.catId=r.rvwCategoryId
            $where";
        
        return $this->db->query($sql)->result_array();
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
        
        $sql="SELECT j.*,b.buss_name,t.jobType,s.state_name as stateName,ctr.country_name as countryName
            FROM tbl_jobs as j
            JOIN tbl_business_info as b ON b.buss_id=j.jobBusinessId
            JOIN tbl_job_types as t ON t.jobTypeId=j.jobTypeId
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            $where";
        
        return $this->db->query($sql)->result_array();
    }
    
    function get_newsletter_list($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        $limitstring="";
        $orderByString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else
            $orderByString=" ORDER BY newsId DESC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
         $where.=$limitstring;
        //echo $where;
        $sql="select * from tbl_newsletter ".$where;
      	return $this->db->query($sql)->result_array();
		//echo $this->db->last_query();
    }
    function get_business_list($sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL,$where='')
    {
        $limitstring="";
        $orderByString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderByString=" ORDER BY $sortBy $sortType";
        else
            $orderByString=" ORDER BY buss_id DESC";
        
        $where.=$orderByString;
        
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
         $where.=$limitstring;
        //echo $where;
        /*$sql="select  b.*,CONCAT(u.user_fname,' ',u.user_lname) as userFullName,c.catName,s.state_name as stateName,ctr.country_name as countryName
              from tbl_business_info as b
              LEFT JOIN tbl_user as u ON b.user_id=u.user_id 
              LEFT JOIN tbl_category as c ON c.catId=b.buss_category 
              LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
              LEFT JOIN tbl_state as s ON s.state_id=b.buss_state ".$where;*/
         $sql="select  b.*,CONCAT(u.user_fname,' ',u.user_lname) as userFullName,s.state_name as stateName,ctr.country_name as countryName
              from tbl_business_info as b
              LEFT JOIN tbl_user as u ON b.user_id=u.user_id               
              LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
              LEFT JOIN tbl_state as s ON s.state_id=b.buss_state ".$where;
		
      	return $this->db->query($sql)->result_array();
		//echo $this->db->last_query();
    }
    function getDealList($where='',$sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL)
    {
        
        $orderString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderString=" ORDER BY $sortBy $sortType";
        else
            $orderString=" ORDER BY d.dealId DESC";
        
        $limitstring="";
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $orderString.=$limitstring;
        $where.=$orderString;
        
        
        $sql="SELECT d.*,b.buss_name,b.buss_address,b.buss_addr_addon,b.buss_city,b.buss_zip_code,b.buss_phone,b.buss_category,c.catName,s.state_name as stateName,ctr.country_name as countryName
             FROM tbl_deals as d 
             JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
             LEFT JOIN tbl_category as c ON c.catId=b.buss_category
             LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
             LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
             $where";
        
        return $this->db->query($sql)->result_array();
    }
    
    function countTotalDeals($where=NULL)
    {
        $sql="SELECT count(*) as totalRecords
             FROM tbl_deals as d 
             JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
             LEFT JOIN tbl_category as c ON c.catId=b.buss_category
             $where";
        
        $result= $this->db->query($sql)->result_array();
        return $result[0]['totalRecords'];
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
	function get_userinfo()
	{
		$array = array('user_acc_status' =>'A');
		$this->db->select('user_fname, user_lname, user_email');
		$this->db->where($array); 
		$sql = $this->db->get('tbl_user');
		//echo $this->db->last_query();
		return $sql->result_array();
	}
	function get_user_business_list($sortBy=NULL,$sortType=NULL,$limit=NULL,$offset=NULL,$where)
	{
		$orderString="";
        if($sortBy!=NULL && $sortType!=NULL)        
            $orderString=" ORDER BY $sortBy $sortType";
        else
            $orderString=" ORDER BY buss_id DESC";
        
        $limitstring="";
        if($limit!=NULL)
            $limitstring=" LIMIT $offset,$limit";
        
        if($limit!=NULL && $offset!=NULL)
            $limitstring=" LIMIT $offset, $limit";
        
        $orderString.=$limitstring;
        $where.=$orderString;
        
        $sql="select  b.*,CONCAT(u.user_fname,' ',u.user_lname) as userFullName,s.state_name as stateName,ctr.country_name as countryName
            FROM tbl_business_info as b
            LEFT JOIN tbl_user as u ON b.user_id=u.user_id 
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
            ".$where;
        return $this->db->query($sql)->result_array();
	
	}
	
}

/* End of file mdgeneraldml.php */
/* Location: ./application/models/mdgeneraldml.php */
