<style>
    .content-page {
        margin-left: 0px !important;
    }
    a#restoreOrder {
        margin-left: 20px;
    }
</style>
<script>
    jQuery(document).on('click','#restoreOrder',function(e){
        var ids = jQuery(this).attr("ids");
        var order_id = jQuery(this).attr("data-order");
        swal({
            title: "Are you sure?",
            text: "You want to restore, Any changes after it will be lost!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            showLoaderOnConfirm: true
            })
        .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: "<?php echo site_url('orders/restore_order')?>",
                        data: { ids: ids },
                        method: 'POST',
                        error: function(data){ console.log(data); },
                        success: function(res){
                            if(res == "TRUE"){
                                swal("Restored!", "You clicked the button!", "success").then(function(){ 
                                       var url = <?php echo "'".base_url()."'"; ?>+"orders/dashboard/"+order_id;
                                       window.location.replace(url);
                                       }
                                    );
                           
                            } else {
                                swal('Oops...', 'Something went wrong with ajax !', 'error');
                            }
                        },
                    })
                }
        });
    });
</script>
<?php $logId = $this->uri->segment(3); ?>
<div class="content-pageee">
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>orders">Orders</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>orders/logs/<?php echo $order_data['id']; ?>">Logs</a></li>
                     <li class="breadcrumb-item active">Order Preview</li>
                  </ol>
               </div>
               <h4 class="page-title">Log Preview</h4>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                    <a href="<?php echo base_url(); ?>orders/logs/<?php echo $order_data['id']; ?>" class="btn btn-danger waves-effect waves-light" >Back</a>

                    <a href="javascript:void(0);" title="Restore" id="restoreOrder" class="btn btn-success waves-effect waves-light" data-order="<?php echo $order_data['id']; ?>" ids="<?php echo $logId; ?>"><i class="fa fa-undo"></i> Restore </a>

                    <div class="clear"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dashboard_info">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Dashboard</header>
                                </div>
                            </div>
                            <div class="additional_list">
                                <ul class="list-group no-radius">
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= $order_data['status']; ?></span>
                                        <span class="text-muted">Status</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= get_field('user_profiles',array('id' => $order_data['sales_primary']),'name') ?></span>
                                        <span class="text-muted">Sale Primary</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= get_field('user_profiles',array('id' => $order_data['sales_secondary']),'name') ?></span>
                                        <span class="text-muted">Sales - Secondary</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?php echo get_field('vendor',array('id' => $order_data['vendor']),'name'); ?></span>
                                        <span class="text-muted">Vendor</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= $order_data['vendor_invoice']; ?></span>
                                        <span class="text-muted">Invoice #</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['is_pickup']); ?></span>
                                        <span class="text-muted">Is Pickup</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['resale_certificate']); ?></span>
                                        <span class="text-muted">Has a Resale Certificate</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?php $tax = ucfirst( $order_data['texes_multiplier']); echo (!$tax) ? '00' : '$'.$tax; ?></span>
                                        <span class="text-muted">Taxes Multiplier ( % )</span>  
                                    </li>
                                
                                    <li class="list-group-item">
                                        <span class="pull-right"><?php $ttl = ucfirst( $order_data['total']); echo (!$ttl) ? '00' : '$'.$ttl; ?></span>
                                        <span class="text-muted">Total</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right">
                                            <?php $paid = ucfirst( $order_data['paid']); echo (!$paid) ? '00' : '$'.$paid; ?> 
                                        </span>
                                        <span class="text-muted">Total Paid</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?php $aspend = ucfirst( $order_data['amount_spent']); echo (!$aspend) ? '00' : '$'.$ref; ?></span>
                                        <span class="text-muted">Amount Spent</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['first_name']); ?></span>
                                        <span class="text-muted">First Name</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['last_name']); ?></span>
                                        <span class="text-muted">Last Name</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right">
                                            <?= ucfirst( $order_data['requested_delivery_date']); ?>
                                        </span>
                                        <span class="text-muted">Requested Delivery Date</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right">
                                            <?= ucfirst( $order_data['requested_date_notes']); ?>
                                        </span>
                                        <span class="text-muted">Requested Delivery Date Notes</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['hard_date']); ?></span>
                                        <span class="text-muted">Hard Date</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right">
                                            <?= ucfirst( $order_data['estimated_delivery_date']); ?> 
                                        </span>
                                        <span class="text-muted">Estimated Delivery Date</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right">
                                            <?= ucfirst( $order_data['estimated_date_notes']); ?>
                                        </span>
                                        <span class="text-muted">Estimated Delivery Date Notes</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right">
                                            <?= ucfirst( $order_data['schedule_delivery_date']); ?> 
                                        </span>
                                        <span class="text-muted">Scheduled Delivery Date</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['survey']); ?></span>
                                        <span class="text-muted">Survey</span>  
                                    </li>
                                    <li class="list-group-item">
                                        <span class="pull-right"><?= ucfirst( $order_data['survey_date']); ?></span>
                                        <span class="text-muted">Survey Date</span>  
                                    </li>
                                </ul>
                            </div>                                                
                        </div><!--  .dashboard_info ends -->
                        <div class="col-md-6">
                            <div class="product_info">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Product</header>
                                </div>
                                <div class="additional_list">
                                    <?php  if( !empty($product_order) ){  ?>
                                        <table id="DataTable scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                            <thead>
                                                <tr>
                                                    <th>Quantity</th>
                                                    <th>Style/Item</th>
                                                    <th>Total </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($product_order as $key => $value) {
                                               $style_code = $obj->getStyleName($value['style_id']);  ?>
                                                    <tr>
                                                        <td><?= $value['qty'] ?></td>
                                                        
                                                        <td>
                                                            <?php 
                                                            echo $style_code.'/';
                                                            if( isset($value['Item_code']) ){
                                                                echo $value['Item_code'];   
                                                            }else{
                                                                echo $value['item_code'];   
                                                            }
                                                            ?>
                                                            
                                                        </td>

                                                        <td style="vertical-align : middle;" ><?= '$'.number_format($value['total_price'],2); //get_field('pk_order', array('id' => $value['order_id']), 'total')?></td>
                                                    </tr>
                                            <?php  }  
                                                if( !empty($product_order_child) ){ 
                                                    foreach ($product_order_child as $key => $value) { 
                                                        $style_code = $obj->getStyleName($value['style_id']); ?>
                                                    <tr>
                                                        <td><?= $value['qty'] ?></td>
                                                        <td><?= $style_code; ?>/
                                                            <?= get_field('pk_product', array('id' => $value['product_id']), 'Item_Name')?></td>
                                                            <td><?= '$'.number_format($value['total_price'],2); //get_field('pk_order', array('id' => $value['order_id']), 'total')?></td>
                                                    </tr>
                                            <?php  }
                                                }
                                                if( !empty($product_order_sub_child) ){ 
                                                    foreach ($product_order_sub_child as $key => $value) { ?>
                                                    <tr>
                                                        <td><?= $value['qty'] ?></td>
                                                        <td><?php 
                                                                $pro_order_id = get_field('product_order_child', array('id' => $value['pro_order_id']), 'pro_order_id');
                                                                echo $obj->getStyleName($value['style']);
                                                            ?>/<?= get_field('pk_product', array('id' => $value['product_id']), 'Item_Name')?></td>
                                                            <td><?= '$'.number_format($value['total_price'],2); //get_field('pk_order', array('id' => $value['order_id']), 'total')?></td>
                                                    </tr>
                                            <?php  }
                                                } 
                                            ?>
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                      
                                </div>
                            </div><!--  .product_info  ends -->
                        </div>
                    </div>
                    <div class="payment_info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Payment</header>
                                </div>
                            </div>
                        </div>
                        <div class="additional_list">
                             <?php
                           if( !empty($payment_data) ){ 
                        ?>
                        <div class="additional_list">
                            <table id="DataTable scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Payment Type</th>
                                       <th>Payment Amount</th>
                                       <th>Payment Reference Number</th>
                                       <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                       $i = 1;
                                       foreach ($payment_data as $key => $value) { 
                                          $catogery = unserialize( $value['category_meta'] ); ?>
                                          <tr>
                                             <td><?= $i; ?></td>
                                             <td><?= $value['payment_method']; ?></td>
                                             <td><?= $value['payment_amount']; ?></td>
                                             <td><?= $value['reference_no']; ?></td>
                                             <td><?php $timestamp = strtotime($value['created_date']);
                                                      echo $newDate = date('m-d-Y h:i a', $timestamp);
                                                 ?>
                                             </td>
                                          </tr>
                                        <?php $i++;  
                                       } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                        </div>                                                
                            
                    </div><!--  .payment_info  ends -->

                    <div class="expenses_info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Expenses</header>
                                </div>
                            </div>
                        </div>
                        <?php
                           if( !empty($expenses_data) ){ 
                        ?>
                        <div class="additional_list">
                            <table id="DataTable scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                <thead>
                                    <tr>
                                       <th>#</th>
                                       <th>Payee</th>
                                       <th>Payment Date</th>
                                       <th>Payment Method</th>
                                       <th>Total</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                    <?php
                                       $i = 1;
                                       foreach ($expenses_data as $key => $value) { 
                                          $catogery = unserialize( $value['category_meta'] );
                                           ?>
                                          <tr>
                                             <td><?= $i; ?></td>
                                             <td><?= ucfirst($value['payee']); ?></td>
                                             <td><?= $value['payment_date']; ?></td>
                                             <td><?= ucfirst($value['payment_method']); ?></td>
                                             <td><?= '$'.$value['total']; ?></td>
                                          </tr>
                                    <?php
                                       $i++;  
                                       }

                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?>
                    </div><!--  .expenses_info  ends -->

                    <div class="files_info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Files</header>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="additional_list">
                                    <?php
                                        foreach ($files_data AS $file) {
                                        $expImg =  explode( ',',$file['file_name']); ?>
                                        <ul class="list-group no-radius">
                                            <?php
                                            foreach ($expImg as $keys => $values) {
                                             
                                                $fileLink = '<a target="_blank" href="'.base_url().'assets/leadsfiles/'.$values.'">'.$values.'</a>';
                                             
                                                $againexp = explode( '__',$values);
                                                $fLabel = ucfirst( str_replace('_', ' ' , $againexp[0]) );
                                                ?>
                                                <li class="list-group-item">
                                                    <span class="text-muted"><?php echo $fLabel; ?></span>
                                                    <span class="pull-right"><?php echo $fileLink; ?></span>
                                                </li> 
                                            <?php } ?>
                                        </ul>
                                <?php } ?>
                                </div>                                                
                            </div>
                        </div>
                    </div><!--  .files_info  ends -->

               </div>
            </div>
         </div>
      </div>
   </div>
</div>