<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class User extends CI_Controller {
  
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

    function index($sort_by='user_id', $sort_type='DESC', $offset=0) 
    { 
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/user/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('user_acc_status != ' => 'D');
        $data = _getPagingVaiables('tbl_user', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);            
        $tbl = 'tbl_user';
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['userList'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by, $limit, $offset);       
         
        //count total number of users
        $sql4="SELECT count(*) as total_users_count FROM tbl_user WHERE user_acc_status !='D'";
        $numTotalUsers=$this->admin_model->sqlQuery($sql4);
        $data['total_users_count']=$numTotalUsers[0]['total_users_count'];
        
        //$data['userList']=$this->admin_model->getUserList();
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/user_view',$data);
        $this->load->view('admin/includes/footer');		
    }

    
 function view_details($user_id=NULL,$sort_by='user_id', $sort_type='DESC', $offset=0)
    {
        if($user_id!=NULL && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id))))
        {
            $data['user_view']= $this->mdgeneraldml->select("*","tbl_user",array("user_id"=>$user_id));           
            $data['user_id']=$user_id;
            $data['sort_by']=$sort_by;
            $data['sort_type']=$sort_type;
            $data['offset']=$offset;
            
            //echo '<pre>'; print_r($data); die;
            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_detail_vw',$data);
           $this->load->view('admin/includes/footer');
           
        }else{
             $this->session->set_flashdata('error', '!! Request not exist.!!');
             redirect(ADMIN_FOLDER_NAME.'/cashout/request_list');
        } 
    }
    
    
    function add_new()
    {       $data=array(                   
                        'btnName'=>'Save'
                  );
            $this->form_validation->set_rules('user_name', 'User name', 'xss_clean|trim|required|is_unique[tbl_user.user_name]');           
            $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
            $this->form_validation->set_rules('user_password', 'Password', 'trim|min_length[6]|max_length[30]||required|matches[cuser_password]');
            $this->form_validation->set_rules('cuser_password', 'Confirm Password', 'trim|min_length[6]|max_length[30]||required|matches[user_password]');
             $this->form_validation->set_message('is_unique', 'This entry is already exist. Please enter something else.');
            if ($this->form_validation->run() == FALSE)
            {                
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/user_add_vw',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                $insertData=array(
                        'user_name'     =>$this->input->post('user_name'),                       
                        'user_email'      =>$this->input->post('user_email'),
                        'user_password'      =>md5($this->input->post('user_password')),                                  
                        'user_registered_date'     =>_getDate(),
                        'user_update_date'          =>_getDate(),
                        'user_acc_status'             =>"A",
                         'act_link_click_status'=>0
                  );

               $tableName = 'tbl_user';              
               $result = $this->mdgeneraldml->insert($tableName, $insertData);
               $this->session->set_flashdata('success', 'User has been successfully added.');
               redirect(ADMIN_FOLDER_NAME.'/user');
            }
       
    }
    
    
    
    function edit($user_id=NULL,$sort_by='user_id', $sort_type='DESC', $offset=0)
    {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
                        
            $tbl = 'tbl_user';
            $order_by = array('colname' => $sort_by, 'type' => $sort_type);
            $where=array('user_id'=>$user_id);
            $userInfo = $this->mdgeneraldml->select('*', $tbl, $where);
            $info=$userInfo[0];
            $data=array(
                        'user_id'            =>$user_id,
                        'user_name'        => $info['user_name'],
                        'user_fname'     =>$info['user_fname'],
                        'user_lname'      =>$info['user_lname'],
                        'user_email'         =>$info['user_email'],
                        'user_password'      =>'',
                        'user_phone'       =>$info['user_phone'],                       
                        'user_city'          =>$info['user_city'],
                        'user_state'         =>$info['user_state'],
                        'user_country'    =>$info['user_country'],
                        'user_interest'       =>$info['user_interest'],
                        'user_newslet_sub'         =>$info['user_newslet_sub'],                
                        'action'=>'Edit',
                        'btnName'=>'Save'
                  );

            $this->form_validation->set_rules('user_name', 'User name', 'xss_clean|trim|required');
            $this->form_validation->set_rules('user_fname', 'Last name', 'xss_clean|trim');
            $this->form_validation->set_rules('user_lname', 'Last name', 'xss_clean|trim');
            $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required');
            $this->form_validation->set_rules('user_password', 'Password', 'trim|min_length[6]|max_length[30]||required');
            $this->form_validation->set_rules('user_phone', 'Phone no', 'xss_clean|trim|is_numeric');           
            $this->form_validation->set_rules('user_city', 'City', 'xss_clean|trim|max_lenght[30]');
            $this->form_validation->set_rules('user_state', 'State', 'xss_clean|trimd');         
            $this->form_validation->set_rules('user_country', 'Country', 'xss_clean|trim');

            if ($this->form_validation->run() == FALSE)
            {
                $data['offset'] = $offset;
                $data['sort_by'] = $sort_by;
                $data['sort_type'] = $sort_type;
                $this->load->view('admin/includes/header');	
                $this->load->view('admin/user_edit_vw',$data);
                $this->load->view('admin/includes/footer');
            }
            else
            {
                $updateData=array(
                        'user_name'     =>$this->input->post('user_name'),
                        'user_fname'     =>$this->input->post('user_fname'),
                        'user_lname'      =>$this->input->post('user_lname'),
                        'user_email'      =>$this->input->post('user_email'),
                        'user_password'      =>($this->input->post('user_password')!="" ? md5($this->input->post('user_password')) : $info['user_password']),
                        'user_phone'       =>$this->input->post('user_phone'),                     
                        'user_city'          =>$this->input->post('user_city'),
                        'user_state'         =>$this->input->post('user_state'),                       
                        'user_country'       =>$this->input->post('user_country'),                    
                        'user_update_date'     =>_getDateAndTime()
                  );

               $tableName = 'tbl_user';
               $where = array('user_id' => $user_id);
               $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
               $this->session->set_flashdata('success', 'User has been successfully updated.');
               redirect(ADMIN_FOLDER_NAME.'/user');
            }
        }
        else
        {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/user');
        }
    }
    
    
    
    function delete($user_id=NULL, $sort_by='user_id', $sort_type='DESC', $offset=0) 
    {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            $this->admin_model->sqlUpdate("Update tbl_user SET user_acc_status='D',user_update_date='"._getDateAndTime()."' WHERE user_id=$user_id");
            $this->session->set_flashdata('success', 'User has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/user/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/user');
        }
    }
    
    function soft_delete_selected($sort_by='user_id', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST['chkmsg']))
        {
            $user_ids=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlUpdate("Update tbl_user SET user_acc_status='D',user_update_date='"._getDateAndTime()."' WHERE user_id in($user_ids)");
            $this->session->set_flashdata('success', 'User has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME.'/user/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single user to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/user'); 
        }
    }
    
    function deleted_users($sort_by='user_id', $sort_type='DESC', $offset=0)
    {
         # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME.'/user/deleted_users/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('user_acc_status' => 'D');
        $data = _getPagingVaiables('tbl_user', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);            
        $tbl = 'tbl_user';
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['userList'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by, $limit, $offset);

        //$data['userList']=$this->admin_model->getUserList();
        $this->load->view('admin/includes/header');	
        $this->load->view('admin/deleted_users_view',$data);
        $this->load->view('admin/includes/footer');
    }    
       
    function delete_from_system($user_id)
    {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            //$this->admin_model->deleteUserFromAllTables($user_id);
            $this->admin_model->sqlDelete("DELETE FROM tbl_user WHERE user_id=$user_id");
            $this->session->set_flashdata('success', 'User has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME.'/user/deleted_users/');
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/user/deleted_users');
        }
    }
    
   function hard_delete_selected($sort_by='user_id', $sort_type='DESC', $offset=0)
    {
        if(!empty($_POST['chkmsg']))
        {
            $user_ids=implode(',',$_POST['chkmsg']);
            $this->admin_model->sqlDelete("DELETE FROM tbl_user WHERE user_id in($user_ids)");  
            $this->session->set_flashdata('success', 'User has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME.'/user/deleted_users/' . $sort_by . '/' . $sort_type . '/' . $offset);           
        }
        else
        {
           $this->session->set_flashdata('error', 'Select atleast single user to delete the record.');
           redirect(ADMIN_FOLDER_NAME.'/user/deleted_users'); 
        }
    }
    
    function change_status($sort_by='user_id', $sort_type='DESC', $offset=0, $user_id=NULL, $status=NULL) 
    {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            $updateData = array(
                'user_acc_status' => $status,
                'user_update_date' => _getDateAndTime()
            );
            $tableName = 'tbl_user';
            $where = array('user_id' => $user_id);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Status has been successfully changed.');
            redirect(ADMIN_FOLDER_NAME.'/user/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        }else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME.'/user');
        }
    }	
    
    
    function getEmailList()
    {
        $csv_output = '';
        $csv_output .= "\n";
                
        $sql="SELECT userEmail FROM tbl_users where userStatus !='Deleted' ORDER BY userEmail ASC";
        $result=$this->admin_model->sqlQuery($sql);
        $csv_output = "Emails\r\n";
        foreach ($result as $key => $val) {
            $csv_output .= $val['userEmail'] . "\r\n";
        }

        $file = 'email_list';
        $filename = $file . "_" . date("d-m-Y_H-i", time());

        header("Content-type: application/vnd.ms-excel");
        header("Content-disposition: csv" . date("Y-m-d") . ".csv");
        header("Content-disposition: filename=" . $filename . ".csv");

        print $csv_output;
        exit;
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */