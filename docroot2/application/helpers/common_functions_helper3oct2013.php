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
       
    if($CI->session->userdata('adsableUserId') != '' && $CI->session->userdata('adsableUserEmail'))
            return true;
    else
        redirect('home');
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

function checkUserSession()
 {
      $CI =& get_instance();       
       
       $CI->load->database();
       $CI->load->library('session');
       //echo '<pre>'; print_r($CI->session->userdata); exit;
       $userId=$CI->session->userdata('zappyUserId');
     if ($userId!= "") {
        //zappyLocalUserLoginKey

            $qry = "SELECT usr_last_log_ip,usr_last_login_key,usr_last_login_status FROM tbl_user WHERE usr_id=".$userId;
            $res = $CI->db->query($qry)->result_array();             
            if($res[0]['usr_last_login_key']!=$CI->session->userdata('zappyUserLoginKey'))
            {
                $CI->session->unset_userdata('zappyUserId');
                $CI->session->unset_userdata('zappyUserEmail');
                $CI->session->unset_userdata('zappyUserDisplayName');
                $CI->session->unset_userdata('zappyUserFirstName');                
                $CI->session->unset_userdata('zappyUserLoginKey');
                $CI->session->unset_userdata('zappyUserTimeZone');
		$CI->session->unset_userdata('currentAdLayout');
		$CI->session->unset_userdata('zappyUserPaidStatus');                
                redirect('home');
            } 
            elseif($res[0]['usr_last_login_status']!=1)
            {
                $CI->session->unset_userdata('zappyUserId');
                $CI->session->unset_userdata('zappyUserEmail');
                $CI->session->unset_userdata('zappyUserDisplayName');
                $CI->session->unset_userdata('zappyUserFirstName');                
                $CI->session->unset_userdata('zappyUserLoginKey');
                $CI->session->unset_userdata('zappyUserTimeZone');
		$CI->session->unset_userdata('currentAdLayout');
		$CI->session->unset_userdata('zappyUserPaidStatus');                
                redirect('home');
            }
            else
            {
                //update log that means user is still loged in
               $currentTime=date('Y-m-d H:i:s');
               $sql="UPDATE tbl_user_log SET current_active_time='".$currentTime."' WHERE log_id=(SELECT log_id FROM tbl_user_log WHERE log_user_id=".$userId." ORDER BY log_id DESC LIMIT 1)";
               $CI->db->query($sql);
               //echo $currentTime; die;
            }
         return true;
    }
    else
        redirect('home');
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
 
/* End of file commomn_functions_helper.php */
/* Location: ./application/helpers/commomn_functions_helper.php */    