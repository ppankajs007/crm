<div class="container-fluid"><!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">Dashboard</a></li>
                     <li class="breadcrumb-item"><a href="<?php echo base_url().'orders';?>">Orders</a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'customer/dashboard/'.$edit_order['customer_id']; ?>"><?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
                     <li class="breadcrumb-item"><a href="<?= base_url().'orders/Dashboard/'.$this->uri->segment(3); ?>">Order For <?= $edit_order['first_name']; ?> <?= $edit_order['last_name']; ?></a></li>
                     <li class="breadcrumb-item">Logs</li>
                    </ol>
                </div>
                <h4 class="page-title">Logs</h4>
            </div>
        </div>
    </div>     
    <!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card-box">
               <ul class="overview_list" id="lead_sub_menu" class="lead_sub_menu">
                  <?php  echo modules::run('includes/order_sub_menu'); ?>
               </ul>
               <div class="clear"></div>
             </div>
        </div>
    </div>      
    <div class="row">
        <div class="col-xl-12">
            <div class="card-box project-box">
                <table width="100%" class="table">
                    <thead>
                        <tr>    
                            <th>#</th>
                            <th>Name</th>
                            <th>Order Status</th>
                            <th>Created By</th>
                            <th>Version Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (! empty($logs) ) {
                            if( $order_det['current_version'] == '0'){
                               $logs[0]['this_is_current'] = 'yes'; 
                            }
                            $result = [];
                            foreach ($logs as $log) { 
                                $order_data = json_decode($log['order_data'], true); 
                                
                                if( ($order_det['current_version'] == $log['id']) || isset($log['this_is_current']) ) {
                                    $class = 'log_active';
                                }else{
                                    $class = '';
                                }
                                
                            ?>
                                <tr class="<?php echo $class; ?>">
                                    <td>V.<?php echo $log['id']; ?></td>
                                    <td><?php echo (!empty($order_data['first_name']) || !empty($order_data['last_name']) ? ucfirst($order_data['first_name']).' '.$order_data['last_name']: 'N/A');  ?></td>
                                    <td><?php echo ( !empty($order_data['status']) ? $order_data['status'] : 'N/A' ); ?></td>
                                    <td><?php 
                                        $user = (array) App::get_row_by_where('user_profiles', array( 'user_id' => $log['user_id'] ) );
                                        echo ucfirst($user['name']); 
                                        ?>
                                    </td>
                                    <td><?php echo date('M d Y H:i:s A', $log['created_on']); ?></td>
                                    <td>
                                        <a href="<?php echo base_url().'orders/preview/'.$log['id']; ?>" title="Preview" class="action-icon" style="color:#808080 !important" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" ><i class="fas fa-eye"></i></a>
                                        <a href="javascript:void(0);" title="Restore" id="restoreOrder" class="action-icon" style="color:#808080 !important" data-order="<?php echo $log['order_id']; ?>" ids="<?php echo $log['id']; ?>"> <i class="fa fa-undo"></i></a>
                                    </td>
                                </tr>      
                        <?php 
                            } 
                        }
                        else
                        {
                        ?>
                        <tr>
                            <td colspan="11" style="text-align:center;">There are no logs available right now!</td>
                        </tr>
                        <?php 
                        }
                        ?>
                    </tbody>
                </table>
            </div> <!-- end card box-->
        </div><!-- end col-->
   </div> <!-- end row -->
</div> <!-- container -->

