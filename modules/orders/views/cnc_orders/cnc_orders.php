    <link href="<?php echo base_url()?>assets/libs/DataTableServer/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <div class="container-fluid">                       
    <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                            <li class="breadcrumb-item active">Orders</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Orders</h4>
                </div>
            </div>
        </div>     
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <!--<a href="<?php// echo base_url();?>order/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Order</a>-->
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-right">
                                 </div>
                            </div><!-- end col-->
                        </div>
                        <table id="OrderTable" class="table" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Sales</th>
                                    <th>V</th>
                                    <th>SDD/RDD</th>
                                    <th>Total</th>
                                    <th>Paid</th>
                                    <th>Total Due</th>
                                    <th>P</th>
                                    <th>Is Pickup</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
