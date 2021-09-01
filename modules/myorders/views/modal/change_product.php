<div class="modal-demo">
<?php // $attributes = array('id' => 'form_change_product'); echo form_open($this->uri->uri_string(),$attributes); ?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Change Product</h4>
    <div class="custom-modal-text text-left">             
        <div class="form-group">
            <label for="assigned_to">Select Style</label>
            <select class="form-control" name="filterStyle" value=""> 
            <option value="" id="0">Select option</option>
            <?php if ( !empty($styles) ) {
                    foreach ($styles as $style) {  ?> 
                    <option value="<?=$style->id?>" ><?=$style->style_name?></option>
            <?php } 
                }
            ?>

            </select> 
        </div>

        <div class="text-right">
            <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="pk_change_product" value="Save">
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div>
<?php // echo form_close(); ?>
</div>

