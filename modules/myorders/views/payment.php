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
                  <h4 class="page-title">Expenses</h4>
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
                     <div class=row>
                        <div class="col-6">
                           <div class="form-group">
                              <label for="">Total</label>
                              <input type="text" class="form-control total price" id="total" name="total" 
                                 value="<?= $edit_order['total']; ?>">
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group">
                              <label for="">Paid </label>
                              <input type="text" class="form-control paid price" id="paid" name="paid" 
                                 value="<?= $edit_order['paid']; ?>" >  
                           </div>
                        </div>
                     </div>
                     <div class=row>
                        <div class="col-6">
                           <div class="form-group">
                              <label for="first_name">Amount Spent</label>
                              <input type="text" class="form-control amount_spent price"  id="amount_spent" name="amount_spent"
                                 value="<?= $edit_order['amount_spent']; ?>" />  
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group">
                              <label for="">Refunded</label>
                              <input type="text" class="form-control refunded price" id="" name="refunded"
                                 value="<?= $edit_order['refunded']; ?>" > 
                           </div>
                        </div>
                     </div>
                     <div class=row>
                        <div class="col-6">
                           <div class="form-group">
                              <label for="">Discount ( % )</label>
                              <input type="text" class="form-control discount price" name="discount"
                                 value="<?= $edit_order['discount']; ?>" /> 
                           </div>
                        </div>
                        <div class="col-6">
                           <div class="form-group">
                              <label for="">Taxes Multiplier ( % )</label>
                              <input type="text" class="form-control texes_multiplier price" name="texes_multiplier"
                                 value="<?= $edit_order['texes_multiplier']; ?>" /> 
                           </div>
                        </div>
                     </div>
                     <div class=row>
                        <div class="col-6">
                           <div class="form-group"> 
                              <label for="">Total Due </label>
                              <input type="text" class="form-control total_due price" id="total_due" name="total_due"
                                 value="<?= $edit_order['total_due']; ?>" >
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