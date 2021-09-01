<div class="modal-demo">
<?php $attributes = array('id' => 'form_task'); echo form_open($this->uri->uri_string(),$attributes); ?>
<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Add Task</h4>
            <div class="custom-modal-text text-left">
                <div class="after-add-more">
                     <fieldset>
                        <legend><span class="task_no">Task 1</span></legend>
                    <div class="form-group">
                        <label for="first_name">Task Name</label>
                         <?php $id = $this->uri->segment(4);?>
                         <input type="hidden" name="task[main0][lead_id]" value="<?php echo $id;?>" class="form-control lead_id" id="lead_id">
                        <input type="text" class="form-control" id="task_title" name="task[main0][task_title]" placeholder="Enter Task Name">
                    </div>
                   
                    <div class="form-group">
                        <label for="task_desc">Task Description</label>
                       <textarea id="task_desc" name="task[main0][task_desc]" class="form-control"></textarea> 
                  
                    </div>
                    <div class="form-group">
                        <label for="task_desc">Deadline Date(MM-DD-YYYY)</label>
                       <input type="text" class="form-control datePick" id="deadline_date" name="task[main0][deadline_date]" placeholder="Enter Deadline Date">
                  
                    </div>
                    
                     <div class="form-group">
                        <label for="task_desc">Assign Team</label>
                    <select class="form-control" name="task[main0][assigned_team]" value=""> 
                         <option value="" id="0">Select option</option>
                        	<?php 
                        	
                        
                 foreach ($lead_statuss as $us)
                        {
                       ?> 
                        <option value="<?php echo $us['code_value'];?>" <?php echo (($us['id']=='')?"selected":""); ?> id="0"><?php echo $us['code_value'];?></option>
                        <?php }?>
                        </select> 
                  
                    </div>
                     </fieldset>
                </div>
                 <div class="form-group">
                   <div class="form-control boder change">
               <label for=""></label>
              <a class="add-more">+ Add More</a>
                     </div>
                  </div>
                <div class="searchlist form-group" style="overflow-y: auto;">
                      	<ul class="list-group"></ul>
                      </div>

                    <div class="text-right">
                        <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="save_" value="Save">
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                    </div>
                    </div>
            </div>
            </div>
<?php echo form_close(); ?>

<script src="<?php echo base_url();?>assets/libs/flatpickr/flatpickr.min.js"></script>
<script>
jQuery(document).ready(function(){
   
    $("#deadline_date").flatpickr({ 
        dateFormat:'m-d-Y'
    });
});
</script>

</div>




 

