<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Style extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->module('layouts');
        $this->load->library('template');
        $this->load->model('Style_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
       
    } 

    /**
    * Loads View styles.php
    */
    public function index() {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $result = $this->db->select('*')->from('roles')->get();
        $data['roles'] = $result->result('array');  
        $this->template->title('Style');
        $this->template
                ->set_layout('inner')
                ->build('styles', $data);
    }/* function End index */

    
    /**
    * Functionality: Add Style
    */
    public function add() {
        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');
        }else{
            if( $this->input->post() ){
                $post_data = array(
                    'style_name'    => $this->input->post('name'),
                    'style_desc'     => $this->input->post('description'),
                    'style_code'     => $this->input->post('code'),
                );
                if( !$style_id = App::save_data( 'style', $post_data ) ) {
                        $this->session->set_flashdata('response_status', 'error');
                        $this->session->set_flashdata('message', 'Style didn\'t save, Try again!');
                        redirect('/style');
                }else{       
                        $this->session->set_flashdata('response_status', 'success');
                        $this->session->set_flashdata('message', 'Style Has Been added successfully');
                        redirect('/style');
                    }
            }

        }  
        $this->load->view('modal/add_style', $data);
    }/* function End add */

    /**
    * Functionality: loads view/load_script.php
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* function End load_script */

    /**
    * Functionality: loads view/load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* function End load_css */
    
    /**
     * Functionality: Delete Style
     */
    public function delete_style(){
        if( isset($_POST['ids']) ){
            $ids = $_POST['ids'];
            if( App::delete('style', array('id' => $ids))){
                echo "TRUE";
            }else{
                echo "FALSE";
            }
        }
    }/* function End delete_style */

    /**
    * Functionality: Edit Style
    */
    public function edit( $id ) {
        if ( $this->input->post('style_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('style_id');
            $match = array (
                'id' => $this->input->post('style_id'),
            );
            $data = array(
                    'style_name'  => $this->input->post('name'),
                    'style_desc'       => $this->input->post('description'),
                    'style_code'     => $this->input->post('code')
              );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Style has been updated successfully'); 
            App::update('style',$match,$data);
            redirect('/style');
        }else{
            $data['style'] = (array) App::get_row_by_where('style', array('id'=>$id) );
            $this->load->view('modal/edit_style', $data);
            }

    }/* function End edit */

    /**
    * Functionality: Datatable style listing
    */
    public function getStyle() {
        $column = array(
                      0 => 'id',
                      1 => 'style_name',
                      2 => 'style_code',
                      3 => 'style_desc'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $column[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->Style_model->countdata('style');
        $totalFiltered = $totalData;
        $data = $row = array();
        if( empty( $this->input->post('search')['value'] ) ) {
            $styleData = $this->Style_model->getRows($limit,$start,$order,$dir,'style');
        }else{
            $search = $_POST['search']['value'];
            $styleData = $this->Style_model->data_search($limit,$start,$search,$order,$dir,'style',$column );
            $totalFiltered = $this->Style_model->data_search_count($search,'style', $column);
        }
        if (!empty($styleData)) {
            $startvalue = $start;
            foreach($styleData as $style){
                $data[] = array(
                        $style->id,  
                        $style->style_name, 
                        $style->style_code, 
                        $style->style_desc, 
                        '<a href="'.base_url().'style/edit/'.$style->id.'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="custommodalEdit" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" id="deleteStyle" title="Delete" class="action-icon" ids="'. $style->id.'"> <i class="mdi mdi-delete"></i></a>'

                    );
            }
        }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data
                );
        
        echo json_encode($output);
     }/* function End getstyle */

}

/* End of file Style.php */