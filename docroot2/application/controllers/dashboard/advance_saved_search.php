<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class advance_saved_search extends CI_Controller {

    function __construct() {
        parent::__construct();
        _authenticateUserLogin();
        $this->load->model('website_general_model', 'WGModel');
        $this->load->model('mdgeneraldml');
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }

    function index() {
        $user_id = $this->session->userdata('user_id');
        //echo $this->session->userdata('user_type'); die;
        //echo $user_id; die;
        $data['searchList'] = $this->mdgeneraldml->select('*', 'tbl_advance_search', array('user_id' => $user_id));
        $this->load->view('includes/header');
        $this->load->view('dashboard/advance_saved_search_view', $data);
        $this->load->view('includes/footer');
    }

    function delete($srhId) {
        $where = array('search_id' => $srhId);
        if ($srhId != NULL && _isRecordExist('tbl_advance_search', $where)) {
            $this->mdgeneraldml->delete($where, 'tbl_advance_search');
            $this->session->set_flashdata('success', "Search record deleted successfully.");
            redirect('dashboard/advance_saved_search');
        } else {
            $this->session->set_flashdata('error', 'Record not exist.');
            redirect('dashboard/advance_saved_search');
        }
    }

    function delete_selected() {
        if (!empty($_POST)) {
            //print_r($_POST['chkmsg']);
            //for($i=0;$i<count($_POST['chkmsg']);$i++)
            // {
            $id = implode(',', $_POST['chkmsg']);
            $whereIn = "search_id IN(" . $id . ")"; //array('column'=>'search_id','fields'=>$id);

            $this->mdgeneraldml->delete($whereIn, 'tbl_advance_search');
            //echo $this->db->last_query();
            //}
            $this->session->set_flashdata('success', "Your selected search history has been deleted successfully.");
            $ret_html = true;
            echo json_encode($ret_html);
            die;
            // redirect('dashboard/advance_saved_search');
        } else {
            $this->session->set_flashdata('error', 'Please select at list single record.');
            //   redirect('dashboard/advance_saved_search');
        }
    }

}