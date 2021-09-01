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
                                            $parentProduct['data'] = $controllerThis->quoteOrderForObject($order_view['assemble_value'],$value,'No');
                                            $rawTotal[] = $parentProduct['data']['totalprice'];
                                            $this->view( 'tsg_orders/tr__template_quote',$parentProduct);

                                            if ( !empty($product_order_child) ) {
                                              foreach ($product_order_child as $key => $values) {
                                                  if( $value->POProId == $values->pro_order_id  ){ 

                                                      $childProduct['data'] = $controllerThis->quoteOrderForObject($order_view['assemble_value'],$values,'No');

                                                      $childProduct['data']['child'] = 1;

                                                      $rawTotal[] = $childProduct['data']['totalprice'];
                                                      $this->view( 'tsg_orders/tr__template_quote',$childProduct);
                                                      

                                                      if ( !empty($product_order_sub_child) ) {
                                                        foreach ($product_order_sub_child as $key => $valuesub) {
                                                            if( $valuesub->pro_parent_id == $values->product_id  ){

                                                               $subchildProduct['data'] = $controllerThis->quoteOrderForObject($order_view['assemble_value'],$valuesub,'No');
                                                                $subchildProduct['data']['subchild'] = 1;
                                                      
                                                                $rawTotal[] = $subchildProduct['data']['totalprice'];

                                                                $this->view( 'tsg_orders/tr__template_quote',$subchildProduct);
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
                     <?php if ( $order_view['ordering_note'] ) echo '<strong>Ordering Note:</strong> <p>'.$order_view['ordering_note'].'</p>';  ?>
                     <?php if ( $order_view['installation_note'] ) echo '<strong>Installation Note:</strong><p>'.$order_view['installation_note'].'</p>';  ?>
                    <p><strong>This agreement/sale is based on the following terms and conditions:</strong></p>
                     <ol class="contract_term">
                        <li>When freight is delivered, Purchaser understands that they are responsible for receiving and taking inventory of the order from the delivery driver.  Please verify that your order is correct BEFORE signing the driver’s delivery slip.  Any incorrect or missing item claims will NOT be honored once a delivery is signed for.  If any items in the delivery appear to be damaged or missing, please note on the driver’s delivery ticket and contact Perfection Kitchens immediately.</li>
                        <li>Perfection Kitchens shall not be responsible for any damage to the materials and products provided pursuant to this Contract that is not reported to Perfection Kitchens by Purchaser within 48 hours of delivery.  Upon timely notification of damage, Perfection Kitchens shall, at its sole discretion, either supply a repair kit or replace any damaged materials or products, and Perfection Kitchens responsibility shall be limited to such repair or replacement.  Purchaser also understands that any scratches, scuffs or nicks that will not be visible after installation will not be replaced.  Damaged item claims must be made prior to assembly and/or installation.  Any damaged item that is installed or assembled will not be replaced.</li>
                        <li>Defective or damaged items will not be replaced or repaired until Perfection Kitchens conducts an inspection of the defective or damaged items.  Photos of damaged can be provided via email to order@perfectionkitchens.com </li>
                        <li>Purchaser acknowledges and understands that natural wood products are not fully consistent in appearance and that color variations will exist between among the pieces of wood used in the construction of natural wood cabinetry, even within a single component (door, drawer, etc.). The Purchaser further acknowledges and understands that natural wood may contain wavy, curly, "bird's eye" and/or burl grain, and may also contain mineral streaks and worm tracking across the grain. </li>
                        <li>Purchaser agrees that the delivery of the cabinetry will be curbside and that two to three people may be needed to adequately get the cabinetry from curbside into the Purchasers climate controlled environment due to the size and weight of the cabinetry.  The Purchaser agrees to have assistance available on day of delivery.</li>
                        <li>Purchaser agrees that a date for delivery will be provided after the cabinet order has been invoiced by the manufacturer.  The Purchaser understands that the window for delivery will be provided after 2PM on the previous business day prior to delivery.  If the Purchaser confirms that the date of delivery is acceptable and then reschedules the delivery with less than 48 hours’ notice to Perfection Kitchens, the Purchaser may be responsible for a $250 rescheduling fee. </li>
                        <li>Perfection Kitchens shall not be responsible for damage caused after delivery of the materials and products, unless caused by Contractor or its subcontractor(s). Cabinets are not considered damaged and will not be exchanged if they have alterations such as holes from installation or door hardware. </li>
                        <li>The Purchaser will be supplied floor plans, elevation views, 3D views and an overview of their cabinetry design and the products selected.  The Purchaser’s initials on those pages signify that those measurements, appliance sizes, locations, layout and product choices are correct. </li>
                        <li>Purchaser understands that the Perfection Kitchens offers designs services as an assistance to the Purchaser and that unless Perfection Kitchens is contracted to do the full renovation, the Purchaser agrees that they are fully responsible to ensure that they measurements, appliance sizes, appliance locations and cabinet layouts are correct and will work.</li>
                        <li>The Purchaser acknowledges and understands that wood products react to extreme temperatures and to changes in temperature and/or humidity by expanding and contracting.  Perfection Kitchens  shall not be responsible for damage to materials and products provided pursuant to this Contract that is caused by a lack of normal indoor temperature and/or humidity control (normal humidity range is 25-55%).  It is strongly encouraged that kitchen cabinets are stored in a climate controlled environment while waiting for installation.</li>
                        <li>Indicators of left/right hinges in the Contract Documents are installation notes only.  Hinges come in default configuration. Perfection Kitchens will not make any left/right modifications for hinges (this is not applicable to Woodmaster, Hanssem, Holiday Kitchens or Legacy Crafted orders). </li>
                        <li>A registered home improvement contractor must be used for all installations not personally performed by a homeowner. The installer will make necessary adjustments for the alignment of door hinges, roll out trays, cabinets, and drawers. </li>
                        <li>When the cabinets are installed and leveled, the doors are put out of alignment and need to be readjusted. Sometimes the drawers need minor adjustments as well due to the leveling of the cabinets </li>
                        <li>Changes made to the delivery date after production of the product start could result in storage fees and additional charges to the customer. </li>
                        <li>Re-orders may take 1 to 6 weeks to arrive (lead-time varies by manufacturer). </li>
                        <li>Removal of old kitchen cabinets should not take place until all new cabinets have arrived, have been inspected, and are ready for installation. </li>
                        <li>The characteristics of the wood species that has been chosen may have variations that are inherent. The chosen finish a) glazed. b) painted, c) distressed fashion finish may have a variation that is inherent. </li>
                        <li>Purchaser is responsible for the protection of my floors during delivery, installation or service appointments, especially during inclement weather. </li>
                        <li>Joint and Trim fracturing (hairline cracks along joints/trims on the front, back or edge of doors) from handling of doors and/or the natural process of expansion and contraction of the doors during the different seasons of the year is not considered to be defective or damaged. </li>
                        <li>Lazy Susans, Sink Base, and Corner cabinets may need up to 36" of door clearance. Delivery personnel will not take any doors down. </li>
                        <li>Some designs will utilize wall cabinets that are used in place of base cabinets.  Some installations will require the clients contractor to build a platform under the cabinet to increase the height of the wall cabinet to the base cabinet height. </li>
                        <li>It is not always possible to reach clients ceiling with crown molding due to ceiling height or ceiling unevenness.  Furthermore, client may have opted not to purchase the proper molding to take crown to the ceiling.  It is client’s responsibility to review the item list with their contractor and insure the correct molding is being supplied to achieve desired look. </li>
                        <li>Fillers and panels may need to be cut to size in the field by the clients contractor.  Adjustments and sizing may be slightly different then what is supplied on the design.  It is the clients contractors responsibility to determine final filler and panel size. </li>
                        <li>It is the client’s responsibility to insure that all appliances for the new kitchen will work with Perfection Kitchens supplied design. </li>
                        <li>Any plumbing lines, electrical lines, outlets, lights, switches or HVAC vents will need to be adjusted to accommodate the provided layout. Perfection Kitchens is not responsible ensuring that it will work with present locations unless Perfection Kitchens is contracted, in writing, to do so.</li>
                        <li>Codes and permits differ between each town. Client is responsible for insuring that this design and their chosen appliances meet all code standards. </li>
                        <li>If Perfection Kitchens is not installing the cabinetry, client is responsible for having their licensed contractor review and approve that the layout fits the space and all parts needed for installation are included.  Any additional parts or cabinetry needed will not be the responsibility of the Perfection Kitchens.  </li>
                        <li>Wall Ovens come in many different sizes and combinations. Unless otherwise indicated on this contract, any oven cabinets will have to be modified to fit your appliances in the field by your installation contractor. Perfection Kitchens assumes no liability for modifying the cabinet to fit your exact wall oven configuration.  </li>
                        <li>Unless customer purchases a reduced depth refrigerator, the entire refrigerator box will not be covered by the refrigerator panels. </li>
                        <li>If picking up, Purchaser acknowledges that the available days and times for pickup, by appointment only, are Tuesday through Friday between the hours of 10 am - 4pm only. </li>
                        <li>Perfection Kitchens shall furnish the Owner a written copy of all guarantees or warranties made with respect to labor services, products or materials furnished in connection with the Work. Such guarantees or warranties shall be specific, clear and definite and shall include any exclusions or limitations as to their scope or duration.  Copies of all guarantees or warranties shall be furnished to the Owner at the time Perfection Kitchens presents the bid as well as at the time of execution of the contract, except that separate guarantees or warranties of the manufacturer of products or materials may be furnished at the time such products or materials are installed. </li>
                        <li>In the event that Perfection Kitchens retains counsel in order to enforce any of the terms of this Agreement, including but not limited to collection of moneys payable by the Owner, or to defend any claim(s) brought against the Perfection Kitchens by the Purchaser and such defense is successful, the Purchaser shall reimburse Perfection Kitchens for any attorney fees, collection costs, and related costs reasonably incurred by Perfection Kitchens.</li>
                        <li>Purchaser find the preceding order has meet his/her specifications. </li>
                        <li>Perfection Kitchens accepts certified bank checks, cashier's check, money orders and credit card payments ONLY. Any forms of check most clear prior to delivery of any product.  Purchaser understands that cabinets and countertop orders must be paid in full with cleared funds no later than 12PM the business day prior to delivery.  Non-payment by that time will result and in cancellation of the delivery or granite installation and will result in a $250 rescheduling fee.</li>
                        <li>In the event that any check tendered to the Perfection Kitchens by or on behalf of the Owner is returned unpaid, Perfection Kitchens may charge the Owner a $50.00 fee </li>
                        <li>The purchaser agrees that additions or deletions due to layout and order revisions of items totaling $1000.00 or less to this order does not require signed written consent, email authorization by the email listed on this contract will be sufficient.</li>
                        <li>Acceptance and Signing of "Purchaser Signature" on this custom order is final and binding, no cancellation after the three-day period will be allowed. No refunds, store credit, or exchanges will be provided. </li>
                        <li>In the event that Perfection Kitchens agrees to accept return of any materials (unless due to damage not caused by Owner), Purchaser shall be responsible for a 30% restocking fee.  </li>
                        <li>You must notify Perfection Kitchens of any changes within 48 hours. Requests for changes after 48 hours will be considered, based on Perfection Kitchens's ability to accommodate </li>
                        <li>This Agreement represents the entire agreement between the parties and shall be binding upon the parties and their heirs, successors and assigns. </li>
                        <li>This Agreement may not be sold or assigned by any party except with the written consent of the other party. </li>
                        <li>All notices required under the terms of this Agreement will be given and will be complete by mailing by certified or registered mail, return receipt requested, or by hand delivery, confirmed fax or overnight delivery service, to the address of the parties as shown at the beginning of this Agreement, or to such other address as may be designated in writing, which notice of change of address is given in the same manner. </li>
                        <li>Any reference herein to the singular shall include the plural and vice versa.  Any reference herein to the masculine shall include the feminine and vice versa. </li>
                        <li>This Agreement shall be construed in accordance with the laws of the State of New Jersey. </li>
                        <li>Should any provision of this Agreement be deemed unenforceable, the remaining provisions shall remain in full force and effect. </li>
                        <li>Perfection Kitchens shall not be responsible for problems arising from errors in measurements provided to Perfection Kitchens by Purchaser.</li>
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
                   <div class='col-md-12'>Customer Signature _______________________________  &nbsp;&nbsp;&nbsp;     Date of Acknowledgments ____________________________________</div>
                  </div>
                  <br><br><br>
                  <?php if($order_view['payment_person'] == 'no'){ ?>
                  <div class="pPerson">
                     <h5>
                        I, <?php echo $order_view['payment_person_name']; ?> authorize the use of my credit card to pay for this order. 
                     </h5>
                     <br>
                     <p>Signature ____________________________________</p>
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