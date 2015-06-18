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
class Dashboard_model extends CI_Model {

    /**
     * Constructor
     */
    function dashboard_model() {
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
            $where.=" AND bussStatus != 'Deleted'";
        }else{
            $where=" WHERE bussStatus != 'Deleted'";
        }
        
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
        
        $sql="SELECT d.*,b.buss_id,b.buss_name,b.buss_address,b.buss_avg_ratings,b.buss_addr_addon,b.buss_city,b.buss_zip_code,b.buss_phone,b.buss_category,
        b.buss_social_media_channel_1,b.buss_social_media_channel_2,b.buss_social_media_channel_3,b.buss_social_media_channel_4,b.buss_web_address,
        s.state_name as stateName,ctr.country_name as countryName 
            FROM tbl_deals as d 
            JOIN tbl_business_info as b ON b.buss_id=d.dealBusinessId
            
            LEFT JOIN tbl_country ctr ON ctr.country_code=b.buss_country
            LEFT JOIN tbl_state as s ON s.state_id=b.buss_state
             $where";
        
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
        
    
}

/* End of file mdgeneraldml.php */
/* Location: ./application/models/mdgeneraldml.php */
