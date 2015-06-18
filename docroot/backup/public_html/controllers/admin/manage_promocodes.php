<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_promocodes extends CI_Controller {
  
    function __construct()  
    {
            parent::__construct();
            _authenticateAdmin();
            //$this->load->model('db_transact_model');
            $this->load->model('admin_model');
            $this->load->model('mdgeneraldml');
            $this->load->library('form_validation');
            $this->load->library('pagination');
            $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }


function index($sort_by='pc_id', $sort_type='Desc', $offset=0) 
    {             
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_promocodes/index/';

        //get and set pagination config variables
        $url_segment = 6;
		$cnd = array('tbl_promo_codes.pc_status <> ' => 'D');
        $limit = ADMIN_PAGING_LIMIT;             
        $data = _getPagingVaiables('tbl_promo_codes', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type,$cnd);   
		$order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $join[1] = array('tableName' => 'tbl_subscription_plans', 'columnNames' => 'tbl_subscription_plans.subs_plan_id = tbl_promo_codes.pc_plan_id','jType'=>'LEFT');
		$join[2] = array('tableName' => 'tbl_subscription_sub_plans', 'columnNames' => 'tbl_subscription_sub_plans.subs_sub_plan_id = tbl_promo_codes.pc_plan_type_id','jType'=>'LEFT');
		$select = 'tbl_promo_codes.*,tbl_subscription_plans.subs_plan_name,tbl_subscription_sub_plans.subs_sub_plan_name';
		$data['records'] = $this->mdgeneraldml->select($select,'tbl_promo_codes' ,$cnd, $order_by, $limit, $offset,$join,2);
		$this->load->view('admin/includes/header');	
        $this->load->view('admin/vwPromoCode',$data);
        $this->load->view('admin/includes/footer');		
    }
    
     function view_details($subs_plan_id=NULL)
    {
        if($subs_plan_id!=NULL && ($this->admin_model->isRecordExist('tbl_subscription_plans', array('subs_plan_id' => $subs_plan_id))))
        {
           $data['plan_view']= $this->mdgeneraldml->select("*","tbl_subscription_plans",array("subs_plan_id"=>$subs_plan_id));           
            $data['subs_plan_id']=$subs_plan_id;
            $data['sub_plan_view']= $this->mdgeneraldml->select("*","tbl_subscription_sub_plans",array("subs_plan_id"=>$subs_plan_id));  
            
          //  echo '<pre>'; print_r($data); die;
            $data['plan_name']=$data['plan_view'][0]['subs_plan_name']; 
            
            $data['ann_price']= $data['sub_plan_view'][0]['subs_sub_plan_price'];             
            $data['ann_price_period']= $data['sub_plan_view'][0]['subs_sub_plan_period']; 
            $data['ann_price_created_date']= $data['sub_plan_view'][0]['subs_sub_plan_created_on']; 
            $data['ann_price_updated_date']= $data['sub_plan_view'][0]['subs_sub_plan_updated_on']; 
            
            $data['mon_price']=  $data['sub_plan_view'][1]['subs_sub_plan_price'];
            $data['mon_price_period']=  $data['sub_plan_view'][1]['subs_sub_plan_period']; 
            $data['mon_price_created_date']=  $data['sub_plan_view'][1]['subs_sub_plan_created_on']; 
            $data['mon_price_updated_date']=  $data['sub_plan_view'][1]['subs_sub_plan_updated_on']; 
             
            $this->load->view('admin/includes/header');
            $this->load->view('admin/subscription_plans_details_view',$data);
           $this->load->view('admin/includes/footer');
           
        }else{
             $this->session->set_flashdata('error', '!! Plan not exist.!!');
             redirect(ADMIN_FOLDER_NAME.'/subscription_plans');
        } 
    }
    function addPromocodes(){
		if(isset($_POST['submit']) && !empty($_POST['submit'])){
			
			$data_err=array(
                        'plan_name'       => $this->input->post('plan_name'),
                        'plan_type'       => $this->input->post('plan_type'),
						'discount'        => $this->input->post('discount'),
						'promo_code'      => $this->input->post('promo_code'),
			      );

            //$this->form_validation->set_rules('plan_name', 'Plan Name', 'xss_clean|trim|required');
			$this->form_validation->set_rules('plan_type', 'Plan Type', 'xss_clean|trim|required'); 
			$this->form_validation->set_rules('discount', 'Discount', 'xss_clean|trim|required|numeric');
			$this->form_validation->set_rules('promo_code', 'Promo code', 'xss_clean|trim|required|is_unique[tbl_promo_codes.pc_code]');

            if ($this->form_validation->run() == FALSE)
            {               
				$data_err['plans'] = $this->mdgeneraldml->select("subs_plan_name,subs_plan_id","tbl_subscription_plans",array("subs_plan_status"=> 'A'));
				$join_b[1] = array('tableName' => 'tbl_subscription_plans', 'columnNames' => 'tbl_subscription_plans.subs_plan_id = tbl_subscription_sub_plans.subs_plan_id','JType' => 'LEFT');
				$data_err['plan_types'] = $this->mdgeneraldml->select("tbl_subscription_plans.subs_plan_name,tbl_subscription_sub_plans.subs_sub_plan_name,tbl_subscription_sub_plans.subs_plan_id,tbl_subscription_sub_plans.subs_sub_plan_id","tbl_subscription_sub_plans",'','','','',$join_b,1);   
				$this->load->view('admin/includes/header');	
				$data_err['action'] = 'add';
                $this->load->view('admin/vwAddPromoCode',$data_err);
                $this->load->view('admin/includes/footer');
            }else{
				$recExp = explode('_', $this->input->post('plan_type'));
				if(!empty($recExp)){
				$insertData=array(
                        'pc_plan_type_id'         =>$recExp[0], 
                        'pc_plan_id'     =>$recExp[1],                       
                        'pc_code'      =>$this->input->post('promo_code'),
                        'pc_discount'      => $this->input->post('discount'),
                        'pc_status'             =>"A"
                  );
				}else{
					$insertData=array(
                        'pc_code'      =>$this->input->post('promo_code'),
                        'pc_discount'      => $this->input->post('discount'),
                        'pc_status'             =>"A"
					);
					
				}
               $tableName = 'tbl_promo_codes';              
               $result = $this->mdgeneraldml->insert($tableName, $insertData);
               $this->session->set_flashdata('success', 'Promo code has been successfully added.');
               redirect(ADMIN_FOLDER_NAME.'/manage_promocodes');
			}
		
		}else{
			$data=array(
                        'plan_name'       => '',
                        'plan_type'       => '',
						'discount'        => '',
						'promo_code'      => '',
			      );
			//$data['plans'] = $this->mdgeneraldml->select("subs_plan_name,subs_plan_id","tbl_subscription_plans",array("subs_plan_status"=> 'A'));
			$join_b[1] = array('tableName' => 'tbl_subscription_plans', 'columnNames' => 'tbl_subscription_plans.subs_plan_id = tbl_subscription_sub_plans.subs_plan_id','JType' => 'LEFT');
			$data['plan_types'] = $this->mdgeneraldml->select("tbl_subscription_plans.subs_plan_name,tbl_subscription_sub_plans.subs_sub_plan_name,tbl_subscription_sub_plans.subs_plan_id,tbl_subscription_sub_plans.subs_sub_plan_id","tbl_subscription_sub_plans",'','','','',$join_b,1); 
		
			//$data['records'] = $this->mdgeneraldml->select($select,'tbl_promo_codes' ,$cnd, $order_by, $limit, $offset,$join,2);
			
			$data['action'] = 'add';
			$this->load->view('admin/includes/header');	
			$this->load->view('admin/vwAddPromoCode',$data);
			$this->load->view('admin/includes/footer');			
		}
	}
	
	function EditPromocodes($promo_id=NULL)
    {
        $rec = $this->mdgeneraldml->select("*","tbl_promo_codes",array("pc_id"=> $promo_id));
		if(isset($_POST['submit']) && !empty($_POST['submit'])){
			
			$data_err=array(
                        'plan_name'       => $this->input->post('plan_name'),
                        'plan_type'       => $this->input->post('plan_type'),
						'discount'        => $this->input->post('discount'),
						'promo_code'      => $this->input->post('promo_code'),
			);
			$promo_code_hidden = $this->input->post('promo_code_hidden');
			$promo_code_new   = $this->input->post('promo_code');		
          //  $this->form_validation->set_rules('plan_name', 'Plan Name', 'xss_clean|trim|required');
			$this->form_validation->set_rules('plan_type', 'Plan Type', 'xss_clean|trim|required'); 
			$this->form_validation->set_rules('discount', 'Discount', 'xss_clean|trim|required|numeric');
			//Check promo code
			if($promo_code_hidden != $promo_code_new){
				$this->form_validation->set_rules('promo_code', 'Promo code', 'xss_clean|trim|required|is_unique[tbl_promo_codes.pc_code]');
			}

            if ($this->form_validation->run() == FALSE)
            {               
				$data_err = array(
                        'plan_name'       => $rec[0]['pc_plan_id'],
						'pc_id'       => $promo_id,
                        'plan_type'       => $rec[0]['pc_plan_type_id']."_".$rec[0]['pc_plan_id'],
						'discount'        => $rec[0]['pc_discount'],
						'promo_code'      => $rec[0]['pc_code'],
			      );
				$data_err['plans'] = $this->mdgeneraldml->select("subs_plan_name,subs_plan_id","tbl_subscription_plans",array("subs_plan_status"=> 'A'));
				$data_err['plan_types']= $this->mdgeneraldml->select("subs_sub_plan_id,subs_sub_plan_name","tbl_subscription_sub_plans",array("subs_sub_plan_status"=> 'A'));  
				$this->load->view('admin/includes/header');	
				$data_err['action'] = 'edit';
                $this->load->view('admin/vwAddPromoCode',$data_err);
                $this->load->view('admin/includes/footer');
            }else{
				$recExp = explode('_', $this->input->post('plan_type'));
				$updateData = array(
                        'pc_plan_type_id'         => $recExp[0], 
                        'pc_plan_id'     => $recExp[1],                       
                        'pc_code'      =>$this->input->post('promo_code'),
                        'pc_discount'      => $this->input->post('discount'),
						'pc_updated_on' => _getDateAndTime()
                  );
				$tableName = 'tbl_promo_codes';              
				$where = array('pc_id' => $promo_id);
				$result = $this->mdgeneraldml->update($where, $tableName, $updateData);
				$this->session->set_flashdata('success', 'Promo code has been updated successfully.');
                redirect(ADMIN_FOLDER_NAME.'/manage_promocodes');
			}
		
		}else{
			
			
			$data = array(
                        'plan_name'       => $rec[0]['pc_plan_id'],
						'pc_id'       => $promo_id,
                        'plan_type'       => $rec[0]['pc_plan_type_id']."_".$rec[0]['pc_plan_id'],
						'discount'        => $rec[0]['pc_discount'],
						'promo_code'      => $rec[0]['pc_code'],
			      );
			
			$data['plans'] = $this->mdgeneraldml->select("subs_plan_name,subs_plan_id","tbl_subscription_plans",array("subs_plan_status"=> 'A'));
			$join_b[1] = array('tableName' => 'tbl_subscription_plans', 'columnNames' => 'tbl_subscription_plans.subs_plan_id = tbl_subscription_sub_plans.subs_plan_id','JType' => 'LEFT');
			$data['plan_types'] = $this->mdgeneraldml->select("tbl_subscription_plans.subs_plan_name,tbl_subscription_sub_plans.subs_sub_plan_name,tbl_subscription_sub_plans.subs_plan_id,tbl_subscription_sub_plans.subs_sub_plan_id","tbl_subscription_sub_plans",'','','','',$join_b,1);   
			$data['action'] = 'edit';
		
			$this->load->view('admin/includes/header');	
			$this->load->view('admin/vwAddPromoCode',$data);
			$this->load->view('admin/includes/footer');			
		}
    }
    
     function change_status($sort_by='pc_id', $sort_type='DESC', $offset=0,$promo_id=NULL, $status=NULL) 
    {
        if(isset($promo_id)){
			$tableName = 'tbl_promo_codes';              
			$where = array('pc_id' => $promo_id);
			$result = $this->mdgeneraldml->update($where, $tableName, array('pc_status'=> $status));
			$this->session->set_flashdata('success', 'Status updated successfully.');
			redirect(ADMIN_FOLDER_NAME.'/manage_promocodes');
		}else{
			$this->session->set_flashdata('error', 'Status could not be deleted.');
			redirect(ADMIN_FOLDER_NAME.'/manage_promocodes');
		}
    }
	
	function delete($promo_id=NULL)
    {
        if(isset($promo_id)){
			$tableName = 'tbl_promo_codes';              
			$where = array('pc_id' => $promo_id);
			$result = $this->mdgeneraldml->update($where, $tableName, array('pc_status'=> 'D'));
			$this->session->set_flashdata('success', 'Promo code has been Deleted successfully.');
			redirect(ADMIN_FOLDER_NAME.'/manage_promocodes');
		}else{
			$this->session->set_flashdata('error', 'Promo code could not be deleted.');
			redirect(ADMIN_FOLDER_NAME.'/manage_promocodes');
		}
    }    
}