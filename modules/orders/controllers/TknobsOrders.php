<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';
require_once APPPATH . 'third_party/PHPExcel/spout-2.4.3/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class TknobsOrders extends MX_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('security');
        $this->load->library('tank_auth');
        $this->lang->load('tank_auth');
        $this->load->module('layouts');
        $this->load->library('template');
        $this->load->model('tknobs_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
    }

    function edit($id){
        $data = array();
        $allPros = array();
        $id = $this->uri->segment(4);
        $sArr = $this->input->post();

        if( $this->input->post() ){

            if (!empty($_FILES['file_upload']['name'])) {

                $config = array(
                    'upload_path' => "assets/productOrderfile",
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
                                $sr      = $row['0'];
                                $itmCode = $row['1'];
                                $styid   = $this->input->post('style');
                                
                                $parentChild = explode('.', $sr);
                                $this->db->select('pkpro.*,pkpro.id as pkpro_id,pkpro.style_id as pkprost,sy.*,sy.id as sid');
                                         $this->db->from('tknobs_product pkpro');
                                         $this->db->join('tknobs_style sy', 'pkpro.style_id = sy.id', 'left');
                                         $this->db->where(array( 'pkpro.item_code' => $itmCode, 'pkpro.style_id' => $styid ) );
                                $query = $this->db->get();
                                $pro_Id = $query->row();


                                if ( isset($parentChild[1]) ) {
                                    $is_parent = 'no';
                                }else{
                                    $is_parent = 'yes';
                                }

                                if ( $pro_Id != "" ) {

                                      if( empty( $pro_Id->Width ) || ( $pro_Id->Width =='NA' ) ){ $width=''; }else{ $width=$pro_Id->Width.'W x '; }
                                      if( empty( $pro_Id->Height ) || ( $pro_Id->Height =='NA' ) ){$height='';}else{$height = $pro_Id->Height.'W x ';}
                                      if( empty( $pro_Id->Depth ) || ( $pro_Id->Depth =='NA' ) ) {$depth='';}else{$depth = $pro_Id->Depth.'D';}

                                        $item_cost    = decimalValue($pro_Id->item_cost);
                                        $cabinet_cost = decimalValue($pro_Id->retail_price);

                                      if( empty($item_cost) || $item_cost == 'NA'  ){
                                        $item_cost    = 0;
                                      }

                                      if( empty($cabinet_cost) || $cabinet_cost == 'NA'  ){
                                        $cabinet_cost    = 0;
                                      }

                                      $proDode = array( 'product_id' => $pro_Id->pkpro_id, 'qty' => '1', 'style_id' => $pro_Id->style_code.'/'.$pro_Id->item_code, 'description' => '','descriptionII' => '','item_code' => $pro_Id->item_code,'style_id' => $styid,'price'=> '','u_price'=> '','total_price' => $cabinet_cost,'final_cost' => $item_cost,'item_cost' => $item_cost,'cabinaet_assemb_c' => $cabinet_cost ,'is_parent' => $is_parent, 'parent_id' => $parentChild[0]);

                                        if ($is_parent == 'yes') {
                                            $data[$parentChild[0]] = $proDode;
                                        }else{
                                            $data[$parentChild[0]]['child_product'][] = $proDode;
                                        }
                                    }else{
                                        $styleData =  $this->tknobs_model->findWhere( 'tknobs_style',array( 'id' => $styid ), False, array('*'));
                                        $styleCode = $styleData['style_code'];
                                        $styleName = $styleData['style_name'];
                                        
                                        $proDode = array( 'product_id' => 'temp_'.rand(999,99999), 'qty' => '1', 'item_code' => $itmCode,'style_id' => $styid,'description' => '','descriptionII' => '','price'=> '','u_price'=> '','item_cost' => 0,'cabinaet_assemb_c' => 0,'total_price' => '0','final_cost' => '0', 'is_parent' => $is_parent, 'parent_id' => $parentChild[0],'assembled_retail_item_price' => 0, 'not_exist' => 'yes' );

                                        if ($is_parent == 'yes') {
                                            $data[$parentChild[0]] = $proDode;
                                        }else{
                                            $data[$parentChild[0]]['child_product'][] = $proDode;
                                        }
                                    }

                            } $count++;
                        }
                    }
                    $reader->close();
                }
                $sArr['is_import'] = 'yes';
                $sArr['product'] = $data;
                // $finalProList = $this->searchForSameProduct($sArr['product'],true);
                // if ($finalProList) $sArr['product'] = $finalProList;
            }else{
                $sArr['is_import'] = 'no';
            }

            $this->tknobs_model->saveJkOrder( $id, $sArr );
            //save order logs
            log_orders( 
                $id, //order_id 
                $this->session->userdata('user_id'), 
                'edit(TknobsOrders)' 
            );
            selfRedirect();
        }

        $data['edit_order']            = $this->tknobs_model->getJkOrder($id);
        $data['vendor']                =multiArrSort($this->tknobs_model->fetch_all('vendor'),'name');
        $data['jk_style']              = $this->tknobs_model->fetch_all('tknobs_style');
        $data['jk_products']           = $this->tknobs_model->getJkProdyctByOrderId($id);
        $data['jk_products_child']     = $this->tknobs_model->getJkProdyctChildByOrderId($id);
        $data['jk_products_subchild']  = $this->tknobs_model->getJkProdyctSubChildByOrderId($id);
        $data['jkClass']               = $this;

        $this->template->title('Wc Edit');
        $this->template
                ->set_layout('inner')
                ->build('tknobs_orders/tknobs_edit', $data);
    }

    public function categoryByStyle() {
        $styleID = $_POST['style_id'];
        $allCats = $this->tknobs_model->getCatByStyle($styleID);
        $options = "";
        $allCats = $this->arrayShortByName($allCats);
        if( $allCats ){
            foreach( $allCats as $id => $cat_name){
                if ( $id  ) {
                    $options .= "<li class='catName' data-catid='".$id."'>".$cat_name."</li>";
                }
            }
        }
        echo $options;
    }

    function arrayShortByName($myArray){
        foreach ($myArray as $key => $value) {
            if( $value['id'] ){
                    $arrayMer[$value['id']] = $value['cat_name'];
            }
        }
        asort($arrayMer);
        return $arrayMer;
    }

    public function categoryByProduct(){
        $cat_id   = $_POST['cat_id'];
        $cat_type = $_POST['cat_type'];
        $p_style  = $_POST['s_name'];
        $res_status = $resStatus['status'];
        $mainCat  = $_POST['main_cat'];
        $childCat  = $_POST['child_cat'];
        $subCat  = $_POST['sub_cat'];
        $subSubCat  = $_POST['sub_sub_cat'];
        
        $rawRes = $this->tknobs_model->getCatByProduct($cat_id,$cat_type,$p_style,$res_status,$mainCat,$childCat,$subCat, $subSubCat);
        $options = "";
        $dbRes = $rawRes['result'];
        foreach( $dbRes as $key => $value ){
            if($rawRes['rtype'] == 'product'){
                    $status = 'final';
                    $width = ''; if( !empty( $value['Width'] ) && ( $value['Width'] != 'NA' ) ) $width=$value['Width'].'W';
                    $height=''; if( !empty( $value['Height'] ) && ( $value['Height'] != 'NA' ) ) $height = $value['Height'].'x H';
                    $depth ='';  if( !empty( $value['Depth'] ) && ( $value['Depth'] !='NA' ) ) $depth = $value['Depth'].'x D';
                    $dN = "<b>".$value['display_title']."</b> - ". $value['item_description'].' '.$width.$height.$depth;
                    $key = $value['id'];
            }else{
                $status = 'notfinal';
                $dN = $value;
                $key = $key;
            }
            $options .= "<li class='child_item' data-catid='".$key."'>$dN</li>";
        }
        $resStatus = array( 'res' => $options, 'status' => $status);
        echo json_encode($resStatus); 
    }

    function productByCategory()
    {
        $trRows = '';
        if ( isset( $_POST['productId'] ) ) {
            $productId = $_POST['productId'];
            $dbRes     = $this->tknobs_model->getProductByCat($productId);
            if ($dbRes['status'] == 'success') {
                foreach ($dbRes['rows'] as $key => $value) {
                    $item_cost  = decimalValue($value['item_cost']);
                    $item_price = decimalValue($value['retail_price']);

                    $value['item_cost']  = $item_cost;
                    $value['item_price'] = $item_price;   
                    $value['prcnt_cost'] = $this->calcuatePercentage($item_price,$item_cost);
                    $trRows .= $this->load->view('tknobs_orders/parent_template', $value, TRUE); 
                }
            }
        }
        echo $trRows;
    }

    function getChildProducts($style_id,$item_code){
        return $this->tknobs_model->getChildProStyleName( $item_code,$style_id );
    }

    function productFilter(){
        if( isset($_POST['search']) ){
            $search = $_POST['search'];
            $cond = array();
            // if( !empty($_POST['vendor_id']) ){
            //     $cond = array_merge( $cond, array( "vendor_id" => $_POST['vendor_id'] ) );
            // }
            if( !empty($_POST['style_id']) ){
                $cond = array_merge( $cond, array( "style_id" => $_POST['style_id'] ) );
            }
            $output = $this->db->where("(item_code like '%".$search."%' OR item_description like '%".$search."%')", NULL, FALSE)
                      ->where($cond)
                      ->where('not_exist IS NULL', null, false)
                      ->get('tknobs_product')
                      ->result_array();
            $options = '';
            $width = ''; if( !empty( $row['width'] ) && ( $row['width'] != 'NA' ) ) $width=$row['width'].'W';
                    $height=''; if( !empty( $row['height'] ) && ( $row['height'] != 'NA' ) ) $height = $row['height'].'x H';
                    $depth ='';  if( !empty( $row['depth'] ) && ( $row['depth'] !='NA' ) ) $depth = $row['depth'].'x D';
            foreach ($output as $row){
                $options .= "<li class='child_item' data-catid='".$row['id']."'><b>".$row['item_code']." -</b> ".$row['item_description']." ".$width.$height.$depth."</li>";
            }
            $resStatus['status'] = 'final'; 
            $resStatus['res'] = $options;
            echo json_encode($resStatus);
        }
    }

    function childProductStyle($item_code='', $style_id='', $parent_id='', $data_row_count=''){
        if ( isset($_POST) ) {
            $trRows = '';
            $item_code  = $_POST['item_code'];
            $style_id   = $_POST['style_id'];
            $parent_id  = $_POST['parent_id'];
            $data_row_count  = $_POST['data_row_count'];

            $data['jk_product'] = $this->tknobs_model->getChildProStyleName( $item_code,$style_id );
            if ( $data['jk_product'] ) { 
               $data['parent_id'] = array('parent_id' => $parent_id );
               $data['data_row_count'] = array('data_row_count' => $data_row_count );
               $trRows =  $this->load->view('tknobs_orders/child_template', $data, TRUE);
               echo $trRows;
            }else{
                $varient = $this->tknobs_model->getProductFindByVariants($item_code,$style_id)[0];
                if($varient){
                    $data['jk_product'] = $this->tknobs_model->getChildProStyleName( $varient['item_code'],$style_id );
                    if ( $data['jk_product'] ) { 
                       $data['parent_id'] = array('parent_id' => $parent_id );
                       $data['data_row_count'] = array('data_row_count' => $data_row_count );
                       $trRows =  $this->load->view('tknobs_orders/child_template', $data, TRUE);
                       echo $trRows;
                    }
                }
            }
        }
        die;
    }

    function productByStyleName(){
        $data = array(  'style_name' => "",
                        'item_cost'  => "",
                        'item_price' => "",
                        'jkpid'      => "",
                        'style_id'   => "",
                        'item_code'  => "",
                    );
        
        if( isset($_POST['productId']) ){
           $proData = $this->tknobs_model->getProductById($_POST['productId']);
           if ($proData) {
                $priceData = array(
                    'item_cost'  => decimalValue($proData['item_cost']),
                    'item_price' => decimalValue($proData['retail_price'])
                );
                $ResData =  array( 'style_name' => $proData['style_name'],
                                  'item_cost'  => decimalValue($proData['item_cost']),
                                  'item_price' => decimalValue($proData['item_price']),
                                  'jkpid'      => $proData['jkpid'],
                                  'style_id'   => $proData['styid'],
                                  'item_code'  => $proData['item_code'] 
                            );

                $data = array_merge( $ResData,$priceData );

            }else{
                $data = array(
                    'item_cost'  => '0.00',
                    'item_price' => '0.00'
                );
            }
        }
        echo json_encode($data);
    }

    function subChildProductStyle($item_code='', $style_id='', $parent_id='', $data_row_count=''){
        if ( isset($_POST) ) {
            $item_code       = $_POST['item_code'];
            $style_id        = $_POST['style_id'];
            $parent_id       = $_POST['parent_id'];
            $data_row_count  = $_POST['data_row_count'];
            $data_parent_row = $_POST['data_parent_row'];
            $data_parent_id  = $_POST['data_parent_id'];
            $parent_id       = $_POST['parent_id'];
        }
        $data['jk_product'] = $this->tknobs_model->getChildProStyleName( $item_code,$style_id );
        if ( $data['jk_product'] ) { 
           $data['parent_id']       = array('parent_id' => $parent_id );
           $data['data_row_count']  = array('data_row_count' => $data_row_count );
           $data['data_parent_row'] = array('data_parent_row' => $data_parent_row, 'data_parent_id' => $data_parent_id );

           $trRows =  $this->load->view('tknobs_orders/subchild_template', $data, TRUE);
           echo $trRows;
        }else{
            $varient = $this->tknobs_model->getProductFindByVariants($item_code,$style_id)[0];
            if($varient){
                $data['jk_product'] = $this->tknobs_model->getChildProStyleName( $varient['item_code'],$style_id );
                if ( $data['jk_product'] ) { 
                   $data['parent_id']       = array('parent_id' => $parent_id );
                   $data['data_row_count']  = array('data_row_count' => $data_row_count );
                   $data['data_parent_row'] = array('data_parent_row' => $data_parent_row, 'data_parent_id' => $data_parent_id );

                   $trRows =  $this->load->view('tknobs_orders/subchild_template', $data, TRUE);
                   echo $trRows;
                }
            }
        }
    }

    function calcuatePercentage($netTotal,$costPrice){
        if($costPrice == 0){
            return '100.00';
        }
        return decimalValue( ( ($netTotal-$costPrice) / $costPrice ) *100);
    }

    public function styleByVendor() {
        $vID = $_POST['v_id'];
        $styles = $this->db->where( array( 'vendor_id' => $vID ) )->get('tknobs_style')->result();
        $options = "<option value='0'>Select...</option>";
        if( $styles ){
            foreach( $styles as $style){
                $options .= "<option value='$style->id'>$style->style_name</option>";
            }
        }
        echo $options;
    }
    function calcuateProQty(){
        if ( isset($_POST) ) {
            $pro_qty = $_POST['qty'];
            $proID   = $_POST['pro_id'];
            $changeCost    = $_POST['change_cost'];
            $changePrice   = $_POST['change_price'];


            $data = $this->tknobs_model->getProductById( $proID,'tknobs_product');

            $item_cost  = decimalValue($data['item_cost']);
            $item_price = decimalValue($data['retail_price']);
    
            $finalIC = $item_cost*$pro_qty;
            $finalIP = $item_price*$pro_qty;

            if ( isset($changeCost) ) {
                $finalIC = $finalIC+$changeCost;
            }

            if ( isset($changePrice) ) {
                $finalIP = $finalIP+$changePrice;
            }

            echo json_encode( array(
                'item_cost'   => decimalValue($finalIC),
                'item_price'  => decimalValue($finalIP),
                'nCostPrc'    => $this->calcuatePercentage($finalIP,$finalIC)
            ));
        }
    }

    function quoteOrderForObject($value,$PO_Quote){

        $parentDetails = [];
        $width  = ''; if( !empty( $value->width ) && ( $value->width !='NA' ) ) $width=$value->width.'W x ';
        $height = ''; if(!empty( $value->Height ) && ( $value->Height !='NA' ) ) $height=$value->Height.'W x ';
        $length  = ''; if(!empty( $value->length ) && ( $value->length !='NA' ) ) $depth=$value->length.'D';
        
        $ted_price = decimalValue($value->item_cost);
        $cust_price = decimalValue($value->retail_price);

        if ( $PO_Quote == 'Yes' ) {
            $price = $ted_price;
            $custom_price =  $value->u_price;
            $custom_description = $value->descriptionII;
        }else{
            $price = $cust_price;
            $custom_price =  $value->price;
            $custom_description = $value->description;
        }

        $priceTotal = $value->qty * decimalValue($price);

        $parentDetails = [
                    'width' => $width, 
                    'height' => $height, 
                    'depth' => $depth,
                    'item_code' => $value->item_code,
                    'style_name' => $value->sn,
                    'qty' => $value->qty,
                    'price' => $custom_price, 
                    'main_description' => $value->item_description, 
                    'custom_description' => $custom_description,
                    'cust_price' => $price ,
                    'totalprice' => $priceTotal 
                ];
        return $parentDetails;
        
    }

    function quote($id)
    {
        $id   = $this->uri->segment(4);
        $data = array();
        
        $data['order_view'] = $this->tknobs_model->getJkOrder($id);
        $data['pro_view'] = $this->tknobs_model->getProductDetails($id);
        $data['product_order_child'] = $this->tknobs_model->getChildProductQuote($id);
        $data['product_order_sub_child'] = $this->tknobs_model->getSubChildProductQuote($id);        
        $data['obj'] = $this;       

        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('tknobs_orders/quote', $data);        

    }

    function contract($id)
    {   
        $id   = $this->uri->segment(4);
        $data = array();
        
        
        $data['order_view'] = $this->tknobs_model->getJkOrder($id);
        $data['pro_view'] = $this->tknobs_model->getProductDetails($id);
        $data['product_order_child'] = $this->tknobs_model->getChildProductQuote($id);
        $data['product_order_sub_child'] = $this->tknobs_model->getSubChildProductQuote($id);        
        $data['controllerThis'] =  $this;

        
        $data['payment_data'] = $this->tknobs_model->findWhere( 'customer_payment', array( 'order_id' => $id ), TRUE, array( 'payment_amount' ) );
        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('tknobs_orders/contract', $data);        

    }

    function purchase_order($id)
    {
        $id   = $this->uri->segment(4);
        $data = array();

        $data['order_view'] = $this->tknobs_model->getJkOrder($id);
        $data['pro_view'] = $this->tknobs_model->getProductDetails($id);
        $data['product_order_child'] = $this->tknobs_model->getChildProductQuote($id);
        $data['product_order_sub_child'] = $this->tknobs_model->getSubChildProductQuote($id);        
        $data['controllerThis'] =  $this;

        $vid = $data['order_view']['vendor'];
        $data['my_vendor']  = $this->tknobs_model->findWhere( 'vendor', array( 'id' => $vid ), FALSE, array( '*' ) );
        
        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('tknobs_orders/purchase_order', $data);        

    }

    /* ---------------------------  start calcuated copy function --------------------------- */

    function calcuateAllProductPrice(){
        if ( isset($_POST) ) {
            $total_price = $_POST['total_price'];
            $total_cost  = $_POST['total_cost'];
            $paid_amount = $_POST['paid_amount'];

            $subcostPerc = $this->calcuatePercentage($total_price,$total_cost);

            if ( $_POST['is_pickup'] =='no' ) {
                $deliveryp = ($_POST['deliveryp']) ? $_POST['deliveryp'] : '0';
                $deliveryc = ($_POST['deliveryc']) ? $_POST['deliveryc'] : '0';
                
                $afterDeliveryPrice =  $total_price += $deliveryp;
                $afterDeliveryCost  =  $total_cost  += $deliveryc;

                if ($deliveryp && $deliveryc) {
                    $afterDeliveryPerc = ($deliveryp-$deliveryc)/$deliveryc*100;
                }else{
                    $afterDeliveryPerc = "0.00";
                }

            }else{
                $afterDeliveryPrice = $total_price;
                $afterDeliveryCost = $total_cost;
                $afterDeliveryPerc = "0.00";
            }

            if($_POST['price_perc']){
                $perAmt = ($total_price * $_POST['price_perc']) / 100;
                $total_price -= $perAmt;
            }else if ($_POST['perc_amount']) {
                $total_price -= $_POST['perc_amount'];
            }

            $afterDiscPrice = $total_price;

            if ( $_POST['resale'] != 'yes' ) {
                $tax_price = (order_tax * $total_price) / 100;
                $total_order = $total_price + $tax_price;
                $tax_rate = order_tax;
            }else{
                $tax_rate = '0.00';
                $tax_price = '0.00';
                $total_order = $total_price;
            }

            $total_due = $total_order - $paid_amount; 

            echo json_encode( array(
                'ProductPrice'       => print_r($_POST,1),
                'subtotal'           => decimalValue($_POST['total_price']),
                'subcost'            => decimalValue($_POST['total_cost']),
                'subcostPerc'        => decimalValue($subcostPerc),
                'taxRate'            => $tax_rate,
                'perAmt'             => decimalValue($perAmt),
                'taxValue'           => decimalValue($tax_price),
                'afterDeliveryPrice' => decimalValue($afterDeliveryPrice),
                'afterDeliveryCost'  => decimalValue($afterDeliveryCost),
                'afterDeliveryPerc'  => decimalValue($afterDeliveryPerc),
                'afterDiscPrice'     => decimalValue($afterDiscPrice),
                'netprice'           => decimalValue($total_order),
                'nCostAmt'           => decimalValue($total_cost),
                'nCostPrc'           => $this->calcuatePercentage($afterDiscPrice,$total_cost),
                'paidAmountPrc'      => $this->calcuateAmountPer($total_order,$paid_amount),
                'totalDue'          => decimalValue($total_due),
            ));
        }
    }

    function calcuateAmountPer($total_amount,$paid_amount){
        if($paid_amount){
            $res = ( $paid_amount / $total_amount ) * 100;
            if (!is_nan($res)) {
                return decimalValue($res);
            }
            return '0.00';
        }
        return '0.00';
    }

    public function customSum(){
        if ( isset($_POST) ) {
            $deliveryp = ($_POST['deliveryp']) ? $_POST['deliveryp'] : '0';
            $deliveryc = ($_POST['deliveryc']) ? $_POST['deliveryc'] : '0';
            $curprice  = $_POST['curprice'];
            
            if ($_POST['ptype'] == 'price') {
                $sum = $deliveryp + $curprice;
            }else{
                $sum = $deliveryc + $curprice;
            }
            
            if ($deliveryp && $deliveryc) {
                $perc = ($deliveryp-$deliveryc)/$deliveryc*100;
            }else{
                $perc = "0.00";
            }
            echo json_encode( array(
                'perc' => decimalValue($perc),
                'final_val' => decimalValue($sum)
            ) );
        }
    }

    function calcuateAllProductByAmt(){
        if ( isset($_POST) ) {
            $total_cost  = $_POST['total_cost'];
            $total_price = $_POST['total_price'];
            $disc_amt    = $_POST['disc_amt'];
            
            $perPer = ($disc_amt / $total_price) * 100;
            $afterDisc = $total_price - $disc_amt;

            if ( $_POST['is_pickup'] =='no' ) {
                $deliveryp = ($_POST['deliveryp']) ? $_POST['deliveryp'] : '0';
                $deliveryc = ($_POST['deliveryc']) ? $_POST['deliveryc'] : '0';
                
                $afterDisc  += $deliveryp;
                $total_cost += $deliveryc;
            }

            if ( $_POST['resale'] !='yes' ) {
                $Tax =  ($afterDisc * order_tax) / 100;
                $afterDisc = $afterDisc + $Tax;    
            }else{
                $afterDisc = $afterDisc;
            }

            echo json_encode( array(
                'taxAmt'  => decimalValue($Tax),
                'perCent' => decimalValue($perPer),
                'netprice' => decimalValue($afterDisc),
                'nCostAmt' => decimalValue($total_cost),
                'nCostPrc' => $this->calcuatePercentage($afterDisc,$total_cost)
            ));
        }
    }

    function calcuateAllProductByPerc(){
        if ( isset($_POST) ) {
            $total_price = $_POST['total_price'];
            $total_cost  = $_POST['total_cost'];
            $perct       = $_POST['perc'];
            
            if ( $_POST['is_pickup'] =='no' ) {
                $deliveryp = ($_POST['deliveryp']) ? $_POST['deliveryp'] : '0';
                $deliveryc = ($_POST['deliveryc']) ? $_POST['deliveryc'] : '0';
                
                $total_price += $deliveryp;
                $total_cost  += $deliveryc;
            }

            $perAmt = ($total_price * $perct) / 100;
            $afterDisc = $total_price - $perAmt;

            if ( $_POST['resale'] !='yes' ) {
                $Tax =  ($afterDisc * order_tax) / 100;
                $afterDisc = $afterDisc + $Tax;    
            }else{
                $afterDisc = $afterDisc;
            }

            echo json_encode( array(
                'taxAmt'   => decimalValue($Tax),
                'perAmt'   => decimalValue($perAmt),
                'netprice' => decimalValue($afterDisc),
                'nCostAmt' => decimalValue($total_cost),
                'nCostPrc' => $this->calcuatePercentage($afterDisc,$total_cost),
                'dsfsdf' =>  print_r($_POST,1)
            ));
        }
    }

    function calcuateAllProductByNetPrice(){
        if ( isset($_POST) ) {
            
            $total_price  = $_POST['total_price'];
            $net_price    = $_POST['net_price'];
            $total_cost   = $_POST['total_cost'];
            $paid_amount  = $_POST['paid_amount'];
            $resale       = $_POST['resale'];

            if ( $resale != 'yes' ) {
                $reverseVal = (order_tax/100) + 1;
                $beforeTax =  $net_price / $reverseVal;
                $tax_price = $net_price - $beforeTax;
                $tax_rate = order_tax;
            }else{
                $tax_rate = '0.00';
                $tax_price = '0.00';
                $beforeTax = $net_price;
            }

            $descAmt = $total_price - $beforeTax;
            $descPer = ($descAmt/$total_price)*100;

            $total_due = $net_price - $paid_amount; 

            echo json_encode( array(
                'NetPrice'           => print_r($tax_price,1),
                'taxRate'            => $tax_rate,
                'taxValue'           => decimalValue($tax_price),
                'afterDiscPrice'     => decimalValue($beforeTax),
                'nCostAmt'           => decimalValue($total_cost),
                'nCostPrc'           => $this->calcuatePercentage($beforeTax,$total_cost),
                'paidAmountPrc'      => $this->calcuateAmountPer($net_price,$paid_amount),
                'totalDue'          => decimalValue($total_due),
                'descAmt'          => decimalValue($descAmt),
                'descPer'          => decimalValue($descPer),
            ));
        }
    }

    function calcuateNetDiscount(){
        if ( isset($_POST) ) {

            $total_price  = $_POST['subtotal'];
            $total_cost   = $_POST['total_cost'];
            $pricePerc    = $_POST['price_perc'];
            $percAmount   = $_POST['perc_amount'];
            $resale       = $_POST['resale'];
            $dlvryPrice   = $_POST['delivery_price'];
            
            if($percAmount){
                $net_price = $total_price - $percAmount;
            }else{
                $perAmt = ($total_price * $pricePerc) / 100;
                $net_price = $total_price - $perAmt;
            }

            if ( $resale != 'yes' ) {
                $Tax = ($net_price * order_tax) / 100;
                $net_price = $net_price + $Tax;
            }else{
                $net_price = $net_price;
            }

            if ($dlvryPrice) {
                $net_price += $dlvryPrice;
            }

            echo json_encode( array(
                'taxAmt'   => decimalValue($Tax),
                'netprice' => decimalValue($net_price),
                'nCostAmt' => decimalValue($total_cost),
                'nCostPrc' => $this->calcuatePercentage($net_price,$total_cost)
            ));
        }
    }

/* ---------------------------  end calcuated copy function ---------------------------  */



    function load_script()
    {
        $data = array();
        $this->load->view('tknobs_orders/load_script', $data);
    }

    function load_css()
    {
        $data = array();
        $this->load->view('tknobs_orders/load_css', $data);
    }
}