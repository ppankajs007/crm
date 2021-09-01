<div class="modal-demo">
    <style>
       .searchlist > ul{
        max-height: 150px;
    } 
    .searchlist li{
        cursor: pointer;
    }
    </style>
   <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Assign Lead</h4>
    <?php echo form_open($this->uri->uri_string(),array('id' => 'Assignform')); ?>
    <div class="custom-modal-text text-left">
        <div class="form-group" >
            <label for="position">Assign lead</label>
                <input type="email" class="form-control" name="email" value="" id="exampleInputEmail1" placeholder="Enter Your email" >
        </div>
        <div class="text-right">
            <input type="hidden" name="custm_id" value="<?php echo $this->uri->segment(3); ?>">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_" name="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div><?php echo form_close(); ?>
</div>



