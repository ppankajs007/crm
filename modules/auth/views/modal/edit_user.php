<div class="modal-demo">
<?php
    $new_password = array(
    	'name'	=> 'new_password',
    	'id'	=> 'new_password',
    	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
    	'size'	=> 30,
    	'class'	=> 'form-control',
    	'placeholder' => 'Enter New Password'
    );
    $confirm_new_password = array(
    	'name'	=> 'confirm_new_password',
    	'id'	=> 'confirm_new_password',
    	'maxlength'	=> $this->config->item('password_max_length', 'tank_auth'),
    	'size' 	=> 30,
    	'class'	=> 'form-control',
    	'placeholder' => 'Enter Confirm Password'
    
    );
    $username = array(
    	'username'	=> 'username',
    	'id'	=> 'username',
    	'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
    	'size' 	=> 30,
    	'class'	=> 'form-control',
    	'placeholder' => 'Enter User Name'
    
    );
    $email = array(
    	'name'	=> 'email',
    	'id'	=> 'email',
    	'value'	=> set_value('email'),
    	'maxlength'	=> 80,
    	'size'	=> 30,
        'placeholder' => 'Enter email',
        'class'     => 'form-control'
    );
    
    $role = array(
        'role'	=> 'role',
        'id'	=> 'role',
        'value' => set_value('role')
    );
    $role = array(
        'role'	=> 'role',
        'id'	=> 'role',
        'value'	=> set_value('role'),
        'placeholder' => 'Select Input',
        'class'     => 'form-control'
    );

?>
<?php echo form_open($this->uri->uri_string()); ?>
	<button type="button" class="close" onclick="Custombox.modal.close();">
	    <span>&times;</span><span class="sr-only">Close</span>
	</button>
	<h4 class="custom-modal-title">Add User</h4>
	<div class="custom-modal-text text-left">
		<div class="form-group">
            <?php echo form_label('Username', $username['id']); ?>
            <?php echo form_password($username); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Email', $email['id']); ?>
            <?php echo form_password($email); ?>
        </div>
		<div class="form-group">
            <?php echo form_label('New Password', $new_password['id']); ?>
            <?php echo form_password($new_password); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Confirm New Password', $confirm_new_password['id']); ?>
            <?php echo form_password($confirm_new_password); ?>
        </div>
        <div class="form-group">
            <?php echo form_label('Select Input', $role['id']); ?>
             <select class="form-control" name="role" id="example-select">
                <option value="0" <?php echo (($users->role==0)?"selected":""); ?> id="0">Brand Ambassador</option>
                <option value="1" <?php echo (($users->role==1)?"selected":""); ?> id="1">Admin</option>
                <option value="2" <?php echo (($users->role==2)?"selected":""); ?> id="2">Designer</option>
                <option value="3" <?php echo (($users->role==3)?"selected":""); ?> id="3">Executive</option>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10 close" onclick="Custombox.modal.close();">Cancel</button>
        </div>

	</div>
<?php echo form_close(); ?>
</div>