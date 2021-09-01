<div class="modal-demo">
<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
               <?php $attributes = array('id' => 'form_task'); echo form_open($this->uri->uri_string(),$attributes); ?>
             <?php 
            if( empty($task) ) return;
               ?>
            <h4 class="custom-modal-title">Edit Task</h4>
            <div class="custom-modal-text text-left">
               
                 
                    <div class="form-group">
                        <label for="name">Task Name</label>
                        <input type="hidden" id="id" name="task_id" value='<?php echo $task['id'];?>'>
                        <input type="text" class="form-control" id="task_title"  name="task_title" value='<?php echo $task['task_title'];?>'   placeholder="Enter Task name">
                    </div>
                   <div class="form-group">
                        <label for="department_desc">Task Description</label>
                       <textarea name="task_desc" class="form-control"><?php echo $task['task_desc'];?></textarea> 
                    </div>
                    
                     <div class="form-group">
                        <label for="task_desc">Assign Team</label>
                    <select class="form-control" name="assigned_team"> 
                         <option>Select option</option>
                        	<?php 
                        	 foreach ($lead_statuss as $us)
                        {
                       ?>
                       <option value="<?php echo $us['code_value'];?>"<?php echo (($us['code_value']==$task['assigned_team'])?"selected":""); ?>><?php echo $us['code_value'];?></option>
                        <?php }?>
                        </select> 
                    </div>
                    <div class="form-group">
                        <label for="name">Status</label>
                         <select class="form-control" name="status"  id ="cobdition_set"> 
                         <option value="" id="0">Select Option</option>
                         
                           <!--<option value="completed" id="0">completed</option>-->
                            <option value="Pending" <?php echo (($task['status']=='Pending')?"selected":""); ?> id="">Pending</option>
                             <option value="completed" <?php echo (($task['status']=='completed')?"selected":""); ?> id="0">completed</option>
                             <?php  $id=$this->session->userdata('user_id');
                               $uid= $task['created_by'];
                                
                                if($id != $uid){?>
                                
                                    <option disabled value="close" <?php echo (($task['status']=='close')?"selected":""); ?> ids="<?php echo $id;?>" uid="<?php echo $task['created_by'];?> ">close</option> 
                              <?php  }else{?>
                             
                             <option value="close" <?php echo (($task['status']=='close')?"selected":""); ?> ids="<?php echo $id;?>" uid="<?php echo $task['created_by'];?> ">close</option>
                             
                  <?php }?>
                        </select>
                    </div>
                    <div class="form-group" >
                        <!--<label for="position">Associate Lead</label>-->
                        <?php $leads=App::get_row_by_where('leads', array('id'=>$task['lead_id']) ); 
                       ?>
                       
                      </div>
                           <input type="hidden" name="lead_id" value="<?php echo $task['lead_id'];?>" class="form-control lead_id" id="lead_id">
                      <div class="searchlist form-group" style="overflow-y: auto;">
                      	<ul class="list-group"></ul>
                      </div>
                    <div class="text-right">
                        <input type="submit" name="save_" class="btn btn-success waves-effect waves-light" id="save_" value="Update">
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                    </div>
                </form>
            </div>
</div>


