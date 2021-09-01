<style>
.error {
  display: none;
  width: 100%;
  margin-top: .25rem;
  font-size: .75rem;
  color: #f1556c;
  display: block;
}
</style>
        
<div class="content-pageee">
    <div class="content"><!-- Start Content-->
        <div class="container-fluid"> <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">CRM</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>crm/MRLeads">Measurement Leads</a></li>
                                <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/MRLeads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                                <li class="breadcrumb-item active">
                                <?php if( empty($leads) ) return; extract($leads); echo  ucfirst($first_name); ?>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Measurement Leads(#<?php echo $id.' '.$first_name;?>)</h4>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-12">   
                    <div class="card">
                        <div class="card-body">
                            <?php 
                                $fullname = @$first_name.' '.@$last_name; 
                                $attr = array( 'id' => 'mreditform'); echo form_open($this->uri->uri_string(),$attr); //form starts here
                                ?>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group ">
                                        <label for="">Customer Name</label>
                                        <input type="hidden" id="id" name="lead_id" value="<?php echo $id; ?>">
                                        <input type="text" class="form-control" name="name" value="<?php echo $fullname;?>" placeholder="Enter full name" >
                                        <div class="invalid-feedback"></div>
                                    </div>          
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Measurement Required Status</label>
                                        <select  class="form-control" id="mr_status" name="mr_status" data-toggle="select2">
                                            <?php   foreach( $int_lead_status AS $int){  ?> 
                                            <option value="<?php echo $int['id']; ?>" <?php if($mr_status == $int['id']){ echo 'selected="selected"'; } ?> ><?php echo $int['status']; ?></option>
                                            <?php  }  ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Customer Availability</label>
                                        <input type="text" class="form-control" value="<?php echo $mr_custavail;?>" name="mr_custavail"  id="mr_custavail" >
                                    </div>
                                </div>
                                <div class="col-6">     
                                    <div class="form-group">
                                        <label for="">Customer Phone</label>
                                        <input type="text" class="form-control" value="<?php echo $phone;?>" name="phone"  id="phone" >
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row"> -->
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Address</label>
                                        <input type="text" class="form-control" name="mr_custaddress" value="<?php echo $mr_custaddress; ?>" id="mr_custaddress" >
                                    </div> 
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">City</label>
                                        <input type="text" class="form-control" name="mr_city" value="<?php echo $mr_city; ?>" id="mr_city" >
                                    </div>  
                                </div>
                            </div>  
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">State</label>
                                        <input type="text" class="form-control" name="mr_state" value="<?php echo $mr_state; ?>" id="mr_state" >
                                    </div>  
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Zip</label>
                                        <input type="text" class="form-control" name="mr_zip" value="<?php echo $mr_zip; ?>" id="mr_zip" >
                                    </div>  
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Measurer</label>
                                        <input type="text" class="form-control" name="mr_measurer" value="<?php echo $mr_measurer; ?>" id="mr_measurer" >
                                    </div>  
                                </div>
                                <!-- <div class="col-6">
                                    <div class="form-group">
                                        <label for="">Survey Sent</label>
                                        <input type="text" class="form-control" name="mr_surveysent" value="<?php echo $mr_surveysent; ?>" id="mr_surveysent" >
                                    </div>
                                </div> -->
                                <div class="col-6"> 
                                    <div class="form-group">
                                        <label for="position">Lead Status</label>
                                        <select class="form-control" id="lead_status" name="lead_status"  data-toggle="select2"> 
                                            <!--<option value="Select option" id="0">Select option</option>-->
                                           <?php  foreach ($lead_statuss as $st) {  ?> 
                                                <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12" id="lost_id" style="display:none" >
                                    <div class="form-group ">
                                        <label for="">lost sale Reason</label>
                                         <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail" cols="50"><?php echo $leads['lost_sale_detail']; ?></textarea>
                                        <div class="invalid-feedback"></div>
                                    </div>          
                                </div>
                            </div>
                          <div class="row">
                              <div class="col-6">
                                <div class="form-group">
                                    <label for="">Next Action</label>
                                    <select  class="form-control" id="next_action" name="action_lead"  data-toggle="select2" name="nextAction">
                                        <?php
                                        $lead_next_action = json_decode(lead_next_action);
                                        foreach ( $lead_next_action as $key => $value) {
                                            echo '<optgroup label="'.$key.'">';
                                                foreach ($value as $ckey => $cValue) {
                                                  if ($action_lead == $cValue) {
                                                    $sl = 'selected="selected"'; 
                                                  }else{
                                                    $sl = ''; 
                                                  }
                                                  echo "<option $sl>$cValue</option>";
                                                }
                                            echo '</optgroup>';
                                        } ?>
                                    </select>
                                </div>  
                            </div>
                            <div class="col-6">
                                  <div class="form-group">
                                    <label for="">Last Action</label>
                                    <select  class="form-control" id="last_action" name="last_action"  data-toggle="select2" name="lastAction">
                                        <?php
                                        $lead_last_action = json_decode(lead_last_action);
                                        foreach ( $lead_last_action as $key => $value) {
                                            echo '<optgroup label="'.$key.'">';
                                                foreach ($value as $ckey => $cValue) {
                                                  if ($last_action == $cValue) {
                                                    $sl = 'selected="selected"'; 
                                                  }else{
                                                    $sl = ''; 
                                                  }
                                                  echo "<option $sl>$cValue</option>";
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
                        </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
                                <a href="<?php echo base_url();?>crm/MRLeads" class="btn btn-danger waves-effect waves-light m-l-10" ><i class=""></i>Cancel</a>
                            </div>
                            <?php echo form_close(); ?>
                        </div><!-- .card-body end here-->
                    </div><!-- .card ends here -->
                </div><!-- col ends here -->
            </div><!-- row ends here -->
        </div>
    </div>
</div><!-- .content-pageee ends here -->
        