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
   /*  border-radius: ;*/
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
 .space {
     padding: 22px !important;
}
.form-group.check_box_outer label input {
    margin-top: 0;
    position: relative;
    top: 2px;
}
.form-group.check_box_outer label {
    margin: 0 14px 0 0px;
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
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/Qualified">Qualified Leads</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>crm/Qualified/dashboard/<?php echo $pw_pending[0]['lead_id']; ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active">Kitchen Details</li>
                    </ol>
                </div>  <?php $lead= App::get_by_where('leads', array('id'=>$pw_pending[0]['lead_id']) );?>
                        <h4 class="page-title">Qualified Leads(#<?php echo $pw_pending[0]['lead_id']. ' '.$lead[0]->first_name;?>)</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                     <ul class="overview_list" id="lead_sub_menu">
                        <?php  echo modules::run('includes/Qualified_sub_menu');?>
                        </ul>
                            <?php $attr = array( 'id' => 'edit_form'); echo form_open($this->uri->uri_string(),$attr); ?>
                    <div class="space"></div>
                    
                    <h5 class="page-title">Product Information</h5>            
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Cabinet Manufacturer</label>
                                <input type="hidden" id="id" name="lead_id" value="<?php if(isset($pw_pending[0]['lead_id'])){ echo $pw_pending[0]['lead_id'];}?>">
                                <select class="form-control" name="cabinet_manufacturer"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Forevermark"<?php  if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'Forevermark'){ echo 'selected';} }?>>Forevermark</option>
                                    <option value="CNC Cabinetry"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'CNC Cabinetry'){ echo 'selected';}} ?>>CNC Cabinetry</option>
                                    <option value="J&K Cabinetry"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'J&K Cabinetry'){ echo 'selected';}} ?>>J&K Cabinetry</option>
                                    <option value="Wolf"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'Wolf'){ echo 'selected';}} ?>>Wolf</option>
                                    <option value="Hanssem"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'Hanssem'){ echo 'selected';}} ?>>Hanssem</option>
                                    <option value="WoodMaster"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'WoodMaster'){ echo 'selected';}} ?>>WoodMaster</option>
                                    <option value="Legacy Crafted"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'Legacy Crafted'){ echo 'selected';}} ?>>Legacy Crafted</option>
                                    <option value="Holiday Kitchens"<?php if (isset($pw_pending[0]['cabinet_manufacturer'])){ if($pw_pending[0]['cabinet_manufacturer'] == 'Holiday Kitchens'){ echo 'selected';}} ?>>Holiday Kitchens</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Door Style</label>
                                <input type="text" class="form-control" name="door_style" value="<?php if(isset($pw_pending[0]['door_style'])){ echo $pw_pending[0]['door_style'];}?>" id="" placeholder="Enter Door Style" >
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group">
                            <label for="position">Desired Flooring Type</label>
                            <input type="text" class="form-control phone" name="desired_flooring_type" value="<?php if(isset($pw_pending[0]['door_style'])){ echo $pw_pending[0]['desired_flooring_type'];}?>"  id="phone" placeholder="Enter Desired Flooring Type">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Desired Flooring Color</label>
                                <input type="text" class="form-control" name="desired_flooring_color" value="<?php if(isset($pw_pending[0]['door_style'])){ echo $pw_pending[0]['desired_flooring_color'];}?>" id="position" placeholder="Enter Desired Flooring Color">
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Backsplash</label>
                                <input type="text" class="form-control" name="backsplash" value="<?php if(isset($pw_pending[0]['door_style'])){ echo $pw_pending[0]['backsplash'];}?>" id="position" placeholder="Enter Backsplash ">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Countertop Type</label>
                                <select class="form-control" name="countertop_type"  data-toggle="select2">
                                    <option value="">Select Option</option>

                                    <option value="Quartz"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Quartz'){ echo 'selected';}} ?>>Quartz</option>
                                    <option value="Granite"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Granite'){ echo 'selected';} }?>>Granite</option>
                                    <option value="Soapstone"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Soapstone'){ echo 'selected';}} ?>>Soapstone</option>
                                    <option value="Marble"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Marble'){ echo 'selected';}} ?>>Marble</option>
                                    <option value="Travertine"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Travertine'){ echo 'selected';}} ?>>Travertine</option>
                                    <option value="Formica"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Formica'){ echo 'selected';}} ?>>Formica</option>
                                    <option value="Unsure"<?php if(isset($pw_pending[0]['countertop_type'])){ if($pw_pending[0]['countertop_type'] == 'Unsure'){ echo 'selected';}} ?>>Unsure</option>
                                </select> 
                            </div>
                        </div>
                    </div>
               
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Countertop Color</label>
                                <input type="text" class="form-control" name="countertop_color" value="<?php if(isset($pw_pending[0]['countertop_color'])){ echo $pw_pending[0]['countertop_color'];}?>" id="position" placeholder="Enter Countertop Color">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="position">Knobs and Handles</label>
                                <input type="text" class="form-control" name="knobs_and_handles" value="<?php if(isset($pw_pending[0]['knobs_and_handles'])){ echo $pw_pending[0]['knobs_and_handles'];}?>" id="position" placeholder="Enter Knobs and Handles">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="position">Sink Type</label>
                                <select class="form-control" name="sink_type"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Undermount Stainless Steel"<?php if(isset($pw_pending[0]['sink_type'])){ if($pw_pending[0]['sink_type'] == 'Undermount Stainless Steel'){ echo 'selected';}} ?>>Undermount Stainless Steel</option>
                                    <option value="Undermount Quartz"<?php if(isset($pw_pending[0]['sink_type'])){ if($pw_pending[0]['sink_type'] == 'Undermount Quartz'){ echo 'selected';}} ?>>Undermount Quartz</option>
                                    <option value="Stainless Steel Apron Front"<?php if(isset($pw_pending[0]['sink_type'])){ if($pw_pending[0]['sink_type'] == 'Stainless Steel Apron Front'){ echo 'selected';}} ?>>Stainless Steel Apron Front</option>
                                    <option value="Farmhouse"<?php if(isset($pw_pending[0]['sink_type'])){ if($pw_pending[0]['sink_type'] == 'Farmhouse'){ echo 'selected';}} ?>>Farmhouse</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group inline">
                                <label for="position">Sink Color</label>
                                <select class="form-control" name="sink_color"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Stainless Steel"<?php if(isset($pw_pending[0]['sink_color'])){ if($pw_pending[0]['sink_color'] == 'Stainless Steel'){ echo 'selected';} }?>>Stainless Steel</option>
                                    <option value="White"<?php if(isset($pw_pending[0]['sink_color'])){ if($pw_pending[0]['sink_color'] == 'White'){ echo 'selected';}} ?>>White</option>
                                    <option value="Black"<?php if(isset($pw_pending[0]['sink_color'])){ if($pw_pending[0]['sink_color'] == 'Black'){ echo 'selected';}} ?>>Black</option>
                                    <option value="Grey"<?php if(isset($pw_pending[0]['sink_color'])){ if($pw_pending[0]['sink_color'] == 'Grey'){ echo 'selected';}} ?>>Grey</option>
                                </select> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Sink Bowls</label>
                                <select class="form-control" name="sink_bowls"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="One Bowl"<?php if(isset($pw_pending[0]['sink_bowls'])){ if($pw_pending[0]['sink_bowls'] == 'One Bowl'){ echo 'selected';}} ?>>One Bowl</option>
                                    <option value="Two Bowls"<?php if(isset($pw_pending[0]['sink_bowls'])){ if($pw_pending[0]['sink_bowls'] == 'Two Bowls'){ echo 'selected';}} ?>>Two Bowls</option>
                                </select> 
                            </div>
                        </div>
                    </div>
            
                    <h5 class="page-title">Appliance Dimensions and Selection</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Keeping Existing</label>
                                <select class="form-control" name="keeping_existing"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Yes"<?php if(isset($pw_pending[0]['keeping_existing'])){ if($pw_pending[0]['keeping_existing'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['keeping_existing'])){ if($pw_pending[0]['keeping_existing'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Some"<?php if(isset($pw_pending[0]['keeping_existing'])){ if($pw_pending[0]['keeping_existing'] == 'Some'){ echo 'selected';}} ?>>Some</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="position">Dishwasher Size</label>
                                <select class="form-control" name="dishwasher_size"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="24"<?php if(isset($pw_pending[0]['dishwasher_size'])){ if($pw_pending[0]['dishwasher_size'] == '24'){ echo 'selected';}} ?>>24</option>
                                    <option value="18"<?php if(isset($pw_pending[0]['dishwasher_size'])){ if($pw_pending[0]['dishwasher_size'] == '18'){ echo 'selected';}} ?>>18</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Desired Dishwasher Color</label>
                                <select class="form-control" name="desired_dishwasher_color"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="Stainless Steel"<?php if(isset($pw_pending[0]['desired_dishwasher_color'])){  if($pw_pending[0]['desired_dishwasher_color'] == 'Stainless Steelt'){ echo 'selected';}} ?>>Stainless Steel</option>
                                    <option value="White"<?php if(isset($pw_pending[0]['desired_dishwasher_color'])){ if($pw_pending[0]['desired_dishwasher_color'] == 'White'){ echo 'selected';}}?>>White</option>
                                    <option value="JBlack"<?php if(isset($pw_pending[0]['desired_dishwasher_color'])){ if($pw_pending[0]['desired_dishwasher_color'] == 'Black'){ echo 'selected';}} ?>>Black</option>
                                    <option value="Matching Front"<?php if(isset($pw_pending[0]['desired_dishwasher_color'])){ if($pw_pending[0]['desired_dishwasher_color'] == 'Matching Front'){ echo 'selected';}} ?>>Matching Front</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Dishwasher Quantity</label>
                                <select class="form-control" name="dishwasher_quantity"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="0"<?php if(isset($pw_pending[0]['dishwasher_quantity'])){ if($pw_pending[0]['dishwasher_quantity'] == '0'){ echo 'selected';}} ?>>0</option>
                                    <option value="1"<?php if(isset($pw_pending[0]['dishwasher_quantity'])){ if($pw_pending[0]['dishwasher_quantity'] == '1'){ echo 'selected';}} ?>>1</option>
                                    <option value="2"<?php if(isset($pw_pending[0]['dishwasher_quantity'])){ if($pw_pending[0]['dishwasher_quantity'] == '2'){ echo 'selected';}} ?>>2</option>
                                </select> 
                            </div>
                        </div>
                    </div>



                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Range Size</label>
                                <select class="form-control" name="range_size"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['range_size'])){ if($pw_pending[0]['range_size'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="30"<?php if(isset($pw_pending[0]['range_size'])){ if($pw_pending[0]['range_size'] == '30'){ echo 'selected';}} ?>>30</option>
                                    <option value="36"<?php if(isset($pw_pending[0]['range_size'])){  if($pw_pending[0]['range_size'] == '36'){ echo 'selected';}} ?>>36</option>
                                    <option value="48"<?php if(isset($pw_pending[0]['range_size'])){ if($pw_pending[0]['range_size'] == '48'){ echo 'selected';}} ?>>48</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cooktop Size</label>
                                <select class="form-control" name="cooktop_size_p"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="24"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '24'){ echo 'selected';}} ?>>24</option>
                                    <option value="30"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '30'){ echo 'selected';} }?>>30</option>
                                    <option value="36"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '36'){ echo 'selected';}} ?>>36</option>
                                    <option value="40"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '40'){ echo 'selected';} }?>>40</option>
                                    <option value="42"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '42'){ echo 'selected';} }?>>42</option>
                                    <option value="45"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '45'){ echo 'selected';}} ?>>45</option>
                                    <option value="48"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '48'){ echo 'selected';}} ?>>48</option>
                                    <option value="60"<?php if(isset($pw_pending[0]['cooktop_size_p'])){ if($pw_pending[0]['cooktop_size_p'] == '60'){ echo 'selected';}} ?>>60</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Wall Oven Count</label>
                                <select class="form-control" name="wall_oven_count"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['wall_oven_count'])){ if($pw_pending[0]['wall_oven_count'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="Single Wall Oven"<?php if(isset($pw_pending[0]['wall_oven_count'])){ if($pw_pending[0]['wall_oven_count'] == 'Single Wall Oven'){ echo 'selected';} }?>>Single Wall Oven</option>
                                    <option value="Double Wall Oven"<?php if(isset($pw_pending[0]['wall_oven_count'])){ if($pw_pending[0]['wall_oven_count'] == 'Double Wall Oven'){ echo 'selected';}} ?>>Double Wall Oven</option>
                                    <option value="Wall Oven/Microwave Combo"<?php if(isset($pw_pending[0]['wall_oven_count'])){ if($pw_pending[0]['wall_oven_count'] == 'Wall Oven/Microwave Combo'){ echo 'selected';}} ?>>Wall Oven/Microwave Combo</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Wall Oven Width</label>
                                <select class="form-control" name="wall_oven_width"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['wall_oven_width'])){ if($pw_pending[0]['wall_oven_width'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="24"<?php if(isset($pw_pending[0]['wall_oven_width'])){ if($pw_pending[0]['wall_oven_width'] == '24'){ echo 'selected';} }?>>24</option>
                                    <option value="27"<?php if(isset($pw_pending[0]['wall_oven_width'])){ if($pw_pending[0]['wall_oven_width'] == '27'){ echo 'selected';} }?>>27</option>
                                    <option value="30"<?php if(isset($pw_pending[0]['wall_oven_width'])){ if($pw_pending[0]['wall_oven_width'] == '30'){ echo 'selected';}} ?>>30</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Microwave</label>
                                <select class="form-control" name="microwave"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="N/A"<?php if(isset($pw_pending[0]['microwave'])){ if($pw_pending[0]['microwave'] == 'N/A'){ echo 'selected';} }?>>N/A</option>
                                    <option value="Above Range"<?php if(isset($pw_pending[0]['microwave'])){ if($pw_pending[0]['microwave'] == 'Above Range'){ echo 'selected';}} ?>>Above Range</option>
                                    <option value="In Base Cabinet"<?php if(isset($pw_pending[0]['microwave'])){ if($pw_pending[0]['microwave'] == 'In Base Cabinet'){ echo 'selected';}} ?>>In Base Cabinet</option>
                                    <option value="On Shelf"<?php if(isset($pw_pending[0]['microwave'])){ if($pw_pending[0]['microwave'] == 'On Shelf'){ echo 'selected';}} ?>>On Shelf</option>
                                    <option value="On Counter"<?php if(isset($pw_pending[0]['microwave'])){ if($pw_pending[0]['microwave'] == 'On Counter'){ echo 'selected';}} ?>>On Counter</option>
                                    <option value="Hanging on Wall"<?php if(isset($pw_pending[0]['microwave'])){ if($pw_pending[0]['microwave'] == 'Hanging on Wall'){ echo 'selected';}} ?>>Hanging on Wall</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Microwave Width</label>
                                <select class="form-control" name="microwave_width"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['microwave_width'])){ if($pw_pending[0]['microwave_width'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="24"<?php if(isset($pw_pending[0]['microwave_width'])){ if($pw_pending[0]['microwave_width'] == '24'){ echo 'selected';}} ?>>24</option>
                                    <option value="30"<?php if(isset($pw_pending[0]['microwave_width'])){ if($pw_pending[0]['microwave_width'] == '30'){ echo 'selected';}} ?>>30</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Hood</label>
                                <select class="form-control" name="hood"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="N/A" <?php if(isset($pw_pending[0]['hood'])){ if($pw_pending[0]['hood'] == 'N/A'){ echo 'selected'; } } ?>>N/A</option>
                                    <option value="Microwave Hood" <?php if(isset($pw_pending[0]['hood'])){ if($pw_pending[0]['hood'] == 'Microwave Hood'){ echo 'selected'; } } ?>>Microwave Hood</option>
                                    <option value="Stainless Steel Hood" <?php if(isset($pw_pending[0]['hood'])){ if($pw_pending[0]['hood'] == 'Stainless Steel Hood'){ echo 'selected'; } } ?>>Stainless Steel Hood</option>
                                    <option value="Wood Hood" <?php if(isset($pw_pending[0]['hood'])){ if($pw_pending[0]['hood'] == 'Wood Hood'){ echo 'selected'; } } ?>>Wood Hood</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Refrigerator Width</label>
                                <select class="form-control" name="refrigerator_width"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="24"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '24'){ echo 'selected';} }?>>24</option>
                                    <option value="30"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '30'){ echo 'selected';} }?>>30</option>
                                    <option value="33"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '33'){ echo 'selected';}} ?>>33</option>
                                    <option value="36"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '36'){ echo 'selected';}} ?>>36</option>
                                    <option value="40"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '40'){ echo 'selected';}} ?>>40</option>
                                    <option value="42"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '42'){ echo 'selected';}} ?>>42</option>
                                    <option value="60"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '60'){ echo 'selected';}} ?>>60</option>
                                    <option value="72"<?php if(isset($pw_pending[0]['refrigerator_width'])){ if($pw_pending[0]['refrigerator_width'] == '72'){ echo 'selected';}} ?>>72</option>
                                </select> 
                            </div>
                        </div>
                    </div>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Refrigerator Depth</label>
                                <select class="form-control" name="refrigerator_depth"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['refrigerator_depth'])){ if($pw_pending[0]['refrigerator_depth'] == 'N/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="Full Depth"<?php if(isset($pw_pending[0]['refrigerator_depth'])){ if($pw_pending[0]['refrigerator_depth'] == 'Full Depth'){ echo 'selected';}} ?>>Full Depth</option>
                                    <option value="Countertop Depth"<?php if(isset($pw_pending[0]['refrigerator_depth'])){ if($pw_pending[0]['refrigerator_depth'] == 'Countertop Depth'){ echo 'selected';}} ?>>Countertop Depth</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Applicance Other</label>
                                <input type="text" class="form-control" name="applicance_other" value="<?php if(isset($pw_pending[0]['refrigerator_depth'])){ echo $pw_pending[0]['applicance_other'];}?>" id="position" placeholder="Enter Applicance Other">
                            </div>
                        </div>
                    </div>
                
                    <h5 class="page-title">Cabinetry Options</h5>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Crown Molding</label>
                                <select class="form-control" name="crown_molding"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="No Crown"<?php if(isset($pw_pending[0]['crown_molding'])){ if($pw_pending[0]['crown_molding'] == 'No Crown'){ echo 'selected';}} ?>>No Crown</option>
                                    <option value="Single Stack"<?php if(isset($pw_pending[0]['crown_molding'])){ if($pw_pending[0]['crown_molding'] == 'Single Stack'){ echo 'selected';}} ?>>Single Stack</option>
                                    <option value="Double Stack"<?php if(isset($pw_pending[0]['crown_molding'])){ if($pw_pending[0]['crown_molding'] == 'Double Stack'){ echo 'selected';} }?>>Double Stack</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Crown Molding Touch Ceiling</label>
                                <select class="form-control" name="crown_molding_touch_ceiling"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="N/A"<?php if(isset($pw_pending[0]['crown_molding_touch_ceiling'])){ if($pw_pending[0]['crown_molding_touch_ceiling'] == 'M/A'){ echo 'selected';}} ?>>N/A</option>
                                    <option value="Yes"<?php if(isset($pw_pending[0]['crown_molding_touch_ceiling'])){ if($pw_pending[0]['crown_molding_touch_ceiling'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['crown_molding_touch_ceiling'])){ if($pw_pending[0]['crown_molding_touch_ceiling'] == 'No'){ echo 'selected';}} ?>>No</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Light Rail</label>
                                <select class="form-control" name="light_rail"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Yes" <?php if(isset($pw_pending[0]['light_rail'])){ if($pw_pending[0]['light_rail'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No" <?php if(isset($pw_pending[0]['light_rail'])){ if($pw_pending[0]['light_rail'] == 'No'){ echo 'selected';}} ?>>No</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cabinet Wall Height</label>
                                <select class="form-control" name="cabinet_wall_height"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="30"<?php if(isset($pw_pending[0]['cabinet_wall_height'])){ if($pw_pending[0]['cabinet_wall_height'] == '30'){ echo 'selected';}} ?>>30</option>
                                    <option value="36"<?php if(isset($pw_pending[0]['cabinet_wall_height'])){ if($pw_pending[0]['cabinet_wall_height'] == '36'){ echo 'selected';}} ?>>36</option>
                                    <option value="42"<?php if(isset($pw_pending[0]['cabinet_wall_height'])){ if($pw_pending[0]['cabinet_wall_height'] == '42'){ echo 'selected';}} ?>>42</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class=row>
                        <div class="col-12">
                            <div class="form-group check_box_outer">
                                <label for="name">Option Request</label></br></br>
                                <?php
                                    if( isset($pw_pending[0]['option_request']) ){ 
                                        $option_request = explode(', ', $pw_pending[0]['option_request']);
                                    }else{
                                        $option_request = array();
                                    }
                                ?>
                                <label class="checkbox-inline"><input type="checkbox" <?php if(in_array("Roll Out Trays", $option_request)){ echo "checked"; } ?> name="option_request[]" value="Roll Out Trays">&nbsp;Roll Out Trays</label>
                                <label class="checkbox-inline"><input type="checkbox" <?php if(in_array("In Cabinet Trash", $option_request)){ echo "checked"; } ?> name="option_request[]" value="In Cabinet Trash">&nbsp;In Cabinet Trash</label>
                                <label class="checkbox-inline"><input type="checkbox"  <?php if(in_array("Pantry", $option_request)){ echo "checked"; } ?> name="option_request[]" value="Pantry">&nbsp;Pantry</label>
                                <label class="checkbox-inline"><input type="checkbox" <?php if(in_array("Spice Racks", $option_request)){ echo "checked"; } ?> name="option_request[]" value="Spice Racks">&nbsp;Spice Racks</label> 
                                <label class="checkbox-inline"><input type="checkbox" <?php if(in_array("Glass", $option_request)){ echo "checked"; } ?> name="option_request[]" value="Glass">&nbsp;Glass</label>
                                <label class="checkbox-inline"><input type="checkbox" <?php if(in_array("Lazy Susan Wall", $option_request)){ echo "checked"; } ?> name="option_request[]" value="Lazy Susan Wall">&nbsp;Lazy Susan Wall</label>
                                <label class="checkbox-inline"><input type="checkbox" <?php if(in_array("Lazy Susan Base", $option_request)){ echo "checked"; } ?> name="option_request[]" value="Lazy Susan Base">&nbsp; Lazy Susan Base</label>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                    </div>

                    <div class='row'>
                        <div class="col-6">
                            <label for="name">Prequalified</label>
                            <label class="checkbox-inline"><input type="radio" <?php if( $pw_pending[0]['prequalified'] == 'yes' ){ echo 'checked'; }  ?>  name="prequalified" class="prequalified" data-val="yes"  value="yes">Yes &nbsp;</label>
                            <label class="checkbox-inline"><input type="radio" <?php if( $pw_pending[0]['prequalified'] == 'no' ){ echo 'checked'; }  ?> name="prequalified" class="prequalified" data-val="no" value="no">No &nbsp;</label>
                        </div>
                        <?php if( $pw_pending[0]['prequalified'] == 'yes' ){ 
                            $display_block = 'style="display:block"';}else{
                                $display_block = 'style="display:none"';
                            }
                        ?>
                            <div class="col-6">
                                <div class="preamountDiv" <?php echo $display_block;  ?> >
                                
                                    <label for="name">PreAmount</label>
                                    <input type="text" name="preamount" class="preamount form-control" id="preamount" value="<?php if( $pw_pending[0]['preamount'] ){ echo $pw_pending[0]['preamount'];  } ?>">
                                </div>
                            </div>
                    </div>

                    <h5 class="page-title"> Construction Questions</h5>
                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Ceiling Height</label>
                                <input type="text" class="form-control" name="ceiling_height" value="<?php if(isset($pw_pending[0]['ceiling_height'])){ echo $pw_pending[0]['ceiling_height'];}?>" id="position" placeholder="Enter Ceiling Height"> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Soffit</label>
                                <select class="form-control" name="soffit"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Yes"<?php if(isset($pw_pending[0]['soffit'])){ if($pw_pending[0]['soffit'] == 'Yes'){ echo 'selected';} } ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['soffit'])){ if($pw_pending[0]['soffit'] == 'No'){ echo 'selected';}} ?>>No</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">If Soffit Yes, Keeping?</label>
                                <select class="form-control" name="soffit_yes_keeping"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Yes"<?php if(isset($pw_pending[0]['soffit_yes_keeping'])){ if($pw_pending[0]['soffit_yes_keeping'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['soffit_yes_keeping'])){ if($pw_pending[0]['soffit_yes_keeping'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Not Sure"<?php if(isset($pw_pending[0]['soffit_yes_keeping'])){ if($pw_pending[0]['soffit_yes_keeping'] == 'Not Sure'){ echo 'selected';}} ?>>Not Sure</option>
                                </select>                                                  
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Can any walls be moved?</label>
                                <select class="form-control" name="walls_be_moved"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Yes"<?php if(isset($pw_pending[0]['walls_be_moved'])){ if($pw_pending[0]['walls_be_moved'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['walls_be_moved'])){ if($pw_pending[0]['walls_be_moved'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Not Sure"<?php if(isset($pw_pending[0]['walls_be_moved'])){ if($pw_pending[0]['walls_be_moved'] == 'Not Sure'){ echo 'selected';}} ?>>Not Sure</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Can Windows or Doors be Moved</label>
                                <select class="form-control" name="doors_be_moved"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="Yes"<?php if(isset($pw_pending[0]['doors_be_moved'])){ if($pw_pending[0]['doors_be_moved'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['doors_be_moved'])){ if($pw_pending[0]['doors_be_moved'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Not Sure"<?php if(isset($pw_pending[0]['doors_be_moved'])){ if($pw_pending[0]['doors_be_moved'] == 'Not Sure'){ echo 'selected';}} ?>>Not Sure</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Can Plumbing Be Moved</label>
                                <select class="form-control" name="plumbing_be_moved"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="Yes"<?php  if(isset($pw_pending[0]['plumbing_be_moved'])){ if($pw_pending[0]['plumbing_be_moved'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php  if(isset($pw_pending[0]['plumbing_be_moved'])){ if($pw_pending[0]['plumbing_be_moved'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Not Sure"<?php  if(isset($pw_pending[0]['plumbing_be_moved'])){ if($pw_pending[0]['plumbing_be_moved'] == 'Not Sure'){ echo 'selected';}} ?>>Not Sure</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class=row>
                        <div class="col-6">
                            <div class="form-group ">
                                <label for="name">Can Hood/Range Location be Moved</label>
                                <select class="form-control" name="range_location_be_moved"  data-toggle="select2">
                                    <option value="">Select Option</option> 
                                    <option value="Yes"<?php if(isset($pw_pending[0]['range_location_be_moved'])){ if($pw_pending[0]['range_location_be_moved'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['range_location_be_moved'])){ if($pw_pending[0]['range_location_be_moved'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Not Sure"<?php if(isset($pw_pending[0]['range_location_be_moved'])){ if($pw_pending[0]['range_location_be_moved'] == 'Not Sure'){ echo 'selected';}} ?>>Not Sure</option>
                                </select> 
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Can Refrigerator Location be Moved</label>
                                <select class="form-control" name="refrigerator_location_be_moved"  data-toggle="select2"> 
                                    <option value="">Select Option</option>
                                    <option value="Yes"<?php if(isset($pw_pending[0]['refrigerator_location_be_moved'])){ if($pw_pending[0]['refrigerator_location_be_moved'] == 'Yes'){ echo 'selected';}} ?>>Yes</option>
                                    <option value="No"<?php if(isset($pw_pending[0]['refrigerator_location_be_moved'])){ if($pw_pending[0]['refrigerator_location_be_moved'] == 'No'){ echo 'selected';}} ?>>No</option>
                                    <option value="Not Sure"<?php  if(isset($pw_pending[0]['refrigerator_location_be_moved'])){if($pw_pending[0]['refrigerator_location_be_moved'] == 'Not Sure'){ echo 'selected';}} ?>>Not Sure</option>
                                </select> 
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label>Notes</label>
                                <textarea class="form-control" rows="5" name="kitchen_note"> <?php if( $pw_pending[0]['kitchen_note'] ){ echo $pw_pending[0]['kitchen_note']; } ?> </textarea>
                            </div>
                        </div>
                        
                    </div>
             
                    <div class="text-right">
                        <button type="submit" class="btn btn-success waves-effect waves-light" value="upload" id="save_">Update</button>
                        <button type="button" class="btn btn-danger waves-effect waves-light m-l-10" onclick="Custombox.modal.close();">Cancel</button>
                    </div>
                    <?php echo form_close(); ?><!-- form closes here -->
                </div>
                <!--</div>-->
            </div> <!-- end card body-->
        </div> <!-- end card -->
    </div><!-- end col-->
</div> <!-- container -->