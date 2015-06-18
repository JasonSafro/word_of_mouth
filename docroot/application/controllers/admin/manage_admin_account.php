<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_admin_account extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
        $this->load->library('session');     //  This Library is use to When session get created.	
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
        $this->load->model('admin_model');
        $this->load->library('pagination');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

    public function index()
    {
        $where = array('adm_usertype' => 'AD');
        $data['admin_data'] = $this->mdgeneraldml->select('*', 'tbl_administrators', $where);

        $data['admin_full_name'] = $data['admin_data'][0]['adm_full_name'];
        $data['admin_name'] = $data['admin_data'][0]['adm_username'];
        $data['admin_email'] = $data['admin_data'][0]['adm_email'];
        $data['admin_pwd'] = '';
        $data['admin_cnt_num'] = $data['admin_data'][0]['adm_contactno'];
        $data['btnName'] = 'Save';
        $this->load->view('admin/includes/header');
        $this->load->view('admin/admin_account_views/manage_admin_account_edit_view', $data);
        $this->load->view('admin/includes/footer');
    }

    public function edit()
    {
        $where = array('adm_usertype' => 'AD');
        $data['admin_data'] = $this->mdgeneraldml->select('*', 'tbl_administrators', $where);
        $adm_id = $data['admin_data'][0]['adm_id'];
        $data['admin_full_name'] = $data['admin_data'][0]['adm_full_name'];
        $data['admin_name'] = $data['admin_data'][0]['adm_username'];
        $data['admin_email'] = $data['admin_data'][0]['adm_email'];
        $data['admin_pwd'] = '';
        $data['admin_cnt_num'] = $data['admin_data'][0]['adm_contactno'];
        $data['btnName'] = 'Save';
        $this->form_validation->set_rules('adm_full_name', 'Full Name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('adm_username', 'User Name', 'xss_clean|trim|required|alpha_numeric|min_length[4]|max_length[32]|callback_username_check[' . $adm_id . ']');
        $this->form_validation->set_rules('adm_email', 'Email', 'xss_clean|trim|required|valid_email|callback_email_check[' . $adm_id . ']');
        $this->form_validation->set_rules('adm_password', 'Password', 'trim|alpha_numeric|min_length[6]|max_length[12]|required');
        $this->form_validation->set_rules('adm_contactno', 'Contact no', 'xss_clean|trim|is_numeric|required');

        if ($this->form_validation->run() == FALSE)
        {

            $this->load->view('admin/includes/header');
            $this->load->view('admin/admin_account_views/manage_admin_account_edit_view', $data);
            $this->load->view('admin/includes/footer');
        }
        else
        {
            $updateData=array(
                        'adm_full_name' =>$this->input->post('adm_full_name'),
                        'adm_username'     =>$this->input->post('adm_username'),
                        'adm_email'     =>$this->input->post('adm_email'),                       
                        'adm_password'      =>($this->input->post('adm_password')!="" ? md5($this->input->post('adm_password')) : $data['admin_data'][0]['adm_password']),
                        'adm_contactno'       =>$this->input->post('adm_contactno'),
                        'adm_updated_date'     =>_getDateAndTime()
                  );

               $tableName = 'tbl_administrators';
               $where = array('adm_id' => $adm_id);
               $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
               $this->session->set_flashdata('item', 'Admin Data has been successfully updated.');
               redirect(ADMIN_FOLDER_NAME.'/home');
        }
    }

    public function username_check($str, $adm_id)
    {
        $sql_q = "SELECT adm_id, adm_username FROM tbl_administrators WHERE adm_username = '$str' AND adm_id != '$adm_id'";
        $execute_q = $this->admin_model->sqlQuery($sql_q);
        $record_count = count($execute_q);
        //  echo $this->db->last_query();die;
        if ($record_count != 0)
        {
            $this->form_validation->set_message('username_check', 'This entry is already exist. Please enter something else.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    public function email_check($str, $adm_id)
    {
        $sql_q = "SELECT adm_id, adm_email FROM tbl_administrators WHERE adm_email = '$str' AND adm_id != '$adm_id'";
        $execute_q = $this->admin_model->sqlQuery($sql_q);
        $record_count = count($execute_q);
        //  echo $this->db->last_query();die;
        if ($record_count != 0)
        {
            $this->form_validation->set_message('email_check', 'This entry is already exist. Please enter something else.');
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}
