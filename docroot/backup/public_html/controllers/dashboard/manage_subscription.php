<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_subscription extends CI_Controller {

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
        $userInfo = $this->mdgeneraldml->select('user_plan', $tbl_user, $where_user);
        $info = $userInfo[0];

        $tbl_user_subscription_plan_info = 'tbl_user_subscription_plan_info';
        $where = array('user_id' => $this->session->userdata('user_id'));
        $userInfo1 = $this->mdgeneraldml->select('*', $tbl_user_subscription_plan_info, $where);
        $info1 = $userInfo1[0];
        //echo '<pre>'; print_r($info1);
        
        //$where1 = array('subs_plan_id' => $info1['sub_subplan_id']);
        $where1 = array('subs_sub_plan_id' => $info1['sub_subplan_id']);
        $sub_sub_plan_name = $this->mdgeneraldml->select('subs_sub_plan_name', 'tbl_subscription_sub_plans', $where1);
        //echo $this->db->last_query(); die;
        //echo '<pre>'; print_r($sub_sub_plan_name); die;
        /*if($info['user_plan'] == 'bm')
        {
            $data['sub_sub_plan'] = $sub_sub_plan_name[1]['subs_sub_plan_name'];
        }
        elseif($info['user_plan'] == 'ba')
        {
            $data['sub_sub_plan'] = $sub_sub_plan_name[0]['subs_sub_plan_name'];
        }
        elseif($info['user_plan'] == 'pm')
        {
            $data['sub_sub_plan'] = $sub_sub_plan_name[3]['subs_sub_plan_name'];
        }
        elseif($info['user_plan'] == 'pa')
        {
            $data['sub_sub_plan'] = $sub_sub_plan_name[2]['subs_sub_plan_name'];
        }*/
        
        $data['sub_sub_plan'] = $sub_sub_plan_name[0]['subs_sub_plan_name'];
        
        $where2 = array('subs_plan_id' => $info1['sub_plan_id']);
        $sub_plan_name = $this->mdgeneraldml->select('subs_plan_name', 'tbl_subscription_plans', $where2);


        $data['sub_plan'] = $sub_plan_name[0]['subs_plan_name'];
        $data['start_date']=$info1['sub_start_date'];
        $data['end_date']=$info1['sub_end_date'];
        
        /* print_r($sub_sub_plan);
          print_r($sub_plan); */
        
        $this->load->view('includes/header');
        $this->load->view('dashboard/subscription_plan_view', $data);
        $this->load->view('includes/footer');
    }

}