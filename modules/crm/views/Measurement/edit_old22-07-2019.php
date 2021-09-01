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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>">CRM</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>crm/MRLeads">Measurement Leads</a></li>
                                             <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/MRLeads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Edit</li>
                                            <li class="breadcrumb-item active">
                                            <?php     if( empty($leads) ) return;
                                                    extract($leads);
                                                echo  ucfirst($first_name);
                                                
                                                ?></li>
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
  //print_r($leads);
 
            //  if( empty($leads) ) return;
            //     extract($leads);
            
              $fullname= @$first_name.' '.@$last_name;  


               ?>
         
        <?php $attr = array( 'id' => 'mreditform'); echo form_open($this->uri->uri_string(),$attr); ?>
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
        
            <div class="col-6">
             <div class="form-group">
                <label for="">Survey Sent</label>
                <input type="text" class="form-control" name="mr_surveysent" value="<?php echo $mr_surveysent; ?>" id="mr_surveysent" >
             </div>
            </div>
         </div> 
         <div class="row">
            <div class="col-6">
             <div class="form-group">
                <label for="">Survey Complete</label>
                <input type="text" class="form-control" name="mr_surveycompleted" value="<?php echo $mr_surveycompleted; ?>" id="mr_surveycompleted" >
             </div>  
           </div>
        
            <div class="col-6">
             <div class="form-group">
                <label for="">Days pending Completion</label>
                <input type="text" class="form-control" name="mr_dpcompletion" value="<?php echo $mr_dpcompletion; ?>" id="mr_dpcompletion" >
             </div>  
           </div>
         </div> 
          <div class="row">
              <div class="col-6"> 
                <div class="form-group">
                        <label for="position">Lead Status</label>
                         <select class="form-control" id="lead_status" name="lead_status"  data-toggle="select2"> 
                        <!--<option value="Select option" id="0">Select option</option>-->
                       <?php  foreach ($lead_statuss as $st) {  ?> 
                            <option value="<?php echo $st['id'];?>" <?php echo (($st['id']==$lead_status)?"selected":""); ?> ids="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                        <?php  } ?>
                  </select>
                </div>
             </div>
             <div class="col-md-12" id="lost_id" style="display:none" >
            <div class="form-group ">
                <label for="">lost sale Reason</label>
                
                <!--<input type="text" class="form-control" id="lost" name="lost_sale_detail" value="<?php echo $leads['lost_sale_detail']; ?> " placeholder="Enter lost sale" >-->
                 <textarea rows="2" class="form-control" id="lost" name="lost_sale_detail"   cols="50"><?php echo $leads['lost_sale_detail'];?></textarea>
                <div class="invalid-feedback"></div>
            </div>          
          </div>
        </div>
       
              <div class="text-right">
                  <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
                  <a href="<?php echo base_url();?>crm/MRLeads" class="btn btn-danger waves-effect waves-light m-l-10" ><i class=""></i>Cancel</a>
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

        