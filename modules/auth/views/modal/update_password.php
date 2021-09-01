<div class="modal-demo">
    <?php
    $new_password = array(
    	'name'	=> 'new_password',
    	'id'	=> 'new_password',
    	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
    	'size'	=> 30,
    	'class'	=> 'form-control',
    	'placeholder' => 'Enter New Password',
    	'autocomplete'=>'off'
    );
    $confirm_new_password = array(
    	'name'	=> 'confirm_new_password',
    	'id'	=> 'confirm_new_password',
    	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
    	'size' 	=> 30,
    	'class'	=> 'form-control',
    	'placeholder' => 'Enter Confirm Password'
    
    );
    ?>
    <?php $attr = array( 'id' => 'edit_password'); echo form_open($this->uri->uri_string() ,$attr); ?>
	<button type="button" class="close" onclick="Custombox.modal.close();">
	    <span>&times;</span><span class="sr-only">Close</span>
	</button>
	<h4 class="custom-modal-title">Edit Password</h4>
	<div class="custom-modal-text text-left">
		<div class="form-group">
            <?php echo form_label('New Password', $new_password['id']); ?>
            <?php echo form_password($new_password); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
            <?php echo form_password($confirm_new_password); ?>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
    </div><?php echo form_close(); ?>
</div>