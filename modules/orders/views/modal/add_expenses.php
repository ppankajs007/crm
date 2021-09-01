<div class="modal-demo" style="width: 800px !important">
   <button type="button" class="close" onclick="Custombox.modal.close();">
   <span>&times;</span><span class="sr-only">Close</span>
   </button>
   <h4 class="custom-modal-title">Add Expenses</h4>
   <div class="custom-modal-text text-left">
      <?php $attr = array( 'id' => 'add_file');echo form_open_multipart('',$attr); ?>
      <div class="row">
         <div class="col-md-6">
            <div class="form-group">
               <label for="name">Payee</label>
               <input type="text" name="payee" class="form-control">
            </div>
         </div>
         <div class="col-md-6">
            <div class="form-group">
               <label for="name">Payment Date</label>
               <input type="text" name="payee_date" id="payee_date" class="form-control">
            </div>
         </div>
        <div class="col-md-6">
            <div class="form-group">
               <label for="name">Reference No</label>
               <input type="text" name="reference_no" id="reference_no" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
             <div class="form-group">
               <label for="name">Payment Method</label>
               <select class="form-control" name="payment_method">
                  <option value="">Select Payment Method</option>
                  <option value="cash">Cash</option>
                  <option value="cheque">Cheque</option>
                  <option value="credit_card">Credit card</option>
               </select>
            </div>
       </div>
       </div>
      <div class="row">
         <div class="col-md-12">
            <table class="table table-bordered">
               <thead>
                  <tr>
                     <td>#</td>
                     <td>Category</td>
                     <td>Description</td>
                     <td>Total</td>
                     <td></td>
                  </tr>
               </thead>
               <tbody class="appendExp">
                  <tr class="after-add-more">
                     <td>1</td>
                     <td>
                        <select class="form-control" name="exp_cat[main0][cat]">
                           <option>What tax category fits?</option>
                           <?php 
                              if ( !empty( $exp_cat ) ) {
                                  foreach ($exp_cat as $key => $value) { ?>
                           <option value="<?= $value->id; ?>" >
                              <?= $value->catogery_title; ?>
                           </option>
                           <?php   }        
                              }
                              ?> 
                        </select>
                     </td>
                     <td><input type="text" name="exp_cat[main0][description]" class="form-control"></td>
                     <td><input type="text" name="exp_cat[main0][amount]" class="form-control expensesprice"></td>
                     <td><i class="mdi mdi-delete delete_cat"></i></td>
                  </tr>
               </tbody>
            </table>
         </div>
         <div class="col-md-6">
            <a href="javascript:;" class="add-more" data-animation="fadein" data-plugin="" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i>Add More</a>
         </div>
         <div class="col-md-6" >
            <div class="float-right total-hidden">
               <h3>Total :<span class="total"></span></h3>
               <input type="hidden" name="totalExpenses" class="totalexp" value="" readonly>
            </div>
         </div>
      </div>
      <div class="form-group">
         <div class="row">
            <div class="text-left col-md-12 form-group">
               <label>Memo</label>
               <textarea name="memo" rows="5" class="form-control"></textarea>
            </div>
         </div>
         <div class="form-group">
            <div class="custom-file">
               <input type="file" class="custom-file-input" id="image_upload" name="image_upload[]" aria-describedby="inputGroupFileAddon01" multiple >
               <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
         </div>
         <div class="text-right">
            <input type="hidden" name="order_id" value="<?php echo $this->uri->segment(3); ?>">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Save</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
         </div>
         <?php echo form_close(); ?>
      </div>
   </div>
   <table style="height: 0px; visibility: hidden;" class="addMoreRow">
      <tr class="appendRow">
         <td>1</td>
         <td>
            <select class="form-control" name="exp_cat[main0][cat]">
               <option>What tax category fits?</option>
               <?php foreach ($exp_cat as $key => $value) { ?>
               <option value="<?= $value->id; ?>"> <?= $value->catogery_title; ?> </option>
               <?php } ?> 
            </select>
         </td>
         <td><input type="text" name="exp_cat[main0][description]" class="form-control"></td>
         <td><input type="text" name="exp_cat[main0][amount]" class="form-control expensesprice"></td>
         <td><i class="mdi mdi-delete delete_cat"></i></td>
      </tr>
   </table>
</div>
<style type="text/css">.error{ color:red;}</style>