<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title"><?=lang('delete_permission')?></h4>
		</div><?php
			echo form_open(base_url().'permission/delete'); ?>
		<div class="modal-body">
			<p><?=lang('delete_user_warning')?></p>
			<input type="hidden" name="id" value="<?=$id?>">
			<input type="hidden" name="r_url" value="<?=base_url()?><?=$redirect?>">
		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
