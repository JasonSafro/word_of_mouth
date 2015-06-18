<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forgot_uname extends CI_Controller {

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
        $this->form_validation->set_error_delimiters('<span style="float:left;color: #EE0101 !important;">', '</span>');
    }

    public function index()
    {
       
    }

    function check_email()
    {
        $where = array('user_email' => $_POST['uname_forg_email'], 'user_acc_status !=' => 'D');
        $result = $this->mdgeneraldml->select('user_email', 'tbl_user', $where);
        if (!empty($result))
            echo 'true';
        else
            echo 'false';
    }

    function submitForm()
    {
        if (!empty($_POST))
        {
            //  $emailAddress = $this->input->post('forg_email');
            //Get User Info          
            $tbl = "tbl_user";
            $select = 'tbl_user.*';
            $uemail = $this->input->post('uname_forg_email');
            $cnd = array('tbl_user.user_email = ' => $uemail);
            $userInfo = $this->mdgeneraldml->select($select, $tbl, $cnd);
            //  print_r($userInfo);die;

            if (!empty($userInfo))
            {
                $userInfo = $userInfo[0];
                //echo $userInfo['user_acc_status'];die;
                if ($userInfo['user_acc_status'] == 'A')
                {
                    $u_mail = $userInfo['user_email'];
                    $uname=$userInfo['user_name'];
                    //Send Email                  
                  /*   $subject = "Forgot User Name";
                      $msg = "The User-Name For the Account is ".$uname."<br>";
                      $msg.="<a href='" . base_url() ."' target='_blank'> Open Web-Site </a>";
                      sendEmail($u_mail, $u_mail, $subject, $msg); */
                    // echo base_url() . "forgot_pwd/getpassword/" . $enc_text;    
                    echo "true, Username for This Email is : " . $uname;
                }
            }
            else
            {
                //$this->session->set_flashdata('error','User not exist this email.');
                //redirect('home');
                echo 'false';
            }
        }
    }

}

/* End of file forgot_uname.php */
/* Location: ./application/controllers/forgot_uname.php */