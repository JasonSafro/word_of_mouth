<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
        //$this->load->library('session');	    //  This Library is use to When session get created.	
        $this->load->library('email');  // Email library to send mail
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->helper('captcha');
        $this->load->library('form_validation');
    }

    public function index() {
        redirect('home');
    }

    //Home Page
    public function home() {

        $where = array('catStatus' => 'Active');
        $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
        $data['testimonials'] = $this->mdgeneraldml->select('*', 'tbl_testimonials', array('tmlStatus' => 'Active'));
        $this->load->view('includes/header', $data);
        $this->load->view('home_view');
        $this->load->view('includes/footer');
    }

    //Services Page
    public function services() {               //Get subscription plans
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


        //Get service limit Details
        $tbl_service_limits = 'tbl_service_limits';
        $in_para = array('service_id');
        $where_not_in = array('service_id' => array(13, 14));
        $data['service_limits'] = $this->mdgeneraldml->select_not_in('*', $tbl_service_limits, $in_para, $where_not_in);
        // echo $this->db->last_query(); die;
        // echo '<pre>'; print_r($data); die;

        $this->load->view('includes/header');
        $this->load->view('services_view', $data);
        $this->load->view('includes/footer');
    }

    //FAQ Page
    public function faq() {
        $sql = "SELECT pageContent FROM tbl_static_pages WHERE pageId=100";
        $where = array('pageId' => '100');
        $data['pageInfo'] = $this->mdgeneraldml->select('*', 'tbl_static_pages', $where);
        $this->load->view('includes/header');
        $this->load->view('faq_view', $data);
        $this->load->view('includes/footer');
    }

    //Contact us Page
    public function contact_us() {
        $this->load->view('includes/header');
        $this->load->view('contact_us_view');
        $this->load->view('includes/footer');
    }

    //User Registration
    public function registerOLD() {
        //echo 'hellow im here....'; exit;
        $sess_arr = array(
            "uname" => $this->input->post('uname'),
            "email" => $this->input->post('email'));
        $this->session->set_userdata($sess_arr);
        $field_data = array('user_name' => $this->input->post('uname'),
            'user_email' => $this->input->post('email'),
            'user_password' => MD5($this->input->post('password')),
            'user_registered_date' => date('Y-m-d'),
            'user_update_date' => date('Y-m-d'),
            'user_acc_status' => "I",
            'act_link_click_status' => 1,
            'user_plan' => '',
            'user_type' => "site_user"
        );
        $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
        $last_ins_id = $data['last_insertId'];


        //Inser referral info if the user has created his account with the referance of existing user
        //please check the referrals controller where I have created the session for referralCode
        $referralCode = $this->session->userdata('referralCode');
        if ($referralCode != "") {
            $where2 = array('user_referralCode' => $referralCode);
            $info = $this->mdgeneraldml->select('user_id', 'tbl_user', $where2);
            if (!empty($info)) {
                $inserReferral = array(
                    'refUserId' => $info[0]['user_id'],
                    'refToUserId' => $last_ins_id,
                    'refCreatedOn' => _getDateAndTime()
                );
                $this->mdgeneraldml->insert('tbl_referral', $inserReferral);
            }
        }

        //Send Email
        $uname = $this->input->post('uname');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $encryption_str = $uname . "/" . $data['last_insertId'];
        $enc_text = base64_encode($encryption_str);
        $activation_url = base_url() . "user/activated_user/" . $enc_text;

        $where_Id = array('emailId' => '104');
        $emailinfo = $this->mdgeneraldml->select('*', 'tbl_email_contents', $where_Id);

        $emilTemplet = $emailinfo[0]['emailBody'];
        $emilTempletSubject = $emailinfo[0]['emailSubject'];

        $emailBody = str_replace("[[USER_FULL_NAME]]", $uname, $emilTemplet);
        $emailBody = str_replace("[[LINK]]", $activation_url, $emailBody);
        @send_email($email, $emilTempletSubject, $emailBody);
        //echo "<script>alert('mail sent successfully');</script>";
        /*  $subject = "Registration Details";
          $msg = "Hello " . $uname . ",<br><br>";
          $msg.= "Thanks for Registration" . "<br><br>";
          $msg.= "Your Deatils are : " . "<br><br>";
          $msg.= "User Name: " . $uname . "<br>";
          $msg.="Email: " . $email . "<br>";
          $msg.="Password: " . $password . "<br>"; */

        $encryption_str = $uname . "/" . $data['last_insertId'];
        $enc_text = base64_encode($encryption_str);
        /*  $msg.= "Thanks" . ".<br>";
          $msg.= "WOM Team " . ",<br>";
          $msg.="Login and Activate Your Account From The Given Link:  " . "<br>";
          $msg.="<a href='".base_url()."user/activated_user/".$enc_text."' target='_blank'> Activate Me </a>";
          sendEmail($uname, $email, $subject, $msg); */
        if ($data !== 0) {
            echo "true," . base_url() . "user/activated_user/" . $enc_text;
        } else {
            echo "false";
        }
    }

    function register() {
        $sess_arr = array(
            "uname" => $this->input->post('uname'),
            "email" => $this->input->post('email'));
        $this->session->set_userdata($sess_arr);
        $field_data = array('user_name' => $this->input->post('uname'),
            'user_email' => $this->input->post('email'),
            'user_password' => MD5($this->input->post('password')),
            'user_registered_date' => date('Y-m-d'),
            'user_update_date' => date('Y-m-d'),
            'user_acc_status' => "A", //I
            'act_link_click_status' => 0, //1
            'user_plan' => '',
            'user_type' => "site_user"
        );
        $stepOneSession = array('stepOneSession' => $field_data);
        $this->session->set_userdata($stepOneSession);

        echo "true";

        
    }

    //User Registration Step 2
    public function register_step2() {
        if (isset($_POST['submit'])) {
            if (isset($_POST['inter'])) {
                $inter = implode(",", $_POST['inter']);
            } else {
                $inter = "";
            }

            if (isset($_POST['subscr'])) {
                if ($_POST['subscr'] == 'on') {
                    $subscr = 1;
                } else {
                    $subscr = 0;
                }
            } else {
                $subscr = 0;
            }


            $field_data = array('user_fname' => $this->input->post('fname'),
                'user_lname' => $this->input->post('lname'),
                'user_phone' => $this->input->post('phone'),
                'user_city' => $this->input->post('city'),
                'user_address' => $this->input->post('uaddress'),
                'user_address_addon' => $this->input->post('uaddressaddon'),
                'user_zipcode' => $this->input->post('uzipcode'),
                'user_state' => $this->input->post('state'),
                'user_country' => $this->input->post('country'),
                'user_interest' => $inter,
                'user_newslet_sub' => $subscr
            );
            
            $stepOneData=$this->session->userdata('stepOneSession');
           $field_data= array_merge($field_data,$stepOneData);
           // echo '<pre>'; print_r($field_data);die;
            $data = $this->mdgeneraldml->insert('tbl_user', $field_data);
            $last_ins_id = $data['last_insertId'];

        
            //Inser referral info if the user has created his account with the referance of existing user
            //please check the referrals controller where I have created the session for referralCode
            $referralCode=$this->session->userdata('referralCode');
            if($referralCode!="")
            {            
                $where2=array('user_referralCode'=>$referralCode);
                $info=$this->mdgeneraldml->select('user_id','tbl_user',$where2);
                if(!empty($info)){
                    $inserReferral=array(
                        'refUserId'=>$info[0]['user_id'],
                        'refToUserId'=>$last_ins_id,
                        'refCreatedOn'=>_getDateAndTime()
                        );
                    $this->mdgeneraldml->insert('tbl_referral', $inserReferral);
                }
            }    

            //Send Email   
            $uname = $field_data['user_name'];
            $email = $field_data['user_email'];
            
            $encryption_str = $uname . "/" . $data['last_insertId'];
            $enc_text = base64_encode($encryption_str);
            $activation_url=base_url() . "user/activated_user/" . $enc_text;

            $where_Id=array('emailId'=>'104');
            $emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);

            $emilTemplet=$emailinfo[0]['emailBody'];
            $emilTempletSubject=$emailinfo[0]['emailSubject'];

            $emailBody=str_replace ("[[USER_FULL_NAME]]", $field_data['user_fname'].' '.$field_data['user_lname'], $emilTemplet);
            $emailBody=str_replace ("[[LINK]]", $activation_url, $emailBody);
            @send_email($email,$emilTempletSubject,$emailBody);
            
            //unset previous session
            $this->session->unset_userdata('uname');
            $this->session->unset_userdata('email');
            $this->session->unset_userdata('stepOneSession');
               
            //set new session to login the user
            $sess_arr = array(
                "user_id" => $last_ins_id,
                "user_email" => $field_data['user_email'],
                "user_name" => $field_data['user_name'],
                "user_type" => $field_data['user_type']
            );
            $this->session->set_userdata($sess_arr);
             //echo $emailBody; die;           
            $url = base_url() . 'dashboard';
            echo "<script>alert('You have registered successfully.');window.location.href='$url'</script>";
        }
        /*if (isset($_POST['skip'])) {
            $this->session->unset_userdata('uname');
            $this->session->unset_userdata('email');
            redirect(base_url() . 'user/home');
        }*/
    }

    //Activate user                
    function activated_user($act_enc_text_return) {

        //Decrypt the url (User_Name and user_id)
        $act_decrypt_str = base64_decode($act_enc_text_return);
        $act_user_info_arr = explode("/", $act_decrypt_str);
        // echo $act_decrypt_str;
        //Get users ID
        $tbl = "tbl_user";
        $cnd = "user_id = '" . $act_user_info_arr[1] . "' ";
        $res_id_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        if (count($res_id_chk) > 0) {
            if ($res_id_chk[0]['act_link_click_status'] == 0) {
                echo "Link Expired";
            } else {
                if ($act_user_info_arr[1] == $res_id_chk[0]['user_id']) {

                    $sess_arr = array(
                        "user_id" => $res_id_chk[0]['user_id'],
                        "user_email" => $res_id_chk[0]['user_email'],
                        "user_name" => $res_id_chk[0]['user_name'],
                        "user_type" => $res_id_chk[0]['user_type']
                    );
                    $this->session->set_userdata($sess_arr);
                    //Update Link Status to 0 (0 is for Link Expired)
                    $uid = $res_id_chk[0]['user_id'];
                    $uid_select = array("user_id" => $uid);
                    $tbl1 = "tbl_user";
                    $where = $uid_select;
                    $link_st = array("act_link_click_status" => 0);
                    $this->mdgeneraldml->update($where, $tbl1, $link_st);
                    $change_status = array("user_acc_status" => 'A', "user_last_login_on" => date('Y-m-d H:i:s'));
                    $this->mdgeneraldml->update($where, $tbl1, $change_status);
                    // redirect(base_url().'user/home');
                    redirect(base_url() . 'dashboard/account_overview');
                }
            }
        } else {
            echo "ERROR : NO ACCOUNT INFO AVAILABLE";
        }
    }

    // Check Duplicate Email
    public function check_email_dup() {
        $tbl = "tbl_user";
        $cnd = "user_email = '" . $this->input->post('email') . "' ";
        $res_mail_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
        if (count($res_mail_chk) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    // Check Duplicate Username
    public function check_uname_dup() {
        $tbl = "tbl_user";
        $cnd = "user_name = '" . $this->input->post('uname') . "' ";
        $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);
        if (count($res_name_chk) > 0) {
            echo "false";
        } else {
            echo "true";
        }
    }

    //Login user
    public function login_user() {
        $userfield = $this->input->post('uemail');
        $userpwd = $this->input->post('upassword');

        if (!filter_var($userfield, FILTER_VALIDATE_EMAIL)) {
            $username = $userfield;
            $tbl = "tbl_user";
            $cnd = "user_name = '" . $username . "'";
            $db_det = $this->db_transact_model->get_single_record($tbl, $cnd);
            //print_r($_POST);print_r($db_det);die;
            if (!empty($db_det)) {
                if ($db_det[0]['user_acc_status'] == "A") {
                    if ($db_det[0]['user_password'] == MD5($userpwd)) {
                        $sess_arr = array(
                            "user_id" => $db_det[0]['user_id'],
                            "user_email" => $db_det[0]['user_email'],
                            "user_name" => $db_det[0]['user_name'],
                            "user_type" => $db_det[0]['user_type']
                        );
                        $this->session->set_userdata($sess_arr);

                        //  echo $this->session->userdata('user_id');die;
                        if ($this->input->post('rem_check', true)) {
                            $val = $db_det[0]['user_email'] . "/" . $userpwd;
                            $cookie = array(
                                'name' => 'mem_login_info',
                                'value' => $val,
                                'expire' => '604800');
                            $this->input->set_cookie($cookie);
                        }
                        //Update Login user Date and Time
                        $uid_select = array("user_id" => $db_det[0]['user_id']);
                        $where = $uid_select;
                        $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                        $this->mdgeneraldml->update($where, $tbl, $change_login_time);
                        // redirect(base_url().'user/home');   
                        // redirect(base_url() . 'dashboard/account_overview'); 
                        //echo "true,ok";   
                        if ($this->session->userdata('user_type') == 'buss_user')
                            echo "true_bus_user,ok";
                        else
                            echo "true_site_user,ok";
                    }
                    else {
                        /* $url= base_url().'user/home';   
                          echo "<script>alert('Your Password Not Matching!');window.location.href='$url'</script>"; */
                        echo "false,Your Password Not Matching!";
                    }
                } else {
                    /* $url= base_url().'user/home';   
                      echo "<script>alert('Your Account is Not Acivated Yet!');window.location.href='$url'</script>"; */
                    echo "false1,Your Account is Not Acivated Yet!";
                }
            } else {
                /* $url= base_url().'user/home';   
                  echo "<script>alert('Your Email Not Matching!');window.location.href='$url'</script>"; */
                echo "false2,Your User Name Not Matching!";
            }
        } else {
            $useremail = $userfield;
            $tbl = "tbl_user";
            $cnd = "user_email = '" . $useremail . "'";
            $db_det = $this->db_transact_model->get_single_record($tbl, $cnd);
            //print_r($_POST);print_r($db_det);die;
            if (!empty($db_det)) {
                if ($db_det[0]['user_acc_status'] == "A") {
                    if ($db_det[0]['user_password'] == MD5($userpwd)) {
                        $sess_arr = array(
                            "user_id" => $db_det[0]['user_id'],
                            "user_email" => $db_det[0]['user_email'],
                            "user_name" => $db_det[0]['user_name'],
                            "user_type" => $db_det[0]['user_type']
                        );
                        $this->session->set_userdata($sess_arr);
                        if ($this->input->post('rem_check', true)) {
                            $val = $useremail . "/" . $userpwd;
                            $cookie = array(
                                'name' => 'mem_login_info',
                                'value' => $val,
                                'expire' => '604800');
                            $this->input->set_cookie($cookie);
                        }
                        //Update Login user Date and Time
                        $uid_select = array("user_id" => $db_det[0]['user_id']);
                        $where = $uid_select;
                        $change_login_time = array("user_last_login_on" => date('Y-m-d H:i:s'));
                        $this->mdgeneraldml->update($where, $tbl, $change_login_time);

                        if ($this->session->userdata('user_type') == 'buss_user')
                            echo "true_bus_user,ok";
                        else
                            echo "true_site_user,ok";
                    } else {
                        /* $url= base_url().'user/home';   
                          echo "<script>alert('Your Password Not Matching!');window.location.href='$url'</script>"; */
                        echo "false,Your Password Not Matching!";
                    }
                } else {
                    /* $url= base_url().'user/home';   
                      echo "<script>alert('Your Account is Not Acivated Yet!');window.location.href='$url'</script>"; */
                    echo "false1,Your Account is Not Acivated Yet!";
                }
            } else {
                /* $url= base_url().'user/home';   
                  echo "<script>alert('Your Email Not Matching!');window.location.href='$url'</script>"; */
                echo "false2,Your User Name Not Matching!";
            }
        }
    }

    //Check user Present or not
    public function check_user_present() {
        $tbl = "tbl_user";

        //Get UserName
        $cnd = "user_name = '" . $this->input->post('uemail') . "' ";
        $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        //Get Email
        $cnd1 = "user_email = '" . $this->input->post('uemail') . "' ";
        $res_name_chk1 = $this->db_transact_model->get_single_record($tbl, $cnd1);

        if (count($res_name_chk) > 0) {
            if ($res_name_chk[0]['user_acc_status'] == "A") {
                echo "true";
            } else {
                echo "false";
            }
        } else if (count($res_name_chk1) > 0) {
            if ($res_name_chk1[0]['user_acc_status'] == "A") {
                echo "true";
            } else {
                echo "false";
            }
        }
    }

    public function check_user_active() {
        $tbl = "tbl_user";
        //Get UserName
        $cnd = "user_name = '" . $this->input->post('uemail') . "' ";
        $res_name_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        //Get Email
        $cnd1 = "user_email = '" . $this->input->post('uemail') . "' ";
        $res_name_chk1 = $this->db_transact_model->get_single_record($tbl, $cnd1);

        if (count($res_name_chk) > 0 || count($res_name_chk1) > 0) {
            if ($res_name_chk[0]['user_acc_status'] == "A" || $res_name_chk1[0]['user_acc_status'] == "A") {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }
    }

    //Check User Password
    public function check_user_password() {
        //Get DATA by Email
        $tbl = "tbl_user";
        $select = 'tbl_user.*';
        $uemail = $this->input->post('uemail');
        $upassword = $this->input->post('upassword');
        $cnd = array('tbl_user.user_email = ' => $uemail);
        $get_pass = $this->mdgeneraldml->select($select, $tbl, $cnd);

        //Get DATA by Username
        $cnd1 = array('tbl_user.user_name = ' => $uemail);
        $get_pass1 = $this->mdgeneraldml->select($select, $tbl, $cnd1);

        echo $uemail;
        echo "\n";
        echo $get_pass[0]['user_password'];
        echo "\n";
        echo $get_pass1[0]['user_password'];
        echo "\n";
        echo MD5($upassword);
        echo "\n";

        if (count($get_pass) > 0 || count($get_pass1)) {
            if ($get_pass[0]['user_password'] == MD5($upassword) || $get_pass1[0]['user_password'] == MD5($upassword)) {
                echo "true";
            } else {
                echo "false";
            }
        } else {
            echo "false";
        }
    }

    function connect() {
        $redirect_uri = site_url('fsignup.php'); //'http://server.ashoresystems.com/~adsmarke/fsignup.php';
        //$url = "https://www.facebook.com/dialog/oauth?client_id=448194741967917&redirect_uri=$redirect_uri&scope=email,offline_access,user_birthday,status_update,publish_stream,manage_pages";
         $url = "https://www.facebook.com/dialog/oauth?client_id=689154591144524&redirect_uri=$redirect_uri&scope=email,offline_access,user_birthday,status_update,publish_stream,manage_pages";
        redirect($url);
    }

    public function logout() {
        //$this->session->unset_userdata('mem_id','mem_email');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_email');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_type');

        delete_cookie('mem_login_info');
        redirect(base_url() . 'home');
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */