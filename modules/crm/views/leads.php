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
table{
    table-layout: fixed;
    word-wrap:break-word;
}

div.dataTables_wrapper {
        margin: 0 auto;
}

.qfbox{
    text-align:center;
    cursor: pointer;
}

.qfboxgreen {
    border: 2px solid #7dcc90;
    color: #7dcc90;
    
}

.qfboxred {
    border: 2px solid #fb6b5b;
    color: #fb6b5b;
}

.qfboxyellow {
    border: 2px solid #eab50a;
    color: #eab50a;
}
ul.lead_list li {
  display: inline-block;
  list-style: none;
  margin: 0 14px 19px 0;
  width: 29%;
}
 

@media only screen and (max-width: 484px) {
     ul.lead_list li {
        display: inline-block;
        list-style: none;
        margin: 0 14px 19px 0;
        width: 100%;
      }
        ul.lead_list li:last-child {
            float: none;
            margin: 0;
            width: 100%;
          }
          ul.lead_list li:last-child .btn {
            float: left;
            width: 100%;
            margin: 0;
            }
            .page-link {
              position: relative;
              display: block;
              padding:0;
              margin: 10px;
              line-height: 1.25;
              color: #323a46;
              background-color: #fff;
              border: 1px solid #dee2e6;
    }

    li.paginate_button.next, li.paginate_button.previous {
    display: inline-block;
    font-size: 1rem;
}
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

                                        <a href="<?php echo base_url();?>crm/leads/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add New Lead</a>
                                        <ul class="lead_list">
                                            <li>  
                                             <label>Status </label>
                                                <select class="js-example-basic-multiple form-control" id="selectStatus" multiple="true" name="selectedst" >
                                                  <?php
                                                    foreach ($Select_status as $key => $value) { ?>
                                                        <option value="<?php echo $value->id; ?>" ><?php echo $value->status; ?></option>
                                                    <?php }

                                                   ?>
                                                 </select>
                                              
                                            </li>
                                            <li>
                                             <label>Assign </label>
                                                <select class="js-example-basic-multiple form-control" id="selectAssign" multiple="true" name="selectassign" >
                                                  <?php
                                                    foreach ($SelectAssign as $key => $value) { ?>
                                                        <option value="<?php echo $value->id; ?>" ><?php echo $value->name."&nbsp #".$value->id; ?></option>
                                                    <?php }

                                                   ?>
                                                </select>
                                            
                                            </li>
                                            <li>
                                             <label>Next Action</label>
                                                <select class="js-example-basic-multiple form-control" id="nextAction" multiple="true" name="nextaction" >
                                                  <?php
                                                    $lead_next_action = json_decode(lead_next_action);
                                                    echo '<option>Select.....</option>';
                                                    foreach ( $lead_next_action as $key => $value) {
                                                        echo '<optgroup label="'.$key.'">';
                                                            foreach ($value as $ckey => $cValue) {
                                                              echo "<option $sl>$cValue</option>";
                                                            }
                                                        echo '</optgroup>';
                                                    } ?>
                                                </select>
                                            
                                            </li>
                                            <li>
                                                <button class="btn btn-success mb-2 mr-1 js-programmatic-multi-clear" >Clear</button>
                                            </li>
                                        </ul>


                                   <!--    <div class="row mb-2">
                                            <div class="col-sm-2">
                                                <a href="<?php echo base_url();?>crm/leads/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add New Lead</a>
                                            </div>
                                            
                                            
                                            <div class="col-md-3">
                                                <label>Status
                                                <select class="js-example-basic-multiple form-control" id="selectStatus" multiple="true" name="selectedst" >
                                                  <?php
                                                    foreach ($Select_status as $key => $value) { ?>
                                                        <option value="<?php echo $value->id; ?>" ><?php echo $value->status; ?></option>
                                                    <?php }

                                                   ?>
                                                </select>
                                                </label>
                                            </div>

                                            <div class="col-md-3">
                                                <label>Assign
                                                <select class="js-example-basic-multiple form-control" id="selectAssign" multiple="true" name="selectassign" >
                                                  <?php
                                                    foreach ($SelectAssign as $key => $value) { ?>
                                                        <option value="<?php echo $value->id; ?>" ><?php echo $value->name."&nbsp #".$value->id; ?></option>
                                                    <?php }

                                                   ?>
                                                </select>
                                                </label>
                                            </div>
                                            
                                            
                                            <div class="col-md-1">
                                                <button class="btn btn-success mb-2 mr-1 js-programmatic-multi-clear" >Clear</button>
                                            </div> -->
                                            
                                            
                                           <!--  <div class="col-sm-3">
                                                <div class="text-sm-right">
                                                    <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>
                                                    <button type="button" class="btn btn-light mb-2 mr-1">Import</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div> end col--> 
                                            
                                            <div class="table-responsivee" >
                                      
                                        <table id="leadsTable" class="display table compact dataTable dtr-inline"  style="width:100%">
                                           <thead> 
                                              <tr>
                                                  <th>#</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Qualified Status">QS</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Assign">Assign</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Name / Email / Phone">Name/Email/Phone</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Communication Attempts">Comm. Attempts</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Last Action / Last Action date">LA / LAD</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Status">Status</th>
                                                <th data-toggle="tooltip" data-placement="top" title="Next Step / Next Step Date">NS / NSD</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Survey Score / Hotness">SS/H</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Age">Age</th>
                                                  <th data-toggle="tooltip" data-placement="top" title="Action">Action</th>
                                              </tr>
                                            </thead>
                                            
                                        </table>
                                        </div>

                                    </div> <!-- end card body -->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
        </div> <!-- container -->
