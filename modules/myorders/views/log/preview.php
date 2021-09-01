<style>
    .content-page {
        margin-left: 0px !important;
    }   
</style>
<div class="content-pageee">
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>order">Order</a></li>
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
                    <ul class="overview_list" id="">
                        <a href="<?php echo base_url(); ?>orders/logs/<?php echo $order_data['id']; ?>" class="btn btn-danger waves-effect waves-light" >Back</a>
                    <?php // echo modules::run('includes/order_sub_menu');?>
                    </ul>
                    <div class="clear"></div>
                    <div class="dashboard_info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Dashboard</header>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['status']; ?></span>
                                            <span class="text-muted">Status</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['sales_primary']; ?></span>
                                            <span class="text-muted">Sale Primary</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['sales_secondary']; ?></span>
                                            <span class="text-muted">Sales - Secondary</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['vendor_invoice']; ?></span>
                                            <span class="text-muted">Vendor</span>  
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
                                                <?php $ttl_due = ucfirst( $order_data['total_due']); echo (!$ttl_due) ? '00' : '$'.$ttl_due; ?>&nbsp; 
                                                <label for="Item_Name" class="col-form-label" >
                                                    Paid &nbsp <?php $paid = ucfirst( $order_data['paid']); echo (!$paid) ? '00' : '$'.$paid; ?>
                                                </label> &nbsp; 
                                                <label for="Item_Name" class="col-form-label" >
                                                    Refunded &nbsp <? $ref= ucfirst( $order_data['refunded']); echo (!$ref) ? '00' : '$'.$ref; ?>
                                                </label>
                                            </span>
                                            <span class="text-muted">Total Due</span>  
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
                            </div>
                        </div>
                    </div><!--  .dashboard_info ends -->

                    <div class="product_info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Product</header>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                 <div class="table-responsive mt-4 table_append">
                                  <table class="table table-bordered table-centered mb-0">
                                      <thead>
                                          <tr>
                                            <th>Quantity</th>
                                            <th>Item</th>
                                            <th>Doorstyle</th>
                                            <th>Description</th>
                                            <th>Cost</th>
                                            <th>Price</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        <?php 

                                          if ( !empty( $product_data ) ) {
                                            $i = 0;
                                                foreach ($product_data as $Key => $value) { 
                                                  ?>
                                                 <tr>
                                                <td>
                                                  <input type='text' class='form-control qty' style='width:70px;' value='<?= $value['qty']; ?>' >
                                                </td>
                                                <td><input type="text" name="product[<?= $i; ?>][Item_code]" value="<?= $value['Item_code']; ?>" class='form-control'></td>
                                                <td><input type='text' class='form-control product_style' name='product[<?= $i; ?>][style_id]' value='<?= $value['style_id']; ?>'>
                                                </td>
                                                <td><input type="text" name='product[<?= $i; ?>][description]' 
                                                      value="<?= $value['description']; ?>" class="form-control"><br>
                                                      <input type="text" name='product[<?= $i; ?>][descriptionII]' 
                                                      value="<?= $value['descriptionII']; ?>" class="form-control">
                                                </td>
                                                <td><input type="text" class="form-control Productprice" id='Productprice<?= $i; ?>' name='product[<?= $i; ?>][price]' 
                                                      value="<?= $value['price']; ?>" data-price='<?= $value['price']; ?>' >
                                                      <br>
                                                      <input type="text" class="form-control aftercharge" name='product[<?= $i; ?>][aftercharge]' 
                                                      value="<?= $value['u_price']; ?>" id="aftercharge<?= $i; ?>">
                                                </td>
                                                <td><input class='form-control aftercharge' name='product[<?= $i; ?>][aftertotal]' id='aftercharge<?= $i; ?>' value='<?= $value['total_price']; ?>' data-price='<?= $value['total_price']/$value['qty'] ?>'></td>
                                              </tr>
                                          <?php $i++;  }
                                          } else { ?>
                                             
                                             <tr class="removetr">
                                                 <td colspan="7" style="text-align:center;">No Products</td>
                                             </tr> 
                                             
                                    <?php }
                                        ?>
                                      </tbody>
                                  </table>
                                </div>                                             
                            </div>
                        </div>

                    </div><!--  .product_info  ends -->

                    <div class="payment_info">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="additional_list">
                                    <header class="panel-heading">Order Payment</header>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['total']; ?></span>
                                            <span class="text-muted">Total</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['paid']; ?></span>
                                            <span class="text-muted">Paid</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['amount_spent']; ?></span>
                                            <span class="text-muted">Amount Spent</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['refunded']; ?></span>
                                            <span class="text-muted">Refunded</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['discount']; ?></span>
                                            <span class="text-muted">Discount ( % )</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['texes_multiplier']; ?></span>
                                            <span class="text-muted">Taxes Multiplier ( % )</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?= $order_data['total_due']; ?></span>
                                            <span class="text-muted">Total Due</span>  
                                        </li>
                                    </ul>
                                </div>                                                
                            </div>
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

                                        $expImg =  explode( ',',$file['file_name']);
                                    ?>
                                        
                                    <ul class="list-group no-radius">
                                        <?php
                                        foreach ($expImg as $keys => $values) {
                                         
                                         $againexp = explode( '__',$values);
                                         
                                            if ( in_array( "floor_plan", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != 'floor_plan' ) { ?>
                                                    <li class="list-group-item">
                                                        <span class="pull-right"><?= $florValue; ?></span>
                                                        <span class="text-muted">Floor plan</span>  
                                                    </li>
                                                <?php
                                                    }
                                                }
                                            } 
                                            
                                            if ( in_array( "3d_views", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != '3d_views' ) { ?>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?= $florValue; ?></span>
                                                            <span class="text-muted">3D Views</span>  
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                            } 
                                            
                                            if ( in_array( "walk_through_form", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != 'walk_through_form' ) { ?>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?= $florValue; ?></span>
                                                            <span class="text-muted">Walk Through Form</span>  
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                            } 
                                            
                                            if ( in_array( "signed_contracts", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != 'signed_contracts' ) { ?>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?= $florValue; ?></span>
                                                            <span class="text-muted">Signed Contracts</span>  
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                            } 
                                            
                                            if ( in_array( "st3_form", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != 'st3_form' ) { ?>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?= $order_data['paid']; ?></span>
                                                            <span class="text-muted">ST3 Form</span>  
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                            } 
                                            
                                            if ( in_array( "st8_form", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != 'st8_form' ) { ?>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?= $order_data['paid']; ?></span>
                                                            <span class="text-muted">ST8 Form</span>  
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                            } 
                                            
                                            if ( in_array( "receipts", $againexp ) ) {
                                                foreach( $againexp as $florValue ){
                                                    if( $florValue != 'receipts' ) { ?>
                                                        <li class="list-group-item">
                                                            <span class="pull-right"><?= $order_data['paid']; ?></span>
                                                            <span class="text-muted">Receipts</span>  
                                                        </li>
                                                    <?php
                                                    }
                                                }
                                            } 
                                        } 
                                        ?>
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