<?php
	$id = $orderID;

    $activeMenus = $this->router->fetch_method();

    $controlerName = array( 'TsgOrders','FabOrders',
                            'jkOrders','cncOrders',
                            'wcOrders','tknobsOrders',
                            'msiTileOrders','AsfgOrders','centuryOrders' );
    $cName = $this->uri->segment(2);
    if ( in_array($cName, $controlerName) ) {
        $activeMenu = $this->uri->segment(3);
    }else{
        $activeMenu = $this->uri->segment(2);
    }

    $order = $orderedit = $payment = $expenses  = $view_po = $print_po = $files = $emails = $logs = '' ;
    if( $activeMenu == 'Dashboard' ){
        $order = 'active';
    }
    elseif($activeMenu == 'edit'){
        $orderproduct = 'active';
    }
    elseif($activeMenu == 'payment'){
        $payment = 'active';
    }
    elseif($activeMenu == 'expenses'){
        $expenses = 'active';
    }
    elseif($activeMenu == 'files'){
        $files = 'active';
    }
    elseif($activeMenu == 'emails'){
        $emails = 'active';
    }
    elseif($activeMenu == 'quote'){
        $quote = 'active';
    }
    elseif($activeMenu == 'contract'){
        $contract = 'active';
    }
    elseif($activeMenu == 'purchase_order'){
        $purchase_order = 'active';
    }
    elseif($activeMenu == 'logs'){
        $logs = 'active';
    }
    else{
        $order = 'active';
    } 

    $quoteurl = 'orders/quote/'; 
    $contracturl = 'orders/contract/'; 
    $po = 'Purchase Order'; 
    $poURL = 'orders/purchase_order/';

    if( $vendorId['vendor'] == 2 ){ 
        $edit = 'orders/FabOrders/edit/';
        $quoteurl = 'orders/FabOrders/quote/'; 
        $contracturl = 'orders/FabOrders/contract/';
        $po = 'PoMSI';
        $poURL = 'orders/FabOrders/PoMsi/';

    }else if( $vendorId['vendor'] == 1 ){ 
        $edit = 'orders/TsgOrders/edit/';
        $quoteurl = 'orders/TsgOrders/quote/'; 
        $poURL = 'orders/TsgOrders/purchase_order/';
        $contracturl = 'orders/TsgOrders/contract/';
    }else if( $vendorId['vendor'] == 3 ){ 
        $edit = 'orders/jkOrders/edit/';
        $quoteurl = 'orders/jkOrders/quote/'; 
        $poURL = 'orders/jkOrders/purchase_order/';
        $contracturl = 'orders/jkOrders/contract/';
    }else if( $vendorId['vendor'] == 4 ){ 
        $edit = 'orders/cncOrders/edit/';
        $quoteurl = 'orders/cncOrders/quote/'; 
        $poURL = 'orders/cncOrders/purchase_order/';
        $contracturl = 'orders/cncOrders/contract/';
    }else if( $vendorId['vendor'] == 5 ){ 
        $edit = 'orders/wcOrders/edit/';
        $quoteurl = 'orders/wcOrders/quote/'; 
        $poURL = 'orders/wcOrders/purchase_order/';
        $contracturl = 'orders/wcOrders/contract/';

    }else if( $vendorId['vendor'] == 6 ){ 
        $edit = 'orders/tknobsOrders/edit/';
        $quoteurl = 'orders/tknobsOrders/quote/'; 
        $poURL = 'orders/tknobsOrders/purchase_order/';
        $contracturl = 'orders/tknobsOrders/contract/';
    }else if( $vendorId['vendor'] == 8 ){ 
        $edit = 'orders/AsfgOrders/edit/';
        $quoteurl = 'orders/AsfgOrders/quote/'; 
        $poURL = 'orders/AsfgOrders/purchase_order/';
        $contracturl = 'orders/AsfgOrders/contract/'; 
    }else if( $vendorId['vendor'] == 7 ){ 
        $edit = 'orders/msiTileOrders/edit/';
        $quoteurl = 'orders/msiTileOrders/quote/'; 
        $poURL = 'orders/msiTileOrders/purchase_order/';
        $contracturl = 'orders/msiTileOrders/contract/'; 
    }else if( $vendorId['vendor'] == 9 ){ 
        $edit = 'orders/centuryOrders/edit/';
        $quoteurl = 'orders/centuryOrders/quote/'; 
        $poURL = 'orders/centuryOrders/purchase_order/';
        $contracturl = 'orders/centuryOrders/contract/'; 
    }else{ 
        $edit = 'orders/TsgOrders/edit/';

    }

    ?>
    <li class="<?php echo $order;?>"><a href="<?php echo base_url()?>orders/Dashboard/<?php echo $id; ?>">Order</a></li>
    <li class="<?php echo $orderproduct;?>"><a href="<?php echo base_url().$edit.$id; ?>">Edit</a></li>
    <li class="<?php echo $payment;?>"><a href="<?php echo base_url()?>orders/payment/<?php echo $id; ?>">Payment</a></li>
    <li class="<?php echo $expenses;?>"><a href="<?php echo base_url()?>orders/expenses/<?php echo $id; ?>">Expenses</a></li>
    <li class="<?php echo $quote;?>"><a href="<?php echo base_url().$quoteurl.$id; ?>">Quote</a></li>
    <li class="<?php echo $contract;?>"><a href="<?php echo base_url().$contracturl.$id; ?>">Contract</a></li>
    <li class="<?php echo $purchase_order;?>"><a href="<?php echo base_url().$poURL.$id; ?>"><?php echo $po ?></a></li>
    <?php if( $vendorId['vendor'] == 2 ){  ?>
        <li class="<?php echo $PoAay;?>"><a href="<?php echo base_url().'orders/FabOrders/PoAay/'.$id; ?>">PO AAY</a></li>
    <?php }?>
    <li class="<?php echo $files;?>"><a href="<?php echo base_url()?>orders/files/<?php echo $id; ?>">Files</a></li>
    <li class="<?php echo $emails;?>"><a href="<?php echo base_url()?>orders/emails/<?php echo $id; ?>">Emails</a></li>
    <li class="<?php echo $logs;?>"><a href="<?php echo base_url()?>orders/logs/<?php echo $id; ?>">Logs</a></li>
    <?php $oData = getOrderMeta($id); ?>
    <li style="/*float:right;*/"><a href="<?php echo base_url();?>customer/order/<?php echo $oData->customer_id; ?>">Add New Order</a></li>
