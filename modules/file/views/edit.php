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
                <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">UBold</a></li>
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                                            <li class="breadcrumb-item active">Advanced</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Edit Lead</h4>
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


               ?>
         
              <!--   <form method="post" action="<?php// echo base_url();?><?php// echo base_url();?>index.php/crm/leads/edit_leads/<?php //echo $id;?>"> -->
                    <?php $attr = array( 'id' => 'edit_form'); echo form_open_multipart($this->uri->uri_string(),$attr); ?>
                     <div class=row>
                    <div class="col-6">
                    <div class="form-group ">
                        <label for="name">Full Name</label>
                         <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                        <input type="text" class="form-control" name="first_name" value="<?php echo $name1;?>" placeholder="Enter full name" requried>
                        <div class="invalid-feedback"></div>
                    </div>
                     
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" name="email" value="<?php echo $email;?>" id="exampleInputEmail1" placeholder="Enter email" readonly>
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
            <div class="row">
              <div class="col-6">
             <div class="form-group">
                        <label for="position">Contact Preprence</label>
                        <input type="text" class="form-control" name="contact_preprence" value="<?php echo $contact_preprence;?>" id="position" placeholder="Enter Contact Preprence ">
                    </div>
                  </div>
                   <div class="col-6">
                    <div class="form-group">
                       <label for="position">Survey</label>
                        <input type="text" class="form-control" name="survey" value="<?php echo $survey;?>"  id="position" placeholder="Enter Survey">
                    </div>
                  </div></div>
                 
                    <div class="form-group">
                        <label for="position">Comments</label>
                        <textarea rows="2" name="comments" class="form-control" cols="50"> <?php echo $comments;?></textarea>
                    </div>
               
                     <div class=row>
                    <div class="col-6">
                     <div class="form-group">
                        <label for="position">Assigned To</label>
                        <select class="form-control" name="assigned_to" value="<?php echo $assigned_to;?>"> 
                        	<?php 
                 foreach ($users as $us)
                        {
                       ?> 
                        <option value="<?php echo $us['id'];?>" <?php echo (($us['name']==0)?"selected":""); ?> id="0"><?php echo $us['name'];?></option>
                        <?php }?>
                        </select>
                    </div>
                </div>
                 <div class="col-6">
            
                 
                    <div class="form-group">
                        <label for="position">Status</label>
                       <select class="form-control" name="lead_status"  data-toggle="select2"> 
                         <?php 
                 foreach ($lead_statuss as $st)
                        {
                        	
                       ?> 
                    <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> id="0"><?php echo $st['status'];?></option>
                        
                        <?php }?>

                        </select>

  </div>
                </div>
            </div>

        

   <div class="form-group">

                        <label for="position">Lost Sale Detail</label>
                      <!-- <input type="text" class="form-control" id="position" placeholder="Lost Sale Detail"> -->
                      <textarea rows="2" class="form-control" name="lost_sale_detail"   cols="50"><?php echo $lost_sale_detail;?></textarea>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                       <div class="form-group inline">
                           <label for="position">Hoteness</label>
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
              <label class="radio-inline">
             <input name="hoteness" type="radio" id="signi" value="6" <?php echo ($hoteness== '6') ?  "checked" : "" ;  ?>/> 6<br>
              </label>

                </div>
              </div>



                <div class="col-md-6">
                     
                <!-- <div class="form-group">
                        <label for="position">Point</label>
                        <input type="text" class="form-control" id="position" placeholder="Enter Survey">
                    </div> -->
              </div>
            </div>
            <div class="row">
               <div class="col-md-6">
                 <div class="form-group">
                                        <label>Reminder date</label>
                                       <input type="text" id="basic-datepicker" name="reminder_date" value="<?php echo $reminder_date;?>"  class="form-control" placeholder="Date and Time">
                                    </div>
                                  </div>
                                  <!-- <input type="text" id="basic-datepicker" class="form-control" placeholder="Basic datepicker"> -->
                           <div class="col-md-6">
                    <div class="form-group">

                        <label for="position">Action</label>
                       <select class="form-control" name="action_lead" value="<?php echo $action_lead;?>" data-toggle="select2"> 
                          <option value="<?php echo $action_lead;?>"><?php echo $action_lead;?></option>
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
               <!--  <div class="row">
                     <div class="col-md-4">
                     <div class="form-group">
                         <label for="position">Appointment task</label>
                       <input type="text" class="form-control">
                   </div>
               </div>
                <div class="col-md-2">
                <div class="form-group">
                     <label for="position"></label>
                       <select class="form-control"> 
                        <option value="American">00;00</option>  
                        
                        </select>
                    </div>
                </div>
                    <div class="col-md-2">
                    <div class="form-group">
                         <label for="position"></label>
                        <select class="form-control"> 
                        <option  value="American">00:00</option>  
                       
                        </select>

                    </div>
                    </div>
                
                <div class="col-md-4">
                <div class="form-group">
                         <label for="position">Miltary Time</label>
                          <input type="text" class="form-control">
                    </div>
                    <label for="position">Mints</label>
                </div>
            </div> -->
           <div class="row">
             <div class="col-md-6">
        <div class="form-group">
          <div class="custom-file">
            <span class="input-group-text" id="image_upload"></span>
            <input type="file" class="custom-file-input" id="image_upload" name="image_upload"
              aria-describedby="image_upload">
            <label class="custom-file-label" for="image_upload">Choose file</label>
             </div>
            <!--   <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div> -->
             </div>
              </div>
         <!--      <div class="col-md-6">
               <div class="form-group">
          <div class="custom-file">
            <input type="file" class="custom-file-input" id="inputGroupFile01"
              aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
             </div>
        <!--       <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
          </div> -->
             <!-- </div> -->
         <!-- </div> --> 
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

        