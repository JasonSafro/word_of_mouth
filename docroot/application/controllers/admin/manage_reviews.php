<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_Reviews extends CI_Controller {
  
    function __construct()  
    {
            parent::__construct();
            _authenticateAdmin();
            $this->load->model('admin_model');
            $this->load->model('mdgeneraldml');
            $this->load->model('db_transact_model');			
            $this->load->library('form_validation');
            $this->load->library('pagination');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='rvwId', $sort_type='DESC', $offset=0) 
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_reviews/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        
           
        $where=array('rvwStatus !='=>'Deleted');
        $data = _getPagingVaiables('tbl_business_reviews', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$where); 
        
        $whereReview="WHERE rvwStatus!='Deleted'";
        $data['reviewList']=$this->admin_model->getBusinessReviews($whereReview,$sort_by,$sort_type,$limit,$offset);
        
       
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/manage_reviews_vw',$data);
        $this->load->view('admin/includes/footer');		
    }
    
    function view($rvwId='',$sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
        $where=array('rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!='' && _isRecordExist('tbl_business_reviews',$where))
        {
            $whereReview="WHERE rvwStatus!='Deleted' AND rvwId=$rvwId";
            $data['review']=$this->admin_model->getBusinessReviews($whereReview);
            $this->load->view('admin/includes/header');	
            $this->load->view('admin/manage_reviews_detailpage_vw',$data);
            $this->load->view('admin/includes/footer');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }        
    }
    
    function save_satus($rvwId=NULL)
    {
        $where=array('rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!=NULL && _isRecordExist('tbl_business_reviews',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('rvwStatus'=>$status,'rvwUpdatedOn'=>_getDateAndTime());
            if($status=="Disputed"){
                $updataeData['rvwDesputedReason']=$this->input->post('rvwDesputedReason');
            }
			
			$where_1 = array('rvwId'=>$rvwId); 
			$rvw_info=$this->mdgeneraldml->select('rvwReviewerId, rvwBusinessUserId, rvwBusinessId, rvwRatingProfessionalism, rvwRatingDependability, rvwRatingPrice, rvwRatingOverall','tbl_business_reviews',$where_1);
			
			$user_id = $rvw_info[0]['rvwBusinessUserId'];
			$rvwReviewerId = $rvw_info[0]['rvwReviewerId'];
			$bus_id = $rvw_info[0]['rvwBusinessId'];
			
			$rvwRatingProfessionalism = $rvw_info[0]['rvwRatingProfessionalism'];
			$rvwRatingDependability = $rvw_info[0]['rvwRatingDependability'];
			$rvwRatingPrice = $rvw_info[0]['rvwRatingPrice'];
			$rvwRatingOverall = $rvw_info[0]['rvwRatingOverall'];
			
			$user_ratings = ($rvwRatingProfessionalism + $rvwRatingDependability + $rvwRatingPrice + $rvwRatingOverall)/4;
			
			$user_ratings = round($user_ratings);
			
			
            if($status=="Published"){
                //check whether reating has given of this user (who has given rating) with business id
                $this->insert_bus_ratings($user_id,$bus_id,$user_ratings);
            }else{
                //remove 
                $this->remove($user_id,$bus_id,$user_ratings);
            }
			
			
            $this->mdgeneraldml->update($where, 'tbl_business_reviews', $updataeData);
            $this->session->set_flashdata('success',"Review status changed successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }      
    }
    
	public function insert_bus_ratings($user_id,$bus_id,$user_ratings)
    {
            //Store in DB
           
		   
		    $arr = array("user_id" => $user_id,
                "buss_id" => $bus_id,
                "rat_stars" => $user_ratings
            );
			
            //If already rated by user
            $tbl = "tbl_ratings";
            $where = array("user_id" => $user_id, "buss_id" => $bus_id);
            $db_det = $this->db_transact_model->get_single_record($tbl, $where);

            if (empty($db_det))
            {
				$data = $this->db->insert("tbl_ratings", $arr);

/*				if(isset($data))
				echo 'Inserted';
				exit;*/
            }

            //Get Total Ratings
            $tbl_ratings = 'tbl_ratings';
            $where2 = array("buss_id" => $bus_id);
            $total_ratings = $this->mdgeneraldml->select('rat_stars', 'tbl_ratings', $where2);

			
			$avg_ratings = 0;
			$avg_rating_db = array("buss_avg_ratings" => $avg_ratings);
            //print_r($total_ratings);
            if (count($total_ratings) > 0)
            {
                $total_ratings_sum = 0;
                for ($i = 0; $i < count($total_ratings); $i++)
                {
                    // $total_ratings_sum=$total_ratings[$i]['rat_stars'];
                    $total_ratings_sum = $total_ratings_sum + $total_ratings[$i]['rat_stars'];
                }

                //Update business info
                $avg_ratings = round($total_ratings_sum/count($total_ratings));
                $avg_rating_db = array("buss_avg_ratings" => $avg_ratings);
				$where3 = array("buss_id" => $bus_id);
				$data = $this->mdgeneraldml->update($where3, 'tbl_business_info', $avg_rating_db);


                
            }
    }
        
	function remove($user_id,$bus_id,$user_ratings){
		//Store in DB
		$arr = array("user_id" => $user_id,
			"buss_id" => $bus_id,
			"rat_stars" => $user_ratings
		);
		//If already rated by user
		$tbl = "tbl_ratings";
		$where = array("user_id" => $user_id, "buss_id" => $bus_id);
		$db_det = $this->db_transact_model->get_single_record($tbl, $where);

		if (!empty($db_det))
		{
			//use delete query (delete reation that has given by user)
			//$data = $this->db->delete("tbl_ratings", $arr);
			$data_delete = $this->mdgeneraldml->delete($arr,'tbl_ratings');
/*				if(isset($data_delete))
			echo 'Deleted';
			exit;	*/
			
			//Get Total Ratings
			$tbl_ratings = 'tbl_ratings';
			$where2 = array("buss_id" => $bus_id);
			$total_ratings = $this->mdgeneraldml->select('rat_stars', 'tbl_ratings', $where2);
			//print_r($total_ratings);
			$avg_ratings=0;
			$avg_rating_db = array("buss_avg_ratings" => $avg_ratings);
			if (count($total_ratings) > 0)
			{
				$total_ratings_sum = 0;
				for ($i = 0; $i < count($total_ratings); $i++)
				{
					// $total_ratings_sum=$total_ratings[$i]['rat_stars'];
					$total_ratings_sum = $total_ratings_sum + $total_ratings[$i]['rat_stars'];
				}

				//Update business info
				$avg_ratings = round($total_ratings_sum/count($total_ratings));
				$avg_rating_db = array("buss_avg_ratings" => $avg_ratings);
			}
			$where3 = array("buss_id" => $bus_id);
			$data = $this->mdgeneraldml->update($where3, 'tbl_business_info', $avg_rating_db);
		}
	}	
	
	
    function delete($rvwId='',$sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
        $where=array('rvwStatus !='=>'Deleted','rvwId'=>$rvwId);
        if($rvwId!='' && _isRecordExist('tbl_business_reviews',$where))
        {
            $status=$this->input->post('status');
            $updataeData=array('rvwStatus'=>'Deleted','rvwUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update($where, 'tbl_business_reviews', $updataeData);
            $this->session->set_flashdata('success',"Review deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        }else{
            $this->session->set_flashdata('error','Record not exist.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews');
        } 
    }
    
    function delete_selected($sort_by='rvwId', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST))
        {            
            $whereIn=array('column'=>'rvwId','fields'=>$_POST['chkmsg']);
            $updataeData=array('rvwStatus'=>'Deleted','rvwUpdatedOn'=>_getDateAndTime());
            $this->mdgeneraldml->update_in('tbl_business_reviews', $updataeData,'',$whereIn);
            //echo $this->db->last_query();
            $this->session->set_flashdata('success',"selected reviews has been deleted successfully.");
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }else{
            $this->session->set_flashdata('error','Please select at list single record.');
            redirect(ADMIN_FOLDER_NAME.'/manage_reviews/index/'.$sort_by.'/'.$sort_type.'/'.$offset);
        }    
    }
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */