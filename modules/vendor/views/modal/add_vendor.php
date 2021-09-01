<div class="modal-demo">
    <?php $attributes = array('id' => 'form');  echo form_open($this->uri->uri_string(),$attributes);  ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Vendor</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="name">Company Name</label>
            <input type="text" class="form-control" id="name1" name="name" placeholder="Enter Name">
        </div>        
        <div class="form-group">
            <label for="name">Address</label>
            <input type="text" class="form-control" id="" name="addressline_one">
        </div>
        <div class="form-group">
            <label for="name">Address 2</label>
            <input type="text" class="form-control" id="" name="addressline_two">
        </div>
        <div class="form-group">
            <label for="name">City</label>
            <input type="text" class="form-control" id="title" name="city">
        </div>
        <div class="form-group">
            <label for="name">State</label>
            <input type="text" class="form-control" id="" name="state">
        </div>
        <div class="form-group">
            <label for="name">Zipcode</label>
            <input type="text" class="form-control" id="" name="zipcode">
        </div>
        <div class="form-group">
            <label for="">Office Phone</label>
            <input type="text" class="form-control" name="office_phone">
        </div>
        <div class="form-group">
            <label for="">Ext</label>
            <input type="text" class="form-control" name="ext">
        </div>
        <div class="form-group">
            <label for="">Website</label>
            <input type="text" class="form-control" name="website">
        </div>
        <div class="form-group">
            <label for="">Order Processor</label>
            <input type="text" class="form-control" name="order_processor">
        </div>
        <div class="form-group">
            <label for="">Order Processor Email</label>
            <input type="text" class="form-control" name="order_processor_email">
        </div>
        <div class="form-group">
            <label for="">Order Processor Phone</label>
            <input type="text" class="form-control" name="order_processor_phone">
        </div>
        <div class="form-group">
            <label for="">Inside Sales Rep</label>
            <input type="text" class="form-control" name="inside_sales_rep">
        </div>
        <div class="form-group">
            <label for="">Inside Sales Email</label>
            <input type="text" class="form-control" name="inside_sales_email">
        </div>
        <div class="form-group">
            <label for="">Inside Sales Phone</label>
            <input type="text" class="form-control" name="inside_sales_phone">
        </div>
        <div class="form-group">
            <label for="">Outside Sales Rep</label>
            <input type="text" class="form-control" name="outside_sales_rep">
        </div>        
        <div class="form-group">
            <label for="">Outside Sales Email</label>
            <input type="text" class="form-control" name="outside_sales_email">
        </div>
        <div class="form-group">
            <label for="">Outside Sales Phone</label>
            <input type="text" class="form-control" name="outside_sales_phone">
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>     
    </div><?php echo form_close(); ?>
</div>
<style type="text/css">
.error { 
    color:red;
}
</style>