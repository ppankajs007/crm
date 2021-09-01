<div class="modal-demo">
<?php
if ($use_username) {
	$username = array(
		'name'	=> 'username',
		'id'	=> 'username',
		'value' => set_value('username'),
		'maxlength'	=> $this->config->item('username_max_length', 'tank_auth'),
		'size'	=> 30,
	);
} 
    $email = array(
    	'name'	=> 'email',
    	'id'	=> 'email',
    	'value'	=> set_value('email'),
    	'maxlength'	=> 80,
    	'size'	=> 30,
        'placeholder' => 'Enter email',
        'class'     => 'form-control'
    );
    $password = array(
        'name'  => 'password',
        'id'    => 'password',
        'type'   =>'password',
        'value' => set_value('password'),
        'maxlength' => $this->config->item('password_max_length', 'tank_auth'),
        'size'  => 30,
        'placeholder' => 'Enter Password',
        'class'     => 'form-control'
    );
?>
<?php if(validation_errors() != false) 
          { echo '<ul class="text-danger">' . validation_errors() . "</ul>";}  
        if( isset($errors) && !empty($errors) ){ 
            echo '<ul class="text-danger">';
          foreach ($errors as $v) {
            echo "<li>{$v}</li>";
          }
          echo "</ul>";
            }?>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <?php echo form_open($this->uri->uri_string(),array('id' => 'registerform')); ?>
    <h4 class="custom-modal-title">Add User</h4>
    <div class="custom-modal-text text-left">
        <div class="form-group">
            <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter full name">
            </div>
        <div class="form-group">
            <?php echo form_label('Email Address', $email['id']); ?>
            <?php echo form_input($email); ?>
            <span class="email_error"></span>
        </div>
        <div class="form-group">
            <?php echo form_label('Password', $password['id']); ?>
            <?php echo form_input($password); ?>
        </div>
        <div class="form-group">
            <?php //$depts = $this->config->item('department', 'tank_auth');?>
            <label for="department">Select Department</label>
            <select class="form-control" id="department" name="department">
                    <option value="">Please Select Any</option>
                <?php foreach ($depts as $dept) {
                    echo "<option value='{$dept->id}'>{$dept->department_title}</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <?php //$roles = $this->config->item('roles', 'tank_auth');?>
            <label for="role">Select Role</label>
            <select class="form-control" id="role" name="role">
                <option value="">Please Select Any</option>
                <?php foreach ($roles as $role) {
                    echo "<option value='{$role->id}'>{$role->role_title}</option>";
                }
                ?>
            </select>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light save_btn" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div></form>
    </div><?php echo form_close(); ?>
</div>
<style type="text/css">
    
    .save_btn {
      width: auto;
      display: inline;
    }
</style>