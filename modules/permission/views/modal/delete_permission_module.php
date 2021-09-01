<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Delete Permission<?=lang('delete_permission')?></h4>
		</div><?php
			echo form_open(base_url().'permission/module/delete'); ?>
		<div class="modal-body">
			<p><?=lang('delete_user_warning')?></p>
			
			<input type="hidden" name="id" value="<?=$id?>">
			<?php
			$company = $this->user_profile->get_profile_details($user_id,'company');
			if ($company >= 1) {
				$redirect = 'companies/view/details/'.$company;
			}else{
				$redirect = 'users/account';				
			}
			?>
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
