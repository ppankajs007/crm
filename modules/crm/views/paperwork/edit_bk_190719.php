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
                    <div class="container-fluid">
                        
                        <!-- start page title -->
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
                                            <?php     if( empty($leads) ) return;
                                                    extract($leads);
                                                $fullname= @$first_name.' '.@$last_name;
                                                echo  ucfirst($fullname);
                                                ?></li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Paperwork Pending(#<?php echo $id.' '.$first_name;?>)</h4>
                                </div>
                            </div>
                        </div>  
                          <div class="row">
                            <div class="col-12">   
                                 <div class="card">
                                  <div class="card-body">

        <?php   if( empty($leads) ) return;
                extract($leads);
              $fullname= @$first_name.' '.@$last_name;  
         ?>
         
        <?php $attr = array( 'id' => 'pweditform'); echo form_open($this->uri->uri_string(),$attr); ?>
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
                    <?php foreach( $int_lead_status as $int){ ?>
                     <option value="<?php echo $int['id']; ?>" <?php if( $leads['qf_status'] == $int['id'] ){ echo  'selected="selected"'; } ?> ><?php echo $int['status']; ?></option>
                    <?php } ?>
                </select>
             </div>
           </div>
      </div>
        
          <div class="row">
            <div class="col-12">
             <div class="form-group">
                <label for="">Next Step</label>
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
           </div>
         </div> 
        <div class="row">
            <div class="col-12">
                <?php
                if(!empty($reminder_date)){
                    $rem =  crm_date($reminder_date);
                }else{
                   $rem="";    
                }
                ?>
                <div class="form-group">
                  <label for="">Next Step Date</label>
                  <input type="text" class="form-control" name="reminder_date" value="<?php echo $rem;?>" placeholder="mm-dd-yyyy" id="dateMasksnd" readonly >
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
                          foreach ($users as $us)
                        {
                         ?> 
                                <option value="<?php echo $us['id'];?>" <?php echo (($us['id']==$assigned_to)?"selected":""); ?> id="0"><?php echo $us['name'];?></option>
                                <?php }?>
                                </select>
                    </div>
              </div>
         </div> 
         <div class="row">
              <div class="col-12"> 
                   <div class="form-group">
                        <label for="position">Lead Status</label>
                         <select class="form-control" id="lead_status" name="lead_status"  data-toggle="select2"> 
                        <!--<option value="Select option" id="0">Select option</option>-->
                       <?php   foreach ($lead_statuss as $st) { ?> 
                            <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                        <?php  } ?>
                  </select>
             </div>
        </div>
      </div>
      <div class="col-md-12" id="lost_id" style="display:none" >
            <div class="form-group ">
                <label for="">Lost Sale Reason</label>
                
                <!--<input type="text" class="form-control" id="lost" name="lost_sale_detail" value="<?php echo $leads['lost_sale_detail']; ?> " placeholder="Enter lost sale" >-->
                 <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail"   cols="50"><?php echo $leads['lost_sale_detail'];?></textarea>
                <div class="invalid-feedback"></div>
            </div>          
          </div>
                                 
          <div class="text-right">
              <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
              <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
          </div>
         
              <?php echo form_close(); ?>
          

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
      
</div>
</div>
    

        