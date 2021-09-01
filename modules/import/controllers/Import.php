<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH . 'third_party/PHPExcel/spout-2.4.3/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class Import extends MX_Controller
{
    public $grouping;
    public $vendor_id;

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
        $this->load->model('Import_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) redirect('auth/login');  

        $this->grouping = uniqid();
        $this->vendor_id = $this->session->userdata('vendor_id');
    }

    public function index()
    {   
        $data = array();
        $this->load->view('auth/index', $data);
        $this->template->title('Product');
        $this->template
            ->set_layout('inner')
            ->build('import', $data);
    }

    /**
    *Functionality: Import Msi
    */
    public function ImportMsi() {
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
                            if( $row[16]  != ''){ $Height =  $row[16];  }else{ $Height = ""; }
                            if( $row[15]  != ''){ $Size   =  $row[15];  }else{ $Size   = ""; }
                            if( $row[17]  != ''){ $Width  =  $row[17];  }else{ $Width  = ""; }
                            if ($row[4] == ''){   
                                logDbError( 'msi_import', "Error - ".$this->grouping , 'Item_Code Empty - '.$row );
                                continue;
                            }

                            // echo $count++." - ".$row[4]."<br>"; continue;
                            $style_id  = $this->getNameId( 'msiTile_style','style_code', $row[0],$row[0] );
                            $sub1_name = $this->getNameId( 'msiTile_category','cat_name',$row[1] );
                            $sub2_name = $this->getNameId( 'msiTile_category','cat_name',$row[2] );
                            $sub3_name = $this->getNameId( 'msiTile_category','cat_name',$row[3] );

                            $data = array(
                                'style_id'          => $style_id,
                                'vendor_id'         => $this->vendor_id,
                                'sub_1_category'    => $sub1_name,
                                'sub_2_category'    => $sub2_name,
                                'sub_3_category'    => $sub3_name,
                                'item_code'         => $row[4],
                                'item_description'  => $row[5],
                                'cost_uom'          => $row[6],
                                'cost_each'         => $row[7],
                                'cost_sf'           => $row[8],
                                'cost_per_box'      => $row[9],
                                'price_uom'         => $row[10],
                                'price_each'        => $row[11],
                                'price_sf'          => $row[12],
                                'price_per_box'     => $row[13],
                                'finish'            => $row[14],
                                'size'              => $Size,
                                'height'            => $Height,
                                'width'             => $Width,
                                'thickness'         => $row[18],
                                'pieces_per_box'    => $row[19],
                                'sqft_per_piece'    => $row[20],
                                'total_pieces_sq_ft'=> $row[21],
                                'sqft_per_box'      => $row[22],
                                'u_m'               => $row[23],
                                'calculation_type'  => $row[24],
                                'item_id'           => $row[44],
                                'link'              => $row[45],
                                'product_line'      => $row[46],
                                'material'          => $row[47],
                                'description'       => $row[5],
                                'status'            => $row[50],
                                'source'            => $row[51]
                            );  

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('msiTile_product',array('style_id' => $style_id,'item_code' => $row[4] ));

                            // echo "<br><br>".$count." -- ".$this->db->last_query().'  <->  '.$findProduct;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'msiTile_product', array('style_id' => $style_id,'item_code' => $row[4] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{
                                if( $this->Import_model->insert_data('msiTile_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            // echo "<br>".$count." -- ".$this->db->last_query();

                            // $afterInsert = $this->findProductExist('msiTile_product',array('style_id' => $style_id,'item_code' => $row[4] ));
                            // echo "<br>".$count." -- ".$this->db->last_query().'  <->  '.$afterInsert."--------";
                            // $count++; continue;

                            logDbError( 'msi_import', $resQ.' - '.$row[4]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */

    /**
    *Functionality: Import Msi
    */
    public function ImportTsg() {
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
                        //pr($row);die;
                        if ($count > 1) {
                            // pr($row,1);
                            if( $row[16]  != ''){ $Width  =  $row[16];  }else{ $Width  = ""; }
                            if( $row[17]  != ''){ $Height =  $row[17];  }else{ $Height = ""; }
                            if( $row[18]  != ''){ $Depth  =  $row[18];  }else{ $Depth  = ""; }
                            if ($row[6] == ''){   
                                logDbError( 'tsg_import', "Error - ".$this->grouping , 'Item_Code Empty - '.$row['9'] );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                            $style_id  = $this->getNameId( 'style','style_code',$row[1],$row[0]);
                            $cat_name  = $this->getNameId( 'category','cat_name',$row[2]);
                            $sub1_name = $this->getNameId( 'category','cat_name',$row[4] );
                            $sub2_name = $this->getNameId( 'category','cat_name',$row[5] );

                            $data = array(
                                'Item_Name'         => $row[6],
                                'Item_Code'         => $row[6],
                                'style_id'          => $style_id,
                                'vendor_id'         => $this->vendor_id,
                                'parent_id'         => $row[7],
                                'category'          => $cat_name,
                                'is_sub_item_only'  => $row[3],
                                'sub_category_first'   => $sub1_name,
                                'sub_category_second'  => $sub2_name,
                                'user_code_variants'   => $row[8],
                                'Item_description'       => $row[9],
                                'cabinet_assembly_price'        => $row[15],
                                'assembled_retail_item_price'   => $row[12],
                                'item_cost'              => $row[13],
                                'unassembled_retail_item_price' => $row[10],
                                'Cabinet_price'          => $row[15],
                                'Assembly'               => $row[14],
                                'Assembly_Cost'          => $row[14],
                                'assembly_retail_price'  => $row[11],
                                'Width'             => $Width,
                                'Height'            => $Height,
                                'Depth'             => $Depth,
                                'user_id'           => $this->session->userdata('user_id')
                            );

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('pk_product',array('style_id' => $style_id,'Item_Code' => $row[6] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'pk_product', array('style_id' => $style_id,'item_code' => $row[6] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('pk_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }

                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('pk_product',array('style_id' => $style_id,'Item_Code' => $row[6] ));
                            // echo "<br>".$count."<->".$afterInsert."--------";
                            // $count++; continue;

                            logDbError( 'tsg_import', $resQ.' - '.$row[6]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */



    public function ImportJk() {
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
                        // pr($row,1);
                        if ($count > 1) {
                            //pr($row,1);
                            if( $row[18]  != ''){ $Width  =  $row[18];  }else{ $Width  = ""; }
                            if( $row[19]  != ''){ $Height =  $row[19];  }else{ $Height = ""; }
                            if( $row[20]  != ''){ $Depth  =  $row[20];  }else{ $Depth  = ""; }
                            if ($row[7] == ''){   
                                logDbError( 'jk_import', "Error - ".$this->grouping , 'Item_Code Empty - '.$row[10] );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                            							 /* tableName,columnName,columnValue,styleName */
                            $style_id  = $this->getNameId( 'jk_style','style_code',$row[1],$row[0]);
                            $cat_name  = $this->getNameId( 'jk_category','cat_name',$row[3]);
                            $sub1_name = $this->getNameId( 'jk_category','cat_name',$row[4] );
                            $sub2_name = $this->getNameId( 'jk_category','cat_name',$row[5] );
                            $sub3_name = $this->getNameId( 'jk_category','cat_name',$row[6] );

                            $data = array(
							'style_id'              =>    $style_id,
							'vendor_id'             =>    $this->vendor_id,
						    'is_sub_item'           =>    $row[2],   
						    'category'              =>    $cat_name,   
						    'sub_1_category'        =>    $sub1_name,   
						    'sub_2_category'        =>    $sub2_name,   
						    'sub_3_category'        =>    $sub3_name,
						    'item_code'             =>    $row[7],   
						    'parent'                =>    $row[8],   
						    'variants'              =>    $row[9],   
						    'Item_description'      =>    $row[10],  

						    'assembly_price'        =>    $row[12],  
						    'item_cost'             =>    $row[14],  
						    'assembly_cost'         =>    $row[15],  

						    'item_cost_unassembled_with_tariff' => $row[15],
						    'unassembled_item_cost' =>    $row[11],  
						    
                            'item_assembly_cost'    =>    $row[17],  
						    'assembled_item_cost'   =>    $row[13],  

						    'width'                 =>    $Width,  
						    'height'                =>    $Height,  
						    'depth'                 =>    $Depth,  
                            'user_id'               => $this->session->userdata('user_id'),
                            );

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('jk_product',array('style_id' => $style_id,'item_code' => $row[7] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'jk_product', array('style_id' => $style_id,'item_code' => $row[7] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('jk_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }

                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('jk_product',array('style_id' => $style_id,'item_code' => $row[7] ));
                            // echo "<br>".$count."<->".$afterInsert."--------";
                            // $count++; continue;
                            logDbError( 'jk_import', $resQ.' - '.$row[7]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */


    public function ImportCnc() {
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

                            if( $row[16]  != ''){ $Width  =  $row[16];  }else{ $Width  = ""; }
                            if( $row[17]  != ''){ $Height =  $row[17];  }else{ $Height = ""; }
                            if( $row[18]  != ''){ $Depth  =  $row[18];  }else{ $Depth  = ""; }
                            if ($row[6] == ''){   
                                logDbError( 'cnc_import',"Error - ".$this->grouping , 'Item_Code Empty - '.json_encode($row) );
                                continue;
                            }
                            // echo $count++." - ".$row[4]."<br>"; continue;
                            $style_id  = $this->getNameId( 'cnc_style','style_code',$row[1],$row[0]);
                            $cat_name  = $this->getNameId( 'cnc_category','cat_name',$row[3]);
                            $sub1_name = $this->getNameId( 'cnc_category','cat_name',$row[4] );
                            $sub2_name = $this->getNameId( 'cnc_category','cat_name',$row[5] );

                            $data = array(
                                
                                    'style_id'                        =>  $row[1],
                                    'vendor_id'                       =>  $this->vendor_id,
                                    'is_sub_item'                     =>  $row[2],
                                    'category'                        =>  $row[3],
                                    'sub_1_category'                  =>  $row[4],
                                    'sub_2_category'                  =>  $row[5],
                                    'item_code'                       =>  $row[6],
                                    'parent'                          =>  $row[7],
                                    'variants'                        =>  $row[8],
                                    'item_description'                =>  $row[9],
                                    'unassembled_item_cost'           => $row[10],
                                    'assembled_item_cost'             => $row[11],
                                    'item_cost_assembled'             => $row[12],
                                    'item_cost_assembled_tariff'      => $row[13],
                                    'item_cost_unassembled'           => $row[14],
                                    'item_cost_unassembled_tariff'    => $row[15],
                                    'width'                           => $row[16],
                                    'height'                          => $row[17],
                                    'depth'                           => $row[18],
                                    'user_id'                         => $this->session->userdata('user_id')
                            );

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('cnc_product',array('style_id' => $style_id,'item_code' => $row[6] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'cnc_product', array('style_id' => $style_id,'item_code' => $row[6] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('cnc_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('cnc_product',array('style_id' => $style_id,'item_code' => $row[6] ));
                            // echo "<br>".$count."<->".$afterInsert."--------";
                            // $count++; continue;

                            logDbError( 'cnc_import', $resQ.' - '.$row[6]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */



    public function ImportWc() {
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
                            // pr($row);
                        if ($count > 1) {
                            // pr($row,1);
                            if( $row[18]  != ''){ $Width  =  $row[18];  }else{ $Width  = ""; }
                            if( $row[19]  != ''){ $Height =  $row[19];  }else{ $Height = ""; }
                            if( $row[20]  != ''){ $Depth  =  $row[20];  }else{ $Depth  = ""; }
                            if ($row[8] == ''){   
                                logDbError( 'wc_import',"Error - ".$this->grouping , 'Item_Code Empty - '.json_encode($row) );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                            $style_id  = $this->getNameId( 'wc_style','style_code',$row[1],$row[0]);
                            $cat_name  = $this->getNameId( 'wc_category','cat_name',$row[4]);
                            $sub1_name = $this->getNameId( 'wc_category','cat_name',$row[5] );
                            $sub2_name = $this->getNameId( 'wc_category','cat_name',$row[6] );
                            $sub3_name = $this->getNameId( 'wc_category','cat_name',$row[7] );

                            $data = array(
							    'style_id'                           =>    $style_id,
							    'vendor_id'							 =>    $this->vendor_id,
							    'is_sub_item_only'                   =>    $row[2],
							    'category'                           =>    $cat_name,
							    'sub_1_category'                     =>    $sub1_name,
							    'sub_2_category'                     =>    $sub2_name,
							    'sub_3_category'                     =>    $sub3_name,
							    'item_code'                          =>    $row[8],
							    'parent'                             =>    $row[9],
							    'variants'                           =>    $row[10],
							    'item_description'                   =>    $row[11],
							    'unassembled_item_price'             =>    $row[12],
							    'assembled_item_price'               =>    $row[13],
							    'item_cost_assembled'                =>    $row[14],
							    'item_cost_assembled_with_tariff'    =>    $row[15],
							    'item_cost_unassembled'              =>    $row[16],
							    'item_cost_unassembled_with_tariff'  =>    $row[17],
							    'bar_codeinformation'                =>    $row[21],
							    'material'                           =>    $row[22],
							    'width'                 			 =>    $Width,  
							    'height'                			 =>    $Height,  
							    'depth'                 			 =>    $Depth,  
	                            'user_id'               			 =>    $this->session->userdata('user_id'),
                            );

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('wc_product',array('style_id' => $style_id,'item_code' => $row[8] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct;
                            if ( $findProduct >= 1 ) {
                                if($this->Import_model->updateWhere( 'wc_product', array('style_id' => $style_id,'item_code' => $row[8] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('wc_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('wc_product',array('style_id' => $style_id,'item_code' => $row[8] ));
                            // echo "<br>".$count.' -- '.$this->db->last_query()."<->".$afterInsert."--------";
                            logDbError( 'wc_import', $resQ.' - '.$row[8]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */


    public function ImportTKnobs() {
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
                        //pr($row);die;
                        if ($count > 1) {
                            //pr($row,1);
                            if( $row[14]  != ''){ $Width  =  $row[14];  }else{ $Width  = ""; }
                            if ($row[6] == ''){   
                                logDbError( 'tknobs_import',"Error - ".$this->grouping , 'Item_Code Empty - '.json_encode($row) );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                            							 /* tableName,columnName,columnValue,styleName */
                            $style_id  = $this->getNameId( 'tknobs_style','style_code',$row[0],$row[1]);
                            $cat_name  = $this->getNameId( 'tknobs_category','cat_name',$row[3]);
                            $sub1_name = $this->getNameId( 'tknobs_category','cat_name',$row[4] );
                            $sub2_name = $this->getNameId( 'tknobs_category','cat_name',$row[5] );

                            $data = array(
							    'style_id'         =>    $style_id, 
							    'vendor_id'         =>    $this->vendor_id, 
							    'is_sub_item'       =>    $row[2], 
							    'category'          =>    $cat_name, 
							    'sub_1_category'    =>    $sub1_name, 
							    'sub_2_category'    =>    $sub2_name, 
							    'item_code'         =>    $row[6], 
							    'parent'            =>    $row[7], 
							    'variants'          =>    $row[8], 
							    'item_description'  =>    $row[9], 
							    'retail_price'      =>    $row[10],
							    'cant_find'         =>    $row[11],
							    'item_cost'         =>    $row[12],
							    'length'            =>    $row[13],
							    'width'             =>    $row[14],
							    'projection'        =>    $row[15],
							    'center_to_center'  =>    $row[16],
							    'base_diameter'     =>    $row[17],
							    'image_file_name'   =>    $row[18],
							    'width'             =>    $Width,
	                            'user_id'           =>    $this->session->userdata('user_id'),
                            );

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('tknobs_product',array('style_id' => $style_id,'item_code' => $row[6] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'tknobs_product', array('style_id' => $style_id,'item_code' => $row[6] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('tknobs_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            logDbError( 'tknobs_import', $resQ.' - '.$row[6]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */


    public function ImportAsfg() {
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
                        //pr($row);die;
                        if ($count > 1) {
                            //pr($row,1);
                            
                            if ($row[3] == ''){   
                                logDbError( 'asfg_import', "Error - ".$this->grouping , 'Item_Code Empty - '.json_encode($row) );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                            							 /* tableName,columnName,columnValue,styleName */
                            $style_id  = $this->getNameId( 'asfg_style','style_code',$row[0],$row[0]);
                            $cat_name  = $this->getNameId( 'asfg_category','cat_name',$row[1]);
                            

                            $data = array(
							    'style_id'            =>    $style_id,
							    'vendor_id'		      =>    $this->vendor_id,
							    'category'            =>    $cat_name,
							  	'item_code'           =>  	$row[3],
							    'item_description'    =>    $row[4],
							    'cost'                =>    $row[5],
							    'cust_price'          =>    $row[6],
                            );

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('asfg_product',array('style_id' => $style_id,'item_code' => $row[3] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'asfg_product', array('style_id' => $style_id,'item_code' => $row[3] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('asfg_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('asfg_product',array('style_id' => $style_id,'item_code' => $row[3] ));
                            // echo "<br>".$count."<->".$afterInsert."--------";
                            // $count++; continue;

                            logDbError( 'asfg_import', $resQ.' - '.$row[3]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */


    public function ImportCentury() {
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
                            // echo $count++." - ".$row[7].'<br>'; continue;

                            if( $row[17]  != ''){ $Width  =  $row[17];  }else{ $Width  = ""; }
                            if( $row[18]  != ''){ $Height =  $row[18];  }else{ $Depth  = ""; }
                            if( $row[19]  != ''){ $Depth  =  $row[19];  }else{ $Depth  = ""; }
                            if ($row[7] == ''){   
                                logDbError( '21century_import',"Error - ".$this->grouping , 'Item_Code Empty - '.json_encode($row) );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                            							
                            $style_id  = $this->getNameId( '21century_style','style_code',$row[1],$row[0]);
                            $cat_name  = $this->getNameId( '21century_category','cat_name',$row[3]);
                            $sub1_name = $this->getNameId( '21century_category','cat_name',$row[4] );
                            $sub2_name = $this->getNameId( '21century_category','cat_name',$row[5] );
                            $sub3_name = $this->getNameId( '21century_category','cat_name',$row[6] );

                            $data = array(
							    'style_id'               =>    $style_id, 
							    'vendor_id'              =>    $this->vendor_id, 
								'is_sub_item_only'       =>    $row[2], 
								'category'               =>    $cat_name, 
								'sub_1_category'         =>    $sub1_name, 
								'sub_2_category'         =>    $sub2_name, 
								'sub_3_category'         =>    $sub3_name, 
								'item_code'              =>    $row[7], 
								'parent'                 =>    $row[8], 
								'variant'                =>    $row[9], 
								'item_description'       =>    $row[10],
								'unassembled_item_price' =>    $row[11],
								'assembly_price'         =>    $row[12],
								'assembled_item_price'   =>    $row[13],
								'unassembled_item_cost'  =>    $row[14],
								'assembly_cost'          =>    $row[15],
								'item_assembly_cost'     =>    $row[16],
								'width'                  =>    $row[17],
								'height'                 =>    $row[18],
								'depth'                  =>    $row[19],
	                            'user_id'                =>    $this->session->userdata('user_id'),
                            );

                            // pr($data);$count++; continue;

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('21century_product',array('style_id' => $style_id,'item_code' => $row[7] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( '21century_product', array('style_id' => $style_id,'item_code' => $row[7] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('21century_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('21century_product',array('style_id' => $style_id,'item_code' => $row[3] ));
                            // echo "<br>".$count."<->".$afterInsert."--------";
                            // $count++; continue;

                            logDbError( '21century_import', $resQ.' - '.$row[7]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                redirect("/import");
                $reader->close();
            }

        }
        redirect('/import');
    }/* End function import */

    public function ImportAAY() {
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
                        // pr($row);
                        if ($count > 1) {
                            // pr($row,1);
                            // echo $count++." - ".$row[7].'<br>'; continue;

                            if( $row[15]  != ''){ $Width  =  $row[15];  }else{ $Width  = ""; }
                            if( $row[16]  != ''){ $Height =  $row[16];  }else{ $Height  = ""; }
                            if ($row[5] == ''){   
                                logDbError('aay_import',"Error - ".$this->grouping , 'Item_Code Empty - '.json_encode($row) );
                                continue;
                            }
                            // echo $count++."<br>"; continue;
                                                        
                            $style_id  = $this->getNameId( 'fab_style','style_code',$row[1],$row[0]);
                            $cat_name  = $this->getNameId( 'fab_category','cat_name',$row[2]);
                            $sub1_name = $this->getNameId( 'fab_category','cat_name',$row[3] );
                            $sub2_name = $this->getNameId( 'fab_category','cat_name',$row[4] );

                            $data = array(
                                'item_code'          =>    $row[5], 
                                'style_id'           =>    $style_id, 
                                'vendor_id'          =>    $this->vendor_id, 
                                'item_description'   =>    $row[6], 
                                'category'           =>    $cat_name, 
                                'sub_1_category'     =>    $sub1_name, 
                                'sub_2_category'     =>    $sub2_name, 
                                'item_cost'          =>    $row[7], 
                                'slab_cost'          =>    $row[10], 
                                'fabrication_cost'   =>    $row[8], 
                                'total_cost'         =>    $row[9], 
                                'apx_slab_sq_ft'     =>    $row[11],
                                'slab_width'         =>    $row[12],
                                'slab_height'        =>    $row[13],
                                'customer_price'     =>    $row[14],
                                'width'              =>    $Width,
                                'height'             =>    $Height,
                                'user_id'            =>    $this->session->userdata('user_id'),
                            );

                            // pr($data);$count++; continue;

                            $findProduct = 0;
                            $findProduct = $this->findProductExist('fab_product',array('style_id' => $style_id,'item_code' => $row[5] ));

                            // echo "<br><br>".$this->db->last_query().'  <->  '.$findProduct; continue;
                            if ( $findProduct == 1 ) {
                                if($this->Import_model->updateWhere( 'fab_product', array('style_id' => $style_id,'item_code' => $row[5] ), $data ) ) {
                                    $resQ = 'Update';
                                }else{
                                    $resQ = 'Error Update';
                                }
                            }else{

                                //$data = array_merge($data,array('custom_product' => 'Yes'));
                                if( $this->Import_model->insert_data('fab_product',$data) ){
                                    $resQ = 'Insert';
                                }else{
                                    $resQ = 'Error Insert';
                                }
                            }
                            // echo "<br>".$count." -- ".$this->db->last_query();
                            // $afterInsert = $this->findProductExist('fab_product',array('style_id' => $style_id,'item_code' => $row[5] ));
                            // echo "<br>".$count."<->".$afterInsert."--------";

                            logDbError( 'aay_import', $resQ.' - '.$row[5]." - ".$this->grouping , $this->db->last_query() );
                        }
                        $count++;
                    }
                }
                $reader->close();
                redirect("/import");
            }

        }
        redirect('/import');
    }/* End function import */

    function getNameId ($tableName,$columnName,$columnValue,$styleName=''){
        if($columnValue !=''){
            return $this->Import_model->findNameid($tableName,$columnName,$columnValue,$styleName);
        }else{
            return '';
        }
    }

    function findProductExist($table_name,$where){
        return $this->Import_model->findProductExist($table_name,$where);
    }


}

/* End of file Import.php */