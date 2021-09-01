<style type="text/css">

.float-right.print_button h4 {
       float: right;
       margin-top: 7px !important;
   }
   .float-right.print_button {
    width: 221px;
    }
   .card-box{
   float:left;
   }
   div.pdf_footer {
       /*position: running(pdf_footer);*/
       position: fixed; 
       width: 100%; 
       bottom: 0px; 
       left: 0;
       right: 0;
       display: none;
       padding-left: 70px;
       padding-top: 30px;
       color: #ccc;
   }
    .pdf_footer, .page-footer-space {
        height: 160px;
    }
   .container-fluid {
     page-break-after: always;
   }

  div.pdf_footer p{
   margin-bottom: 5px;
   margin-left: 0px;
   }
   .textright{
   text-align: right;
   }
@media print {
       #lead_sub_menu, .text-right *{
       display: none !important;
       } 
       #print_btn{
       display: none !important;
       }

        .logo-print{
          margin-bottom: 1em;
        }

       div.pdf_footer{
         /*border-top: 2px solid #343a40;
         border-bottom: 2px solid #343a40;*/
         display:table-footer-group;
       }
       thead {display: table-header-group;} 
       tfoot {display: table-footer-group;}
    }
   @page {
      margin: 10mm
    }
</style>

<table class="col-md-12">
    <thead><tr><td></td></tr></thead>
    <tbody>
      <tr>
        <td>
<div class="content">
   <!-- Start Content-->
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$order_view['customer_id']; ?>"><?= $order_view['first_name']; ?> <?= $order_view['last_name']; ?></a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$this->uri->segment(3); ?>">Order For <?= $order_view['first_name']; ?> <?= $order_view['last_name']; ?></a></li>
                     <li class="breadcrumb-item">Purchase Order</li>
                  </ol>
               </div>
               <h4 class="page-title">Purchase Order</h4>
            </div>
         </div>
      </div>
      <!-- end page title --> 
      <div class="row">
         <div class="col-12">
            <div class="card-box col-md-12">
               <ul class="overview_list" id="lead_sub_menu" class="lead_sub_menu">
                  <?php  echo modules::run('includes/order_sub_menu');?>
               </ul>
               <div class="clear"></div>
               <br>
               <div class="clearfix">
                  <div class="float-left logo-print">
                     <img src="https://perfectionkitchens.com/wp-content/uploads/2019/04/logo-1.png" width="150">
                  </div>
                  <div class="float-right print_button">
                      <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light" id="print_btn"><i class="mdi mdi-printer mr-1"></i> Print</a>
                     <h4 class="m-0">Purchase Order</h4>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="mt-3">
                        <div class="topaddr">
                          <p><label>Web</label> <span> : PerfectionKitchens.com</span></p>
                          <p style="margin-bottom: -10px;"><label>Address</label><span> : 1174 Fischer Blvd.</span></p>
                          <p><label></label><span> &nbsp;&nbsp;River, NJ 08753</span></p>
                          <p><label>Email</label><span> : orders@perfectionkitchens.com</span></p>
                          <p><label>Phone</label><span> : (732) 270-9300</span></p>
                        </div>
                     </div>
                  </div>
                  <!-- end col -->
                  <div class="col-md-4 offset-md-2">
                     <div class="mt-3 float-right">
                        <div class="mt-3-print">
                          <?php $data = date('F j, Y',strtotime($order_view['created'])); ?>
                          <p class="m-b-10"><strong>Order Date : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; <?= $data ?></span></p>
                          <p class="m-b-10"><strong>Order No. : </strong> <span class="float-right"><?= $order_view['id']; ?> </span></p>
                        </div>
                     </div>
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
               <?php
                  //$customer= $this->order_model->findWhere( 'customer', array( 'id' => $order_view['customer_id'] ), FALSE, array( '*' ) );
                
                    $this->db->select('*');
                    $this->db->from('customer');
                    $this->db->join('customer_address', 'customer.id = customer_address.customer_id');
                    $this->db->where('customer.id', $order_view['customer_id']);
                    $get =$query = $this->db->get();
                    $cdata = $get->result('array');
                    $bill = array_search('Billing', array_column($cdata, 'address_type'));
                    $ship = array_search('Shipping', array_column($cdata, 'address_type'));
                    ?>
                  <div class="row mt-3">
                  <div class="col-sm-6">
                     <h4>To <?= '<b>'.$my_vendor['name']."</b>"; ?></h4>
                     <?php 
                        $errorAddr = '';
                        if( isset($my_vendor) ){    
                                echo '<b>Email : </b>'.$my_vendor['email']."<br>";
                                echo '<b>Address : </b>'.$my_vendor['address'].'<br>';
                                echo '<b>Phone : </b>'.$my_vendor['phone'];
                        }else{
                            $errorAddr = "No address found";
                        }
                        echo $errorAddr;
                     ?>
                  </div>
                  <!-- end col -->
                  <div class="col-sm-6">
                     <?php if ($order_view['is_pickup'] != 'yes' && $order_view['is_pickup'] != 'mf') { ?>
                     <h4>Delivery</h4>
                        <address>
                            <?php 
                            $errorAddr = '';
                            if( isset($cdata[$ship]) ){
                                if( in_array('Shipping', array_column( $cdata, 'address_type') ) ){
                                  echo '<b>Name : </b>'.$cdata[$ship]['full_name']."<br>";
                                  echo '<b>Address : </b>';
                                  if($cdata[$ship]['addressline_one']) echo $cdata[$ship]['addressline_one'].", ";
                                  if($cdata[$ship]['addressline_two']) echo $cdata[$ship]['addressline_two'];
                                  echo "<br>";
                                  echo '<b>City : </b>'.$cdata[$ship]['city']."<br>";
                                  echo '<b>State : </b>'.$cdata[$ship]['state']."<br>";
                                  echo '<b>ZIP : </b>'.$cdata[$ship]['zipcode']."<br>";
                                  echo '<b>Phone : </b>'.$cdata[$ship]['phone'];
                                }else{
                                    $errorAddr = "No address found";
                                }
                            }else{
                                $errorAddr = "No address found";
                            }
                             echo $errorAddr;
                         ?>
                     </address>
                   <?php }elseif ($order_view['is_pickup'] == 'yes') { ?>
                        <h4>Showroom</h4>
                        <address>
                                <?php
                                  echo '<b>PerfectionKitchens</b><br>';
                                  echo '<b>Address : 1174 Fischer Blvd. River, NJ 08753</b>';
                                  echo "<br>";
                                  echo '<b>Phone : </b>(732) 270-9300'; ?>

                        </address>
                   <?php } else { echo "<h5>Pick Up / No Delivery</h5>"; } ?>
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
                <div class="row">
                  <div class="col-12">
                     <div class="table-responsive">
                        <table class="table mt-4 table-bordered table-centered">
                           <thead>
                              <tr>
                                 <th>Item</th>
                                 <th>Style</th>
                                 <th>Quantity</th>
                                 <th style="width: 10%">Description</th>
                                 <th class="text-right">Price</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ( !empty($pro_view) ) {
                                     $sum = 0;
                                     $sum2 = 0; 
                                     $subPrice = array();
                                     $parentPrice = array();
                                       foreach ($pro_view as $key => $value) {
                                        /*pr( $value );*/
                                        $width='';if( !empty( $value->Width ) && ( $value->Width !='NA' ) )$width=$value->Width.'W x ';
                                        $height='';if(!empty( $value->Height ) && ( $value->Height !='NA' ) )$height=$value->Height.'W x ';
                                        $depth='';if(!empty( $value->Depth ) && ( $value->Depth !='NA' ) )$depth=$value->Depth.'D';

                                        if( $order_view['assemble_value'] == 1 ){
                                          
                                          $ted_price = $value->item_cost;
                                          $cust_price = $value->unassembled_retail_item_price;
                                        }else{
                                          
                                            $ted_price = $value->cabinet_assembly_price;
                                            $cust_price = $value->assembled_retail_item_price;
                                        }


                                        ?>
                                        <tr>
                                           <td width="15%"><b><?= $value->Item_code; ?></b></td>
                                           <td width="10%"><b><?= $value->style_code; ?></b></td>
                                           <td width="10%"><b><?= $value->qty; ?></b></td>
                                           <td width="40%"><b><?= $value->item_descriptionII.' '.$width.$height.$depth; ?></b></td>
                                           <td width="20%" class="textright"><b>$<?= number_format($ted_price,2); ?></b></td>
                                        </tr>
                                          <?php if ( !empty($product_order_child) ) {
                                                   foreach ($product_order_child as $key => $values) {
                                                      //pr( $values );
                                                    if( $value->pkid == $values['pro_parent_id']  ){ 
                                                $widthchild='';
                                                if( !empty( $values['Width'] ) && ( $values['Width'] !='NA' ) )$widthchild=$values['Width'].'W x ';
                                              $heightchild='';
                                              if(!empty( $values['Height'] ) && ( $values['Height'] !='NA' ) )$heightchild=$values['Height'].'W x ';
                                                $depthchild='';
                                                if(!empty( $values['Depth'] ) && ( $values['Depth'] !='NA' ) )$depthchild=$values['Depth'].'D';
                                                if( $order_view['assemble_value'] == 1 ){
                                                    $ted_pricec = $values['item_cost'];
                                                    $cust_pricec = $values['unassembled_retail_item_price'];
                                                }else{
                                                    $ted_pricec = $values['cabinet_assembly_price'];
                                                    $cust_pricec = $values['assembled_retail_item_price'];
                                                }

                                               ?>
                                                  <tr>
                                                     <td><b> * <?= $values['Item_Code']; ?></b></td>
                                                     <td><b><?= $value->style_code; ?></b></td>
                                                     <td><b><?= $values['qty']; ?></b></td>
                                                     <td width="40%"><b><?= $values['item_descriptionII'].' '.$widthchild.$heightchild.$depthchild; ?></b></td>
                                                     <td width="20%" class="textright"><b>$<?= number_format($ted_pricec,2); ?></b></td>
                                                  </tr>

                                     
                                                  <?php 
                                                $subPrice[] = $ted_pricec;

                                                            if ( !empty($product_order_sub_child) ) {
                                                              foreach ($product_order_sub_child as $key => $valuesub) {
                                                                if( $valuesub['pro_parent_id'] == $values['product_id']  ){ 
                                                                  $widthsub_c='';
                                                                  if( !empty( $valuesub['Width'] ) && ( $valuesub['Width'] !='NA' ) )$widthsub_c=$valuesub['Width'].'W x ';
                                                                $height_c='';
                                                                if(!empty( $valuesub['Height'] ) && ( $valuesub['Height'] !='NA' ) )$height_c=$valuesub['Height'].'W x ';
                                                                $depth_c='';
                                                                if(!empty( $valuesub['Depth'] ) && ( $valuesub['Depth'] !='NA' ) )$depth_c=$valuesub['Depth'].'D';

                                                              if( $order_view['assemble_value'] == 1 ){
                                                                $ted_pricecsub = $valuesub['item_cost'];
                                                                $cust_pricecsub = $valuesub['unassembled_retail_item_price'];
                                                              }else{
                                                                  $ted_pricecsub = $valuesub['cabinet_assembly_price'];
                                                                  $cust_pricecsub = $valuesub['assembled_retail_item_price'];
                                                              }

                                                              ?>
                                                              <tr>
                                                                <td><b>* * <?= $valuesub['Item_Code']; ?></b></td>
                                                                <td><b><?= $value->style_code; ?></b></td>
                                                                <td><b><?= $valuesub['qty']; ?></b></td>
                                                                <td width="40%"><b><?= $valuesub['item_descriptionII'].' '.$widthsub_c.$height_c.$depth_c; ?></b></td>
                                                                <td width="20%" class="textright"><b>$<?= number_format($ted_pricecsub,2); ?></b></td>
                                                              </tr>
                                                              <?php

                                                              $subPricechild[] = $ted_pricecsub;
                                                              }
                                                            }
                                                        }
                                                    }

                                                  }

                                                }

                                             $parentPrice[] = $ted_price;
                                        }
                                    } 
                                $rawTotal = array_merge($subPrice,$parentPrice);
                                if ( isset( $subPricechild ) ) {
                                  $rawTotal = array_merge( $rawTotal,$subPricechild ); 
                                }
                                $total_sum = array_sum( $rawTotal );
                                 ?>
                           </tbody>
                        </table>
                     </div>
                     <!-- end table-responsive -->
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
               <div class="row">
                  <div class="col-sm-6"></div>
                  <!-- end col -->
                  <div class="col-sm-6">
                     <div class="float-right">
                      <p><b>Delivery Price:</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; 
                           <?php echo ($order_view['delivery_price'])? '$'.number_format($order_view['delivery_price'],2): '$0.00'; ?></span>
                        </p>
                        <?php $total_sum = $total_sum + $order_view['delivery_price']; ?>
                        <p><b>Total:</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; 
                           $<?= number_format($total_sum,2); ?></span>
                        </p>
                     </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                         <div class="clearfix">
                          <strong>Assembly Note:</strong><br>
                          <?php if ( $order_view['assembly_note'] ) echo '<p>'.$order_view['assembly_note'].'</p><br>';  ?>
                          <strong>Delivery Note:</strong><br>
                          <?php if ( $order_view['delivery_note'] ) echo '<p>'.$order_view['delivery_note'].'</p>';  ?>
                        </div>

                        <div id="pdf_footer" class="pdf_footer">
                           <p>By signing below, I agree to the terms and conditions of the sale.</p>
                           <p>SIGNATURE X_______________________________________ DATE X_________________ (Every Page Needs to be Signed)</p>
                           <p>NAME <?= $order_view['first_name']; ?> <?= $order_view['last_name']; ?> (PRINT SIGNER'S NAME IF CUSTOMER IS A COMPANY)</p>
                           <p>Thank you for your patronage - Ted Beaudry, Cabinet Specialist (973) 244-9933</p>
                           <p>Generated on <?php echo date('Y-m-d h:i A'); ?> Order #<?php echo $this->uri->segment(3); ?></p>
                      </div>

                     <div class="clearfix"></div>

                    </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
            </div>
            <!-- end card-box -->
         </div>
         <!-- end col -->
      </div>
      <!-- end row --> 
   </div>
   <!-- container -->
</div>
<!-- content -->
  </td>
      </tr>
    </tbody>

    <tfoot>
      <tr>
        <td>
          <!--place holder for the fixed-position footer-->
          <div class="page-footer-space"></div>
        </td>
      </tr>
    </tfoot>

  </table>
  </body>

</html>