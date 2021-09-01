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
        border: 2px solid #e8e8e8;
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
    .clear { clear:both; }  
    .sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
    .sms_out { float: right;     background-color: #1abc9c; color: #fff;}
    .smst { padding: 4px 8px; border-radius: 4px;clear: both; margin:10px; }
    .smst span{ margin-left:0px; }
    .btn-success {display: block; width: 100%;}
    .timeline:before {
        background-color: #dee2e6;
        bottom: 0;
        content: "";
        left: 50%;
        position: absolute;
        top: 30px;
        width: 2px;
        z-index: 0;
        display:none;
    }
    .timeline {
        margin-bottom: 8px;
        position: relative;
        padding: 10px 10px 0;
    }
</style>
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

    <?php    //print_r($leads);
          if( empty($leads) ) return;
            $name= $leads[0]->first_name.' '.$leads[0]->last_name;
                 

                if(!empty($leads[0]->lead_status)){
                    $lead['status'] = $this->db->where('id',$leads[0]->lead_status)->get('status_lead')->row()->status;
                }else{
                    $lead['status']="NA";
                }

                if( !empty( $leads[0]->assigned_to) ){
                    $lead['name'] = $this->db->where('id',$leads[0]->assigned_to)->get('user_profiles')->row()->name;
                }  
                else{
                   $lead['name'] = 'NA';
                }

                if(!empty($leads[0]->reminder_date)){
                    $datetime =  $leads[0]->reminder_date;
                    $rem = date("m-d-Y", strtotime($datetime));
                }else{
                    $rem="NA";
                }
                
                if(!empty($leads[0]->action_lead)){
                    $lead_a = $leads[0]->action_lead;
                }else{
                    $lead_a = "NA";
                }

                if(!empty($leads[0]->second_phone)){
                    $second_p = $leads[0]->second_phone;
                }else{
                    $second_p = "NA";
                } ?>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                    <ul class="overview_list" id="">
                                      <?php  echo modules::run('includes/lead_sub_menu');?>
                                     </ul>
    
                                <div class="clear"></div>
                                <div class="row total_list">
                                    <div class="col-md-3">
                                        <div class="box_outer">
                                        <label>Current Status</label>
                                         <!--<h4 class="cursor-pointer text-open small">Payments</h4>-->
                                         <h5><strong>   <?php echo $lead['status'];?>  </strong>  </h5>
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box_outer">
                                        <label style="">Next Step</label>
                                         <!--<h4 class="cursor-pointer text-open small">- Expenses</h4>-->
                                         <h5><strong>  <?php echo $lead_a;?> </strong>  </h5> 
                                        </div> 
                                    </div>
                                    <div class="col-md-3">
                                        <div class="box_outer">
                                             
                                        <label >Next Step Date</label>
                                         <!--<h4 class="cursor-pointer text-open small" style="color:#F05050">Pending</h4>-->
                                         <h5><strong>  <?php echo $rem;?>   </strong>  </h5> 
                                        </div> 
                                    </div>
                                     <div class="col-md-3">
                                        <div class="box_outer" style="border:none;">
                                        <label>Assign</label>
                                         <!--<h4 class="cursor-pointer text-success small" style="color:#F05050">Pending</h4>-->
                                         <h5><strong>  <?php echo $lead['name'];?>  </strong>  </h5> 
                                        </div> 
                                    </div>
                                    <div class="information_outer"></div>
    
                                
                                    
                                    <div class="col-md-4">
                                        <div class="additional_list">
                                            <header class="panel-heading">Details</header>
                                            <ul class="list-group no-radius">
                                                <li class="list-group-item">
                                                    <span class="pull-right text"><?php echo $name;?></span>
                                                    <span class="text-muted">
                                                        Name </span>
                                                </li>
                                                 <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->email;?></span>
                                                        <span class="text-muted">Email </span>  
                                                </li>
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->phone;?> </span>
                                                        <span class="text-muted">Main Phone </span>
                                                </li>
                                                
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $second_p;?></span>
                                                        <span class="text-muted">Second Phone </span>  
                                                </li>
                                                 
                                                 
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->contact_preprence;?></span>
                                                        <span class="text-muted">Contact Preprence </span>  
                                                </li>
                                                <!--<li class="list-group-item">-->
                                                <!--        <span class="pull-right"><?php// echo $leads[0]->survey;?></span>-->
                                                <!--        <span class="text-muted">Survey </span>  -->
                                                <!--</li>-->
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->comments;?></span>
                                                        <span class="text-muted">Comments </span>  
                                                </li>
                                                
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $lead['name'];?></span>
                                                        <span class="text-muted">Assigned To </span>  
                                                </li>
                                              <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $lead['status'];?></span>
                                                        <span class="text-muted">Status </span>  
                                                </li>
                                                
                                                 <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->lost_sale_detail;?></span>
                                                        <span class="text-muted">Lost Sale Detail </span>  
                                                </li>
                                                
                                                 <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->hoteness;?></span>
                                                        <span class="text-muted">Hoteness </span>  
                                                </li>
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->action_lead;?></span>
                                                        <span class="text-muted">Action </span>  
                                                </li>
                                              
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $rem;?></span>
                                                        <span class="text-muted">Reminder date </span>  
                                                </li>
                                                <li class="list-group-item">
                                                        <span class="pull-right"><?php echo $leads[0]->note;?></span>
                                                        <span class="text-muted">Note </span>  
                                                </li>
                                                
                                                
                                           </ul>
                                             
                                        </div>                                                
                                    </div>
                                    <div class="col-md-4">
                                        <div class="additional_list">
                                            <header class="panel-heading">Activities</header>
                                             <div class='slimscroll' style='max-height: 350px;'>
                                            <ul class="list-group no-radius">
                                                
                                             
                                                <?php 
    
                                               // print_r($activities);
                                                 
                                                if( isset( $activities ) && !empty( $activities ) ) {
                                                    foreach( $activities as $activity ){
    
                                                       // print_r($activity);
                                                ?>
                                                <li class="list-group-item">
                                                    <span class="pull-right text"><i class="mdi mdi-calendar-text"></i><?php echo date('m-d-Y', strtotime( $activity['created']));?></span>
                                                    <span class="text-muted">
                                                        <?php echo $activity['activity'];?> </span>
                                                </li>
                                                <?php } } ?>
                                           </ul>
                                       </div>
                                             
                                        </div>                                                
                                    </div>
                                    <div class="col-md-4">
                                            <div class="additional_list">
                                            <header class="panel-heading"> Messenger</header>
                                            <ul class="list-group no-radius">
                                                            <div class="timeline profile_page_" dir="ltr">
                            <h5 class="card-title"><i class="fe-edit-2"></i> &nbsp;Messenger <?php echo $name; ?></h5>
                        <div class="card-text">
                            <div class='chatbox slimscroll' style='max-height: 350px;'>
                        <?php 
                            // echo "<pre>"; var_dump($lsms); echo "<pre>";
                            foreach($lsms as $sKey => $sVal){
                                echo "<p class='smst sms_$sVal->sms_type'><span>".$sVal->sms_text."</span></p>";
                            } ?>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="md-form">
                              <div class='row'>
                          
                                  <div class="col-md-9">
                                      <textarea id="smstext" name='smstext' class="md-textarea form-control" rows="1" required/></textarea>
                                      <input type='hidden' id="lid" name='lid' value='<?php echo $leads[0]->id; ?>'>
                                      <input type='hidden' id="lnmbr" name='lnmbr' value='<?php echo $leads[0]->phone; ?>'>
                                      
                                  </div>
                                
                                <div class="col-md-3">
                                    <button type="submit" id="submit" class="btn btn-success waves-effect waves-light"><i class="fe-send"></i></button>
                                </div>
                                  </div>
                            </div>
                                                   </ul>
                                                     
                                                </div> 
                                        

                                              <!--   <div class="additional_list">
                                                    <header class="panel-heading"> Fields</header>
                                                    <ul class="list-group no-radius">
                                                        <li class="list-group-item">
                                                            <span class="pull-right text">asdf</span>
                                                            <span class="text-muted">
                                                                Company Name </span>
                                                        </li>
                                                        <li class="list-group-item">
                                                                <span class="pull-right"> </span>
                                                                <span class="text-muted">Contact Person </span>
                                                        </li>
                                                        <li class="list-group-item">
                                                                <span class="pull-right">admin@gmail.com </span>
                                                                <span class="text-muted">Email </span>  
                                                        </li>
                                                   </ul>
                                                     
                                                </div>  --> 
                                                
                                            </div>

                                        </div>
                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>
                        <!-- end row-->
                    </div> <!-- container -->
                  