<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Edit Permission<?=lang('edit_permission')?></h4>
		</div><?php
			 $attributes = array('class' => 'bs-example form-horizontal');
          echo form_open(base_url().'permission/module/update',$attributes); ?>
         
			<input type="hidden" value="<?=$permission_id?>" name="id">
		
		<div class="modal-body">
			 
			 <div class="form-group">
				<label class="col-lg-4 control-label">Name<?=lang('name')?> </label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?=$permission_data[0]->name?>" name="name" required>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-4 control-label"><?=lang('description')?> </label>
				<div class="col-lg-8">
					<input type="text" class="form-control" value="<?=$permission_data[0]->description?>" name="description" required>
				</div>
			</div>
			
				
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a> 
		<button type="submit" class="btn btn-primary"><?=lang('save_changes')?></button>
		</form>
		
		</div>
	</div>
	<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
