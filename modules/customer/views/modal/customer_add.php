<div class="modal-demo">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 
    <?php  echo form_open($this->uri->uri_string(),array('id'=>'form'));  ?>
    <?php  $this->uri->segment(4); ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Customer</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="first_name">Full Name</label>
            <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter Customer Full Name" value="<?php echo $leads_info['first_name'].' '.$leads_info['last_name']; ?>">
        </div>
        <div class="form-group">
            <label for="first_name">Gender</label>
            <select class="form-control" id="gender" name="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
        </div>
        <div class="form-group">
            <label for="first_name">Phone</label>
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone Number" value="<?php echo $leads_info['phone']; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="first_name">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" value="<?php echo $leads_info['email']; ?>" readonly>
        </div>
        <div class="text-right">
            <input type="hidden" name="leads_id" value="<?php echo $this->uri->segment(4); ?>"> 
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_" name="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div><?php echo form_close(); ?>
</div>