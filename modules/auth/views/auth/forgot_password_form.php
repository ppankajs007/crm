<?php
    $login = array(
    	'name'	=> 'login',
    	'id'	=> 'login',
    	'value' => set_value('login'),
    	'maxlength'	=> 80,
    	'size'	=> 30,
    	'class' => 'form-control'
    );
    if ($this->config->item('use_username', 'tank_auth')) {
    	$login_label = 'Email or login';
    }else{
    	$login_label = 'Email';
    }
?>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
                <div class="card-body p-4">
                    <div class="text-center w-75 m-auto">
                        <a href="index.html">
                        <span><img src="<?php echo base_url()?>assets/images/pk-logo.png" alt="" height="50"></span>
                        </a>
                        <p class="text-muted mb-4 mt-3">Enter your email address to get new password.</p>
                    </div><?php echo form_open($this->uri->uri_string()); ?>
                    <div class="form-group mb-3">
                        <p ><?php 
                            if(validation_errors() != false) 
                                { echo '<ul class="parsley-errors-list filled">' . validation_errors() . "</ul>";}  
                                if( isset($errors) && !empty($errors) )
                                { echo '<ul class="parsley-errors-list filled">';
                                foreach ($errors as $v) {
                                    echo "<li class='parsley-required'>{$v}</li>";
                                }  echo "</ul>";
                            }?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <?php echo form_label($login_label, $login['id']); ?>
                        <?php echo form_input($login); ?>                                        
                    </div>
                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit"> Get a new password </button>
                    </div></form>
                </div> <!-- end card-body -->
            </div><!-- end card -->
        </div> <!-- end col -->
    </div>