<div class="modal-demo">
    <?php 
    $attributes = array('id' => 'form'); 
    echo form_open($this->uri->uri_string(),$attributes);  ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Role</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="first_name">Role Name</label>
            <input type="text" class="form-control" id="" name="role_title" placeholder="Enter Role Name">
        </div>
        <div class="form-group">
            <label for="role_desc">Role Description</label>
           <textarea name="role_desc" class="form-control"></textarea> 
        </div>
        <div class="form-group">
            <label for="parent-select">Select Parent Role</label>
            <select class="form-control" name="parent_role" id="parent-select">
                <option value="" id="selected" selected>Please select any</option>
                <?php 
                foreach ($roles as $role) { 
                echo '<option value="'.$role->id.'" >'.$role->role_title.'</option>';
                } 
                ?>
            </select>
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