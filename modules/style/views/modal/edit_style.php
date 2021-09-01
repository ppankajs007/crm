<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php if( empty($style) ) return; ?>
    <h4 class="custom-modal-title">Edit Style</h4>
    <div class="custom-modal-text text-left">
        <?php $attributes = array('id' => 'form'); echo form_open($this->uri->uri_string(),$attributes); ?>
        <?php // echo form_open($this->uri->uri_string()); ?>
        <input type="hidden" id="id" name="style_id" value='<?php echo $style['id'];?>'>
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name"  name="name" value='<?php echo $style["style_name"];?>'>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code"  name="code" value='<?php echo $style["style_code"];?>'>
        </div>
        <div class="form-group">
            <label for="">Description</label>
           <textarea name="description" class="form-control"><?php echo $style['style_desc']; ?></textarea> 
        </div>
       <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>  <?php echo form_close(); ?>
    </div>
</div>
<style type="text/css">
.error { 
    color:red;
}
</style>


