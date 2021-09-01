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
ul.lead_list li {
    display: inline-block;
    list-style: none;
    margin: 0 14px 19px 0;
    width: 29%;
}
</style>
<div class="container-fluid">                       
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                           <li class="breadcrumb-item active">Paperwork Pending</li>
                    </ol>
                </div>
                <h4 class="page-title">Paperwork Pending </h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="lead_list assign_list">
                        <li>
                         <label>Assign </label>
                            <select class="js-example-basic-multiple form-control" id="selectAssign" multiple="true" name="selectassign" >
                                <?php foreach ($SelectAssign as $key => $value) { ?>
                                    <option value="<?php echo $value->id; ?>" ><?php echo $value->name."&nbsp #".$value->id; ?></option>
                                <?php } ?>
                            </select>
                        </li>
                        <li>
                            <button class="btn btn-success mb-2 mr-1 js-programmatic-multi-clear" >Clear</button>
                        </li>
                    </ul>
                    <div class="table-responsivee" >
                        <table id="pwleadsTable" class="display table compact dataTable dtr-inline" cellspacing="0" style="width:100%">
                           <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Measurement Method</th>
                                    <th>Latest Action</th>
                                    <th>Next Step Date</th>
                                    <th>N/S Owner</th>
                                    <th>Date Added</th>
                                    <th>Action</th> 
                                </tr>
                            </thead>
                            
                        </table>
                    </div>

                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div> <!-- container -->