<div class="container-fluid">    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                        <li class="breadcrumb-item active">Duplicate Leads</li>
                    </ol>
                </div>
                <h4 class="page-title">Duplicate Leads</h4>
            </div>
        </div>
    </div>  <!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-sm-4">
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table  class="table no-footer nowrap dataTable dtr-inline collapsed" id=""> 
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                if ( !empty($ldata) ) {
                                    foreach ( $ldata as $lKey => $lead ){
                                        usort($lead, 'array_compare_by_id');
                                        foreach ( $lead as $iKey => $iVal  ){
                                                //pr( $iVal );continue; 
                                            if ($lead[0]['id'] == $iVal['id']) { 
                                                $mCl = 'mainCl'; 
                                                $pEmail = $lead[0]['email'];
                                                $pPhone = $lead[0]['phone'];
                                                if( !App::findParent($pEmail, $pPhone) ) continue;
                                            }else{ $mCl = 'childCl'; }
                                            $pL = $lead[0]['id'];
                                            $self = $iVal['id'];
                                            $rem = date("m/d/Y", strtotime($iVal['created'])); 
                                            if(empty($iVal['parent_lead'])  ){ ?> 
                                            <tr class="Mystyle<?php echo  $self.' '.$mCl; ?>">
                                                <td><?php echo  $self; ?></td>
                                                <td>
                                                    <a href="<?php echo base_url();?>crm/leads/dashboard/<?php echo $lead[0]['id'];?>"><?php echo ucwords( $iVal['first_name'] . ' ' . $iVal['last_name'] ); ?></a>
                                                </td>
                                                <td><?php echo $iVal['email']; ?></td>
                                                <td><?php echo $iVal['phone']; ?></td>
                                                <td><?php echo $rem;?></td>
                                                <td>
                                                <?php if($lead[0]['id'] != $iVal['id']) echo '<button data-parent="'.$pL.'" data-self="'.$self.'" type="button" class="btn btn-success  mergelead mb-2 mr-1">Merge</button>'; ?> 
                                                </td>
                                            </tr><?php 
                                            }
                                        }
                                    }
                                } 
                            ?>
                        </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div><!-- end row-->
</div> <!-- container -->