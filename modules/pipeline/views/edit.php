  <style>
    .error {
    display: none;
    width: 100%;
    margin-top: .25rem;
    font-size: .75rem;
    color: #f1556c;
    display: block;
}
  </style>
        
    <div class="content-pageee">
        <div class="content"><!-- Start Content-->
            <div class="container-fluid"><!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                   <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                                    <li class="breadcrumb-item"><a href="<?php echo base_url();?>customer">Customers</a></li>
                                    <li class="breadcrumb-item"><a href=" <?php echo base_url()."customer/dashboard/".$this->uri->segment(3); ?>">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Edit</li>
                                </ol>
                            </div><h4 class="page-title">Customers</h4>
                        </div>
                    </div>
                </div>  
                <div class="row">
                    <div class="col-12">   
                        <div class="card">
                           <div class="card-body">
                                <?php  if( empty($customer) ) return;  extract($customer);  ?>
                                <?php $attr = array( 'id' => 'edit_form'); echo form_open($this->uri->uri_string(),$attr); ?>
                                <div class=row>
                                    <div class="col-6">
                                        <div class="form-group ">
                                            <label for="name">Full Name</label>
                                            <input type="hidden" id="id" name="id" value="<?php echo $id;?>">
                                            <input type="text" class="form-control" name="full_name" value="<?php echo $full_name;?>" placeholder="Enter full name" requried>
                                            <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Email address</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $email;?>" id="exampleInputEmail1" placeholder="Enter email" readonly>
                                        </div>
                                    </div>
                                 </div>
                                <div class=row>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="position">Phone</label>
                                            <input type="text" class="form-control phone" name="phone" value="<?php echo $phone;?>"  id="phone" placeholder="Enter phone number">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="position">Gender</label>
                                            <input type="text" class="form-control phone" name="gender" value="<?php echo $gender;?>"  id="phone" placeholder="Enter phone Gender">
                                        </div>
                                    </div>
                                </div>
                                <div class=row>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="position">Fax</label>
                                            <input type="text" class="form-control" name="fax" value="<?php echo $fax;?>" id="position" placeholder="Enter Fax">
                                        </div>
                                    </div>
                                </div>
                                <div class=row>
                                    <div class="col-12">
                                        <div class="form-group">
                                                <label for="position">Note</label>
                                            <textarea rows="8" name="comment" class="form-control" cols="50"><?php echo $comment;?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
                                    <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                                </div></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     