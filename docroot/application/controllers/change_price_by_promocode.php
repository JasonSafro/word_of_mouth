<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Change_price_by_promocode extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->model('db_transact_model'); // This model is use to common quries defined into this model	     
        $this->load->model('website_general_model','WGM'); 
        $this->load->library('session');     //  This Library is use to When session get created.	
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
    }
    
        //Cheack Promocode Basic Form
   function check_promocode()
    {
        if ($this->input->post('plan_type') == 'bm')
        {
            $plan_type = 2;
            $r=$this->WGM->sqlQuery('SELECT subs_sub_plan_price FROM tbl_subscription_sub_plans WHERE subs_sub_plan_id=2');
            $original_price=$r[0]['subs_sub_plan_price'];
        }
        else
        {
            $plan_type = 1;
            $r=$this->WGM->sqlQuery('SELECT subs_sub_plan_price FROM tbl_subscription_sub_plans WHERE subs_sub_plan_id=1');
            $original_price=$r[0]['subs_sub_plan_price'];
        }  
        //echo $original_price;
        //$original_price = $this->input->post('plan_price');
        $tbl = "tbl_promo_codes";
        $cnd = "pc_code = '" . $this->input->post('pro_code') . "' and pc_plan_type_id =$plan_type";        
        $db_pro_code = $this->db_transact_model->get_single_record($tbl, $cnd);        
        if (!empty($db_pro_code))
        {
            if ($db_pro_code[0]['pc_status'] == 'A')
            {  $discount = $db_pro_code[0]['pc_discount'];
                $basic_total_cost = $original_price - $discount;
                
               // $data['basic_total_cost'] = $basic_total_cost;
                echo "active,".number_format($basic_total_cost,2,'.','');                
            }
            else
            {
                echo "inactive";
            }
        }
        else
        {
            echo "invalid";
        }
    }
    
            //Cheack Promocode Premium Form
   function check_promocode_p()
    {
        if ($this->input->post('plan_type') == 'pm')
        {
            $plan_type = 4;
            $r=$this->WGM->sqlQuery('SELECT subs_sub_plan_price FROM tbl_subscription_sub_plans WHERE subs_sub_plan_id=4');
            $original_price=$r[0]['subs_sub_plan_price'];
        }
        else
        {
            $plan_type = 3;
            $r=$this->WGM->sqlQuery('SELECT subs_sub_plan_price FROM tbl_subscription_sub_plans WHERE subs_sub_plan_id=3');
            $original_price=$r[0]['subs_sub_plan_price'];
        }    
        //$original_price = $this->input->post('plan_price');
        $tbl = "tbl_promo_codes";
        $cnd = "pc_code = '" . $this->input->post('pro_code') . "' and pc_plan_type_id =$plan_type";       
        $db_pro_code = $this->db_transact_model->get_single_record($tbl, $cnd);
        //echo $this->db->last_query();
        if (!empty($db_pro_code))
        {
            if ($db_pro_code[0]['pc_status'] == 'A')
            {  $discount = $db_pro_code[0]['pc_discount'];
                $premium_total_cost = $original_price - $discount;
                
               // $data['basic_total_cost'] = $basic_total_cost;
                echo "active,".number_format($premium_total_cost,2,'.','');                
            }
            else
            {
                echo "inactive";
            }
        }
        else
        {
            echo "invalid";
        }
    }

}