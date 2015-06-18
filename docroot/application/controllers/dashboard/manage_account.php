<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_account extends CI_Controller {

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

        $data = array(
            'user_name' => $info['user_name'],
            'user_fname' => $info['user_fname'],
            'user_lname' => $info['user_lname'],
            'user_city' => $info['user_city'],
            'user_address' => $info['user_address'],
            'user_address_addon' => $info['user_address_addon'],
            'user_zipcode' => $info['user_zipcode'],
            'user_phone' => $info['user_phone'],           
            'user_country'=>$info['user_country']
        );
        //Get User State
        $where_state_id = array('state_id' => $info['user_state']);
        $get_state = $this->mdgeneraldml->select('state_name', 'tbl_state', $where_state_id);
        if (count($get_state) > 0)
            $data['user_state'] = $get_state[0]['state_name'];
        else
            $data['user_state'] = '';
            
        //Get User Country
        /*
        $where_country_code = array('country_code' => $info['user_country']);
        $get_country = $this->mdgeneraldml->select('country_name', 'tbl_country', $where_country_code);

        if (count($get_country) > 0)
            $data['user_country'] = $get_country[0]['country_name'];
        else
            $data['user_country'] = '';*/

        $this->form_validation->set_rules('user_fname', 'First name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('user_lname', 'Last name', 'xss_clean|trim|required');
        $this->form_validation->set_rules('user_address', 'Address', 'xss_clean|trim|required');
        $this->form_validation->set_rules('user_address_addon', 'Address Add On', 'xss_clean|trim');
        $this->form_validation->set_rules('user_city', 'City', 'xss_clean|trim|required|max_lenght[30]');
       /* $this->form_validation->set_rules('user_state', 'State', 'xss_clean|trim|required');
        $this->form_validation->set_rules('user_country', 'Country', 'xss_clean|trim|required');*/
        $this->form_validation->set_rules('Items', 'Country', 'required');
        $this->form_validation->set_rules('userState', 'State', 'required');
        $this->form_validation->set_rules('user_zipcode', 'Zip Code', 'required|is_numeric');
        
        $this->form_validation->set_rules('user_phone', 'Phone no', 'xss_clean|trim|required|is_numeric');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('includes/header');
            $this->load->view('dashboard/account_setting_view', $data);
            $this->load->view('includes/footer');
        }
        else
        {            
            $updateData = array(
                'user_fname' => $this->input->post('user_fname'),
                'user_lname' => $this->input->post('user_lname'),
                'user_address' => $this->input->post('user_address'),
                'user_address_addon' => $this->input->post('user_address_addon'),
                'user_city' => $this->input->post('user_city'),
                'user_state' => $this->input->post('userState'),
                'user_country' => $this->input->post('Items'),
                'user_phone' => $this->input->post('user_phone'),
                'user_zipcode'=> $this->input->post('user_zipcode'),
                'user_update_date' => _getDate()
            );

            $tableName = 'tbl_user';
            $where = array('user_id' => $this->session->userdata('user_id'));
            $result = $this->mdgeneraldml->update($where, $tableName, $updateData);
            $url = base_url() . 'dashboard/account_overview';
            echo "<script>alert('Information Updated Successfully!');window.location.href='$url'</script>";
        }
    }

    
    
     function getCountrys()
    {
        $countryList = _getCountryList();
        $responseArray = array();

        foreach ($countryList as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }

    function getStateList($countryCode)
    {
        //$st='id="userState" class="items"';//stateHolder
        // echo form_dropdown('userState', _getStateList($countryCode),set_value('userState'),'id="userState" class="items"'); 
        $stateList = _getStateList($countryCode);
        foreach ($stateList as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }
    
    function getState($countryCode)
    {
        $get_user_state = "SELECT user_state FROM tbl_user WHERE tbl_user.user_id='" . $this->session->userdata('user_id') . "'";
        $result_user_state = $this->db->query($get_user_state)->result_array();


        $get_state = "SELECT state_id,state_name FROM tbl_state WHERE state_id='" . $result_user_state[0]['user_state'] . "'";
        $result_state = $this->db->query($get_state)->result_array();

        foreach ($result_state as $key => $val)
        {
            $list[$val['state_id']] = $val['state_name'];
        }


        foreach ($list as $key => $val)
        {
            if ($key !== "")
                $responseArray[] = array('val' => $key, 'text' => $val);
        }

        echo json_encode($responseArray);
    }
    
    public function test()
    {
        $this->load->view('includes/header');
        $this->load->view('dashboard/testcountry');
        $this->load->view('includes/footer');
    }
}