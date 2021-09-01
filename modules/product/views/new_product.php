<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: black;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
}
</style>
<div class="container-fluid"> <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Product</li>
                    </ol>
                </div>
                <h4 class="page-title">Product</h4>
            </div>
        </div>
    </div>    <!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <div class="row mb-2">
                        <!-- <div class="col-sm-4">
                            <a href="<?php echo base_url();?>product/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Product</a>
                        </div> -->
                        <!-- <div class="col-sm-8">
                            <div class="text-sm-right">
                                <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>
                                <button type="button" class="btn btn-light mb-2 mr-1">
                                <a href="<?php echo base_url()?>product/Import"  class="btn-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a">Import</a>
                                </button>
                                <button type="button" class="btn btn-light mb-2">Export</button>
                            </div>
                        </div> --><!-- end col-->
                    </div>
                    <table id="newproductsTable" class="table" style="width:100%">
                       <thead>
                            <tr>
                                <th>#</th>
                                <th>Item Code</th>
                                <th>Style</th>
                                <th>Item Description</th>
                                <th>Assembly Cost</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div><!-- end row-->
</div> <!-- container -->