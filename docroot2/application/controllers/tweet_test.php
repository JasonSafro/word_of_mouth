<?php
	class Tweet_test extends CI_Controller {
 		function __construct()
		{
			parent::__construct();
			
			// It really is best to auto-load this library!
			$this->load->library('tweet');	
			$this->load->library('session');
			
			// Enabling debug will show you any errors in the calls you're making, e.g:
			$this->tweet->enable_debug(TRUE);
			
			// If you already have a token saved for your user
			// (In a db for example) - See line #37
			// 
			// You can set these tokens before calling logged_in to try using the existing tokens.
			// $tokens = array('oauth_token' => 'foo', 'oauth_token_secret' => 'bar');
			// $this->tweet->set_tokens($tokens);
			
			
			if ( !$this->tweet->logged_in() )
			{
				// This is where the url will go to after auth.
				// ( Callback url )
				
				$this->tweet->set_callback(site_url('tweet_test/auth'));
				
				// Send the user off for login!
				$this->tweet->login();
			}
			else
			{
				// You can get the tokens for the active logged in user:
				// $tokens = $this->tweet->get_tokens();
				
				// 
				// These can be saved in a db alongside a user record
				// if you already have your own auth system.
			}
		}
		
		function index()
		{
 
 		}
		
		function auth()
		{
		 
			$tokens = $this->tweet->get_tokens();
			$user = $this->tweet->call('get', 'account/verify_credentials');
			$twitter_username =	 $user->screen_name;
			$twt_name = explode(" ",$user->name);
			$first_name = $twt_name[0];
			
			$lname = '';
 			if(isset($twt_name[2]))
			{
				$lname = $twt_name[2];
 			}
 			$last_name = $twt_name[1].$lname;
 			$twitter_location =	 $user->location;
		 	 
			$newdata = array(
                   'twitter_username'  => $twitter_username,
                   'first_name'     => $first_name,
                   'last_name'     => $last_name,
			       'twitter_location'     => $twitter_location
               );
			/*$field_data = array('user_name' => $twitter_username,
                            'user_email' => '',
                            'user_password' =>'',
                            'user_registered_date' => date('Y-m-d'),
                            'user_update_date' => date('Y-m-d'),
                            'user_acc_status' => "A",
                            'act_link_click_status' => 0,
                            'user_plan' => '',
                            'user_type' => "site_user",
                            'user_fname' => $first_name,
                            'user_lname' => $last_name,
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
			$this->session->set_userdata($newdata);*/
			redirect('welcome');
		}
	}
?>