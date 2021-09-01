<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php //$attributes = array('id' => 'form_email'); echo form_open($this->uri->uri_string(),$attributes); ?>
    <?php 
        if( empty($email) ) return;
    ?>
    <h4 class="custom-modal-title">View Email</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <strong>Subject</strong> &nbsp;<span><?php echo $email['subject']; ?></span>
        
        </div>
        <div class="form-group">
            <strong>Message</strong>
            <pre><?php echo $email['message']; ?></pre>
        </div>
        <div class="text-right">
          <!--   <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="save_" value="Update"> -->
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div>
</div>


