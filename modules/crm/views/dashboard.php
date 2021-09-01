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

.clear {
    clear: both;
}

.sms_in {
    float: left;
    background-color: #e8e8e8;
    margin: 15px 0;
}

.sms_out {
    float: right;
    background-color: #1abc9c;
    color: #fff;
}

.smst {
    padding: 4px 8px;
    border-radius: 4px;
    clear: both;
    max-width: 75%;
    margin-top: 15px;
}
.sms_admin {
    float: right;
    color: black;
}

.smstname {
    border-radius: 4px;
    clear: both;
    font-size: 10px;
    margin-top: -12px;
    margin-left: 10px;
}
.sms_timeout {
    float: left;
    color: black;
}

.smst span {
    margin-left: 0px;
}

.btn-success {
    display: block;
    width: 100%;
}

.timeline:before {
    background-color: #dee2e6;
    bottom: 0;
    content: "";
    left: 50%;
    position: absolute;
    top: 30px;
    width: 2px;
    z-index: 0;
    display: none;
}

.timeline {
    margin-bottom: 8px;
    position: relative;
    padding: 10px 10px 0;
}

.add_file {
    float: right;
}

.additional_list.activ .slimscroll {
    max-height: 409px !important
}

.additional_list.messenger .chatbox.slimscroll {
    height: 322px !important;
}

.comment-list {
    position: relative;
}

.comment-list:before {
    position: absolute;
    top: 0;
    bottom: 35px;
    left: 18px;
    width: 1px;
    background: #e0e4e8;
    content: '';
}

.comment-list .comment-item {
    margin-top: 18px;
    position: relative;
}

.text-info {
    color: #4cc0c1;
}

.comment-list .comment-item .comment-body {
    margin-left: 46px;
}

.comment-list article span.fa-stack {
    float: left;
}

.comment-list .comment-item:last-child {
    margin-bottom: 16px;
}

li.list-group-item:nth-child,
li.list-group-item:last-child {
    border: block !important;
}

li.nineboxexlayout {
    width: 10%;
    display: inline-block;
}

.nineBoxesYes {
    background: #169c82;
    color: white;
    width: 17px;
    height: 18px;
    border-radius: 100%;
}

.nineBoxesNo {
    background: #e43c55;
    color: white;
    border-radius: 100%;
    width: 17px;
    height: 18px;
}

.box_outer.nine_outer {
    display: flex;
    border: none;
    align-items: center;
}

.box_outer.nine_outer label {
    margin-left: 11px;
}

</style>
<div class="container-fluid">  <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <?php  if( empty($leads) ) return;
                $name= $leads[0]->first_name.' '.$leads[0]->last_name;
                if(!empty($leads[0]->lead_status)){
                $lead['status'] = $this->db->where('id',$leads[0]->lead_status)->get('status_lead')->row()->status;
                }else{
                    $lead['status']="NA";
                }
                if( !empty( $leads[0]->assigned_to) ){
                    $lead['name'] = $this->db->where('user_id',$leads[0]->assigned_to)->get('user_profiles')->row()->name;
                }else{
                    $lead['name'] = 'NA';
                    }
                if(!empty($leads[0]->reminder_date)){
                    $rem = crm_date($leads[0]->reminder_date);
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
                    }
                if(!empty($leads[0]->secondry_email)){
                    $second_E = $leads[0]->secondry_email;
                }else{
                    $second_E ='NA';
                    }
                    $surveyQus = $this->crm_model->findWhere('survey_answers', array('lead_id' => $leads[0]->id), true, array('answer') );
                    $sum = 0;
                    foreach($surveyQus as $value ){
                        $point = 0;
                        $surveypoint = $this->crm_model->findWhere( $table = 'survey_qoptions', $where_data = array('id' => $value['answer']), $multi_record = true, $select = array('point') );
                        if( isset($surveypoint[0]['point']) ){
                        $point = $surveypoint[0]['point'];
                        $sum += $point;
                        }
                    } ?>
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/leads">Leads</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                        <li class="breadcrumb-item active"><?php echo  $leads[0]->first_name;?></li>
                    </ol>
                </div>
                <h4 class="page-title">Leads(# <?php echo  $leads[0]->id.' '.$leads[0]->first_name.' ' .$leads[0]->last_name;?>)</h4>
            </div>
        </div>
    </div><!-- end row -->

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
                                    <h5><strong>   <?php echo $lead['status'];?>  </strong>  </h5>
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="box_outer">
                                <label style="">Last Action</label>
                                    <h5><strong>  <?php echo $leads[0]->last_action;?> </strong>  </h5> 
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="box_outer">
                                <label style="">Last Action Date</label>
                                <?php    
                                    $old_date_timestamp = strtotime($leads[0]->last_action_time);
                                    $new_date = date('m-d-Y', $old_date_timestamp); 
                                ?>
                                <h5><strong>  <?php echo $new_date;?> </strong>  </h5> 
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="box_outer">
                                <label >Next Action</label>
                                    <h5><strong><?= !empty( $leads[0]->action_lead ) ?  $leads[0]->action_lead  : 'N/A'; ?></strong>  </h5> 
                            </div> 
                        </div>
                        <div class="col-md-2">
                            <div class="box_outer">
                                <label >Next Action Date</label>
                                    <h5><strong>  <?php echo $rem;?>   </strong>  </h5> 
                            </div> 
                        </div>
                        <div class="col-md-1">
                            <div class="box_outer" style="border:none;">
                                <label>Assign</label>
                                    <h5><strong>  <?php echo $lead['name'];?>  </strong>  </h5> 
                            </div> 
                        </div>
                        <div class="information_outer"></div>
                        <ul class="nineBoxUl"style="width: 100%;">
                        <?php

                        $nine_array = array( 'W1d' => 'w1d', 'W1n' => 'w1n', 'W1e' => 'w1e','W2d' => 'w2d','W2n' => 'w2n','W2e' => 'w2e','SMS 1' => 'sms1','SMS 2' => 'sms2','SMS 3' => 'sms3');
                        
                        foreach ($nine_array as $key => $value) {
                            foreach ($nine_boxes as $keyb => $valueb) { 
                             ?>

                            <li class="nineboxexlayout">
                                <div class="box_outer nine_outer">
                                    
                                  <? if ( $valueb[$value] ){ ?>
                                        
                                        <div class="nineBoxesYes"><i class="fe-check"></i></div>
                                  
                              <?php }else{ ?>
                              
                                        <div class="nineBoxesNo"><i class="fe-x"></i></div>
                                  
                              <?php } ?>
                              <label><?= $key; ?></label>
                                </div>
                            </li>
                        <?php }
                         }

                         ?>
                        </ul>
                        <div class="information_outer"></div> 
                        <div class="col-md-4">
                            <div class="additional_list activ">
                                <header class="panel-heading">Details <a href="<?php echo base_url();?>crm/leads/edit_leads/<?php echo $leads[0]->id; ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable"><i class="fe-edit-2"></i></a></header>
                                <div class='slimscroll' style="max-height:400px;">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right text"><?php echo $name;?></span>
                                            <span class="text-muted"> Name </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $leads[0]->email;?></span>
                                            <span class="text-muted">Email </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $second_E;?></span>
                                            <span class="text-muted"> Secondry Email </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo phoneNumberPattern($leads[0]->phone); ?></span>
                                            <span class="text-muted">Main Phone </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $second_p;?></span>
                                            <span class="text-muted">Second Phone </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $leads[0]->contact_preprence;?></span>
                                            <span class="text-muted">Contact Prefrence </span>  
                                        </li>
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
                                            <span class="text-muted">Lost Sale Reason </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $leads[0]->hoteness;?></span>
                                            <span class="text-muted">Hotness </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $sum;?></span>
                                            <span class="text-muted">Survey </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php echo $leads[0]->action_lead;?></span>
                                            <span class="text-muted">Latest Action</span>  
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
                        </div>
                        <div class="col-md-4">
                            <div class="additional_list activ">
                                <header class="panel-heading">Activities</header>
                                    <div class='slimscroll' style='max-height: 350px;'>
                                        <section class="comment-list block">
                                            <?php
                                            if( isset( $activities ) && !empty( $activities ) ) {
                                            foreach( $activities as $activity ){ ?>
                                                <article class="comment-item">
                                                    <span class="fa-stack pull-left m-l-xs"> 
                                                        <i class="fa fa-circle text-success fa-stack-2x"></i> 
                                                        <i class="fe-edit-2 text-white fa-stack-1x"></i> 
                                                    </span>
                                                    <section class="comment-body m-b-lg">
                                                        <header> 
                                                            <strong><?php echo $activity['name'] ?></strong>
                                                            <span class="text-muted text-xs"> at <?php echo $activity['activity_time'] ?> </span>
                                                        </header>
                                                            <div><?php echo $activity['activity_message']  ?></div>
                                                            <?php if( !empty($activity['old_val']) && !empty($activity['new_val'])  ){ ?>
                                                            <div> <b><?php echo $activity['old_val'] ?> =&gt; <?php echo $activity['new_val'] ?> </b></div>
                                                            <?php } ?>
                                                    </section>
                                                </article>
                                            <?php  }}?>
                                        </section>
                                    </div>
                            </div>                                                
                        </div>
                        <div class="col-md-4">
                            <div class="additional_list messenger"> 
                                <header class="panel-heading"> Messenger</header>
                                <ul class="list-group no-radius">
                                    <div class="timeline profile_page_" dir="ltr">
                                        <h5 class="card-title"><i class="fe-edit-2"></i> &nbsp;Messenger <?php echo $name; ?></h5>
                                        <div class="card-text">
                                            <div class='chatbox slimscroll' style='max-height: 350px;'>
                                                <?php   foreach ($lsms as $sKey => $sVal) {

                                                            $day = new DateTime( $sVal->sms_time); 
                                                            $old_date = $day->format('F jS, Y h:i A');

                                                            echo "<p class='smst sms_$sVal->sms_type'><span>".$sVal->sms_text."</span></p>"; 
                                                            if ($sVal->sms_type =='out') {

                                                                if(!empty($sVal->admin_id) && $sVal->admin_id !='0'){
                                                                $sentby = (array) App::get_row_by_where('user_profiles', array('user_id'=>$sVal->admin_id) );
                                                                echo "<span class='smstname sms_admin' >Sent by ".$sentby['name']." ".$old_date."</span>";
                                                                }else{
                                                                    echo "<span class='smstname sms_admin' >Sent by Automated ".$old_date."</span>";
                                                                }

                                                            }else{
                                                                         echo "<span class='smstname sms_timeout' > ".$old_date."</span>";
                                                            }
                                                        } 
                                                ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="md-form">
                                            <div class='row'>
                                                <div class="col-md-9">
                                                    <textarea id="smstext" name='smstext' class="md-textarea form-control" rows="1" required /></textarea>
                                                    <input type='hidden' id="lid" name='lid' value='<?php echo $leads[0]->id; ?>'>
                                                    <input type='hidden' id="lnmbr" name='lnmbr' value='<?php echo $leads[0]->phone; ?>'>
                                                </div>
                                                <div class="col-md-3">
                                                    <button type="submit" id="submit" class="btn btn-success waves-effect waves-light"><i class="fe-send"></i></button>
                                                </div>
                                            </div>
                                        </div>   
                                    </div>
                                </ul>
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="additional_list">
                                <header class="panel-heading"> Paperwork Details <a href="<?php echo base_url();?>crm/PWleads/edit/<?php echo $leads[0]->id; ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable" target="_blank"><i class="fe-edit-2"></i></a></header>
                                    <ul class="list-group no-radius">
                                         <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($leads[0]->pw_mmethod)){ echo $leads[0]->pw_mmethod;}else{echo '--';}?></span>
                                            <span class="text-muted">Measurement Method </span>  
                                        </li>
                                    </ul>
                            </div>                                                
                        </div>
                        <?php if(!empty($hold[0]->lead_id)) { ?>
                        <div class="col-md-6">
                            <div class="additional_list">
                                <header class="panel-heading"> Hold On Design </header>
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($hold[0]->hold_reason)){ echo $hold[0]->hold_reason;}else{echo'--';}?></span>
                                            <span class="text-muted">Hold Reason </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <?php if(!empty($hold[0]->hold_next_step_date)){ $hold_next_step_date = crm_date($hold[0]->hold_next_step_date);
                                                }else{ $hold_next_step_date='--';   } ?>
                                            <span class="pull-right"><?php if(!empty($hold_next_step_date)){ echo $hold_next_step_date;}else{echo '--';}?></span>
                                                 <span class="text-muted">Hold Next Action Date </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($hold[0]->hold_next_step)){ echo $hold[0]->hold_next_step;}else{echo '--';}?></span>
                                            <span class="text-muted">Hold Next Action </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($hold[0]->hold_owner)){ echo $hold[0]->hold_owner; }else{ echo '--';}?></span>
                                            <span class="text-muted">Hold Owner </span>  
                                        </li>
                                    </ul>
                            </div>                                                
                        </div>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="additional_list">
                                <header class="panel-heading"> Measurement Details <a href="<?php echo base_url();?>crm/MRLeads/edit/<?php echo $leads[0]->id; ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable"target="_blank"><i class="fe-edit-2"></i></a></header>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="additional_list">
                                <ul class="list-group no-radius">
                                    <li class="list-group-item">
                                        <span class="pull-right"><?php  if( !empty( $leads[0]->mr_status) ){ $int_status = $this->db->where('id',$leads[0]->mr_status)->get('lead_int_status')->row()->status;}  
                                                       else{   $int_status = '--'; } echo  $int_status; ?></span>
                                                        <span class="text-muted">Status</span>  
                                    </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_custavail ) ){ echo $Mleads[0]->mr_custavail; } else { echo '--'; }?></span>
                                            <span class="text-muted">Customer Availability</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->phone ) ){ echo $Mleads[0]->phone; } else { echo '--'; }?></span>
                                            <span class="text-muted">Customer Phone</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_custaddress ) ){ echo $Mleads[0]->mr_custaddress; } else { echo '--'; }?></span>
                                            <span class="text-muted">Address</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_city ) ){ echo $Mleads[0]->mr_city; } else { echo '--'; }?></span>
                                            <span class="text-muted">City</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_state ) ){ echo $Mleads[0]->mr_state; } else { echo '--'; }?></span>
                                            <span class="text-muted">State</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_zip ) ){ echo $Mleads[0]->mr_zip; } else { echo '--'; }?></span>
                                            <span class="text-muted">Zip</span>  
                                        </li>
                                </ul>
                            </div>                                                
                        </div>
                            <div class="col-md-6">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_msdate ) ){ echo $Mleads[0]->mr_msdate; } else { echo '--'; }?></span>
                                                <span class="text-muted">M/S Date</span>  
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_mstime ) ){ echo $Mleads[0]->mr_mstime; } else { echo '--'; }?></span>
                                                    <span class="text-muted">M/S Time</span>  
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_measurer ) ){ echo $Mleads[0]->mr_measurer; } else { echo '--'; }?></span>
                                                    <span class="text-muted">Measurer</span>  
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_surveysent ) ){ echo $Mleads[0]->mr_surveysent; } else { echo '--'; }?></span>
                                                    <span class="text-muted">Survey Sent</span>  
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_surveycompleted ) ){ echo $Mleads[0]->mr_surveycompleted; } else { echo '--'; }?></span>
                                                    <span class="text-muted">Survey Complete</span>  
                                                </li>
                                                <li class="list-group-item">
                                                    <span class="pull-right"><?php if( !empty( $Mleads[0]->mr_dpcompletion ) ){ echo $Mleads[0]->mr_dpcompletion; } else { echo '--'; }?></span>
                                                    <span class="text-muted">Days pending Completion</span>  
                                                </li>
                                    </ul>
                                </div>                                                
                            </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="additional_list">
                                <header class="panel-heading"> Qualified Details <a href="<?php echo base_url();?>crm/Qualified/edit/<?php echo $leads[0]->id; ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable" target="_blank"><i class="fe-edit-2"></i></a></header>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                            <div class="col-md-6">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php  if( !empty( $leads[0]->qf_status) ){ echo $this->db->where('id',$leads[0]->qf_status)->get('lead_int_status')->row()->status; 
                                                           } else { echo '--'; }   ?></span>
                                            <span class="text-muted">Status</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <?php  if(!empty($leads[0]->qf_dateRecieved)){  $qf_dateRecieved  = crm_date($leads[0]->qf_dateRecieved);
                                                         }else{  $qf_dateRecieved='--';  } ?>
                                            <span class="pull-right"><?php echo $qf_dateRecieved; ?></span>
                                            <span class="text-muted">Date Recieved</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <?php if(!empty($leads[0]->qf_dateAdded)){ $qf_dateAdded = crm_date($leads[0]->qf_dateAdded);
                                            }else{   $qf_dateAdded='--';  } ?>
                                            <span class="pull-right"><?php  echo $qf_dateAdded; ?></span>
                                            <span class="text-muted">Date Added</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <?php if(!empty($leads[0]->qf_datestarted)){ $qf_datestarted = crm_date($leads[0]->qf_datestarted);
                                                }else{ $qf_datestarted='--'; } ?>
                                            <span class="pull-right"><?php  echo $qf_datestarted; ?></span>
                                            <span class="text-muted">Date Started</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <?php if(!empty($leads[0]->qf_dateCompleted)){ $qf_dateCompleted = crm_date($leads[0]->qf_dateCompleted);
                                                }else{ $qf_dateCompleted='--';  } ?>
                                            <span class="pull-right"><?php  echo $qf_dateCompleted; ?></span>
                                            <span class="text-muted">Date Completed</span>  
                                        </li>
                                        <li class="list-group-item">
                                                <?php if(!empty($leads[0]->qf_dateSent)){ $qf_dateSent = crm_date($leads[0]->qf_dateSent);
                                                    }else{ $qf_dateSent='--';  } ?>
                                            <span class="pull-right"><?php  echo $qf_dateSent; ?></span>
                                            <span class="text-muted">Date Sent</span>  
                                        </li>
                                    </ul>
                                </div>                                                
                            </div>
                                <div class="col-md-6">
                                    <div class="additional_list">
                                        <ul class="list-group no-radius">
                                            <li class="list-group-item">
                                                <?php if(!empty( $leads[0]->qf_Kit_File_1)){
                                                        $link = $leads[0]->qf_Kit_File_1;
                                                        $link_array = explode('/',$link);
                                                        $qf_Kit_File_1 = end($link_array);
                                                        }else{
                                                        $qf_Kit_File_1= '--';
                                                    } ?>
                                                <span class="pull-right"><?php if( !empty( $leads[0]->qf_Kit_File_1 ) ){ echo '<a target=”_blank” href="'.$leads[0]->qf_Kit_File_1.'">'.$qf_Kit_File_1.'</a>'; } else { echo '--'; }?></span>
                                                <span class="text-muted">Kit File 1</span>  
                                            </li>
                                            <li class="list-group-item">
                                                <?php if(!empty( $leads[0]->qf_Kit_File_2)){
                                                            $link = $leads[0]->qf_Kit_File_2;
                                                            $link_array = explode('/',$link);
                                                            $qf_Kit_File_2 = end($link_array);
                                                            }else{
                                                            $qf_Kit_File_2= '--';
                                                        }?>
                                                <span class="pull-right"><?php if( !empty( $leads[0]->qf_Kit_File_2 ) ){ echo '<a target=”_blank” href="'.$leads[0]->qf_Kit_File_2.'">'.$qf_Kit_File_2.'</a>'; } else { echo '--'; }?></span>
                                                <span class="text-muted">Kit File 2</span>  
                                            </li>
                                            <li class="list-group-item">
                                                <?php if(!empty( $leads[0]->qf_Panoramic_D1)){
                                                        $link = $leads[0]->qf_Panoramic_D1;
                                                        $link_array = explode('/',$link);
                                                        $qf_Panoramic_D1 = end($link_array);
                                                        }else{
                                                        $qf_Panoramic_D1= '--';
                                                    }?>
                                                <span class="pull-right"><?php if( !empty( $leads[0]->qf_Panoramic_D1 ) ){ echo '<a target=”_blank” href="'.$leads[0]->qf_Panoramic_D1.'">'.$qf_Panoramic_D1.'</a>'; } else { echo '--'; }?></span>
                                                <span class="text-muted">Panoramic D1</span>  
                                            </li><?php if(!empty( $leads[0]->qf_Panoramic_D2)){
                                                        $link = $leads[0]->qf_Panoramic_D2;
                                                        $link_array = explode('/',$link);
                                                        $qf_Panoramic_D2 = end($link_array);
                                                        }else{
                                                        $qf_Panoramic_D2 = '--';
                                                    } ?>
                                            <li class="list-group-item">
                                                <span class="pull-right"><?php if( !empty( $leads[0]->qf_Panoramic_D2 ) ){ echo '<a target=”_blank” href="'.$leads[0]->qf_Panoramic_D2.'">'.$qf_Panoramic_D2.'</a>'; } else { echo '--'; }?></span>
                                                <span class="text-muted">Panoramic D2</span>  
                                            </li>
                                            <li class="list-group-item">
                                                <?php if(!empty( $leads[0]->qf_Deck)){
                                                        $link = $leads[0]->qf_Deck;
                                                        $link_array = explode('/',$link);
                                                        $qf_Deck = end($link_array);
                                                        }else{
                                                        $qf_Deck = '--';
                                                    }?>
                                                <span class="pull-right"><?php if( !empty( $leads[0]->qf_Deck ) ){ echo '<a target=”_blank” href="'. $leads[0]->qf_Deck.'">'.$qf_Deck.'</a>'; } else { echo '--'; }?></span>
                                                <span class="text-muted">Deck</span>  
                                            </li>
                                            <li class="list-group-item">
                                                <span class="pull-right"><?php if( !empty( $leads[0]->qf_LIVE_PRESENTATION_DATE ) ){ echo crm_date($leads[0]->qf_LIVE_PRESENTATION_DATE); } else { echo '--'; }?></span>
                                                <span class="text-muted">LIVE PRESENTATION DATE</span>  
                                            </li>
                                                
                                        </ul>
                                    </div>                                                
                                </div>
                    </div>
                    <div class="col-md-12">
                        <div class="additional_list">
                            <div class="row"> 
                                <div class="col-md-12"><header class="panel-heading">Kitchen Details</header></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right text"><?php if(!empty($pw_pending[0]['cabinet_manufacturer'])){ echo $pw_pending[0]['cabinet_manufacturer'];}else{echo '--';}?></span>
                                            <span class="text-muted">
                                                Cabinet Manufacturer </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['door_style'])){ echo $pw_pending[0]['door_style'];}else{echo '--';}?></span>
                                            <span class="text-muted">Door Style </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['desired_flooring_type'])){ echo $pw_pending[0]['desired_flooring_type'];}else{echo '--';}?> </span>
                                            <span class="text-muted">Desired Flooring Type </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php  if(!empty($pw_pending[0]['desired_flooring_color'])){ echo $pw_pending[0]['desired_flooring_color'];}else{echo '--';}?></span>
                                            <span class="text-muted">Desired Flooring Color </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['backsplash'])){ echo $pw_pending[0]['backsplash'];}else{echo '--';}?></span>
                                            <span class="text-muted">Backsplash </span>  
                                        </li>
                                       <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['countertop_type'])){ echo $pw_pending[0]['countertop_type'];}else{echo '--';}?></span>
                                            <span class="text-muted">Countertop Type </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['countertop_color'])){ echo $pw_pending[0]['countertop_color'];}else{echo '--';}?></span>
                                            <span class="text-muted">Countertop Color </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['knobs_and_handles'])){ echo $pw_pending[0]['knobs_and_handles'];}else{echo '--';}?></span>
                                            <span class="text-muted">Knobs and Handles </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['sink_type'])){ echo $pw_pending[0]['sink_type'];}else{echo '--';}?></span>
                                            <span class="text-muted">Sink Type </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['sink_color'])){ echo $pw_pending[0]['sink_color'];}else{echo '--';}?></span>
                                            <span class="text-muted">Sink Color </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['sink_bowls'])){ echo $pw_pending[0]['sink_bowls'];}else{echo '--';}?></span>
                                            <span class="text-muted">Sink Bowls </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['keeping_existing'])){ echo $pw_pending[0]['keeping_existing'];}else{echo '--';}?></span>
                                            <span class="text-muted">Keeping Existing </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['dishwasher_size'])){ echo $pw_pending[0]['dishwasher_size'];}else{echo '--';}?></span>
                                            <span class="text-muted">Dishwasher Size </span>  
                                       </li>
                                    </ul>
                                </div>                                                
                            </div>
                            <div class="col-md-4">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right text"><?php if(!empty($pw_pending[0]['desired_dishwasher_color'])){ echo $pw_pending[0]['desired_dishwasher_color'];}else{echo '--';}?></span>
                                            <span class="text-muted">
                                            Desired Dishwasher Color </span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['dishwasher_quantity'])){ echo $pw_pending[0]['dishwasher_quantity'];}else{echo '--';}?> </span>
                                            <span class="text-muted">Dishwasher Quantity </span>
                                        </li>
                                        <li class="list-group-item">
                                             <span class="pull-right"><?php if(!empty($pw_pending[0]['range_size'])){ echo $pw_pending[0]['range_size'];}else{echo '--';}?></span>
                                            <span class="text-muted">Range Size </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['cooktop_size_p'])){ echo $pw_pending[0]['cooktop_size_p'];}else{echo '--';}?></span>
                                            <span class="text-muted">Cooktop Size </span>  
                                        </li>
                                        
                                         <li class="list-group-item">
                                                <span class="pull-right"><?php if(!empty($pw_pending[0]['wall_oven_count'])){ echo $pw_pending[0]['wall_oven_count'];}else{echo '--';}?></span>
                                                <span class="text-muted">Wall Oven Count </span>  
                                        </li>
                                        
                                          <li class="list-group-item">
                                                <span class="pull-right"><?php if(!empty($pw_pending[0]['wall_oven_width'])){ echo $pw_pending[0]['wall_oven_width'];}else{echo '--';}?></span>
                                                <span class="text-muted">Wall Oven Width </span>  
                                        </li>
                                          <li class="list-group-item">
                                                <span class="pull-right"><?php if(!empty($pw_pending[0]['microwave'])){ echo $pw_pending[0]['microwave'];}else{echo '--';}?></span>
                                                <span class="text-muted">Microwave </span>  
                                        </li>
                                        <li class="list-group-item">
                                                <span class="pull-right"><?php if(!empty($pw_pending[0]['microwave_width'])){ echo $pw_pending[0]['microwave_width'];}else{echo '--';}?></span>
                                                <span class="text-muted">Microwave Width </span>  
                                        </li>
                                        <li class="list-group-item">
                                                <span class="pull-right"><?php if(!empty($pw_pending[0]['hood'])){ echo $pw_pending[0]['hood'];}else{echo '--';}?></span>
                                                <span class="text-muted">Hood </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['refrigerator_width'])){ echo $pw_pending[0]['refrigerator_width'];}else{echo '--';}?></span>
                                            <span class="text-muted">Refrigerator Width </span>  
                                        </li>
                                           
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['refrigerator_depth'])){ echo $pw_pending[0]['refrigerator_depth'];}else{echo '--';}?></span>
                                            <span class="text-muted">Refrigerator Depth </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['applicance_other'])){ echo $pw_pending[0]['applicance_other'];}else{echo '--';}?></span>
                                            <span class="text-muted">Applicance Other </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['crown_molding'])){ echo $pw_pending[0]['crown_molding'];}else{echo '--';}?></span>
                                            <span class="text-muted">Crown Molding </span>  
                                        </li>
                                    </ul>
                                </div>                                                
                            </div>
                            <div class="col-md-4">
                                <div class="additional_list">
                                    <ul class="list-group no-radius">
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['crown_molding_touch_ceiling'])){ echo $pw_pending[0]['crown_molding_touch_ceiling'];}else{echo '--';}?></span>
                                            <span class="text-muted">Crown Molding Touch Ceiling </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['light_rail'])){ echo $pw_pending[0]['light_rail'];}else{echo '--';}?></span>
                                            <span class="text-muted">Light Rail </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['cabinet_wall_height'])){ echo $pw_pending[0]['cabinet_wall_height'];}else{echo '--';}?></span>
                                            <span class="text-muted">Cabinet Wall Height </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['option_request'])){ echo $pw_pending[0]['option_request'];}else{echo '--';}?></span>
                                            <span class="text-muted">Option Request</span>  
                                        </li><li class="list-group-item">
                                            <span class="pull-right"><?php  if(isset($pw_pending[0]['ceiling_height'])){ echo $pw_pending[0]['ceiling_height'];}else{echo '--';}?></span>
                                            <span class="text-muted">Ceiling Height </span>  
                                        </li><li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['soffit'])){ echo $pw_pending[0]['soffit'];}else{echo '--';}?></span>
                                            <span class="text-muted">Soffit </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['soffit_yes_keeping'])){ echo $pw_pending[0]['soffit_yes_keeping'];}else{echo '--';}?></span>
                                            <span class="text-muted">If Soffit Yes, Keeping? </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['walls_be_moved'])){ echo $pw_pending[0]['walls_be_moved'];}else{echo '--';}?></span>
                                            <span class="text-muted">Can any walls be moved? </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['doors_be_moved'])){ echo $pw_pending[0]['doors_be_moved'];}else{echo '--';}?></span>
                                            <span class="text-muted">Can Windows or Doors be Moved </span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['plumbing_be_moved'])){ echo $pw_pending[0]['plumbing_be_moved'];}else{echo '--';}?></span>
                                            <span class="text-muted">Can Plumbing Be Moved </span>  
                                        </li>
                                         <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['range_location_be_moved'])){ echo $pw_pending[0]['range_location_be_moved'];}else{echo '--';}?></span>
                                                <span class="text-muted">Can Hood/Range Location be Moved</span>  
                                        </li>
                                        <li class="list-group-item">
                                            <span class="pull-right"><?php if(!empty($pw_pending[0]['refrigerator_location_be_moved'])){ echo $pw_pending[0]['refrigerator_location_be_moved'];}else{echo '--';}?></span>
                                            <span class="text-muted">Can Refrigerator Location be Moved </span>  
                                        </li>
                                    </ul>
                                </div>                                                
                            </div>
                        </div>
                    </div>  
                 </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div><!-- end row-->
</div> <!-- container -->
              