

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
   border: 2px solid #e8e8e8;
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
   .clear { clear:both; }  
   .sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
   .sms_out { float: right;     background-color: #1abc9c; color: #fff;}
   .smst { padding: 4px 8px; border-radius: 4px;clear: both; margin:10px; }
   .smst span{ margin-left:0px; }
   .btn-success {/*display: block; width: 100%;*/}
   .timeline:before {
   background-color: #dee2e6;
   bottom: 0;
   content: "";
   left: 50%;
   position: absolute;
   top: 30px;
   width: 2px;
   z-index: 0;
   display:none;
   }
   .timeline {
   margin-bottom: 8px;
   position: relative;
   padding: 10px 10px 0;
   }
   .add_file{
   float: right;
   }
   .additional_list.activ .slimscroll {
   max-height:409px !important
   }
   .additional_list.messenger .chatbox.slimscroll {
   height: 322px !important;
   }
   .comment-list {
   position: relative;
   }
   .comment-list:before {
   position: absolute;
   top: 0;
   bottom: 35px;
   left: 18px;
   width: 1px;
   background: #e0e4e8;
   content: '';
   }
   .comment-list .comment-item {
   margin-top: 18px;
   position: relative;
   }
   .text-info {
   color: #4cc0c1;
   }
   .comment-list .comment-item .comment-body {
   margin-left: 46px;
   }
   .comment-list article span.fa-stack {
   float: left;
   }
   .comment-list .comment-item:last-child {
   margin-bottom: 16px;
   }
   .custom-file{
   padding: 10px;
   }
   .customInput {
       margin:10px;
   }
   .customInput img{
        border: 1px solid #ccc;
    }
    .customInput li{
        list-style:none;
        margin-bottom:10px;
    }
    .deleteIMG {
        font-size: 20px;
        line-height: 4;
        cursor:pointer;
    }
    .customInput li:hover .deleteIMG{
        color:#ff0000;
    }
</style>
<div class="container-fluid">
   <div class="row">
      <div class="col-12">
         <div class="page-title-box">
            <div class="page-title-right">
               <ol class="breadcrumb m-0">
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>orders">Orders</a></li>
                  <li class="breadcrumb-item active">File</li>
               </ol>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-12">
         <div class="card">
            <div class="card-body">
               <ul class="overview_list" id="">
                  <?php  echo modules::run('includes/order_sub_menu');?>
               </ul>
               <div class="clear"></div>
                  <?= form_open_multipart(); ?>
               <div class="row">
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">Floor plan</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "floor_plan", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != 'floor_plan' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/floor_plan__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/floor_plan__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[floor_plan][]" value="<?= 'floor_plan__'.$florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                          <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[floor_plan]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">3D Views</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "3d_views", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != '3d_views' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/3d_views__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/3d_views__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[3d_views][]" value="<?= '3d_views__'.$florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[3d_views]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">Walk Through Form</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "walk_through_form", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != 'walk_through_form' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/walk_through_form__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/walk_through_form__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[walk_through_form][]" value="<?= 'walk_through_form__'.$florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[walk_through_form]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">Signed Contracts</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "signed_contracts", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != 'signed_contracts' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/signed_contracts__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/signed_contracts__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[signed_contracts][]" value="<?= 'signed_contracts__'.$florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[signed_contracts]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">ST3 Form</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "st3_form", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != 'st3_form' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/st3_form__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/st3_form__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[st3_form][]" value="<?= 'st3_form__'.$florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[st3_form]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">ST8 Form</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "st8_form", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != 'st8_form' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/st8_form__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/st8_form__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[st8_form][]" value="<?= 'st8_form__'.$florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[st8_form]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="additional_list activ">
                        <header class="panel-heading">Receipts</header>
                        <div class='customInput'>
                           <ul class="list-group no-radius">
                              <?php 
                                 $i = 0;
                                 foreach($file_data as $key => $value ){
                                    
                                 $expImg =  explode( ',',$value['file_name']);
                                     
                                     foreach($expImg as $keys => $values ){
                                         
                                         $againexp = explode( '__',$values);
                                         
                                         if ( in_array( "receipts", $againexp ) ) {
                                             
                                             foreach( $againexp as $florValue ){
                                                 if( $florValue != 'receipts' ){ ?>
                              <li class="list-group-image">
                                 <span class="pull-right text"><i class="mdi mdi-delete deleteIMG" ></i></span>
                                 <span class="text-muted">
                                 <a href="<?= base_url() .'assets/leadsfiles/receipts__'.$florValue ?>">
                                 <img target="_blank" src="<?= base_url() .'assets/leadsfiles/receipts__'.$florValue ?>" width="100px" height="100px" >
                                 </a>
                                 <input type="hidden" id="img_<?= $i; ?>" name="upload[receipts][]" value="receipts__<?= $florValue ?>">
                                 </span>
                              </li>
                              <?php $i++;       }
                                             }
                                          } 
                                                                         
                                    }
                                 
                                 } ?>
                           </ul>
                           <div class="custom-file">
                              <input type="file" class="custom-file-input" id="image_upload" name="files[receipts]" aria-describedby="inputGroupFileAddon01">
                              <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-12">
                     <div class="form-group">
                        <div class="text-right">
                           <input type="submit" class="btn btn-success waves-effect waves-light" value="Save" id="save_" name="submit_product">
                        </div>
                     </div>
                  </div>
               </div>
               <?= form_close(); ?> 
            </div>
         </div>
      </div>
   </div>
</div>