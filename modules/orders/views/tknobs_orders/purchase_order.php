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
                    <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$order_view['id']; ?>">Order For <?= $order_view['first_name']; ?> <?= $order_view['last_name']; ?></a></li>
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
                      <?php $orderName = "O".$this->uri->segment(4)."_".$order_view['last_name']; ?>
                      <a onclick="document.title='<?php echo $orderName; ?>'; window.print(); return false;" href="javascript:;" class="btn btn-primary waves-effect waves-light" id="print_btn"><i class="mdi mdi-printer mr-1"></i> Print</a>
                     <h4 class="m-0">Purchase Order</h4>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="mt-3">
                        <div class="topaddr">
                          <p><label>Web</label> <span>  PerfectionKitchens.com</span></p>
                          <p style="margin-bottom: -10px;"><label>Address</label><span>  1174 Fischer Blvd.</span></p>
                          <p><label></label><span>  River, NJ 08753</span></p>
                          <p><label>Email</label><span>  orders@perfectionkitchens.com</span></p>
                          <p><label>Phone</label><span>  (732) 270-9300</span></p>
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
                            if($my_vendor['office_phone']) echo $my_vendor['office_phone'].",<br> ";
                            if($my_vendor['order_processor_email']) echo $my_vendor['order_processor_email'].",<br> ";
                            if($my_vendor['addressline_one']) echo $my_vendor['addressline_one'].", ";
                            if($my_vendor['addressline_two']) echo $my_vendor['addressline_two'];
                            echo "<br>";
                            echo $my_vendor['city'].", ".$my_vendor['state']." ".$my_vendor['zipcode'];
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
                                 echo ucfirst($cdata[$ship]['full_name'])."<br>";
                                 echo $cdata[0]['phone'].'<br>';
                                 echo $cdata[0]['email'].'<br>';
                                 if($cdata[$ship]['addressline_one']) echo $cdata[$ship]['addressline_one'].", ";
                                 if($cdata[$ship]['addressline_two']) echo $cdata[$ship]['addressline_two'];
                                 echo "<br>";
                                 echo $cdata[$ship]['city'].", ".$cdata[$ship]['state']." ".$cdata[$ship]['zipcode']."<br>";
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
                              echo 'Perfection Kitchens<br>';
                              echo '(732) 270-9300<br>';
                              echo 'orders@perfectionkitchens.com<br>';
                              echo '1174 Fischer Blvd.<br> River, NJ 08753<br>';
                          ?>
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
                                 <th style="width: 10%">Description</th>
                                 <th>Quantity</th>
                                 <th>Price</th>
                                 <th class="text-right">Total Price</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                                if ( !empty($pro_view) ) {
                                  $rawTotal = array();
                                    $total_sum = 0;
                                      foreach ($pro_view as $key => $value) {
                                            $parentProduct['data'] = $controllerThis->quoteOrderForObject($value,'Yes');
                                            $rawTotal[] = $parentProduct['data']['totalprice'];
                                            $this->view( 'tknobs_orders/tr__template_quote',$parentProduct);

                                            if ( !empty($product_order_child) ) {
                                              foreach ($product_order_child as $key => $values) {
                                                  if( $value->POProId == $values->pro_order_id  ){ 

                                                      $childProduct['data'] = $controllerThis->quoteOrderForObject($values,'Yes');

                                                      $childProduct['data']['child'] = 1;

                                                      $rawTotal[] = $childProduct['data']['totalprice'];

                                                      $this->view( 'tknobs_orders/tr__template_quote',$childProduct);
                                                      

                                                      if ( !empty($product_order_sub_child) ) {
                                                        foreach ($product_order_sub_child as $key => $valuesub) {
                                                            if( $valuesub->pro_order_id == $values->p_o_cid  ){

                                                               $subchildProduct['data'] = $controllerThis->quoteOrderForObject($valuesub,'Yes');
                                                                $subchildProduct['data']['subchild'] = 1;
                                                      
                                                                $rawTotal[] = $subchildProduct['data']['totalprice'];

                                                                $this->view( 'tknobs_orders/tr__template_quote',$subchildProduct);
                                                            }
                                                        }
                                                      }
                                                  }
                                              }

                                            }
                                      }
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
                     <p><b>Total : </b> <span class="float-right">$<?= decimalValue($total_sum); ?></span></p>
                     </div>
                     </div>
                     <div class="clearfix"></div>
                     <div class="col-md-12">
                         <div class="clearfix">
                          <?php if ( $order_view['assembly_note'] ){
                            echo "<strong>Assembly Note:</strong><br>";
                            echo '<p>'.$order_view['assembly_note'].'</p><br>';
                          }
                          if ( $order_view['delivery_note'] ){
                            echo "<strong>Delivery Note:</strong><br>";
                            echo '<p>'.$order_view['delivery_note'].'</p>';
                          }
                          ?>
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