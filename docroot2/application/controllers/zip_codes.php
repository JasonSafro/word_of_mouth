<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');


class Zip_codes extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
        $this->load->library("geozip");
    }
    
    function index(){
       $zips = $this->geozip->get_zips_in_range('10001', 10, SORT_BY_ZIP_ASC, false);
       echo '<pre>'; print_r($zips);
    }
}    
    
?>
