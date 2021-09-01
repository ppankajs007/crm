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
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$edit_order['customer_id']; ?>"><?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$edit_order['id']; ?>">Order For <?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
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
                     <?php $orderName = "O".$this->uri->segment(4)."_".$edit_order['last_name']; ?>
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
                          <?php $data = date('F j, Y',strtotime($edit_order['created'])); ?>
                          <p class="m-b-10"><strong>Order Date : </strong> <span class="float-right"> &nbsp;&nbsp;&nbsp;&nbsp; <?= $data ?></span></p>
                          <p class="m-b-10"><strong>Order No. : </strong> <span class="float-right"><?= $edit_order['id']; ?> </span></p>
                        </div>
                     </div>
                  </div>
                  <!-- end col -->
               </div>
               <!-- end row -->
               <?php
                  //$customer= $this->order_model->findWhere( 'customer', array( 'id' => $edit_order['customer_id'] ), FALSE, array( '*' ) );
                  
                    $this->db->select('*');
                    $this->db->from('customer');
                    $this->db->join('customer_address', 'customer.id = customer_address.customer_id');
                    $this->db->where('customer.id', $edit_order['customer_id']);
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
                     <?php if ($edit_order['is_pickup'] != 'yes') { ?>
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
                              <?php $cPrice = 0; foreach ($fab_products as $key => $value) {
                                    extract( $value );
                                ?>
                                <tr>
                                  <td width="15%"><b><?php echo $item_code; ?><b></td>
                                  <td width="15%"><b><?php echo $style_name; ?><b></td>
                                  <td width="40%"><b><?php echo $item_description; ?><b></td>
                                  <td width="02%"><b><?php echo $qty; ?><b></td>
                                  <td width="15%"><b><?php echo '$'.$total_price; ?><b></td>
                                  <td width="15%"><b><?php echo '$'.$total_price; ?><b></td>
                                </tr>
                                
                              <?php $cPrice += $total_price; } ?>
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
                        <?php if($edit_order['is_pickup'] == 'no'){ 
                            $delivery_price = ( $edit_order['delivery_price'] ) ? decimalValue($edit_order['delivery_price']): '0.00' ;
                            echo "<p><b>Delivery:</b> <span class='float-right'>$".$delivery_price."</span></p>";
                            
                            $afterDelivery = decimalValue($cPrice + $delivery_price);
                            echo "<p><b>Item & Delivery Total : </b><span class='float-right'>$".$afterDelivery."</span></p>";
                        }else{
                            $afterDelivery = $cPrice;
                        } ?> 

                        <!-- Discount check --> 
                        <?php if(!empty($edit_order['discount_per']) && $edit_order['discount_per'] != 0 ){
                            $discount_per = $edit_order['discount_per'];
                            $discount     = decimalValue( $afterDelivery*$edit_order['discount_per']/100 );
                            echo "<p><b>Discount (".$discount_per."%) : </b> <span class='float-right'>$".$discount."</span></p>";
                        }else{
                            $discount = 0.00; 
                        }?>

                        <?php $subtotal = decimalValue( $afterDelivery - $discount ); ?>
                        <p><b>Subtotal:</b> <span class="float-right">$<?php echo $subtotal; ?></span></p>

                        <!-- Tax check --> 
                       <?php if( $edit_order['resale_certificate'] == '' && $edit_order['has_a_uez'] == '' && $edit_order['has_a_stform'] == '' ){ 
                            $order_tax = 0.00;
                            $taxV = 0.00;
                        }else if( $edit_order['resale_certificate'] != 'yes' && $edit_order['has_a_uez'] != 'yes' && $edit_order['has_a_stform'] != 'yes' ){
                            $order_tax = order_tax;
                            $taxV = $edit_order['tax'];
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
                        <?php $paid_amount = ( $edit_order['paid_amount'] ) ? decimalValue($edit_order['paid_amount']): '0.00';
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
                    <?php if ( $edit_order['ordering_note'] ) echo '<strong>Ordering Note:</strong> <p>'.$edit_order['ordering_note'].'</p>';  ?>
                    <?php if ( $edit_order['installation_note'] ) echo '<strong>Installation Note:</strong><p>'.$edit_order['installation_note'].'</p>';  ?>

                     <strong>This agreement for installation is based on the following terms and conditions:</strong>
                     <br>
												<ol class="contract_term">
						<h4>SELECTIONS:</h4>
							<li>Before we can start the scheduling process, all details must be confirmed, including but not limited to product, color, edge style(s), sink option(s) and backsplash option(s) and payments must be paid in full based on the final selected details.</li>
              <li>Actual slabs will be tagged and approved for the project prior to scheduling.</li>

						<h4>ESTIMATES:</h4>
							<li>Our estimate is based on the drawing provided by either the purchaser or the contractor.</li>
              <li>Prices are subject to change based on measurements taken at actual template.</li>
              <li>The price received includes one trip for templating and one trip for installation.</li>
              <li>Additional trips can be completed at an additional charge of $125.00 for each additional trip, scheduled on a day that that best meets our schedule demands.</li>
						
            <h4>SCHEDULING:</h4>
							<li>Template: All details must be confirmed prior to scheduling a template.</li>
              <li>Purchaser must be on site at time of template to confirm all information in writing.</li>
              <li>All items purchased outside of Perfection Kitchens, including but not limited to sinks, free standing range, slide in range, down draft and/or cook tops must be on site at time of template.</li>
              <li>Apron front/farm sinks must be installed prior to our template visit, unless the sink manufacturer suggests otherwise.</li>
              <li>All cabinets receiving countertops must be permanently installed, set, level and properly secured to the wall and/or floor and no adjustments are to be made after the completion of a template.</li>
              <li>Perfection Kitchens will not level or adjust cabinets not installed by Perfection.</li>
              <li>Perfection Kitchens HIGHLY recommends that NO ADJUSTMENTS be made after the completion of a template. If cabinets are adjusted after the completion of a template, a secondary template must be completed at an additional charge of $150.00.</li>
              <li>Perfection Kitchens.’s success rate is highest if we are able to template on bare cabinetry (no existing countertops). If your project is an existing kitchen or remodel and your existing countertops cannot be removed before your scheduled template, the countertops must be cleared and no fixtures, dishes, décor, etc. are to be left of the existing countertop. By choosing to template over an existing countertop, you are acknowledging that you understand the possibility for unnecessary gapping and acknowledge that Perfection Kitchens cannot be held responsible for said possible gapping. Tear out and disposal services are available at an extra service charge.</li>
              <li>Should the Purchaser choose to hire Perfection Kitchens to complete a tear out service, Perfection Kitchens cannot be held responsible for any patchwork that may be required after the tear out of your old countertop, including but not limited to wallpaper, tile, spackle, trim, mirrors, etc.</li>
              <li>Perfection Kitchens cannot accept any responsibility for the integrity of the cabinets or any knee walls after removal of the old countertops. Should Perfection Kitchens determine that there is an issue with your cabinets, the determination, if possible, will be made at the time of template and Perfection Kitchens reserves the right to re-schedule your template and/or installation until proper adjustments have been made.</li>

						<h4>FABRICATION:</h4>
							<li>Fabrication will not begin until all information has been confirmed in writing with the Purchaser, including but not limited to layout confirmation, sink information, any and all cut out information, edge profiles, etc.</li>
						  <li>There is a 24 hour grace period between template and fabrication that allows for any changes in the confirmed details without having to reschedule your installation date.</li>
              <li>Signed template dimensions will be placed on your slab by our fabrication team who will determine the best placement.</li>
              <li>Some granites have a great deal of variation and movement. For those purchasing this type of slab, an appointment to view the slabs prior to template date is highly recommended.</li>
              <li>Perfection Kitchens suggests that the Purchaser select their individual slabs, and complete a layout on any directional stones (stones with movement).</li>
                <ul>
                  <li>All layouts are required to be completed the next business day after template. This gives the Purchaser the opportunity to choose the quadrant of the stone and to discuss seam placement with our fabrication team. This layout process can also be completed via email.</li>
                </ul>
                <li>If the purchaser chooses to waive the right to a layout, the home owner therefore accepts the direction and color of the stone as well as the seam placement, as is.</li>
                <li>All seams are completed within stone industry standards. A copy of these standards are available in the Homeowner's Guide to Countertop Installation which can be found at http://www.marble-institute.com/consumers/index.cfm.</li>

            <h4>INSTALLATION:</h4>
							<li>Installation dates are scheduled 3-7 business days after the completion of your template, depending on selections, inventory and availability of material(s).</li>
              <li>The Purchaser must be on site at the time of installation and available to complete the Certification of Completion.</li>
              <li>Cabinets must be ready to accept the countertop installation.</li>
              <li>All plumbing must be disconnected prior to the delivery of the countertops.</li>
              <li>Our installation crew will attach an under mount sink and/or test fit your drop in sink and/or cook top stove. Perfection Kitchens does not install drop in sinks. This is the responsibility of individual that is reconnecting your plumbing.</li>
              <li>Unless specified on an installation agreement, Perfection Kitchens does not install your cooktop stove. This is the responsibility of the Purchaser or their contractor.</li>
              <li>Perfection Kitchens is not responsible for moving any major appliance(s). If appliance(s) cannot be moved before the installation date, a seam can be/will be added for installation purposes OR you have the option to sign the waiver on our Certificate of Completion agreeing that Perfection Kitchens cannot be held responsible for any damages caused by moving any appliances.</li>

						<h4>ADDITIONAL INFORMATION:</h4>
							 <li>All payments for materials and services must be paid in full prior to the day of installation. Should pricing increase after the completion of a template (including but not limited to a different type of material selected, different edging or more sq. footage), the balance must be paid in full within 24 hours and before fabrication begins. Should the new balance not be paid within the 24 hour grace period, Perfection Kitchens reserves the right to reschedule your installation date. </li>
               <li>Should there be a decrease in cost after the completion of a template, a refund will be mailed to you within 7 days after the completion of the installation.</li>
               <li>Perfection Kitchens does not do electrical work unless specified on an installation agreement.</li>
               <li>We ask that you DO NOT schedule any other trades such as plumbing, electrical work, floor preparation, etc on the same day as Perfection Kitchens is scheduled to be in your home. Should there be other trades scheduled at the same time as our services, we reserve the right to reschedule your installation.</li>
               <li>Perfection Kitchens does not mount or recommend mounting a dishwasher to the countertops. If a dishwasher is not mounted to the cabinetry we recommend using a dishwasher mounting bracket, which can be supplied at an additional and minimal charge.</li>
               <li>If the countertops are not correct for any reason, we need to be notified while the installation team is on site. After the countertops are installed, please check them over carefully prior to the installation team departing.</li>
               <li>We will not be responsible for any work that is done after the countertops are installed, including but not limited to tile, plumbing, painting, wallpaper, etc.</li>
               <li>Perfection will not be held liable for strikes, accidents weather or other delays beyond Perfection’s control.</li>
               <li>Any alteration or deviation from the above specifications involving extra work or costs will be executed only upon the written order signed by the Purchaser and will become an extra charge over and above the contract price.</li>
               <li>Any checks returned by the bank shall incur a “Returned Check” charge of $30.00.</li>
               <li>In the event of default, the Purchaser shall be responsible to pay attorney fees, collection costs and other fees associated with the enforcement of this agreement.</li>
               <li>Acceptance and Signing of "Purchaser Signature" on this order is final and binding, no cancellation after the three-day period will be allowed. No refunds, store credit, or exchanges will be provided.</li>
               <li>I find the preceding order has met his/her specifications.</li>
               <li>Final payment must be made via certified bank check, cashier's check, money order, credit card or cash.  Personal or business checks will not be accepted as final payment.</li>
               <li>This Agreement represents the entire agreement between the parties and shall be binding upon the parties and their heirs, successors and assigns.</li>
               <li>This Agreement may not be sold or assigned by any party except with the written consent of the other party.</li>
               <li>All notices required under the terms of this Agreement will be given and will be complete by mailing by certified or registered mail, return receipt requested, or by hand delivery, confirmed fax or overnight delivery service, to the address of the parties as shown at the beginning of this Agreement, or to such other address as may be designated in writing, which notice of change of address is given in the same manner.</li>
               <li>Any reference herein to the singular shall include the plural and vice versa. Any reference herein to the masculine shall include the feminine and vice versa.</li>
               <li>This Agreement shall be construed in accordance with the laws of the State of New Jersey.</li>
               <li>Should any provision of this Agreement be deemed unenforceable, the remaining provisions shall remain in full force and effect.</li>
               <li>The purchaser agrees that additions or deletions due to layout and order revisions of items totaling $1000.00 or less to this order does not require signed written consent, email authorization by the email listed on this contract will be sufficient.</li>
       
            <h4>DESCRIPTION OF SERVICES:</h4>
              <li>Perfection Kitchens will provide to Purchaser services as specified on this order as provided to the Purchaser by Perfection Kitchens. All material is guaranteed to be as specified. All work to be completed in a professional manner, according to standard practices. Any alteration or deviation from the description of services as indicated on this quote will be at an additional cost over and above this agreement.</li>
              <li>This agreement is contingent upon accidents or delays beyond our control. In the event of a breach of this contract, the non-defaulting party shall be entitled to seek reasonable attorney fees incurred in connection with such default.</li>
              <li>All balances not paid in accordance with this agreement will result in the charge of an interest rate of 2% per month (24% per year) applicable on the amount owed. </li>
              <li>If payment is not made in full, all warranties are null and void. </li>
              <li>The prices, specifications and conditions are satisfactory and are accepted.</li>
              <li>Perfection Kitchens is authorized to do the work specified. Payments will be made as outline above.</li>

						</ol>
						<ol class="contract_term">
						<h4>NOTICE TO PURCHASER:</h4>
						<p>YOU MAY CANCEL THIS CONTRACT AT ANY TIME BEFORE MIDNIGHT OF THE THIRD BUSINESS DAY AFTER RECEIVING A COPY OF THIS CONTRACT. IF YOU WISH TO CANCEL THIS CONTRACT, YOU MUST EITHER:</p>
							<li>SEND A SIGNED AND DATED WRITTEN NOTICE OF CANCELLATION BY REGISTERED OR CERTIFIED MAIL, RETURN RECEIPT REQUESTED; OR</li>
							<li>PERSONALLY DELIVER A SIGNED AND DATED WRITTEN NOTICE OF CANCELLATION TO:</li>
						</ol>
						<p>
							Perfection Associates, Limited Liability Company d/b/a Perfection Kitchens 1174 Fischer Blvd. Toms River, NJ 08753 TELEPHONE: (732) 270-9300; EMAIL: orders@perfectionkitchens.com<br>
							If you cancel this contract within the three-day period, you are entitled to a full refund of your money. Refunds must be made within 30 days of the contractor's receipt of the cancellation notice.<br>
							By signing this agreement, I, Purchaser and Owner, agree to the terms and conditions of the sale and have reviewed all of the Contract Documents and that the same accurately reflect kind and quality of the Work, including all materials, requested by Purchaser and Owner.<br>
						</p>

                  </div>
                  <br>
                  <div class="row">
                     <div class='col-md-4'>Purchaser Signature _______________</div>
                     <div class='col-md-4'>Date of Acknowledgements _______________</div>
                  </div>
                  <br><br><br>
                  <!-- <?php  if($edit_order['Is_Colourtone'] == 'yes'){ ?>
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
                  <?php } ?> -->
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