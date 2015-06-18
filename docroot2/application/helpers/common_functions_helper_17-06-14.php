<?php 

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

$ci = & get_instance();
$ci->load->database();
$ci->load->model('mdgeneraldml');

$ci->load->library('session');
$segment_page = $ci->uri->segment(1);


function _authenticateAdmin()
{
   $CI =& get_instance();       
   $CI->load->database();
   $CI->load->library('session');
       
    if($CI->session->userdata('a_user_name') != '' || $CI->session->userdata('a_id') != '' || $CI->session->userdata('logged_in') != '')
            return true;
    else
        redirect(ADMIN_FOLDER_NAME.'/welcome');
}

function _authenticateUserLogin()
{
   $CI =& get_instance();       
   $CI->load->database();
   $CI->load->library('session');
       
    if($CI->session->userdata('user_id') != '' && $CI->session->userdata('user_email'))
            return true;
    else
        redirect('home');
}

function _authenticateBusinessUser(){
    $obj =& get_instance();
    $obj->load->database();
    $userId=$obj->session->userdata('user_id');
    $sql = "SELECT user_type FROM tbl_user WHERE user_id=$userId";
    $result=$obj->db->query($sql)->result_array();
    if($result[0]['user_type']=='buss_user')
        return true;
    else
    {
        $obj->session->set_flashdata('error','Only business users can have this access.');
        redirect('dashboard');
    }
}


function _authenticatePrimiumUser(){
    $obj =& get_instance();
    $obj->load->database();
    $userId=$obj->session->userdata('user_id');
    $sql = "SELECT user_plan FROM tbl_user WHERE user_id=$userId";
    $result=$obj->db->query($sql)->result_array();
    if($result[0]['user_plan']=='pa' || $result[0]['user_plan']=='pm')
        return true;
    else
    {
        $obj->session->set_flashdata('error','Only premium business users can have this access.');
        redirect('dashboard');
    }
}


function _getDateAndTime()
{
    return date('Y-m-d H:i:s');
}

function _getDate()
{
    return date('Y-m-d');
}

function _getTime()
{
    return date('H:i:s');
}

function _isRecordExist($tableName, $where) 
{
    $obj =& get_instance();
    $obj->load->database();
    
    $obj->db->from($tableName);
    $obj->db->where($where);
    $count=$obj->db->count_all_results();
    if ($count > 0)
        return true;
    else
        return false;
}

function _getFooterVideos($pageName="home")
{    
	//echo "page NAme:".$pageName; exit
	$pageName=($pageName==""?'home':$pageName);
    $obj =& get_instance();
    $obj->load->database();
    if(_isRecordExist('tbl_footer_videos',array('fvPageName'=>$pageName,'fvStatus'=>'Active')))
        $where="fvStatus='Active' AND fvPageName='".$pageName."'";
    else
        $where="fvStatus='Active' AND fvPageName='home'";   
    
    $sql="SELECT fvId,fvImage,fvTitle,fvDescription,fvYouTubeVideoLink,fvReadMoreLink,fvUpdatedOn
        FROM tbl_footer_videos
        WHERE $where ORDER BY fvId ASC LIMIT 3";   
  
    return $obj->db->query($sql)->result_array();
}

function _getFooterRightContent()
{
    $obj =& get_instance();
    $obj->load->database();
    
    $sql="SELECT pageHeading,pageContent FROM tbl_static_pages WHERE pageId='106'";
    return $obj->db->query($sql)->result_array();
}

function _getHomePageSliders()
{
    $obj =& get_instance();
    $obj->load->database();
    
    $sql="SELECT sldrId,sldrImage,sldrTitle,sldrSubTitle FROM tbl_slider_contents WHERE sldrStatus='Active'";
    return $obj->db->query($sql)->result_array();
}

function _getSingleRecord($select=NULL,$from=NULL,$tableName=NULL)
{
    $obj =& get_instance();
    $obj->load->database();
    if($select!=NULL && $from!=NULL && $tableName!=NULL)
    {
        $obj->db->select($select);
        $obj->db->from($from);
        $obj->db->where($tableName);
        return $obj->db->get()->result_array();
        //return $obj->db->last_query();
    }
    else
        return false;
}

function _getUploadUnsupportMessageForIPhone(){
    $obj=& get_instance();
    $obj->load->library('user_agent');
    if ($obj->agent->is_mobile('iphone')){
        return "Upload is not supported by iPad.";
    }else{
        return "";
    }
}

function _getHeaderPhoneNo(){
   $obj =& get_instance();
    $obj->load->database();    
    $sql="SELECT headerFooterPhoneNo FROM tbl_admin_setting";
    $result=$obj->db->query($sql)->result_array();
    if(!empty($result)){
        return $result[0]['headerFooterPhoneNo'];
    }else{
        return '';
    }
}

function pagination_count()
{
	$obj =& get_instance();
	$obj->load->database();
	$qry = "Select num_rows from tbl_setting_paginination";
	$row['data'] = $obj->db->query($qry)->result(); 
	return $row['data'][0]->num_rows;
}

function send_email($email_ids, $subject, $body, $file_name = NULL) {
    $CI = & get_instance();
    $CI->load->library('email');
    
    /*$config['protocol'] = PROTOCOL;
    $config['smtp_host'] = SMTP_HOST;
    $config['smtp_port'] = SMTP_PORT;
    $config['smtp_timeout'] = SMTP_TIMEOUT;

    $config['smtp_user'] = SMTP_USER_EMAIL;
    $config['smtp_pass'] = SMTP_PASSWORD;

    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html'; // text or html
    $config['validation'] = TRUE; // bool whether to validate email or not  $CI->email->initialize($config);
    $config['wordwrap'] = TRUE;
    $CI->email->from(SMTP_USER_EMAIL, SMTP_USERNAME);
    $CI->email->to($email_ids);
    $CI->email->subject($subject);
    $CI->email->message($body);*/
    

    
    $admin_email=ADMIN_EMAIL;
    $config['protocol'] = 'sendmail';
    $config['mailtype'] = 'html'; // text or html
    //$config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'utf-8'; //iso-8859-1
    $config['newline'] = "\r\n";
    $config['validation'] = TRUE; // bool whether to validate email or not 
    $config['wordwrap'] = TRUE;
    $CI->email->initialize($config);
    $CI->email->from($admin_email, 'wordofmouthreferral.com');
    $CI->email->to($email_ids);
    $CI->email->subject($subject);
    $CI->email->message($body);    
	if($file_name != NULL)
	{
            foreach($file_name as $key=>$attachemnt)
                $CI->email->attach($attachemnt);
	}
    return $CI->email->send();
}

function send_bcc_email($from,$to,$subject,$body,$bcc=NULL,$cc=NULL,$file_name=NULL) {
    $CI = & get_instance();
    $CI->load->library('email');
    
    $config['protocol'] = 'sendmail';
    $config['mailtype'] = 'html'; // text or html
    //$config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'utf-8'; //iso-8859-1
    $config['newline'] = "\r\n";
    $config['validation'] = TRUE; // bool whether to validate email or not 
    $config['wordwrap'] = TRUE;
    
    
    $CI->email->initialize($config);
    $CI->email->from($from, 'wordofmouthreferral.com');
    $CI->email->to($to);
    if($bcc!=NULL)
        $CI->email->bcc($bcc);
    
    if($cc!=NULL)
        $CI->email->cc($cc);
    
    $CI->email->subject($subject);
    $CI->email->message($body);
	if($file_name != NULL)
	{
		foreach($file_name as $key=>$attachemnt)
                    $CI->email->attach($attachemnt);
	}
    return $CI->email->send();
} 



 
function _getPagingVaiables($tableName, $uri_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where=NULL) {
        //set base_url
      
       $CI =& get_instance();       
       $CI->load->database();
       $CI->load->model('mdgeneraldml');
       $CI->load->library('pagination');
   
        $config['base_url'] = base_url() . $base_url_address . $sort_by . '/' . $sort_type;
        $config['total_rows'] = $CI->mdgeneraldml->get_table_total_count($tableName);
        if ($where != NULL)
            $config['total_rows'] = $CI->mdgeneraldml->get_table_total_count($tableName, $where);

        if ($config['total_rows'] < $limit)
            $limit = $config['total_rows'];

        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $limit;
        $config['full_tag_open'] = '<ul class="pager">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';


        //initialize config setting
        $CI->pagination->initialize($config);
        # Pagination Ends Here -


        $data['offset'] = $offset + 1;
        $data['page_tab'] = 'image';
        $data['per_page'] = $config['per_page'];
        $data['limit'] = $limit + $offset;
        $data['totalrecords'] = $config['total_rows'];

        $data['base_url_address'] = $base_url_address;
        $data['sort_by'] = $sort_by;
        $data['sort_type'] = $sort_type;


        return $data;
    }

function _getPagingVaiablesByCount($totalRecords, $uri_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type){
        //set base_url
      
       $CI =& get_instance();       
       $CI->load->database();
       $CI->load->model('mdgeneraldml');
       $CI->load->library('pagination');
   
        $config['base_url'] = base_url() . $base_url_address . $sort_by . '/' . $sort_type;
        $config['total_rows'] = $totalRecords;
        

        if ($config['total_rows'] < $limit)
            $limit = $config['total_rows'];

        $config['uri_segment'] = $uri_segment;
        $config['per_page'] = $limit;
        $config['full_tag_open'] = '<ul class="pager">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="current">';
        $config['cur_tag_close'] = '</li>';


        //initialize config setting
        $CI->pagination->initialize($config);
        # Pagination Ends Here -


        $data['offset'] = $offset + 1;
        $data['page_tab'] = 'image';
        $data['per_page'] = $config['per_page'];
        $data['limit'] = $limit + $offset;
        $data['totalrecords'] = $config['total_rows'];

        $data['base_url_address'] = $base_url_address;
        $data['sort_by'] = $sort_by;
        $data['sort_type'] = $sort_type;


        return $data;
    }    
    
function _getStateList($countryCode=NULL)
{
    $obj =& get_instance();
    $obj->load->database();
    if($countryCode!=NULL)
        $sql="SELECT state_id,country_code,state_name FROM tbl_state WHERE country_code='".$countryCode."' ORDER BY state_name";
    else
        $sql="SELECT state_id,country_code,state_name FROM tbl_state ORDER BY state_name";
    
    $result=$obj->db->query($sql)->result_array();
    
    $list=array(''=>'Select');
    foreach($result as $key=>$val)
    {
        $list[$val['state_id']]=$val['state_name'];
    }
    return $list;
}

function _getStateListOnlyName($countryCode=NULL)
{
    $obj =& get_instance();
    $obj->load->database();
    if($countryCode!=NULL)
        $sql="SELECT state_id,country_code,state_name FROM tbl_state WHERE country_code='".$countryCode."' ORDER BY state_name";
    else
        $sql="SELECT state_id,country_code,state_name FROM tbl_state ORDER BY state_name";
    
    $result=$obj->db->query($sql)->result_array();
    
    $list=array(''=>'Select');
    foreach($result as $key=>$val)
    {
        $list[$val['state_name']]=$val['state_name'];
    }
    return $list;
}

function _getCountryList()
{
    $obj =& get_instance();
    $obj->load->database();
    $sql="SELECT country_id,country_code,country_name FROM tbl_country ORDER BY country_name";
    $result=$obj->db->query($sql)->result_array();
    
    $list=array(''=>'Select');
    foreach($result as $key=>$val)
    {
        $list[$val['country_code']]=$val['country_name'];
    }
    return $list;
}
//PRITAM
function _getCountry_name($id = '')
{
    $obj =& get_instance();
    $obj->load->database();
    $sql="SELECT country_name FROM tbl_country where country_code = '$id'";
    $result=$obj->db->query($sql)->result_array();
    
    /*$list=array(''=>'Select');
    foreach($result as $key=>$val)
    {
        $list[$val['country_code']]=$val['country_name'];
    }*/
	if(count($result)!=0)
		$list = $result[0]['country_name'];
	else
	    $list = "--";
    return $list;
}
function _getState_name($countryCode=NULL,$state_id='')
{
    $obj =& get_instance();
    $obj->load->database();
    if($countryCode!=NULL)
        $sql="SELECT state_id,country_code,state_name FROM tbl_state WHERE country_code='".$countryCode."' AND state_id = $state_id";
    else
        $sql="SELECT state_id,country_code,state_name FROM tbl_state where state_id = $state_id ";
    
    $result=$obj->db->query($sql)->result_array();
    if(count($result)!=0)
    	$list= $result[0]['state_name'];
    else
		$list = "--";
    return $list;
}
function _getCategoryList()
{
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT catId, catName FROM tbl_category WHERE catStatus = 'Active' ORDER BY catName";
    $result=$obj->db->query($sql)->result_array();
    
    $list=array(''=>'Select');
    foreach($result as $key=>$val)
    {
        $list[$val['catId']]=$val['catName'];
    }
    return $list;
}

function _getBusinessCategoryArray($businessId)
{
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT cat_id FROM tbl_business_categories WHERE buss_id=$businessId";
    $result=$obj->db->query($sql)->result_array();
    
    $list=array();
    foreach($result as $key=>$val)
    {
        $list[]=$val['cat_id'];
    }
    return $list;
}

function _getBusinessIdsByCategory($catId){
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT buss_id FROM tbl_business_categories WHERE cat_id=$catId";
    $result=$obj->db->query($sql)->result_array();
    
    $list=array();
    foreach($result as $key=>$val)
    {
        $list[]=$val['buss_id'];
    }
    return $list;
}

function _getBusinessCategoryNameString($businessId)
{
    $obj =& get_instance();
    $obj->load->database();
    
    $sql="SELECT c.catName
            FROM tbl_business_categories as bc             
            LEFT JOIN tbl_category as c ON c.catId=bc.cat_id            
            WHERE bc.buss_id=$businessId";        
        $result=$obj->db->query($sql)->result_array();
        
        $response=array();
        foreach($result as $key=>$val)
            $response[]=$val['catName'];
        
        return implode(', ', $response);
}

function _getMonths()
{
    return array('01'=>'01','02'=>'02','03'=>'03','04'=>'04','05'=>'05','06'=>'06','07'=>'07','08'=>'08','09'=>'09','10'=>'10','11'=>'11','12'=>'12');
}

function _getExpiryYears($numberOfYears=5)
{
    $curentYear=date('Y');
    $endCount=$curentYear+$numberOfYears;
    $year=array();
    
    for($i=$curentYear;$i<=$endCount;$i++)
        $year[$i]=$i;
    
    return $year;
}

function __myBusinessDropdown($userId='')
{
    $where="";
    if($userId!='')
    {
        //$where= " WHERE user_id=$userId";
        $where= " WHERE user_id=$userId and bussStatus='Active'";
    }   
    
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT buss_id,buss_name FROM tbl_business_info $where ORDER BY buss_name";
    $result=$obj->db->query($sql)->result_array();
    
    $list=array(''=>'Business Name');
    foreach($result as $key=>$val)
    {
        $list[$val['buss_id']]=$val['buss_name'];
    }
    return $list;
        
}

function __myJobTypesDropdown()
{
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT jobTypeId,jobType FROM tbl_job_types WHERE jobTypeStatus='Active' ORDER BY jobTypeId ASC";
    $result=$obj->db->query($sql)->result_array();
    
    $list=array(''=>'Job Type');
    foreach($result as $key=>$val)
    {
        $list[$val['jobTypeId']]=$val['jobType'];
    }
    return $list;
        
}

function __numOfUserBusiness($userId){
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT count(*) numRecords FROM tbl_business_info WHERE user_id=$userId";
    $result=$obj->db->query($sql)->result_array();
    return $result[0]['numRecords'];
}

function __mySubscriptionPlan($userId){
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT user_plan FROM tbl_user WHERE user_id=$userId";
    $result=$obj->db->query($sql)->result_array();
    return $result[0]['user_plan'];
}

function _getBusinessRating($userId,$bussId)
{
    $obj =& get_instance();
    $obj->load->database();
    $sql = "SELECT rat_stars FROM tbl_ratings WHERE user_id=$userId AND buss_id=$bussId";
    $result=$obj->db->query($sql)->result_array();
    if(!empty($result))
        return $result[0]['rat_stars'];
    else
        return 0;
}

function __authorisedPayment($cardInfo){
	$post_url = "https://secure.authorize.net/gateway/transact.dll";
	
    /*  Local Details
		$post_url = "https://test.authorize.net/gateway/transact.dll";           //15-04-14 Local
		"x_login"			=> "3ecHaM273S23"
		"x_tran_key"		=> "625369ddfZ4J5jZu"*/ //15-04-14 Local
	/*
		Live Detaisl
			$post_url = "https://secure.authorize.net/gateway/transact.dll";
			"x_login"			=> "23GSh2fV",
            "x_tran_key"		=> "32dS5L3ha5d925n2",
		
	*/		
	
	/*		local Working
            "x_login"			=> "74nQJ3jt",
            "x_tran_key"		=> "799v9H7K6Lb8PAwg",	
	
	*/

    $post_values = array(
            // the API Login ID and Transaction Key must be replaced with valid values
            "x_login"			=> "23GSh2fV",
            "x_tran_key"		=> "4YyVTP22wB254q6D",
            "x_version"			=> "3.1",
            "x_delim_data"		=> "TRUE",
            "x_delim_char"		=> "|",
            "x_relay_response"  => "FALSE",
            "x_type"			=> "AUTH_CAPTURE",
            "x_method"			=> "CC",
            "x_card_num"		=> $cardInfo['creditCardNumber'],
            "x_card_code"		=> $cardInfo['cvv2Number'],
            "x_exp_date"		=> $cardInfo['expDateMonth'].'/'.$cardInfo['expDateYear'],//"0115",

            "x_amount"			=> $cardInfo['amount'],//"19.99",
            "x_description"		=> "Business Registration Transaction",

            "x_first_name"		=> $cardInfo['firstName'],//"John",
            "x_last_name"		=> $cardInfo['lastName'],//"Doe",
            "x_address"			=> $cardInfo['address1'],//"1234 Street",
            "x_state"			=> $cardInfo['state'],//"WA",
            "x_zip"			=> $cardInfo['zip']//"98004"
            // Additional fields can be added here as outlined in the AIM integration
            // guide at: http://developer.authorize.net
    );
    
    // This section takes the input fields and converts them to the proper format
    // for an http post.  For example: "x_login=username&x_tran_key=a1B2c3D4"
    $post_string = "";
    foreach( $post_values as $key => $value )
            { $post_string .= "$key=" . urlencode( $value ) . "&"; }
    $post_string = rtrim( $post_string, "& " );
    
    // This sample code uses the CURL library for php to establish a connection,
    // submit the post, and record the response.
    // If you receive an error, you may want to ensure that you have the curl
    // library enabled in your php configuration
    $request = curl_init($post_url); // initiate curl object
            curl_setopt($request, CURLOPT_HEADER, 0); // set to 0 to eliminate header info from response
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); // Returns response data instead of TRUE(1)
            curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); // use HTTP POST to send form data
            curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); // uncomment this line if you get no gateway response.
            $post_response = curl_exec($request); // execute curl post and store results in $post_response
            // additional options may be required depending upon your server configuration
            // you can find documentation on curl options at http://www.php.net/curl_setopt
    curl_close ($request); // close curl object

    // This line takes the response and breaks it into an array using the specified delimiting character
    $response_array = explode($post_values["x_delim_char"],$post_response);
    
    $returnInfo = array('status' => '', 'successData' => '', 'transactionId' => '', 'errorData' => '');
    if($response_array[0]==1){
        $returnInfo['status'] = 'success';
        $returnInfo['transactionId'] = $response_array[6];        
        $returnInfo['successData'] = $response_array;        
    }else{
        $returnInfo['status'] = 'fail';
        $returnInfo['errorData'] = $response_array[3];    
        //echo '<pre>'; print_r($response_array);die;
    }

    return $returnInfo;
}

function _getMetadata($pageName){
    $metaArray=array(
		
        'home'=>array(
            'title'=>'Search businesses, reviews, download deals and look for jobs all on Word of Mouth Referral',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'aboutus'=>array(
            'title'=>'Advertising, reviews, deals & coupon offers and job services',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'how_it_works'=>array(
            'title'=>'Advertising packages, deals & coupons, and employment ads',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'services'=>array(
            'title'=>'Basic and Premium Packages at very low prices on Word of Mouth Referral',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'deals_and_coupons'=>array(
            'title'=>'Find Deals & Coupons on Word of Mouth Referral',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'we_are_hiring'=>array(
            'title'=>"Who's Hiring on Word of Mouth Referral?",
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'faq'=>array(
            'title'=>'Free Search, verified reviews, instant quote request on Word of Mouth Referral',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        ),
        'contact_us'=>array(
            'title'=>'Charleston, South Carolina, info@wordofmouthreferral.com, 843-327-0813',
            'description'=>'',
            'keywords'=>"business advertising, internet business advertising, business reviews, deals, coupons, we're hiring, jobs, employment, quotes, reviews, top deals, internet marketing advertising, daily deals, restaurant coupons, printable coupons"
        )
    );
    
    if(array_key_exists($pageName, $metaArray)){
        return $metaArray[$pageName];
    }
}
 
/* End of file commomn_functions_helper.php */
/* Location: ./application/helpers/commomn_functions_helper.php */    