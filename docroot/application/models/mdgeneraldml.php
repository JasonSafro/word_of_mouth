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
class mdgeneraldml extends CI_Model {

    /**
     * Constructor
     */
    function mdgeneraldml() {
        parent::__construct();
        $this->load->database();
    }

    
    function getLogin($loginInfo)
    {
         $sql="SELECT * FROM tbl_users where userEmail='".$loginInfo['userEmail']."' AND userPassword='".$loginInfo['userPassword']."'";
	return $this->db->query($sql)->result_array();
    }
    /**
     * Fetch the data from table
     *
     * @access	public
     * @param   $select         string      Which fields want to fetch from database
     *          $from           string      From table name
     *          $where          string      Condition for fetch (optional)
     *          $orderBy        string      Order by statement (optional)
     *          $num            integer     How many records want to fetch
     *          $offset         integer     Fetch records from offset
     *          $join           string      Join with table
     *          $joinCnt        integer     number of joins
     * @return	array                       Records array
     */
    function select($select, $from, $where=NULL, $orderBy=NULL, $num=NULL, $offset=NULL, $join = NULL, $joinCnt = 1, $group_by=NULL) {
        $this->db->select($select);
        $this->db->from($from);

        //if there is any joining with n($joinCnt) another tables...................
        if ($join != NULL) {
            for ($i = 1; $i <= $joinCnt; $i++) {
                $this->db->join($join[$i]['tableName'], $join[$i]['columnNames']);
            }
        }

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

        if ($group_by != NULL) {
            $this->db->group_by($group_by);
        }

        return $this->db->get()->result_array();
    }
    
    
    	
	function select1($select, $from, $where=NULL, $orderBy=NULL, $num=NULL, $offset=NULL, $join = NULL, $joinCnt = 1,$group_by = NULL)
	{

		$this->db->select($select);
		$this->db->from($from);
	
		//if there is any joining with n($joinCnt) another tables .................
		if($join != NULL)
		{
			for($i = 1; $i <= $joinCnt; $i++)
			{
				$left_join = '';
				if(!empty($join[$i]['jType']))
					$left_join = $join[$i]['jType'];
				$this->db->join($join[$i]['tableName'],$join[$i]['columnNames'], $left_join);
			
			}
		}		
		//if there is no any where criteria..............
		if($where != NULL)
		{
			$this->db->where($where);
		}
		
		//check for group by
		if($group_by != NULL)
		{
			$this->db->group_by($group_by); 
		}
		
		//if result want sorted 
		if($orderBy != NULL)
		{
			$this->db->order_by($orderBy['colname'],$orderBy['type']);
		}
		//chk fror pagination pages......................
		if($num != NULL or $offset != NULL)
		{
			$this->db->limit($num, $offset);
		}		
		///echo $this->db->last_query();exit;
		return $this->db->get()->result_array();
	}
        
    function select_rat()
	{
		$sql = "SELECT rat_id, user_id, buss_id, ceil( avg( rat_stars ) ) as avrg FROM tbl_ratings GROUP BY buss_id";
		
		return $this->db->query($sql)->result();
	}
        
        

    /**
     * Insert data in table
     *
     * @access	public
     * @param   string      Table name
     *          array       Data with records want to insert
     * @return	array       with last insert id, number of rows affected and last query
     */
    function insert($tableName, $insertData)
	{
        $this->db->insert($tableName, $insertData);
        $arr['last_insertId'] = $this->db->insert_id();
        $arr['affectedRow'] = $this->db->affected_rows();
        $arr['last_query'] = $this->db->last_query();
        return $arr;
    }

    /**
     * Update table data
     *
     * @access	public
     * @param   array       Where condition varibles in array
     *          string      Table name
     *          array       Data want to update
     * @return	boolean     result of the query (number of rows affected)
     */
    function update($where, $tableName, $updateData)
	{
        $this->db->where($where);
        return $this->db->update($tableName, $updateData);
        /* return $this->db->last_query(); */
    }
	
	function update_in($tableName,$updateData,$where=NULL,$whereIn=NULL)
	{
		if($whereIn!=NULL)
			$this->db->where_in($whereIn['column'],$whereIn['fields']);
				
		if($where!=NULL)		
			$this->db->where($where);
			
		return $this->db->update($tableName,$updateData);
	}
	
    /**
     * Delete table record
     *
     * @access	public
     * @param   array       Where condition varibles in array
     *          string      Table name
     * @return	boolean     result of the query
     */
    function delete($where, $tableName)
    {
        return $this->db->delete($tableName, $where);
    }
	
	
   
    
    function delete_in($tableName,$whereIn,$where=NULL)
	{
		if($where!=NULL)
			$this->db->where($where);
			
		$this->db->where_in($whereIn['column'],$whereIn['fields']);
		return $this->db->delete($tableName);
	}
    /**
     * Select the records with like functionality
     *
     * @access	public
     * @param   string      Which fields want to fetch from database
     *          string      Table name
     *          array       Like  variables in array (optional)
     *          string      Condition for fetch (optional)
     *          string      Order by statement (optional)
     *          integer     How many records want to fetch
     *          integer     Fetch records from offset
     *          string      Join with table
     *          integer     number of joins
     * @return	array                       Records array
     */
    function select_like($select, $from, $like_parameter=NULL, $where=NULL, $orderBy=NULL, $num=NULL, $offset=NULL, $join = NULL, $joinCnt = 1) {
        $this->db->select($select);
        $this->db->from($from);

        //if there is any joining with n($joinCnt) another tables .................
        if ($join != NULL) {
            for ($i = 1; $i <= $joinCnt; $i++) {
                $this->db->join($join[$i]['tableName'], $join[$i]['columnNames']);
            }
        }

        //if there is no any where criteria..............
        if ($where != NULL) {
            $this->db->where($where);
        }

        if ($like_parameter != NULL && $like_parameter != '') {
            /* $this->db->or_like($like_parameter); */
            $this->db->where($like_parameter);
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

    /**
     * Fetch the data from table
     *
     * @access	public
     * @param   $select         string      Which fields want to fetch from database
     *          $from           string      From table name
     *          $where_in       string      Condition for fetch with in(optional)
     *          $where          string      Condition for fetch (optional)
     *          $orderBy        string      Order by statement (optional)
     *          $num            integer     How many records want to fetch
     *          $offset         integer     Fetch records from offset
     *          $join           string      Join with table
     *          $joinCnt        integer     number of joins
     * @return	array                       Records array
     */
    function select_in($select, $from, $in_para=NULL, $where_in=NULL, $where=NULL, $orderBy=NULL, $num=NULL, $offset=NULL, $join = NULL, $joinCnt = 1) {
        $this->db->select($select);
        $this->db->from($from);

        //if there is any joining with n($joinCnt) another tables .................
        if ($join != NULL) {
            for ($i = 1; $i <= $joinCnt; $i++) {
                $this->db->join($join[$i]['tableName'], $join[$i]['columnNames']);
            }
        }

        //if there is no any where criteria..............
        if ($where != NULL) {
            $this->db->where($where);
        }

        //if there is no any where in criteria..............
        if ($where_in != NULL && $in_para != NULL) {
            if (is_array($in_para) && count($in_para) > 0)
                foreach ($in_para as $para)
                    if (array_key_exists($para, $where_in))
                        $this->db->where_in($para, $where_in[$para]);
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

    function get_table_total_count($from, $where=NULL, $like_parameter=NULL, $where_in=NULL) {
        $this->db->from($from);

        if ($where != NULL) {
            $this->db->where($where);
        }

        if ($like_parameter != NULL && $like_parameter != '') {
            $this->db->where($like_parameter);
        }

        //if there is no any where in criteria..............
        if ($where_in != NULL) {
            if (count($where_in) > 0)
                foreach ($where_in as $para => $win_ind)
                    $this->db->where_in($para, $where_in[$para]);
        }

        return $this->db->count_all_results();
    }
	
    function doUpdate($tableName,$updateData,$where=NULL)
    {
            if($where!=NULL)
                    $this->db->where($where);
         return $this->db->update($tableName, $updateData);
    }



    function select_not_in($select, $from, $in_para=NULL, $where_in=NULL, $where=NULL, $orderBy=NULL, $num=NULL, $offset=NULL, $join = NULL, $joinCnt = 1) {
        $this->db->select($select);
        $this->db->from($from);

        //if there is any joining with n($joinCnt) another tables .................
        if ($join != NULL) {
            for ($i = 1; $i <= $joinCnt; $i++) {
                $this->db->join($join[$i]['tableName'], $join[$i]['columnNames']);
            }
        }

        //if there is no any where criteria..............
        if ($where != NULL) {
            $this->db->where($where);
        }

        //if there is no any where in criteria..............
        if ($where_in != NULL && $in_para != NULL) {
            if (is_array($in_para) && count($in_para) > 0)
                foreach ($in_para as $para)
                    if (array_key_exists($para, $where_in))
                        $this->db->where_not_in($para, $where_in[$para]);
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

    function getStyle_iLike($select,$styleName)
    {
        $sql="SELECT ".$select." FROM tbl_style where stl_name iLIKE '".$styleName."'";
	return $this->db->query($sql)->result_array();
    }
    

}

/* End of file mdgeneraldml.php */
/* Location: ./application/models/mdgeneraldml.php */
