        <style type="text/css">
           .overview_list {
            padding: 0;
            margin: 0;
            border-bottom: 1px solid #ccc;
            float: left;
            width: 100%;
        }
            .overview_list li {
               float: left;
                margin-bottom: 9px;
                list-style: none;
            }
            .overview_list li a {
                margin-right: 2px;
                line-height: 1.42857143;
                border: 1px solid transparent;
                border-radius: 2px 2px 0 0;
                color: #428bca;
                padding: 10px 8px;
            }    
            .overview_list li.active a {
                border-bottom: 2px solid #566676;
                border-radius: 0px;
            }
            .clear {
                clear: both;
            }
            .box_outer label {
                color: #979797;
                font-size: 85%;
                margin-bottom: 0;
            }
            .box_outer h4 {
                color: #2c96dd;
                font-size: 11px;
                margin-top: 1px;
            }
           
            .box_outer h5 {
                 color: #666;
                 font-size: 18px;
            }
            .box_outer {
                text-align: center;
                border-right: 1px solid #E7E7E7;
                padding: 5px 0;
                margin-bottom: 16px;
                margin-top: 29px;

            }
            .additional_list {
                border: 1px solid #e8e8e8;
                padding: 0px 0;
                border-radius: 3px;
                margin-top: 23px;
            }
            .additional_list .panel-heading {
               background: #f5f5f5;
              padding: 10px;
              color: #000;
              font-size: 13px;
           }
           .list-group.no-radius .pull-right {
               float: right;
            }
            .additional_list ul li {
                border-left: none;
                border-radius: ;
                border-right: none;
            }
            .information_outer {

                float: left;
                width: 100%;
                height: 1px;
                width: 100%;
                background: #ddd;

            }

            .slectLead {
                    margin: 28px;
            }
            
            
            .add_assign {
                float: right;
                font-size: 17px;
                margin: 4px 12px;
                margin-top: 0px;
            }
            
        </style>

        <div class="container-fluid"> <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>customer">Customers</a></li>
                                <li class="breadcrumb-item"><a href=" <?php  echo base_url()."customer/dashboard/".$this->uri->segment(3); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Customer Leads</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Customers</h4>
                    </div>
                </div>
            </div> <!-- end page title --> 
                <?php // pr($leads); ?><?php // echo $leads['note']; ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <ul class="overview_list" id="lead_sub_menu">
                              <?php  echo modules::run('includes/customer_submenu');?>
                            </ul>
                            <div class="clear"></div>
                            <div class="row total_list">
                                <div class="col-md-12">
                                    <div class="additional_list">
                                        <header class="panel-heading">Customer Lead
                                            <a href="<?php echo base_url()."customer/assign/".$this->uri->segment(3); ?>" class="add_assign waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable">
                                                <i class="mdi mdi-plus-circle mr-1"></i>Assign lead
                                            </a>
                                        </header>
                                    <table id="scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                                        <thead>
                                            <tr>
                                                
                                                <th>Assign</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Next Step</th>
                                                <th>Next Step date</th>
                                                <th>Hotness</th>
                                                <th>Age</th>
                                             </tr>
                                        </thead>
                                            <tbody>
                                                <?php  function humanTimingd ($time) {
                                                        $time = time() - $time; // to get the time since that moment
                                                        $time = ($time<1)? 1 : $time;
                                                        $tokens = array (
                                                            31536000 => 'year',
                                                            2592000 => 'month',
                                                            604800 => 'week',
                                                            86400 => 'day',
                                                            3600 => 'hour',
                                                            60 => 'minute',
                                                            1 => 'second'
                                                        );
                                                foreach ($tokens as $unit => $text) {
                                                        if ($time < $unit) continue;
                                                        $numberOfUnits = floor($time / $unit);
                                                        return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
                                                        }
                                                    }
                                                $lead_source = $this->config->item('lead_source', 'tank_auth');
                                            if( !empty($leads) ){
                                                foreach( $leads as $key => $lead ){
                                                    $dt = new DateTime();
                                                    $olddate = strtotime( $lead->created );
                                                    $curdate = strtotime( $dt->format('Y-m-d') );
                                                    $age= humanTiming($olddate);
                                                    if(!empty($lead->reminder_date)){
                                                        $datetime = $lead->reminder_date;
                                                         $rem = date("m-d-Y", strtotime($datetime));
                                                    }else{  $rem='NA'; } ?>
                                                <tr class="Mystyle<?php echo  $lead->id; ?>">
                                                    <?php
                                                    if( isset($lead->assigned_to) && !empty( $lead->assigned_to ) ){
                                                            $assigned_name = $this->db->where('id',$lead->assigned_to)->get('user_profiles')->row()->name;
                                                        }
                                                        else{
                                                            $assigned_name = 'NA';
                                                        }
                                                    if(!empty($lead->action_lead)){
                                                        $Ld=$lead->action_lead;
                                                    }else{
                                                            $Ld='NA';
                                                        }
                                                    if(!empty($lead->status)){
                                                        $sta=$lead->status;

                                                    }else{
                                                        $sta='NA';
                                                        }
                                                    if(!empty($lead->hoteness)){
                                                        $hot=$lead->hoteness;
                                                    }else{
                                                        $hot='NA';
                                                        }
                                                     ?>
                                                    
                                                    <td><a href="<?php echo base_url().'crm/leads/dashboard/'.$lead->id; ?>"><?php echo $assigned_name; ?></a></td>
                                                    <td><a href="<?php echo base_url().'crm/leads/dashboard/'.$lead->id; ?>"><?php echo ucwords( $lead->first_name . ' ' . $lead->last_name ); ?></td>
                                                    <td><a href="<?php echo base_url().'crm/leads/dashboard/'.$lead->id; ?>"><?php echo $lead->email; ?></a></td>
                                                    <td><?php echo $lead->phone; ?></td>
                                                    <td><?php echo $sta; ?></td>
                                                    <td><?php echo $Ld; ?></td>
                                                    <td><?php echo $rem; ?></td>
                                                    <td><?php echo $hot; ?></td>
                                                    <td><?php echo $age; ?></td>
                                                </tr>
                                                    <?php }
                                                    }else{?>
                                                <tr><td colspan="9" align="center">No record found</td></tr>
                                                            <?php } ?> 
                                            </tbody>
                                        </table>  
                                    </div>  
                                </div>
                            </div>
                        </div> <!-- end card body-->
                    </div> <!-- end card -->
                </div><!-- end col-->
            </div> <!-- end row-->
        </div> <!-- container -->
                 