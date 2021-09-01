<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . 'third_party/ClickSend/vendor/autoload.php';

class FabOrders extends MX_Controller
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
        $this->load->model('fab_model');
        $this->load->model('user_model');
        if (!$this->tank_auth->is_logged_in()) {
            redirect('auth/login');
        }
    }

    function index()
    {   
        $data = array();
        $result = $this->db->select('*')->from('pk_order')->get();
        $data['order'] = $result->result('array');  
        $this->load->view('index', $data);
        $this->template->title('order');
        $this->template
                ->set_layout('inner')
                ->build('fab_orders/fab_orders', $data);
    }

    function edit($id){
        $data = array();
        $id = $this->uri->segment(4);

        if( $this->input->post() ){
            $this->fab_model->saveFabOrder( $id, $this->input->post() );
            //save order logs
            log_orders( 
                $id, //order_id 
                $this->session->userdata('user_id'), 
                'edit(FabOrders)' 
            );
            selfRedirect();
        }

        $data['edit_order']   = $this->fab_model->getFabOrder($id);
        $data['vendor']       = multiArrSort($this->fab_model->fetch_all('vendor'),'name');
        $data['fab_style']    = $this->fab_model->fetch_all('fab_style');
        $data['fab_products'] = $this->fab_model->getFabProdyctByOrderId($id);

        // pr($data,1);
        $this->template->title('Fab Edit');
        $this->template
                ->set_layout('inner')
                ->build('fab_orders/fab_edit', $data);
    }

    public function categoryByStyle() {
        $styleID = $_POST['style_id'];
        $allCats = $this->fab_model->getCatByStyle($styleID);
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
    
    function productByCategory()
    {
        $trRows = '';
        if ( isset( $_POST['productId'] ) ) {
            $productId = $_POST['productId'];
            $styleId   = $_POST['style'];
            $catId     = $_POST['cat_id'];
            $dbRes     = $this->fab_model->getProductByCat($productId);
            if ($dbRes['status'] == 'success') {
                foreach ($dbRes['rows'] as $key => $value) {
                    $value['slab1_id']   = '';
                    $value['slab1_sqft'] = '';
                    $value['slab2_id']   = '';
                    $value['slab2_sqft'] = '';
                    $value['slab3_id']   = '';
                    $value['slab3_sqft'] = '';
                    $value['pro_qty']    = '1';

                    if ( $styleId == 1 ) {
                        $value['item_cost']  = '0.00';
                        $value['item_price'] = '0.00';
                        $value['prcnt_cost'] = '0.00';
                        $value['display']    = 'MSI_N';
                        $value['pro_qty']    = '1';
                    }elseif ( $styleId == '2' ) {
                        
                        $itemSqft = $value['slab_cost']/$value['item_cost'];
                        $value['slab1_id']   = $value['item_code'];
                        $value['slab1_sqft'] = $value['apx_slab_sq_ft'];
                        $value['item_cost']  = decimalValue( $value['item_cost'] * $itemSqft );
                        $value['item_price'] = decimalValue( $value['item_cost'] * 1.5 );
                        $value['prcnt_cost'] = $this->calcuatePercentage($value['item_price'],$value['item_cost']);
                        $value['display']    = 'MSI_Q';

                        
                    }elseif ( $styleId == '3' ) {
                        $value['item_cost']  = decimalValue($value['item_cost']);
                        $value['item_price'] = decimalValue($value['item_cost'] * 1.5);
                        $value['prcnt_cost'] = $this->calcuatePercentage($value['item_price'],$value['item_cost']);
                        $value['display']    = 'AAY_G_Q';
                    }elseif ( $styleId == '4' ) {
                        $value['item_cost']  = decimalValue($value['item_cost']);
                        $value['item_price'] = decimalValue($value['customer_price']);
                        $value['prcnt_cost'] = $this->calcuatePercentage($value['customer_price'],$value['item_cost']);
                        $value['display']    = 'AAY_Sink';
                    }

                    $trRows .= $this->load->view('fab_orders/parent_template', $value, TRUE); 
                }
            }
        }
        echo $trRows;
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
        
        $rawRes = $this->fab_model->getCatByProduct($cat_id,$cat_type,$p_style,$res_status,$mainCat,$childCat,$subCat, $subSubCat);
        $options = "";
        $dbRes = $rawRes['result'];
        foreach( $dbRes as $key => $value ){
            if($rawRes['rtype'] == 'product'){
                    $status = 'final';
                    if ( $value['is_sub_item_only'] != 'Y' ) {
                        $dN = "<b>".$value['display_title']."</b> - ". $value['item_description'].' '.$width.$height.$depth;
                        $key = $value['id'];
                    }
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

    public function styleByVendor() {
        $vID = $_POST['v_id'];
        $styles = $this->db->where( array( 'vendor_id' => $vID ) )->get('fab_style')->result();
        $options = "<option value='0'>Select...</option>";
        if( $styles ){
            foreach( $styles as $style){
                $options .= "<option value='$style->id'>$style->style_name</option>";
            }
        }
        echo $options;
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
                              ->get('fab_product')
                              ->result_array();
            $options = '';
            $width = ''; if( !empty( $row['width'] ) && ( $row['width'] != 'NA' ) ) $width=$row['width'].'W';
                    $height=''; if( !empty( $row['height'] ) && ( $row['height'] != 'NA' ) ) $height = $row['height'].'x H';
                    $depth ='';  if( !empty( $row['depth'] ) && ( $row['depth'] !='NA' ) ) $depth = $row['depth'].'x D';
            foreach ($output as $row){
                $options .= "<li class='child_item' data-catid='".$row['id']."'><b>".$row['item_code']." - </b>".$row['item_description']." ".$width.$height.$depth."</li>";
            }
            $resStatus['status'] = 'final'; 
            $resStatus['res'] = $options;
            echo json_encode($resStatus);
        }
    }

    function calcuateSlabPrice(){
        /*
            Cost Quantity 
            + Add 3 SQFT slabs

            Item Cost from DB
             = Total slab cost = ( Item Cost * Add 3 SQFT slabs )

            Fabrication
            Get fab cost from DB
            total fab cost = ( Quantity * Get fab cost from DB )

            Cost for sqft for ted =  ( total fab cost + Total slab cost )

        */
        if ( isset($_POST) ) {
            extract($_POST);
            $rowData = $this->fab_model->getProductById($proId);

            if (empty($slabVOne)) { $slabVOne = 0; }
            if (empty($slabVTwo)) { $slabVTwo = 0; }
            if (empty($slabVThree)) { $slabVThree = 0; }
            if (empty($slabQty)) { $slabQty = 1; }

            if ($styleId =='1' || $styleId =='2'  ) {
                // Total squarefeet for slab 1,2.3
                $totalSqFtSlab = $slabVOne+$slabVTwo+$slabVThree;
                $console = "<br>Total slab - ".$totalSqFtSlab;
                
                $itemCostSqFt  = $rowData['item_cost'];
                $console .= "<br>Item Cost ".$itemCostSqFt;

                $totalSlabCost = $itemCostSqFt*$totalSqFtSlab;
                $console .= "<br>Total Item Cost ".$totalSlabCost;
                	
                // Get Fabrication cost
                $fabCost = $rowData['fabrication_cost'];
                $console .= "<br>Fab Cost ".$fabCost;

                $totalFabCost = $slabQty*$fabCost;
                $console .= "<br>Total Fab Cost ".$totalFabCost;

                // Total Cost price
                $totalOrderCost = $totalSlabCost+$totalFabCost;
                $console .= "<br>Total Cost ".$totalOrderCost;
                
                // Total Sale Price
                $pricePerSqFt = $totalOrderCost*1.5;
                $console .= "<br>Total Price ".$pricePerSqFt;
                if ($totalSqFtSlab == 0) {
                    $totalOrderCost = 0.00;
                    $pricePerSqFt = 0.00;
                }

            }else if ($styleId =='3' || $styleId =='4') {

                $totalOrderCost = $rowData['item_cost'] * $slabQty;
                $pricePerSqFt   = $totalOrderCost * 1.5; 
            }


            if ( isset($change_cost) ) {
                $totalOrderCost = $totalOrderCost+$change_cost;
            }

            if ( isset($change_price) ) {
                $pricePerSqFt = $pricePerSqFt+$change_price;
            }

            $calcPerc = $this->calcuatePercentage($pricePerSqFt,$totalOrderCost);

            $retData = array(
                'console' => $console,
                'cost_price' => decimalValue($totalOrderCost),
                'sale_price' => decimalValue($pricePerSqFt),
                'percent'    => decimalValue($calcPerc),
                'test_qty'   => decimalValue($slabQty),
                'test_totalSlabs' => decimalValue($totalSqFtSlab),
                'test_itemCost'    => decimalValue($itemCostSqFt),
                'test_totalSlabCost'    => decimalValue($totalSlabCost),
                'test_fabricationCost'    => decimalValue($fabCost),
                'test_totalFabricationCost'    => decimalValue($totalFabCost),
                'test_totalCostTed'    => decimalValue($totalOrderCost),
                'test_totalSaleTed'    => decimalValue($pricePerSqFt),
            );
            echo json_encode($retData);
        }
    }

    function calcuatePercentage($netTotal,$costPrice){
        if($costPrice == 0){
            return '100.00';
        }
        return decimalValue( ( ($netTotal-$costPrice) / $costPrice ) *100);
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
                'taxValue'           => decimalValue($tax_price),
                'perAmt'             => decimalValue($perAmt),               
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

    function PoMSI(){
        $data = array();
        $id = $this->uri->segment(4);

        $data['edit_order']   = $this->fab_model->getFabOrder($id);
        $data['fab_products'] = $this->fab_model->getFabProdyctByOrderId($id);
        $data['my_vendor']    = $this->fab_model->findWhere( 'vendor', array( 'id' => 7 ), FALSE, array( '*' ) );
        $this->template->title('Fab Edit');
        $this->template
                ->set_layout('inner')
                ->build('fab_orders/po_msi', $data);
    }

    function PoAAY(){
        $data = array();
        $id = $this->uri->segment(4);

        $data['edit_order']   = $this->fab_model->getFabOrder($id);
        $data['fab_products'] = $this->fab_model->getFabProdyctByOrderId($id);
        $data['my_vendor']    = $this->fab_model->findWhere( 'vendor', array( 'id' => 2 ), FALSE, array( '*' ) );

        $this->template->title('Fab Edit');
        $this->template
                ->set_layout('inner')
                ->build('fab_orders/po_aay', $data);
    }

    function Quote($id)
    {
        $id   = $this->uri->segment(4);
        $data = array();

        $data['edit_order']   = $this->fab_model->getFabOrder($id);
        $data['fab_products'] = $this->fab_model->getFabProdyctByOrderId($id);        

        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('fab_orders/quote', $data);        

    }

    function Contract($id)
    {   
        $id   = $this->uri->segment(4);
        $data = array();

        $data['edit_order']   = $this->fab_model->getFabOrder($id);
        $data['fab_products'] = $this->fab_model->getFabProdyctByOrderId($id);
        $data['controllerThis'] = $this; 
        
        $this->load->view('index', $data);
        $this->template->title('Order View');
        $this->template
                ->set_layout('inner')
                ->build('fab_orders/contract', $data);        

    }

    function load_script()
    {
        $data = array();
        $this->load->view('fab_orders/load_script', $data);
    }

    function load_css()
    {
        $data = array();
        $this->load->view('fab_orders/load_css', $data);
    }
}