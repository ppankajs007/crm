<style>
    .error {
    display: none;
    width: 100%;
    margin-top: .25rem;
    font-size: .75rem;
    color: #f1556c;
    display: block;
}
  .task_b {
    position: absolute;
    visibility: hidden;
}
.form-group.check_box_outer label input {
    margin-top: 0;
    position: relative;
    top: 2px;
}
.form-group.check_box_outer label {
    margin: 0 14px 0 0px;
}
.qfAmount {
    display: flex;
    display: none;
}

  </style>
    <div class="content-pageee">
        <div class="content"><!-- Start Content-->
           <div class="container-fluid"><!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <?php  if( empty($leads) ) return;;
                                 extract($leads);
                                 $name1= @$first_name.' '.@$last_name; 
                                   $na= trim($name1); ?>
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                 <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/leads">Leads</a></li>
                                 <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/leads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                 <li class="breadcrumb-item active">Edit Lead</li>
                             </ol>
                        </div>
                   <!--<h4 class="page-title">Leads</h4>-->
                   <h4 class="page-title">Lead(#<?php echo $id.' '.$first_name;?>)</h4>
                </div>
            </div>
          </div> <!-- end row --> 
        <div class="row">
          <div class="col-12">   
             <div class="card">
                <div class="card-body">
                   <?php $attr = array( 'id' => 'edit_form'); echo form_open($this->uri->uri_string(),$attr); ?>
        <div class=row>
          <div class="col-6">
            <div class="form-group ">
              <label for="name">Full Name</label>
                <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                <input type="text" class="form-control" name="first_name" value="<?php echo $na;?>" placeholder="Enter full name" requried>
                <div class="invalid-feedback"></div>
            </div>
          </div>
        <div class="col-3">
          <div class="form-group">
              <label for="exampleInputEmail1">Email address</label>
              <input type="email" class="form-control" name="email" value="<?php echo $email;?>" id="exampleInputEmail1" placeholder="Enter email" >
          </div>
        </div>
         <div class="col-3">
          <div class="form-group">
              <label for="exampleInputEmail1">Secondary Emai</label>
              <input type="email" class="form-control" name="secondry_email" value="<?php echo $secondry_email;?>" id="exampleInputEmail1" placeholder="Enter secondary email" >
          </div>
        </div>
      </div><!--end row"> -->
      <div class=row>
        <div class="col-6">
          <div class="form-group">
              <label for="position">Main Phone</label>
              <input type="text" class="form-control phone" name="phone" value="<?php echo $phone;?>"  id="phone" placeholder="Enter phone number">
          </div>
        </div>
        <div class="col-6">
          <div class="form-group">
                <label for="position">Second Phone</label>
               <input type="text" class="form-control" name="second_phone" value="<?php echo $second_phone;?>" id="second_phone" placeholder="Enter Second number">
          </div>
        </div>
      </div><!--end row"> -->
      <div class="form-group">
          <label for="position">Contact Prefrence</label>
              <input type="text" class="form-control" name="contact_preprence" value="<?php echo $contact_preprence;?>" id="position" placeholder="Enter Contact Preprence ">
      </div>
       <div class="form-group">
          <label for="position">Comments</label>
            <textarea rows="2" name="comments" class="form-control" cols="50"><?php echo $comments;?></textarea>
        </div>
      <div class=row>
          <div class="col-6">
              <div class="form-group">
                  <label for="position">Assigned To</label>
                    <select class="form-control" name="assigned_to" value=""> 
                        <option value="" id="0">Select option</option>
                        	<?php  foreach ($users as $us){ ?> 
                          <option value="<?php echo $us['user_id'];?>" <?php echo (($us['user_id']==$assigned_to)?"selected":""); ?> id="0"><?php echo $us['name'];?></option>
                        <?php }?>
                    </select>
              </div>
          </div>
        <div class="col-6">
            <div class="form-group">
                <label for="position">Status</label>
                <select class="form-control" id="lead_status" name="lead_status"  data-toggle="select2"> 
                    <option value="" id="0">Select option</option>
                    <?php foreach ($lead_statuss as $st) {
                              if($st['id']== 11){
                                }else{?>
                    <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                       <?php }}?>
                </select>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label for="position">Qualified Status</label>
                <select class="form-control" id="qf_lead_status" name="qf_lead_status"  data-toggle="select2"> 
                    <option value="" id="0">Select option</option>
                    <option value="qualified" <?php echo ( $qf_lead_status == 'qualified' )? 'selected':''; ?> >Qualified</option>
                    <option value="disqualified" <?php echo ( $qf_lead_status == 'disqualified' )? 'selected':''; ?> >DisQualified</option>
                    <option value="unqualified" <?php echo ( $qf_lead_status == 'unqualified' )? 'selected':''; ?> >UnQualified</option>
                </select>
            </div>
        </div>
        <div class="col-6">
              <div class="form-group">
                <?php
                 $qfDisplay = '';
                 if ( $qf_lead_status == 'qualified' ) {
                   $qfDisplay = 'style="display:block;display:flex;"';
                } ?>
                <div class="qfAmount" <?php echo $qfDisplay; ?>>
                  <div class="qf_low">
                      <label for="position">Low</label>
                      <input type="text" autocomplete="off" value="<?php echo $qf_low_amount; ?>" name="qf_low" class="form-control">
                  </div> &nbsp &nbsp 
                  <div class="qf_high">
                      <label for="position">High</label>
                       <input type="text" autocomplete="off" value="<?php echo $qf_high_amount; ?>" name="qf_high" class="form-control">
                  </div>
                </div>
              </div>
            </div>
    </div><!--end row"> -->
      <div class="col-md-12" id="lost_id" style="display:none" >
          <div class="form-group ">
            <label for="">Lost Sale Reason</label>
            <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail"   cols="50"><?php echo $lost_sale_detail;?></textarea>
                  <div class="invalid-feedback"></div>
          </div>          
        </div>
      <div class="row">
       <div class="col-md-6">
        <div class="form-group">
            <label>Next Step date</label>
            <input type="text" id="dateMasksnd" name="reminder_date" value="<?php echo crm_date($reminder_date); ?>" placeholder="mm-dd-yyyy" class="form-control" > 
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group inline check_box_outer">
            <label for="position">Hotness</label>
            <label class="radio-inline">
                <input name="hoteness" type="radio" id="signi" value="1" <?php echo ($hoteness== '1') ?  "checked" : "" ;  ?>/> 1<br>
                </label>
                <label class="radio-inline">
                <input name="hoteness" type="radio" id="signi" value="2" <?php echo ($hoteness== '2') ?  "checked" : "" ;  ?>/> 2<br>
                </label>
                <label class="radio-inline">
                <input name="hoteness" type="radio" id="signi" value="3" <?php echo ($hoteness== '3') ?  "checked" : "" ;  ?>/> 3<br>
                </label>
                <label class="radio-inline">
                <input name="hoteness" type="radio" id="signi" value="4" <?php echo ($hoteness== '4') ?  "checked" : "" ;  ?>/> 4<br>
                </label>
                <label class="radio-inline">
                <input name="hoteness" type="radio" id="signi" value="5" <?php echo ($hoteness== '5') ?  "checked" : "" ;  ?>/> 5<br>
            </label>
         </div>
      </div>
    </div><!--end row"> -->
      <div class="row">
          <div class="col-6">
            <div class="form-group">
                <label for="">Next Action <?php echo ( $action_lead ) ? '<mark>'.$action_lead.'</mark>': ''; ?></label>
                <input type="hidden" name="old_action_lead" value="<?php echo $action_lead; ?>">
                <select  class="form-control" id="next_action" name="action_lead"  data-toggle="select2" name="nextAction">
                    <?php
                    $hiddenClass = 'hideTrue';
                    $lead_next_action = json_decode(lead_next_action);
                    echo '<option value="">Select.....</option>';
                    foreach ( $lead_next_action as $key => $value) {
                        echo '<optgroup label="'.$key.'">';
                            foreach ($value as $ckey => $cValue) {
                              if ($action_lead == $cValue) {
                              	$hiddenClass = '';
                                $sl = 'selected="selected"';
                              }else{
                                $sl = ''; 
                              }
                              echo "<option>$cValue</option>";
                            }
                        echo '</optgroup>';
                    } ?>
                </select>
                <div id="call_customer_meta" class="row col-12 <?php echo $hiddenClass; ?>">
                	<p>Call Schedule</p>
            		<input type="text" class="form-control col-3 offset-md-1" name="call_start_time" value="<?php echo $call_start_time; ?>" placeholder="Start Time"> 
            		<input type="text" class="form-control col-3 offset-md-1" name="call_end_time" value="<?php echo $call_end_time; ?>" placeholder="End Time">
                </div>
            </div>  
        </div>
        <div class="col-6">
              <div class="form-group">
                <label for="">Last Action  <?php echo ( $last_action ) ? '<mark>'.$last_action.'</mark>': ''; ?></label>
                <input type="hidden" name="old_last_action" value="<?php echo $last_action; ?>">
                <select  class="form-control" id="last_action" name="last_action"  data-toggle="select2" name="lastAction">
                    <?php
                    $lead_last_action = json_decode(lead_last_action);
                    echo '<option value="">Select.....</option>';
                    foreach ( $lead_last_action as $key => $value) {
                        echo '<optgroup label="'.$key.'">';
                            foreach ($value as $ckey => $cValue) {
                              if ($last_action == $cValue) {
                                $sl = 'selected="selected"'; 
                              }else{
                                $sl = ''; 
                              }
                              echo "<option>$cValue</option>";
                            }
                        echo '</optgroup>';
                    } ?> 
                </select>
            </div>  
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="position">Next Action Note</label>
                <textarea rows="8" name="note" class="form-control" cols="50"><?php echo $note;?></textarea>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="position">Last Action Note</label>
                <textarea rows="8" name="last_action_note" class="form-control" cols="50"><?php echo $last_action_note;?></textarea>
            </div>
        </div>
        <!-- <div class="col-md-6">
            <div class="form-group">
                <label for="position">Action</label>
                <select class="form-control" name="action_lead" data-toggle="select2"> 
                    <?php if(!empty($action_lead)){?>
                    <option value="<?php echo $action_lead;?>"><?php echo $action_lead;?></option>
                      <?php }else{?>
                    <option value="" id="0">Select option</option>
                    <?php }?>
                    <option value="Task">Task</option>
                    <option value="Appointment">Appointment</option>
                    <optgroup label="You">
                    <option value="You Called">You Called</option>
                    <option value="You Emailed">You Emailed</option>
                    <option value="You Left Voicemail">You Left Voicemail</option>
                    <option value="You Fixed">You Fixed</option>
                    <option value="You Create Layout">You Create Layout</option>
                    <option value="You Create Pricing">You Create Pricing</option>
                    <option value="You Survey">You Survey</option>
                    </optgroup>
                    <optgroup label="Customer">
                    <option value="Customer Called">Customer Called</option>
                    <option value="Customer Emailed">Customer Emailed</option>
                    <option value="Customer Left Voicemail">Customer Left Voicemail</option>
                    <option value="Customer Faxed">Customer Faxed</option>
                    <option value="Customer Visited">Customer Visited</option>
                    <option value="Customer submitted layout">Customer submitted layout</option>
                    </optgroup>
                </select>
            </div>
        </div> -->
    </div><!--end row"> -->
            <div class="text-right">
                  <input type="hidden" name="created_lead" value="<?= $leads['created']; ?>">
                 <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
                 <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="window.location.href = '<?php echo base_url();?>crm/leads'">Cancel</button>
            </div>
            </form>
     </div> <?php echo form_close(); ?>
  </div>
 </div>
      
           </div></div>
      <link href="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/clockpicker/bootstrap-clockpicker.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
         <script src="<?php echo base_url();?>assets/js/vendor.min.js"></script>
   <!-- Plugins js-->
        <script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
        <script src="<?php echo base_url();?>assets/libs/bootstrap-colorpicker/bootstrap-colorpicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/libs/clockpicker/bootstrap-clockpicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
        <script src="<?php echo base_url();?>assets/js/pages/form-pickers.init.js"></script>

        