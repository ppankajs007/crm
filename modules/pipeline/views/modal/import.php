<div class="modal-demo">
<style>
.downloadh5 h5 a {
    color: #6c757d !important;
}
</style>
    <button type="button" class="close" onclick="Custombox.modal.close();">
        <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Import file</h4>
    <div class="custom-modal-text text-left">
        <?php  echo form_open_multipart() ?>
            <div class="form-group">
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="file_upload" name="file_upload" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                 </div>
            </div>
            <div class="form-group">
                <div class="custom-file downloadh5">
                    <h5 style="float: right;"><a href="<?= base_url(); ?>assets/productOrderfile/orderImport.xlsx" style="color: #6e768e; margin-top:10px;display:block;">Download Sample</a></h5>
                </div>
            </div>
            <div class="text-right">
                <button type="button" class="btn btn-success waves-effect waves-light" id="importcustpro">save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
            </div>
        <?php echo form_close(); ?>          
    </div>
</div>