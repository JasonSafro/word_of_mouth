<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_testimonials extends CI_Controller {

    /**
     * Constructor
     */
    function __construct() {
        parent::__construct();
        _authenticateAdmin();
        $this->load->model('admin_model');
        $this->load->model('mdgeneraldml');
        $this->load->library('pagination');
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<span class="error">', '</span>');
        $this->load->library('upload');
    }

    function index($sort_by='tmlId', $sort_type='ASC', $offset=0) {
        # Pagination Starts Here -
        $base_url_address = ADMIN_FOLDER_NAME . '/manage_testimonials/index/';

        //get and set pagination config variables
        $url_segment = 6;
        $limit = ADMIN_PAGING_LIMIT;
        $where = array('tmlStatus !=' => 'Deleted');
        $data = _getPagingVaiables('tbl_testimonials', $url_segment, $base_url_address, $limit, $offset, $sort_by, $sort_type, $where);
        $order_by = array('colname' => $sort_by, 'type' => $sort_type);
        $data['listTestimonial'] = $this->mdgeneraldml->select('*', 'tbl_testimonials', $where, $order_by, $limit, $offset);


        $this->load->view('admin/includes/header.php');
        $this->load->view('admin/testimonials_vw', $data);
        $this->load->view('admin/includes/footer.php');
    }

    function add_new($sort_by='tmlId', $sort_type='DESC', $offset=0) {
        $data = array('action' => 'New', 'tmlId' => '', 'tmlPersonName' => '', 'tmlDesignation' => '','tmlDescription'=>'', 'tmlImage' => '', 'error'=>'','btnName' => 'Save');

        $this->form_validation->set_rules('tmlPersonName', 'Person Name', 'trim|xss_clean|required|max_lenght[60]');
        $this->form_validation->set_rules('tmlDesignation', 'Designation', 'trim|xss_clean|required|max_lenght[100]');
        $this->form_validation->set_rules('tmlDescription', 'Description', 'trim|xss_clean|max_lenght[300]');

        $data['offset'] = $offset;
        $data['sort_by'] = $sort_by;
        $data['sort_type'] = $sort_type;
            
        if ($this->form_validation->run() == FALSE) {
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/testimonial_add_edit_vw');
            $this->load->view('admin/includes/footer');
        } else {
            $cat_id = $this->input->post('tmlPersonName');
            //mkdir('category_images/' . $cat_id, 0777, true);



            $config['upload_path'] = './sitedata/testimonials_images/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
            $config['max_size'] = '1000';
            $config['max_width'] = '350';
            $config['max_height'] = '100';
            $config['file_name'] = $this->input->post('tmlImage');
            $config['overwrite'] = TRUE;
            $config['quality'] = 100;
            $this->load->library('upload');
            $this->upload->initialize($config);
            //$data = array('upload_data' => $this->upload->data());


            if (!$this->upload->do_upload('tmlImage')) {
                //$error = array('error' => $this->upload->display_errors());
                $data['error']=$this->upload->display_errors();
                $this->load->view('admin/includes/header', $data);
                $this->load->view('admin/testimonial_add_edit_vw');
                $this->load->view('admin/includes/footer');
            } else {
                $data = array('upload_data' => $this->upload->data());
                $insertData = array(
                'tmlPersonName' => str_replace('"', " ", $this->input->post('tmlPersonName')),
                'tmlDesignation' => str_replace('"', " ", $this->input->post('tmlDesignation')),
                'tmlDescription' => $this->input->post('tmlDescription'),
                'tmlImage' => $data['upload_data']['file_name'],
                'tmlCreatedOn' => _getDateAndTime(),
                'tmlCreatedOn' => _getDateAndTime()
            );
            $this->mdgeneraldml->insert('tbl_testimonials', $insertData);


            $this->session->set_flashdata('success', 'New testimonial has been created successfully');
            redirect(ADMIN_FOLDER_NAME . '/manage_testimonials/add_new/' . $sort_by . '/' . $sort_type . '/' . $offset);
            }
            
        }
    }

    /*
      function do_upload($fieldName,$newImageName,$pathToStore,$soursePath,$tumbToStorePath,$forcedWidth=160,$forcedHeight=160){

      $userId=$this->session->userdata('adsableUserId');

      $config=array();
      $config['upload_path'] = $pathToStore;
      $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
      //$config['allowed_types'] = '*';
      $config['max_size'] = '2048';
      $config['file_name'] = $newImageName;
      $config['overwrite'] = TRUE;
      $config['quality'] = 100;
      $this->load->library('upload');
      $this->upload->initialize($config);
      //
      if (!$this->upload->do_upload($fieldName)) {
      $error = array('error' => $this->upload->display_errors());
      return $error;
      } else {
      $data = array('upload_data' => $this->upload->data());

      $listingImageName=$data['upload_data']['file_name'];



      $config['image_library'] = 'gd2';
      $config['source_image'] = $soursePath.''. $listingImageName;
      $config['new_image'] = $tumbToStorePath.'' . $listingImageName;
      $config['create_thumb'] = FALSE;
      $config['maintain_ratio'] = FALSE;
      $config['overwrite'] = TRUE;

      $sourceImage = $data['upload_data']['full_path'];
      $sourceSize = getimagesize($sourceImage);

      $config['width'] = $forcedWidth; //$finalWidth;
      $config['height'] = $forcedHeight; //$finalHeight;

      $this->load->library('image_lib');
      $this->image_lib->initialize($config);
      $this->image_lib->display_errors('<p>', '</p>');
      if (!$this->image_lib->resize()) {
      //echo 'resize error:';
      return array('error' => $this->image_lib->display_errors());
      } else {
      return array('resized_imageName' => $data['upload_data']['file_name']);
      }
      }
      }
     */

    function edit($tmlId=NULL, $sort_by='tmlId', $sort_type='DESC', $offset=0) {

        if (($tmlId == NULL) or (!$this->admin_model->isRecordExist('tbl_testimonials', array('tmlId' => $tmlId)))) {
            $this->session->set_flashdata('error', 'The record your are looking is not exist!!');
            redirect(ADMIN_FOLDER_NAME . '/manage_testimonials');
        }

        $sql = "SELECT * FROM tbl_testimonials WHERE tmlId=$tmlId";
        $conInfo = $this->admin_model->sqlQuery($sql);
        $data = array('action' => 'Edit', 'tmlId' => $conInfo[0]['tmlId'], 'tmlPersonName' => $conInfo[0]['tmlPersonName'],'tmlDescription'=>$conInfo[0]['tmlDescription'] ,'tmlImage' => $conInfo[0]['tmlImage'], 'tmlDesignation' => $conInfo[0]['tmlDesignation'], 'error'=>'','btnName' => 'Save Changes');

        $this->form_validation->set_rules('tmlPersonName', 'Person Name', 'trim|xss_clean|required|max_lenght[60]');
        $this->form_validation->set_rules('tmlDesignation', 'Designation', 'trim|xss_clean|required|max_lenght[100]');
        $this->form_validation->set_rules('tmlDescription', 'Description', 'trim|xss_clean|max_lenght[300]');
        
        $data['offset'] = $offset;
        $data['sort_by'] = $sort_by;
        $data['sort_type'] = $sort_type;
            
        if ($this->form_validation->run() == FALSE) {            
            $this->load->view('admin/includes/header', $data);
            $this->load->view('admin/testimonial_add_edit_vw');
            $this->load->view('admin/includes/footer');
        } else {
            //prepare data for update category
            $updateData = array(
                'tmlPersonName' => str_replace('"', " ", $this->input->post('tmlPersonName')),
                'tmlDesignation' => $this->input->post('tmlDesignation'),
                'tmlDescription' => $this->input->post('tmlDescription'),
                'tmlCreatedOn' => _getDateAndTime()
            );
            
            $flag=true;
            
           
            //upload file
            $newFileName=date('YmdHms').'jpg';
            if($_FILES['tmlImage']['name']!=""){
                $config['upload_path'] = './sitedata/testimonials_images/';
                $config['allowed_types'] = 'gif|jpg|png|jpeg|GIF|JPG|PNG|JPEG';
                $config['max_size'] = '1000';
                $config['max_width'] = '350';
                $config['max_height'] = '100';
                $config['file_name'] = $newFileName;//$this->input->post('tmlImage');
                $config['overwrite'] = TRUE;
                $config['quality'] = 100;
                $this->load->library('upload');
                $this->upload->initialize($config);
                //$data = array('upload_data' => $this->upload->data());

                $data1 = array();
                if (!$this->upload->do_upload('tmlImage')) {
                    $flag=false;
                    //$error = array('error' => $this->upload->display_errors());
                    $data['error']=$this->upload->display_errors();
                    $this->load->view('admin/includes/header', $data);
                    $this->load->view('admin/testimonial_add_edit_vw');
                    $this->load->view('admin/includes/footer');
                } else {
                    $data1 = array('upload_data' => $this->upload->data());
                    $updateData['tmlImage']=$data1['upload_data']['file_name'];
                }
            }//end of $_FILE
            
            if($flag==true)
            {
                $tableName = 'tbl_testimonials';
                $where = array('tmlId' => $tmlId);

                $this->mdgeneraldml->update($where, $tableName, $updateData);
                $this->session->set_flashdata('success', 'Testimonial has been updated.');
                redirect(ADMIN_FOLDER_NAME . '/manage_testimonials/edit/' . $tmlId . '/' . $sort_by . '/' . $sort_type . '/' . $offset);
            }
        }//end of else
    }//end of function

    function delete($tmlId=NULL, $sort_by='tmlId', $sort_type='DESC', $offset=0) {
        if (($tmlId != NULL) && ($this->admin_model->isRecordExist('tbl_testimonials', array('tmlId' => $tmlId)))) {
            $tableName = 'tbl_testimonials';
            $where = array('tmlId' => $tmlId);
            $updateData = array(                
                'tmlStatus' => 'Deleted',
                'tmlCreatedOn' => _getDateAndTime(),
            );

            $this->mdgeneraldml->update($where, $tableName, $updateData);
            $this->session->set_flashdata('success', 'Testimonial has been deleted successfully.');

            redirect(ADMIN_FOLDER_NAME . '/manage_testimonials/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', '!! testimonial not exist.!!');
            redirect(ADMIN_FOLDER_NAME . '/manage_testimonials');
        }
    }

    function delete_selected($sort_by='tmlId', $sort_type='DESC', $offset=0) {
        if (!empty($_POST['chkmsg'])) {
            $tmlIds = implode(',', $_POST['chkmsg']);
            $this->admin_model->sqlUpdate("Update tbl_testimonials SET tmlStatus='Deleted',tmlCreatedOn='" . _getDateAndTime() . "' WHERE tmlId in($tmlIds)");
            $this->session->set_flashdata('success', 'Testimonial has been Deleted successfully.');
            redirect(ADMIN_FOLDER_NAME . '/manage_testimonials/index/' . $sort_by . '/' . $sort_type . '/' . $offset);
        } else {
            $this->session->set_flashdata('error', 'Select atleast single testimonial to delete the record.');
            redirect(ADMIN_FOLDER_NAME . '/manage_testimonials');
        }
    }

}

/* End of file home.php */
/* Location: ./application/controllers/admin/home.php */