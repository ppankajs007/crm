<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php 
    $attributes = array('id' => 'form'); 
    echo form_open($this->uri->uri_string(),$attributes); //form open
    if( empty($department) ) return;  ?>
    <h4 class="custom-modal-title">Edit Department</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="name">Department Name</label>
            <input type="hidden" id="id" name="department_id" value='<?php echo $department['id'];?>'>
            <input type="text" class="form-control" id="department_title"  name="department_title" value='<?php echo $department['department_title'];?>'   placeholder="Enter Department name">
        </div>
        <div class="form-group">
            <label for="department_desc">Department Description</label>
           <textarea name="department_desc" class="form-control"><?php echo $department['department_desc'];?></textarea> 
        </div>
        
        <div class="text-right">
            <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="save_" value="Update">
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div><?php echo form_close(); ?><!-- end form -->
</div>


