<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <?php echo date('Y')?> &copy; Perfection Kitchens CRM by <a target="_blank" href="http://acewebx.com">Acewebx Team</a> 
        </div>
        <div class="col-md-6">
            <div class="text-md-right footer-links d-none d-sm-block">
                <a href="javascript:void(0);">About Us</a>
                <a href="javascript:void(0);">Help</a>
                <a href="javascript:void(0);">Contact Us</a>
            </div>
        </div>
    </div>
</div>

<style>
    ul.list-group.search_ul {
    list-style: none;
    width: 200px;
    height: 316px;
    overflow: auto;
    top: 45px;
    position: relative;
}

.option_group_li {
    font-weight: 900;
    font-size: 20px;
    text-transform: uppercase;
}

</style>

<script src="<?php echo base_url() ?>assets/libs/jQuery/jQuery.js"></script>
<script type="text/javascript">

    /*jQuery(document).ready(function(){
        if (jQuery(window).width() < 480){
            jQuery('.enlarged .left-side-menu').css('width','0px');
        }
    });*/


    jQuery(document).on('click','#button-value',function(){
        var valuebtn = "value";
        jQuery.ajax({
            url:"<?php echo base_url() ?>crm/leads/coll_menu",
            method:"post",
            data:{valuebtn:valuebtn},
            error:function(res){ console.log(res);},
            success:function(res){
                console.log(res);
            }

        });

    });
</script>
<?php 
$user_id = $this->tank_auth->get_user_id();
$data    = $this->db->select('coll_value')->from('coll_menu')->where('user_id',$user_id )->get()->row_array();
if( $data['coll_value'] == 0 ){ ?>
    <script type="text/javascript">
        jQuery(document).ready(function(){
            if (jQuery(window).width() > 480){
                jQuery('#button-value').trigger('click');
            }
        });
    </script>

<?php } ?>

<script>
    
    jQuery(document).on('keyup','#search_input',function(){
       var inputVal = jQuery(this).val();
       jQuery.ajax({
          url: '<?php echo base_url(); ?>search/search/search_result',
          type: 'post',
          data: { inputVal:inputVal },
          error:function(res){
              console.log(res);
          },
          success:function(res){
              jQuery('.search_result').html(res);
          }
       });
        
    });
    
</script>