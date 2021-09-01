<div class="modal-demo">
	<?php
	$to_sms = array(
		'name'	=> 'to_sms',
		'id'	=> 'to_sms',
		'size'	=> 30,
		'class'	=> 'form-control',
		'placeholder' => 'Enter To phone'
	);
	$sms = array(
		'name'	=> 'sms',
		'id'	=> 'sms',
		'class'	=> 'form-control',

	);
	?>
	<?php echo form_open($this->uri->uri_string()); ?>
	<button type="button" class="close" onclick="Custombox.modal.close();">
	    <span>&times;</span><span class="sr-only">Close</span>
	</button>
	<h4 class="custom-modal-title">Send SMS</h4>
	<div class="custom-modal-text text-left">
		<div class="form-group">
            <?php echo form_label('Phone', $to_sms['id']); ?>
            <input type="text" class="form-control" id="to_sms" name="to_sms" placeholder="Phone No">
        </div>
        <div class="form-group">
            <?php echo form_label('SMS', $sms['id']); ?>
            <textarea name="sms" class="form-control"></textarea>
        </div>
        <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Send</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
	</div>
	<?php echo form_close(); ?>
</div>