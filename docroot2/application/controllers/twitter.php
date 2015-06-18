<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
session_start();
class Twitter extends CI_Controller {
	
    function __construct() {
        parent::__construct();          
        $this->load->model('mdgeneraldml');
        $this->load->model('website_general_model','WGModel');  
        $this->form_validation->set_error_delimiters('<span class="red">', '</span>');
    }
    
    public $tweetAPIKey="WPJgsFyCJ5CzuTlx8juR6w";
    public $tweetSecretKey="rsICVRU9wLL6oIRowQ2WxIdhhy8v5VFzVqz5iXxA";
        
    function connect($socialMediaId=NULL)
    {         
           /* Start session and load library. */

            unset($_SESSION['oauth_token']);
            unset($_SESSION['oauth_token_secret']);
        
            require_once(APPPATH.'third_party/twitter1.1/twitteroauth/twitteroauth.php');
            //require_once(APPPATH.'third_party/twitter1.1/config.php');
            define('CONSUMER_KEY', $this->tweetAPIKey);
            define('CONSUMER_SECRET', $this->tweetSecretKey);
            //define('OAUTH_CALLBACK', 'http://server.ashoresystems.com/~adsmarke/twitter.php');
             define('OAUTH_CALLBACK', site_url('twitter/callback'));


            /* Build TwitterOAuth object with client credentials. */
            $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET);

            /* Get temporary credentials. */
            $request_token = $connection->getRequestToken(OAUTH_CALLBACK);
            
            /* Save temporary credentials to session. */
            $_SESSION['oauth_token'] = $token = $request_token['oauth_token'];
            $_SESSION['oauth_token_secret'] = $request_token['oauth_token_secret'];
            //echo '<pre>'; print_r($request_token); die;

            /* If last connection failed don't display authorization link. */
            switch ($connection->http_code) {
              case 200:
                /* Build authorize URL and redirect user to Twitter. */
                $url = $connection->getAuthorizeURL($token);
                header('Location: ' . $url); 
                break;
              default:
                /* Show notification if something went wrong. */                    
                  $this->session->set_flashdata('error','Sorry! Could not connect to Twitter. Refresh the home page or try again later.');                  
                  redirect('message');
            }
    }
    
    function callback()
    {
        require_once(APPPATH.'third_party/twitter1.1/twitteroauth/twitteroauth.php');
        //require_once(APPPATH.'third_party/twitter1.1/config.php');
        define('CONSUMER_KEY', $this->tweetAPIKey);
        define('CONSUMER_SECRET', $this->tweetSecretKey);
        define('OAUTH_CALLBACK', site_url('twitter/callback'));
        // echo '<pre>'; print_r($_SESSION);

        /* Create a TwitterOauth object with consumer/user tokens. */
        $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);

        $token_credentials = $connection->getAccessToken($_REQUEST['oauth_verifier']);
        //print_r($token_credentials);
        /* Get user access tokens out of the session. */
        //$access_token = $_SESSION['access_token'];
        /* If method is set change API call made. Test is called by default. */
        $content = $connection->get('account/verify_credentials');

        /* Some example calls */
        //$res=$connection->get('users/show', array('screen_name' => $token_credentials['screen_name']));
        $res=$connection->get('users/show', array('screen_name' => $token_credentials['screen_name']));
        //echo '<pre>';print_r($res);

        $this->session->set_userdata('social_name', $res->name);
        $this->session->set_userdata('social_image', $res->profile_image_url);        
        $this->session->set_userdata('social_username', $res->screen_name);        
        $this->session->set_userdata('social_city', $res->location);
        
        redirect('social_signin/register');
        
    }
    
}    