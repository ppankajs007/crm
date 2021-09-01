  <style>
  	.error {
    display: none;
    width: 100%;
    margin-top: .25rem;
    font-size: .75rem;
    color: #f1556c;
    display: block;
}
	.task_b {
    position: absolute;
    visibility: hidden;
}

  </style>
        
    <div class="content-pageee">
                <div class="content"><!-- Start Content-->
                    <div class="container-fluid"><!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/leads">Order</a></li>
                                            <!--<li class="breadcrumb-item"><a href="<?php// echo base_url();?>crm/leads/dashboard/<?php// echo $id; ?>">Dashboard</a></li>-->
                                             <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/leads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
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
                    <?php $attr = array( 'id' => 'add_order'); echo form_open($this->uri->uri_string(),$attr); ?>
                    
                    <div class=row>
                    <div class="col-6">
                        
                          <div class="form-group">
                            <label for="Item_Name">Status</label>
                            <input type="hidden" name="customer_id" id="customer_id" value="<?php echo  $Cid = $this->uri->segment(3);?>">
                        <select  class="form-control" name="status">
                           <option value="">Select Option</option>
                           <option value="Pre-Order">Pre-Order</option>
                           <option value="Ordered">Ordered</option>
                           <option value="Delivered">Delivered</option>
                           <option value="Closed">Closed</option>
          </select>
     </div>
           
                     
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Sales - Primary</label>
                        <input type="text" class="form-control" name="sales_primary" />  
                    </div>
                </div></div>
                    <div class=row>
                    <div class="col-6">
                  <div class="form-group">
                        <label for="">Sales - Secondary</label>
                        <input type="text" class="form-control" name="sales_secondary" />  
                    </div>
                </div>
                <div class="col-6">
                       <div class="form-group">
                        <label for="last_name">Vendor</label>
                      <select class="form-control" id="vendor" name="vendor" > 
                        
                            <?php 
                    
                       foreach ($users as $us)
                        {
                            
                          
                       ?> 
                        <option value="<?php echo $us['id'];?>" <?php echo (($us['id']=='')?"selected":""); ?> id="0"><?php echo $us['name'];?></option>
                        <?php }?>
                        </select>
                    </div>
                </div>
            </div>
             <div class=row>
                    <div class="col-6">
             <div class="form-group">
                        <label for="first_name">Vendor Invoice</label>
                         <input type="text" class="form-control" name="vendor_invoice" />  
                         
                    </div>
                   </div> 
                    <div class="col-6">
                  <div class="form-group">
                        <label for="first_name">Type </label>
                        <select name="product_type" class="form-control">
                            <option>Cabinets</option>
                            <option>Countertops</option>
                            <option>Backsplash</option>
                            <option>Installation</option>
                            <option>Measurements</option>
                         </select>
                    </div>
                  </div>
                </div>
               <div class=row>
                   <div class="col-6">
                        <div class="form-group">
                            <label for="first_name">Is Pickup</label>
                             <input type="text" class="form-control" name="is_pickup" />  
                             
                        </div>
                </div>
                <div class="col-md-6">
                       <div class="form-group">
                        <label for="last_name">Has a Resale Certificate</label>
                         <input type="text" class="form-control" name="resale_certificate" />  
                    </div>
              </div>
               </div>
                 <div class=row>
            <div class="col-md-6">
          <div class="form-group">
                        <label for="">Taxes Multiplier</label>
                         <input type="text" class="form-control" name="texes_multiplier" /> 
                    </div>

            </div>
           
            
               <div class="col-md-6">

          <div class="form-group">
                        <label for="">Total</label>
                        <input type="text" class="form-control" id="" name="total">
                    </div>
            
                </div>
                </div>
                 <div class=row>
             <div class="col-md-6">
               <div class="form-group">
                        <label for="">Total Due </label>
                        <input type="text" class="form-control" id="" name="total_due" >
               </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                        <label for="">Paid </label>
                        <input type="text" class="form-control" id="" name="paid" >
                    </div>
              </div>
              </div>
               <div class=row>
              <div class="col-md-12">
                <div class="form-group">
                        <label for="">Refunded</label>
                        <input type="text" class="form-control" id="" name="refunded" > 
                    </div>
              </div>
              </div>
           
       
            <div class="row">
                <div class="col-md-6">
                    <?php  $customer_name = App::get_row_by_where('customer', array( 'id' => $Cid = $this->uri->segment(3) ) );
                    $name = $customer_name->full_name;
                    $firstname = strtok($name,' ');
                    $lastname = strstr($name,' '); 
                    ?>
                    <div class="form-group">
                        <label for="">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo $firstname;?>" >
                    </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" class="form-control" id="" name="last_name" value="<?php echo $lastname;?>" >
                    </div>
              </div>
            </div>

     <div class="row">
       <div class="col-md-6">
              <div class="form-group">
                        <label for="">Requested Delivery Date</label>
                        <input type="text" class="form-control" id="requested_delivery_date" name="requested_delivery_date" >
                    </div>
                  </div>
                   <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Requested Delivery Date Notes</label>
                        <input type="text" class="form-control" id="notes" name="requested_date_notes" >
                    </div>
                  </div>
                </div>
                 <div class="row">
       <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Hard Date</label>
                        <input type="text" class="form-control" id="hard_date" name="hard_date" >
                    </div>
                  </div>
       <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Estimated Delivery Date</label>
                        <input type="text" class="form-control" id="estimated_delivery_date" name="estimated_delivery_date" >
                    </div>
                  </div>
                </div>
                    <div class="row">
       <div class="col-md-6">
                       <div class="form-group">
                        <label for="">Estimated Delivery Date Notes</label>
                        <input type="text" class="form-control" id="" name="estimated_date_notes" >
                    </div>
                  </div>
       <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Schedule Delivery Date</label>
                        <input type="text" class="form-control" id="schedule_delivery_date" name="schedule_delivery_date" >
                    </div>
                  </div>
                </div>
                  <div class="row">
       <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Show Delivery Details</label>
                        <input type="text" class="form-control" id="" name="show_delivery_details" >
                    </div>
                  </div>
                    <div class="col-md-6">
                     <div class="form-group">
                        <label for="">Survey Required</label>
                        <input type="text" class="form-control" id="" name="survey" >
                    </div>
                  </div>
                </div>
                    <div class="form-group">
                        <label for="">Survey Date</label>
                        <input type="text" class="form-control" id="survey_date" name="survey_date" >
                    </div>
                    
                

        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
                  </form>
              </div>
              <?php echo form_close(); ?>
          </div>
      
            </div>
      
           </div></div>
   

       