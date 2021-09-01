<?php
    
    if( $this->uri->segment(2) == 'FabOrders' ){
        $ids = $this->uri->segment(4); 
    }else{
        $ids = $this->uri->segment(3); 
    }
    $activeMenu = $this->uri->segment(3);
    $activeMenus = $this->router->fetch_method(); 
    $order = $orderedit = $payment = $expenses  = $view_po = $files = $emails = $logs = $PoMsi = $PoAay = $quote = $contract = '' ;
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
    elseif($activeMenu == 'logs'){
        $logs = 'active';
    }
    elseif($activeMenu == 'PoMsi'){
        $PoMsi = 'active';
    }
    elseif($activeMenu == 'PoAay'){
        $PoAay = 'active';
    }
    elseif($activeMenu == 'quote'){
        $quote = 'active';
    }
    elseif($activeMenu == 'contract'){
        $contract = 'active';
    }
    else{
        $order = 'active';
    } 
?>
    <li class="<?php echo $order;?>"><a href="<?php echo base_url()?>orders/Dashboard/<?php echo $ids; ?>">Order</a></li>
    <li class="<?php echo $orderproduct;?>"><a href="<?php echo base_url().'orders/FabOrders/edit/'.$ids; ?>">Edit</a></li>
    <li class="<?php echo $payment;?>"><a href="<?php echo base_url()?>orders/payment/<?php echo $ids; ?>">Payment</a></li>
    <li class="<?php echo $expenses;?>"><a href="<?php echo base_url()?>orders/expenses/<?php echo $ids; ?>">Expenses</a></li>
     <li class="<?php echo $quote;?>"><a href="<?php echo base_url()?>orders/FabOrders/quote/<?php echo $ids; ?>">Quote</a></li>
    <li class="<?php echo $contract;?>"><a href="<?php echo base_url()?>orders/FabOrders/contract/<?php echo $ids; ?>">Contract</a></li>
    <li class="<?php echo $PoMsi;?>"><a href="<?php echo base_url()?>orders/FabOrders/PoMsi/<?php echo $ids; ?>">PO MSI</a></li>
    <li class="<?php echo $PoAay;?>"><a href="<?php echo base_url()?>orders/FabOrders/PoAay/<?php echo $ids; ?>">PO AAY</a></li>
    <li class="<?php echo $files;?>"><a href="<?php echo base_url()?>orders/files/<?php echo $ids; ?>">Files</a></li>
    <li class="<?php echo $emails;?>"><a href="<?php echo base_url()?>orders/emails/<?php echo $ids; ?>">Emails</a></li>
    <li class="<?php echo $logs;?>"><a href="<?php echo base_url()?>orders/logs/<?php echo $ids; ?>">Logs</a></li>
    <?php $oData = getOrderMeta($ids); ?>
    <li style="/*float:right;*/"><a href="<?php echo base_url();?>customer/order/<?php echo $oData->customer_id; ?>">Add New Order</a></li>
