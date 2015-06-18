<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Forgot_pwd extends CI_Controller {

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
        /* $this->form_validation->set_rules('forg_email', 'Email', 'xss_clean|trim|required|valid_email');
          if ($this->form_validation->run() == FALSE)
          {
          $where = array('catStatus' => 'Active');
          $data['categories'] = $this->mdgeneraldml->select('*', 'tbl_category', $where);
          $this->load->view('includes/header', $data);
          $this->load->view('home_view');
          $this->load->view('includes/footer');
          }
          else
          {

          } */
    }

    function check_email()
    {
        $where = array('user_email' => $_POST['forg_email'], 'user_acc_status !=' => 'D');
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
            $uemail = $this->input->post('forg_email');
            $cnd = array('tbl_user.user_email = ' => $uemail);
            $userInfo = $this->mdgeneraldml->select($select, $tbl, $cnd);
		
			
            //  print_r($userInfo);die;

            if (!empty($userInfo))
            {
                $userInfo = $userInfo[0];
                //echo $userInfo['user_acc_status'];die;
                if ($userInfo['user_acc_status'] == 'A')
                {

                    //Generate New Password
                    //Create a String
                    function RandomString($length)
                    {
                        $original_string = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
                        $original_string = implode("", $original_string);
                        return substr(str_shuffle($original_string), 0, $length);
                    }

                    $u_mail = $userInfo['user_email'];
                    //Update Link Status to 1 (1 is for Link Created First Time)     
                    $uid_select = array("user_id" => $userInfo['user_id']);
                    $where = $uid_select;
                    $link_st = array("user_forgot_pwd_link_click_status" => 1);
                    $this->mdgeneraldml->update($where, $tbl, $link_st);

                    $newpwd = RandomString(6);
                    $data = array("user_password" => md5($newpwd));
                    //Update Table with this password
                    $this->mdgeneraldml->update($where, $tbl, $data);

                    //Send Email with Encrypted mail and password
                    $encryption_str = $u_mail . "/" . $newpwd;
                    $enc_text = base64_encode($encryption_str);
			
                    //Send Email                  
                    /* $subject = "Reset Password";
                      $msg = "To reset Your Password Click/Copy This Link.<br>";
                      $msg.="<a href='" . base_url() . "forgot_pwd/getpassword/" . $enc_text . "' target='_blank'> Reset Password </a>";
                      sendEmail($u_mail, $u_mail, $subject, $msg); */
                    // echo base_url() . "forgot_pwd/getpassword/" . $enc_text;    
	                 //echo "true," . base_url() . "forgot_pwd/getpassword/" . $enc_text;
                    

					$pass_link = base_url() . "forgot_pwd/getpassword/" . $enc_text;
					
					$user_full_name = $userInfo['user_fname']." ".$userInfo['user_lname'];
					$where_Id=array('emailId'=>'105');
					$emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
					$emilTemplet=$emailinfo[0]['emailBody'];
					$emilTempletSubject=$emailinfo[0]['emailSubject'];
					$emailBody=str_replace ("[[USER_FULL_NAME]]", $user_full_name, $emilTemplet);
					$emailBody=str_replace ("[[LINK]]", $pass_link, $emailBody);
										
					//send email to admin
					send_email($userInfo['user_email'],$emilTempletSubject,$emailBody);
					
					echo "true," . 'Please check your inbox to reset your password';
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

    //After Mail Sent for forget password 
    public function getpassword($enc_text_return)
    {
        //Decrypt the url (Email and Password)
        $decrypt_str = base64_decode($enc_text_return);
        $user_info_arr = explode("/", $decrypt_str);


        //Get New Password with That users Email
        $tbl = "tbl_user";
        $cnd = "user_email = '" . $user_info_arr[0] . "' ";
        $res_mail_chk = $this->db_transact_model->get_single_record($tbl, $cnd);

        //If Already link Status is 0 then link is expired		
        $status = 0;
        $get_mem_id = $res_mail_chk[0]['user_id'];
        //$cnd1 = "user_forgot_pwd_link_click_status  = '".$status."' "; 
        $cnd1 = "user_forgot_pwd_link_click_status  = '" . $status . "' and user_id='" . $get_mem_id . "' ";
        $get_link_status = $this->db_transact_model->get_single_record($tbl, $cnd1);
        if (count($get_link_status) > 0)
        {
            echo "Link Expired";
        }
        else
        {
            if (!empty($user_info_arr))
            {
                if (md5($user_info_arr[1]) == $res_mail_chk[0]['user_password'])
                {
                    $sess_arr = array(
                        "user_id" => $res_mail_chk[0]['user_id'],
                        "user_email" => $res_mail_chk[0]['user_email'],
                        "user_name" => $res_mail_chk[0]['user_name'],
                        "user_type" => $res_mail_chk[0]['user_type']
                    );
                    $this->session->set_userdata($sess_arr);

                    //Update Link Status to 0 (0 is for Link Expired)
                    $uid = $res_mail_chk[0]['user_id'];
                    $uid_select = array("user_id" => $uid);
                    $tbl1 = "tbl_user";
                    $where = $uid_select;
                    $link_st = array("user_forgot_pwd_link_click_status" => 0);
                    $this->mdgeneraldml->update($where, $tbl1, $link_st);
                    redirect(base_url() . 'forgot_pwd/create_new_pwd');
                }
            }
            else
            {
                echo "Invalid URL";
            }
        }
    }

    public function create_new_pwd()
    {
        $this->load->view('cre_new_pwd_view');
    }

    public function change_pwd()
    {
        $this->form_validation->set_rules('n_pass', 'Password', 'xss_clean|trim|required|alpha_numeric|matches[c_pass]');
        $this->form_validation->set_rules('c_pass', 'Confirm Password', 'xss_clean|trim|required|alpha_numeric|matches[n_pass]');
        if ($this->form_validation->run() == FALSE)
        {
            $this->load->view('cre_new_pwd_view');
        }
        else
        {
            if ($this->session->userdata('user_id') == '')
            {
                $url = base_url();
                echo "<script>
			alert('ERROR: Somthing Goes Wrong, Please Try Again!!');
			window.location.href='$url'</script>";
            }
            else
            {
                $new_pwd = array("user_password" => md5($this->input->post('n_pass')));
                $where = array("user_id" => $this->session->userdata('user_id'));
                $tbl1 = "tbl_user";
                $status = $this->mdgeneraldml->update($where, $tbl1, $new_pwd);
				if($status)
				{
		            $userinfo=$this->mdgeneraldml->select('user_name,user_email,user_fname,user_lname','tbl_user',$where);
					$user_full_name = $userinfo[0]['user_fname']." ".$userinfo[0]['user_lname'];
					$where_Id=array('emailId'=>'106');
					$emailinfo=$this->mdgeneraldml->select('*','tbl_email_contents',$where_Id);
							
					$emilTemplet=$emailinfo[0]['emailBody'];
					$emilTempletSubject=$emailinfo[0]['emailSubject'];
					
					$emailBody=str_replace ("[[USER_FULL_NAME]]", $user_full_name, $emilTemplet);

					//send email to admin
					send_email($userinfo[0]['user_email'],$emilTempletSubject,$emailBody);
				}
                
				$url = base_url() . 'dashboard/account_overview';
                echo "<script>alert('Password Changed Successfully!');window.location.href='$url'</script>";
            }
        }
    }

}

/* End of file forgot_pwd.php */
/* Location: ./application/controllers/forgot_pwd.php */