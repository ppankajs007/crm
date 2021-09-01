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
                                                <a href="<?php echo base_url();?>crm/leads/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add New Lead</a>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="text-sm-right">
                                                    <button type="button" class="btn btn-success mb-2 mr-1"><i class="mdi mdi-settings"></i></button>
                                                    <button type="button" class="btn btn-light mb-2 mr-1">Import</button>
                                                    <button type="button" class="btn btn-light mb-2">Export</button>
                                                </div>
                                            </div><!-- end col-->
                                        </div>

                                        <table id="tabelainfo" class="table dt-responsive nowrap " id="DataTable">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Assignaa</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Status</th>
                                                    <th>Hotness</th>
                                                    <th>Score</th>
                                                    <th>Age</th>
                                                     <th>Next Step</th>
                                                      <th>Next Step date</th>
                                                    <!-- <th>Source</th> -->
                                                    <!-- <th>Created</th> -->
                                                    <!-- <th>IP</th> -->
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                        
                                        
                                            <tbody>
                                                <?php   
                                     

                                                function secondsToTime($seconds) {
                                                    $ret = "";

                                                    /*** get the days ***/
                                                    $days = intval(intval($seconds) / (3600*24));
                                                    if($days> 0)
                                                    {
                                                        $ret .= "$days days ";
                                                    }

                                                    /*** get the hours ***/
                                                    $hours = (intval($seconds) / 3600) % 24;
                                                    if($hours > 0)
                                                    {
                                                        $ret .= "$hours hours ";
                                                    }

                                                    /*** get the minutes ***/
                                                    $minutes = (intval($seconds) / 60) % 60;
                                                    if($minutes > 0)
                                                    {
                                                        $ret .= "$minutes minutes ";
                                                    }

                                                    /*** get the seconds ***/
                                                    $seconds = intval($seconds) % 60;
                                                    if ($seconds > 0) {
                                                        $ret .= "$seconds seconds";
                                                    }

                                                    return $ret;
                                                }

                                                  $lead_source = $this->config->item('lead_source', 'tank_auth');
                                                if( !empty($leads) ){
                                                    foreach( $leads as $lead ){ 


                                                        $dt = new DateTime();

                                                        $olddate = strtotime( $lead['created'] );
                                                        $curdate = strtotime( $dt->format('Y-m-d') );

                                                        $fTime = $olddate-$curdate;
                                                        $age= secondsToTime($fTime);
                                                        
                                                        $datetime = $lead['reminder_date'];
                                                        $rem = date("Y-m-d", strtotime($datetime));                                                     
                                             

                                                ?>
                                                <tr class="Mystyle<?php echo  $lead['id']; ?>">
                                               <td><?php echo  $lead['id']; ?></td>
                                                <td><?php echo $lead['name']; ?></td>
                            <td><a href='<?php echo base_url();?>crm/leads/view_profile/<?php echo $lead['id'];?>'><?php echo ucwords( $lead['first_name'] . ' ' . $lead['last_name'] ); ?></a></td>
                                                    <td><?php echo $lead['email']; ?></td>
                                                    <td><?php echo $lead['phone']; ?></td>
                                                    <td><?php echo $lead['status']; ?></td>
                                                    <td><?php echo $lead['hoteness']; ?></td>
                                                     <td><?php echo $lead['score']; ?></td>
                                                     <td><?php echo $age; ?></td>
                                                     <td><?php echo $lead['action_lead']; ?></td>
                                                     <td><?php echo $rem; ?></td>
                                                    <!-- <td><?php// echo $lead_source[$lead['source']]; ?></td> -->
                                                    <!-- <td><?php// echo $lead['created'];?></td> -->
                                                    <!-- <td><?php// echo $lead['ip'];?></td> -->
                                                    <td>
                                                        <a href="<?php echo base_url();?>file/leads/edit_leads/<?php echo $lead['id'];?>" class="action-icon" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a"> <i class="mdi mdi-square-edit-outline"></i></a>
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
                    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
                    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
                    <script type="text/javascript">
                    	$(function(){
    $('#tabelainfo').dataTable({
        "bLengthChange": false,
        "bFilter": true,
        "bSort": true,
        "bInfo": true,
        "bAutoWidth": false,
        "sScrollY": "200px",
        "sScrollX": "100%",
        "sPaginationType": "full_numbers",
        "bRetrieve": true,
        "bScrollCollapse": true,
    });

    $(".dataTables_scrollBody").css('width', '102%');
   
    /* commented out not working stuff
    $(window).bind('resize', function() {
        oTable.fnAdjustColumnSizing();
    });
    jQuery('#' + idTabela).wrap('<div class="scrollStyle" />');
    */
});
                    </script>