<div class="container-fluid">  <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Department</li>
                    </ol>
                </div>
                <h4 class="page-title">Department</h4>
            </div>
        </div>
    </div> <!-- end page title --> 
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
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table id="DepartmentTable" class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div> <!-- container -->

