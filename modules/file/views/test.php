 <div class=row>
      <?php $attr = array( 'id' => 'edit_form2'); echo form_open($this->uri->uri_string(),$attr); ?>
                    <div class="col-6">
                    <div class="form-group">
                        <label for="position">Main Phone</label>
                        <input type="text" class="form-control phone" name="phone" value=""  id="phone" placeholder="Enter phone number">
                    </div>
                </div>
                <div class="col-6">
                     <div class="form-group">
                        <label for="position">Second Phone</label>

                        <input type="text" class="form-control" name="second_phone" value="" id="position" placeholder="Enter Second number">
                    </div>
                </div>
            </div>
            <div class="text-right">
            <button type="submit" class="btn btn-success waves-effect waves-light" id="save_">Update</button>
            <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
        </div>
                  </form>