<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Linkedin_login extends CI_Controller {

    function __construct() {
        $API_KEY = "tejdwohzjrye";
        $SECRET_KEY = "5uGXOQfJWOdA3oxS";

        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url'); 
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
        $this->header_arr['default_tab'] = 'home';
        $this->data['consumer_key'] = $API_KEY;
        $this->data['consumer_secret'] = $SECRET_KEY;
        $this->data['callback_url'] = site_url() . 'linkedin_login/linkedin_submit';
        $this->load->library('session');
    }

    public function index() {
        $this->load->library('linkedin', $this->data);
        $token = $this->linkedin->get_request_token();
        $this->session->set_userdata('oauth_request_token', $token['oauth_token']);
        $this->session->set_userdata('oauth_request_token_secret', $token['oauth_token_secret']);
        $request_link = $this->linkedin->get_authorize_URL($token);
        $data['link'] = $request_link;
        redirect($request_link);
    }

    function linkedin_submit() {
        $base_url_redirect = '/linkedin_login/linkedin_join';
        $this->data['oauth_token'] = $this->session->userdata('oauth_request_token');
        $this->data['oauth_token_secret'] = $this->session->userdata('oauth_request_token_secret');

        //laod the library with the variables defined in the constructor
        $this->load->library('linkedin', $this->data);
        //echo $_REQUEST['oauth_verifier'];

        $this->session->set_userdata('oauth_verifier', $_REQUEST['oauth_verifier']);

        /* Request access tokens from linkedin */
        $tokens = $this->linkedin->get_access_token($this->session->userdata('oauth_verifier'));
        /* Save the access tokens. */
        /* Normally these would be saved in a database for future use. */
        $this->session->set_userdata('oauth_access_token', $tokens['oauth_token']);

        $this->session->set_userdata('oauth_access_token_secret', $tokens['oauth_token_secret']);
        //store your user info
        //if your going to store the tokens you will need to serialise in and out of the db
        // you will need to write your own models- simple storage- serialization done here in the controller

        $xml = simplexml_load_string($this->linkedin->getProfile("~:(id,first-name,last-name,headline,picture-url,email-address,location,industry,distance,num-recommenders,api-standard-profile-request,positions,date-of-birth,phone-numbers,connections)"));

        //More List of fileds are listted out here   http://developer.linkedin.com/documents/profile-fields

        //echo "<pre>";
        //print_r($xml);
             
      
        
        $first_name = "first-name";        
        $last_name = "last-name";
        $email_address="email-address"; 
        
        $user_name = '' . $xml->$first_name . '';
        $fname = '' . $xml->$first_name . '';
        $lname = '' . $xml->$last_name . '';
        $email = '' . $xml->$email_address . '';       
       
        
        
          /*      $newdata = array(
            'uname'=>'"' . $xml->$first_name . '"',
            'fname' => '"' . $xml->$first_name . '"',
            'lname' => '"' . $xml->$last_name . '"',
            'email' => '"' . $xml->$email_address . '"',
        );
        */
        //Generate New Password
                //Create a String
                function RandomString($length)
                {
                    $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
                    $original_string = implode("", $original_string);
                    return substr(str_shuffle($original_string), 0, $length);
                }
                
                 $user_pwd = RandomString(6);
                 
                
                   //Check if user already present
                $tbl = "tbl_user";
                $cnd = "user_email = '" . $email . "' ";                
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
                        $url = base_url() . 'user/home';
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
                            'user_email' => $email,
                            'user_password' => md5($user_pwd),
                            'user_registered_date' => date('Y-m-d'),
                            'user_update_date' => date('Y-m-d'),
                            'user_acc_status' => "A",
                            'act_link_click_status' => 0,
                            'user_plan' => '',
                            'user_type' => "site_user",
                            'user_fname' => $fname,
                            'user_lname' => $lname,
                            'user_phone' => '',
                            'user_city' => '',
                            'user_state' => '',
                            'user_country' => '',
                            'user_interest' => '',
                            'user_newslet_sub' => '',
                            'user_address' => ''
                        );
                        $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
                        $last_ins_id = $data['last_insertId'];
                        //Send Email                        
                        /*  $subject = "Registration Details";
                          $msg = "Hello " . $user_name . ",<br><br>";
                          $msg.= "Thanks for Registration" . "<br><br>";
                          $msg.= "Your Deatils are : " . "<br><br>";
                          $msg.= "User Name: " . $user_name . "<br>";
                          $msg.="Email: " . $user_email . "<br>";
                          $msg.="Password: " . $user_pwd . "<br>";
                          $msg.= "Thanks" . ".<br>";
                          $msg.= "WOM Team " . ",<br>";
                          sendEmail($user_name, $user_email, $subject, $msg); */
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
                 
                 
                 
                 
       //   die;
        /*$newdata = array(
            'uname'=>'"' . $xml->$first_name . '"',
            'fname' => '"' . $xml->$first_name . '"',
            'lname' => '"' . $xml->$last_name . '"',
            'email' => '"' . $xml->$email_address . '"',
        );
        print_r($newdata);die;
        $this->session->set_userdata($newdata);*/

        //redirect('welcome/signup');
    }

}

?>