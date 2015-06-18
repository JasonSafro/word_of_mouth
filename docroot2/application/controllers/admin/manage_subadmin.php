<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Manage_subadmin extends CI_Controller {
  
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

    function index($sort_by='adm_id', $sort_type='DESC', $offset=0) 
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_subadmin/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('adm_status != ' => 'D','adm_usertype' =>'SA');
        $data = _getPagingVaiables('tbl_administrators', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);            
        $tbl = 'tbl_administrators';
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['sub_admin_List'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by, $limit, $offset);       
         
        //count total number of sub-admins
        $sql4="SELECT count(*) as total_sub_admin_count FROM tbl_administrators WHERE adm_status !='D' AND adm_usertype = 'SA'";
        $numTotalSubAdmins=$this->admin_model->sqlQuery($sql4);
        $data['total_sub_admin_count']=$numTotalSubAdmins[0]['total_sub_admin_count'];
        
        //$data['userList']=$this->admin_model->getUserList();
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/sub_admin_views/subadmin_view',$data);
        $this->load->view('admin/includes/footer');		
    }
    
    
    function add_new()
    {       $data=array(                   
                        'btnName'=>'Save'
                  );
    
            $this->form_validation->set_rules('adm_full_name', 'Full Name', 'xss_clean|trim|required');  
            $this->form_validation->set_rules('adm_username', 'Sub-Admin Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|is_unique[tbl_administrators.adm_username]');           
            $this->form_validation->set_rules('adm_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_administrators.adm_email]');
            $this->form_validation->set_rules('adm_password', 'Password', 'trim|min_length[6]|max_length[12]|alpha_numeric|required|matches[cadm_password]');
            $this->form_validation->set_rules('cadm_password', 'Confirm Password', 'trim|min_length[6]|max_length[12]|required|matches[adm_password]');
            $this->form_validation->set_rules('adm_contactno', 'Contact no', 'xss_clean|trim|is_numeric|required');
             $this->form_validation->set_message('is_unique', 'This entry is already exist. Please enter something else.');
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/sub_admin_views/subadmin_add_view',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {       
                $insertData=array(
                        'adm_full_name'         =>$this->input->post('adm_full_name'), 
                        'adm_username'     =>$this->input->post('adm_username'),                       
                        'adm_email'      =>$this->input->post('adm_email'),
                        'adm_password'      =>md5($this->input->post('adm_password')),
                        'adm_contactno'     =>$this->input->post('adm_contactno'),
                        'adm_created_date'     =>_getDateAndTime(),
                        'adm_updated_date'          =>_getDateAndTime(),
                        'adm_status'             =>"A"
                  );

               $tableName = 'tbl_administrators';              
               $result = $this->mdgeneraldml->insert($tableName, $insertData);
               $this->session->set_flashdata('success', 'Sub-Admin has been successfully added.');
               redirect(ADMIN_FOLDER_NAME.'/manage_subadmin');
            }
       
    }
    
    
    
    function edit($adm_id=NULL,$sort_by='adm_id', $sort_type='DESC', $offset=0)
    {
        if (($adm_id != NULL) && ($this->admin_model->isRecordExist('tbl_administrators', array('adm_id' => $adm_id)))) {
                        
            $tbl = 'tbl_administrators';
            $order_by = array('colname' => $sort_by, 'type' => $sort_type);
            $where=array('adm_id'=>$adm_id);
            $sub_adminInfo = $this->mdgeneraldml->select('*', $tbl, $where);
            $info=$sub_adminInfo[0];
            $data=array(
                        'adm_id'            =>$adm_id,
                        'adm_full_name' =>$info['adm_full_name'],
                        'adm_username'        => $info['adm_username'],
                        'adm_email'     =>$info['adm_email'],                       
                        'adm_password'      =>'',
                        'adm_contactno'       =>$info['adm_contactno'],
                        'action'=>'Edit',
                        'btnName'=>'Save'
                  );
            $this->form_validation->set_rules('adm_full_name', 'Full Name', 'xss_clean|trim|required');  
            $this->form_validation->set_rules('adm_username', 'Sub-Admin Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|callback_username_check[' . $adm_id . ']');          
            $this->form_validation->set_rules('adm_email', 'Email', 'xss_clean|trim|required|valid_email|callback_email_check[' . $adm_id . ']');
            $this->form_validation->set_rules('adm_password', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[12]|required');
            $this->form_validation->set_rules('adm_contactno', 'Contact no', 'xss_clean|trim|is_numeric|required');

            if ($this->form_validation->run() == FALSE)
            {
                $data['offset'] = $offset;
                $data['sort_by'] = $sort_by;
                $data['sort_type'] = $sort_type;
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/sub_admin_views/subadmin_edit_view',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                $updateData=array(
                        'adm_full_name' =>$this->input->post('adm_full_name'),
                        'adm_username'     =>$this->input->post('adm_username'),
                        'adm_email'     =>$this->input->post('adm_email'),                       
                        'adm_password'      =>($this->input->post('adm_password')!="" ? md5($this->input->post('adm_password')) : $info['adm_password']),
                        'adm_contactno'       =>$this->input->post('adm_contactno'),
                        'adm_updated_date'     =>_getDateAndTime()
                  );

               $tableName = 'tbl_administrators';
               $where = array('adm_id' => $adm_id);
               $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
               $this->session->set_flashdata('success', 'Sub_admin has been successfully updated.');
               redirect(ADMIN_FOLDER_NAME.'/manage_subadmin');
            }
            
        }
        else
        {
            $this->session->set_flashdata('error', '!! Sub-Admin not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin');
        }
        
    }
        public function username_check($str,$adm_id)
	{
                                $sql_q="SELECT adm_id, adm_username FROM tbl_administrators WHERE adm_username = '$str' AND adm_id != '$adm_id'";
                                $execute_q=$this->admin_model->sqlQuery($sql_q);
                                $record_count = count($execute_q);
                             //  echo $this->db->last_query();die;
                                if($record_count != 0)
		{
			$this->form_validation->set_message('username_check', 'This entry is already exist. Please enter something else.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
        
         public function email_check($str,$adm_id)
	{
                                $sql_q="SELECT adm_id, adm_email FROM tbl_administrators WHERE adm_email = '$str' AND adm_id != '$adm_id'";
                                $execute_q=$this->admin_model->sqlQuery($sql_q);
                                $record_count = count($execute_q);
                             //  echo $this->db->last_query();die;
                                if($record_count != 0)
		{
			$this->form_validation->set_message('email_check', 'This entry is already exist. Please enter something else.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
    
    function delete($adm_id=NULL, $sort_by='adm_id', $sort_type='DESC', $offset=0) 
    {
        if (($adm_id != NULL) && ($this->admin_model->isRecordExist('tbl_administrators', array('adm_id' => $adm_id)))) {
            $this->admin_model->sqlUpdate("Update tbl_administrators SET adm_status='D',adm_updated_date='"._getDateAndTime()."' WHERE adm_id=$adm_id");
            $this->session->set_flashdata('success', 'Sub-Admin has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! Sub-Admin not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin');
        }
    }
    
    function soft_delete_selected($sort_by='adm_id', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST['chkmsg']))
        {
            $adm_ids=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlUpdate("Update tbl_administrators SET adm_status='D',adm_updated_date='"._getDateAndTime()."' WHERE adm_id in($adm_ids)");
            $this->session->set_flashdata('success', 'Sub-Admin has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single sub-admin to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/manage_subadmin'); 
        }
    }
    
    function deleted_subadmins($sort_by='adm_id', $sort_type='DESC', $offset=0)
    {
         # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/manage_subadmin/deleted_subadmins/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('adm_status' => 'D');
        $data = _getPagingVaiables('tbl_administrators', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);            
        $tbl = 'tbl_administrators';
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['subadminList'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by, $limit, $offset);

        //$data['userList']=$this->admin_model->getUserList();
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/sub_admin_views/deleted_sub_admins_view',$data);
        $this->load->view('admin/includes/footer');
    }    
       
    function delete_from_system($adm_id)
    {
        if (($adm_id != NULL) && ($this->admin_model->isRecordExist('tbl_administrators', array('adm_id' => $adm_id)))) {
            //$this->admin_model->deleteUserFromAllTables($user_id);
            $this->admin_model->sqlDelete("DELETE FROM tbl_administrators WHERE adm_id=$adm_id");
            $this->session->set_flashdata('success', 'Sub-Admin has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/deleted_subadmins/');
        } else {
            $this->session->set_flashdata('error', '!! Sub-Admin not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/deleted_subadmins');
        }
    }
    
   function hard_delete_selected($sort_by='adm_id', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST['chkmsg']))
        {
            $adm_ids=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlDelete("DELETE FROM tbl_administrators WHERE adm_id in($adm_ids)");  
            $this->session->set_flashdata('success', 'Sub-Admin has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/deleted_subadmins/' . $sort_by . '/' . $sort_type . '/' . $offset);           
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single sub-admin to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/deleted_subadmins'); 
        }
    }
    
    function change_status($sort_by='adm_id', $sort_type='DESC', $offset=0, $adm_id=NULL, $status=NULL) 
    {
        if (($adm_id != NULL) && ($this->admin_model->isRecordExist('tbl_administrators', array('adm_id' => $adm_id)))) {
            $updateData = array(
                'adm_status' => $status,
                'adm_updated_date' => _getDateAndTime()
            );
            $tableName = 'tbl_administrators';
            $where = array('adm_id' => $adm_id);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Status has been successfully changed.');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }else {
            $this->session->set_flashdata('error', '!! Sub-Admin not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/manage_subadmin');
        }
    }	
    
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */