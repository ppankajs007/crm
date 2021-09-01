<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button><?php
        if( empty($role) ) return; ?>
    <h4 class="custom-modal-title">Edit Customer</h4>
        <?php echo form_open($this->uri->uri_string()); ?>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="first_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Customer Full Name" value="<?php echo $role['full_name']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">Gender</label>
            <select class="form-control" id="gender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="first_name">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?php echo $role['address']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">City</label>
            <input type="text" class="form-control" id="city" name="city" placeholder="Enter City" value="<?php echo $role['city']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">State</label>
            <input type="text" class="form-control" id="state" name="state" placeholder="Enter State" value="<?php echo $role['state']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">Zipcode</label>
            <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="Enter Zipcode" value="<?php echo $role['zipcode']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="<?php echo $role['phone']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">Fax</label>
            <input type="text" class="form-control" id="fax" name="fax" placeholder="Enter Fax Number" value="<?php echo $role['fax']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo $role['email']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="first_name">Notes</label>
            <textarea class="form-control" name="comment" placeholder="Note"><?php if(isset($role['comment'] ) ): echo $role['comment'];else:""; endif; ?></textarea>
        </div>
        <div class="text-right">
            <input type="hidden" name="custm_id" value="<?php echo $role['id']; ?>">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_" name="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div></form>
</div>


