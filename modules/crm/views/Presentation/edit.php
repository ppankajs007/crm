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

fieldset {
  min-width: unset;
  border: 1px solid #ededed;
  padding: 0 10px;
  margin: 4px 0;
  margin-bottom: 4px;
  background: #f8f8f8;
  margin-bottom: 20px;
}

fieldset legend {
  width: auto;
  font-size: 18px;
}

fieldset textarea {
  resize: none;
}
</style>
        
<div class="content-pageee">
    <div class="content"><!-- Start Content-->
        <div class="container-fluid"><!-- start page title -->
            <div class="row">
                <div class="col-md-12">        
                    <?php 
                         if( empty($leads) ) return;
                            extract($leads);
                          $fullname = @$first_name.' '.@$last_name;
                    ?>
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">CRM</a></li>
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>crm/Presentation">Presentation Leads</a></li>
                                 <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/Presentation/dashboard/<?php echo $id; ?>">Dashboard</a></li>
                                <li class="breadcrumb-item active">
                                <?php  if( empty($leads) ) return;
                                        extract($leads);
                                      $fullname = @$first_name.' '.@$last_name;
                                      echo ucfirst($first_name);
                                ?>
                                </li>
                            </ol>
                        </div><h4 class="page-title">Edit Presentation Lead(#<?php echo $id.' '.$first_name;?>)</h4>
                    </div>
                </div>
            </div>  
            <div class="row">
                <div class="col-md-12">   
                    <div class="card">
                        <div class="card-body">
                            <?php $attr = array( 'id' => 'QualifiedEform'); echo form_open($this->uri->uri_string(),$attr); ?>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group ">
                                            <label for="">Full Name</label>
                                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                                            <input type="text" class="form-control" name="name" value="<?php echo $fullname;?>" placeholder="Enter full name" >
                                            <div class="invalid-feedback"></div>
                                        </div>          
                                    </div>
                                     <div class="col-md-6">
                                        <div class="form-group">
                                            <a href="<?php echo base_url();?>crm/presentation/add_hold_desgin/<?php echo $id; ?>" class="action-icon create-customer task_b" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="hold_popup"><i class="fa fa-plus-square" aria-hidden="true" ></i></a>
                                            <label for="">Status</label> <a href="<?php echo base_url();?>crm/presentation/add_task/<?php echo $id; ?>" class="action-icon create-customer task_b" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="pstatus_popup"><i class="fa fa-plus-square" aria-hidden="true" ></i></a>
                                            <?php // $qfStatus = array('Need More Info to Start','Not Started','Started','Ready for Q/C','Revision Required','Approved for Deck','Completed','Hold On Design') ?>
                                            <select  class="form-control" id="qf_status" name="qf_status" data-toggle="select2">
                                                <?php foreach ( $int_lead_status as $int) { ?>
                                                <option class="" value="<?php echo $int['id']; ?>" <?php if( $leads['qf_status'] == $int['id'] ){ echo  'selected="selected"'; } ?> ids="<?php echo $int['id']; ?>" Lds="<?php echo $id; ?>"><?php echo $int['status']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Designer Assigned</label>
                                            <select  class="form-control" id="qf_designAssigned" name="qf_designAssigned" data-toggle="select2">
                                            <option>Select Designer Assigned</option>
                                            <?php  foreach ($users as $us) {  ?> 
                                                <option value="<?php echo $us['name'];?>" <?php echo (($us['name']==$leads['qf_designAssigned'])?"selected":""); ?> id="0"><?php  echo $us['name'];?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php if($leads['qf_dateRecieved'] != ''){
                                                $qf_dateRecieved = crm_date($leads['qf_dateRecieved']);
                                            }else{ $qf_dateRecieved = ""; } ?>
                                          <label for="">Date Received</label>
                                        <input type="text" class="form-control" name="qf_dateRecieved" value="<?php  echo $qf_dateRecieved; ?>" id="dateMasksnd" placeholder="mm-dd-yyyy" readonly >
                                        </div>
                                    </div>
                                    <div class="col-md-6">     
                                       <div class="form-group">
                                            <label for="">Date Added</label>
                                            <?php if($leads['qf_dateAdded'] != '') {
                                                $qf_dateAdded = crm_date($leads['qf_dateAdded']);
                                            } else {
                                            $qf_dateAdded= "N/A";  } ?>
                                            <input type="text" class="form-control" value="<?php echo  $qf_dateAdded; ?>" name="qf_dateAdded"  id="qf_dateAdded" readonly >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                      <div class="form-group">
                                            <label for="">Date Started</label>
                                             <?php if($leads['qf_datestarted'] != ''){
                                                $qf_datestarted = crm_date($leads['qf_datestarted']);
                                            } else { $qf_datestarted= "N/A"; } ?>
                                          <input type="text" class="form-control" name="qf_datestarted " value="<?php echo $qf_datestarted; ?>" id="qf_datestarted" readonly >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                          <?php if($leads['qf_dateCompleted'] != ''){
                                                $qf_dateCompleted = crm_date($leads['qf_dateCompleted']); 
                                           }else { $qf_dateCompleted= "N/A";  } ?>
                                            <label for="">Date Completed </label>
                                            <input type="text" class="form-control" name="qf_dateCompleted" value="<?php  echo $qf_dateCompleted; ?>" id="qf_dateCompleted" readonly  >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Date Sent</label>
                                            <?php if($leads['qf_dateSent'] != ''){  $qf_dateSent = crm_date($leads['qf_dateSent']); 
                                            }else { $qf_dateSent= "N/A"; } ?>
                                            <input type="text" class="form-control" name="qf_dateSent" value="<?php echo $qf_dateSent; ?>" id="qf_dateSent" readonly >
                                        </div> 
                                    </div><!-- other fileds start  -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kit File 1</label>
                                            <input type="text" class="form-control" name="qf_Kit_File_1" value="<?php if( !empty( $KitFilesF[0]['file_name'] ) ){ echo base_url().'assets/'.$KitFilesF[0]["file_name"];   } ?>" id="qf_Kit_File_1" readonly >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Kit File 2</label>
                                            <input type="text" class="form-control" name="qf_Kit_File_2" value="<?php if( !empty( $KitFilesF[1]['file_name'] ) ){ echo base_url().'assets/'.$KitFilesF[1]["file_name"];   } ?>" id="qf_Kit_File_2" >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Panoramic D1</label>
                                            <input type="text" class="form-control" name="qf_Panoramic_D1" value="<?php if( !empty( $leads['qf_Panoramic_D1'] ) ){ echo $leads['qf_Panoramic_D1'];  }?>" id="qf_Panoramic_D1" >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Panoramic D2</label>
                                            <input type="text" class="form-control" name="qf_Panoramic_D2" value="<?php if( !empty( $leads['qf_Panoramic_D2'] ) ){ echo $leads['qf_Panoramic_D2'];  }?>" id="qf_Panoramic_D2" >
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Deck</label>
                                            <input type="text" class="form-control" name="qf_Deck" value="<?php if( !empty( $leads['qf_Deck'] ) ){ echo $leads['qf_Deck'];  } ?>" id="qf_Deck">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <?php if($leads['qf_LIVE_PRESENTATION_DATE'] != ''){
                                             $qf_live = crm_date($leads['qf_LIVE_PRESENTATION_DATE']);
                                            } else { $qf_live= "N/A"; } ?>
                                            <label for="">LIVE PRESENTATION DATE</label>
                                            <input type="text" class="form-control" name="qf_LIVE_PRESENTATION_DATE" value="<?php if( !empty( $leads['qf_LIVE_PRESENTATION_DATE'] ) ){ echo $qf_live;  }?>" id="dateMaskfst" placeholder="mm-dd-yyyy" readonly>
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">LIVE PRESENTATION TIME</label>
                                            <input type="text" class="form-control" name="qf_LIVE_PRESENTATION_TIME" value="<?php if( !empty( $leads['qf_LIVE_PRESENTATION_TIME'] ) ){ echo $leads['qf_LIVE_PRESENTATION_TIME'];  }?>" id="qf_LIVE_PRESENTATION_TIME">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Qualifying Promotions</label>
                                            <input type="text" class="form-control" name="qf_Qualifying_Promotions" value="<?php if( !empty( $leads['qf_Qualifying_Promotions'] ) ){ echo $leads['qf_Qualifying_Promotions'];  }?>" id="qf_Qualifying_Promotions">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Notes for Nicarter</label>
                                            <input type="text" class="form-control" name="qf_Notes_for_Nicarter" value="<?php if( !empty( $leads['qf_Notes_for_Nicarter'] ) ){ echo $leads['qf_Notes_for_Nicarter'];  }?>" id="qf_Notes_for_Nicarter">
                                        </div> 
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Lead Status</label>
                                            <select  class="form-control" id="lead_status" name="lead_status" data-toggle="select2">
                                                <?php foreach ($lead_statuss as $st) { ?> 
                                                <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="lost_id" style="display:none" >
                                        <div class="form-group ">
                                            <label for="">lost sale Reason</label>
                                            <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail"   cols="50"><?php echo $leads['lost_sale_detail'];?></textarea>
                                            <div class="invalid-feedback"></div>
                                        </div>          
                                    </div> <!-- other fileds end  -->
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
                                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="window.location.href = '<?php echo base_url();?>crm/Presentation'">Cancel</button>
                                    </div><?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- end .content-pageee -->
        