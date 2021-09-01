<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add file</h4>
    <div class="custom-modal-text text-left">
        <?php $attr = array( 'id' => 'add_file');echo form_open_multipart('',$attr); ?>
        <div class="form-group">
            <label for="name">Title</label>
            <input type="text" class="form-control" id="title" name="title" placeholder="Enter File Title">
        </div>
        <div class="form-group">
            <label for="name">Description</label>
            <textarea class="form-control" name="description"></textarea>
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="image_upload" name="image_upload" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
        </div>
        <div class="text-right">
            <input type="hidden" name="id" value="<?php echo $this->uri->segment(3); ?>">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div><?php echo form_close(); ?>
    </div>
</div>
<style type="text/css">.error{ color:red;}</style>