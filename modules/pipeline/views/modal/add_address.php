<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Address</h4>
    <div class="custom-modal-text text-left">
        <?php $attributes = array('id' => 'form_address'); echo form_open($this->uri->uri_string(),$attributes);
        $type =  $this->uri->segment(4);
        ?>
        <div class="form-group">
            <label for="name">Address</label>
            <input type="hidden" class="form-control" id="" name="address_type"  value="<?php echo $type;?>" >
            <input type="text" class="form-control" id="" name="addressline_one" placeholder="Enter Address" >
        </div>
       
        <div class="form-group">
            <label for="name">Address 2</label>
            <input type="text" class="form-control" id="" name="addressline_two" placeholder="Enter  Address" >
        </div>
        <div class="form-group">
            <label for="name">State</label>
            <input type="text" class="form-control" id="" name="state" placeholder="Enter  State" >
        </div>
        <div class="form-group">
            <label for="name">Country</label>
            <input type="text" class="form-control" id="" name="city" placeholder="Enter  city" >
        </div>
        <div class="form-group">
            <label for="name">Zipcode</label>
            <input type="text" class="form-control" id="" name="zipcode" placeholder="Enter  Zipcode" >
        </div>
        <div class="form-group">
            <label for="name">Fax No</label>
            <input type="text" class="form-control" id="" name="fax" placeholder="Enter  Fax No" >
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