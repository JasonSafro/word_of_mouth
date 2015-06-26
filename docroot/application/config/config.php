<?php
  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  // Pick a config file based on the server
  switch( strtolower($_SERVER['SERVER_NAME']) ) :
    case 'dev.wom.local':
      require_once( dirname(__FILE__).'/config.jsafro.php' );
    break;

    case 'cooper.wom.local':
      require_once( dirname(__FILE__).'/config.jcooper.php' );
      break;

    default:
      require_once( dirname(__FILE__).'/config.default.php' );
    break;
  endswitch;

/* End of file config.php */
/* Location: ./application/config/config.php */
