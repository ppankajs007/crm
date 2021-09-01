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
            <label for="department">Select File Type</label>
            <select class="form-control" id="lead_file_type" name="lead_file_type">
                <option value="">Please Select Any</option>
                <option value="kit 1">kit 1</option>
                <option value="kit 2">kit 2</option>
                <option value="kit 3">kit 3</option>
                <option value="Deck 1">Deck 1</option>
                <option value="Deck 2">Deck 2</option>
                <option value="Deck 3">Deck 3</option>
                <option value="Worksheet">Worksheet</option>
                <option value="kitchen pictures">kitchen pictures</option>
                <option value="measurement form">measurement form</option>
                <option value="measurements">measurements</option>
                <option value="desired look">desired look</option>
                <option value="final paperwork">final paperwork</option>
                <option value="certificate of work complete">certificate of work complete</option>
                <option value="receipts">receipts</option>
            </select>
        </div>
        <div class="form-group">
            <label for="name">Deck 1</label>
            <input type="text" class="form-control" id="deck_one" name="deck_one" placeholder="Enter First Deck">
        </div>
        
        <div class="form-group">
            <label for="name">Deck 2</label>
            <input type="text" class="form-control" id="deck_two" name="deck_two" placeholder="Enter Second Deck">
        </div>
        
        <div class="form-group">
            <label for="name">Deck 3</label>
            <input type="text" class="form-control" id="deck_three" name="deck_three" placeholder="Enter Third Deck">
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
            <input type="hidden" name="leads_id" value="<?php echo $this->uri->segment(4); ?>">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
            <?php echo form_close(); ?>
    </div>
</div>
<style type="text/css">.error{ color:red;}</style>