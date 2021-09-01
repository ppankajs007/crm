<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header"> <button type="button" class="close" data-dismiss="modal">&times;</button> 
		<h4 class="modal-title">Remove User</h4>
		</div><?php
			$attributes = array('id' => 'remove_user' );	
			echo form_open(base_url().'permission/access/delete_user',$attributes); ?>
		<div class="modal-body">
			<p>This action will remove user from this project. Proceed?</p>

			<input type="hidden" name="workspace_id" value="<?=$workspace_id?>">
			<input type="hidden" name="project_id" value="<?=$project_id?>">
			<input type="hidden" name="access_id" value="<?=$access_id?>">

		</div>
		<div class="modal-footer"> <a href="#" class="btn btn-default" data-dismiss="modal"><?=lang('close')?></a>
			<button type="submit" class="btn btn-danger jq_remove_user"><?=lang('delete_button')?></button>
		</form>
	</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->


<script src="<?= base_url() ?>new/js/validation/jquery.validate.js"></script>
<script src="<?= base_url() ?>new/js/validation/additional-methods.js"></script>
<script type="text/javascript">
<?php /**
Validations for add group form ( users/views/modal/modal_add_deparment )
**/ ?>


$("#remove_user").validate({
  errorClass:'validate_error',

    submitHandler: function(form) 
    {
    	$('.jq_remove_user').prop('disabled', true);
    	form.submit();
  	}
});
</script>