<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
     <?php if( empty($role) ) return; ?>
    <h4 class="custom-modal-title">Edit Role</h4>
     <?php $attributes = array('id' => 'form'); echo form_open($this->uri->uri_string(),$attributes); ?>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="name">Role Name</label>
            <input type="hidden" id="id" name="role_id" value='<?php echo $role['id'];?>'>
            <input type="text" class="form-control" id="role_title"  name="role_title" value='<?php echo $role['role_title'];?>'   placeholder="Enter role name">
        </div>
        <div class="form-group">
            <label for="department_desc">Role Description</label>
            <textarea name="role_desc" class="form-control"><?php echo $role['role_desc'];?></textarea> 
        </div>
        <div class="form-group">
            <label for="parent-select">Select Parent Role</label>
            <select class="form-control" name="parent_role" id="parent-select">
                <option value="0" id="default-parent" selected>Please select any</option>
                <?php 
                foreach ($roles as $parent_role) { 
                    if ($parent_role->id != $role['id'] ) {
                ?>
                <option value="<?php echo $parent_role->id; ?>" <?php if( $role['parent_role'] == $parent_role->id ){ echo 'selected'; } ?> ><?php echo $parent_role->role_title; ?></option>
                <?php  
                     } 
                }   
                ?>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div><?php echo form_close(); ?>
</div>
<style type="text/css">
.error { 
    color:red;
}
</style>


