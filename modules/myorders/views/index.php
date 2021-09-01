        <div class="container-fluid">                       
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                                            <li class="breadcrumb-item active">Users</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Users</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                      <div class="row mb-2">
                                            <div class="col-sm-4">
                                                <a href="<?php echo base_url();?>index.php/auth/registerUser" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add User</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-right">
                                                    <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>
                                                    <button type="button" class="btn btn-light mb-2 mr-1">Import</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <table id="scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Role</th>
                                                    <th>Date of Join</th>
                                                    <th>Last Loggin</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                <?php 

                                            //print_r($current_user);

                                                $roles = $this->config->item('roles', 'tank_auth');
                                                if( !empty($allUsersQuery) ){
                                                    foreach( $allUsersQuery as $Users ){ 
                                                ?>
                                                <tr class="Mystyle<?php echo  $Users['id'] ?>">

                                                    <td><?php echo $Users['name']; ?></td>
                                                    <td><?php echo $Users['email']; ?></td>
                                                    <td><?php echo $roles[$Users['role']]; ?></td>
                                                    <td><?php echo $Users['created'];?></td>
                                                    <td><?php echo $Users['last_login'];?></td>
                                                    <td>
                                                        <a href="<?php echo base_url();?>auth/edit_user/<?php echo $Users['id'];?>" class="action-icon" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                       <?php
                                                        if($current_user!== $Users['id']){?> 
                                                        <a href="javascript:void(0);" id="deleteUser" class="action-icon" ids="<?php echo $Users['id']; ?>"> <i class="mdi mdi-delete"></i></a>

                                                  <?php  }?>
                                                        
                                                    </td>


                                                </tr>
                                                <?php } } ?>
                                            </tbody>
                                        </table>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    </div> <!-- container -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script> 
<script>
    jQuery(document).ready( function(){
        jQuery(document).on("change","#email", function(){
            var email = jQuery(this).val();
            jQuery.ajax({
                type : "POST",
                url  : "<?php echo site_url(); ?>/auth/email_validation_check",
                data:{
                  "email":email,
                },
                success:function(data){
                    console.log(jQuery.type(data));
                    if(data == 'true'){
                        jQuery(".email_error").text("This Email is already exist");
                        jQuery("#save_").prop('disabled', true);
                    }else{
                        jQuery(".email_error").text("");
                        jQuery("#save_").prop('disabled', false);
                    }
                },
                error: function(error) {
                   console.log(data);
                }
            });
        });
        jQuery(document).ready(function() {
            jQuery('#DataTable').DataTable({
                "paging": true,
                "pagingType": "full_numbers"
            });

        });
    });
</script>