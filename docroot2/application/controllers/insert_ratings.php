<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Insert_ratings extends CI_Controller {

    /**
     * Constructor
     */
    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model	
        $this->load->model('mdgeneraldml');
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }

/*    public function insert_bus_ratings()
    {
        //Check user is Logged or Not
        if (($this->session->userdata('user_id') == ""))
        {
            echo "user_not_logged_in";
        }
        else
        {
            //Get Ratings
            $user_ratings = $_GET['rating'];
            $bus_id = $_GET['busId'];
            $user_id = $this->session->userdata('user_id');

            //Store in DB
            $arr = array("user_id" => $user_id,
                "buss_id" => $bus_id,
                "rat_stars" => $user_ratings
            );



            //If already rated by user
            $tbl = "tbl_ratings";
            $where = array("user_id" => $user_id, "buss_id" => $bus_id);
            $db_det = $this->db_transact_model->get_single_record($tbl, $where);

            if (!empty($db_det))
            {//Update
                $data = $this->mdgeneraldml->update($where, 'tbl_ratings', $arr);
            }
            else
            {//Insert
                $data = $this->db->insert("tbl_ratings", $arr);
            }

            //Update Average Ratings
            $tbl_business_info = 'tbl_business_info';
            $where1 = array("buss_id" => $bus_id);
            $db_buss = $this->db_transact_model->get_single_record($tbl_business_info, $where1);

            //Get Total Ratings
            $tbl_ratings = 'tbl_ratings';
            $where2 = array("buss_id" => $bus_id);
            $total_ratings = $this->mdgeneraldml->select('rat_stars', 'tbl_ratings', $where2);
            //print_r($total_ratings);
            if (count($total_ratings) > 0)
            {
                $total_ratings_sum = 0;
                for ($i = 0; $i < count($total_ratings); $i++)
                {
                    // $total_ratings_sum=$total_ratings[$i]['rat_stars'];
                    $total_ratings_sum = $total_ratings_sum + $total_ratings[$i]['rat_stars'];
                }

                //Update business info
                $avg_ratings = round($total_ratings_sum/count($total_ratings));
                $avg_rating_db = array("buss_avg_ratings" => $avg_ratings);
                $where3 = array("buss_id" => $bus_id);
                $data = $this->mdgeneraldml->update($where3, 'tbl_business_info', $avg_rating_db);
            }
        }
    }*/

}

/* End of file home.php */
/* Location: ./application/controllers/dashboard/business_lists.php */