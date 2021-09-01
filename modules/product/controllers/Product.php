<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';
require_once APPPATH . 'third_party/PHPExcel/spout-2.4.3/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Product extends MX_Controller
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
        $this->load->model('product_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
        redirect('auth/login');
        }
       
    }

    /**
    *Functionality: Loads View product.php
    */
    public function index()
    {   

    	// category Replace in wc_product table  
       /* $category = $this->db->select('*')->from('asfg_category')->get()->result();
        foreach($category as $key => $arr){
            $cat_name = $arr->cat_name;
            $id = $arr->id;
            if ( !empty($cat_name) ) {
	            $pros = $this->product_model->findWhere('asfg_product',array('category' => $cat_name),array("id"));
	            foreach($pros as $key => $prod){
	                $producrt_data = array('category'=> $id);
	                $this->product_model->updateWhere('asfg_product',array('id' => $prod['id']),$producrt_data);
	                // echo $this->db->last_query();
	            }
        	}
        }*/
        
        // Style Replace in wc_product table
       /* $styles = $this->db->select('*')->from('21century_style')->get()->result();
        foreach($styles as $key => $arr){
            $style_code = $arr->style_name;
            $id = $arr->id;
            $id = $arr->id;
            if ( !empty($style_code) ) {
	            $pros = $this->product_model->findWhere('21century_product',array('style_id' => $style_code),array("id"));
	            foreach($pros as $key => $prod){
	                $producrt_data = array('style_id'=>$id);
	                $this->product_model->updateWhere('21century_product',array('id' => $prod['id']),$producrt_data);
	                // echo $this->db->last_query();
	            }
        	}
        }*/



        $data = array();
        $this->load->view('auth/index', $data);
        $this->template->title('Product');
        $this->template
            ->set_layout('inner')
            ->build('product', $data);
    }

    public function add() {
        if (!$this->tank_auth->is_logged_in()) {                // not logged in or not activated
          redirect('/auth/login/');
        }else{
            $data = array();
            $data['category'] = $this->product_model->findWhere('category',array('cat_parent' => '0'),array("*"));
            $data['style'] = $this->product_model->fetch_all('style');
            $data['vendor'] = $this->product_model->fetch_all('vendor');
            if( $this->input->post() ) {
                if ( !empty($this->input->post('subCatogeryFirst') ) ) {
                  $subFirst  =  $this->input->post('subCatogeryFirst');
                } else {
                  $subFirst = '';
                }
                if ( !empty( $this->input->post('subCatogerysecond') ) ) {
                  $subsecond  =  $this->input->post('subCatogerysecond');
                } else {
                  $subsecond = '';
                }
                $producrt_data = array(
                                'Item_Name'           => $this->input->post('Item_Name'),
                                'Item_Code'           => $this->input->post('Item_Code'),
                                'vendor_id'           => $this->input->post('vendor'),
                                'style_id'            => $this->input->post('styleAcode'),
                                'category'            => $this->input->post('cat_name'),
                                'Item_description'    =>  $this->input->post('Item_description'),
                                'Cabinet_price'       =>  $this->input->post('Cabinet_price'),
                                'Assembly'            =>  $this->input->post('Assembly'),
                                'Assembly_Cost'       =>  $this->input->post('Assembly_Cost'),
                                'Width'               =>  $this->input->post('Width'),
                                'Height'              =>  $this->input->post('Height'),
                                'Depth'               => $this->input->post('Depth'),
                                'sub_category_first'  => $subFirst,
                                'sub_category_second' => $subsecond
                        );
                if( !$product_id = App::save_data( 'pk_product', $producrt_data ) ) {
                        $this->session->set_flashdata('response_status', 'error');
                        $this->session->set_flashdata('message', 'Product didn\'t save, Try again!');
                        redirect('/product');
                }else{   
                        $this->session->set_flashdata('response_status', 'success');
                        $this->session->set_flashdata('message', 'Product added successfully');
                        redirect('/product');
                        }
              }

          } 
        
        $this->load->view('modal/add', $data);
    }/* End function add */

    /**
     *Functionality: loads load_script.php
     */
    public function load_script() {
        $data = array();
        $this->load->view('load_script', $data);
    }/* End function load_script */

    /**
     *Functionality: loads load_css.php
     */
    public function load_css() {
        $data = array();
        $this->load->view('load_css', $data);
    }/* End function load_css */

    /**
     *Functionality: 
     */
    public function appendcat() {
      if( isset( $_POST['catId'] ) && !empty( $_POST['catId'] ) ) {
          $data = $this->product_model
                       ->findWhere('category',array('cat_parent' => $_POST['catId']),true,array('*'));
          if (!empty( $data ) && $data == true ) {
            foreach ($data as $key => $value) {
                    $catData[$value['id']] = array("id" => $value['id'],'cat_name' => $value['cat_name'] );
            }
                echo json_encode($catData);
            }else {
              echo "false";  
                }
            }else{
          echo "false";
      }

    }/* End function appndcat */

    /**
    *Functionality: Delete Product
    */
    public function deleteProduct() {
        if ( isset($_POST['ids'] ) ) {
              $data = $this->product_model->deleteWhere('pk_product',array('id' => $_POST['ids'] ) );
              if( $data == true ){
                echo "TRUE";
              } else {
                echo "FALSE";
              }
        }
    }/* End function deleteProduct */

    /**
    *Functionality: Edit Product
    */
    public function edit() {
        $id =  $this->uri->segment(3);
        $subcat = $this->uri->segment(4); 
        $data['productData'] = $this->db->select('pk_product.*,pk_product.id as ID,vendor.name as vendor_name,category.*,style.style_name')
                 ->from('pk_product')
                 ->join('vendor','pk_product.vendor_id = vendor.id')
                 ->join( 'category', 'pk_product.category = category.id' ) 
                 ->join('style', 'pk_product.style_id = style.id ')
                 ->where('pk_product.id',$id)
                 ->get()->row();
        $data['category'] = $this->product_model->findWhere('category',array('cat_parent' => '0'),array("*"));
        $data['style'] = $this->product_model->fetch_all('style');
        $data['vendor'] = $this->product_model->fetch_all('vendor');
        if ( !empty( $subcat ) ) {
            $data['subcatfirst'] = $this->product_model->findWhere('category',array('cat_parent' => $subcat),array("*"));
        }
        if( $this->input->post() ){
            if ( !empty($this->input->post('subCatogeryFirst') ) ) {
                $subFirst  =  $this->input->post('subCatogeryFirst');
            } else {
                $subFirst = '';
            }
            if ( !empty( $this->input->post('subCatogerysecond') ) ) {
                $subsecond  =  $this->input->post('subCatogerysecond');
            } else {
                $subsecond = '';
            }
            $producrt_data = array(
                            'Item_Name'           => $this->input->post('Item_Name'),
                            'Item_Code'           => $this->input->post('Item_Code'),
                            'vendor_id'           => $this->input->post('vendor'),
                            'style_id'            => $this->input->post('styleAcode'),
                            'category'            => $this->input->post('cat_name'),
                            'Item_description'    =>  $this->input->post('Item_description'),
                            'Cabinet_price'       =>  $this->input->post('Cabinet_price'),
                            'Assembly'            =>  $this->input->post('Assembly'),
                            'Assembly_Cost'       =>  $this->input->post('Assembly_Cost'),
                            'Width'               =>  $this->input->post('Width'),
                            'Height'              =>  $this->input->post('Height'),
                            'Depth'               => $this->input->post('Depth'),
                            'sub_category_first'  => $subFirst,
                            'sub_category_second' => $subsecond
                        );

            if( !$product_id = $this->product_model->updateWhere('pk_product',array('id' => $id),$producrt_data) ) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', 'Product didn\'t save, Try again!');
            }else{   
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', 'Product Updated successfully');
            }
            redirect('/product');
        }

      $this->load->view('modal/edit',$data);
      
    }/* End function edit */

    /**
    *Functionality: Import Products
    */
    public function ImportMeta() {
        $data = array();
        if(  isset($_POST['submit'] ) ) {
            $config = array(
                'upload_path' => "assets/productFile",
                'allowed_types' => "xlsx|xls|csv"
            );
            $this->load->library('upload', $config);
          
            if(!$this->upload->do_upload('file_upload')){
                  $error['error'] = array('error' => $this->upload->display_errors());
            }else{
                $uploaddata = array('upload' => $this->upload->data() );
                $exttrim = ltrim($uploaddata['upload']['file_ext'],".");
                switch ( $exttrim ) {
                  case 'xlsx':
                    $reader = ReaderFactory::create(Type::XLSX);                
                    break;
                  case 'xls':
                    $reader = ReaderFactory::create(Type::XLS);                
                    break;
                  case 'csv':
                    $reader = ReaderFactory::create(Type::CSV);                
                    break;
                }
                $reader->open($uploaddata['upload']['full_path']);
                $count = 1;
                foreach ($reader->getSheetIterator() as $sheet) {             
                    foreach ($sheet->getRowIterator() as $row) { 
                            if ($count > 1) {
                            if( !empty( $row[16] ) ){ $Width =  $row[16];  }else{ $Width  = ""; }
                            if( !empty( $row[17] ) ){ $Height =  $row[17];  }else{ $Height  = ""; }
                            if( !empty( $row[18] ) ){ $Depth =  $row[18];  }else{ $Depth  = ""; }
                            $data = array(
                                'parent_id' 					=> $row['7'],
                                'Item_Name' 					=> $row['6'],
                                'Item_Code' 					=> $row['6'],
                                'style_id'						=> $row['1'],
                                'vendor_id' 					=> 1,
                                'category'						=> $row['2'],
                                'is_sub_item_only' 				=> $row['3'],
                                'sub_category_first' 			=> $row['4'],
                                'sub_category_second' 			=> $row['5'],
                                'user_code_variants' 			=> $row['8'],
                                'Item_description' 				=> $row['9'],
                                'item_descriptionII' 			=> $row['9'],
                                'Cabinet_price' 				=> 'NULL',
                                'Assembly' 						=> 'NULL',
                                'cabinet_assembly_price' 		=> $row['15'],
                                'item_cost' 					=> $row['13'],
                                'Assembly_Cost' 				=> $row['14'],
                                'unassembled_retail_item_price' => $row['10'],
                                'assembly_retail_price' 		=> $row['11'],
                                'assembled_retail_item_price'   => $row['12'],
                                'Width'               			=> $Width,
                                'Height'              			=> $Height,
                                'Depth'               			=> $Depth
                            );
                        if( !$data['product_data'] = $this->product_model->insert_data('pk_product',$data)){
                            $this->session->set_flashdata('response_status', 'error');
                            $this->session->set_flashdata('message', 'File not import in database, Try again!');
                        }else{
                            $this->session->set_flashdata('response_status', 'success');
                            $this->session->set_flashdata('message', 'File import successfully');

                            }

                        }
                        $count++;
                    }
                }
                redirect("/product");
                $reader->close();
            }

        }
        $this->load->view('modal/import',$data);
    }/* End function import */
  
    
    /**
    *Functionality: Meta Import
    */
    public function Import() {
        $data = array();
        if(  isset($_POST['submit'] ) ) {
            $config = array(
                'upload_path' => "assets/productFile",
                'allowed_types' => "xlsx|xls|csv"
            );
            $this->load->library('upload', $config);
          
            if(!$this->upload->do_upload('file_upload')){
                  $error['error'] = array('error' => $this->upload->display_errors());
            }else{
                $uploaddata = array('upload' => $this->upload->data() );
                $exttrim = ltrim($uploaddata['upload']['file_ext'],".");
                switch ( $exttrim ) {
                  case 'xlsx':
                    $reader = ReaderFactory::create(Type::XLSX);                
                    break;
                  case 'xls':
                    $reader = ReaderFactory::create(Type::XLS);                
                    break;
                  case 'csv':
                    $reader = ReaderFactory::create(Type::CSV);                
                    break;
                }
                $reader->open($uploaddata['upload']['full_path']);
                $count = 1;
                foreach ($reader->getSheetIterator() as $sheet) {             
                    foreach ($sheet->getRowIterator() as $row) {
                            //pr( $row );die;
                        if ($count > 1 ) {

                        	/*$numlength = strlen((string)$row['2']);

                            if ( $numlength == '1' ) {
                            	$style_count = '00'.$row[2];
                            }elseif ( $numlength == '2' ) {
                            	$style_count =  '0'.$row[2];
                            }else{
                            	$style_count = $row[2];
                            }*/


                            // Import Style    
                            /*$data = array(
                              'style_name'         => $row[0],
                              'style_code'         => $row[1],
                              'vendor_id'          => '8'
                            );
        
                            $this->db->where('style_code', $row[1]);
                            $num_rows = $this->db->count_all_results('21century_style');
                            if($num_rows == 0) {
                                $this->product_model->insert_data('21century_style',$data);
                            }*/
                            
                            // Import Categories
                            /*$data = array(
                              'cat_name'  => $row[1],
                              'cat_parent' => '0'
                            );
        
                            $this->db->where('cat_name', $row[1]);
                            $num_rows = $this->db->count_all_results('asfg_category');
                            if($num_rows == 0) {
                                $this->product_model->insert_data('asfg_category',$data);
                            }*/

                            // Categories Relation
                            /*$chData  = $this->db->select('*')->from('category')->where('cat_name', $row[4])->get()->row();
                            $thisCat = $chData->id;
                            
                            $prntData = $this->db->select('*')->from('category')->where('cat_name', $row[2])->get()->row();
                            $pCat  = $prntData->id;*/
                            
                            /*$this->db->set('cat_parent', $pCat);
                            $this->db->where('id', $thisCat);
                            $this->db->update('category');*/

                            // // Import Prodcts
                            

	                        $data = array(

    /*  'style_id' => $row[0],
      'category' => $row[1],
      'item_code' => $row[3],
      'description' => $row[4],
      'cost' => $row[5],
      'price' => $row[6],*/
                                
                            );

                           //$this->product_model->insert_data('asfg_product',$data);

                        }
                        $count++;
                    }
                }
                redirect("/product");
                $reader->close();
            }

        }
        $this->load->view('modal/import',$data);
    }/* End function import */
    
    /**
    *Functionality: Datatable Get Products
    *Call From: call from load_script.php
    */
    public function getProducts() {
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
    
        $columns = array(
                    0 => 'id',
                    1 => 'Item_Code',   
                    2 => 'style_id',  
                    3 => 'vendor_id',    
                    4 => 'category',  
                    5 => 'sub_category_first',    
                    6 => 'sub_category_second',    
                    7 => 'Item_description',    
                    8 => 'Cabinet_price',    
                    9 => 'Assembly',    
                    10 => 'Assembly_Cost',    
                    11 => 'Width',    
                    12 => 'Height',    
                    13 => 'Depth'    
            );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "SELECT p.id, p.Item_Code, p.style_id, p.vendor_id, p.category, p.sub_category_first, p.sub_category_second, p.Item_description, p.Cabinet_price, p.Assembly, p.Assembly_Cost, p.Width, p.Height, p.Depth";
        $sql.=" FROM pk_product p WHERE 1= 1";
        $totalData = $this->product_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
        if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $sql.=" AND ( p.id LIKE '".$requestData['search']['value']."%' ";    
             // $sql.=" OR p.Item_Code LIKE '%".$requestData['search']['value']."%' ";    
             // $sql.=" OR p.style_id LIKE '%".$requestData['search']['value']."%' ";    
              $sql.=" OR p.Item_Code LIKE '".$requestData['search']['value']."%' )";
        }
        $totalFiltered = $this->product_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */    
        $total_record = $this->product_model->custom_query($sql,false,'array'); 
        /*echo json_encode($total_record);die();*/
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) ) {
            foreach ($total_record as $row) {
                /*action button conditions*/                        
                $vendor = $this->product_model->findWhere( $table = 'vendor', $where_data = array('id' => $row['vendor_id']), $multi_record = false, $select = array() );
                $category = $this->product_model->findWhere( $table = 'category', $where_data = array('id' => $row['category']), $multi_record = false, $select = array() );
                $sub_category_first = $this->product_model->findWhere( $table = 'category', $where_data = array('id' => $row['sub_category_first']), $multi_record = false, $select = array() );
                if(!empty($sub_category_first['cat_name'])){ $subcategory = $sub_category_first['cat_name']; }else{ $subcategory = "NA"; }
                if(!empty($sub_category_second['cat_name'])){ $subchildcategory = $sub_category_second['cat_name']; }else{ $subchildcategory = "NA"; }
                    $sub_category_second = $this->product_model->findWhere( $table = 'category', $where_data = array('id' => $row['sub_category_second']), $multi_record = false, $select = array() );
                    $html =  '<a href="'.base_url().'product/edit/'.$row['id'].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="custommodal1" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $html .=   '<a href="javascript:void(0);" title="Delete" id="deleteProduct" class="action-icon" ids="'.$row['id'].'"> <i class="mdi mdi-delete"></i></a>';
                    $data[] = array(
                          $row["id"],  
                          $row["Item_Code"],
                          $row['style_id'],
                          $vendor['name'],
                          $category['cat_name'],
                          $subcategory,
                          $subchildcategory,
                          $row['Item_description'],
                          $row['Cabinet_price'],
                          $row['Assembly'],
                          $row['Assembly_Cost'],
                          $row['Width'],
                          $row['Height'],
                          $row['Depth'],
                          $html
                    );
                }
            }
            $json_data = array(
                          "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw. 
                          "recordsTotal"    => intval( $totalData ),  // total number of records
                          "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
                          "data"            => $data   // total data array
                    );

            echo json_encode($json_data);  // send data as json format
      
   }

    public function new_product(){     

        $data = array();
        $this->template->title('New Product');
        $this->template
            ->set_layout('inner')
            ->build('new_product', $data);
    }

    public function get_new_products(){
       
        ini_set('max_execution_time', 30000000);
        ini_set('memory_limit','2048M');
        $requestData= $_REQUEST;
    
        $columns = array(
                    0 => 'id',
                    1 => 'item_Code',   
                    2 => 'style_id',  
                    3 => 'description',
                    4 => 'price'
            );
        $vendor_id = $this->session->userdata('vendor_id');
        $sql = "SELECT p.*";
        $sql.=" FROM product_order p WHERE product_id = 0";
        $totalData = $this->product_model->custom_query($sql,true,'array');
        $totalFiltered = $totalData;
        if( !empty($requestData['search']['value']) ) {   
            $sql.=" AND ( p.id LIKE '".$requestData['search']['value']."%' ";    
           
              $sql.=" OR p.item_Code LIKE '".$requestData['search']['value']."%' )";
        }
        $totalFiltered = $this->product_model->custom_query($sql,true,'array'); 
        $sql.=" ORDER BY ". $columns[$requestData['order'][0]['column']]."   ".$requestData['order'][0]['dir']."  LIMIT ".$requestData['start']." ,".$requestData['length']."   ";
        $total_record = $this->product_model->custom_query($sql,false,'array'); 
        $data = array();
        if( is_array( $total_record ) && !empty( $total_record ) ) {
            foreach ($total_record as $row) {
                    $html =  '<a href="'.base_url().'product/edit_new_product/'.$row['id'].'" title="Edit" class="action-icon" data-animation="fadein" data-plugin="custommodal1" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $data[] = array(
                          $row["id"],  
                          $row["Item_code"],
                          $row['style_id'],
                          $row['description'],
                          $row['price'],
                          $html
                    );
                }
            }
            $json_data = array(
                          "draw"            => intval( $requestData['draw'] ), 
                          "recordsTotal"    => intval( $totalData ),
                          "recordsFiltered" => intval( $totalFiltered ),
                          "data"            => $data
                    );

            echo json_encode($json_data);
    }

    public function edit_new_product(){
        $id = $this->uri->segment(3);
        $data['productData'] = $this->db->select('product_order.*')
                 ->from('product_order')
                 ->where('product_order.id',$id)
                 ->get()->row();
        $data['category'] = $this->product_model->findWhere('category',array('cat_parent' => '0'),array("*"));
        $data['style'] = $this->product_model->fetch_all('style');
        $data['vendor'] = $this->product_model->fetch_all('vendor');
        if ( !empty( $subcat ) ) {
            $data['subcatfirst'] = $this->product_model->findWhere('category',array('cat_parent' => $subcat),array("*"));
        }
        if( $this->input->post() ){
            if ( !empty($this->input->post('subCatogeryFirst') ) ) {
                $subFirst  =  $this->input->post('subCatogeryFirst');
            } else {
                $subFirst = '';
            }
            if ( !empty( $this->input->post('subCatogerysecond') ) ) {
                $subsecond  =  $this->input->post('subCatogerysecond');
            } else {
                $subsecond = '';
            }

            $CAprice = floatval($this->input->post('Cabinet_price')) + floatval($this->input->post('Assembly'));  

            $product_data = array(
                            'Item_Code'                 => $this->input->post('Item_Code'),
                            'vendor_id'                 => $this->input->post('vendor'),
                            'style_id'                  => $this->input->post('styleAcode'),
                            'category'                  => $this->input->post('cat_name'),
                            'Item_description'          =>  $this->input->post('Item_description'),
                            'Cabinet_price'             =>  $this->input->post('Cabinet_price'),
                            'Assembly'                  =>  $this->input->post('Assembly'),
                            'cabinet_assembly_price'    =>  $CAprice,
                            'Width'                     =>  $this->input->post('Width'),
                            'Height'                    =>  $this->input->post('Height'),
                            'Depth'                     => $this->input->post('Depth'),
                            'sub_category_first'        => $subFirst,
                            'sub_category_second'       => $subsecond
                        );

            if( !$product_id = $this->product_model->add('pk_product',$product_data) ) {
                $this->session->set_flashdata('response_status', 'error');
                $this->session->set_flashdata('message', 'Product didn\'t save, Try again!');
            }else{   

                $this->product_model->updateWhere('product_order',array('id' => $id),array('product_id' => $product_id));
                $this->session->set_flashdata('response_status', 'success');
                $this->session->set_flashdata('message', 'Product Move successfully');
            }
            redirect('/product/new_product');
        }

        $this->load->view('modal/edit_new',$data);

    }

}

/* End of file Product.php */