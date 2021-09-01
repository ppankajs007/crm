<div class="modal-demo">
<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
<?php // print_r($leads);
             if( empty($leads) ) return;
                extract($leads);
               $name1= @$first_name.' '.@$last_name;  


               ?>
            <h4 class="custom-modal-title">Edit</h4>
            <div class="custom-modal-text text-left">
                <?php $attr = array( 'id' => 'quick_edit'); echo form_open($this->uri->uri_string(),$attr); ?>

               
                        <div class="form-group">
                   <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                        <label for="position">Next Step</label>
                       <select class="form-control" name="action_lead" value="<?php echo $action_lead;?>" data-toggle="select2"> 
                       
                          <option value="Select option" <?php if(empty($action_lead) ){ echo "selected"; } ?> id="0">Select option</option>
                         <!-- <option value="<?php echo $action_lead;?>"><?php echo $action_lead;?></option> -->
                         
                           <option value="Task" <?php if($action_lead=='Task'){ echo "selected"; } ?> >Task</option>
                                   <option value="Appointment" <?php if($action_lead=='Appointment') { echo "selected"; } ?> >Appointment</option>
                              <optgroup label="You">
                                  <option value="You Called" <?php if($action_lead=='You Called') { echo "selected"; } ?> >You Called</option>
                                   <option value="You Emailed" <?php if($action_lead=='You Emailed') { echo "selected"; } ?> >You Emailed</option>
                                   <option value="You Left Voicemail" <?php if($action_lead=='You Left Voicemail') { echo "selected"; } ?> >You Left Voicemail</option>
                                   <option value="You Fixed" <?php if($action_lead=='You Fixed') { echo "selected"; } ?> >You Fixed</option>
                                   <option value="You Create Layout" <?php if($action_lead=='You Create Layout') { echo "selected"; } ?> >You Create Layout</option>
                                   <option value="You Create Pricing" <?php if($action_lead=='You Create Pricing') { echo "selected"; } ?> >You Create Pricing</option>
                                    <option value="You Survey" <?php if($action_lead=='You Survey') { echo "selected"; } ?> >You Survey</option>
                                     </optgroup>
                                        <optgroup label="Customer">
                                    <option value="Customer Called" <?php if($action_lead=='Customer Called') { echo "selected"; } ?> >Customer Called</option>
                                  <option value="Customer Emailed" <?php if($action_lead=='Customer Emailed') { echo "selected"; } ?> >Customer Emailed</option>
                              <option value="Customer Left Voicemail" <?php if($action_lead=='Customer Left Voicemail') { echo "selected"; } ?> >Customer Left Voicemail</option>
                           <option value="Customer Faxed" <?php if($action_lead=='Customer Faxed') { echo "selected"; } ?> >Customer Faxed</option>
                           <option value="Customer Visited" <?php if($action_lead=='Customer Visited') { echo "selected"; } ?> >Customer Visited</option>
                           <option value="Customer submitted layout" <?php if($action_lead=='Customer submitted layout') { echo "selected"; } ?> >Customer submitted layout</option>
                      </optgroup>
                        </select>
                    </div>
                 

                     <div class="form-group">

                       <?php                       
                                              if(!empty($reminder_date)){

                                                      $datetime = $reminder_date;
                                                        $rem = date("m-d-Y", strtotime($datetime));

                                                        }else{

                                                          $rem="NA";
                                                        }
                                                     

                                                        ?>
                                        <label>Next step Date (MM-DD-YYYY)</label>
                                       <input type="text" id="basic-datepicker" name="reminder_date" value="<?php echo $rem;?>"class="form-control" placeholder="Next step Date">
                                    </div>

                     <div class="form-group">
                        <label for="position">Assigned To</label>
                        <select class="form-control" name="assigned_to" value=""> 
                           <option value="Select option" id="0">Select option</option>
                            <?php 
                 foreach ($users as $us)
                        {
                       ?> 
                        <option value="<?php echo $us['id'];?>" <?php echo (($us['id']==$assigned_to)?"selected":""); ?> id="0"><?php echo $us['name'];?></option>
                        <?php }?>
                        </select>
                    </div>

                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                    </div>
                </form>
            </div>
<?php echo form_close(); ?>
</div>
<style type="text/css">.error{ color:red;}</style>
           