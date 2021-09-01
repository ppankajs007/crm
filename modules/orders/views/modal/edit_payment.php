<div class="modal-demo" style="width: 800px !important">
   <button type="button" class="close" onclick="Custombox.modal.close();">
   <span>&times;</span><span class="sr-only">Close</span>
   </button>
   <h4 class="custom-modal-title">Add Payment</h4>
   <div class="custom-modal-text text-left">
      <?php $attr = array( 'id' => 'add_file');echo form_open_multipart('',$attr); ?>
      <div class="row">
         <div class="col-md-12">
            <div class="form-group">
               <div class="form-group">
               <label for="name">Payment Type</label>
               <select class="form-control" name="payment_method">
                  <option value="">Select Payment Type</option>
                  <option value="cash" <?php if( $payment_data['payment_method'] == 'cash' ) echo 'selected';  ?> >Cash</option>
                  <option value="cheque" <?php if( $payment_data['payment_method'] == 'cheque' ) echo 'selected';  ?> >Cheque</option>
                  <option value="credit/debit" <?php if( $payment_data['payment_method'] == 'credit/debit' ) echo 'selected';  ?> > Credit/Debit</option>
                  <option value="e-Check" <?php if( $payment_data['payment_method'] == 'e-Check' ) echo 'selected';  ?> > e-Check</option>
               </select>
            </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <label for="name">Payment Amount</label>
               <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">$</div>
                    </div>
                    <input type="text" name="payment_amount" id="payment_amount" class="form-control" value="<?= $payment_data['payment_amount'] ?>">
                </div>
            </div>
         </div>
         <div class="col-md-12">
            <div class="form-group">
               <label for="name">Payment Reference Number</label>
               <input type="text" name="reference_no" id="reference_no" value="<?= $payment_data['reference_no'] ?>" class="form-control">
            </div>
         </div>
         <div class="col-md-12">
            <div class="text-right">
               <input type="hidden" name="order_id" value="<?= $payment_data['order_id'] ?>">
               <input type="hidden" name="id" value="<?= $payment_data['id'] ?>">
               <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
               <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
            </div>
         </div>
       </div>
      <?php echo form_close(); ?>
      
   </div>
</div>
<style type="text/css">.error{ color:red;}</style>