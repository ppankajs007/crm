<div class="modal-demo">
<button type="button" class="close" onclick="Custombox.modal.close();">
                <span>&times;</span><span class="sr-only">Close</span>
            </button>
             <?php 
             if( empty($leads) ) return;;
               ?>
            <h4 class="custom-modal-title">Edit Lead</h4>
            <div class="custom-modal-text text-left">
                <form>
                    <div class="form-group">
                        <label for="name">First Name</label>
                        <input type="text" class="form-control" id="firstname"   placeholder="Enter full name">
                    </div>
                     <div class="form-group">
                        <label for="name">Last Name</label>
                        <input type="text" class="form-control" id="lastname"   placeholder="Enter full name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="position">Main Phone</label>
                        <input type="text" class="form-control" id="position" placeholder="Enter phone number">
                    </div>
                  
                    
                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
                    </div>
                </form>
            </div>
</div>


