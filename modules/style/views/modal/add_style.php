<div class="modal-demo">
    <?php 
        $attributes = array('id' => 'form'); 
        echo form_open($this->uri->uri_string(),$attributes); 
    ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add Style</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code">
        </div>
        <div class="form-group">
            <label for="desc">Description</label>
           <textarea name="description" class="form-control"></textarea> 
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