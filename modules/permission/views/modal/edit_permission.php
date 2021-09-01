<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Edit Permission</h4>
    <div class="custom-modal-text text-left">
    <?php echo form_open($this->uri->uri_string()); ?>
        <input type="hidden" value="<?php echo $permission_id; ?>" name="id">
    <?php foreach ($permission_data as $info) 
                    {
            
     ?>
            <div class="form-group">
                <label for="name">Permission Name</label>
                <input type="text" class="form-control" value="<?php echo $info->permission_name; ?>" name="name" required>
            </div>
            <div class="form-group">
                <label >Controller Name</label>
                <input type="text" class="form-control" value="<?php echo $info->controller_name; ?>" name="controller_name" required>
            </div>
            <div class="form-group">
                <label>Method Name</label>
                <input type="text" class="form-control" value="<?php echo $info->method_name; ?>" name="method_name" required>
            </div>
            <div class="form-group">
                <label>Description</label>
                <input type="text" class="form-control" value="<?php echo $info->description; ?>" name="description" required>
            </div>
            <div class="form-group">
                <label for="hidden">Hidden</label>
                <label class="switch">
                    <input type="checkbox" id="hidden" name="hidden" <?php echo $info->hidden == 1 ? 'checked' : ''; ?> >
                    <span></span>
                </label>
            </div>

            <div class="form-group">
                <label>Permission Module</label>
                <div class="col-lg-4">
                    
                    <select class="form-control" name="permission_module"required>
                        <option value="" >select</option>
                        <?php 
                            foreach ($permission_module_data as $module) 
                            { 
                        ?>
                            
                        <option value="<?php echo $module->permission_module_id; ?>" <?php echo ( $info->fk_permission_module_id == $module->permission_module_id ? 'selected' : '' ); ?> >
                            <?php echo $module->name ?>
                        </option>
                                
                        <?php } ?>
                    </select>
                </div>
            </div>
            <?php } ?>
            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
            </div>
        </form>
    </div>
</div>


