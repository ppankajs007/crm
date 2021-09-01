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
        
<div class="container-fluid">    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Email</li>
                    </ol>
                </div>
                <h4 class="page-title">Email Template</h4>
            </div>
        </div>
    </div><!-- end page title --> 
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="" class="table" style="width:100%">
                       <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Subject</th>
                                <th>Message</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                            <tbody><?php 
                                    if(!empty($emailFetch) ){
                                        foreach ($emailFetch as $key =>$value) { ?>
                                        <tr>
                                            <td><?php echo $value['id']; ?></td>
                                            <td><?php echo $value['type']; ?></td>
                                            <td><?php echo $value['subject']; ?></td>
                                            <td><?php $pos=strpos($value['msg'], ' ', 20);
                                                echo strip_tags(substr($value['msg'],0,$pos )); ?></td>
                                            <td><a href="<?php echo base_url().'setting/email_template/edit/'.$value['id'] ?>" title="Edit Email" class="action-icon" data-animation="" data-plugin="" data-overlaycolor="#38414a"><i class="mdi mdi-square-edit-outline"></i></a></td>
                                        </tr>
                                <?php } } ?>
                            </tbody>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div><!-- end row-->
</div> <!-- container -->
