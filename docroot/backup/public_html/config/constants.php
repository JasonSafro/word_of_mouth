<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| All constants set by users for site title , site data css, js , others file
| Added by : Manoj Nemade
| Date: 15-May-2013
| Company : Avion Technology
|--------------------------------------------------------------------------
|
*/
 
 
 
//define('SITE_ROOT','http://server.ashoresystems.com/~wom/');
define('SITE_ROOT', rtrim($_SERVER['HTTP_HOST'] . "/" . $_SERVER['SCRIPT_NAME'], '/'));
define('ADMIN_SIDE_CSS',SITE_ROOT."assets/css/");
define('ADMIN_SIDE_COLOUR_CSS',SITE_ROOT.ADMIN_SIDE_CSS."colors/");
define('ADMIN_SIDE_JS',SITE_ROOT."assets/scripts/");
define('ADMIN_SIDE_IMAGES',SITE_ROOT."assets/images/");
define('ADMIN_FOLDER_NAME','admin');
define('ADMIN_PAGING_LIMIT','20');


/* Usersite constants */
define('SITE_ROOT_FOR_USER',"http://wordofmouthreferral.com/");
//define('SITE_ROOT_FOR_USER',"http://192 186 234 230/");
define('USER_SIDE_CSS', SITE_ROOT_FOR_USER . "sitedata/css/");
define('USER_SIDE_JS', SITE_ROOT_FOR_USER . "sitedata/js/");
define('USER_SIDE_IMAGES', SITE_ROOT_FOR_USER . "sitedata/images/");
define('USER_SIDE_FONTS', SITE_ROOT_FOR_USER . "sitedata/fonts/");
define('USER_CSV_FILES',SITE_ROOT_FOR_USER ."sitedata/CSV_Files/");

/*SMTP SETTING*/
define('PROTOCOL','smtp');
define('SMTP_HOST','ssl://smtp.gmail.com');
define('SMTP_PORT','465');
define('SMTP_TIMEOUT','20');
define('SMTP_USER_EMAIL','bhagwant.systemtest@gmail.com');
define('SMTP_PASSWORD','systemtest');
define('SMTP_USERNAME','WOM.com');
define('ADMIN_EMAIL','info@wordofmouthreferral.com');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */