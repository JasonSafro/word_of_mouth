<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

<title>:: Word Of Mouth ::</title>
<?php
echo css_asset("reset.css");
echo css_asset("stylesheet.css");
echo css_asset("word-of-mouth.css");
//echo css_asset("featuredcontentglider.css");
echo css_asset("flexslider.css");
echo css_asset("address-popup.css");
echo css_asset("screen.css");
?>
<link rel="shortcut icon" href="<?php echo USER_SIDE_IMAGES;?>wom-20130603-favicon.ico.png"/>
<?php echo css_asset("selectbox.css");?>
<!--[if IE]>
<script src="<?php echo base_url()?>assets/scripts/html5.js"></script>
<![endif]-->
<?php echo js_asset("jquery-1.8.3.min.js"); ?>
<script type="text/javascript" language="javascript">
$(document).ready(function () {
$("div.videos li:last") .css("margin-bottom","0px");
$("div.videos li:last") .css("background","none");
$("div.line-one li:last") .css("margin-right","0px");
$("div.line-two li:last") .css("margin-right","0px");
$("div.line-three li:last") .css("margin-right","0px");
$("div.line-four li:last") .css("margin-right","0px");
$("div.line-five li:last") .css("margin-right","0px");
$("div.swControls a:last") .css("margin-right","0px");
$("div.links li:last") .css("background","none");
});
</script>
<?php
echo js_asset("jquery.responsivetable.min.js");
echo js_asset("jquery.responsivetable.js");
?>
<script type="text/javascript" src="<?php echo base_url()?>assets/scripts/claim_a_business_process_validation.js"></script>
<?php echo js_asset("jquery.maskedinput-1.3.js");?>
<script type="text/javascript">
  //store_phone phone_number
 
    jQuery(function($){
        $("#buss_phone").mask("999-999-9999");
        $("#p_buss_phone").mask("999-999-9999");
		$("#buss_fax").mask("999-999-9999");
		$("#p_buss_fax").mask("999-999-9999");
    }); 
</script> 
<style>
    .error{
	font-style:italic;
	font-size:13px;
	color:#FF0000;
	font-weight: bold;
}
.content-pop form input[type="password"] {
    border: 1px solid #A1A1A1;
    border-radius: 5px 5px 5px 5px;
    color: #BFBFBF;
    font-family: 'RobotoItalic';
    font-size: 12px;
    margin-bottom: 21px;
    padding: 9px 38px;
    width: 100%;
}
</style>
<script>
var SITE_URL="<?php echo base_url(); ?>";
$(document).ready(function() {
$('table').responsiveTable();
});
</script>
<!--for us of back to top function-->
<script src="<?php echo base_url()?>assets/scripts/jquery.easing.1.2.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo base_url()?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
			$(document).ready(function(){
				/*====================== Exemple basique ======================*/
				$("#parent1").wslide({
					width: 450,
					height: 200,
					duration: 2000,
					effect: 'easeOutBounce'
				});
				/*====================== Exemple 2 ======================*/
				$("#parent2").wslide({
					width: '100%',
					height: 284,
					//pos: 1,
					//horiz: true,
					autoplay: true ,
					fade: true,
					//delay: 2000,
					duration: 2000, 
					//type: 'sequence',
					//duration: 1000,
					//effect: 'easeOutElastic'
					
				});
				
				
				
				/*====================== Exemple 3 ======================*/
				$("#parent3").wslide({
					width: 250,
					height: 300,
					col: 4,
					autolink: 'menu3',
					duration: 4000,
					effect: 'easeOutExpo'
				});
			});
</script>
<?php
echo js_asset("jquery.reveal.js");
echo js_asset("script.js");
echo js_asset("jquery.min.js");
?>
<!--select-->

<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script-->

  <script type="text/javascript" charset="utf-8">
         
       
        function print_state(state_id, countryCode){            
             $.ajax({
                    type: "GET",                                        
                    //url: '<?php echo base_url() ?>services/getState/'+countryCode,
                    url: '<?php echo base_url() ?>services/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) { 
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;                               
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);                                   
                                });  
                                //$('#'+state_id).parent().children(':not(#'+state_id+')').remove();
                                //$('#userState').selectbox(); 
                    }
            });           
        } 
        
        function initialize(){
            //When Page Loads- Get State by country(Basic)
            var e = document.getElementById("userCountry");
            if(e!=''){
                var strUser = e.options[e.selectedIndex].value;                          
                print_state('userState',strUser);}
            
           //When Page Loads- Get State by country(Premium)
            var e = document.getElementById("p_userCountry");
            if(e!=''){
                var strUser = e.options[e.selectedIndex].value;                          
                print_state('p_userState',strUser);}
           
            
            //when page load again with the error then it will works 
            var e = document.getElementById("userCategory");
            if(e!=''){                  
               var flag=false;
               $('#userCategory :selected').each(function(i, selected){ 
                  if($(selected).val()=='other')
                      flag=true;
                });
               if(flag==true)
                    $("#otherCatDiv").css('display','block');
                else
                    $("#otherCatDiv").css('display','none'); 
            }
            
             //when page load again with the error then it will works 
               var e = document.getElementById("p_userCategory");
                if(e!=''){                  
                   var flag=false;
                   $('#p_userCategory :selected').each(function(i, selected){ 
                      if($(selected).val()=='other')
                          flag=true;
                    });
                   if(flag==true)
                        $("#p_otherCatDiv").css('display','block');
                    else
                        $("#p_otherCatDiv").css('display','none'); 
                }
                
            //set price for selected plan (Form basic account)
            var e = document.getElementById("b_acc_type");
            var acc_type = e.options[e.selectedIndex].value;  
            if(acc_type=="bm")
                $('#b_price').html('<?php echo $basic_plan_monthly_price; ?>');
            else
                $('#b_price').html('<?php echo $basic_plan_annual_price; ?>');
                        
            //set price for selected plan (Form premium account)
            var e = document.getElementById("p_acc_type1");
            var acc_type = e.options[e.selectedIndex].value;                                                 
            if(acc_type=="pm")
                $('#p_price2').html('<?php echo $prem_plan_monthly_price; ?>');
            else
                $('#p_price2').html('<?php echo $prem_plan_annual_price; ?>');
        }
    </script>  
	<?php //echo js_asset("jquery.selectbox-0.5.js");  ?>
	<script type="text/javascript">
	$(document).ready(function() {	
            initialize();
            
		 //When Country Changes, Change State 
                    $('#userCountry').change(function(){
                       setTimeout(function(){
                           var e = document.getElementById("userCountry");
                           var strUser = e.options[e.selectedIndex].value;
                           print_state('userState',strUser);
                       },500)
                        
                          // alert(this.value+' ='+$('#userCountry').val());
                    });
                    
                   //Premium Form (ADDED)
                     $('#p_userCountry').change(function(){
                       setTimeout(function(){
                           var e = document.getElementById("p_userCountry");
                           var strUser = e.options[e.selectedIndex].value;
                           print_state('p_userState',strUser);
                       },500)                        
                    });
                    
                    //Basic business info
                     $('#buss_country').change(function(){                        
                           var e = document.getElementById("buss_country");
                           var countryCode = e.options[e.selectedIndex].value;
                           print_state('buss_state',countryCode);                       
                    });
                    
                    //Premium business info
                     $('#p_buss_country').change(function(){ 
                           var e = document.getElementById("p_buss_country");
                           var countryCode = e.options[e.selectedIndex].value;
                           print_state('p_buss_state',countryCode);                      
                    });
                    
                    //Basic cc info
                     $('#c_userCountry').change(function(){                        
                           var e = document.getElementById("c_userCountry");
                           var countryCode = e.options[e.selectedIndex].value;
                           print_stateForCC('c_state',countryCode);                       
                    });
                    
                    //premium cc info // p_c_userCountry
                     $('#p_c_userCountry').change(function(){                        
                           var e = document.getElementById("p_c_userCountry");
                           var countryCode = e.options[e.selectedIndex].value;
                           print_stateForCC('p_c_state',countryCode);                       
                    });
                    
                    //Basic Plan Page 1 for price
                    $("#acc_type").change(function() {$('#promocode').val("");$("#pro_code_err").html("");
                             setTimeout(function(){
                                   var e = document.getElementById("acc_type");
                                    var acc_type = e.options[e.selectedIndex].value;  
                                   // alert(acc_type);
                                    if(acc_type=="bm")                                        
                                        $('#price').html('<?php echo $basic_plan_monthly_price;?>');
                                    else
                                        $('#price').html('<?php echo $basic_plan_annual_price;?>');
                               },500)         

                    });

                     //Basic Plan Page 2 for price
                $("#b_acc_type").change(function() {$('#b_promocode').val("");$("#b_pro_code_err").html("");
                    setTimeout(function(){
                        var e = document.getElementById("b_acc_type");
                        var acc_type = e.options[e.selectedIndex].value;  
                        // alert(acc_type);
                        if(acc_type=="bm")
                            $('#b_price').html('<?php echo $basic_plan_monthly_price; ?>');
                        else
                            $('#b_price').html('<?php echo $basic_plan_annual_price; ?>');
                    },500)         
                });
                                        
                               
                //Premium Plan Page 2 for price
                $("#p_acc_type1").change(function() {$('#p_promocode1').val("");$("#p_pro_code_err1").html("");                    
                        var e = document.getElementById("p_acc_type1");
                        var acc_type = e.options[e.selectedIndex].value;                                                 
                        if(acc_type=="pm")
                            $('#p_price2').html('<?php echo $prem_plan_monthly_price; ?>');
                        else
                            $('#p_price2').html('<?php echo $prem_plan_annual_price; ?>');                    
                });
                
                //for basic business user
                var arr = new Array();
                $("#userCategory").change(function() {
                    $(this).find("option:selected")
                    if ($(this).find("option:selected").length > 2) {
                        $(this).find("option").removeAttr("selected");
                        alert('You can only choose two categories.');
                        $(this).val(arr);
                    }
                    else {
                        arr = new Array();
                        $(this).find("option:selected").each(function(index, item) {
                            arr.push($(item).val());
                        });
                    }

                    var flag=false;
                   $('#userCategory :selected').each(function(i, selected){ 
                       //alert($(selected).val());
                      if($(selected).val()=='other')
                          flag=true;
                    });

                   if(flag==true)
                        $("#otherCatDiv").css('display','block');
                    else
                        $("#otherCatDiv").css('display','none');  
                            
            }); 
                //for premium user
                $('#p_userCategory').change(function(){                      
                           var e = document.getElementById("p_userCategory");                           
                           var flag=false;
                           $('#p_userCategory :selected').each(function(i, selected){                                
                              if($(selected).val()=='other')
                                  flag=true;
                            });                           
                           if(flag==true)
                                $("#p_otherCatDiv").css('display','block');
                            else
                                $("#p_otherCatDiv").css('display','none'); 
                    });               
	});
	</script>
    
<script type="text/javascript">
// Popup window code
function newPopup(url) {
	var popupWindow = window.open(
		url,'popUpWindow','height=780,width=800,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
                
                return false;
}

</script>


<?php echo js_asset("jquery.alerts.js");?>
<?php echo js_asset("jquery.MultiFile.js");?>
<?php echo js_asset("jquery.MultiFile.pack.js");?>
<?php echo js_asset("additional-methods.js");?>
</head>

<body id="top">
 <?php $this->load->view('includes/user_reg_view'); ?>
<div id="fade1" class="black_overlay"></div>
<!--register lightbox popup end-->
<!--lightbox vidfeo player appearing from here-->
<div id="myModal" class="reveal-modal">
  <video poster="http://media.w3.org/2010/05/sintel/poster.png" preload="none" controls="" id="video" tabindex="0" width="520" height="380">
    <source type="video/mp4" src="http://media.w3.org/2010/05/sintel/trailer.mp4" id="mp4"></source>
    <source type="video/webm" src="http://media.w3.org/2010/05/sintel/trailer.webm" id="webm"></source>
    <source type="video/ogg" src="http://media.w3.org/2010/05/sintel/trailer.ogv" id="ogv"></source>
    <p>Your user agent does not support the HTML5 Video element.</p>
  </video>
  <a class="close-reveal-modal">&#215;</a> </div>
<!--lightbox vidfeo player end here-->
<div id="wrapper" >
  <div class="clearfix">
    <header>
      <div id="main" >
        <div class="fr1">
          <div class="sign-box">
            <li><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Sign In</a></li>
            <li class="divide"></li>
            <li> <a href = "javascript:void(0)" onclick = "document.getElementById('light1').style.display='block';document.getElementById('fade1').style.display='block'">Register</a></li>
          </div>
          <div class="clear"></div>
        </div>
        <div class="logo"><?php echo anchor('user/home/', img(array('src' => USER_SIDE_IMAGES.'logo.png','border'=>"0", 'alt' => 'logo'))); ?></div>
               <div class="fr">
            <?php if ($this->session->userdata('user_id') != '')
                { ?>
            <div class="login_name">
                <a href="<?php echo base_url() ?>dashboard" title="Dashboard"><b>Welcome, &nbsp;<?php echo $this->session->userdata('user_name') ?></b></a>
            </div>
                <div class="sign-box">  
                    <li><a href = "<?php echo base_url() ?>dashboard" title="My Account">My Account</a></li>
                    <li class="divide"></li>
                    <li><a href = "<?php echo base_url() ?>user/logout" title="Signout">Sign Out</a></li>
                <?php }
                else
                { ?>
                    <div class="sign-box"> 
                    <li><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='block';document.getElementById('fade').style.display='block'">Sign In</a></li> 
                    <li class="divide"></li>
                        <li> <a href = "javascript:void(0)" onclick = "document.getElementById('light1').style.display='block';document.getElementById('fade1').style.display='block'">Register</a></li>
                <?php  }?>
                </div>
            
          <div class="clear"></div>
          <div class="call-us">
            <div class="space"><img src="<?php echo USER_SIDE_IMAGES;?>spacer.gif" alt="spacer" width="5"></div>
            <span>Call Us Today: <?php echo _getHeaderPhoneNo();?></span></div>
        </div>
        <div class="call-us1">
          <div class="space"><img src="<?php echo USER_SIDE_IMAGES;?>spacer.gif" alt="spacer" width="5"></div>
          Call Us Today: <?php echo _getHeaderPhoneNo();?></div>
        <div class="clear"></div>
      </div>
        </div>
        <nav>
           <?php $currentUri=$this->uri->segment(1);?>
        <ul>
           
           <li><?php echo anchor('home/', 'Home', array('class' => ($currentUri=='home'?"active":''))); ?></li>
            <li><?php echo anchor('aboutus/', 'About Us', array('class' => ($currentUri=='aboutus'?"active":''))); ?></li>
            <li><?php echo anchor('how_it_works/', 'How it Works', array('class' => ($currentUri=='how_it_works'?"active":''))); ?></li>
            <li><?php echo anchor('services/', 'Our Services', array('class' => ($currentUri=='services'?"active":''))); ?></li>
            <li><?php echo anchor('deals_and_coupons/', 'Deals & Coupons', array('class' => ($currentUri=='deals_and_coupons'?"active":''))); ?></li>
            <li><?php echo anchor('we_are_hiring/', 'We’re Hiring', array('class' => ($currentUri=='we_are_hiring'?"active":''))); ?></li>
            <li><?php echo anchor('faq/', 'FAQ', array('class' => ($currentUri=='faq'?"active":''))); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us', array('class' => ($currentUri=='contact_us'?"active":''))); ?></li>
            
          <div class="clear"></div>
        </ul>
        </nav>
    </header>
    <!--header end here-->
    <div id="page-wrap">

        <div id="main1">
          <section class="inside-title">
          <div class="inside-title-in"><div  id="main">
          <h1>Our Services</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>services/">Home</a> |  Our Services</div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>
 
      <div id="section">
        <section id="main">
        <div class="about-main">
   <table width="100%" border="0" class="services-tb">
  <tr>
    <th>Word of Mouth Referral Plans</th>
    <th ><?php echo $basic_plan_name;?></th>
    <th ><?php echo $prem_plan_name;?></th>
  </tr>
  <?php foreach($service_limits as $key=>$val)
  {?>
    <tr>
    <td><?php echo $val['service_name'];?></td>
    <td><div class="max-out">
    <?php 
         if($val['service_basic_status']=='A'){?>
        <img src="<?php echo USER_SIDE_IMAGES;?>tick.png" alt="">
        <?php }else {?>
        <img src="<?php echo USER_SIDE_IMAGES;?>cross.png" alt="">
        <?php }?><span class="max"><?php if($val['service_basic_limit']=='0'){?>Unlimited<?php }else if($val['service_basic_limit']!='') {echo $val['service_basic_limit']." Max";}?></span></div>
    </td>
    <td><div class="max-out"><?php 
         if($val['service_premium_status']=='A'){?>
        <img src="<?php echo USER_SIDE_IMAGES;?>tick.png" alt="">
        <?php }else {?>
        <img src="<?php echo USER_SIDE_IMAGES;?>cross.png" alt="">
        <?php }?><span class="max"><?php if($val['service_premium_limit']=='0'){?>Unlimited<?php }else if($val['service_premium_limit']!='') {echo $val['service_premium_limit']." Max";}?></span></div>
    </td>
  </tr>
  <?php }?>     
  
  
  <tr>
    <td><div class="cent"><?php echo $basic_plan_annual_name;?> & <?php echo $basic_plan_monthly_name;?> price details*<br>
       <span class="ymc">*You may cancel anytime</span></div></td>
    <td>
    <div class="l-p">
    $<?php echo $basic_plan_annual_price;?> <br><h2><?php echo $basic_plan_annual_name;?></h2>
    </div>
     <div class="r-p">
   $<?php echo $basic_plan_monthly_price;?> <h2><?php echo $basic_plan_monthly_name;?></h2>  
    </div>
    <div class="clear"></div>
    <div class="green-btn">
        <?php         
        if($this->session->userdata('claimRequestedUserId')==''){ ?>
        <a href="#address10" id="address_pop" class="button6 green" onclick="javascript: $('#back-top a').click();">SIGN UP</a>   
        <?php }else{?>
     <a href="#address11" id="address_pop" class="button6 green" onclick="javascript: $('#back-top a').click();">SIGN UP</a>   
     <?php }?>
    <!--/*======================== popup start1=====================================/-->
    
           <div>
            <a href="#" class="overlay" id="address10"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop newht" align="center">   
            
            <h1><?php echo $basic_plan_name;?> Plan</h1>
           <h2> You are on step 1 out of 2 </h2>
              <div class="form2">
     
              
              <!--------------------------------------step1--------------------------------------------------->
           <?php
        $attributes = array('name' => 'frmSignup_basic', 'id' => 'frmSignup_basic', 'method' => 'post');
        //echo form_open('services/submitForm_basic', $attributes);
        echo form_open('claim/registeration/basic/1#address10', $attributes);
        ?>
           <div class="pop-left fullwdth">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Create your username</h4>
           <label>Username <span>(alphanumeric, no more than 32 characters)</span></label>
           <input name="username" id="username" type="text" value="<?php echo set_value('username',$user_info_array['user_name']);?>">
           <?php echo form_error('username');?>
           </div>
           <div class="pop-left-second">
            <h4><img src="<?php echo USER_SIDE_IMAGES;?>passsword.png"> &nbsp; Choose a password</h4>
           <label>Password *</label>
             <input name="user_password" id="user_password" type="password" value="<?php echo set_value('user_password'); ?>">
             <?php echo form_error('user_password');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
          
           <label>Business Contact Email *<span>(we won't spam you!)</span></label>
          <input name="user_email" id="user_email" type="text" value="<?php echo set_value('user_email',$user_info_array['user_email']);?>">
          <?php echo form_error('user_email');?>
           </div>
           <div class="pop-left-second">
           
           <label>Repeat *<span>(for confirmation) </span></label>
             <input name="cpassword" id="cpassword" type="password" value="<?php echo set_value('cpassword'); ?>">
              <?php echo form_error('cpassword');?>
           </div>
           <div class="clear"></div>
           <div class="full">
            <label><input name="email_announc" type="checkbox" value="1"> &nbsp;Receive important email announcements from Word of Mouth Referral</label>
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>user.png"> &nbsp; Your Information</h4>
           <label>First Name *</label>
             <input name="fname" id="fname" type="text" value="<?php echo set_value('fname',$user_info_array['user_fname']);?>">
             <?php echo form_error('fname');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Last Name *</label>
          <input name="lname" id="lname" type="text" value="<?php echo set_value('lname',$user_info_array['user_lname']);?>">
           <?php echo form_error('lname');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>Address *  </label>
            <input name="address" id="address" type="text" value="<?php echo set_value('address',$user_info_array['user_address']);?>">
            <?php echo form_error('address');?>
           </div>
           <div class="pop-left-second">
     
           <label>Address add on</label>
            <input name="addr_addon" id="addr_addon"type="text" value="<?php echo set_value('addr_addon',$user_info_array['user_address_addon']);?>">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Zip code *</label>
            <input name="zip_code" id="zip_code"type="text" value="<?php echo set_value('zip_code',$user_info_array['user_zipcode']);?>">
             <?php echo form_error('zip_code');?>
            
           </div>
           <div class="pop-left-second">
      
           <label>City *</label>
          <input name="city" id="city"type="text" value="<?php echo set_value('city',$user_info_array['user_city']);?>">
          <?php echo form_error('city');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first rel-position">
    
           <label>Country *</label>
           <?php 
                            //$st='id="Items" class="items userCountry" onchange="changeState(this.value);"';
                            //echo form_dropdown('userCountry', _getCountryList(),set_value('userCountry'),$st);                            
                        ?>   
            <select name="Items" id="userCountry" class="items_custom">
                <?php
                                        $countryList = _getCountryList();    
                                         if ($user_info_array['user_country'])
                                            {
                                                foreach ($countryList as $key => $val)
                                                {
                                                    if ($key == $user_info_array['user_country'])
                                                    {
                                                        ?>
                                                    <option value="<?php echo $key; ?>" selected><?php echo $val; ?></option> 
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="' . $key . '">' . $val . ' </option> ';
                                                    }
                                                }
                                            }
                                            else
                                            { 
                                                foreach ($countryList as $key => $val)
                                                {
                                              ?>                                           
                                            <option value="<?php echo $key; ?>" <?php if($key=="USA"){?> selected <?php }?>><?php echo $val; ?></option>                                            
                                        <?php }} ?>    
            <!--option value="">Select</option>
             <option>United States</option>
              <option>United States</option -->
            </select>
           <?php echo form_error('Items');?>
           </div>
           <div class="pop-left-second rel-position">
    
           <label>State *</label>
           <div id="stateHolder">
            <?php 
                           // $st='id="userState" class="items"';//stateHolder
                            //echo form_dropdown('userState', _getStateList(),set_value('userState'),$st);                            
                        ?>   
               <select name="userState" id="userState" class="items_custom">
            <option>Choose your state</option>
            </select>
               <?php echo form_error('userState');?>
           </div>    
            <br>
           
            
           </div>
            <div class="cancel-sec">
                <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" onClick="javascript: $('#submitbtn12').click();">PROCEED TO STEP 2</a><br>
      <input  style="display:none;" name="submitbtn12" id="submitbtn12" value="PROCEED TO STEP 2"  type="submit"/>
            </div>
           <div class="clear"></div>
           <div class="clear"></div>
           </div>          
            <br><br>
                </div>
                
              
           
           </form>
           </div>
                        
               </div>
            </div>
            </div>
            <!--/*======================== popup1 end*=====================================/-->
              
            
             <!--/*========================step 2 start=====================================/-->
    
           <div>
            <a href="#" class="overlay" id="address11"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
            
                          <!-- Remove this after email starts -->
            <?php  //if ($this->session->userdata('activation_url') != ''){?>
                <!--h5>Account Activation Link : <?php echo $this->session->userdata('activation_url');?></h5-->
                <?php //}?>
            
            <h1>Basic Plan</h1>
           <h2> You are on step 2 out of 2 </h2>
           <?php if($error!=''){?>
           <br/><?php /*?><h2><?php echo $error;?></h2><?php */?>
           <span class="h2-error"><?php echo $error;?></span>
           <?php }?>
              <div class="form2">
     <!--------------------------------------step2--------------------------------------------------->
              <?php
        $attributes = array('name' => 'frmSignup_buss_basic', 'id' => 'frmSignup_buss_basic1', 'method' => 'post');
        echo form_open_multipart('claim/registeration/basic/2#address11', $attributes);
        ?>
           <div class="pop-left ">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Business Name</h4>
           <label>Name * <span>(alphanumeric, no more than 32 characters)</span></label>
           <input name="buss_name" id="buss_name"type="text" value="<?php echo set_value('buss_name',$tmp_buss_name); ?>"/>
            <?php echo form_error('buss_name');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Contact Name</label>
            <input name="buss_cont_name" id="buss_cont_name"type="text"value="<?php echo set_value('buss_cont_name',$tmp_buss_cont_name); ?>"/>
            <?php echo form_error('buss_cont_name');?>
           </div>
           <div class="clear"></div>
                     <div class="full">
          
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>home2.png"> &nbsp; Business Details</h4>
           <label>Address * </label>
            <input name="buss_addr" id="buss_addr" type="text"value="<?php echo set_value('buss_addr',$tmp_buss_address); ?>"/>
             <?php echo form_error('buss_addr');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Address add on</label>
            <input name="buss_addr_addon" id="buss_addr_addon" type="text"value="<?php echo set_value('buss_addr_addon',$tmp_buss_addr_addon); ?>"/>
            <?php echo form_error('buss_addr_addon');?>
           </div>
           <div class="clear"></div>
           
           <div class="pop-left-first">
           <label>Country * </label>
            <?php 
                $st='id="buss_country" class="items_custom"';                
                echo form_dropdown('buss_country', _getCountryList(),set_value('buss_country',$tmp_buss_country),$st);
              ?>
            <?php echo form_error('buss_country');?>
           </div>
           
           <div class="pop-left-second">
           <label>State *</label>
            <?php 
                $selectedBussCountry=set_value('buss_country',$tmp_buss_country);//get selected country value that is country code
                $st='id="buss_state" class="items_custom"';
                echo form_dropdown('buss_state', _getStateList($selectedBussCountry),set_value('buss_state',$tmp_buss_state),$st);
              ?>
               <?php echo form_error('buss_state');?>
           </div>
           <div class="clear"></div>
           
           <div class="pop-left-first">        
           <label>City * </label>
            <input name="buss_city" id="buss_city"type="text"value="<?php echo set_value('buss_city',$tmp_buss_city); ?>"/>
            <?php echo form_error('buss_city');?>
           </div>
           <div class="pop-left-second">
     
           <label>Zip code *</label>
            <input name="buss_zipcode" id="buss_zipcode"type="text"value="<?php echo set_value('buss_zipcode',$tmp_buss_zip_code); ?>"/>
               <?php echo form_error('buss_zipcode');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Phone</label>
            <input name="buss_phone" id="buss_phone"type="text"value="<?php echo set_value('buss_phone',$tmp_buss_phone); ?>"/>
              <?php echo form_error('buss_phone');?>
           </div>
           <div class="pop-left-second">
      
           <label>Fax</label>
            <input name="buss_fax" id="buss_fax"type="text" value="<?php echo set_value('buss_fax',$tmp_buss_fax); ?>"/>
             <?php echo form_error('buss_fax');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Web Address</label>
            <input name="buss_web_addr" id="buss_web_addr"type="text"value="<?php if($tmp_buss_web_address){
					echo set_value('buss_web_addr',$tmp_buss_web_address);
				}
				else echo "http://"; ?>"/>
            <?php echo form_error('buss_web_addr');?>
           </div>
           <div class="pop-left-second">
      
           <label>Contact Email Address *</label>
            <input name="buss_email_addr" id="buss_email_addr" type="text"value="<?php echo set_value('buss_email_addr',$tmp_buss_email); ?>"/>
             <?php echo form_error('buss_email_addr');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first rel-position">
    
           <label>Business Category *</label>
            <!--<select name="Items" class="items">
            <option>Automotive</option>
            </select>-->
           <div style=" float:left; width:100%; background: #fff; border: 1px solid #A1A1A1; border-radius:9px; margin:0 0 15px 0;">
               <?php 
                $categoryList= _getCategoryList();
                $businessCategories=_getBusinessCategoryArray($tmp_buss_id);
                if(empty($businessCategories))
                    $businessCategories[]='';?>
                
           <select name="userCategory[]" id="userCategory" multiple style="background:none; border:none; width:98%; padding: 0 2%; margin:2% 0">
                <?php
                foreach($categoryList as $key=>$val){?>
               <option value="<?php echo $key;?>" <?php if(in_array($key,$businessCategories)){?> selected="selected" <?php }?>><?php echo $val;?></option>
                <?php }
                ?>           
            </select>
             </div>
           <label>Tip: use Ctrl key to select multiple categories.</label>
             <?php echo form_error('userCategory[]');?>
           </div>
           <div class="pop-left-second">
    
           <label>Business License Number</label>
            <input name="buss_lice_num" id="buss_lice_num" type="text"value="<?php echo set_value('buss_lice_num',$tmp_buss_license_num); ?>">
             <?php echo form_error('buss_lice_num');?>
           </div>
           
           <div class="clear" style="margin-bottom: 10px;"></div>
            <div class="pop-left-first">
                <h4><img src="<?php echo USER_SIDE_IMAGES; ?>media.png"> &nbsp;Business License Certification </h4> 
               <div class="write-review3 sip">
                  <input type="button" class="custome_button red" value="UPLOAD DOCS"><input type="file" class="multi hide" name="license_docs[]" id="license_docs" accept="pdf|PDF|doc|DOC|docx|DOCx" maxlen="3"/>                   
                   <?php echo form_error('license_docs[]'); ?>
               </div>
           </div>
          
           <div class="pop-left-second">
               <h4><img src="<?php echo USER_SIDE_IMAGES; ?>media.png"> &nbsp;Upload Your Logo </h4> 
               <div class="write-review3 sip">
                  <input type="button" class="custome_button red" value="UPLOAD LOGO"><input type="file" class="multi hide" name="upload_logo" id="upload_logo" accept="jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP" maxlen="1"/>                   
                   <?php echo form_error('upload_logo'); ?>
               </div>
                <div style="float:left; margin-top: 0 auto;"> 
                       <label><span>Size : up-to 3mb, Dimension : up-to 1024 X 768 with extention:jpg,png </span></label>
                </div>
           </div>
           
           <div class="clear"></div>           
            <div class="pop-left-first">
               <br/><br/><h4><img src="<?php echo USER_SIDE_IMAGES; ?>media.png"> &nbsp;Upload Your Media copy</h4> 
               <div class="write-review3 sip">
                  <input type="button" class="custome_button red" value="UPLOAD PHOTO"><input type="file" class="multi hide" name="upload_photos[]" id="upload_photos" accept="jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP" maxlen="2"/>
                   <input type="hidden" name="buss_basic_photos" value="<?php echo $service_limits[3]['service_basic_limit']; ?>">
                   <?php echo form_error('upload_photos[]'); ?><p id="maxfileserror"></p>
                   
               </div>
               <div class="centeralign" style="float:left; margin-top: 0 auto;"> 
                       <label><span><?php if($service_limits[3]['service_basic_limit']=='0'){?>Unlimited <?php }else if($service_limits[3]['service_basic_limit']!=''){echo $service_limits[3]['service_basic_limit']." Max";}?></span></label>
                   </div>
           </div>
           
           <div class="pop-left-second">&nbsp;</div>
           
           <script>
               $(function(){
                   $("input[type='submit']").click(function(){
                       var input = document.getElementById('upload_photos');
                       if (parseInt(input.files.length)>2){                          
                           $('#maxfileserror').html('<span class=\"error\">You can only upload a maximum of 2 files</span>');                         
                       }
                       else
                           {
                               $('#maxfileserror').html('');
                           }
                   });    
               });
           </script>
           
           <div class="clear"></div><br>
            <div class="full">
          
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>social.png"> &nbsp; Social Media Channels</h4>
           <label>Please input your social media channels. </label>
           <br>

             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png"></div>
            <div class="pop-left-first-two">
                <input name="buss_sco_one" id="buss_sco_one" type="text"value="<?php echo set_value('buss_sco_one',$tmp_buss_social_media_channel_1); ?>">
                <?php echo form_error('buss_sco_one'); ?>
            </div>
            <div class="clear"></div>
             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png"></div>
            <div class="pop-left-first-two">
                <input name="buss_sco_two" id="buss_sco_two" type="text"value="<?php echo set_value('buss_sco_two',$tmp_buss_social_media_channel_2); ?>">
                <?php echo form_error('buss_sco_two'); ?>
            </div>
            <div class="clear"></div>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>&nbsp;</label><br>
            <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png"></div>
            <div class="pop-left-first-two">
                <input name="buss_sco_three" id="buss_sco_three" type="text"value="<?php echo set_value('buss_sco_three',$tmp_buss_social_media_channel_3); ?>">
                <?php echo form_error('buss_sco_three'); ?>
            </div>
             <div class="clear"></div>
              <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png"></div>
            <div class="pop-left-first-two">
                <input name="buss_sco_four" id="buss_sco_four" type="text"value="<?php echo set_value('buss_sco_four',$tmp_buss_social_media_channel_4); ?>">
                <?php echo form_error('buss_sco_four'); ?>
            </div>
             <div class="clear"></div>
           </div>
           <div class="clear"></div>      
           <div class="full2">
               <h4>
                   <img src="<?php echo USER_SIDE_IMAGES;?>payment.png">&nbsp; Payment Method 
                   <span class="im"><img src="<?php echo USER_SIDE_IMAGES;?>visa.png" style="padding-top:6.4px;" id="visaImg"/> </span>
                   <span class="pay">
                       <img src="<?php echo USER_SIDE_IMAGES;?>mestro-inactive.png"  id="mestroImg"/>
                       <img src="<?php echo USER_SIDE_IMAGES;?>american-inactive.png"  id="americanImg"/>
                       <!--<img src="<?php echo USER_SIDE_IMAGES;?>paypal-inactive.png" id="paypalImg"/>-->
                   </span>
               </h4>
               
           </div>           
           <div class="clear"></div>
           
                         <div class="form2" >
     <!--------------------------------------credit card--------------------------------------------------->             
           <div class="pop-left" id="basicCreditCardInfoDiv">
           <div class="pop-left-first">          
           <label>Name on card *</label>
           <input name="nameOnCard" id="nameOnCard"type="text"value="<?php echo set_value('nameOnCard');?>">
            <?php echo form_error('nameOnCard');?>        
           </div>
               <div class="pop-left-second rel-position">
           <label>Card Type * </label>
            <?php   $cardTypes=array(''=>'Select Type','visa'=>'VISA','mastercard'=>'MASTERCARD','amex'=>'AMERICAN EXPRESS','discover'=>'DISCOVER');
                                                $ct='id="cardType" class="items_custom"';
                                                echo form_dropdown('cardType', $cardTypes,set_value('cardType'),$ct);
                                            ?>
           <?php echo form_error('cardType');?>
           </div>
           <div class="clear"></div>
                      <div class="pop-left-first">
           <label>Card Number * </label>       
             <input name="c_card_num" id="c_card_num" type="text" value="<?php echo set_value('c_card_num');?>">  
            <?php echo form_error('c_card_num');?> 
           </div>
           <div class="pop-left-second">
           <label>Security Code * </label>
           <input name="c_secu_code" id="c_secu_code" type="text" value="<?php echo set_value('c_secu_code');?>">  
            <?php echo form_error('c_secu_code');?> 
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
           <label>Address Line 1 * </label>       
            <input name="c_address_1" id="c_address_1" type="text" value="<?php echo set_value('c_address_1');?>" >
             <?php echo form_error('c_address_1');?>
           </div>
           <div class="pop-left-second">
           <label>Address Line 2  </label>
            <input name="c_address_2" id="c_address_2" type="text" value="<?php echo set_value('c_address_2');?>" >
             <?php echo form_error('c_address_2');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>City * </label>
            <input name="c_city" id="c_city"type="text" value="<?php echo set_value('c_city');?>">
            <?php echo form_error('c_city');?>
           </div>
            <div class="pop-left-second">
          <label>Email </label>
            <input name="c_email" id="c_email" type="text"value="<?php echo set_value('c_email');?>">
             <?php echo form_error('c_email');?>
           </div>
         
           <div class="clear"></div>
           <div class="pop-left-first rel-position">
           <label>Country *</label>
           <?php 
           $xm='id="c_userCountry" class="items_custom"';
           echo form_dropdown('c_Items', _getCountryList(),set_value('c_Items','USA'),$xm);
           ?>
           <?php echo form_error('c_Items');?>
           </div>   
             <div class="pop-left-second">
     
           <label>State *</label>
           <?php 
           $xm='id="c_state" class="items_custom"';
           echo form_dropdown('c_state', _getStateListOnlyName(set_value('c_Items','USA')),set_value('c_state'),$xm);
           echo form_error('c_state');?>
           </div>
           
          
           <div class="clear"></div>
           
                      <div class="pop-left-first">  
           <label>Zip Code *</label>
            <input name="c_zip_code" id="c_zip_code"type="text"value="<?php echo set_value('c_zip_code');?>">
            <?php echo form_error('c_zip_code');?>
           </div>
           <div class="pop-left-second">     
           <label>CVV2 Number</label>
           <input name="c_cvv2_no" id="c_cvv2_no"type="text"value="<?php echo set_value('c_cvv2_no');?>">
            <?php echo form_error('c_cvv2_no');?>
           </div>
           
           <div class="clear"></div>
           
           
           <div class="pop-left-first">
  
           <label>Phone No</label>
            <input name="c_phone_no" id="c_phone_no"type="text"value="<?php echo set_value('c_phone_no');?>">
            <?php echo form_error('c_phone_no');?>
           </div>
           <div class="pop-left-second rel-position">
     
           <label>Expiration Date *</label>
           <div class="date">
          <?php 
                                                $xm='id="expiryMonth" class="items_custom"';
                                                echo form_dropdown('expiryMonth', _getMonths(),set_value('expiryMonth'),$xm);
                                            ?>
                         </div>
                     <div class="year">
                                           <?php 
                                                $xy='id="expiryYear" class="items_custom"';
                                                echo form_dropdown('expiryYear', _getExpiryYears(11),set_value('expiryYear'),$xy);
                                            ?>
                         </div>
                                           <?php echo form_error('expiryMonth');?>
                                           <?php echo form_error('expiryYear');?>
           </div>
           
           <div class="clear"></div>
          
           
           <div class="clear"></div>
           <div class="clear"></div><br>
            <div class="full">
          
           </div>          
          
           <div class="clear"></div>
           
           </div>
            
           <!--------------------------------------START PAYPAL BLOCK--------------------------------------------->
     <div class="pop-left" id="basicPaypalInfoDiv">           
           
            <div class="full">                
                <p>To pay through Paypal, you will be sent to the Paypal website to enter your billing information. When that is completed, you will be redirected back to our website to complete your registration process.</p>
           </div> 
            <div class="clear"></div>
            <div class="full"><br/><br/><br/><br/></div>          
            <div class="clear"></div>
    </div>
     <!--------------------------------------END PAYPAL BLOCK--------------------------------------------->
     <input type="hidden" name="basicHiddenPaymentType" id="basicHiddenPaymentType" value="<?php echo set_value('basicHiddenPaymentType','visaImg');?>"/>
      <script>
               $('#visaImg,#mestroImg,#americanImg').click(function(){                   
                   $('#basicCreditCardInfoDiv').show('slow');  
                   $('#basicPaypalInfoDiv').hide('slow');                     
                   changeCardImages($(this).attr('id'));
                });
                
                $('#paypalImg').click(function(){
                    $('#basicCreditCardInfoDiv').hide('slow');  
                    $('#basicPaypalInfoDiv').show('slow');  
                    changeCardImages($(this).attr('id'));
                });
                
                var basicHiddenPaymentType = $('#basicHiddenPaymentType').val();
                if(basicHiddenPaymentType!="")
                {
                    $('#'+basicHiddenPaymentType).click();
                    //alert($('#basicHiddenPaymentType').val());
                }    
                
                function changeCardImages(imgId)
                {
                    var imgArray={"visaImg":"visa.png","mestroImg":"mestro.png","americanImg":"american.png","paypalImg":"paypal.png"};
                    var imgPath="<?php echo USER_SIDE_IMAGES;?>";
                    $('#visaImg').attr('src',imgPath+'visa-inactive.png');
                    $('#mestroImg').attr('src',imgPath+'mestro-inactive.png');
                    $('#americanImg').attr('src',imgPath+'american-inactive.png');
                    $('#paypalImg').attr('src',imgPath+'paypal-inactive.png');
                    $('#'+imgId).attr('src',imgPath+imgArray[imgId]);
                    $('#basicHiddenPaymentType').val(imgId);                    
                }
               </script>
     
                      
                        
           </div>
           <div class="clear" style="height:20px;"></div>
           </div>
           <div class="pop-right rel-position pad-bottom"><h4><h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
             <?php 
           $subsPlanArray=array('bm'=>$basic_plan_monthly_name,'ba'=>$basic_plan_annual_name);
           $st='id="b_acc_type" class="items_custom"';
           echo form_dropdown('b_acc_type', $subsPlanArray,set_value('b_acc_type'),$st);
           echo form_error('b_acc_type');
           ?>
            <div class="full3"><h4><img src="<?php echo USER_SIDE_IMAGES;?>plan-details.png"> &nbsp; Plan Details</h4>
            <ul>
<?php foreach($service_limits as $key=>$val)
  {?>
    
    <?php if($val['service_basic_status']=='A'){?>
        <li><?php echo $val['service_name'];?>
        <?php
        if($val['service_basic_limit']=='0')
            {?>
            <?php            
            }
            else if($val['service_basic_limit']!=''){?>
                <?php echo "|".$val['service_basic_limit']." Max";}?></li>
        <?php }}?> 
            </ul>
            </div>
         <h4><img src="<?php echo USER_SIDE_IMAGES;?>search2.png"> &nbsp; Got a promo code?</h4>
            <!--<input name="" type="text" value=""> -->
            
                        <input type="text" name="b_promocode" id="b_promocode" value=""><span id="b_pro_code_err"></span>
            
            <script>

                /*check if entered promo code is valid/invalid/expired */
		$("#b_promocode").keyup(function(){		
			var b_promo_code = $("#b_promocode").val();
                        var b_plan_sub_type=$("#b_acc_type").val();                                              
                        var b_plan_price=$('#b_price').text();
                        
                        var e = document.getElementById("b_acc_type");
                        var acc_type = e.options[e.selectedIndex].value;                        
                        
                        //get actual price
                        var bactualPrice="";
                        if(acc_type=="bm")
                            bactualPrice="<?php echo $basic_plan_monthly_price; ?>";
                        else
                            bactualPrice="<?php echo $basic_plan_annual_price; ?>";
                        
			if(b_promo_code!="")
			{
				$.ajax({
				url: '<?php echo base_url()?>change_price_by_promocode/check_promocode',
				type: 'post',                                                               
				data: 'pro_code='+b_promo_code+'&plan_type='+b_plan_sub_type+'&plan_price='+b_plan_price,
				success: function(data){
                                                                                                 var n=data.split(",");
						if(data == "inactive")
						{
							$("#b_pro_code_err").addClass("error");
							$("#b_pro_code_err").html("This code is expired.");
                                                        $('#b_price').html(bactualPrice);
							return false; 
						}
						else if(data == "invalid")
						{
							$("#b_pro_code_err").addClass("error");
							$("#b_pro_code_err").html("This code is invalid.");
                                                        $('#b_price').html(bactualPrice);
							return false; 
						}
						else if(n[0] == "active")
						{               
							$("#b_pro_code_err").html("");
                                                        $('#b_price').html(n[1]);
                                                        
						}
					},
				}); 
			}
			else
			{
                           $('#b_price').html(bactualPrice);
                           $("#b_pro_code_err").html("");
			}
			
		});
            </script>
            
            
             <div class="full3">
              <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment-details.png"> &nbsp; Payment Details</h4>
             
                
             <span class="price"><span class="super1">$</span> &nbsp;<span id="b_price"><?php echo $basic_plan_monthly_price;?></span><span class="super2">*</span></span> 
             </div>
            <br><br>
            
                <div class="pop-right">  
                   <div class="clear"></div> 
                   <div class="link-orange">
                       <a href="void(0)" onClick="JavaScript: return newPopup('<?php echo base_url()?>services/terms_and_condition');">READ  FULL TERMS & CONDITIONS</a> 
                   </div>
                   <label> <input id="basicTerms" name="buss_cond" type="checkbox" required> &nbsp;I agree to terms & conditions</label>
                   <br>
                    <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" id="basicSubmit" onClick="javascript: $('#submitbtn13').click();">SUBMIT</a><br>
                     <input  style="display:none;" name="submitbtn13" id="submitbtn13" value="SUBMIT"  type="submit"/>

                    <br><br>
                </div> 
            
                </div>
           </form>
        
     
           </div>
                        
               </div>
            </div>
            </div>
            <!--/*======================== step2 end*=====================================/-->
            
    
    </div>    </td>
    <td>
    <div class="l-p">
        $<?php echo $prem_plan_annual_price;?> <br><h2><?php echo $prem_plan_annual_name;?></h2>
    </div>
     <div class="r-p">
   $<?php echo $prem_plan_monthly_price;?> <h2><?php echo $prem_plan_monthly_name;?></h2>  
    </div>
    <div class="clear"></div>
    <div class="green-btn">
        <?php if($this->session->userdata('claimRequestedUserId') == ''){ ?>
        <a href="#address12" id="address_pop" class="button6 green" onclick="javascript: $('#back-top a').click();">SIGN UP</a>   
        <?php }else{?>
     <a href="#address13" id="address_pop" class="button6 green" onclick="javascript: $('#back-top a').click();">SIGN UP</a>    
            <?php }?>
    <!--/*======================== popup2 start*=====================================/-->
<!----------------step1------------->
           <div>
            <a href="#" class="overlay" id="address12"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop newht" align="center">   
            
            <h1><?php echo $prem_plan_name;?> Plan </h1>
           <h2> You are on step 1 out of 2 </h2>
              <div class="form2">
              
         <?php
        $attributes = array('name' => 'frmSignup_prem', 'id' => 'frmSignup_prem', 'method' => 'post');
        //echo form_open('services/submitForm_basic', $attributes);
         echo form_open('claim/registeration/prem/1#address12', $attributes);
        
        ?>
           <div class="pop-left fullwdth">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Create your username</h4>
           <label>Username <span>(alphanumeric, no more than 32 characters)</span></label>
           <input name="p_username" id="p_username" type="text" value="<?php echo set_value('p_username',$user_info_array['user_name']);?>">
           <?php echo form_error('p_username');?>
           </div>
           <div class="pop-left-second">
            <h4><img src="<?php echo USER_SIDE_IMAGES;?>passsword.png"> &nbsp; Choose a password</h4>
            <label>Password *</label>
          <input name="p_user_password" id="p_user_password" type="password" value="<?php echo set_value('p_user_password'); ?>">
             <?php echo form_error('p_user_password');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
          
           <label>Business Contact Email * <span>(we won't spam you!)</span></label>
            <input name="p_user_email" id="p_user_email" type="text" value="<?php echo set_value('p_user_email',$user_info_array['user_email']);?>">
          <?php echo form_error('p_user_email');?>
           </div>
           <div class="pop-left-second">
           
           <label>Repeat * <span>(for confirmation) </span></label>
            <input name="p_cpassword" id="p_cpassword" type="password" value="<?php echo set_value('p_cpassword'); ?>">
              <?php echo form_error('p_cpassword');?>
           </div>
           <div class="clear"></div>
           <div class="full">
           <label> <input name="p_email_announc" type="checkbox" value="1"> &nbsp;Receive important email announcements from Word of Mouth Referral</label>
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>user.png"> &nbsp; Your Information</h4>
           <label>First Name *</label>
           <input name="p_fname" id="p_fname" type="text" value="<?php echo set_value('p_fname',$user_info_array['user_fname']);?>">
             <?php echo form_error('p_fname');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Last Name *</label>
             <input name="p_lname" id="p_lname" type="text" value="<?php echo set_value('p_lname',$user_info_array['user_lname']);?>">
           <?php echo form_error('p_lname');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>Address *  </label>
             <input name="p_address" id="p_address" type="text" value="<?php echo set_value('p_address',$user_info_array['user_address']);?>">
            <?php echo form_error('p_address');?>
           </div>
           <div class="pop-left-second">
     
           <label>Address add on</label>
                <input name="p_addr_addon" id="p_addr_addon"type="text" value="<?php echo set_value('p_addr_addon',$user_info_array['user_address_addon']);?>">
                <?php echo form_error('p_addr_addon');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Zip code *</label>
             <input name="p_zip_code" id="p_zip_code"type="text" value="<?php echo set_value('p_zip_code',$user_info_array['user_zipcode']);?>">
             <?php echo form_error('p_zip_code');?>
           </div>
           <div class="pop-left-second">
      
           <label>City *</label>
             <input name="p_city" id="p_city"type="text" value="<?php echo set_value('p_city',$user_info_array['user_city']);?>">
          <?php echo form_error('p_city');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first rel-position">
    
           <label>Country *</label>
            <select name="p_Items" id="p_userCountry" class="items_custom">
               <?php
                                        $countryList = _getCountryList();    
                                         if ($user_info_array['user_country'])
                                            {
                                                foreach ($countryList as $key => $val)
                                                {
                                                    if ($key == $user_info_array['user_country'])
                                                    {
                                                        ?>
                                                    <option value="<?php echo $key; ?>" selected><?php echo $val; ?></option> 
                                                    <?php
                                                    }
                                                    else
                                                    {
                                                        echo '<option value="' . $key . '">' . $val . ' </option> ';
                                                    }
                                                }
                                            }
                                            else
                                            { 
                                                foreach ($countryList as $key => $val)
                                                {
                                              ?>                                           
                                            <option value="<?php echo $key; ?>" <?php if($key=="USA"){?> selected <?php }?>><?php echo $val; ?></option>                                            
                                        <?php }} ?>
            <!--option value="">Select</option>
             <option>United States</option>
              <option>United States</option -->
            </select>
           </div>
           <div class="pop-left-second rel-position">
    
           <label>State *</label>
          <div id="p_stateHolder">
            <?php 
                           // $st='id="userState" class="items"';//stateHolder
                            //echo form_dropdown('userState', _getStateList(),set_value('userState'),$st);                            
                        ?>   
               <select name="p_userState" id="p_userState" class="items_custom">
            <option>Choose your state</option>
            </select>
              <?php echo form_error('p_userState');?>
           </div>  
            </div>
           <div class="cancel-sec"><span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" onClick="javascript: $('#submitbtn14').click();">CLICK TO STEP 2</a><br>
            <input  style="display:none;" name="submitbtn14" id="submitbtn14" value="PROCEED TO STEP 2"  type="submit"/></div>
           <div class="clear"></div>
           <div class="clear"></div>
            <p>&nbsp;</p>
                <p>&nbsp;</p>  <p>&nbsp;</p>
            <p>&nbsp;</p>
                <p>&nbsp;</p>  <p>&nbsp;</p>
            <p>&nbsp;</p>
                <p>&nbsp;</p>  <p>&nbsp;</p>           
           </div>            
                </div>               
           </form>
           </div>
                        
               </div>
            </div>
            </div>
            
             <div>
            <a href="#" class="overlay" id="address13"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
                          <!-- Remove this after email starts -->
            <?php  //if ($this->session->userdata('activation_url') != ''){?>
                <!--h5>Account Activation Link : <?php echo $this->session->userdata('activation_url');?></h5-->
                <?php //}?>
            
            <h1>Premium Plan </h1>
           <h2> You are on step 2 out of 2 </h2>
            <?php if($p_error!=''){?>
           <br/><?php /*?><h2><?php echo $p_error;?></h2><?php */?>
           <span class="h2-error"><?php echo $p_error;?></span>
           <?php }?>
              <div class="form2">
               <!--------------------------------------step2--------------------------------------------------->
              <?php
        $attributes = array('name' => 'frmSignup_buss_prem', 'id' => 'frmSignup_buss_prem', 'method' => 'post');
        echo form_open_multipart('claim/registeration/prem/2#address13', $attributes);
        ?>
           <div class="pop-left">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Business Name</h4>
           <label>Name *<span>(alphanumeric, no more than 32 characters)</span></label>
            <input name="p_buss_name" id="p_buss_name"type="text" value="<?php echo set_value('p_buss_name',$tmp_buss_name); ?>">
            <?php echo form_error('p_buss_name');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Contact Name</label>
            <input name="p_buss_cont_name" id="p_buss_cont_name"type="text" value="<?php echo set_value('p_buss_cont_name',$tmp_buss_cont_name); ?>">
            <?php echo form_error('p_buss_cont_name');?>
           </div>
           <div class="clear"></div>
                     <div class="full">
          
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>home2.png"> &nbsp; Business Details</h4>
           <label>Address * </label>
            <input name="p_buss_addr" id="p_buss_addr" type="text" value="<?php echo set_value('p_buss_addr',$tmp_buss_address); ?>">
             <?php echo form_error('p_buss_addr');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Address add on</label>
           <input name="p_buss_addr_addon" id="p_buss_addr_addon" type="text" value="<?php echo set_value('p_buss_addr_addon',$tmp_buss_addr_addon); ?>">
            <?php echo form_error('p_buss_addr_addon');?>
           </div>
           <div class="clear"></div>
           
           <div class="pop-left-first">
           <label>Country * </label>
            <?php 
                $st='id="p_buss_country" class="items_custom"';                
                echo form_dropdown('p_buss_country', _getCountryList(),set_value('p_buss_country',$tmp_buss_country),$st);
              ?>
            <?php echo form_error('p_buss_country');?>
           </div>
           
           <div class="pop-left-second">
           <label>State *</label>
            <?php 
                $selectedBussCountry=set_value('p_buss_country',$tmp_buss_country);//get selected country value that is country code
                $st='id="p_buss_state" class="items_custom"';
                echo form_dropdown('p_buss_state', _getStateList($selectedBussCountry),set_value('p_buss_state',$tmp_buss_state),$st);
              ?>
               <?php echo form_error('p_buss_state');?>
           </div>
           <div class="clear"></div>
           
           <div class="pop-left-first">
           <label>City * </label>
             <input name="p_buss_city" id="p_buss_city"type="text"value="<?php echo set_value('p_buss_city',$tmp_buss_city); ?>"/>
            <?php echo form_error('p_buss_city');?>
           </div>
           <div class="pop-left-second">
     
           <label>Zip code *</label>
            <input name="p_buss_zipcode" id="p_buss_zipcode"type="text"value="<?php echo set_value('p_buss_zipcode',$tmp_buss_zip_code); ?>"/>
               <?php echo form_error('p_buss_zipcode');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Phone *</label>
            <input name="p_buss_phone" id="p_buss_phone"type="text"value="<?php echo set_value('p_buss_phone',$tmp_buss_phone); ?>"/>
              <?php echo form_error('p_buss_phone');?>
           </div>
           <div class="pop-left-second">
      
           <label>Fax</label>
            <input name="p_buss_fax" id="p_buss_fax"type="text"value="<?php echo set_value('p_buss_fax',$tmp_buss_fax); ?>"/>
             <?php echo form_error('p_buss_fax');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Web Address</label>
              <input name="p_buss_web_addr" id="p_buss_web_addr" type="text" value="<?php if($tmp_buss_web_address){echo set_value('p_buss_web_addr',$tmp_buss_web_address);}else echo 'http://';?>"/>
            <?php echo form_error('p_buss_web_addr');?>
           </div>
           <div class="pop-left-second">
      
           <label>Contact Email Address *</label>
             <input name="p_buss_email_addr" id="p_buss_email_addr" type="text"value="<?php echo set_value('p_buss_email_addr',$tmp_buss_email); ?>"/>
             <?php echo form_error('p_buss_email_addr');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first rel-position">
    
           <label>Business Category *</label>
            <!--<select name="" class="items">
            <option>Monthly</option>
            <option>Annual</option>
            </select>-->
           <div style=" float:left; width:100%; background: #fff; border: 1px solid #A1A1A1; border-radius:9px; margin:0 0 15px 0;">
           <?php 
           $categoryList= _getCategoryList();
                $businessCategories=_getBusinessCategoryArray($tmp_buss_id);
                if(empty($businessCategories))
                    $businessCategories[]='';
                ?>
            <select name="p_userCategory[]" id="p_userCategory" multiple style="background:none; border:none; width:98%; padding: 0 2%; margin:2% 0">
                <?php 
                
                foreach($categoryList as $key=>$val){?>
                    <option value="<?php echo $key;?>" <?php if(in_array($key,$businessCategories)){?> selected="selected" <?php }?>><?php echo $val;?></option>
                <?php }
                ?>           
            </select>
           </div>
            <?php echo form_error('p_userCategory[]');?>
           </div>
           <div class="pop-left-second">
    
           <label>Business License Number</label>
             <input name="p_buss_lice_num" id="p_buss_lice_num" type="text" value="<?php echo set_value('p_buss_lice_num',$tmp_buss_license_num); ?>"/>
             <?php echo form_error('p_buss_lice_num');?>
           </div>
           <div class="clear"></div>
           
           <div class="clear" style="margin-bottom: 10px;"></div>
            <div class="pop-left-first">
                <h4><img src="<?php echo USER_SIDE_IMAGES;?>lic.png"> &nbsp;Business License Certification </h4> 
                <div class="write-review3 sip">
                  <input type="button" class="custome_button red" value="UPLOAD DOCS"><input type="file" class="multi hide" name="p_license_docs[]" id="p_license_docs" accept="pdf|PDF|doc|DOC|docx|DOCx" maxlen="3"/>                   
                   <?php echo form_error('p_license_docs[]'); ?>
               </div>
           </div>
           
           
           <div class="pop-left-second">
               <h4><img src="<?php echo USER_SIDE_IMAGES; ?>media.png"> &nbsp;Upload Your Logo </h4> 
               <div class="write-review3 sip">
                  <input type="button" class="custome_button red" value="UPLOAD LOGO"><input type="file" class="multi hide" name="p_upload_logo" id="p_upload_logo" accept="jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP" maxlen="1"/>                   
                   <?php echo form_error('p_upload_logo'); ?>
               </div>
                <div style="float:left; margin-top: 0 auto;"> 
                       <label><span>Size : up-to 3mb, Dimension : up-to 1024 X 768 with extention:jpg,png </span></label>
                </div>
           </div>
           <div class="clear"></div>
           
              <div class="pop-left-first">
              <br/> <h4><img src="<?php echo USER_SIDE_IMAGES; ?>media.png"> &nbsp;Upload Your Media copy</h4> 
              <div class="write-review3 sip">
                  <input type="button" class="custome_button red" value="UPLOAD PHOTO"><input type="file" class="multi hide" name="p_upload_photos[]" id="p_upload_photos" accept="jpg|JPG|jpeg|JPEG|png|PNG|gif|GIF|bmp|BMP" maxlen="<?php echo ($service_limits[3]['service_premium_limit']=='0' ? '5':$service_limits[3]['service_premium_limit']);?>"/>                   
                   <input type="hidden" name="p_buss_prem_photos" value="<?php echo $service_limits[3]['service_premium_limit']; ?>">
                    <?php echo form_error('p_upload_photos[]'); ?>
               </div>
              <div class="centeralign"> <label> <span><?php if($service_limits[3]['service_premium_limit']=='0'){?>Unlimited <?php }else if($service_limits[3]['service_premium_limit']!=''){echo $service_limits[3]['service_premium_limit']." Max";}?></span></label></div>              
           </div>
           
           <div class="pop-left-second">
               <br/><h4><img src="<?php echo USER_SIDE_IMAGES; ?>media.png"> &nbsp;Upload Video </h4>
               <div style="float:left; margin-top: 0 auto;"> 
                       <label><span>You can upload videos for your business from dashboard</span></label>
                </div>
           </div>
           <div class="clear"></div><br/>
           
            <div class="full2">
          <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>add-info.png"> &nbsp; Additional Information</h4>
          <label> <input name="comp_quot" type="checkbox" value="1"> &nbsp;Click to receive competitive quotes</label>
           <input name="addition_email" type="text" value="<?php echo set_value('addition_email','(Enter Your Email Address)'); ?>"  onFocus="if(this.value=='(Enter Your Email Address)')this.value=''" onBlur="if(this.value=='')this.value='(Enter Your Email Address)'"/>
           <?php echo form_error('addition_email'); ?> 
          </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
            <label> <input name="mon_d_and_s" type="checkbox" value="1" <?php echo set_checkbox('mon_d_and_s', '1'); ?>/> &nbsp;Click to submit monthly deals & specials</label>
           <label> <input name="we_r_hir" type="checkbox" value="1" <?php echo set_checkbox('we_r_hir', '1'); ?>/> &nbsp;We’re Hiring</label>
           </div>
           <div class="clear"></div>
           </div>
             <div class="full2">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>social.png"> &nbsp; Social Media Channels</h4>
           <label>Please input your social media channels. </label>
           <br>
             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png"></div>
            <div class="pop-left-first-two">
                <input name="p_buss_sco_one" id="p_buss_sco_one" type="text" value="<?php echo set_value('p_buss_sco_one',$tmp_buss_social_media_channel_1); ?>"/>
                <?php echo form_error('p_buss_sco_one'); ?>
            </div>
            <div class="clear"></div>
             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png"></div>
            <div class="pop-left-first-two">
                <input name="p_buss_sco_two" id="p_buss_sco_two" type="text" value="<?php echo set_value('p_buss_sco_two',$tmp_buss_social_media_channel_2); ?>"/>
                <?php echo form_error('p_buss_sco_two'); ?>
            </div>
            <div class="clear"></div>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>&nbsp;</label><br>
            <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png"></div>
            <div class="pop-left-first-two">
                <input name="p_buss_sco_three" id="p_buss_sco_three" type="text" value="<?php echo set_value('p_buss_sco_three',$tmp_buss_social_media_channel_3); ?>"/>
            <?php echo form_error('p_buss_sco_three'); ?>
            </div>
             <div class="clear"></div>
              <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png"></div>
            <div class="pop-left-first-two">
                <input name="p_buss_sco_four" id="p_buss_sco_four" type="text" value="<?php echo set_value('p_buss_sco_four',$tmp_buss_social_media_channel_4); ?>"/>
                <?php echo form_error('p_buss_sco_four'); ?>
            </div>
             <div class="clear"></div>
           </div>
           <div class="clear"></div>
           <div class="full2">
               <h4>
                   <img src="<?php echo USER_SIDE_IMAGES;?>payment.png">&nbsp; Payment Method 
                   <span class="im"><img src="<?php echo USER_SIDE_IMAGES;?>visa.png" id="p_show_form" style="padding-top:6.4px;"> </span>
                   <span class="pay">
                       <img src="<?php echo USER_SIDE_IMAGES;?>mestro.png"  id="p_show_form1">
                       <img src="<?php echo USER_SIDE_IMAGES;?>american.png"  id="p_show_form2">
                       <!--<img src="<?php echo USER_SIDE_IMAGES;?>paypal.png" id="p_show_form3">-->
                   </span>
               </h4>
           </div>           
           <div class="clear"></div>
           <script>/*
               $('#p_show_form,#p_show_form1,#p_show_form2').click(function() {
                   $('#p_myDiv').toggle('slow', function() {
                       // Animation complete.
                   });
               });*/
           </script>
           </div>
                                    <div class="form2" id="p_myDiv">
     <!--------------------------------------credit card--------------------------------------------------->             
           <div class="pop-left" style="padding-bottom: 70px;">
           <div class="pop-left-first">          
           <label>Name on card *</label>
           <input name="p_nameOnCard" id="p_nameOnCard"type="text"value="<?php echo set_value('p_nameOnCard');?>">
            <?php echo form_error('p_nameOnCard');?>        
           </div>
            <div class="pop-left-second rel-position">
           <label>Card Type * </label>
            <?php   $cardTypes=array(''=>'Select Type','visa'=>'VISA','mastercard'=>'MASTERCARD','amex'=>'AMERICAN EXPRESS','discover'=>'DISCOVER');
                                                $ct='id="p_cardType" class="items_custom"';
                                                echo form_dropdown('p_cardType', $cardTypes,set_value('p_cardType'),$ct);
                                            ?>
           <?php echo form_error('p_cardType');?>
           </div>
           <div class="clear"></div>
                      <div class="pop-left-first">
           <label>Card Number * </label>       
             <input name="p_c_card_num" id="p_c_card_num" type="text" value="<?php echo set_value('p_c_card_num');?>">  
            <?php echo form_error('p_c_card_num');?> 
           </div>
           <div class="pop-left-second">
           <label>Security Code * </label>
            <input name="p_c_secu_code" id="p_c_secu_code" type="text" value="<?php echo set_value('p_c_secu_code');?>">  
            <?php echo form_error('p_c_secu_code');?> 
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
           <label>Address Line 1 * </label>       
            <input name="p_c_address_1" id="p_c_address_1" type="text" value="<?php echo set_value('p_c_address_1');?>" >
             <?php echo form_error('p_c_address_1');?>
           </div>
           <div class="pop-left-second">
           <label>Address Line 2 </label>
            <input name="p_c_address_2" id="p_c_address_2" type="text" value="<?php echo set_value('p_c_address_2');?>" >
             <?php echo form_error('p_c_address_2');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>City * </label>
            <input name="p_c_city" id="p_c_city"type="text" value="<?php echo set_value('p_c_city');?>">
            <?php echo form_error('p_c_city');?>
           </div>
           <div class="pop-left-second">
          <label>Email </label>
            <input name="p_c_email" id="p_c_email" type="text"value="<?php echo set_value('p_c_email');?>">
             <?php echo form_error('p_c_email');?>
           </div>
           <div class="clear"></div>
           
           
           <div class="pop-left-first rel-position">
           <label>Country *</label>
           <?php 
           $xm='id="p_c_userCountry" class="items_custom"';
           echo form_dropdown('p_c_Items', _getCountryList(),set_value('c_Items','USA'),$xm);
           ?>
           
           <?php echo form_error('p_c_Items');?>
           </div>
           <div class="pop-left-second">
     
           <label>State *</label>
            <?php 
           $xm='id="p_c_state" class="items_custom"';
           echo form_dropdown('p_c_state', _getStateListOnlyName(set_value('p_c_Items','USA')),set_value('p_c_state'),$xm);
           echo form_error('p_c_state');?>
           </div>
           
           <div class="clear"></div>
           
                                 <div class="pop-left-first">  
           <label>Zip Code *</label>
            <input name="p_c_zip_code" id="p_c_zip_code" type="text" value="<?php echo set_value('p_c_zip_code');?>">
            <?php echo form_error('p_c_zip_code');?>
           </div>
           <div class="pop-left-second">     
           <label>CVV2 Number</label>
           <input name="p_c_cvv2_no" id="p_c_cvv2_no" type="text" value="<?php echo set_value('p_c_cvv2_no');?>">
            <?php echo form_error('p_c_cvv2_no');?>
           </div>
           
           <div class="clear"></div>
           
           
           <div class="pop-left-first">
  
           <label>Phone No </label>
            <input name="p_c_phone_no" id="p_c_phone_no" type="text" value="<?php echo set_value('p_c_phone_no');?>">
            <?php echo form_error('p_c_phone_no');?>
           </div>
            <div class="pop-left-second rel-position">
     
           <label>Expiration Date *</label>
           <div class="date">
          <?php 
                $xm='id="p_expiryMonth" class="items_custom"';
                echo form_dropdown('p_expiryMonth', _getMonths(),set_value('p_expiryMonth'),$xm);
            ?>
            </div>
            <div class="year">
           <?php 
                $xy='id="p_expiryYear" class="items_custom"';
                echo form_dropdown('p_expiryYear', _getExpiryYears(11),set_value('p_expiryYear'),$xy);
            ?>
            </div>
           <?php echo form_error('p_expiryMonth');?>
           <?php echo form_error('p_expiryYear');?>
           </div>
           
           <div class="clear"></div>
          
           
           <div class="clear"></div>
           <div class="clear"></div><br>
            <div class="full">
          
           </div>          
          
           <div class="clear"></div>
           
           </div>
     
                          
           </div>
           </div>
           <div class="pop-right rel-position pad-bottom">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
           <?php 
           $subsPlanArray=array('pm'=>$prem_plan_monthly_name,'pa'=>$prem_plan_annual_name);
           $st='id="p_acc_type1" class="items_custom"';
           echo form_dropdown('p_acc_type1', $subsPlanArray,set_value('p_acc_type1'),$st);
           echo form_error('p_acc_type1');
           ?>       
            <div class="full3"><h4><img src="<?php echo USER_SIDE_IMAGES;?>plan-details.png"> &nbsp; Plan Details</h4>
            <ul>
             <?php foreach($service_limits as $key=>$val)
  {?>
    
    <?php if($val['service_premium_status']=='A'){?>
        <li><?php echo $val['service_name'];?>
        <?php
        if($val['service_premium_limit']=='0')
            {echo "|Unlimited";?>
            <?php            
            }
            else if($val['service_premium_limit']!=''){?>
                <?php echo "|".$val['service_basic_limit']." Max";}?></li>
        <?php }}?>
            </ul>
            </div>
         <h4><img src="<?php echo USER_SIDE_IMAGES;?>search2.png"> &nbsp; Got a promo code?</h4>
            <!--<input name="" type="text" value="">   -->
            
                         <input type="text" name="p_promocode1" id="p_promocode1" value=""><span id="p_pro_code_err1"></span>
           <script>

                /*check if entered promo code is valid/invalid/expired */
		$("#p_promocode1").keyup(function(){		
			var p_promo_code1 = $("#p_promocode1").val();
                        var p_plan_sub_type1=$("#p_acc_type1").val();                                              
                        var p_plan_price1=$('#p_price2').text();   
                        
                        var e = document.getElementById("p_acc_type1");
                        var acc_type = e.options[e.selectedIndex].value;  
                        //get actual price
                        var actualPrice='';
                        if(acc_type=="pm")
                            actualPrice='<?php echo $prem_plan_monthly_price; ?>';
                        else
                            actualPrice='<?php echo $prem_plan_annual_price; ?>';
                                                
			if(p_promo_code1 != '')
			{
				$.ajax({
				url: '<?php echo base_url()?>change_price_by_promocode/check_promocode_p',
				type: 'post',                                                               
				data: 'pro_code='+p_promo_code1+'&plan_type='+p_plan_sub_type1+'&plan_price='+p_plan_price1,
				success: function(data){
                                                                                                 var n=data.split(",");
						if(data == "inactive")
						{
							$("#p_pro_code_err1").addClass("error");
							$("#p_pro_code_err1").html("This code is expired.");
                                                        $('#p_price2').html(actualPrice);
							return false; 
						}
						else if(data == "invalid")
						{
							$("#p_pro_code_err1").addClass("error");
							$("#p_pro_code_err1").html("This code is invalid.");
                                                        $('#p_price2').html(actualPrice);
							return false; 
						}
						else if(n[0] == "active")
						{               
                                                    $("#p_pro_code_err1").html("");
                                                    $('#p_price2').html(n[1]);
                                                        
						}
					}
				}); 
			}
			else
			{
                            $('#p_price2').html(actualPrice);                        
                            $("#p_pro_code_err1").html("");
			}
			
		});
            </script>
            
             <div class="full3">
              <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment-details.png"> &nbsp; Payment Details</h4>
             
                
             <span class="price"><span class="super1">$</span> &nbsp;<span id="p_price2"><?php echo $prem_plan_monthly_price;?></span><span class="super2">*</span></span> 
             </div>
             
            <br><br>
            
                <div class="pop-right">            
                       <div class="clear"></div>
                       <div class="link-orange">
                           <a href="void(0)" onClick="JavaScript: return newPopup('<?php echo base_url()?>services/terms_and_condition');">READ  FULL TERMS & CONDITIONS</a> 
                       </div>     
                       <label> <input name="p_buss_cond" type="checkbox" required> &nbsp;I agree to terms & conditions</label>
                       <br>
                        <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" onClick="javascript: $('#submitbtn15').click();">SUBMIT</a><br>
                         <input  style="display:none;" name="submitbtn15" id="submitbtn15" value="SUBMIT"  type="submit"/>
                        <br><br>
                    </div>
            
                </div>
                
              
           
           </form>
             
          
           </div>
                        
               </div>
            </div>
            </div>
            <!--/*======================== popup2 end=====================================/-->    </div>    </td>
  </tr>
</table>
        </div>
        </section>
      </div>
    </div>
    
    <!--footer start from here-->
    <footer>
      <div class="footer-in"><div class="links">
          <h2>Quick Links</h2>
          <ul>
           <li><a href="<?php echo base_url()?>home/">» Home</a></li>
            <li><a href="<?php echo base_url()?>aboutus/">» About Us</a></li>
            <li><a href="<?php echo base_url()?>how_it_works/">» How it Works</a></li>
            <li><a href="<?php echo base_url()?>services/">» Our Services</a></li>
            <li><a href="<?php echo base_url()?>deals_and_coupons/">» Deals & Coupons</a></li>
            <li><a href="<?php echo base_url()?>we_are_hiring/">»  We’re Hiring</a></li>
            <li><a href="<?php echo base_url()?>faq/">» FAQ</a></li>
            <li><a href="<?php echo base_url()?>contact_us/">» Contact Us</a></li>
          </ul>
        </div>
        <div class="line1"></div>
        <div class="videos">
          <h2>Some of Our Videos</h2>
          <ul>
           <?php $footerVideos=_getFooterVideos();?>
             <?php foreach($footerVideos as $key=>$val){?>
            <li>
              <div class="promo">
                  <a onClick="playFooterVideo('myFooterVideoModal_<?php echo $key;?>')" href="#" data-reveal-id="myFooterVideoModal_<?php echo $key;?>"><img src="<?php echo SITE_ROOT_FOR_USER.'sitedata/footer_videos_images/'.$val['fvImage'];?>" alt="video"></a>
                  <p><span><?php echo $val['fvTitle'];?></span><br/><?php echo $val['fvDescription'];?></p>
              </div>
              <div class="dating">
                <!--<div class="calendar"><?php echo substr($val['fvUpdatedOn'],0,10);?></div>-->
                <a href="<?php echo prep_url($val['fvReadMoreLink']);?>" class="button orange" style="width:85px;" target="_blanck">Read More</a></div>
              <div class="clear"></div>
            </li>
            <?php }?>
          </ul>
        </div>
        <div class="line1"></div>
        <div class="stay">
          <h2>Stay Connected</h2>
          <div class="bottom-logo"><img src="<?php echo USER_SIDE_IMAGES;?>logo-bottom.png" alt="logo"></div>
          <?php $footerRightContent=_getFooterRightContent();?>
          <div class="afew"><span><?php echo $footerRightContent[0]['pageHeading'];?></span><br/><?php echo $footerRightContent[0]['pageContent'];?></div>
          <div class="social1">
            <ul>
              <li><a href="https://twitter.com/WOMReferral" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>twitt1.png" alt="twitter"/></a></li>
              <li><a href="https://www.facebook.com/WordOfMouthReferral" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>facebook1.png" alt="facebook"/></a></li>
              <li><a href="http://www.pinterest.com/mouthreferral/"><img src="<?php echo USER_SIDE_IMAGES;?>printrest1.png" alt="printrest"/></a></li>
              <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>linked-in1.png" alt="linked-in"/></a></li>
              <li><a href="http://www.youtube.com/channel/UChsAXAMLDVAewzhrAdevQ-w"><img src="<?php echo USER_SIDE_IMAGES;?>YouTube.png" alt="youtube" height="25"/></a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <div class="copy">© 2013 Word of Mouth, Inc. All rights reserved.</div>
           <div class="mail"><a href="mailto:info@wordofmouth.com" target="_top">info@wordofmouth.com</a></div>
          <div class="phone"><?php echo _getHeaderPhoneNo();?></div>
        </div>
      </div>
    </footer>
  </div>
  <div class="clear"></div>
</div>

!--lightbox vidfeo player appearing from here-->
<?php foreach($footerVideos as $key=>$val){?>
<div id="myFooterVideoModal_<?php echo $key;?>" class="reveal-modal" style="display:none;">
    <article class="p-marg"
             >
        <div class="js-video [vimeo, widescreen]">
                <iframe allowfullscreen="" frameborder="0" height="317" src="<?php echo prep_url($val['fvYouTubeVideoLink']);?>" width="455"></iframe>
        </div>
    </article>
  <a class="close-reveal-modal">&#215;</a> 
</div>
<?php }?>
<!--lightbox vidfeo player end here-->

</div>
<p id="back-top"><a href="#top"><span></span></a> </p>
<!-- FlexSlider --> 
<script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});
</script>
<script defer src="<?php echo base_url() ?>assets/scripts/jquery.flexslider.js"></script> 
<script type="text/javascript">
    $(function(){
      //SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
    
    //function used to show the footer video
    function playFooterVideo(footerVideoId){
        $('#'+footerVideoId).css('display','inline')
    }
</script>
</body>
</html>