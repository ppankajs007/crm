<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit User</h4>
    <div class="custom-modal-text text-left">
        <?php if( empty($users) ) return;?>
        <?php $attr = array( 'id' => 'edit_user'); echo form_open($this->uri->uri_string(),$attr); ?>
        <div class="form-group">
            <label for="name">Full Name</label>
            <input type="hidden" id="id" name="id" value='<?php echo $users->id;?>'>
            <input type="text" class="form-control" id="name" name="name" value='<?php echo $users->name;?>' placeholder="Enter full name" >
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" value='<?php echo $users->email;?>' id="exampleInputEmail1" placeholder="Enter email" readonly>
        </div>
        <div class="form-group">
            <label for="department-select">Select Department</label>
            <select class="form-control" name="department" id="department-select">
                <option value="" id="default-department" selected>Please Select Any</option>
            <?php foreach($depts as $dept){ ?>
                <option value="<?php echo $dept->id; ?>" <?php if( $user_info['department'] == $dept->id ){ echo 'selected'; } ?>  ><?php echo $dept->department_title; ?></option>
            <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="parent-select">Select Role</label>
            <select class="form-control" name="role" id="parent-select">
                <option value="" id="default-parent" selected>Please Select Any</option>
            <?php foreach($roles as $role){ ?>
                <option value="<?php echo $role->id; ?>" <?php if( $user_info['role'] == $role->id ){ echo 'selected'; } ?> ><?php echo $role->role_title; ?></option>
            <?php } ?>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10  " onclick="Custombox.modal.close();">Cancel</button>
        </div></form>
    </div><?php echo form_close(); ?>
</div>