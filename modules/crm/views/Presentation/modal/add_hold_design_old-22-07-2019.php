<div class="modal-demo">
<?php $attributes = array('id' => 'form_task'); echo form_open($this->uri->uri_string(),$attributes); ?>
<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Add Hold On Desgin</h4>
            <div class="custom-modal-text text-left">
                
                 <div class="form-group">
                      <input type="hidden" name="id" value="<?php  if(!empty($hold->id)){echo  $hold->id;}?>">
                        <label for="first_name">Hold Reason</label>
                       <textarea name="hold_reason" class="form-control"><?php if(!empty($hold->hold_reason)){ echo  $hold->hold_reason;}?></textarea> 
                    </div>
                   
                   
                   <div class="form-group">
                        <label for="first_name">Hold Next Step Date (MM/DD/YYYY)</label>
                        <?php  
                                 if(!empty($hold->hold_next_step_date)){
                                     
                                      $new_date1 = strtotime($hold->hold_next_step_date);
                                    $qf_dateRecieved = date('m/d/Y', $new_date1);
                                 }else{
                                     
                                     $qf_dateRecieved="";
                                 }
                       ?>
                        <input type="text" class="form-control" id="hold_next_step_date" value="<?php  echo  $qf_dateRecieved;?>" name="hold_next_step_date" placeholder="Enter Hold Next Step Date">
                    </div>
                    <div class="form-group">
                        <label for="first_name">Hold Next Step</label>
                        <input type="text" class="form-control" id="hold_next_step" name="hold_next_step" value="<?php if(!empty($hold->hold_next_step)){ echo  $hold->hold_next_step;}?>" placeholder="Enter Hold Next Step" required>
                    </div>
                   
                    <div class="form-group">
                        <label for="task_desc">Hold Owner</label>
                       <input type="text" class="form-control" id="hold_owner" name="hold_owner" value="<?php if(!empty($hold->hold_owner)){ echo  $hold->hold_owner;}?>" placeholder="Enter Hold Owner Name" required>
                    </div>
                   
                    <?php $id = $this->uri->segment(4);?>
                     
                           <input type="hidden" name="lead_id" value="<?php echo $id;?>" class="form-control lead_id" id="lead_id">
                      <div class="searchlist form-group" style="overflow-y: auto;">
                      	<ul class="list-group"></ul>
                      </div>

                    <div class="text-right">
                        <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="save_" value="Save">
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                    </div>
            </div>
<?php echo form_close(); ?>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.jsdd"></script>

