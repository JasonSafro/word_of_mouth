<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reasons extends CI_Controller {
  
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

    function index($sort_by='reason_id', $sort_type='DESC', $offset=0) 
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/reasons/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = '';//array('user_acc_status != ' => 'D');
        $data = _getPagingVaiables('tbl_user', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);            
        $tbl = 'tbl_contact_reasons';
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['reasonList'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by, $limit, $offset);       
         
        //count total number of users
        $sql4="SELECT count(*) as total_count FROM tbl_contact_reasons ";
        $numTotalUsers=$this->admin_model->sqlQuery($sql4);
        $data['total_count']=$numTotalUsers[0]['total_count'];
        
        //$data['userList']=$this->admin_model->getUserList();
		
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/reason_view',$data);
        $this->load->view('admin/includes/footer');		
    }
	
	function add_new($reason_id='')
    {       $data=array(                   
                        'btnName'=>'Save'
                  );
            $this->form_validation->set_rules('reason_name', 'Reason name', 'xss_clean|trim|required|min_length[4]|max_length[100]|is_unique[tbl_contact_reasons.reason_name]');           
            
            $this->form_validation->set_message('is_unique', 'This entry is already exist. Please enter something else.');
            if ($this->form_validation->run() == FALSE)
            {    
				if($reason_id!='')
				{
					$tbl = 'tbl_contact_reasons';
					$where = array('reason_id'=>$reason_id);
			        $data['reason_info'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by='', $limi='', $offset='');  
					$data['action'] = "edit"; 
					$data['form_url1'] = ADMIN_FOLDER_NAME.'/reasons/add_new/'.$reason_id;
				}
				else
				{
					$data['action'] = 'add';    
					$data['form_url1'] = ADMIN_FOLDER_NAME.'/reasons/add_new/';        
				}
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/reason_add_view',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                if($reason_id=='')
				{
					$insertData=array(
                        'reason_name'     =>$this->input->post('reason_name'),                       
                        'reason_created_date'     =>_getDate(),
                        'reason_updated_date'          =>_getDate()
                       );
					$tableName = 'tbl_contact_reasons';              
               		$result = $this->mdgeneraldml->insert($tableName, $insertData);
               		$this->session->set_flashdata('success', 'Record has been successfully added.');
				}
				else
				{
					$tableName = 'tbl_contact_reasons';
					$updateData = array('reason_name'     =>$this->input->post('reason_name'),                       
                                       'reason_updated_date'          =>_getDate());
            		$where = array('reason_id' => $reason_id);
           		 	$result = $this->mdgeneraldml->update($where, $tableName, $updateData);
           			$this->session->set_flashdata('success', 'Record has been successfully updated.');
				}
               
               redirect(ADMIN_FOLDER_NAME.'/reasons');
            }
       
    }
	function delete($reason_id='')
	{
		$where = "reason_id = ".$reason_id;
		$tbl = 'tbl_contact_reasons';
       echo "DELETE FROM tbl_contact_reasons WHERE ".$where;
        $this->admin_model->sqlDelete("DELETE FROM tbl_contact_reasons WHERE ".$where);
		$this->session->set_flashdata('success', 'Record Deleted successfully.');
		redirect(ADMIN_FOLDER_NAME.'/reasons');
		
		
	}
    
   
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */