<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';
require_once APPPATH . 'third_party/PHPExcel/spout-2.4.3/src/Spout/Autoloader/autoload.php';
use Box\Spout\Reader\ReaderFactory;
use Box\Spout\Common\Type;

class AsfgOrders extends MX_Controller
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
        $this->load->model('asfg_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
    }

    function edit($id){
        $data = array();
        $id = $this->uri->segment(4);
        if( $this->input->post() ){

            $this->asfg_model->saveJkOrder( $id, $this->input->post() );
            //save order logs
            log_orders( 
                $id, //order_id 
                $this->session->userdata('user_id'), 
                'edit(AsfgOrders)' 
            );
            selfRedirect();
        }
        $data['edit_order']            = $this->asfg_model->getJkOrder($id);
        $data['vendor']                = multiArrSort($this->asfg_model->fetch_all('vendor'),'name');
        $data['jk_style']              = $this->asfg_model->fetch_all('asfg_style');
        $data['jk_products']           = $this->asfg_model->getJkProdyctByOrderId($id);
        $data['jkClass']               = $this;

        $this->template->title('Edit');
        $this->template
                ->set_layout('inner')
                ->build('asfg_orders/asfg_edit', $data);
    }

/*    public function categoryByStyle() {
        $styleID = $_POST['style_id'];
        $allCats = $this->asfg_model->getCatByStyle($styleID);
        $options = "";
        if( $allCats ){
            foreach( $allCats as $cat){
                if ( $cat['id']  ) {
                    $options .= "<li class='catName' data-catid='".$cat['id']."'>".$cat['cat_name']."</li>";
                }
            }
        }
        echo $options;
    }*/

    public function categoryByStyle() {
        $styleID = $_POST['style_id'];
        $allCats = $this->asfg_model->getCatByStyle($styleID);
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
        $cat_id     = $_POST['cat_id'];
        $cat_type   = $_POST['cat_type'];
        $p_style    = $_POST['s_name'];
        $res_status = $_POST['status'];
        $mainCat    = $_POST['main_cat'];
        $childCat   = $_POST['child_cat'];
        $subCat     = $_POST['sub_cat'];
        $subSubCat  = $_POST['sub_sub_cat'];
        
        $rawRes = $this->asfg_model->getCatByProduct($cat_id,$cat_type,$p_style,$res_status,$mainCat,$childCat,$subCat, $subSubCat);
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
            $dbRes     = $this->asfg_model->getProductByCat($productId);
            if ($dbRes['status'] == 'success') {
                foreach ($dbRes['rows'] as $key => $value) {

                    $item_cost  = decimalValue($value['cost']);
                    $item_price = decimalValue($value['cust_price']);

                    $value['item_cost']  = $item_cost;
                    $value['item_code']  = $value['item_code'];
                    $value['item_description'] = $value['item_description'];
                    $value['item_price'] = $item_price;   
                    $value['prcnt_cost'] = $this->calcuatePercentage($item_price,$item_cost);
                    $trRows .= $this->load->view('asfg_orders/parent_template', $value, TRUE); 
                }
            }
        }
        echo $trRows;
    }

    function getChildProducts($style_id,$item_code){
        return $this->asfg_model->getChildProStyleName( $item_code,$style_id );
    }

    function productFilter(){
        if( isset($_POST['search']) ){
            $search = trim($_POST['search']);
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
                              ->get('asfg_product')
                              ->result_array();
            // echo $this->db->last_query(); die;
            $options = '';
            $width = ''; if( !empty( $row['width'] ) && ( $row['width'] != 'NA' ) ) $width=$row['width'].'W';
                    $height=''; if( !empty( $row['height'] ) && ( $row['height'] != 'NA' ) ) $height = $row['height'].'x H';
                    $depth ='';  if( !empty( $row['depth'] ) && ( $row['depth'] !='NA' ) ) $depth = $row['depth'].'x D';
            foreach ($output as $row){
                $options .= "<li class='child_item' data-catid='".$row['id']."'><b>".$row['item_code']."</b> - ".$row['item_description']." ".$width.$height.$depth."</li>";
            }
            $resStatus['status'] = 'final'; 
            $resStatus['res'] = $options;
            echo json_encode($resStatus);
        }
    }

    function childProductStyle($item_code='', $style_id='', $parent_id='', $data_row_count=''){
        if ( isset($_POST) ) {
            $item_code  = $_POST['item_code'];
            $style_id   = $_POST['style_id'];
            $parent_id  = $_POST['parent_id'];
            $data_row_count  = $_POST['data_row_count'];
        }
        $data['jk_product'] = $this->asfg_model->getChildProStyleName( $item_code,$style_id );
        if ( $data['jk_product'] ) { 
           $data['parent_id'] = array('parent_id' => $parent_id );
           $data['data_row_count'] = array('data_row_count' => $data_row_count );
           $trRows =  $this->load->view('asfg_orders/child_template', $data, TRUE);
           echo $trRows;
        }
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
        $data['jk_product'] = $this->asfg_model->getChildProStyleName( $item_code,$style_id );
        if ( $data['jk_product'] ) { 
           $data['parent_id']       = array('parent_id' => $parent_id );
           $data['data_row_count']  = array('data_row_count' => $data_row_count );
           $data['data_parent_row'] = array('data_parent_row' => $data_parent_row, 'data_parent_id' => $data_parent_id );

           $trRows =  $this->load->view('asfg_orders/subchild_template', $data, TRUE);
           echo $trRows;
        }
    }

    function productByStyleName(){
        $data = array(  'style_name' => "",
                        'item_cost'  => "",
                        'item_price' => "",
                        'jkpid'      => "",
                        'style_id'   => "",
                        'Item_Code'  => "",
                        'item_cost'  => "",
                        'item_price'  => "",
                    );
        
        if( isset($_POST['productId']) ){
           $proData = $this->asfg_model->getProductById($_POST['productId']);
           if ($proData) {
               if ( $_POST['assemble_value'] == '1' ) {

                    $priceData = array( 
                            'item_cost'  => decimalValue($proData['item_cost']), 
                            'item_price' => decimalValue($proData['unassembled_retail_item_price']) 
                        );
                }else{

                    $priceData = array(
                                    'item_cost'  => decimalValue($proData['cabinet_assembly_price']),
                                    'item_price' => decimalValue($proData['assembled_retail_item_price'])
                                );
                } 


                $ResData = array( 'style_name' => $proData['style_name'],
                                  'item_cost'  => $proData['item_cost'],
                                  'item_price' => $proData['item_price'],
                                  'jkpid'      => $proData['jkpid'],
                                  'style_id'   => $proData['styid'],
                                  'Item_Code'  => $proData['Item_Code'] );

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

    function calcuatePercentage($netTotal,$costPrice){
        if($costPrice == 0){
            return '100.00';
        }
        return decimalValue( ( ($netTotal-$costPrice) / $costPrice ) *100);
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

    public function styleByVendor() {
        $vID = $_POST['v_id'];
        $styles = $this->db->where( array( 'vendor_id' => $vID ) )->get('style')->result();
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


            $data = $this->asfg_model->getProductById( $proID,'product');

            $item_cost  = decimalValue($data['cost']);
            $item_price = decimalValue($data['cust_price']);

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


    function quote($id)
    {
        $id   = $this->uri->segment(4);
        $data = array();
        
        $data['order_view'] = $this->asfg_model->findWhere( 'pk_order', array( 'id' => $id ), FALSE, array( '*' ) );
        $data['pro_view'] = $this->asfg_model->getJkProdyctByOrderId($id);
        $data['controllerThis'] = $this;

        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('asfg_orders/quote', $data);        

    }

    function quoteOrderForObject($assemble_value,$value,$PO_Quote){

        $parentDetails = [];

        $ted_price = $value['cost'];
        $cust_price = $value['cust_price'];

        if ( $PO_Quote == 'Yes' ) {
            $price = $ted_price;
            $custom_price =  $value['u_price'];
            $custom_description = $value['descriptionII'];
        }else{
            $price = $cust_price;
            $custom_price =  $value['price'];
            $custom_description = $value['description'];
        }

        $priceTotal = $value['qty'] * decimalValue($price);
        $parentDetails = [
                    'item_code' => $value['item_code'],
                    'style_name' => $value['style_name'],
                    'qty' => $value['qty'],
                    'price' => $custom_price, 
                    'main_description' => $value['item_description'], 
                    'custom_description' => $custom_description,
                    'cust_price' => $price ,
                    'totalprice' => $priceTotal 
                ];
        return $parentDetails;
    }

    function contract($id)
    {   
        $id   = $this->uri->segment(4);
        $data = array();

        $data['order_view'] = $this->asfg_model->getJkOrder($id);
        $data['controllerThis'] = $this;
        $data['pro_view'] = $this->asfg_model->getJkProdyctByOrderId($id);

        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('asfg_orders/contract', $data);        

    }

    function purchase_order($id)
    {
        $id   = $this->uri->segment(4);
        $data = array();

        $data['order_view'] = $this->asfg_model->getJkOrder($id);
        $data['pro_view']   = $this->asfg_model->getJkProdyctByOrderId($id);
        $vid = $data['order_view']['vendor'];
        $data['controllerThis'] = $this;
        $data['my_vendor']  = $this->asfg_model->findWhere( 'vendor', array( 'id' => $vid ), FALSE, array( '*' ) );
        
        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('asfg_orders/purchase_order', $data);        

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

    function calcuateTax(){
        if ( isset($_POST) ) {
            $subtotal = $_POST['subtotal'];
            $perc_amount = $_POST['perc_amount'];
            $taxVal = $_POST['taxVal'];
        }

        $Afterdiscount = $subtotal - $perc_amount;
        $taxValue      = ($taxVal/100) * $Afterdiscount;  
        $totalAfterTax = $Afterdiscount + $taxValue;

        echo json_encode( array(
            'taxValue' => decimalValue($taxValue),
            'netprice' => decimalValue($totalAfterTax),
        ) );

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
                'NetPrice'        => print_r($tax_price,1),
                'taxRate'         => $tax_rate,
                'taxValue'        => decimalValue($tax_price),
                'afterDiscPrice'  => decimalValue($beforeTax),
                'nCostAmt'        => decimalValue($total_cost),
                'nCostPrc'        => $this->calcuatePercentage($beforeTax,$total_cost),
                'paidAmountPrc'   => $this->calcuateAmountPer($net_price,$paid_amount),
                'totalDue'        => decimalValue($total_due),
                'descAmt'         => decimalValue($descAmt),
                'descPer'         => decimalValue($descPer),
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
        $this->load->view('asfg_orders/load_script', $data);
    }

    function load_css()
    {
        $data = array();
        $this->load->view('asfg_orders/load_css', $data);
    }
}