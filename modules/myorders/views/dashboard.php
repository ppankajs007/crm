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
                     <li class="breadcrumb-item"><a href=" <?php echo base_url()."orders/".$this->uri->segment(4); ?>">Dashboard</a></li>
                     <li class="breadcrumb-item active">Add Order</li>
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
                     <?php  echo modules::run('includes/order_sub_menu');?>
                  </ul>
                  <div class="clear"></div>
                  <br>
                  <?= form_open(); ?>
                 
                    <div class="row">
                       <div class="col-6" >
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Status</label>
                             </div>
                             <div class="col-md-9">
                                <select  class="form-control" name="status">
                                   <option value=''>Select Option</option>
                                   <option value="Pre-Order" <?php  if( $edit_order['status'] == "Pre-Order"){ echo "selected";} ?> >Pre-Order</option>
                                   <option value="Ordered" <?php  if( $edit_order['status'] == "Ordered"){ echo "selected";} ?> >
                                      Ordered
                                   </option>
                                   <option value="Delivered" <?php  if( $edit_order['status'] == "Delivered"){ echo "selected";} ?> > Delivered</option>
                                   <option value="Closed" <?php  if( $edit_order['status'] == "Closed"){ echo "selected";} ?> >Closed</option>
                                </select>
                             </div>
                          </div>
                       </div>
                    </div>
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Sale Primary</label>
                             </div>
                             <div class="col-md-9">
                                 <select  class="form-control" name="sales_primary">
                                   <option value=''>Select Option</option>
                                   <?php
                                    foreach( $users as $key => $value ){ ?>
                                        <option value='<?= $value->user_id; ?>' <?php if( $value->user_id == $edit_order['user_id'] ){ echo 'selected'; }  ?> >
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
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Sales - Secondary</label>
                             </div>
                             <div class="col-md-9">
                                 <select  class="form-control" name="sales_primary">
                                   <option value=''>Select Option</option>
                                   <?php
                                    foreach( $users as $key => $value ){ ?>
                                        <option value='<?= $value->user_id; ?>' <?php if( $value->user_id == $edit_order['user_id'] ){ echo 'selected'; }  ?> >
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
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Vendor</label>
                             </div>
                             <div class="col-md-9 row">
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
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Is Pickup</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?= ucfirst( $edit_order['is_pickup']); ?> Pick Up Person (s) </p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Has a Resale Certificate</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?= ucfirst( $edit_order['resale_certificate']); ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Taxes Multiplier ( % )</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?php $tax = ucfirst( $edit_order['texes_multiplier']); echo (!$tax) ? '00' : '$'.$tax; ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Total</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?php $ttl = ucfirst( $edit_order['total']); echo (!$ttl) ? '00' : '$'.$ttl; ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Total Due</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?php $ttl_due = ucfirst( $edit_order['total_due']); echo (!$ttl_due) ? '00' : '$'.$ttl_due; ?>&nbsp 
                                    <label for="Item_Name" class="col-form-label" >
                                        Paid &nbsp <?php $paid = ucfirst( $edit_order['paid']); echo (!$paid) ? '00' : '$'.$paid; ?>
                                    </label> &nbsp 
                                    <label for="Item_Name" class="col-form-label" >
                                        Refunded &nbsp <? $ref= ucfirst( $edit_order['refunded']); echo (!$ref) ? '00' : '$'.$ref; ?>
                                    </label>
                                </p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Amount Spent</label>
                             </div>
                             <div class="col-md-9">
                                <p class="col-form-label" ><?php $aspend = ucfirst( $edit_order['amount_spent']); echo (!$aspend) ? '00' : '$'.$ref; ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >First Name</label>
                             </div>
                             <div class="col-md-9">
                                <input type="text" class="form-control" name="first_name" 
                                value="<?= $edit_order['first_name']; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Last Name</label>
                             </div>
                             <div class="col-md-9">
                                <input type="text" class="form-control" name="last_name" 
                                value="<?= $edit_order['last_name']; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Requested Delivery Date</label>
                             </div>
                             <div class="col-md-9">
                                 <p class="col-form-label" ><?= ucfirst( $edit_order['requested_delivery_date']); ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Requested Delivery Date Notes</label>
                             </div>
                             <div class="col-md-9">
                                 <p class="col-form-label" ><?= ucfirst( $edit_order['requested_date_notes']); ?></p>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
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
                    </div>
                    
                     <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Estimated Delivery Date</label>
                             </div>
                             <div class="col-md-9">
                                <input type="text" class="form-control" id="estimated_delivery_date" name="estimated_delivery_date" 
                                value="<?= $edit_order['estimated_delivery_date']; ?>"/>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Estimated Delivery Date Notes</label>
                             </div>
                             <div class="col-md-9">
                                <textarea class="form-control" id="" name="estimated_date_notes" ><?= $edit_order['estimated_date_notes']; ?></textarea>
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=row>
                       <div class="col-6">
                          <div class="form-group row">
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Scheduled Delivery Date</label>
                             </div>
                             <div class="col-md-9">
                                <input type="text" class="form-control" id="scheduled_delivery_date" name="schedule_delivery_date" 
                                value="<?= $edit_order['schedule_delivery_date']; ?>">
                             </div>
                          </div>
                       </div>
                    </div>
                    
                    <div class=" col-md-6 ">
                        <div class=" form-group row">
                           <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Survey</label>
                           </div>
                           <div class="col-md-9 col-form-label">
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
                             <div class="col-md-3">
                                <label for="Item_Name" class="col-form-label" >Survey Date</label>
                             </div>
                             <div class="col-md-9">
                                <input type="text" class="form-control" id="survey_date" name="survey_date" value="<?= $edit_order['survey_date']?>">
                             </div>
                          </div>
                       </div>
                    </div>
                    
                  <div class="text-right">
                      <input type="submit" class="btn btn-success waves-effect waves-light" value="Save" id="save_">
                  </div>
                  <?= form_close() ?>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>