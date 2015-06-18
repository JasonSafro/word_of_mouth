<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateAdmin();
        //$this->load->model('db_transact_model');
        $this->load->model('admin_model');
        $this->load->model('mdgeneraldml');
        $this->load->library('form_validation');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    function index($sort_by='user_id', $sort_type='DESC', $offset=0) {
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME . '/user/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('user_acc_status != ' => 'D');
        $data = _getPagingVaiables('tbl_user', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);
        $tbl = 'tbl_user';
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['userList'] = $this->mdgeneraldml->select('*', $tbl, $where, $order_by, $limit, $offset);

        //count total number of users
        $sql4 = "SELECT count(*) as total_users_count FROM tbl_user WHERE user_acc_status !='D'";
        $numTotalUsers = $this->admin_model->sqlQuery($sql4);
        $data['total_users_count'] = $numTotalUsers[0]['total_users_count'];

        //$data['userList']=$this->admin_model->getUserList();
        $this->load->view('admin/includes/header');
        $this->load->view('admin/user_view', $data);
        $this->load->view('admin/includes/footer');
    }

    public function plan_details() {
        //Get subscription plans
        $tbl_subscription_plans = 'tbl_subscription_plans';
        $data['plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_plans);

        $data['basic_plan_name'] = $data['plan_details'][0]['subs_plan_name'];
        $data['prem_plan_name'] = $data['plan_details'][1]['subs_plan_name'];

        //Get sub-subscription plans
        $tbl_subscription_sub_plans = 'tbl_subscription_sub_plans';
        $data['sub_plan_details'] = $this->mdgeneraldml->select('*', $tbl_subscription_sub_plans);
        //basic Annually 
        $data['basic_plan_annual_name'] = $data['sub_plan_details'][0]['subs_sub_plan_name'];
        $data['basic_plan_annual_price'] = $data['sub_plan_details'][0]['subs_sub_plan_price'];
        //basic Monthly
        $data['basic_plan_monthly_name'] = $data['sub_plan_details'][1]['subs_sub_plan_name'];
        $data['basic_plan_monthly_price'] = $data['sub_plan_details'][1]['subs_sub_plan_price'];
        //premium Annually                                
        $data['prem_plan_annual_name'] = $data['sub_plan_details'][2]['subs_sub_plan_name'];
        $data['prem_plan_annual_price'] = $data['sub_plan_details'][2]['subs_sub_plan_price'];
        //premium Monthly
        $data['prem_plan_monthly_name'] = $data['sub_plan_details'][3]['subs_sub_plan_name'];
        $data['prem_plan_monthly_price'] = $data['sub_plan_details'][3]['subs_sub_plan_price'];

        return $data;
    }

    function view_details($user_id=NULL, $sort_by='user_id', $sort_type='DESC', $offset=0) {
        if ($user_id != NULL && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            $data = $this->plan_details();

            $data['user_view'] = $this->mdgeneraldml->select("*", "tbl_user", array("user_id" => $user_id));
            $data['user_id'] = $user_id;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $data['offset'] = $offset;

            //Get User State
            $where_state_id = array('state_id' => $data['user_view'][0]['user_state']);
            $get_state = $this->mdgeneraldml->select('state_name', 'tbl_state', $where_state_id);
            if (count($get_state) > 0)
                $data['state'] = $get_state[0]['state_name'];
            else
                $data['state'] = '';



            //Get User Country
            $where_country_code = array('country_code' => $data['user_view'][0]['user_country']);
            $get_country = $this->mdgeneraldml->select('country_name', 'tbl_country', $where_country_code);

            if (count($get_country) > 0)
                $data['user_country'] = $get_country[0]['country_name'];
            else
                $data['user_country'] = '';


            //Get user Business Details
            $tbl1 = 'tbl_business_info';
            $where = array("user_id" => $user_id);
            $busiInfo = $this->mdgeneraldml->select('*', $tbl1, $where);
            if (count($busiInfo) > 0) {
                $data['businfo'] = $this->mdgeneraldml->select('*', $tbl1, $where);
                // print_r($data['businfo']); die;
            }

            //echo '<pre>'; print_r($data); die;
            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_detail_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {
            $this->session->set_flashdata('error', '!! Request not exist.!!');
            redirect(ADMIN_FOLDER_NAME . '/cashout/request_list');
        }
    }

    function add_new() {
        $data = array(
            'btnName' => 'Save'
        );
        $this->form_validation->set_rules('user_name', 'User name', 'xss_clean|trim|required|min_length[4]|max_length[32]|callback_user_name_check|is_unique[tbl_user.user_name]');
        $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email|is_unique[tbl_user.user_email]');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|min_length[6]|max_length[12]|alpha_numeric|required|matches[cuser_password]');
        $this->form_validation->set_rules('cuser_password', 'Confirm Password', 'trim|min_length[6]|max_length[12]|alpha_numeric|required|matches[user_password]');
        $this->form_validation->set_message('is_unique', 'This entry is already exist. Please enter something else.');
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_add_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {
            $insertData = array(
                'user_name' => $this->input->post('user_name'),
                'user_email' => $this->input->post('user_email'),
                'user_password' => md5($this->input->post('user_password')),
                'user_registered_date' => _getDate(),
                'user_update_date' => _getDate(),
                'user_acc_status' => "A",
                'act_link_click_status' => 0,
                'user_plan' => '',
                'user_type' => "site_user"
            );

            $tableName = 'tbl_user';
            $result = $this->mdgeneraldml->insert($tableName, $insertData);
            $this->session->set_flashdata('success', 'User has been successfully added.');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    function edit($user_id=NULL, $sort_by='user_id', $sort_type='DESC', $offset=0, $submitedForm='N') {
        // echo $submitedForm; die;
        if ($submitedForm != 'N' && $submitedForm != 'B') {//N=Normal User B=Business User
            $this->session->set_flashdata('error', 'Direct access not allowed.');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }

        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {

            //Get Plan Details
            $plan_details = $this->plan_details();

            //Get User Details
            $tbl = 'tbl_user';
            $order_by = array('colname' => $sort_by, 'type' => $sort_type);
            $where = array('user_id' => $user_id);
            $userInfo = $this->mdgeneraldml->select('*', $tbl, $where);
            $info = $userInfo[0];

            $data = array(
                'user_id' => $user_id,
                'user_name' => $info['user_name'],
                'user_fname' => $info['user_fname'],
                'user_lname' => $info['user_lname'],
                'user_email' => $info['user_email'],
                'user_password' => $info['user_password'],
                'user_phone' => $info['user_phone'],
                'user_city' => $info['user_city'],
                'user_country' => $info['user_country'],
                'user_interest' => $info['user_interest'],
                'user_newslet_sub' => $info['user_newslet_sub'],
                'user_plan' => $info['user_plan'],
                'user_type' => $info['user_type'],
                'action' => 'Edit',
                'btnName' => 'Save'
            );


            //Get User State
            $where_state_id = array('state_id' => $info['user_state']);
            $get_state = $this->mdgeneraldml->select('state_name', 'tbl_state', $where_state_id);
            if (count($get_state) > 0)
                $data['user_state'] = $get_state[0]['state_name'];
            else
                $data['user_state'] = '';


            //Get user Business Details
            $tbl1 = 'tbl_business_info';
            $busiInfo = $this->mdgeneraldml->select('*', $tbl1, $where);
            if (count($busiInfo) > 0) {
                $bu_info = $busiInfo[0];
                if ($bu_info['buss_addr_addon'] == '--') {
                    $addr_addon = '';
                } else {
                    $addr_addon = $bu_info['buss_addr_addon'];
                }

                $buss_data = array(
                    'buss_id' => $bu_info['buss_id'],
                    'buss_name' => $bu_info['buss_name'],
                    'buss_cont_name' => $bu_info['buss_cont_name'],
                    'buss_address' => $bu_info['buss_address'],
                    'buss_addr_addon' => $addr_addon,
                    'buss_city' => $bu_info['buss_city'],
                    'buss_zip_code' => $bu_info['buss_zip_code'],
                    'buss_phone' => $bu_info['buss_phone'],
                    'buss_fax' => $bu_info['buss_fax'],
                    'buss_web_address' => $bu_info['buss_web_address'],
                    'buss_email' => $bu_info['buss_email'],
                    'buss_category' => $bu_info['buss_category'],
                    'buss_license_num' => $bu_info['buss_license_num'],
                    'buss_sco_one' => $bu_info['buss_social_media_channel_1'],
                    'buss_sco_two' => $bu_info['buss_social_media_channel_2'],
                    'buss_sco_three' => $bu_info['buss_social_media_channel_3'],
                    'buss_sco_four' => $bu_info['buss_social_media_channel_4']
                );
            } else {
                $buss_data = array(
                    'buss_id' => '',
                    'buss_name' => '',
                    'buss_cont_name' => '',
                    'buss_address' => '',
                    'buss_addr_addon' => '',
                    'buss_city' => '',
                    'buss_zip_code' => '',
                    'buss_phone' => '',
                    'buss_fax' => '',
                    'buss_web_address' => '',
                    'buss_email' => '',
                    'buss_category' => '',
                    'buss_license_num' => '',
                    'buss_sco_one' => '',
                    'buss_sco_two' => '',
                    'buss_sco_three' => '',
                    'buss_sco_four' => ''
                );
            }

            $data['offset'] = $offset;
            $data['sort_by'] = $sort_by;
            $data['sort_type'] = $sort_type;
            $data = array_merge($data, $plan_details, $buss_data);


            if ($submitedForm == 'N')
                $this->__editNormalUser($data);
            else
                $this->__editBusinessUser($data);
        }
        else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    function __editNormalUser($data) {
        $this->form_validation->set_rules('user_name', 'User name', 'xss_clean|trim|required|min_length[4]|max_length[32]|callback_user_name_check|callback_username_check[' . $data['user_id'] . ']');
        $this->form_validation->set_rules('user_fname', 'Last name', 'xss_clean|trim');
        $this->form_validation->set_rules('user_lname', 'Last name', 'xss_clean|trim');
        $this->form_validation->set_rules('user_email', 'Email', 'xss_clean|trim|required|valid_email|callback_email_check[' . $data['user_id'] . ']');
        $this->form_validation->set_rules('user_password', 'Password', 'trim|min_length[6]|max_length[12]|alpha_numeric');
        $this->form_validation->set_rules('user_phone', 'Phone no', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('user_city', 'City', 'xss_clean|trim|max_lenght[30]');
        $this->form_validation->set_rules('userState', 'State', 'xss_clean|trimd|required');
        $this->form_validation->set_rules('Items', 'Country', 'xss_clean|trim|required');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_edit_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {   //print_r($_POST);die;
            $updateData = array(
                'user_name' => $this->input->post('user_name'),
                'user_fname' => $this->input->post('user_fname'),
                'user_lname' => $this->input->post('user_lname'),
                'user_email' => $this->input->post('user_email'),
                'user_password' => ($this->input->post('user_password') != "" ? md5($this->input->post('user_password')) : $data['user_password']),
                'user_phone' => $this->input->post('user_phone'),
                'user_city' => $this->input->post('user_city'),
                'user_state' => $this->input->post('userState'),
                'user_country' => $this->input->post('Items'),
                'user_update_date' => _getDateAndTime()
            );

            $tableName = 'tbl_user';
            $where = array('user_id' => $data['user_id']);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'User has been successfully updated.');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    function __editBusinessUser($data) {
        $this->form_validation->set_rules('buss_name', 'Business Name', 'xss_clean|trim|required|max_length[32]|alpha_numeric');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim|required|alpha_numeric');
        $this->form_validation->set_rules('buss_address', 'Address', 'xss_clean|trim|required|alpha_numeric');
        $this->form_validation->set_rules('buss_addr_addon', 'Address add on', 'xss_clean|trim|alpha_numeric');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_zip_code', 'Zip code', 'xss_clean|trim|required|numeric');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required|numeric');
        $this->form_validation->set_rules('buss_fax', 'Fax', 'xss_clean|trim|required|numeric');
        $this->form_validation->set_rules('buss_web_address', 'Web Address', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_email', 'Email', 'xss_clean|trim|required|valid_email');
        $this->form_validation->set_rules('buss_license_num', 'Business License Number', 'xss_clean|trim|numeric');



        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_edit_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {
            $updateData = array(
                'buss_name' => $this->input->post('buss_name'),
                'buss_cont_name' => $this->input->post('buss_cont_name'),
                'buss_address' => $this->input->post('buss_address'),
                'buss_addr_addon' => $this->input->post('buss_addr_addon'),
                'buss_city' => $this->input->post('buss_city'),
                'buss_zip_code' => $this->input->post('buss_zip_code'),
                'buss_phone' => $this->input->post('buss_phone'),
                'buss_fax' => $this->input->post('buss_fax'),
                'buss_web_address' => $this->input->post('buss_web_address'),
                'buss_email' => $this->input->post('buss_email'),
                'buss_license_num' => $this->input->post('buss_license_num'),
                'buss_social_media_channel_1' => $this->input->post('buss_social_media_channel_1'),
                'buss_social_media_channel_2' => $this->input->post('buss_social_media_channel_2'),
                'buss_social_media_channel_3' => $this->input->post('buss_social_media_channel_3'),
                'buss_social_media_channel_4' => $this->input->post('buss_social_media_channel_4')
            );
            //'buss_category' =>  $this->input->post('buss_name'),
            $tableName = 'tbl_business_info';
            $where = array('buss_id' => $data['buss_id']);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Business has been successfully updated.');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    public function username_check($str, $user_id) {
        $sql_q = "SELECT user_id, user_name FROM tbl_user WHERE user_name = '$str' AND user_id != '$user_id'";
        $execute_q = $this->admin_model->sqlQuery($sql_q);
        $record_count = count($execute_q);
        //  echo $this->db->last_query();die;
        if ($record_count != 0) {
            $this->form_validation->set_message('username_check', 'This entry is already exist. Please enter something else.');
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function email_check($str, $user_id) {
        $sql_q = "SELECT user_id, user_email FROM tbl_user WHERE user_email = '$str' AND user_id != '$user_id'";
        $execute_q = $this->admin_model->sqlQuery($sql_q);
        $record_count = count($execute_q);
        //  echo $this->db->last_query();die;
        if ($record_count != 0) {
            $this->form_validation->set_message('email_check', 'This entry is already exist. Please enter something else.');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function user_name_check($string){
       
       //$rex = '/^[A-Za-z][A-Za-z0-9]*(?:_[A-Za-z0-9]+)*$/'; //start with characters only       
       $rex = '/^[A-Za-z0-9_.]+$/';
       if (preg_match($rex, $string)){
           return TRUE;
        }
        else
        {
            $this->form_validation->set_message('user_name_check', 'Space and special characters are not allowed.');
            return FALSE;
        }
    }

    function delete($user_id=NULL, $sort_by='user_id', $sort_type='DESC', $offset=0) {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            $this->admin_model->sqlUpdate("Update tbl_user SET user_acc_status='D',user_update_date='" . _getDateAndTime() . "' WHERE user_id=$user_id");
            $this->session->set_flashdata('success', 'User has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME . '/user/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    function soft_delete_selected($sort_by='user_id', $sort_type='DESC', $offset=0) {
        if (!empty($_POST['chkmsg'])) {
            $user_ids = implode(',', $_POST['chkmsg']);
            $this->admin_model->sqlUpdate("Update tbl_user SET user_acc_status='D',user_update_date='" . _getDateAndTime() . "' WHERE user_id in($user_ids)");
            $this->session->set_flashdata('success', 'User has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME . '/user/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', 'Select atleast single user to delete the record.');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    function deleted_users($sort_by='user_id', $sort_type='DESC', $offset=0) {
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME . '/user/deleted_users/';

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
        $this->load->view('admin/deleted_users_view', $data);
        $this->load->view('admin/includes/footer');
    }

    function delete_from_system($user_id) {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            //$this->admin_model->deleteUserFromAllTables($user_id);
            $this->admin_model->sqlDelete("DELETE FROM tbl_user WHERE user_id=$user_id");
            $this->session->set_flashdata('success', 'User has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME . '/user/deleted_users/');
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME . '/user/deleted_users');
        }
    }

    function hard_delete_selected($sort_by='user_id', $sort_type='DESC', $offset=0) {
        if (!empty($_POST['chkmsg'])) {
            $user_ids = implode(',', $_POST['chkmsg']);
            $this->admin_model->sqlDelete("DELETE FROM tbl_user WHERE user_id in($user_ids)");
            $this->session->set_flashdata('success', 'User has been Deleted successfully from the system.');
            redirect(ADMIN_FOLDER_NAME . '/user/deleted_users/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', 'Select atleast single user to delete the record.');
            redirect(ADMIN_FOLDER_NAME . '/user/deleted_users');
        }
    }

    function change_status($sort_by='user_id', $sort_type='DESC', $offset=0, $user_id=NULL, $status=NULL) {
        if (($user_id != NULL) && ($this->admin_model->isRecordExist('tbl_user', array('user_id' => $user_id)))) {
            $updateData = array(
                'user_acc_status' => $status,
                'user_update_date' => _getDateAndTime()
            );
            $tableName = 'tbl_user';
            $where = array('user_id' => $user_id);
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Status has been successfully changed.');
            redirect(ADMIN_FOLDER_NAME . '/user/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! User not exist.!!');
            redirect(ADMIN_FOLDER_NAME . '/user');
        }
    }

    function getEmailList() {
        $csv_output = '';
        $csv_output .= "\n";

        $sql = "SELECT userEmail FROM tbl_users where userStatus !='Deleted' ORDER BY userEmail ASC";
        $result = $this->admin_model->sqlQuery($sql);
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

    function getCountrys() {
        $countryList = _getCountryList();
        $responseArray = array();

        foreach ($countryList as $key => $val) {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }

    function getStateList($countryCode) {
        //$st='id="userState" class="items"';//stateHolder
        // echo form_dropdown('userState', _getStateList($countryCode),set_value('userState'),'id="userState" class="items"'); 
        $stateList = _getStateList($countryCode);
        foreach ($stateList as $key => $val) {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }

    function getState($countryCode, $user_id) {
        $get_user_state = "SELECT user_state FROM tbl_user WHERE tbl_user.user_id='" . $user_id . "'";
        $result_user_state = $this->db->query($get_user_state)->result_array();


        $get_state = "SELECT state_id,state_name FROM tbl_state WHERE state_id='" . $result_user_state[0]['user_state'] . "'";
        $result_state = $this->db->query($get_state)->result_array();

        foreach ($result_state as $key => $val) {
            $list[$val['state_id']] = $val['state_name'];
        }


        foreach ($list as $key => $val) {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }

    function listing($user_id, $sort_by='user_id', $sort_type='DESC', $offset=0) {
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME . '/user/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('user_id' => $user_id);
        $data = _getPagingVaiables('tbl_business_info', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);
        $where = "where u.user_id=$user_id";
        $data['business_info'] = $this->admin_model->get_user_business_list($sort_by, $sort_type, $limit, $offset, $where);
        $data['user_id'] = $user_id;
        $this->load->view('admin/includes/header');
        $this->load->view('admin/user_listing_vw', $data);
        $this->load->view('admin/includes/footer');
    }

    function add_listing($user_id, $sort_by='user_id', $sort_type='DESC', $offset=0) {
        $userId = $user_id;
        $tbl_user = 'tbl_user';
        $where_user = array('user_id' => $userId);
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_user, $where_user);
        $info = $bus_Info[0];
        $myUserType = $info['user_type'];
        if ($myUserType == 'buss_user') {
            $canIAddNewBusiness = true;
            $numOfBusinessAdded = __numOfUserBusiness($userId);
            $mySubscriptionPlan = __mySubscriptionPlan($userId);
            if (($mySubscriptionPlan == 'bm' || $mySubscriptionPlan == 'ba') && $numOfBusinessAdded == 2)//this means user have basic plan and have reached the creating business limit
                $canIAddNewBusiness = false;

            if ($canIAddNewBusiness == false) {
                $this->session->set_flashdata('error', 'You have reached to the limit of listing, you subscription has limit of 2 listings. You can upgrade your account by clicking here.');
                redirect('admin/user');
            }
        } else {
            $this->session->set_flashdata('error', 'You can not create business listing.');
            redirect('admin/user');
        }
        $data = array(
            'buss_category' => '',
            'buss_id' => '',
            'buss_name' => '',
            'buss_cont_name' => '',
            'buss_address' => '',
            'buss_addr_addon' => '',
            'buss_city' => '',
            'buss_zip_code' => '',
            'buss_phone' => '',
            'buss_fax' => '',
            'buss_web_address' => '',
            'buss_email' => '',
            'buss_license_num' => '',
            'buss_social_media_channel_1' => '',
            'buss_social_media_channel_2' => '',
            'buss_social_media_channel_3' => '',
            'buss_social_media_channel_4' => '',
            'buss_tag_line' => '',
            'buss_description' => '',
            'buss_media_copy' => '',
        );
        $data['action'] = 'new';
        $data['user_id'] = $user_id;
        $data['error'] = '';
        $data['error1'] = '';

        $this->form_validation->set_rules('buss_category', 'Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_name', 'Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_addr_addon', 'Address Add On', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required|max_lenght[30]');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required|is_numeric');
        $this->form_validation->set_rules('buss_fax', 'FAX', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('buss_web_address', 'Web Address', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_email', 'Email', 'xss_clean|trim|valid_email');
        $this->form_validation->set_rules('buss_license_num', 'License Number', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('buss_social_media_channel_1', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_2', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_3', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_4', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_tag_line', 'Business Tag Line', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_description', 'Business Description', 'xss_clean|trim|required|max_length[255]');


        if (!empty($_FILES['image_media'])) {
            $this->form_validation->set_rules('image_media[]', 'Media Copy', 'callback_checkForMediaCopy');
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_listing_add_edit_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {  //print_r($_POST);DIE;
            $updateData = array(
                'buss_category' => $this->input->post('buss_category'),
                'buss_name' => $this->input->post('buss_name'),
                'user_id' => $user_id,
                'buss_cont_name' => $this->input->post('buss_cont_name'),
                'buss_address' => $this->input->post('buss_address'),
                'buss_addr_addon' => $this->input->post('buss_addr_addon'),
                'buss_city' => $this->input->post('buss_city'),
                'buss_phone' => $this->input->post('buss_phone'),
                'buss_zip_code' => $this->input->post('buss_zip_code'),
                'buss_fax' => $this->input->post('buss_fax'),
                'buss_web_address' => $this->input->post('buss_web_address'),
                'buss_email' => $this->input->post('buss_email'),
                'buss_license_num' => $this->input->post('buss_license_num'),
                'buss_social_media_channel_1' => $this->input->post('buss_social_media_channel_1'),
                'buss_social_media_channel_2' => $this->input->post('buss_social_media_channel_2'),
                'buss_social_media_channel_3' => $this->input->post('buss_social_media_channel_3'),
                'buss_social_media_channel_4' => $this->input->post('buss_social_media_channel_4'),
                'buss_tag_line' => $this->input->post('buss_tag_line'),
                'buss_description' => $this->input->post('buss_description'),
                'isThisBusinessAddedByAdmin' => 'Yes',
                'bussCreatedOn' => _getDateAndTime(),
                'bussUpdatedOn' => _getDateAndTime()
            );

            $flag = true;


            //upload file
            if (isset($_FILES['image_logo']['name']) && !empty($_FILES['image_logo']['name'])) {
                if ($_FILES['image_logo'] != "") {
                    $config['upload_path'] = './LOGO';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                    $config['max_size'] = '1000';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';
                    $config['file_name'] = $this->input->post('image_logo');
                    $config['overwrite'] = TRUE;
                    $config['quality'] = 100;
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    $data1 = array();
                    if (!$this->upload->do_upload('image_logo')) {
                        $flag = false;
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('admin/includes/header');
                        $this->load->view('admin/user_listing_add_edit_vw', $data);
                        $this->load->view('admin/includes/footer');
                    } else {
                        $data1 = array('upload_data' => $this->upload->data());
                        $updateData['buss_logo'] = $data1['upload_data']['file_name'];
                    }
                }//end of $_FILE
            }// end of isset
            //upload file
            if (!empty($_FILES['image_media'])) {
                $imageNames = $this->do_MultipleUpload('image_media');
                if ($imageNames != "") {
                    $updateData['buss_media_copy'] = $imageNames;
                }
            }


            if ($flag == true) {
                $tableName = 'tbl_business_info';
                $result = $this->mdgeneraldml->insert($tableName, $updateData);
                print_r($result);

                //$this->session->set_flashdata('success','New listing has been created successfully.');
                //redirect('dashboard/business_listing');
                $this->session->set_flashdata('success', 'bussiness listing has been added successfully');
                redirect(ADMIN_FOLDER_NAME . '/user/listing/' . $user_id . '/' . $sort_by . '/' . $sort_type . '/' . $offset);
            }
        }
    }

    function do_MultipleUpload($inputFileName="") {
        $this->load->library('upload'); // Load Library

        $this->upload->initialize(array(// takes an array of initialization options
            "upload_path" => "./Media_Copy/",
            "overwrite" => FALSE,
            "encrypt_name" => TRUE,
            "remove_spaces" => TRUE,
            "allowed_types" => "*",
            "max_size" => 300,
            "xss_clean" => FALSE
        )); // These are just my options. Also keep in mind with PDF's YOU MUST TURN OFF xss_clean

        if ($this->upload->do_multi_upload($inputFileName)) { // use same as you did in the input field
            $result = $this->upload->get_multi_upload_data();

            $fileNames = "";
            $fileNameArray = array();
            foreach ($result as $key => $val)
                $fileNameArray[] = $val['file_name'];

            $fileNames = implode(',', $fileNameArray);
            return $fileNames;
        }
    }

    function edit_listing($buss_id, $sort_by='user_id', $sort_type='DESC', $offset=0) {
        $tbl_user = 'tbl_business_info';
        $where = array('buss_id' => $buss_id);
        $bus_Info = $this->mdgeneraldml->select('*', $tbl_user, $where);
        $info = $bus_Info[0];
        $uid = $info['user_id'];
        $data = array(
            'buss_category' => $info['buss_category'],
            'buss_id' => $info['buss_id'],
            'buss_name' => $info['buss_name'],
            'user_id' => $info['user_id'],
            'buss_cont_name' => $info['buss_cont_name'],
            'buss_address' => $info['buss_address'],
            'buss_addr_addon' => $info['buss_addr_addon'],
            'buss_city' => $info['buss_city'],
            'buss_zip_code' => $info['buss_zip_code'],
            'buss_phone' => $info['buss_phone'],
            'buss_fax' => $info['buss_fax'],
            'buss_web_address' => $info['buss_web_address'],
            'buss_email' => $info['buss_email'],
            'buss_license_num' => $info['buss_license_num'],
            'buss_social_media_channel_1' => $info['buss_social_media_channel_1'],
            'buss_social_media_channel_2' => $info['buss_social_media_channel_2'],
            'buss_social_media_channel_3' => $info['buss_social_media_channel_3'],
            'buss_social_media_channel_4' => $info['buss_social_media_channel_4'],
            'buss_tag_line' => $info['buss_tag_line'],
            'buss_description' => $info['buss_description'],
            'buss_media_copy' => $info['buss_media_copy']
        );
        $data['action'] = 'edit';
        $data['error'] = '';
        $data['error1'] = '';

        $this->form_validation->set_rules('buss_category', 'Category', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_name', 'Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_cont_name', 'Contact Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_addr_addon', 'Address Add On', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_city', 'City', 'xss_clean|trim|required|max_lenght[30]');
        $this->form_validation->set_rules('buss_phone', 'Phone', 'xss_clean|trim|required|is_numeric');
        $this->form_validation->set_rules('buss_fax', 'FAX', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('buss_web_address', 'Web Address', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_email', 'Email', 'xss_clean|trim|valid_email');
        $this->form_validation->set_rules('buss_license_num', 'License Number', 'xss_clean|trim|is_numeric');
        $this->form_validation->set_rules('buss_social_media_channel_1', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_2', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_3', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_social_media_channel_4', 'Phone no', 'xss_clean|trim');
        $this->form_validation->set_rules('buss_tag_line', 'Business Tag Line', 'xss_clean|trim|required');
        $this->form_validation->set_rules('buss_description', 'Business Description', 'xss_clean|trim|required|max_length[255]');

        //echo '<pre>'; print_r($_FILES['image_media']);
        if (!empty($_FILES['image_media'])) {
            if (!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0] != "") {
                $this->form_validation->set_rules('image_media[]', 'Media Copy', 'callback_checkForMediaCopy');
            }
        }

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header');
            $this->load->view('admin/user_listing_add_edit_vw', $data);
            $this->load->view('admin/includes/footer');
        } else {  //print_r($_POST);DIE;
            $updateData = array(
                'buss_category' => $this->input->post('buss_category'),
                'buss_name' => $this->input->post('buss_name'),
                'buss_cont_name' => $this->input->post('buss_cont_name'),
                'buss_address' => $this->input->post('buss_address'),
                'buss_addr_addon' => $this->input->post('buss_addr_addon'),
                'buss_city' => $this->input->post('buss_city'),
                'buss_phone' => $this->input->post('buss_phone'),
                'buss_zip_code' => $this->input->post('buss_zip_code'),
                'buss_fax' => $this->input->post('buss_fax'),
                'buss_web_address' => $this->input->post('buss_web_address'),
                'buss_email' => $this->input->post('buss_email'),
                'buss_license_num' => $this->input->post('buss_license_num'),
                'buss_social_media_channel_1' => $this->input->post('buss_social_media_channel_1'),
                'buss_social_media_channel_2' => $this->input->post('buss_social_media_channel_2'),
                'buss_social_media_channel_3' => $this->input->post('buss_social_media_channel_3'),
                'buss_social_media_channel_4' => $this->input->post('buss_social_media_channel_4'),
                'buss_tag_line' => $this->input->post('buss_tag_line'),
                'bussUpdatedOn' => _getDateAndTime(),
                'buss_description' => $this->input->post('buss_description')
            );

            $flag = true;
            //upload file
            if (isset($_FILES['image_logo']['name']) && !empty($_FILES['image_logo']['name'])) {
                if ($_FILES['image_logo'] != "") {
                    $config['upload_path'] = './LOGO';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                    $config['max_size'] = '1000';
                    $config['max_width'] = '1024';
                    $config['max_height'] = '768';
                    $config['file_name'] = $this->input->post('image_logo');
                    $config['overwrite'] = TRUE;
                    $config['quality'] = 100;
                    $this->load->library('upload');
                    $this->upload->initialize($config);

                    $data1 = array();
                    if (!$this->upload->do_upload('image_logo')) {
                        $flag = false;
                        $data['error'] = $this->upload->display_errors();
                        $this->load->view('admin/includes/header');
                        $this->load->view('admin/user_listing_add_edit_vw', $data);
                        $this->load->view('admin/includes/footer');
                    } else {
                        $data1 = array('upload_data' => $this->upload->data());
                        $updateData['buss_logo'] = $data1['upload_data']['file_name'];
                    }
                }//end of $_FILE
            }// end of isset
            //upload file
            $oldImages = $data['buss_media_copy'];

            if (!empty($_FILES['image_media'])) {
                if (!empty($_FILES['image_media']['name']) && $_FILES['image_media']['name'][0] != "") {
                    $imageNames = $this->do_MultipleUpload('image_media');
                    if ($imageNames != "") {
                        $updateData['buss_media_copy'] = $imageNames . ',' . $oldImages;
                    }
                }
            }


            if ($flag == true) {
                $tableName = 'tbl_business_info';
                $where = array('buss_id' => $buss_id);
                $result = $this->mdgeneraldml->update($where, $tableName, $updateData);

                $this->session->set_flashdata('success', 'bussiness listing has been updated successfully');
                redirect(ADMIN_FOLDER_NAME . '/user/listing/' . $uid . '/' . $sort_by . '/' . $sort_type . '/' . $offset);
            }
        }
    }

    function removeMediaImage() {
        if (!empty($_POST)) {
            $businessId = $_POST['businessId'];
            $imageName = $_POST['imageName'];

            $where = array('buss_id' => $businessId);
            $bus_Info = $this->mdgeneraldml->select('buss_media_copy', 'tbl_business_info', $where);
            $dbImageName = $bus_Info[0]['buss_media_copy'];
            if ($dbImageName != "") {
                $imageArray = explode(',', $dbImageName);
                $newImageArray = array();
                foreach ($imageArray as $key => $val) {
                    if ($val != $imageName) {
                        $newImageArray[] = $val;
                    }
                }

                $newImage = implode(',', $newImageArray);
                $updateData = array('buss_media_copy' => $newImage);
                //echo $newImage;
                $this->mdgeneraldml->update($where, 'tbl_business_info', $updateData);
                unlink('./Media_Copy/' . $imageName);
                echo 'success';
            } else {
                echo 'fail';
            }
        } else {
            echo 'fail';
        }
    }

    function checkForMediaCopy() {
        $userId = $this->input->post('user_id');
        $where = array('user_id' => $userId);
        $userInfo = $this->mdgeneraldml->select('user_plan,user_type', 'tbl_user', $where);
        $numFilesUlpoad = 0;
        if ($userInfo[0]['user_type'] == 'buss_user') {
            if ($userInfo[0]['user_plan'] == 'pm' || $userInfo[0]['user_plan'] == 'pa')//pm==premium monthly pa=oremium anual
                $numFilesUlpoad = 6;
            else
                $numFilesUlpoad=2;
        }else {
            $this->form_validation->set_message('checkForMediaCopy', 'You can not upload the files.');
            return FALSE;
        }


        //check for already uploaded images       
        $bus_Info = $this->mdgeneraldml->select('buss_media_copy', 'tbl_business_info', $where);
        $dbImageName = $bus_Info[0]['buss_media_copy'];
        if ($dbImageName != "") {
            $imageArray = explode(',', $dbImageName);
            $imagesInDbForthisBusiness = sizeof($imageArray);
            $numFilesUlpoad = ($numFilesUlpoad - $imagesInDbForthisBusiness);
            if ($numFilesUlpoad <= 0) {
                $this->form_validation->set_message('checkForMediaCopy', "You have exceded the image upload limit. If you wants to upload new images please remove the previous images.");
                return FALSE;
            }
        }


        ini_set('memory_limit', '-1');
        //echo '<pre>';print_r($_FILES['p_upload_photos']); die;
        $files = $_FILES['image_media'];
        //echo sizeof($files['name']);
        if (sizeof($files['name']) > $numFilesUlpoad) {
            $this->form_validation->set_message('checkForMediaCopy', "You can not upload more than $numFilesUlpoad files.");
            return FALSE;
        } else {
            $types = $files['type'];
            $flag = true;
            foreach ($types as $key => $val) {
                if ($val != "") {
                    $typeArray = explode("/", $val);
                    if ($typeArray[0] != 'image')
                        $flag = false;
                }else {
                    $this->form_validation->set_message('checkForMediaCopy', 'You can only upload the image file.');
                    return FALSE;
                }
            }

            if ($flag == true)
                return TRUE;
            else {
                $this->form_validation->set_message('checkForMediaCopy', 'You can only select upload the image file.');
                return FALSE;
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */