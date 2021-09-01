<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class Category extends MX_Controller
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
        $this->load->model('Category_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
       
    }
    
    /**
    * Functionality: loads view categories.php
    */
    public function index() {   
        if (!$this->tank_auth->is_logged_in()) { // logged in
            redirect('auth/login');
        }
        $data = array();
        $nCatArr = array();
        $pCats = App::get_by_where('category', array('cat_parent'=>0) );
        if ( $pCats ) {
            foreach ($pCats as $pKey => $pValue) {
                $pCats = App::get_by_where('category', array('cat_parent'=>$pValue->id) );
                $nCatArr[$pValue->id]['parent'] = $pValue;
                $nCatArr[$pValue->id]['child']  = $pCats;
                if ( $pCats ) {
                    foreach ($pCats as $ckey => $cValue) {
                        $cCats = App::get_by_where( 'category', array( 'cat_parent'=> $cValue->id ) );
                        $nCatArr[$pValue->id]['subchild']  = $cCats;
                    }

                }
            }

        }
        $data['category'] = $nCatArr; 
        $this->template->title('Edit Lead');
                 $this->template
                ->set_layout('inner')->build('categories',$data);
 
    }/* function End idex */
    
    /**
    * Functionality: Add Category
    */
    public function add() {
        $data = array();
        if (!$this->tank_auth->is_logged_in()) {                                // not logged in or not activated
            redirect('/auth/login/');
        }else{
            if( $this->input->post() ){
                $post_data = array(
                            'cat_name'    => $this->input->post('cat_name'),
                            'cat_desc'    => $this->input->post('cat_desc'),
                            'cat_parent'  => $this->input->post('cat_parent')
                        );
                if( !$category_id = App::save_data( 'category', $post_data ) ) {
                    $this->session->set_flashdata('response_status', 'error');
                    $this->session->set_flashdata('message', 'Category didn\'t save, Try again!');
                    redirect('/category');
                }else{       
                    $this->session->set_flashdata('response_status', 'success');
                    $this->session->set_flashdata('message', 'Category added successfully');
                    redirect('/category');
                    }
            }
        }
        
        $nCatArr = array();
        $pCats = App::get_by_where('category', array('cat_parent'=>0) );
        if ( $pCats ) {
            foreach ($pCats as $pKey => $pValue) {
                $pCats = App::get_by_where('category', array('cat_parent'=>$pValue->id) );
                $nCatArr[$pValue->id]['parent'] = $pValue;
                $nCatArr[$pValue->id]['child']  = $pCats;
            }
        }
        $data['categories'] = $nCatArr;
        
       // $data['categories'] = (array) App::get_by_where('category', array('1' => 1 ));
        $this->load->view('modal/add_cat', $data);
    }/* function End add */

    /**
    * Functionality: Loads view/load_script.php
    */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* function End load_script */

    /**
    * Functionality: Load view/load_css.php
    */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* function End update */

    /**
    * Functionality: Delete Category
    */
    public function delete_category() {
        if( isset($_POST['ids']) ) {
            $ids = $_POST['ids'];
            $data['userDel'] = $this->user_model->Pkdelete_query($ids,'category');
            if($data == true){
                echo "TRUE";
            }else{
                echo "FALSE";
                }
        }
    }/* function End delete category */

    /**
    * Functionality: Edit Category
    */
    public function edit($id){
        if ( $this->input->post('cat_id') ) {    
            $data['errors'] = array();
            $id = $this->input->post('cat_id');
            $match = array ('id' => $this->input->post('cat_id'));
            $data = array(
                        'cat_name'  => $this->input->post('cat_name'),
                        'cat_desc'       => $this->input->post('cat_desc'),
                        'cat_parent'       => $this->input->post('cat_parent')
                  );
            $this->session->set_flashdata('response_status','success'); 
            $this->session->set_flashdata('message','Category has been updated'); 
            App::update('category',$match,$data);
            redirect('/category');
        }else{
            $nCatArr = array();
            $pCats = App::get_by_where('category', array( 'cat_parent' => 0, 'id != ' => $id ) );
            if ( $pCats ) {
                foreach ($pCats as $pKey => $pValue) {
                    $pCats = App::get_by_where('category', array( 'cat_parent' => $pValue->id, 'id != ' => $id ) );
                    $nCatArr[$pValue->id]['parent'] = $pValue;
                    $nCatArr[$pValue->id]['child']  = $pCats;
                }
            }
             $data['categories'] = $nCatArr;
            // $data['categories'] = (array) App::get_by_where('category', array('1' => 1 ));
             $data['category'] = (array) App::get_row_by_where('category', array('id'=>$id) );
             $this->load->view('modal/edit_cat', $data);

            }

     }/* function End edit */

    /**
    * Datatable Category Listing
    * Call From: load_script.php for view
    */
    public function getCategory() {
        $column = array(
                      0 => 'id',
                      1 => 'cat_name',
                      2 => 'cat_desc',
                      3 => 'cat_parent'
                    );
        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $column[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $totalData = $this->Category_model->countdata('category');
        $totalFiltered = $totalData;
        $data = $row = array();
        if( empty( $this->input->post('search')['value'] ) ){
            $categoryData = $this->Category_model->getRows($limit,$start,$order,$dir,'category');
        }else{
            $search = $_POST['search']['value'];
            $categoryData = $this->Category_model->data_search($limit,$start,$search,$order,$dir,'category',array('name') );
            $totalFiltered = $this->Category_model->data_search_count($search,'category');
        }
        if (!empty($categoryData)) {
                $startvalue = $start;
                foreach($categoryData as $category){
                    $startvalue++;
                    $data[] = array(
                        $startvalue,  
                        $category->cat_name, 
                        $category->cat_desc, 
                        $category->cat_parent, 
                        '<a href="'.base_url().'category/edit/'.$category->id.'" class="action-icon" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                        <a href="javascript:void(0);" id="deleteCategory" class="action-icon" ids="'. $category->id.'"> <i class="mdi mdi-delete"></i></a>'

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
     }/* function End getcategory */

    /**
    * Retrieve Category Data View
    */
    public function get_Category(){
        $result = $this->db->select('*')->from('category')->get();
        $data['category'] = $result->result('array'); 
        $this->template->title('Edit Lead');
        $this->template
              ->set_layout('inner')->build('categories',$data);
      }/* function End get_category */

}

/* End of file Category.php */