<div class="modal-demo">
    <?php $attributes = array('id' => 'form'); 
    echo form_open($this->uri->uri_string(),$attributes); 
    ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Department</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="first_name">Department Name</label>
            <input type="text" class="form-control" id="department_title" name="department_title" placeholder="Enter Department Name">
        </div>
        <div class="form-group">
            <label for="department_desc">Department Description</label>
           <textarea name="department_desc" class="form-control"></textarea> 
        </div>
        <div class="text-right">
            <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="save_" value="Save">
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div><?php echo form_close(); ?>
</div>

