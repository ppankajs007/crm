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
                                <li class="breadcrumb-item active">Adds Order</li>
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
                            <?php $attr = array( 'id' => 'edit_order'); echo form_open($this->uri->uri_string(),$attr); ?>
                              <div class="row">
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="">First Name</label>
                                          <input type="text" class="form-control" id="first_name" name="first_name"
                                              value="<?= $edit_order['first_name']; ?>" >
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="form-group">
                                          <label for="">Last Name</label>
                                          <input type="text" class="form-control" id="" name="last_name" 
                                              value="<?= $edit_order['last_name']; ?>" >
                                      </div>
                                  </div>
                              </div>
                              <div class=row>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="Item_Name">Status</label>
                                          <select  class="form-control" name="status">
                                              <option>Select Option</option>
                                              <option value="Pre-Order" <?php  if( $edit_order['status'] == "Pre-Order"){ echo "selected";} ?> >Pre-Order</option>
                                              <option value="Ordered" <?php  if( $edit_order['status'] == "Ordered"){ echo "selected";} ?> >
                                              Ordered</option>
                                              <option value="Delivered" <?php  if( $edit_order['status'] == "Delivered"){ echo "selected";} ?> > Delivered</option>
                                              <option value="Closed" <?php  if( $edit_order['status'] == "Closed"){ echo "selected";} ?> >Closed</option>
                                          </select>
                                      </div> 
                                  </div>
                                  <div class="col-6">
                                      <div class="form-group">
                                          <label for="last_name">Vendor</label>
                                          <select class="form-control" id="vendor" name="vendor" >
                                            <?php 
                                               foreach ($users as $us)
                                               { ?> 
                                                    <option value="<?php echo $us['id'];?>" <?php echo (($us['id']==$edit_order['vendor'])?"selected":""); ?> o_id = '<?php echo $this->uri->segment(4); ?>'><?php echo $us['name'];?></option>
                                            <?php }?>
                                          </select>  
                                      </div>
                                  </div>
                              </div>
                              <div class=row>
                                  <div class="col-12">
                                      <div class="form-group">
                                          <label for="first_name">Vendor Invoice</label>
                                           <input type="text" class="form-control" name="vendor_invoice"
                                              value="<?= $edit_order['vendor_invoice']; ?>" /> 
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
                                          <input type="text" class="form-control" id="notes" name="notes" >
                                      </div>
                                  </div>
                              </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Hard Date</label>
                                        <input type="text" class="form-control" id="hard_date" name="hard_date"
                                        value="" >
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
                                        <input type="text" class="form-control" id="" name="notes" >
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
                                        <input type="text" class="form-control" id="" name="show_delivery_details"
                                            value="<?= $edit_order['show_delivery_details']; ?>" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Survey Required</label>
                                        <input type="text" class="form-control" id="" name="survey"
                                            value="<?= $edit_order['survey']; ?>" >
                                    </div>
                                </div>
                                
                                <div class="col-6">
                                  <div class="form-group">
                                      <label for="">Survey Date</label>
                                      <input type="text" class="form-control" id="survey_date" name="survey_date">
                                  </div>
                                </div>
                                <div class="col-6">
                                      <div class="form-group">
                                           <label for="last_name>Has a Resale Certificate</label>
                                          <input type="text" class="form-control" name="resale_certificate"
                                              value="<?= $edit_order['resale_certificate']; ?>" /> 
                                      </div>
                                  </div>
                            </div>                       
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Save</button>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
   

       