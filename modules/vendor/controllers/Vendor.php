<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Vendor extends MX_Controller
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
        $this->load->model('Vendor_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
       
    }

    /**
    * Functionality: Loads View vendors.php
    */
    public function index() {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $result = $this->db->select('*')->from('roles')->get();
        $data['roles'] = $result->result('array');  
        $this->template->title('Vendor');
        $this->template
                ->set_layout('inner')
                ->build('vendors', $data);
    }/* End  Function index */

    /**
    * Functionality: Add vendor
    */
    public function add() {
        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                
            // not logged in or not activated
            redirect('/auth/login/');

        }else{
            if( $this->input->post() ){
            $code = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '_', $this->input->post('name'))));
                $post_data = array(
                    'name'                   => $this->input->post('name'),
                    'code'                   => $code,
                    'addressline_one'        => $this->input->post('addressline_one'),
                    'addressline_two'        => $this->input->post('addressline_two'),
                    'city'                   => $this->input->post('city'),
                    'state'                  => $this->input->post('state'),
                    'zipcode'                => $this->input->post('zipcode'),
                    'office_phone'           => $this->input->post('office_phone'),
                    'ext'                    => $this->input->post('ext'),
                    'website'                => $this->input->post('website'),
                    'order_processor'        => $this->input->post('order_processor'),
                    'order_processor_email'  => $this->input->post('order_processor_email'),
                    'order_processor_phone'  => $this->input->post('order_processor_phone'),
                    'inside_sales_rep'       => $this->input->post('inside_sales_rep'),
                    'inside_sales_email'     => $this->input->post('inside_sales_email'),
                    'inside_sales_phone'     => $this->input->post('inside_sales_phone'),
                    'outside_sales_rep'      => $this->input->post('outside_sales_rep'),
                    'outside_sales_email'    => $this->input->post('outside_sales_email'),
                    'outside_sales_phone'    => $this->input->post('outside_sales_phone')
                );
                if( !$vendor_id = App::save_data( 'vendor', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Vendor didn\'t save, Try again!');
                    redirect('/vendor');
                }else{       
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Vendor Has Been  add successfully');
                    redirect('/vendor');
                }
            }

        }  
        $this->load->view('modal/add_vendor', $data);
    }/* End  Function Add */

    /**
    * Functionality: loads script load_script.php
    */
    public function load_script()  {
        $data = array();
        $this->load->view('load_script', $data);
    }/* End  Function load_script */

    /**
    * Functionality: loads css load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* End  Function load_css */

    /**
    * Functionality: Delete vendor
    */
    public function delete_vendor() {
        if( isset($_POST['ids']) ) {
            $ids = $_POST['ids'];
            $data['userDel'] = $this->user_model->Pkdelete_query($ids,'vendor');
            if($data == true){
                echo "TRUE";
            }else{
                echo "FALSE";
            }
        }
    }/* End  Function delete_vender */

    /**
    * Functionality: Edit vendor
    */
    public function edit($id) {
        if ( $this->input->post('vendor_id') ) {    
           $data['errors'] = array();
            $id = $this->input->post('vendor_id');
            $match = array( 'id' => $this->input->post('vendor_id'));
            $data = array(
                    'name'                   => $this->input->post('name'),
                    'addressline_one'        => $this->input->post('addressline_one'),
                    'addressline_two'        => $this->input->post('addressline_two'),
                    'city'                   => $this->input->post('city'),
                    'state'                  => $this->input->post('state'),
                    'zipcode'                => $this->input->post('zipcode'),
                    'office_phone'           => $this->input->post('office_phone'),
                    'ext'                    => $this->input->post('ext'),
                    'website'                => $this->input->post('website'),
                    'order_processor'        => $this->input->post('order_processor'),
                    'order_processor_email'  => $this->input->post('order_processor_email'),
                    'order_processor_phone'  => $this->input->post('order_processor_phone'),
                    'inside_sales_rep'       => $this->input->post('inside_sales_rep'),
                    'inside_sales_email'     => $this->input->post('inside_sales_email'),
                    'inside_sales_phone'     => $this->input->post('inside_sales_phone'),
                    'outside_sales_rep'      => $this->input->post('outside_sales_rep'),
                    'outside_sales_email'    => $this->input->post('outside_sales_email'),
                    'outside_sales_phone'    => $this->input->post('outside_sales_phone')
              );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Vendor has been update successfully '); 
            App::update('vendor',$match,$data);
            redirect('/vendor');
        }else{
            $data['vendor'] = (array) App::get_row_by_where('vendor', array('id'=>$id) );
            $this->load->view('modal/edit_vendor', $data);
            }
    }/* End  Function Edit */

    /**
    * Functionality: Retrieve Datatable Vendor Listing
    */
    public function getVendor() {
        $column = array(
                      0 => 'id',
                      1 => 'name',
                      2 => 'office_phone',
                      3 => 'website',
                      4 => 'order_processor',
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $column[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->Vendor_model->countdata('vendor');
        $totalFiltered = $totalData;
        $data = $row = array();
        if( empty( $this->input->post('search')['value'] ) ) {
            $vendorData = $this->Vendor_model->getRows($limit,$start,$order,$dir,'vendor');
        }else{
            $search = $_POST['search']['value'];
            $vendorData = $this->Vendor_model->data_search($limit,$start,$search,$order,$dir,'vendor', $column );
            $totalFiltered = $this->Vendor_model->data_search_count($search,'vendor', $column );
            }
        if (!empty($vendorData)) {
            $startvalue = $start;
                foreach($vendorData as $vendor){
                    $data[] = array(
                            $vendor->id,  
                            $vendor->name, 
                            $vendor->office_phone, 
                            $vendor->website, 
                            $vendor->order_processor, 
                            '<a href="'.base_url().'vendor/edit/'.$vendor->id.'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="custommodal1" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                            <a href="javascript:void(0);" id="deleteVendor" title="Delete" class="action-icon" ids="'. $vendor->id.'"> <i class="mdi mdi-delete"></i></a>'
                        );
                }
            }
        $output = array(
                    "draw" => $_POST['draw'],
                    "recordsTotal" => intval($totalData),
                    "recordsFiltered" => intval($totalFiltered),
                    "data" => $data,
                );
        
        echo json_encode($output);
    }/* End  Function get_vendor */

}

/* End of file Vendor.php */