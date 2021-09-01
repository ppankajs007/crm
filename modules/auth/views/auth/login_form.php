<?php 
    $login = array(
        'name'  => 'login',
        'id'    => 'login',
        'value' => set_value('login'),
        'maxlength' => 80,
        'size'  => 30,
        'class' => 'form-control'
    );
    if ($login_by_username AND $login_by_email) {
        $login_label = 'Email or login';
    } else if ($login_by_username) {
        $login_label = 'Login';
    } else {
        $login_label = 'Email';
    }
    $password = array(
        'name'  => 'password',
        'id'    => 'password',
        'size'  => 30,
        'class' => 'form-control'
    );
    $remember = array(
        'name'  => 'remember',
        'id'    => 'remember',
        'value' => 1,
        'checked'   => set_value('remember'),
        'style' => 'margin:0;padding:0',
        'class' => 'custom-control-input'
    );
    $captcha = array(
        'name'  => 'captcha',
        'id'    => 'captcha',
        'maxlength' => 8,
    );
?>
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 col-xl-5">
            <div class="card bg-pattern">
                <div class="card-body p-4">
                    <div class="text-center w-75 m-auto">
                        <a href="index.html">
                            <span><img src="<?php echo base_url()?>assets/images/pk-logo.png" alt="" height="50"></span>
                        </a>
                        <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                    </div><?php echo form_open($this->uri->uri_string()); ?>
                    <div class="form-group mb-3">
                        <p><?php if(validation_errors() != false)  { 
                            echo '<ul class="parsley-errors-list filled">' . validation_errors() . "</ul>";}  
                            if( isset($errors) && !empty($errors) ) { 
                            echo '<ul class="parsley-errors-list filled">';
                                foreach ($errors as $v) {
                            echo "<li class='parsley-required'>{$v}</li>";
                                }
                            echo "</ul>";
                            }?>
                        </p>
                    </div>
                    <div class="form-group mb-3">
                        <?php echo form_label($login_label, $login['id']); ?>
                        <?php echo form_input($login); ?>                                        
                    </div>
                    <div class="form-group mb-3">
                        <?php echo form_label('Password', $password['id']); ?>
                        <?php echo form_password($password); ?>                                        
                    </div>
                    <div class="form-group mb-3">
                        <div class="custom-control custom-checkbox">
                            <?php echo form_checkbox($remember); ?>
                            <label class="custom-control-label" for="remember">Remember me</label>
                        </div>
                    </div>                                    
                    <div class="form-group mb-0 text-center">
                        <button class="btn btn-primary btn-block" type="submit"> Log In </button>
                    </div></form>
                </div> <!-- end card-body -->
            </div><!-- end card -->
            <div class="row mt-3">
                <div class="col-12 text-center">
                    <p> <a href="<?php echo base_url()?>auth/forgot_password" class="text-white-50 ml-1">Forgot your password?</a></p>
                </div> <!-- end col -->
            </div><!-- end row -->
        </div> <!-- end col -->
    </div><!-- end row -->