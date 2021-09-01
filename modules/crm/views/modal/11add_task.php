<div class="modal-demo">
<?php $attributes = array('id' => 'form_task'); echo form_open($this->uri->uri_string(),$attributes); ?>
<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="custom-modal-title">Add Task</h4>
            <div class="custom-modal-text text-left">
                    <div class="form-group">
                        <label for="first_name">Task Name</label>
                        <input type="text" class="form-control" id="task_title" name="task_title" placeholder="Enter Task Name">
                    </div>
                   
                    <div class="form-group">
                        <label for="task_desc">Task Description</label>
                       <textarea name="task_desc" class="form-control"></textarea> 
                    </div>
                    <div class="form-group">
                        <label for="assigned_to">Assign Task</label>
                       <select class="form-control" name="assigned_to" value=""> 
                         <option value="" id="0">Select option</option>
                        	<?php 
                        	
                        
                 foreach ($users as $us)
                        {
                       ?> 
                        <option value="<?php echo $us['name'];?>" <?php echo (($us['id']=='')?"selected":""); ?> id="0"><?php echo $us['name'];?></option>
                        <?php }?>
                        </select>
                    </div>
                    
                      <div class="form-group" >
                        <label for="position">Associate Lead</label>
                        <input type="text" name="searchLead" value="" class="form-control searchLead" id="searchLead" autocomplete="off">
                      </div>
                           <input type="hidden" name="lead_id" value="" class="form-control lead_id" id="lead_id">
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

