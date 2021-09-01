<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php $type =  $this->uri->segment(4); ?>
    <?php if( empty($role) ) return; extract($role); ?>
    <h4 class="custom-modal-title">Edit <?= $type; ?> Address</h4>
    <div class="custom-modal-text text-left">
        <?php $attributes = array('id' => 'edit_address'); echo form_open($this->uri->uri_string(),$attributes); ?>
        <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" class="form-control" id="" name="address_type"  value="<?php echo $type;?>" >
            <label for="name">Address</label>
            <input type="text" class="form-control" id="title" name="addressline_one" value="<?php echo $addressline_one; ?>" placeholder="Enter Address">
        </div>
        <div class="form-group">
            <label for="name">Address 2</label>
            <input type="text" class="form-control" id="title" name="addressline_two" value="<?php echo $addressline_two; ?>" placeholder="Enter Address">
        </div>
        <div class="form-group">
            <label for="name">City</label>
            <input type="text" class="form-control" id="title" name="city" value="<?php echo $city; ?>" placeholder="Enter  City">
        </div>
        <div class="form-group">
            <label for="name">State</label>
            <input type="text" class="form-control" id="title" name="state" value="<?php echo $state; ?>" placeholder="Enter  State">
        </div>
        <div class="form-group">
            <label for="name">Zipcode</label>
            <input type="text" class="form-control" id="title" name="zipcode" value="<?php echo $zipcode; ?>" placeholder="Enter  Country">
        </div>
        <?php if($type == "Billing"){ ?>
            <div class="form-group">
                <!-- <input type="checkbox" <?php if($shipping_option == 'yes') echo "checked"; ?> id="shipping_option" name="shipping_option" value="yes" > -->
                <!-- <label for="shipping_option">Check if shipping address is different from billing address.</label> -->
            </div>
        <?php } ?>
        <div class="text-right">
            <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>">
            <button type="submit" class="btn btn-success waves-effect waves-light save_btn" id="edit_add">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div> <?php echo form_close(); ?>
    </div>
</div>
<style type="text/css">
    .save_btn {
      width: auto;
      display: inline;
    }
</style>