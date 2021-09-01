        <div class="container-fluid">                       
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                            <li class="breadcrumb-item active">Leads</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Leads</h4>
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
                                                <a href="<?php echo base_url();?>department/department/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Department</a>
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
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Description</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                            <tbody>
                                                <?php 
                                                $lead_source = $this->config->item('lead_source', 'tank_auth');
                                                if( !empty($leads) ){
                                                    foreach( $leads as $lead ){ 
                                                ?>
                                                <tr class="Mystyle<?php echo  $lead['id']; ?>">
                                               <td><?php echo  $lead['id']; ?></td>
                            <td><a href='<?php echo base_url();?>crm/leads/view_profile/<?php echo $lead['id'];?>'><?php echo ucwords( $department['department_title'] ); ?></a></td>
                                                    <td><?php echo $department['department_desc']; ?></td>
                                                    <td>
                                                        <a href="<?php echo base_url();?>crm/leads/edit_lead/<?php echo $lead['id'];?>" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                        <!--<a href="<?php //echo base_url();?>index.php/crm/leads/sendSms/key/<?php// echo encrypt_decrypt($lead['id'], 'e');?>" class="action-icon" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"> <!--<i class="fas fa-sms"></i></a>---->
                                                        <a href="javascript:void(0);" id="deleteUser" class="action-icon" ids="<?php echo $lead['id']; ?>"> <i class="mdi mdi-delete"></i></a>
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