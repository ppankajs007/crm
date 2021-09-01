<div class="container-fluid">  <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="<?php echo base_url();?>">CRM</a></li>
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
                <h4 class="page-title">Categories</h4>
            </div>
        </div>
    </div> <!-- end page title -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                  <div class="row mb-2">
                        <div class="col-sm-4">
                            <a href="<?php echo base_url();?>category/add" class="btn btn-danger waves-effect waves-light" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a" id="modal_disable"><i class="mdi mdi-plus-circle mr-1"></i> Add Category</a>
                        </div>
                        <div class="col-sm-8">
                            <div class="text-sm-right">
                            </div>
                        </div><!-- end col-->
                    </div>
                    <table id="scroll-vertical-datatable" class="table dt-responsive nowrap" id="DataTable">
					   <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Description</th>
                                <!--<th>Parent</th>-->
                                <th>Action</th>
                            </tr>
                         </thead>
                        <?php if( !empty($category) ) { foreach ( $category as $cate ) { ?>
                                <tr class="Mystyle">
                                    <td><?php echo  $cate['parent']->id; ?></td>
                                    <td><?php echo $cate['parent']->cat_name; ?></td>
                                    <td><?php echo $cate['parent']->cat_desc; ?></td>
                                    <!--<td><?php// echo $cate['parent']->cat_parent; ?></td>-->
                                    <td>
                                        <a href="<?php echo base_url();?>category/edit/<?php echo $cate['parent']->id; ?>" title="Edit" class="action-icon create-customer" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0);" id="deleteCat" title="Delete" class="action-icon" ids="<?php echo $cate['parent']->id; ?>"data-toggle="" data-placement="top" title="Delete Lead"> <i class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                 <?php 
                                    if ($cate['child']) { foreach ($cate['child'] as $cKey => $cValue) { ?>
                                <tr class="Mystyle">
                                    <td><?php echo  $cValue->id; ?></td>
                                    <td>- <?php echo $cValue->cat_name; ?></td>
                                    <td><?php echo $cValue->cat_desc; ?></td>
                                     <!--<td><?php //echo $cValue->cat_parent; ?></td>-->
                                    <td>
                                        <a href="<?php echo base_url();?>category/edit/<?php echo $cValue->id; ?>" class="action-icon create-customer" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0);" id="deleteUser" class="action-icon" ids="<?php echo $cValue->id; ?>"data-toggle="" data-placement="top" title="Delete Lead"> <i class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                <?php    }
                                    }
                                    
                                    if ($cate['subchild']) { foreach ($cate['subchild'] as $sKey => $sValue) { ?>
                                <tr class="Mystyle">
                                    <td><?php echo  $sValue->id; ?></td>
                                    <td>-- <?php echo $sValue->cat_name; ?></td>
                                    <td><?php echo $sValue->cat_desc; ?></td>
                                     <!--<td><?php //echo $cValue->cat_parent; ?></td>-->
                                    <td>
                                        <a href="<?php echo base_url();?>category/edit/<?php echo $sValue->id; ?>" class="action-icon create-customer" data-animation="fadein" data-plugin="custommodal" data-overlaycolor="#38414a"><i class="fas fa-edit"></i></a>
                                        <a href="javascript:void(0);" id="deleteUser" class="action-icon" ids="<?php echo $sValue->id; ?>"data-toggle="" data-placement="top" title="Delete Lead"> <i class="mdi mdi-delete"></i></a>
                                    </td>
                                </tr>
                                <?php    }
                                    }
                             }
                         }
                        ?>
                    </table>
                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->
</div> <!-- container -->
