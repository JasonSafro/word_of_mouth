<?php
class Db_transact_model extends CI_Model 
{
	function Db_transact_model()
	{
		$this->load->database();
	}
  	
	/**********************************************************************************
	*	Table of Contents: Global Database functions 19/12/2011
	*	Author(s) : Rajesh Patil < rajesh.patil@aviontechnolog.net > 
	*	1. globalinsert($tblname, $fields,$values);
	*	Insert record into the table.
	*****************************************************************************************/
	
	function cgi($tbl, $fl, $vl, $prn)
	{
		$this->db->insert($tbl,$this->sanitize($data));
		if($prn){
		print_r($this->db->last_query());
		exit;
		}
		return $this->db->insert_id();
	
	}
	/**************************************************************************************
	*	 Function : Creating for complex join query by passing directly condition string  19/12/2011
	*	Author(s) : Rajesh Patil < rajesh.patil@aviontechnolog.net > 
	*	2. globaljoinquery($tblname, $selectfields , $condition, $orderbyfield, $groupby, $ad, $limit)
	***************************************************************************************/
	
	function gj($tbl, $sf , $cd, $ob, $gb, $ad, $l, $prn)
	{
		 // Fetch data from blogs table
        $query = $this->db->get('blogs', $num, $offset);
        $result = $query->results();
        return $result;
	}
	
  	function get_uniqueId()
	{
		$sql_query="SELECT * from uuid_generate_v4()";
		return $this->db->query($sql_query)->result_array();	
	}
	
	
	
	function update_record( $tbl, $data, $cnd)
	{ 	
		$this->db->where( $cnd );	
		return $this->db->update( $tbl, $data);	
	}

	function chk_exist( $tbl, $cnd)
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		return $this->db->get()->result_array();
/*		print_r($this->db->last_query());
		exit;*/
	}	
	
	// Get single Record info
	function get_single_record( $tbl, $cnd)
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		return $this->db->get()->result_array();
	}
	
	//Delete single record
	function delete_single_record( $tbl, $cnd)
	{		
		return $this->db->delete($tbl,$cnd);
	}

	function get_user_role($uid = NULL)
	{
		$rinfo = '';
		if($uid != '')
		{
		$sql = "SELECT ur_descr from user_roles as r LEFT JOIN users ON users.user_role_id = r.ur_id WHERE users.user_id =".$uid;
		$rinfo = $this->db->query($sql)->result_array();
		}
		return $rinfo; 
	}
	
	//Get All Records
	function get_all_records( $tbl, $cnd, $ob, $ot='ASC')
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		$this->db->order_by( $ob, $ot);		
		$qry_info = $this->db->get()->result_array();
		//print_r($this->db->last_query());
		return $qry_info;
	}	
	function get_total_records($tbl)
    {
        $query = $this->db->query("SELECT count(*) as total_rows FROM ".$tbl);
        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->total_rows;
        }
        return 0;
    }
	 
	
	function get_records($tbl , $offset, $limit)
    {
        $query = $this->db->query("SELECT * FROM ".$tbl." LIMIT $offset, $limit");
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
    }
	// Get single Record info
	function get_singlerecord( $tbl, $cnd)
	{		
		$this->db->select('*');
		$this->db->from( $tbl );
		$this->db->where( $cnd );
		$tmp_res = $this->db->get()->result_array();
		return  $tmp_res[0];
	}
	
	function get_childsyById($parentId=0, $del_id, $e_id )
	{
		if($parentId != 0)
		{
			$cnd = "erc_parent_cat = ".$parentId." AND erc_e_id = ".$e_id;	
			$this->db->select('erc_id,erc_parent_cat');
			$this->db->from( 'entity_ref_category');
			$this->db->where( $cnd );
			$data = $this->db->get()->result_array();
		
			for($i = 0; $i<count($data); $i++) 
			{
				$_SESSION['TMP_ID'] .= ",".$data[$i]['erc_id'];
				$cnd1 = "erc_parent_cat = ".$data[$i]['erc_id'];
					
				if( $this->chk_exist('entity_ref_category', $cnd1))
					get_childsyById($data[$i]['erc_id'], $del_id,  $e_id); 
				else
					return  $del_id;
			}
		}	
		return $del_id;
	}
	
	function sanitize($data)
	{	
		$data = trim($data); // remove whitespaces (not a must though)
		if(get_magic_quotes_gpc()){ // apply stripslashes if magic_quotes_gpc is enabled
		$data = stripslashes($data); 
		}
		$data = mysql_real_escape_string($data); // a mySQL connection is required before using this function
		return $data;
	} 
		
	//Fetch records by query
	function sql_qry($sql)
	{
		return $this->db->query($sql)->result_array();
	}	
}
