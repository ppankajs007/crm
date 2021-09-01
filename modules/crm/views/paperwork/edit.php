<style>
.error {
  display: none;
  width: 100%;
  margin-top: .25rem;
  font-size: .75rem;
  color: #f1556c;
  display: block;
}
.custombox-content > * {
    max-height: unset;
}
</style>
        
<div class="content-pageee">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid"><!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">CRM</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>crm/PWleads">Paperwork Pending</a></li>
                                <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/PWleads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">Edit</li>
                                <li class="breadcrumb-item active">
                                <?php  
                                    if( empty($leads) ) return;
                                    extract($leads);
                                    $fullname= @$first_name.' '.@$last_name;
                                    echo  ucfirst($fullname);
                                    ?>
                                </li>
                            </ol>
                        </div>
                        <h4 class="page-title">Paperwork Pending(#<?php echo $id.' '.$first_name;?>)</h4>
                    </div>
                </div>
            </div>  <!-- end row-->
            <div class="row">
                <div class="col-12">   
                    <div class="card">
                        <div class="card-body">
                            <?php   
                                if( empty($leads) ) return;
                                extract($leads);
                                $fullname= @$first_name.' '.@$last_name;

                            $attr = array( 'id' => 'pweditform'); 
                            echo form_open($this->uri->uri_string(),$attr); // form starts here
                            ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group ">
                                        <label for="">Full Name</label>
                                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                        <input type="text" class="form-control" name="name" value="<?php echo $fullname;?>" placeholder="Enter full name" >
                                        <div class="invalid-feedback"></div>
                                    </div>          
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Measurement Method</label>
                                        <select  class="form-control" id="pw_mmethod" name="pw_mmethod" data-toggle="select2">
                                            <option value="">Select Option</option><?php if($pw_mmethod == 'Guide'){ echo 'selected';} ?>
                                            <option value="Diagram" <?php if($pw_mmethod == 'Diagram'){ echo 'selected';} ?> >Diagram</option>
                                            <option value="Guide"<?php if($pw_mmethod == 'Guide'){ echo 'selected';} ?>>Guide</option>
                                            <option value="Field Measurement"<?php if($pw_mmethod == 'Field Measurement'){ echo 'selected';} ?>>Field Measurement</option>
                                            <option value="Pictures"<?php if($pw_mmethod == 'Pictures'){ echo 'selected';} ?>>Pictures</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">Status</label>
                                        <select  class="form-control" id="qf_status" name="qf_status" data-toggle="select2">
                                            <?php foreach ($int_lead_status as $int) { ?>
                                             <option value="<?php echo $int['id']; ?>" <?php if( $leads['qf_status'] == $int['id'] ){ echo  'selected="selected"'; } ?> ><?php echo $int['status']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="">N/S Owner</label>
                                        <select class="form-control" name="assigned_to" > 
                                            <option value="" id="0">Select option</option>
                                            <?php 
                                              foreach ($users as $us) {
                                             ?> 
                                            <option value="<?php echo $us['id']; ?>" <?php echo (($us['id']==$assigned_to)?"selected":""); ?> id="0">
                                                <?php echo $us['name']; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>



                            <div class="row">
                                <div class="col-12"> 
                                    <div class="form-group">
                                        <label for="position">Lead Status</label>
                                        <select class="form-control" id="lead_status" name="lead_status"  data-toggle="select2"> 
                                           <?php   foreach ($lead_statuss as $st) { ?> 
                                                <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id']; ?>"><?php echo $st['status']; ?></option>
                                            <?php  } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" id="lost_id" style="display:none" >
                                <div class="form-group ">
                                    <label for="">Lost Sale Reason</label>
                                    <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail" cols="50">
                                        <?php echo $leads['lost_sale_detail'];?>
                                    </textarea>
                                    <div class="invalid-feedback"></div>
                                </div>          
                            </div>

                            <div class="row">
                                  <div class="col-12">
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
                                <div class="col-12">
                                      <div class="form-group">
                                        <label for="">Last Action</label>
                                        <select  class="form-control" id="last_action" name="last_action"  data-toggle="select2" name="lastAction">
                                            <?php
                                            $lead_last_action = json_decode(lead_last_action);
                                            foreach ( $lead_last_action as $key => $value) {
                                                echo '<optgroup label="'.$key.'">';
                                                    foreach ($value as $ckey => $cValue) {
                                                      if ($leads['last_action'] == $cValue) {
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
                                        <textarea rows="8" name="note" class="form-control" cols="50"><?= $leads['note'] ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="position">Last Action Note</label>
                                        <textarea rows="8" name="last_action_note" class="form-control" cols="50"><?= $leads['last_action_note'];?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="window.location.href = '<?php echo base_url();?>crm/PWleads'">Cancel</button>
                            </div><?php echo form_close(); ?><!-- form close -->
                        </div>
                    </div>
                </div>
            </div><!-- end row -->
        </div> <!-- End Content-->
    </div>
</div>

    

        