<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php if( empty($vendor) ) return; ?>
    <h4 class="custom-modal-title">Edit Vendor</h4>
    <div class="custom-modal-text text-left">
        <?php $attributes = array('id' => 'form'); echo form_open($this->uri->uri_string(),$attributes); ?>
        <input type="hidden" id="id" name="vendor_id" value='<?php echo $vendor['id'];?>'>
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" class="form-control" value='<?php echo $vendor["name"];?>' name="name" placeholder="Enter Name">
        </div>        
        <div class="form-group">
            <label for="name">Address</label>
            <input type="text" class="form-control" value='<?php echo $vendor["addressline_one"];?>' name="addressline_one">
        </div>
        <div class="form-group">
            <label for="name">Address 2</label>
            <input type="text" class="form-control" value='<?php echo $vendor["addressline_two"];?>' name="addressline_two">
        </div>
        <div class="form-group">
            <label for="name">City</label>
            <input type="text" class="form-control" value='<?php echo $vendor["city"];?>' name="city">
        </div>
        <div class="form-group">
            <label for="name">State</label>
            <input type="text" class="form-control" value='<?php echo $vendor["state"];?>' name="state">
        </div>
        <div class="form-group">
            <label for="name">Zipcode</label>
            <input type="text" class="form-control" value='<?php echo $vendor["zipcode"];?>' name="zipcode">
        </div>
        <div class="form-group">
            <label for="">Office Phone</label>
            <input type="text" class="form-control" value='<?php echo $vendor["office_phone"];?>' name="office_phone">
        </div>
        <div class="form-group">
            <label for="">Ext</label>
            <input type="text" class="form-control" value='<?php echo $vendor["ext"];?>' name="ext">
        </div>
        <div class="form-group">
            <label for="">Website</label>
            <input type="text" class="form-control" value='<?php echo $vendor["website"];?>' name="website">
        </div>
        <div class="form-group">
            <label for="">Order Processor</label>
            <input type="text" class="form-control" value='<?php echo $vendor["order_processor"];?>' name="order_processor">
        </div>
        <div class="form-group">
            <label for="">Order Processor Email</label>
            <input type="text" class="form-control" value='<?php echo $vendor["order_processor_email"];?>'name="order_processor_email">
        </div>
        <div class="form-group">
            <label for="">Order Processor Phone</label>
            <input type="text" class="form-control" value='<?php echo $vendor["order_processor_phone"];?>' name="order_processor_phone">
        </div>
        <div class="form-group">
            <label for="">Inside Sales Rep</label>
            <input type="text" class="form-control" value='<?php echo $vendor["inside_sales_rep"];?>' name="inside_sales_rep">
        </div>
        <div class="form-group">
            <label for="">Inside Sales Email</label>
            <input type="text" class="form-control" value='<?php echo $vendor["inside_sales_email"];?>' name="inside_sales_email">
        </div>
        <div class="form-group">
            <label for="">Inside Sales Phone</label>
            <input type="text" class="form-control" value='<?php echo $vendor["inside_sales_phone"];?>' name="inside_sales_phone">
        </div>
        <div class="form-group">
            <label for="">Outside Sales Rep</label>
            <input type="text" class="form-control" value='<?php echo $vendor["outside_sales_rep"];?>' name="outside_sales_rep">
        </div>        
        <div class="form-group">
            <label for="">Outside Sales Email</label>
            <input type="text" class="form-control" value='<?php echo $vendor["outside_sales_email"];?>' name="outside_sales_email">
        </div>
        <div class="form-group">
            <label for="">Outside Sales Phone</label>
            <input type="text" class="form-control" value='<?php echo $vendor["outside_sales_phone"];?>' name="outside_sales_phone">
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div><?php echo form_close(); ?>
    </div>
</div>
<style type="text/css">
.error { 
    color:red;
}
</style>


