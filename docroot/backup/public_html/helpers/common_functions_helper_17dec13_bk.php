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
        redirect('user/home');
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
    
    $config['protocol'] = PROTOCOL;
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
    $CI->email->message($body);
    

    /*$adminEmailInfo= $CI->mdgeneraldml->select('adm_email', 'tbl_admin_email', array('adm_eml_id'=>1));
    if(!empty($adminEmailInfo))
        $admin_email=$adminEmailInfo[0]['adm_email'];
    else
        $admin_email=ADMIN_EMAIL;
    
    $config['protocol'] = 'sendmail';
    $config['mailtype'] = 'html'; // text or html
    //$config['mailpath'] = '/usr/sbin/sendmail';
    $config['charset'] = 'utf-8'; //iso-8859-1
    $config['newline'] = "\r\n";
    $config['validation'] = TRUE; // bool whether to validate email or not 
    $config['wordwrap'] = TRUE;
    $CI->email->initialize($config);
    $CI->email->from($admin_email, 'Adsables.com');
    $CI->email->to($email_ids);
    $CI->email->subject($subject);
    $CI->email->message($body);*/
	if($file_name != NULL)
	{
		for($i=1; $i<= count($file_name); $i++)
		{
			$CI->email->attach($file_name[$i]);
		}
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
    $CI->email->from($from, 'DesignersDressMatch.com');
    $CI->email->to($to);
    if($bcc!=NULL)
        $CI->email->bcc($bcc);
    
    if($cc!=NULL)
        $CI->email->cc($cc);
    
    $CI->email->subject($subject);
    $CI->email->message($body);
	if($file_name != NULL)
	{
		for($i=1; $i<= count($file_name); $i++)
		{
			$CI->email->attach($file_name[$i]);
		}
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
        $where= " WHERE user_id=$userId";
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
    $sql = "SELECT jobTypeId,jobType FROM tbl_job_types WHERE jobTypeStatus='Active' ORDER BY jobType";
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

 
/* End of file commomn_functions_helper.php */
/* Location: ./application/helpers/commomn_functions_helper.php */    