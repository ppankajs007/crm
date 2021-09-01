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
   @media print
   {    
   #lead_sub_menu, .text-right *
       {
            display: none !important;
       }
   }
   
   @media print
   {    
   #print_btn
       {
            display: none !important;
       }
   }
</style>
<div class="content">
   <!-- Start Content-->
   <div class="container-fluid">
      <!-- start page title -->
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                     <li class="breadcrumb-item"><a href="javascript: void(0);">Extras</a></li>
                     <li class="breadcrumb-item active">Invoice</li>
                  </ol>
               </div>
               <h4 class="page-title">Invoice</h4>
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
                      <a href="javascript:window.print()" class="btn btn-primary waves-effect waves-light" id="print_btn"><i class="mdi mdi-printer mr-1"></i> Print</a>
                     <h4 class="m-0 d-print-none">Invoice</h4>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="mt-3">
                        <p><b>Hello, <?= $order_view['first_name']." ".$order_view['last_name']; ?></b></p>
                        <p class="text-muted">Thanks a lot because you keep purchasing our products. Our company
                           promises to provide high quality products for you as well as outstanding
                           customer service for every transaction. 
                        </p>
                     </div>
                  </div>
                  <!-- end col -->
                  <div class="col-md-4 offset-md-2">
                     <div class="mt-3 float-right">
                        <?php $data = date('F j, Y',strtotime($order_view['created'])); ?>
                        <p class="m-b-10"><strong>Order Date : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; <?= $data ?></span></p>
                        <p class="m-b-10"><strong>Order Status : </strong> <span class="float-right"><span class="badge badge-danger"><?= $order_view['status'];?></span></span></p>
                        <p class="m-b-10"><strong>Order No. : </strong> <span class="float-right"><?= $order_view['id']; ?> </span></p>
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
                     <h6>Billing Address</h6>
                     <?php 
                        $errorAddr = '';
                        if( isset($cdata[$bill]) ){
                            if( in_array('Billing', array_column($cdata, 'address_type')) ){
                                echo $cdata[$bill]['full_name']."<br>";
                                echo $cdata[$bill]['addressline_one']."<br>";
                                echo $cdata[$bill]['state']."<br>";
                                echo $cdata[$bill]['country'];
                                echo '<abbr title="Phone">P:</abbr>'.$cdata[$bill]['phone']."</abbr>";
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
                     <h6>Shipping Address</h6>
                        <address>
                            <?php 
                            $errorAddr = '';
                            if( isset($cdata[$ship]) ){
                                if( in_array('Shipping', array_column( $cdata, 'address_type') ) ){
                                    echo $cdata[$ship]['full_name'];
                                    echo $cdata[$ship]['addressline_one'];
                                    echo $cdata[$ship]['state']."<br>";
                                    echo $cdata[$ship]['country'];
                                    echo '<abbr title="Phone">P:</abbr>'.$cdata[0]['phone']."</abbr>";
                                }else{
                                    $errorAddr = "No address found";
                                }
                            }else{
                                $errorAddr = "No address found";
                            }
                             echo $errorAddr;
                         ?>
                     </address>
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
               <div class="row">
                  <div class="col-12">
                     <div class="table-responsive">
                        <table class="table mt-4 table-centered">
                           <thead>
                              <tr>
                                 <th>Product Id</th>
                                 <th></th>
                                 <th>Quentity</th>
                                 <th>Item</th>
                                 <th>Dooostyle</th>
                                 <th style="width: 10%">Description</th>
                                 <th class="text-right">Total</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if ( !empty($pro_view) ) {
                                     $sum = 0;
                                     $sum2 = 0; 
                                       foreach ($pro_view as $key => $value) { ?>
                                          <tr>
                                             <td><b><?= $value['product_id']; ?></b></td>
                                             <td></td>
                                             <td><b><?= $value['qty']; ?></b></td>
                                             <td><b><?= $value['Item_code']; ?></b></td>
                                             <td><b><?= $value['style_id']; ?></b></td>
                                             <td>
                                                <b><?= $value['descriptionII']; ?></b> 
                                             </td>
                                             <td class="text-right"><b><?= $value['total_price']; ?></b></td>
                                          </tr>
                                          <?php if ( !empty($pro_view_child) ) {
                                                   foreach ($pro_view_child as $key => $values) {
                                                        if( $value['id'] == $values['pro_order_id'] ){
                                                   ?>
                                                              <tr>
                                                                 <td></td>
                                                                 <td>------</td>
                                                                 <td><?= $values['qty']; ?></td>
                                                                 <td><?= $values['item']; ?></td>
                                                                 <td><?= $values['style']; ?></td>
                                                                 <td><?= $values['description']; ?> </td>
                                                                 <td class="text-right"><?= $values['price']; ?></td>
                                                              </tr>
                                                  <?php
                                                            $price2      = array($values['price']);
                                                            $price_sum2  = array_sum( $price2 );
                                                            $sum2       += $price_sum2;
                                                  
                                                        }
                                                    }
                                                }
                                             $price     = array($value['price']);
                                             $price_sum = array_sum( $price );
                                             $sum       += $price_sum;
                                        }
                                    } 
                                 
                                 $total_sum = $sum + $sum2; 
                                 
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
                        <p><b>Sub-total:</b> <span class="float-right">$<?= $total_sum; ?></span></p>
                        <?php 
                           $discount = $order_view['discount'];
                           $TaxValue = $order_view['texes_multiplier'];
                           $texvalue =0;
                           $discountValue = $total_sum * ($order_view['discount']/100);
                           $totalDis = $total_sum - $discountValue;
                           if( $TaxValue != '0' ){
                             $texvalue = $totalDis * $TaxValue/100;
                             $grandTotal = $totalDis + $texvalue;
                           } else {
                              $grandTotal  = $totalDis; 
                           }
                           ?>
                        <p><b>Discount (<?= $order_view['discount']; ?>%):</b> <span class="float-right"> &nbsp;&nbsp;&nbsp; 
                           $<?= (int)$discountValue  ?></span>
                        </p>
                        <p><b>Tax (<?= $order_view['texes_multiplier']; ?>%):</b><span class="float-right"> &nbsp;&nbsp;&nbsp; 
                           $<?= (int)$texvalue; ?></span>
                        </p>
                        <h3>$<?= (int)$grandTotal; ?> USD</h3>
                     </div>
                     </div>
                     <div class="col-md-12">
                         <div class="row"><div class='col-md-3'>Customer Signature</div><div class='col-md-3'>Date of Acceptance</div></div>
                         <div class="clearfix">
                            <h6 class="text-muted">Notes:</h6>
                            <strong>This agreement/sale is based on the following terms and conditions:</strong>
    
                            <ol>
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
                      <div class="row"><div class='col-md-3'>Customer Signature</div><div class='col-md-3'>Date of Acknoledgements</div></div>
                     <div class="clearfix"></div>
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
               <div class="mt-4 mb-1">
                  <div class="text-right">
                     <a class="btn btn-success waves-effect waves-light" href="<?= base_url() ?>orders/edit_step_2/<?= $this->uri->segment(3); ?>" style="float: left;">Previous</a>
                  </div>
               </div>
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