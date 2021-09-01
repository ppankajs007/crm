<style type="text/css">
.overview_list {
    padding: 0;
    margin: 0;
    border-bottom: 1px solid #ccc;
    float: left;
    width: 100%;
}
.overview_list li {
    float: left;
    margin-bottom: 9px;
    list-style: none;
}
.overview_list li a {
    margin-right: 2px;
    line-height: 1.42857143;
    border: 1px solid transparent;
    border-radius: 2px 2px 0 0;
    color: #428bca;
    padding: 10px 8px;
}    
.overview_list li.active a {
    border-bottom: 2px solid #566676;
    border-radius: 0px;
}
.clear {
    clear: both;
}
.box_outer label {
    color: #979797;
    font-size: 85%;
    margin-bottom: 0;
}
.box_outer h4 {
    color: #2c96dd;
    font-size: 11px;
    margin-top: 1px;
}

.box_outer h5 {
    color: #666;
    font-size: 18px;
}
.box_outer {
    text-align: center;
    border-right: 1px solid #E7E7E7;
    padding: 5px 0;
    margin-bottom: 16px;
    margin-top: 29px;
}
.additional_list {
    border: 1px solid #e8e8e8;
    padding: 0px 0;
    border-radius: 3px;
    margin-top: 23px;
}
.additional_list .panel-heading {
    background: #f5f5f5;
    padding: 10px;
    color: #000;
    font-size: 13px;
}
.list-group.no-radius .pull-right {
    float: right;
}
.additional_list ul li {
    border-left: none;
    border-radius: ;
    border-right: none;
}
.information_outer {
    float: left;
    width: 100%;
    height: 1px;
    width: 100%;
    background: #ddd;
}
.add_file {
    float: right;
    font-size: 17px;
    margin: 4px 12px;
    margin-top: 0px;
}
</style>

<div class="container-fluid">                       
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/PWleads">Paperwork Pending</a></li>
                        <li class="breadcrumb-item"><a href=" <?php echo base_url()."crm/PWleads/dashboard/".$this->uri->segment(4); ?>">Dashboard</a></li>
                        <li class="breadcrumb-item active">Files</li>
                    </ol>
                </div>
                <?php  
                    $id=$this->uri->segment(4);
                    $lead= App::get_by_where('leads', array('id'=>$id) );
                ?>
                <h4 class="page-title">Paperwork Pending (#<?php echo $id.' ' .$lead[0]->first_name.' '.$lead[0]->last_name;?>)</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                        <ul class="overview_list" id="lead_sub_menu">
                          <?php  echo modules::run('includes/PWleads_sub_menu');?>
                        </ul>
                    <div class="clear"></div>
                    <div class="row total_list">
                        <div class="col-md-12">
                            <div class="additional_list">
                                <header class="panel-heading">Files <a href="<?php echo base_url()."crm/PWleads/add_file/".$this->uri->segment(4); ?>" class="add_file waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add File</a></header>
                                 

                                <table id="DataTable scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
                        <thead>
                            <tr>
                                 <th>#</th>
                                <th>File</th>
                                <th>File Name</th>
                                <th>Deck One</th>
                                <th>Deck Two</th>
                                <th>Deck Three</th>
                                <th>Description</th>
                                <th>File Type</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            //print_r( $file_data );
                                if(!empty( $file_data ) ){
                                    foreach ($file_data as $value) { 
                                    $ext = pathinfo($value['file_name'], PATHINFO_EXTENSION);
                                if( $ext == 'pdf'  ){
                                    $imgLink ='download.png';
                                }else if($ext == 'xls' || $ext == 'xlsx' ){
                                    $imgLink ='Xls-01-512.png';
                                }
                                else if($ext == 'pptx'){
                                    $imgLink ='ppt.png';
                                }else if($ext == 'csv'){
                                    $imgLink ='csv.png';
                                }else if($ext == 'mp4' || $ext == 'mp3'){
                                    $imgLink ='video.jpg';
                                } 
                                else{
                                   $imgLink = $value['file_name'];
                                } 
                                $fileLink = $value['file_name'];
                                        ?>

                           <tr class="Mystyle<?php echo  $value['file_id'] ?>">
                                <td><?php echo $value['file_id']; ?></td>
                                <td><a target="_blank" href="<?php echo  base_url('assets/leadsfiles/'.$fileLink);?>" > <img src="<?php echo  base_url('assets/leadsfiles/'.$imgLink);?>"width="100" height="100" ></a></td>
                                <!-- <td><?php// echo $value['module_name']; ?></td> -->
                                <td><?php echo $value['title']; ?></td>
                                 <td><?= $value['deck_one']; ?></td>
                                <td><?= $value['deck_two']; ?></td>
                                <td><?= $value['deck_three']; ?></td>
                                <td><?php echo $value['description']; ?></td>
                                <td><?php echo $value['lead_file_type']; ?></td>
                                <td><?php echo date('m-d-Y',strtotime($value['created'])); ?></td>
                                
                                <td>
                                    <a href="javascript:void(0);" id="deleteleadfile" class="action-icon" ids="<?php echo $value['file_id']; ?>" 
                                    leads_id="<?php echo $this->uri->segment(4); ?>"> <i class="mdi mdi-delete"></i></a>
                                </td>
                            </tr>
                                        
                                <?php }
                                }else{?>
                                    <tr><td colspan="10" align="center">No record found</td></tr>
                                        <?php } ?> 
                                      </tbody>
                                </table>  

                           </div>  
                        </div>
                    </div>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
</div> <!-- container -->