<?php 

    if($this->router->fetch_method() == 'index' ||$this->router->fetch_method() == 'paperworkpending' )

    {  // For list All users

?>

	<!-- third party js -->

	<link href="<?php echo base_url()?>assets/libs/datatables/dataTables.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/responsive.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/buttons.bootstrap4.css" rel="stylesheet" type="text/css" />

	<link href="<?php echo base_url()?>assets/libs/datatables/select.bootstrap4.css" rel="stylesheet" type="text/css" />

	<style type="text/css">

		.custombox-content>* {

		    max-width: 100%;

		    /*max-height: unset !important; */

		    overflow-y: scroll;

		}

		.error {
    	color: red;
		}


	</style>

<?php } ?>

<style type="text/css">

		.create-customer {
    		font-size: 15px;
		}
		
		.header {
			    width: 100%;
			    padding: 14px;
			    background: #566676;
			    margin: 23px 0px;
			    color: rgba(255,255,255,.6);
		}
/* NEW CSS */		
		  .tooltip {
      position: relative;
      display: inline-block;
      border-bottom: 1px dotted black;
    }
    
    .tooltip .tooltiptext {
      visibility: hidden;
      width: 120px;
      background-color: black;
      color: #fff;
      text-align: center;
      border-radius: 6px;
      padding: 5px 0;
      position: absolute;
      z-index: 1;
    }   
    .timelineprofile_page_{
        people: 
    }
    
    .tooltip:hover .tooltiptext {
      visibility: visible;
    }
    .no_list{
        overflow-y: scroll;
        overflow-x: hidden;
        height: 400px;
    }
     .clear { clear:both; }  
    .sms_in { float: left; background-color: #e8e8e8;     margin-top: 15px;}
    .sms_out { float: right;     background-color: #f1556c; color: #fff;}
    .smst { padding: 4px 8px; border-radius: 4px;clear: both; max-width: 50%;}
    .smst span{ margin-left:0px;}
    .smsr {
        background-color: #e5e4e4;
        color: #151515;
        max-width: 60%;
    }
    .sms_timeout{float: left; color: black;}
    .btn-success {display: block; width: 100%;}
    
   .timeline.profile_page_ .timeline-box span.arrow-alt {
         border-left: 12px solid #f5f5f5!important;
         }
         .timeline.profile_page_ .timeline-box {
         background: #f5f5f5;
         box-shadow: none;
         }
         .timeline.profile_page_ .timeline-box span.arrow {
         border-right: 12px solid #f5f5f5 !important;
         }
         .profile_messages_box{
         margin: 0;
         border-left: 0;
         padding: 0;
         }
         .card-box.text-center.user_profiles_outer img {
         margin-right: 22px;
         }
         .user_profiles_outer h4.mb-0 {
         margin-top: 0;
         margin-bottom: 5px !important;
         }
         .user_profiles_outer p {
         margin-bottom: 0px !important;
         }
        .card-box.mb-2.user_activity .media img {
            width: 29px;
            height: 29px;
            margin-right: 15px !important;
            align-self: center!important;
        }
        .card-box.mb-2.user_activity h4 {
            font-size: 14px !important;
            margin-bottom: 1px !important;
        }
        .card-box.mb-2.user_activity {
            padding: 10px 15px;
        }
        .card-box.mb-2.user_activity p b {
           font-size: 12px;
        }
      .card-box.mb-2.user_activity p {
          margin-bottom: 0 !important;
          font-size: 13px;
       }
       .card-box.mb-2.user_activity p i {
        font-size: 18px;
        position: relative;
        top: 2px;
      }
      .time_bor {
        position: relative;
        bottom: 1px;
      }
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
    
    ul.numberList {
        padding-left: 0;
    }
    
    .numberList a.lead_no {
        padding: 10px;
        display: block;
        border-bottom: 1px solid #e2e2e2;
    }
    .numberList .activeNm .lead_no {
        border-left:3px solid #f1556c;
        background: #f5f5f5;
    }
    .numberList .lead_no:hover{
        background: #f5f5f5;
    }
    .smsl , .smslr{
        width:100%;
        display:block;
        color:#6e768e;
    }
    /*.smsl{*/
    /*    text-align:left;*/
    /*}*/
    /*.smslr{*/
    /*    text-align:right;*/
    /*}*/
    
    .sms_admin {
        float: right;
        color: black;
    }
    
    .smstname {
        border-radius: 4px;
        clear: both;
        font-size: 10px;
        margin-top: -12px;
        margin-left: 10px;
    }
    
    .msgTime {
        text-align:center;
        margin-bottom: 26px;
    }
    .chatbox {
        margin-bottom: 10px}els;
    }
        display: block;
    }
    .customDes i{
       margin-right:0px;
    }
    .timeline {
        margin-bottom: 50px;
        position: relative;
        padding-left: 28px;
        border-left: 1px solid #ccc;
    }
    .customdesign{
        text-align:right;
    }
    .customdesign i {
        font-size: 25px;
        margin-right: 0 !important;
    }
    a.customdesign{
        padding: 2px 7px;
    }
    .mLeft{
        float: left;
    }
    .mRight{
        float: right;
    }
    .markoption {
        list-style: none;
        padding-left: 10px;
    }
    .markoption li{
        display: inline-block;
    }
    .markoption a {
        font-size: 20px;
        color: #6e768e;
        padding: 10px 20px;
        display: block;
        border: 1px solid #6e768e14;
    }
    .markoption a:hover{
        color: #151515;
    }
    .markoption .actives{
        color: #42b72a;
    }
    .markoption a.markdone{
        color: #42b72a;
        border-color: #42b72a;
    }
    .markoption a.markdone:hover, 
    .markdone.actives {
        color: #fff !important;
        background-color: #42b72a;   
    }
    .topBar {
        border-bottom: 1px solid #ccc;
    }

    @media only screen and (max-width: 500px) {
		.profile_page_ {
		    margin-top: 30px;
		    padding: 10px;
		    border-left: 0;
		    border: 1px solid #ccc;
		}
		#smstext{
			margin-bottom: 15px;
		}

    select#dropdownMenuButton {
      width: 55px;
      font-size: 14px;
      padding: 7px;
    }

    .col-sm-4.msgtype {
      width: 24px !important;
      z-index: 9;
    }

    .col-sm-8.msgfolow {
        width: 246px;
        margin-bottom: 12px;
    }

    .markoption a {
      font-size: 13px;
      color: #6e768e;
      padding: 9px 14px;
      display: block;
      border: 1px solid #6e768e14;
    }

    a.customdesign {
      padding: 0px 4px;
    }

    .markoption {
        list-style: none;
        padding-left: 42px;
    }


	}
/* width */
.scrollbar::-webkit-scrollbar {
  width: 12px;
}

/* Track */
.scrollbar::-webkit-scrollbar-track {
  background: #f1f1f1; 
}
 
/* Handle */
.scrollbar::-webkit-scrollbar-thumb {
  background: #888; 
}

/* Handle on hover */
.scrollbar::-webkit-scrollbar-thumb:hover {
  background: #555; 
}

</style>