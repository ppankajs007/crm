<style type="text/css">
   .float-right.print_button h4 {
       float: right;
       margin-top: 7px !important;
   }
   .float-right.print_button {
   width: 161px;
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
   ol.contract_term {
      margin-left: 15px;
   }  
   
   ol.contract_term h4 {
      margin-left: -39px;
      font-size: 15px;
      color: #6c757d;
   }
   ol.contract_term ul li {
      list-style-type: upper-alpha;
  }
   @media print {
       #lead_sub_menu, .text-right *{
       display: none !important;
       } 
       #print_btn{
       display: none !important;
       }
       .mt-3-print {
          margin-top: -5em !important;

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
      margin: 20mm
    }
</style>
<table>
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
                     <li class="breadcrumb-item"><a href="<?php echo base_url().'orders';?>">Orders</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$order_view['customer_id']; ?>"><?= $order_view['first_name']; ?> <?= $order_view['last_name']; ?></a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$order_view['id']; ?>">Order For <?= $order_view['first_name']; ?> <?= $order_view['last_name']; ?></a></li>
                     <li class="breadcrumb-item">Contract</li>
                  </ol>
               </div>
               <h4 class="page-title">Contract</h4>
            </div>
         </div>
      </div>
      <!-- end page title --> 
      <div class="row">
         <div class="col-12">
            <div class="card-box">
               <ul class="overview_list" id="lead_sub_menu" class="lead_sub_menu">
                  <?php  echo modules::run('includes/order_sub_menu');?>
               </ul>
               <div class="clear"></div>
               <br>
               <div class="clearfix">
                  <div class="float-left">
                     <img src="https://perfectionkitchens.com/wp-content/uploads/2019/04/logo-1.png" width="150">
                  </div>
                  <div class="float-right print_button">
                     <?php $orderName = "O".$this->uri->segment(4)."_".$order_view['last_name']; ?>
                      <a onclick="document.title='<?php echo $orderName; ?>'; window.print(); return false;" href="javascript:;" class="btn btn-primary waves-effect waves-light" id="print_btn"><i class="mdi mdi-printer mr-1"></i> Print</a>
                     <h4 class="m-0">Contract</h4>
                  </div>               </div>
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
                     <div class="mt-3 float-right mt-3-print">
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
                     <h4>Billing</h4>
                     <?php 
                        $errorAddr = '';
                        if( isset($cdata[$bill]) ){
                            if( in_array('Billing', array_column($cdata, 'address_type')) ){
                                echo ucfirst($cdata[$bill]['full_name'])."<br>";
                                echo $cdata[0]['phone']."<br>";
                                echo $cdata[0]['email']."<br>";
                                if($cdata[$bill]['addressline_one']) echo $cdata[$bill]['addressline_one'].", ";
                                if($cdata[$bill]['addressline_two']) echo $cdata[$bill]['addressline_two'];
                                echo "<br>".$cdata[$bill]['city'].', ' .$cdata[$bill]['state']." ".$cdata[$bill]['zipcode']."<br>";
                            }else{
                                $errorAddr = "No address found";
                            }
                        }else{
                            $errorAddr = "No address found";
                        }
                        echo $errorAddr;
                        ?>
                  </div>
                  <!-- end col -->
                  <div class="col-sm-6">
                     <?php if ($order_view['is_pickup'] != 'yes') { ?>
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
                                 echo "<br>".$cdata[$ship]['city'].", ".$cdata[$ship]['state']." ".$cdata[$ship]['zipcode']."<br>";
                               }else{
                                   $errorAddr = "No address found";
                               }
                           }else{
                               $errorAddr = "No address found";
                           }
                            echo $errorAddr;
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
                                            $parentProduct['data'] = $controllerThis->quoteOrderForObject($value,'No');
                                            $rawTotal[] = $parentProduct['data']['totalprice'];
                                            $this->view( 'tknobs_orders/tr__template_quote',$parentProduct);

                                            if ( !empty($product_order_child) ) {
                                              foreach ($product_order_child as $key => $values) {
                                                  if( $value->POProId == $values->pro_order_id  ){ 

                                                      $childProduct['data'] = $controllerThis->quoteOrderForObject($values,'No');

                                                      $childProduct['data']['child'] = 1;

                                                      $rawTotal[] = $childProduct['data']['totalprice'];
                                                      $this->view( 'tknobs_orders/tr__template_quote',$childProduct);
                                                      

                                                      if ( !empty($product_order_sub_child) ) {
                                                        foreach ($product_order_sub_child as $key => $valuesub) {
                                                            if( $valuesub->pro_order_id == $values->p_o_cid  ){

                                                               $subchildProduct['data'] = $controllerThis->quoteOrderForObject($valuesub,'No');
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
                               
                                  $cPrice = array_sum( $rawTotal );
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
                        <!-- Item Total --> 
                        <p><b>Item Total:</b> <span class="float-right">$<?= decimalValue($cPrice); ?></span></p>

                        <!-- delivery_price check --> 
                        <?php if($order_view['is_pickup'] == 'no'){ 
                            $delivery_price = ( $order_view['delivery_price'] ) ? decimalValue($order_view['delivery_price']): '0.00' ;
                            echo "<p><b>Delivery:</b> <span class='float-right'>$".$delivery_price."</span></p>";
                            
                            $afterDelivery = decimalValue($cPrice + $delivery_price);
                            echo "<p><b>Item & Delivery Total : </b><span class='float-right'>$".$afterDelivery."</span></p>";
                        }else{
                            $afterDelivery = $cPrice;
                        } ?> 

                        <!-- Discount check --> 
                        <?php if(!empty($order_view['discount_per']) && $order_view['discount_per'] != 0 ){
                            $discount_per = $order_view['discount_per'];
                            $discount     = decimalValue( $afterDelivery*$order_view['discount_per']/100 );
                            echo "<p><b>Discount (".$discount_per."%) : </b> <span class='float-right'>$".$discount."</span></p>";
                        }else{
                            $discount = 0.00; 
                        }?>

                        <?php $subtotal = decimalValue( $afterDelivery - $discount ); ?>
                        <p><b>Subtotal:</b> <span class="float-right">$<?php echo $subtotal; ?></span></p>

                        <!-- Tax check --> 
                       <?php if( $order_view['resale_certificate'] == '' && $order_view['has_a_uez'] == '' && $order_view['has_a_stform'] == '' ){ 
                            $order_tax = 0.00;
                            $taxV = 0.00;
                        }else if( $order_view['resale_certificate'] != 'yes' && $order_view['has_a_uez'] != 'yes' && $order_view['has_a_stform'] != 'yes' ){
                            $order_tax = order_tax;
                            $taxV = $order_view['tax'];
                        }else{
                            $order_tax = 0.00;
                            $taxV = 0.00;
                        }
                        
                        if ( !empty($order_tax) && $order_tax != 0  ){
                            echo '<p><span class="lAl partEq"></span>
                                  <b>Sales Tax:</b> <span class="float-right"><span class="taxxd">'.
                                  $order_tax.'</span>% (<span class="">'.$taxV.'</span>)</span>
                                  </p>';
                            $afterTax = $subtotal+$taxV;
                        }else{
                            $afterTax = $subtotal;
                        } ?>

                        <!-- Paid amount check --> 
                        <?php $paid_amount = ( $order_view['paid_amount'] ) ? decimalValue($order_view['paid_amount']): '0.00';
                        $paidAmountper = $controllerThis->calcuateAmountPer($afterTax,$paid_amount);
                        if ( $paid_amount != '0.00' ){
                            echo '<p><b>Paid('. $paidAmountper.'%):</b> <span class="float-right">$'.$paid_amount.'</span></p>';
                            $afterPaid = $afterTax - $paid_amount;
                        }else{
                            $afterPaid = $afterTax;
                        }?>
                       <p><b>Total Due:</b> <span class="float-right"><b>
                           $<?php echo decimalValue($afterPaid); ?></b></span>
                        </p>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="clearfix">
                     <strong>Ordering Note:</strong>
                     <?php if ( $order_view['ordering_note'] ) echo '<p>'.$order_view['ordering_note'].'</p>';  ?>
                     <strong>Installation Note:</strong>
                     <?php if ( $order_view['installation_note'] ) echo '<p>'.$order_view['installation_note'].'</p>';  ?>
                     <ol class="contract_term">
            <h4>Installation Agreement:</h4>
              <li>Perfection Kitchens will use in house employees, or a subcontractor being used at the direction and instruction of Perfection, or a combination of both depending on the scope of the work to be completed.  All workers will be insured in the state of New Jersey.  Perfection and sub contractors will furnish all labor, supervision, services, materials, tools, transportation, storage and all other things necessary to perform the work required to complete the scope of work as listed above.</li>
            <h4>Purchasers Responsibilities:</h4>
              <li>Unless specifically stated on the item list above, the Purchaser is responsible:
                for obtaining any and all permits as required by law and have in place before installation begins.
                to receive, inspect, report damages or missing cabinets, receive replacements and safely store cabinets prior to the installer arriving to do installation.
                for clearing out all cabinets, valuables or other items that could get damaged during the course of construction.
                to remove, install or change any plumbing, electrical, appliances or flooring, to remove and dispose of old products, remove add or change walls, windows or any other type of construction.
                area must be cleared of any debris and/or obstacles (furniture, appliances, etc.) and ready for installers to start work on scheduled day of installation.</li>
            <h4>Damages:</h4>
              <li>Purchaser acknowledges that cabinetry and appliances are very large and heavy.  Although we are extremely careful, the movement of these can lead to damage to the walls, floors and other obstacles within the room where work is being done or cabinets and appliances need to be brought through.  That is why it’s advised that prior to work starting, the Purchaser:
                <ul>
                  <li>must cover wood floors with cardboard and joints taped in areas outside of where new cabinets will be installed.</li>
                  <li>must move valuable items into another room outside of the work area.</li>
                  <li>should not put the finish coat of spackle on nor final coat of paint as there could be dings, scratches, knicks or other damage to the walls that should be covered in the final coat of spackle and paint.</li>
                  <li>If the above steps are not followed nor painting was finished prior to installation, Perfection Kitchens nor its subcontractors will be held liable to damage to walls, floors or other obstacles.</li>
                </ul>
              </li>
            <h4>Electrical:</h4>
              <li>Unless specifically stated in this contract, we are not responsible to remove, cover or reinstall any electrical items, outlets or switches that are directly wired to your home.  It will be the Purchaser’s responsibility to hire and pay for a licensed electrician to move, remove and install any electrical parts.</li>
            <h4>Plumbing:</h4>
              <li>Unless specifically stated in this contract, we are not responsible for cutting, capping or reinstalling any plumbing for any sinks, faucets, water lines or gas lines.  It is the Purchaser's responsibility to have any cutting and capping to water and gas lines prior to installation.  If this is not done, extra charges will be incurred.</li>
            <h4>Hardware:</h4>
              <li>If hardware is being used it must be on the job site upon the first day of cabinet installation, if not extra charges may be incurred to include drive time and clean up.</li>
            <h4>Other Terms and Conditions:</h4>
              <li>Perfection will not be held liable for strikes, accidents weather or other delays beyond Perfection’s control.</li>
              <li>Any alteration or deviation from the above specifications involving extra work or costs will be executed only upon the written order signed by the Purchaser and will become an extra charge over and above the contract price.</li>
              <li>Any checks returned by the bank shall incur a “Returned Check” charge of $30.00.</li>
              <li>In the event of default, the Purchaser shall be responsible to pay attorney fees, collection costs and other fees associated with the enforcement of this agreement.</li>
              <li>Acceptance and Signing of "Purchaser Signature" on this order is final and binding, no cancellation after the three-day period will be allowed. No refunds, store credit, or exchanges will be provided. </li>
              <li>I find the preceding order has met his/her specifications.</li>
              <li>Final payment must be made via certified bank check, cashier's check, money order, credit card or cash.  Personal or business checks will not be accepted as final payment.</li>
              <li>Removal of old kitchen cabinets should not take place until all new cabinets have arrived, have been inspected and are ready for installation.</li>
              <li>This Agreement represents the entire agreement between the parties and shall be binding upon the parties and their heirs, successors and assigns.</li>
              <li>This Agreement may not be sold or assigned by any party except with the written consent of the other party.</li>
              <li>All notices required under the terms of this Agreement will be given and will be complete by mailing by certified or registered mail, return receipt requested, or by hand delivery, confirmed fax or overnight delivery service, to the address of the parties as shown at the beginning of this Agreement, or to such other address as may be designated in writing, which notice of change of address is given in the same manner.</li>
              <li>Any reference herein to the singular shall include the plural and vice versa. Any reference herein to the masculine shall include the feminine and vice versa.</li>
              <li>This Agreement shall be construed in accordance with the laws of the State of New Jersey.</li>
              <li>Should any provision of this Agreement be deemed unenforceable, the remaining provisions shall remain in full force and effect.</li>
              <li>The purchaser agrees that additions or deletions due to layout and order revisions of items totaling $1000.00 or less to this order does not require signed written consent, email authorization by the email listed on this contract will be sufficient.</li>
            </ol>
                     <p><strong>NOTICE TO PURCHASER: </strong></p>
                     <strong>YOU MAY CANCEL THIS CONTRACT AT ANY TIME BEFORE MIDNIGHT OF THE THIRD BUSINESS DAY AFTER RECEIVING A COPY OF THIS CONTRACT. IF YOU WISH TO CANCEL THIS CONTRACT, YOU MUST EITHER:</strong>
                     <ol>
                        <li>SEND A SIGNED AND DATED WRITTEN NOTICE OF CANCELLATION BY REGISTERED OR CERTIFIED MAIL, RETURN RECEIPT REQUESTED; OR</li>
                        <li>PERSONALLY DELIVER A SIGNED AND DATED WRITTEN NOTICE OF CANCELLATION TO: </li>
                     </ol>
                     <p>Perfection Associates, Limited Liability Company d/b/a Perfection Kitchens 1174 Fischer Blvd. Toms River, NJ 08753 TELEPHONE:  (732) 270-9300; EMAIL: orders@perfectionkitchens.com</p>
                     <p>If you cancel this contract within the three-day period, you are entitled to a full refund of your money. Refunds must be made within 30 days of the contractor's receipt of the cancellation notice.</p>
                     <p>By signing this agreement, I, Purchaser and Owner, agree to the terms and conditions of the sale and have reviewed all of the Contract Documents and that the same accurately reflect kind and quality of the Work, including all materials, requested by Purchaser and Owner.</p>
                  </div>
                  <br>
                  <div class="row">
                     <div class='col-md-4'>Customer Signature _______________</div>
                     <div class='col-md-4'>Date of Acknoledgements _______________</div>
                  </div>
                  <br><br><br>
                  <?php if($order_view['payment_person'] == 'no'){ ?>
                  <div class="pPerson">
                     <h5>
                        I, <?php echo $order_view['payment_person_name']; ?> authorize the use of my credit card to pay for this order. 
                     </h5>
                     <br>
                     <p>Signature _______________</p>
                     <br><br>
                  </div>
                  <?php } ?>
                  <?php  if($order_view['Is_Colourtone'] == 'yes'){ ?>
                  <div class="colortone">
                     <h4>DISCLAIMER FOR COLOURTONE FINISHES</h4>
                     <strong>A signed copy of this form must be supplied to HANSSEM prior to production</strong>
                     <p>Colourtones are opaque finishes, similar in appearance to paint. The coatings are pigmented basecoats that must be catalyzed prior to application and are applied with airless spray equipment . Colourtones have a high solids content, resulting in better build and lower VOC emissions. These finishes are very durable and resistant to moisture</p>
                     <p>WoodMaster’s colourtone finishes are available on maple and ECO doors & will receive a satin finish top coat</p>
                     <p>The following characteristics associated with colourtone finishes are considered acceptable AND WILL NOT BE CONSIDERED DEFECTIVE under WoodMaster’s Warranty Program:</p>
                     <p>• Veneer checking and/or seam separation on ¼” center panels, finished ends, panels, toe kicks, etc.</p>
                     <p>• Joint fracturing (hairline cracks along joints on the front, back or edge of doors) from handling of doors and/or the natural process of expansion and contraction of the doors during the different seasons of the year </p>
                     <p>• Minor flaws such as dust particles, dimples and lint under or in the finish.</p>
                     <p>• Bridging between the framing and center panel and fracturing of the same . (Bridging occurs when the coating material joins two surfaces together)</p>
                     <p>• Colourtone finishes will vary from batch to batch and will change over time due to exposure to light, pollution and chemicals. Therefore, additions or replacements to previous orders and samples will vary from the original color . This variation will be within a controlled color range and will not be considered defective </p>
                     <p>I/We have read and fully understand the above statements and accept the fact that some or all of these characteristics may be evident in my/our order </p>
                     <br><br>
                     <div class="row">
                        <div class='col-md-6'>PO Number _______________________</div>
                        <div class='col-md-6'>WoodMaster Order Number _______________________</div>
                        <br><br>
                        <div class='col-md-6'>Dealer _______________________</div>
                        <div class='col-md-6'>Date _______________________</div>
                        <br><br>
                        <div class='col-md-6'>Signature _______________________</div>
                     </div>
                  </div>
                  <?php } ?>
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