<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class How_it_works extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model		
        $this->load->model('mdgeneraldml'); // This model is use to common quries defined into this model	
       
        $this->load->library('form_validation');
        $this->load->library('user_agent');
    }

    public function index() {
       
        $where = array('pageId' => '105');
        $info = $this->mdgeneraldml->select('*', 'tbl_static_pages', $where);        
        $data['info'] = $info[0];
        
        $where=array('hwId'=>1);
        $info2 = $this->mdgeneraldml->select('*','tbl_how_it_work_videos', $where);
        $info2=$info2[0];
        $data['video1']=$info2['hwVideo1'];
        $data['video2']=$info2['hwVideo2'];
         $data['is_mobile']="No";
        if($this->agent->is_mobile())
                $data['is_mobile']="Yes";
        
        //echo $data['info']['video2']; die;
        $this->load->view('includes/header');
        $this->load->view('how_it_works_view',$data);
        $this->load->view('includes/footer');
    }

   

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */