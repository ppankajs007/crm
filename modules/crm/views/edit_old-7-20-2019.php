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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/leads">Leads</a></li>
                                            <!--<li class="breadcrumb-item"><a href="<?php// echo base_url();?>crm/leads/dashboard/<?php// echo $id; ?>">Dashboard</a></li>-->
                                             <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/leads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Edit Lead</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Leads</h4>
                                </div>
                            </div>
                        </div>  
                          <div class="row">
                            <div class="col-12">   
                                 <div class="card">
                                  <div class="card-body">

  <?php 
 
             if( empty($leads) ) return;;
                extract($leads);
               $name1= @$first_name.' '.@$last_name; 
               $na= trim($name1);


               ?>
         
              <!--   <form method="post" action="<?php// echo base_url();?><?php// echo base_url();?>index.php/crm/leads/edit_leads/<?php //echo $id;?>"> -->
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
                <div class="col-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email;?>" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                </div></div>
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

                        <input type="text" class="form-control" name="second_phone" value="<?php echo $second_phone;?>" id="position" placeholder="Enter Second number">
                    </div>
                </div>
            </div>
            <!-- <div class="row"> -->
              
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
                        	<?php 
                      
                 foreach ($users as $us)
                        {
                            
                          
                       ?> 
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

                         <?php 
                 foreach ($lead_statuss as $st)
                        {
                            
                            if($st['id']== 11){
                                
                                
                            }else{?>
                        	
                       
                       
                    <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                        
                        <?php }}?>

                        </select>

                 </div>
                </div>
            </div>


    <div class="col-md-12" id="lost_id" style="display:none" >
            <div class="form-group ">
                <label for="">Lost Sale Reason</label>
                
                <!--<input type="text" class="form-control" id="lost" name="lost_sale_detail" value="<?php// echo $leads['lost_sale_detail']; ?> " placeholder="Enter lost sale" >-->
                 <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail"   cols="50"><?php echo $lost_sale_detail;?></textarea>
                <div class="invalid-feedback"></div>
            </div>          
          </div>
                    <div class="row">
                      <div class="col-md-6">
                       <div class="form-group inline">
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



                <div class="col-md-6">
                     
               
              </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                 <div class="form-group">
                                        <label>Reminder date</label>
                                <input type="text" id="dateMasksnd" name="reminder_date" value="<?php echo crm_date($reminder_date); ?>" placeholder="mm-dd-yyyy" class="form-control" > 
                                    </div>
                                  </div>
                                  <!-- <input type="text" id="basic-datepicker" class="form-control" placeholder="Basic datepicker"> -->
                           <div class="col-md-6">
                    <div class="form-group">

                        <label for="position">Action</label>
                       <select class="form-control" name="action_lead" value="<?php echo $action_lead;?>" data-toggle="select2"> 
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
             <div class="col-md-6">
     
             </div>
              </div>
                <div class="form-group">
                  <label for="position">Note</label>
                    <textarea rows="8" name="note" class="form-control" cols="50"><?php echo $note;?></textarea>
                </div>

        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
                  </form>
              </div>
              <?php echo form_close(); ?>
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

        