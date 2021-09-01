<div class="modal-demo">
    <button type="button" class="close" onclick="Custombox.modal.close();">
    <span>&times;</span><span class="sr-only">Close</span>
    </button>
    <h4 class="custom-modal-title">Add New Customers</h4>
    <div class="custom-modal-text text-left">
        <form>
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" placeholder="Enter full name">
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
            </div>
            <div class="form-group">
                <label for="position">Phone</label>
                <input type="text" class="form-control" id="position" placeholder="Enter phone number">
            </div>
            <div class="form-group">
                <label for="position">Password</label>
                <input type="password" class="form-control" id="position" placeholder="Enter password">
            </div>
            <div class="form-group">
                <label for="example-select">Input Select</label>
                <select class="form-control" id="example-select">
                    <option value="1">Brand Ambassador</option>
                    <option value="2">Designer</option>
                    <option value="3">Customer Service</option>
                    <option value="4">Executive</option>
                </select>
            </div>
            <div class="text-right">
                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.close();">Cancel</button>
            </div>
        </form>
    </div>
</div>
