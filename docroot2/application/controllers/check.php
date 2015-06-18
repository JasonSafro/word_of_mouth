<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Check extends CI_Controller {

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
		$this->load->helper('common_functions_helper');
        $this->load->library('form_validation');        
        $this->load->library('user_agent');
    }
  
    public function index() {        
/*        $where = array('catStatus' => 'Active', 'catAdminAdded' => '1');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        $data['testimonials'] = $this->mdgeneraldml->select('*', 'tbl_testimonials', array('tmlStatus'=>'Active'));
        //echo '<pre>'; print_r($data['testimonials']); die;
        $this->load->view('includes/header', $data);
        $this->load->view('home_view');
        $this->load->view('includes/footer');*/
		//echo $stt= "SELECT rat_id, user_id, buss_id, ceil( avg( rat_stars ) ) FROM tbl_ratings GROUP BY buss_id";
		$group_by = 'buss_id';
		$arr = $this->mdgeneraldml->select_rat();
/*		echo "<pre>";
		print_r($arr);
		exit;*/
	
		$i=1;
		foreach($arr as $row)
		{
			$buss_id = $row->buss_id;
			$avg = $row->avrg;
			$tableName = 'tbl_business_info';
			$updateData = array('buss_avg_ratings' => $avg);
			$where = array('buss_id' => $buss_id);
			$flag = $this->mdgeneraldml->update($where, $tableName, $updateData);
			
			if($flag)
			{
				
				echo $i;
				$i++;
			}
			else echo "failed";
		}		
    }


}
?>