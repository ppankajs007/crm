<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php $type =  $this->uri->segment(4); 

    ?>
    <h4 class="custom-modal-title">Add Address</h4>
    <div class="custom-modal-text text-left">
        <?php $attributes = array('id' => 'form_address'); echo form_open($this->uri->uri_string(),$attributes); ?>
        <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" class="form-control" id="" name="address_type"  value="<?php echo $type;?>" >
            <label for="name">Billing Address</label>
            <input type="text" class="form-control" id="" name="addressline_one" placeholder="Enter Address" >
        </div>
       
        <div class="form-group">
            <label for="name">Billing Address 2</label>
            <input type="text" class="form-control" id="" name="addressline_two" placeholder="Enter Address" >
        </div>
        <div class="form-group">
            <label for="name">Billing City</label>
            <input type="text" class="form-control" id="title" name="city" value="" placeholder="Enter City">
        </div>
        <div class="form-group">
            <label for="name">Billing State</label>
            <input type="text" class="form-control" id="" name="state" placeholder="Enter State" >
        </div>
        <div class="form-group">
            <label for="name">Billing Zipcode</label>
            <input type="text" class="form-control" id="" name="zipcode" placeholder="Enter Zipcode" >
        </div>
        <?php// if($shipping_address != "yes"){?>
            <div class="form-group">
                <input type="checkbox" id="shipping_option" name="shipping_option" value="yes" >
                <label for="shipping_option">Check if shipping address is different from billing address.</label>
            </div>
        <?php// }else{ ?>
            <!-- <input type="hidden" id="shipping_option" name="shipping_address" value="yes" > -->
        <?php //} ?>
      
   
        <div id="shipping-content" style="display:none;">
            <div class="form-group">
                <label for="name">Shipping Address</label>
                <input type="text" class="form-control" id="" name="s_addressline_one" placeholder="Enter Address" >
            </div>
           
            <div class="form-group">
                <label for="name">Shipping Address 2</label>
                <input type="text" class="form-control" id="" name="s_addressline_two" placeholder="Enter Address" >
            </div>
            <div class="form-group">
                <label for="name">Shipping City</label>
                <input type="text" class="form-control" id="title" name="s_city" value="" placeholder="Enter City">
            </div>
            <div class="form-group">
                <label for="name">Shipping State</label>
                <input type="text" class="form-control" id="" name="s_state" placeholder="Enter State" >
            </div>
            <div class="form-group">
                <label for="name">Shipping Zipcode</label>
                <input type="text" class="form-control" id="" name="s_zipcode" placeholder="Enter Zipcode" >
            </div>
        </div>
        <div class="text-right">
            <input type="hidden" name="customer_id" value="<?php echo $this->uri->segment(3);?>">
            <button type="submit" name="save_address" class="btn btn-success waves-effect waves-light save_btn save_address" id="save_address">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div><?php echo form_close(); ?>
    </div>
</div>

<style type="text/css">
    
    .save_btn {
      width: auto;
      display: inline;
    }
</style>