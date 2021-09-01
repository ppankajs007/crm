<?php 
    $currentMethod = $this->router->fetch_method();
    $globalMethods = array('index');
    if($currentMethod == 'index' ) { ?>
        <script src="<?php echo base_url()?>assets/libs/datatables/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.bootstrap4.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.html5.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.flash.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/buttons.print.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.keyTable.min.js"></script>
        <script src="<?php echo base_url()?>assets/libs/datatables/dataTables.select.min.js"></script>
        <script src="<?php echo base_url()?>assets/js/pages/datatables.init.js"></script>
        <script src="<?php echo base_url()?>assets/libs/jquery-validate/jquery.validate.min.js"></script>
        <script>
            jQuery(document).on('click','#deleteUser',function(e){
                var ids = jQuery(this).attr("ids");
                swal({
                    title: "Are you sure?",
        	        text: "Once deleted, you will not be able to recover this user again!",
        	        icon: "warning",
        	        buttons: true,
        	        dangerMode: true,
        	        showLoaderOnConfirm: true
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            $.ajax({
                                url: "<?php echo site_url('auth/Prdelete_user')?>",
                                data: { ids: ids },
                                method: 'POST',
                                error: function(data){ swal('Oops...', 'Something went wrong with ajax !', 'error'); },
                                success: function(res){
                                    if(res == "TRUE"){
                                        swal("Deleted!", "You clicked the button!", "success");
                                        jQuery(".Mystyle"+ids).fadeOut();
                                        location.reload();
                                    } else {
                                        swal('Oops...', 'Something went wrong with ajax !', 'error');
                                    }
                                },
                            })
                      }
                });
            });

            jQuery(document).on('click','#save_',function(){
                jQuery("#registerform").validate({
                    rules: {
                        name: {
                            required:true,
                        },
                        email:{
                            required:true,
                            email:true,
                        },
                        password:{
                            required:true,
                            minlength: 5
                        },
                         department: {
                            required:true,
                        },
                         role: {
                            required:true,
                        },
                    },
                    messages: {
                        name: {
                            required:"* Please enter full name",
                        },
                         email: {
                            required:"* Please enter a email address",
                            email: "* Please enter a valid email",
                        },
                        password: { 
                            required:"* Please enter password",
                            minlength: "* Please enter password more than 5 characters"
                        },
                        department: {
                            required:"* Please Select Department name",
                        },
                        role: {
                            required:"* Please Select Role",
                        },
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
            });
            
            jQuery("#edit_user").validate({
                rules: {
                    name:{
                        required:true,
                    },
                    department:{
                        required:true,
                    },
                    role:{
                        required:true,
                    },
                },
                messages: {
                    name: {
                        required:"* Please Enter  name",
                    },
                     department: {
                        required:"* Please select a department name",
                    },
                    role: { 
                        required:"* Please select a role",
                    },
                   
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });

            jQuery("#edit_password").validate({
                rules: {
                    new_password:{
                        required:true,
                        minlength : 5
                    },
                    confirm_new_password:{
                        required:true,
                        minlength : 5,
                         equalTo : "#new_password"
                    }
                },
                messages: {
                    new_password: {
                        required:"* Please Enter  New Password",
                    },
                     confirm_new_password: {
                        required:"* Please Enter  Confirm Password",
                        equalTo: "Please enter the same value again.",
                    }
                   
                    },
                    submitHandler: function(form) {
                        form.submit();
                    }
                });
            });
        </script>
<?php } //close index ?>