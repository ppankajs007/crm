<div class="container-fluid">                       
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                       <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Permissions</li>
                    </ol>
                </div>
                <h4 class="page-title">Permissions</h4>
            </div>
        </div>
    </div>    <!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="<?php echo base_url();?>permission/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Permission</a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table id="scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Controller Name</th>
                                <th>Method Name</th>
                                <th>Description</th>
                                <th>Hidden</th>
                                <th>Permission Module Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($permissions)) {
								foreach ($permissions as $key) { 
								$check = $this->db->get_where( 'fx_permission_module',array( 'permission_module_id' => $key->fk_permission_module_id ) )->result(); ?>
                                <tr class="Mystyle<?php echo $key->permission_id; ?>">
									<td><?php echo $key->permission_id; ?></td>
									<td><?php echo $key->permission_name; ?></td>
									<td><?php echo $key->controller_name; ?></td>
									<td><?php echo $key->method_name; ?></td>
									<td><?php echo ucfirst($key->description); ?></td>
									<td><?php echo $key->hidden == 1 ? 'Hidden' : ''; ?></td>
									<td><?php echo $check[0]->name; ?></td>              
                                    <td>
                                       <a href="<?php echo base_url();?>permission/update/<?php  echo $key->permission_id; ?>" class="action-icon" title="Edit" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                                    <?php // if ($user->username != $this->tank_auth->get_username()) { ?>
                                    <a href="javascript:void(0);" title="Delete" id="deletePermission" class="action-icon" ids="<?php echo $key->permission_id; ?>"> <i class="mdi mdi-delete"></i></a>
									</td>
                            	</tr>
                            <?php } } ?>
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div> <!-- container -->