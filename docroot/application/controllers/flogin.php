<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Flogin extends CI_Controller {

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
    }

    //var $facebook_api_key = '448194741967917';    18-04-14
    var $facebook_api_key = '689154591144524';
                             
    
    
    //var $facebook_secret_key = 'ebe657a8f9bac70977abe2f9a2be732a'; 18-04-14
    var $facebook_secret_key = 'a6842c89058f63c30e5b72899053d231';
    
    
    //var $facebook_api_key = '623057237743207';
    //var $facebook_secret_key = '04f8e752dc3fd3e61957610caea19422';
    var $redirect_uri = 'http://www.wordofmouthreferral.com/fsignup.php';

    function flogin()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('mdgeneraldml');
        //$this->load->model('website_general_model','WGModel');
    }

    /*   public function index() {
      /* $data['headerTab'] = 5; // 5= Login Tab Selected
      $data['redirect_uri'] = $this->redirect_uri;
      $this->load->view('vwLogin', $data);
      }
     */

    function fsignup($code)
    {
        $my_url = $this->redirect_uri;

        $access_token = '';

        $token_url = "https://graph.facebook.com/oauth/access_token?client_id=" . $this->facebook_api_key . "&redirect_uri=" . urlencode($my_url) . "&client_secret=" . $this->facebook_secret_key . "&code=" . $code . "&display=popup";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);

        $params = null;
        @parse_str($response, $params);
        $access_token = @$params['access_token'];
        // echo '<pre>'; print_r($response); die;
        //$graph_url = "https://graph.facebook.com/me?fields=accounts,email" . "&access_token=" . $access_token;
        $graph_url = "https://graph.facebook.com/me?access_token=" . $access_token;
        // echo $graph_url.'<br/>';
        curl_setopt($ch, CURLOPT_URL, $graph_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response_graph = curl_exec($ch);
        curl_close($ch);
        // echo '<pre>'; print_r($response_graph);
        $decoded_response = json_decode($response_graph);
        //echo '<pre>';
        //print_r($decoded_response);die;


        if (isset($decoded_response->error))
        {
            // check to see if this is an oAuth error:
            if ($decoded_response->error->type == "OAuthException")
            {
                $dialog_url = "https://www.facebook.com/dialog/oauth?" . "client_id=" . $this->facebook_api_key . "&redirect_uri=" . urlencode($my_url);
                echo("<script> top.location.href='" . $dialog_url . "'</script>");
            }
            else
            {
                //Re-Direct to login page with some Error Message.
                //redirect('home/get_started');
                echo "Something Went Wrong";
            }
        }
        else
        {
            $fb_usr = (array) $decoded_response;

            if ($fb_usr["id"] == "" || $fb_usr["id"] == NULL)
            {
                //Re-Direct to login page with some Error Message.
                //redirect('home/get_started');
                echo "Something Went Wrong";
            }
            else
            {
                /*echo $decoded_response->email;
                echo '<pre>'; print_r($fb_usr);
                echo '-------------------------------------------FIREST END-------------------<br/>';
                echo '<pre>'; print_r($decoded_response);
                die;*/
               if(!isset($decoded_response->email)) 
               {   
                   $this->session->set_userdata('social_name', $decoded_response->first_name.' '.$decoded_response->last_name);
                   $this->session->set_userdata('social_image', '');        
                   $this->session->set_userdata('social_username', $decoded_response->username);        
                   $this->session->set_userdata('social_city', '');
                   //$url = base_url() . 'home';
                   //echo "<script>alert('Sorry! Your email address is protected by facebook, please change your facebook access permission and try again.');window.location.href='$url'</script>";
                   //die;
                   
                   $this->session->set_flashdata('success','Sorry! Your email address is protected by facebook, so please create your account from here.');
                   redirect('social_signin/register');
               }
                 
                        
                $user_name = $decoded_response->username;
                $user_email = $decoded_response->email;
                $user_fname = $decoded_response->first_name;
                $user_lname = $decoded_response->last_name;

                //Generate New Password
                //Create a String
                function RandomString($length)
                {
                    $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
                    $original_string = implode("", $original_string);
                    return substr(str_shuffle($original_string), 0, $length);
                }

              //  $user_city_state = explode(",", $fb_usr['location']->name);
              //  $user_addr_countr = explode(",", $fb_usr['hometown']->name);
                $user_pwd = RandomString(6);
              //  $user_city = $user_city_state[0];
             //   $user_state = $user_city_state[1];
             //   $user_country = $user_addr_countr[1];
             //   $user_address = $user_addr_countr[0];
                // $user_phone=
                // $user_zipcode=
                //Check if user already present
                $tbl = "tbl_user";
                $cnd = "user_email = '" . $user_email . "' ";
                $res_mail_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
                if (count($res_mail_chk) > 0)
                {
                    if ($res_mail_chk[0]['user_acc_status'] == "A")
                    {
                        $sess_arr = array(
                            "user_id" => $res_mail_chk[0]['user_id'],
                            "user_email" => $res_mail_chk[0]['user_email'],
                            "user_name" => $res_mail_chk[0]['user_name'],
                            "user_type" => $res_mail_chk[0]['user_type']
                        );
                        $this->session->set_userdata($sess_arr);
                        $uid_select = array("user_id" => $res_mail_chk[0]['user_id']);
                        $where = $uid_select;
                        $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                        $this->mdgeneraldml->update($where, $tbl, $change_login_time);
                        redirect(base_url() . 'dashboard/account_overview');
                    }
                     else{
                        $url = base_url() . 'home';
                        echo "<script>alert('Sorry. You are already Registered with us but your account is not Activated Yet .');window.location.href='$url'</script>";                        
                    }
                }
                //Check if user already present
                else
                {
                    $tbl = "tbl_user";
                    $cnd = "user_name = '" . $user_name . "' ";
                    $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
                    if (count($res_name_chk) > 0)
                    {
                        if ($res_name_chk[0]['user_acc_status'] == "A")
                        {
                            $sess_arr = array(
                                "user_id" => $res_name_chk[0]['user_id'],
                                "user_email" => $res_name_chk[0]['user_email'],
                                "user_name" => $res_name_chk[0]['user_name'],
                                "user_type" => $res_name_chk[0]['user_type']
                            );
                            $this->session->set_userdata($sess_arr);
                            $uid_select = array("user_id" => $res_name_chk[0]['user_id']);
                            $where = $uid_select;
                            $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                            $this->mdgeneraldml->update($where, $tbl, $change_login_time);
                            redirect(base_url() . 'dashboard/account_overview');
                        }
                         else{
                            $url = base_url() . 'user/home';
                            echo "<script>alert('Sorry. You are already Registered with us but your account is not Activated Yet .');window.location.href='$url'</script>";                        
                        }
                    }
                    else
                    {
                        $field_data = array('user_name' => $user_name,
                            'user_email' => $user_email,
                            'user_password' => md5($user_pwd),
                            'user_registered_date' => date('Y-m-d'),
                            'user_update_date' => date('Y-m-d'),
                            'user_acc_status' => "A",
                            'act_link_click_status' => 0,
                            'user_plan' => '',
                            'user_type' => "site_user",
                            'user_fname' => $user_fname,
                            'user_lname' => $user_lname,
                            'user_phone' => '',
                            'user_city' => '',
                            'user_state' => '',
                            'user_country' => '',
                            'user_interest' => '',
                            'user_newslet_sub' => '',
                            'user_address' => ''
                        );
                        //echo '<pre>'; print_r($field_data);
                        $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
                        $last_ins_id = $data['last_insertId'];
                        
                        if ($data !== 0)
                        {
                            $tbl = "tbl_user";
                            $cnd = "user_id = '" . $last_ins_id . "' ";
                            $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
                            if (count($res_name_chk) > 0)
                            {
                                if ($res_name_chk[0]['user_acc_status'] == "A")
                                {
                                    $sess_arr = array(
                                        "user_id" => $res_name_chk[0]['user_id'],
                                        "user_email" => $res_name_chk[0]['user_email'],
                                        "user_name" => $res_name_chk[0]['user_name'],
                                        "user_type" => $res_name_chk[0]['user_type']
                                    );
                                    $this->session->set_userdata($sess_arr);
                                    $uid_select = array("user_id" => $res_name_chk[0]['user_id']);
                                    $where = $uid_select;
                                    $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                                    $this->mdgeneraldml->update($where, $tbl, $change_login_time);
                                    redirect(base_url() . 'dashboard/account_overview');
                                }
                            }
                            else
                            {
                                $url = base_url() . 'user/home';
                                echo "<script>alert('Something Went Wrong! Please Try Again.');window.location.href='$url'</script>";
                            }
                        }
                        else
                        {
                            $url = base_url() . 'user/home';
                            echo "<script>alert('Something Went Wrong! Please Try Again.');window.location.href='$url'</script>";
                        }
                    }
                }
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */