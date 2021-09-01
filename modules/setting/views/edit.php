<style>

.tag {
    background: #8067b7;
    padding: 3px 7px 4px;
    border-radius: 2px;
    color: #fff;
    font-weight: 700;
    margin: 5px 5px 0 0;
    display: inline-block;
    font-size: 18px;
}

.small, small {
    font-size: 85%;
}

.shortTag {
    padding: 9px;
}

.invoiceEmail label {
    font-size: 19px;
}

</style>
        
<div class="container-fluid">   <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                       <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active"><a href="<?php echo base_url().'setting/email_template';?>">Email</a></li>
                        <li class="breadcrumb-item active">Email Update</li>
                    </ol>
                </div>
                <h4 class="page-title">Email Template</h4>
            </div>
        </div>
    </div>   <!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="invoiceEmail" >
                        <?php echo form_open($this->uri->uri_string()); ?>    
                        <div class="form-group" >
                            <label for="subjectEmail">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subjectEmail" value="<?php echo $emailData['subject'] ?>" >
                        </div>
                        <div class="form-group" >
                            <label for="subjectEmail">Email Body</label>
                            <textarea id="noteEditor" name="emailBody" class="form-control" rows="25"><?php echo $emailData['msg'] ?></textarea>
                        </div>
                        <div class="form-group" >
                            <div class="shortTag form-group">
                                <label for="Tag">Tags</label>
                                <small style="padding-left:10px">
                                    <br>
                                    <?php $tags = explode( ',' , $emailData['tags']  ); 
                                    foreach ($tags as $value) { ?>
                                    <span class="tag"><?php echo $value ?></span>     
                                    <?php  }
                                    ?>
                                </small>
                            </div>
                        </div>
                        <div class="form-group" >
                             <input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="emailID" >
                             <input type="submit" class="btn btn-success waves-effect waves-light" value="Save">
                        </div><?php echo form_close() ?>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div><!-- end row-->
</div> <!-- container -->
