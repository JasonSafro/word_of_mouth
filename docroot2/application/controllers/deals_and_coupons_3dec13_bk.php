<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Deals_and_coupons extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model	
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model
    }

    public function index($offset=0){
        
        $limit=30;
        $sortBy="dealId";
        $sortType="DESC";           
        $data['dealList'] = $this->WGModel->getDealList('',$sortBy,$sortType,$limit,$offset);
        $data['totalRecords']=$this->WGModel->countTotalRecords('tbl_deals');
        
        $data['limit']=$limit;
        $data['offset']=$offset;
        
        //get categories
        $where = array('catStatus' => 'Active');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        
        $this->load->view('includes/header');
        $this->load->view('deals_coupons_view',$data);
        $this->load->view('includes/footer');
    }
    
    function getNextDeals($offset=0){
        
        $limit=30;
        $sortBy="dealId";
        $sortType="DESC";
        $data['dealList'] = $this->WGModel->getDealList('',$sortBy,$sortType,$limit,$offset);
        $data['totalRecords']=$this->WGModel->countTotalRecords('tbl_deals');
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        echo $this->load->view('ajax_pages/deals_coupons_ajax_vw',$data,true);
    }
    
    function view($dealId){
        
        $where="WHERE dealId=$dealId";
        $dealInfo = $this->WGModel->getDealList($where);
        
        if(!empty($dealInfo))
        {    
            $data['dealInfo'] = $dealInfo[0];
            $this->load->view('includes/header');
            $this->load->view('deal_coupons_detail_vw',$data);
            $this->load->view('includes/footer');
        }else{
            $this->session->set_flashdata('error','Deal does not exist.');
            redirect('deals_and_coupons');
        }    
    }
    
    function deals_by_category($catId)
    {
        $offset=0;
        $limit=30;
        $sortBy="dealId";
        $sortType="DESC";
        
        $where="WHERE buss_category=$catId";
        $data['dealList'] = $this->WGModel->getDealList($where,$sortBy,$sortType,$limit,$offset);
        
        $data['totalRecords']=$this->WGModel->countTotalDeals($where);
        //echo $this->db->last_query();die;
        
        $data['catId']=$catId;
        $data['limit']=$limit;
        $data['offset']=$offset;        
        
        $where=array('catId'=>$catId);
        $data['catagotyInfo']=$this->mdgeneraldml->select('*', 'tbl_category', $where);
        
       $this->load->view('includes/header');
       $this->load->view('deals_by_category_list_vw',$data);
       $this->load->view('includes/footer');
    }

    function getNextDealsBCategory($catId,$offset=0)
    {
        $limit=30;
        $sortBy="dealId";
        $sortType="DESC";
        $where="WHERE buss_category=$catId";
        $data['dealList'] = $this->WGModel->getDealList($where,$sortBy,$sortType,$limit,$offset);
        $data['totalRecords']=$this->WGModel->countTotalDeals($where);
        $data['limit']=$limit;
        $data['offset']=$offset;        
        $data['catId']=$catId;
        
        
        
        echo $this->load->view('ajax_pages/deals_coupons_ajax_vw',$data,true);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */