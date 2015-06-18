<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Change_password extends CI_Controller {

    function __construct()
    {
        parent::__construct();
         _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index()
    {        
        $tbl_user = 'tbl_user';
        $where_user = array('user_id' => $this->session->userdata('user_id'));
        $userInfo = $this->mdgeneraldml->select('*', $tbl_user, $where_user);
        $info = $userInfo[0];

        $this->form_validation->set_rules('curr_pwd', 'Old Password', 'xss_clean|trim|required|alpha_numeric|min_length[6]|max_length[12]|callback_change');
        $this->form_validation->set_rules('new_pwd', 'New Password', 'xss_clean|trim|required|alpha_numeric|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('con_new_pwd', 'Confirm Password', 'xss_clean|trim|required|matches[new_pwd]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('includes/header');
            $this->load->view('dashboard/change_password_view');
            $this->load->view('includes/footer');
        }
        else
        {
           // echo "ok";
            $fixed_pw=md5($this->input->post('new_pwd'));
            $user_id=$this->session->userdata('user_id');
            $update = $this->db->query("Update `tbl_user` SET `user_password`='$fixed_pw' WHERE `user_id`=$user_id");
            $this->session->set_flashdata('success','Your Password has been successfully changed.');
             redirect('dashboard/change_password');
        }
    }

    public function change() // we will load models here to check with database
    {
        $sql = $this->db->select('*')->from('tbl_user')->where('user_id', $this->session->userdata('user_id'))->get();

        foreach ($sql->result() as $my_info)
        {

            $db_password = $my_info->user_password;
            //$db_id = $my_info->user_id;
        }

        if (md5($this->input->post("curr_pwd")) != $db_password)
        {

          /*  $fixed_pw = mysql_real_escape_string(md5($this->input->post("new_pwd")));
            $update = $this->db->query("Update `tbl_user` SET `user_password`='$fixed_pw' WHERE `user_id`=$db_id") or die(mysql_error());*/
            $this->form_validation->set_message('change', 'Wrong Old Password!');
            return FALSE;
        }
        else
        {          
           return TRUE;
        }
    }

}