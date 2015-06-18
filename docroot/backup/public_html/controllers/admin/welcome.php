<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->library('session');     //  This Library is use to When session get created.	
        $this->load->model('mdgeneraldml');
    }

    public function index() {
        if ($this->session->userdata('adm_username') != '' || $this->session->userdata('adm_email') != '') {
            redirect('admin/home');
        } else if ($this->session->userdata('sub_adm_username') != '' || $this->session->userdata('sub_adm_email') != '') {
            redirect('admin/home/sub_admin_home');
        } else if ($this->session->userdata('sa_mg_username') != '' || $this->session->userdata('sa_mg_email') != '') {
            redirect('admin/home/sales_mgr_home');
        } else if ($this->session->userdata('sa_rp_username') != '' || $this->session->userdata('sa_rp_email') != '') {
            redirect('admin/home/sales_rep_home');
        } else {
            $this->load->view('admin/login_view'); // call the login_view.php files (View file)
        }
    }

    public function login() {
        $this->load->library('form_validation'); // Loading form_validation Library
        $this->load->helper('security');   //  Loading security Library

        $data = array('username' => $this->security->xss_clean($this->input->post('username')), 'password' => $this->security->xss_clean($this->input->post('password')));

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {

            $this->load->view('admin/login_view', $data); // call the login_view.php files (View file)
        } else {
            $a_username = $this->security->xss_clean($this->input->post('username'));
            $a_password = $this->security->xss_clean($this->input->post('password'));

            //Admin OR Sub-Admin
            $tbl = "tbl_administrators"; // login table
            $cnd = "adm_username ='" . $a_username . "' and adm_password ='" . md5($a_password) . "'";
            // condition of username and password
            $result = $this->db_transact_model->get_single_record($tbl, $cnd);
            $record_count = count($result);


            if ($record_count != 0) {
                if ($result[0]['adm_usertype'] == 'AD' && $result[0]['adm_status'] == 'A') {
                    //if record_count grater then 0 then session will get created for thet user
                    $admin_data = array('adm_type' => $result[0]['adm_usertype'],'adm_username' => $result[0]['adm_username'],
                        'adm_email' => $result[0]['adm_email'], 'adm_id' => $result[0]['adm_id'], 'logged_in' => TRUE);
                    $this->session->set_userdata($admin_data);
                    $this->session->set_flashdata('item', 'You have Logged-in successfully.');
                    $updateData = array('adm_last_login_date' => date('Y-m-d H:i:s'));
                    $tableName = 'tbl_administrators';
                    $where = array('adm_id' => $result[0]['adm_id']);
                    $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                    redirect("admin/home"); // After successfully log-ed In will redirect to home controller
                } else if ($result[0]['adm_usertype'] == 'SA' && $result[0]['adm_status'] == 'A') {
                    $admin_data = array('adm_type' => $result[0]['adm_usertype'],'adm_username' => $result[0]['adm_username'],
                        'adm_email' => $result[0]['adm_email'], 'adm_id' => $result[0]['adm_id'], 'logged_in' => TRUE);
                    $this->session->set_userdata($admin_data);
                    $this->session->set_flashdata('item', 'You have Logged-in successfully.');
                    $updateData = array('adm_last_login_date' => date('Y-m-d H:i:s'));
                    $tableName = 'tbl_administrators';
                    $where = array('adm_id' => $result[0]['adm_id']);
                    $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                    redirect("admin/home"); // After successfully log-ed In will redirect to home controller
                    /*$admin_data = array('sub_adm_username' => $result[0]['adm_username'],
                        'sub_adm_email' => $result[0]['adm_email'], 'sub_adm_id' => $result[0]['adm_id'], 'logged_in' => TRUE);
                    $this->session->set_userdata($admin_data);
                    $this->session->set_flashdata('item', 'You have Logged-in successfully.');
                    $updateData = array('adm_last_login_date' => date('Y-m-d H:i:s'));
                    $tableName = 'tbl_administrators';
                    $where = array('adm_id' => $result[0]['adm_id']);
                    $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                    redirect("admin/home/sub_admin_home"); // After successfully log-ed In will redirect to home controller*/
                } else if ($result[0]['adm_usertype'] == 'SM' && $result[0]['adm_status'] == 'A') {
                    $admin_data = array('sa_mg_adm_username' => $result[0]['adm_username'],
                        'sa_mg_adm_email' => $result[0]['adm_email'], 'sa_mg_adm_id' => $result[0]['adm_id'], 'logged_in' => TRUE);
                    $this->session->set_userdata($admin_data);
                    $this->session->set_flashdata('item', 'You have Logged-in successfully.');
                    $updateData = array('adm_last_login_date' => date('Y-m-d H:i:s'));
                    $tableName = 'tbl_administrators';
                    $where = array('adm_id' => $result[0]['adm_id']);
                    $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                    redirect("admin/home/sales_mgr_home"); // After successfully log-ed In will redirect to home controller
                } else if ($result[0]['adm_usertype'] == 'SR' && $result[0]['adm_status'] == 'A') {
                    $admin_data = array('sa_rp_adm_username' => $result[0]['adm_username'],
                        'sa_rp_adm_email' => $result[0]['adm_email'], 'sa_rp_adm_id' => $result[0]['adm_id'], 'logged_in' => TRUE);
                    $this->session->set_userdata($admin_data);
                    $this->session->set_flashdata('item', 'You have Logged-in successfully.');
                    $updateData = array('adm_last_login_date' => date('Y-m-d H:i:s'));
                    $tableName = 'tbl_administrators';
                    $where = array('adm_id' => $result[0]['adm_id']);
                    $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
                    redirect("admin/home/sales_rep_home"); // After successfully log-ed In will redirect to home controller
                } else {
                    $this->session->set_flashdata('item', 'Invalid username/Password.');
                    redirect('admin/');
                }
            } else {
                $this->session->set_flashdata('item', 'Invalid username/Password.');
                redirect('admin/');
            }
        }
    }

    public function logout() {
        //unset session values 
        $admin_data = array('adm_id' => '', 'adm_username' => '', 'adm_email' => '', 'logged_in' => FALSE);
        $this->session->unset_userdata($admin_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('item', 'You are logged out successfully.');
        redirect('admin');
    }

    public function sub_admin_logout() {
        ////unset session values 
        $admin_data = array('sub_adm_id' => '', 'sub_adm_username' => '', 'sub_adm_email' => '', 'logged_in' => FALSE);
        $this->session->unset_userdata($admin_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('item', 'You are logged out successfully.');
        redirect('admin');
    }

    public function sales_mgr_logout() {
        $sale_data = array('sa_mg_sal_username' => '', 'sa_mg_sal_email' => '', 'sa_mg_sal_uid' => '', 'logged_in' => FALSE);
        $this->session->unset_userdata($sale_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('item', 'You are logged out successfully.');
        redirect('admin');
    }

    public function sales_rep_logout() {
        $sale_data = array('sa_rp_sal_username' => '', 'sa_rp_sal_email' => '', 'sa_rp_sal_uid' => '', 'logged_in' => FALSE);
        $this->session->unset_userdata($sale_data);
        $this->session->sess_destroy();
        $this->session->set_flashdata('item', 'You are logged out successfully.');
        redirect('admin');
    }

    public function forgot() {
        redirect('admin/welcome');
    }

}
