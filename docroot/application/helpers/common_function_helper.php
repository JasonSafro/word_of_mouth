<?php

$ci = & get_instance();
$ci->load->model('mdgeneraldml');
 

   

//$ci->load->library('session');
//echo "common_function_helper.php loaded";
function sendEmail($fname, $email,$subject,$msg) {
    $ci = & get_instance();
    $config['mailtype'] = 'html';
    $ci->load->library('email', $config);
    $ci->load->library('email');
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '20';

    $config['smtp_user'] = 'gouravagaste@gmail.com';
    $config['smtp_pass'] = '9422266433lata';
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html'; // text or html
    $config['validation'] = TRUE; // bool whether to validate email or not

    $ci->email->initialize($config);
    

    $ci->email->from('sachin@abc.com');
    $ci->email->to($email);
    $ci->email->subject($subject);
    $ci->email->message($msg);
    $ci->email->send();
}
function _Get_bussiness_name($buss_id='')
{
	$ci = & get_instance();
	$ci->load->model('mdgeneraldml');
	$tbl_business_info = 'tbl_business_info';
    $where_bus_id = array('buss_id' => $buss_id);
    $bus_Info = $ci->mdgeneraldml->select('*', $tbl_business_info, $where_bus_id);
	
	return $bus_Info[0]['buss_name'];
	
}



?>