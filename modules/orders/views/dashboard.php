<div class="content-pageee">
<div class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="page-title-box">
               <div class="page-title-right">
                  <ol class="breadcrumb m-0">
                     <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url().'orders';?>">Orders</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$edit_order['customer_id']; ?>"><?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
                     <li class="breadcrumb-item">Order For <?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></li>
                  </ol>
               </div>
               <h4 class="page-title">Order</h4>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-body">
                  <ul class="overview_list" id="lead_sub_menu">

                     <?php if ( $edit_order['vendor'] != 2 ) {
                      echo modules::run('includes/order_sub_menu');
                    }else{
                      echo modules::run('includes/faborder_sub_menu');
                    } ?>

                       
                  </ul>
                  <div class="clear"></div>
                  <br>
                  <?= form_open(); ?>
                 
                    <div class="row">
                       <div class="col-6" >
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Status</label>
                             </div>
                             <div class="col-md-8">
                                <select  class="form-control" name="status">
                                   <option value=''>Select Option</option>
                                  <?php 
                                    $ordSt = json_decode( order_statuses );
                                    foreach ($ordSt as $key => $value) {
                                        if( $edit_order['status'] == $value){ 
                                            $sl = 'selected'; 
                                        }else{ 
                                            $sl = ''; 
                                        };
                                        echo "<option value='$value' $sl>$value</option>";
                                    }
                                  ?>   
                                </select>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Sale Primary</label>
                             </div>
                             <div class="col-md-8">
                                 <select  class="form-control" name="sales_primary">
                                   <option value=''>Select Option</option>
                                   <?php
                                    foreach( $users as $key => $value ){ ?>
                                        <option value='<?= $value->user_id; ?>' <?php if( $value->user_id == $edit_order['sales_primary'] ){ echo 'selected'; }  ?> >
                                            <?= $value->name; ?>
                                        </option>
                                    <?php }
                                   
                                   ?>
                                 </select>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Sales - Secondary</label>
                             </div>
                             <div class="col-md-8">
                                 <select  class="form-control" name="sales_secondary">
                                   <option value=''>Select Option</option>
                                   <?php
                                    foreach( $users as $key => $value ){ ?>
                                        <option value='<?= $value->user_id; ?>' <?php if( $value->user_id == $edit_order['sales_secondary'] ){ echo 'selected'; }  ?> >
                                            <?= $value->name; ?>
                                        </option>
                                    <?php }
                                   
                                   ?>
                                 </select><!--
                                <input type="text" class="form-control" name="sales_secondary" 
                                value="<? //$edit_order['sales_secondary']; ?>"/>-->
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Vendor</label>
                             </div>
                             <div class="col-md-8 row">
                                 <div class="col-md-5">
                                    <?= $my_vendorusers[0]->name; ?> &nbsp;&nbsp; <label class="col-form-label"> <span>Invoice #</span> </label>
                                 </div>
                                 <div class="col-md-7">
                                    <input type="text" class="form-control" style="width:auto;" name="vendor_invoice"
                                        value="<?= $edit_order['vendor_invoice']; ?>" />
                                </div>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Is Pickup</label>
                             </div>
                             <div class="col-md-8">
                                <p class="col-form-label" ><?= ucfirst( $edit_order['is_pickup']); ?> Pick Up Person (s) </p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Has a Resale Certificate</label>
                             </div>
                             <div class="col-md-8">
                                <p class="col-form-label" ><?= ucfirst( $edit_order['resale_certificate']); ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Taxes Multiplier ( % )</label>
                             </div>
                             <div class="col-md-8">
                                <p class="col-form-label" ><?php $tax = ucfirst( $edit_order['texes_multiplier']); echo (!$tax) ? '00' : '$'.$tax; ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Total</label>
                             </div>
                             <div class="col-md-8">
                                <p class="col-form-label" ><?php $ttl = ucfirst( $edit_order['total']); echo (!$ttl) ? '00' : '$'.$ttl; ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Total Due</label>
                             </div>
                              <?php if ( !empty( $payment ) ) $paid = 0;
                                        foreach ($payment as $key => $value){ $paid += $value['payment_amount']; }
                              ?>
                             <div class="col-md-8">
                                <p class="col-form-label" ><?php $ttd = $edit_order['total'] - $paid; echo '$'.decimalValue($ttd); ?>&nbsp 
                                    <label for="Item_Name" class="col-form-label" >
                                      Paid &nbsp <?= '$'.decimalValue($paid); ?>
                                    </label> &nbsp 
                                    <!-- <label for="Item_Name" class="col-form-label" >
                                        Refunded &nbsp <? $ref= ucfirst( $edit_order['refunded']); echo (!$ref) ? '00' : '$'.$ref; ?>
                                    </label> -->
                                </p>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="refunded" class="col-form-label" >Refunded</label>
                             </div>
                             <div class="col-md-8">
                                <span>$</span><input type="text" style="display: inline-block;width: 80px;margin-left: 4px;border: 1px solid #ccc;padding: 3px 6px;box-shadow: none;height: auto;" class="form-control" name="refunded" 
                                value="<?php echo ($edit_order['refunded']) ?:'0.00'; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Amount Spent</label>
                             </div>
                             <div class="col-md-8">
                              <?php if ( !empty( $expenses_amt ) ) {
                                      $amount_spent = 0;
                                      foreach ($expenses_amt as $key => $value) {
                                        $amount_spent += $value['total']; 
                                      }
                              } ?>
                                <p class="col-form-label" ><?= '$'.decimalValue($amount_spent); ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >First Name</label>
                             </div>
                             <div class="col-md-8">
                                <input type="text" class="form-control" name="first_name" 
                                value="<?= $edit_order['first_name']; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Last Name</label>
                             </div>
                             <div class="col-md-8">
                                <input type="text" class="form-control" name="last_name" 
                                value="<?= $edit_order['last_name']; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Requested Delivery Date</label>
                             </div>
                             <div class="col-md-8">
                                 <p class="col-form-label" >
                                  <?php echo $edit_order['requested_delivery_date']; ?>
                                  <?php if( $edit_order['hard_date'] == 'yes' ){ 
                                    echo "<span style='color:red'>- Hard Date</span>"; 
                                  } ?> 
                                 </p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Requested Delivery Date Notes</label>
                             </div>
                             <div class="col-md-8">
                                 <p class="col-form-label" ><?= ucfirst( $edit_order['requested_date_notes']); ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    <!-- <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Hard Date</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?= ucfirst( $edit_order['hard_date']); ?></p>
                             </div>
                          </div>
                       </div>
                    </div> -->
                     <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Estimated Delivery Date</label>
                             </div>
                             <div class="col-md-8">
                                <input type="text" class="form-control" id="estimated_delivery_date" name="estimated_delivery_date" 
                                value="<?= $edit_order['estimated_delivery_date']; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Estimated Delivery Date Notes</label>
                             </div>
                             <div class="col-md-8">
                                <textarea class="form-control" id="" name="estimated_date_notes" ><?= $edit_order['estimated_date_notes']; ?></textarea>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Scheduled Delivery Date</label>
                             </div>
                             <div class="col-md-8">
                                <input type="text" class="form-control" id="scheduled_delivery_date" name="schedule_delivery_date" 
                                value="<?= $edit_order['schedule_delivery_date']; ?>">
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=" col-md-6 ">
                        <div class=" form-group row">
                           <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Survey</label>
                           </div>
                           <div class="col-md-8 col-form-label">
                               <div class="radio radio-info form-check-inline">
                                    <input type="radio" id="inlineRadioSurvey1" value="no" name="survey"  <?php if( $edit_order['survey'] == 'no' ){ echo "checked"; } ?>>
                                    <label for="inlineRadioSurvey1"> No </label>
                               </div>
                               <div class="radio radio-info form-check-inline">
                                   <input type="radio" id="inlineRadioSurvey2" value="yes" name="survey" <?php if( $edit_order['survey'] == 'yes' ){ echo "checked"; } ?>>
                                   <label for="inlineRadioSurvey2"> Yes </label>
                               </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-4">
                                <label for="Item_Name" class="col-form-label" >Survey Date</label>
                             </div>
                             <div class="col-md-8">
                                <input type="text" class="form-control" id="survey_date" name="survey_date" value="<?= $edit_order['survey_date']?>">
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class=row>
                      <div class="col-md-12">
                          <input type="submit" class="btn btn-success waves-effect waves-light" value="Save" id="save_">
                      </div>
                    </div>
                  </div>
                  <?= form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>