<style type="text/css">
  ul.nav .checkbox
  {
    margin-right:20px;
  }

  .modal-footer, .modal-header 
  {
    padding: 10px;
  }

  .modal-dialog
  {
    width: 65%;
  }

  .popup_inputs
  {
    padding-left: 12%;
  }
  .checkbox-custom { padding-left: 4%; }
  .response 
  { 
    overflow: hidden;
    position: absolute;
    top: 30%;
    background-color: #81D281;
    color: #ffffff;
    font-size: 25px;
    left: 30%;
    padding: 5%;
    border-radius: 10px;
  }
</style>
      <script src="<?=base_url()?>resource/js/jquery-2.1.1.min.js"></script>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script>
       <script type="text/javascript"> 
       jQuery.getScript("http://malsup.github.com/jquery.form.js", function () {
        jQuery('#myForm').ajaxForm(function() 
        { 
          $( '.response' ).fadeIn('500');
          setTimeout(function(){ $('.response').fadeOut(500); }, 2000);
          
        });

        // Rest of your code here, or call out to another function
    });
        
    </script> 


<!-- Modal -->

    <div class="modal-dialog" id="myModal">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>        
          <header class="panel-heading font-bold"><i class="fa fa-cogs"></i> Default Permission Settings </header>
        </div>  
        <div class="modal-body panel-body">

           <?php

       $target = base_url().'users/account/assign_permissions';
       $attributes = array('class' => 'bs-example form-horizontal', 'id'=> 'myForm');
          echo form_open( base_url().'permission/access/assign_permissions',$attributes); ?>
                <!--adding blocks to repeat-->
                <div class="row permissions_fields" >
                    <!--repeat this section-->

                     <input type="hidden" name="user_id" value="<?=$user_id?>">
                    <?php foreach ($permission_module as $permission_info ) 
                              {
                          ?>
                  <div class="col-sm-6 main_parent">
                      <section class="panel panel-default">
                        <header class="panel-heading font-bold">
                          <div class="form-group" style="margin-bottom: 0;">
                            <label class="checkbox-custom"><?=$permission_info->name?></label>
                          </div>
                          <label class="checkbox-custom" style="color:#656D78; font-weight:normal;   padding: 0;" >
                            <input type="checkbox" class="select_all" >   Select   all                                     
                          </label>
                        </header>                        
                  <div class="panel-body">        
                    <div class="form-group" >
                                  <?php 
                                    foreach ($permission as $d_role) 
                                    {                                    
                                      if( $permission_info  ->permission_module_id == $d_role->fk_permission_module_id )
                                      {

                                    ?>
                                      <div class="checkbox popup_inputs">
                                        <label class="checkbox-custom">
                                          <input type="checkbox" name="permissions[]" class="permissions_values" value="<?=$d_role  ->permission_id?>">
                                          <!-- <i class="fa fa-fw fa-square-o"></i> -->
                                            <?php echo    $d_role->permission_name;?>
                                        </label>
                                      </div>
                            <?php     }
                                    }
                             ?>                
                  </div>
                </div>
                </section>
              </div>
          <?php  } ?>
              <!--repeat this section-->
              <div class="col-sm-6 main_parent">
                <button type="submit" class="btn btn-primary save_permissions" ><?=lang('save_changes')?></button>          
              </div>            
            </div><!--adding blocks to repeat-->
          </form>   
          <div class="response" style="display: none;" >
            Information Updated Sucessfully
          </div> 

        </div>
     
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                        
      </div>
    </div>
  </div>
  


<script>
jQuery(document).ready(function(){
    
    jQuery(".select_all").click(function(){
        //alert("The paragraph was clicked.");       
        if( jQuery('.select_all:checked').length > 0 )
        {
           jQuery(this).parents('.main_parent').find('.panel-body input:checkbox').prop('checked', true);
        }
        else
        {
          jQuery(this).parents('.main_parent').find('.panel-body input:checkbox').prop('checked', false);
        }
       
    });
});
</script>

<script type="text/javascript">
$(document).ready( function ()
{     
          var user_id  = '<?php echo $user_id; ?>';                   
              //$('.permissions_fields').slideDown( 1000 );
              //alert( user_id );
              /************/
              ajaxurl = '<?=base_url()?>permission/access/get_permission_info';
              data = {user_id: user_id};
                /***/
                jQuery.post(ajaxurl, data, function(response)
                { 
                    var arr = JSON.parse(response);

                    $('input[type="checkbox"]').each(function(index,value)
                    {
                      var box = $(this);
                      var val = box.val();
                      if($.inArray(val,arr) !== -1)
                      {    box.prop('checked', true); }
                      else 
                      {   box.prop('checked', false);  }

                    });
                  
                });
              /*************/       




});




</script>

