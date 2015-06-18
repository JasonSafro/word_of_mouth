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
<script src="js/html5.js"></script>
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
<script type="text/javascript" src="<?php echo base_url()?>assets/scripts/signup_validation.js"></script>
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
?>
<!--select-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>

  <script type="text/javascript" charset="utf-8">
         
        function print_country(country_id){
            // given the id of the <select> tag as function argument, it inserts <option> tags
            $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>services/getCountrys',
                    dataType:"json",
                    success: function (data) {
                            //alert($(data.keys).length);
                            var option_str = document.getElementById(country_id);
                            option_str.length=0;
                            option_str.options[0] = new Option('Choose your country','');
                            option_str.selectedIndex = 0;
                            console.log(option_str)                            
                            $.each(data, function(i, v) {
                                option_str.options[option_str.length] = new Option(v.text,v.val);
                            });                           
                    }
            });
            
        }
         
        function print_state(state_id, countryCode){         
         
         $.ajax({
                    type: "GET",                                        
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
                                $('#userState').parent().children(':not(#userState)').remove();
                                $('#userState').selectbox();
                    }
            });
           
        }
         
       
    </script>  
	<?php echo js_asset("jquery.selectbox-0.5.js");  ?>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.items').selectbox();
                    $('#userCountry_input').blur(function(){
                       setTimeout(function(){
                           var e = document.getElementById("userCountry");
                           var strUser = e.options[e.selectedIndex].value;
                           print_state('userState',strUser);
                       },500)
                        
                          // alert(this.value+' ='+$('#userCountry').val());
                    });
                    
                    $("#acc_type_input").blur(function() {
                             setTimeout(function(){
                                   var e = document.getElementById("acc_type");
                                    var acc_type = e.options[e.selectedIndex].value;  
                                   // alert(acc_type);
                                    if(acc_type=="bm")
                                        $('#price').html('<?php echo $basic_plan_monthly_price;?>');
                                    else
                                        $('#price').html('<?php echo $basic_plan_annual_price;?>');
                               },500)         
                                     
  //  if ($('#acc_type').val() == "bm") {$('#price').html('<?php echo $basic_plan_monthly_price;?>');}
    //else if ($('#acc_type').val() == "ba") {$('#price').html('<?php echo $basic_plan_annual_price;?>');}
});


                                        $("#b_acc_type_input").blur(function() {
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
	});
	</script>
        <script>
    $("#userCountry").selectbox({
        onOpen: function (inst) {
            console.log("open", inst);
        },
        onClose: function (inst) {
            console.log("close", inst);
        },
        onChange: function (val, inst) {
            alert('ok');
            $.ajax({
                type: "GET",
                data: {country_id: val},
                url: '<?php echo base_url() ?>services/getStateList/'+countryCode,
                success: function (data) {
                    $("#userState").html(data);
                    alert(data);
                   // $("#city_id").selectbox();
                }
            });
        },
        effect: "slide"
    }); 
        </script>
        
        
     <script type="text/javascript" charset="utf-8">
         function changeState(countryCode)
         {
             //alert(countryCode);
             $.ajax({
                    url: '<?php echo base_url() ?>services/getStateList/'+countryCode,
                    type: 'get',  
                    dataType:"json",
                    success: function(response){
                       // $('#stateHolder').empty().html(response)
                       var e = document.getElementById("userState");
                      //alert(e.options)userState_container
                      
                      $('#userState_container ul')
                        .find('li')
                        .remove()
                        .end()
                        .append(response['lis'])                        
                    ;
                      
                   $('#userState')
                        .find('option')
                        .remove()
                        .end()
                        .append(response['options'])                        
                    ;
                  var tmp=  $('#stateHolder').html();
                 // alert(tmp);
                    var tmp2=$('#userState').selectbox();
                   // alert(tmp2.html());
                      //var strUser = e.options[e.selectedIndex].value;
                      
                       
                       
                    }
                }); 
              
         }
    </script>     
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
                <b>Welcome, &nbsp;<?php echo $this->session->userdata('user_name') ?></b>
            </div>
                <div class="sign-box">                  
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
            <span>Call Us Today: 1-888-324-2301</span></div>
        </div>
        <div class="call-us1">
          <div class="space"><img src="<?php echo USER_SIDE_IMAGES;?>spacer.gif" alt="spacer" width="5"></div>
          Call Us Today: 1-888-324-2301</div>
        <div class="clear"></div>
      </div>
        </div>
 <nav>
        <ul><?php if (basename($_SERVER['PHP_SELF'])=="home"){?>
            <li><?php echo anchor('user/home/', 'Home', array('class' => "active")); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
            
            <?php }else if(basename($_SERVER['PHP_SELF'])=="about_us"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us',array('class' => "active")); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
            
             <?php }else if(basename($_SERVER['PHP_SELF'])=="how_it_works"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works',array('class' => "active")); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
             <?php }else if(basename($_SERVER['PHP_SELF'])=="services"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services',array('class' => "active")); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
             <?php }else if(basename($_SERVER['PHP_SELF'])=="deals_coupons"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons',array('class' => "active")); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
             <?php }else if(basename($_SERVER['PHP_SELF'])=="we_are_hiring"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring',array('class' => "active")); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
             <?php }else if(basename($_SERVER['PHP_SELF'])=="faq"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ',array('class' => "active")); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            
             <?php }else if(basename($_SERVER['PHP_SELF'])=="contact_us"){?>
            <li><?php echo anchor('user/home/', 'Home'); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us',array('class' => "active")); ?></li> 
            <?php } else {?>           
            <li><?php echo anchor('user/home/', 'Home', array('class' => "active")); ?></li>
            <li><?php echo anchor('user/about_us/', 'About Us'); ?></li>
            <li><?php echo anchor('user/how_it_works/', 'How it Works'); ?></li>
            <li><?php echo anchor('services/', 'Our Services'); ?></li>
            <li><?php echo anchor('user/deals_coupons/', 'Deals & Coupons'); ?></li>
            <li><?php echo anchor('user/we_are_hiring/', 'We’re Hiring'); ?></li>
            <li><?php echo anchor('user/faq/', 'FAQ'); ?></li>
            <li><?php echo anchor('contact_us/', 'Contact Us'); ?></li> 
            <?php }?>
            
            
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
     <a href="#address10" id="address_pop" class="button6 green">SIGN UP</a>    
    <!--/*======================== popup start1=====================================/-->
    
           <div>
            <a href="#" class="overlay" id="address10"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
            
            <h1><?php echo $basic_plan_name;?> Plan</h1>
           <h2> You are on step 1 out of 2 </h2>
              <div class="form2">
     
              
              <!--------------------------------------step1--------------------------------------------------->
           <?php
        $attributes = array('name' => 'frmSignup_basic', 'id' => 'frmSignup_basic', 'method' => 'post');
        //echo form_open('services/submitForm_basic', $attributes);
        echo form_open('services/index/basic/1#address10', $attributes);
        ?>
           <div class="pop-left">
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
          
           <label>Email Address *<span>(we won't spam you!)</span></label>
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
           <div class="pop-left-first">
    
           <label>Country *</label>
           <?php 
                            //$st='id="Items" class="items userCountry" onchange="changeState(this.value);"';
                            //echo form_dropdown('userCountry', _getCountryList(),set_value('userCountry'),$st);                            
                        ?>   
            <select name="Items" id="userCountry" class="items">
                <?php 
                $countryList= _getCountryList();
                foreach($countryList as $key=>$val){?>
                    <option value="<?php echo $key;?>" onclick="changeState('<?php echo $key;?>');"><?php echo $val;?></option>
                <?php }
                ?>
            <!--option value="">Select</option>
             <option>United States</option>
              <option>United States</option -->
            </select>
           <?php echo form_error('Items');?>
           </div>
           <div class="pop-left-second">
    
           <label>State</label>
           <div id="stateHolder">
            <?php 
                           // $st='id="userState" class="items"';//stateHolder
                            //echo form_dropdown('userState', _getStateList(),set_value('userState'),$st);                            
                        ?>   
               <select name="userState" id="userState" class="items">
            <option>Choose your state</option>
            </select>
           </div>    
           
           </div>
           <div class="clear"></div>
           <div class="full2"> <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment.png">&nbsp; Payment Method <span class="im"><img src="<?php echo USER_SIDE_IMAGES;?>visa.png"> </span><span class="pay"> <img src="<?php echo USER_SIDE_IMAGES;?>mestro.png"> <img src="<?php echo USER_SIDE_IMAGES;?>american.png"> <img src="<?php echo USER_SIDE_IMAGES;?>paypal.png"></span></h4> </div>
           
            <div class="pop-left-first">
  
           <label>Card number *</label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
      
           <label>CSC <img src="<?php echo USER_SIDE_IMAGES;?>quest.png"> *</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="pop-left-first">
  
           <label>Expiration date *</label>
           <div class="date">
            <select name="" class="items">
            <option>5</option>
            </select>
            </div>
            <div class="year">
            <select name="" class="items">
            <option>2013</option>
            </select>
            </div>
           </div>
           <div class="pop-left-second">
      
           &nbsp;
           </div>
           <div class="clear"></div>
           </div>
           <div class="pop-right">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
                      <select id = "acc_type"name="acc_type"class="items">
<option value="bm"><?php echo $basic_plan_monthly_name;?></option>
<option value="ba"><?php echo $basic_plan_annual_name;?></option>
</select>

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
            <input name="" type="text" value="">   
             <div class="full3">
              <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment-details.png"> &nbsp; Payment Details</h4>
             
             <span class="price"><span class="super1">$</span> &nbsp;<span id="price"><?php echo $basic_plan_monthly_price;?></span><span class="super2">*</span></span> 
             </div>
             
           <!--  <p class="note">* Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
             
           <div class="link-orange">  <a href="#">READ  FULL TERMS & CONDITIONS</a> </div>  -->   
           <!--<label> <input name="" type="checkbox" value=""> &nbsp;I agree to terms & conditions</label>-->
           <br>
            <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" onclick="javascript: $('#submitbtn12').click();">PROCEED TO STEP 2</a><br>
      <input  style="display:none;" name="submitbtn12" id="submitbtn12" value="PROCEED TO STEP 2"  type="submit"/>
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
            
            <h1>Basic Plan</h1>
           <h2> You are on step 2 out of 2 </h2>
              <div class="form2">
     <!--------------------------------------step2--------------------------------------------------->
              <?php
        $attributes = array('name' => 'frmSignup_buss_basic', 'id' => 'frmSignup_buss_basic', 'method' => 'post');
        echo form_open('services/index/basic/2#address11', $attributes);
        ?>
           <div class="pop-left">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Business Name</h4>
           <label>Name * <span>(alphanumeric, no more than 32 characters)</span></label>
           <input name="buss_name" id="buss_name"type="text" value="<?php echo set_value('buss_name'); ?>">
            <?php echo form_error('buss_name');?>
           </div>
           <div class="pop-left-second">
            <h4> &nbsp;</h4>
           <label>Contact Name</label>
            <input name="buss_cont_name" id="buss_cont_name"type="text">
            <?php echo form_error('buss_cont_name');?>
           </div>
           <div class="clear"></div>
                     <div class="full">
          
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>home2.png"> &nbsp; Business Details</h4>
           <label>Address * </label>
            <input name="buss_addr" id="buss_addr" type="text">
             <?php echo form_error('buss_addr');?>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Address add on</label>
            <input name="buss_addr_addon" id="buss_addr_addon" type="text">
            <?php echo form_error('buss_addr_addon');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>City * </label>
            <input name="buss_city" id="buss_city"type="text">
            <?php echo form_error('buss_city');?>
           </div>
           <div class="pop-left-second">
     
           <label>Zip code *</label>
            <input name="buss_zipcode" id="buss_zipcode"type="text">
               <?php echo form_error('buss_zipcode');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Phone</label>
            <input name="buss_phone" id="buss_phone"type="text" >
              <?php echo form_error('buss_phone');?>
           </div>
           <div class="pop-left-second">
      
           <label>Fax</label>
            <input name="buss_fax" id="buss_fax"type="text" >
             <?php echo form_error('buss_fax');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Web Address</label>
            <input name="buss_web_addr" id="buss_web_addr"type="text">
            <?php echo form_error('buss_web_addr');?>
           </div>
           <div class="pop-left-second">
      
           <label>Contact Email Address</label>
            <input name="buss_email_addr" id="buss_email_addr" type="text">
             <?php echo form_error('buss_email_addr');?>
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
    
           <label>Business Category *  (2 Max)</label>
            <select name="Items" class="items">
            <option>Automotive</option>
            </select>
           </div>
           <div class="pop-left-second">
    
           <label>Business License Number</label>
            <input name="buss_lice_num" id="buss_lice_num" type="text">
             <?php echo form_error('buss_lice_num');?>
           </div>
           <div class="clear"></div>
           
           
            <div class="pop-left-first">
  <h4><img src="<?php echo USER_SIDE_IMAGES;?>lic.png"> &nbsp;Business License Certification </h4> 
            <div class="write-review2">
<a href="#"><span class="top-padd"><img src="<?php echo USER_SIDE_IMAGES;?>download.png"> </span>&nbsp;DOWNLOAD</a></div>
           </div>
           <div class="pop-left-second">
      <h4><img src="<?php echo USER_SIDE_IMAGES;?>media.png"> &nbsp;Upload Your Media copy </h4> 
           <div class="write-review2">
<a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>upload.png">&nbsp; UPLOAD PHOTOS</a>
<div class="centeralign"> <label> <span>(2 Max)</span></label></div>
</div>

           </div>
           <div class="clear"></div><br>
            <div class="full">
          
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>social.png"> &nbsp; Social Media Channels</h4>
           <label>Please input your social media channels. </label>
           <br>

             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png"></div>
            <div class="pop-left-first-two"><input name="buss_sco_one" id="buss_sco_one" type="text"></div>
            <div class="clear"></div>
             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png"></div>
            <div class="pop-left-first-two"><input name="buss_sco_two" id="buss_sco_two" type="text"></div>
            <div class="clear"></div>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>&nbsp;</label><br>
            <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png"></div>
            <div class="pop-left-first-two"><input name="buss_sco_three" id="buss_sco_three" type="text"></div>
             <div class="clear"></div>
              <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png"></div>
            <div class="pop-left-first-two"><input name="buss_sco_four" id="buss_sco_four" type="text"></div>
             <div class="clear"></div>
           </div>
           <div class="clear"></div>
           
           </div>
           <div class="pop-right"><h4><h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
            <select id = "b_acc_type"name="b_acc_type"class="items">
<option value="bm"><?php echo $basic_plan_monthly_name;?></option>
<option value="ba"><?php echo $basic_plan_annual_name;?></option>
</select>
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
            <input name="" type="text" value="">   
             <div class="full3">
              <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment-details.png"> &nbsp; Payment Details</h4>
             
                
             <span class="price"><span class="super1">$</span> &nbsp;<span id="b_price"><?php echo $basic_plan_monthly_price;?></span><span class="super2">*</span></span> 
             </div>
             
             <p class="note">* Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
             
           <div class="link-orange">  <a href="#">READ  FULL TERMS & CONDITIONS</a> </div>     
           <label> <input name="buss_cond" type="checkbox" required> &nbsp;I agree to terms & conditions</label>
           <br>
            <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" onclick="javascript: $('#submitbtn13').click();">PROCEED TO STEP 2</a><br>
             <input  style="display:none;" name="submitbtn13" id="submitbtn13" value="PROCEED TO STEP 2"  type="submit"/>
            <br><br>
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
     <a href="#address12" id="address_pop" class="button6 green">SIGN UP</a>    
    <!--/*======================== popup2 start*=====================================/-->
<!----------------step1------------->
           <div>
            <a href="#" class="overlay" id="address12"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
            
            <h1>Premium Plan </h1>
           <h2> You are on step 1 out of 2 </h2>
              <div class="form2">
              
          <form action="" method="get">
           <div class="pop-left">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Create your username</h4>
           <label>Username <span>(alphanumeric, no more than 32 characters)</span></label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
            <h4><img src="<?php echo USER_SIDE_IMAGES;?>passsword.png"> &nbsp; Choose a password</h4>
           <label>Password</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
          
           <label>Email Address <span>(we won't spam you!)</span></label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
           
           <label>Repeat <span>(for confirmation) </span></label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="full">
           <label> <input name="" type="checkbox" value=""> &nbsp;Receive important email announcements from Word of Mouth Referral</label>
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>user.png"> &nbsp; Your Information</h4>
           <label>First Name *</label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Last Name *</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>Address *  </label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
     
           <label>Address add on</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Zip code *</label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
      
           <label>City *</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
    
           <label>Country *</label>
            <select name="Items" class="items">
            <option>United States</option>
             <option>United States</option>
              <option>United States</option>
            </select>
           </div>
           <div class="pop-left-second">
    
           <label>State</label>
           <select name="" class="items">
            <option>Choose your state</option>
            </select>
           </div>
           <div class="clear"></div>
           <div class="full2"> <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment.png"> &nbsp; Payment Method <span class="im"><img src="<?php echo USER_SIDE_IMAGES;?>visa.png"> </span><span class="pay"> <img src="<?php echo USER_SIDE_IMAGES;?>mestro.png"> <img src="<?php echo USER_SIDE_IMAGES;?>american.png"> <img src="<?php echo USER_SIDE_IMAGES;?>paypal.png"></span></h4> </div>
           
            <div class="pop-left-first">
  
           <label>Card number *</label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
      
           <label>CSC <img src="<?php echo USER_SIDE_IMAGES;?>quest.png"> *</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="pop-left-first">
  
           <label>Expiration date *</label>
           <div class="date">
            <select name="" class="items">
            <option>5</option>
            </select>
            </div>
            <div class="year">
            <select name="" class="items">
            <option>2013</option>
            </select>
            </div>
           </div>
           <div class="pop-left-second">
      
           &nbsp;
           </div>
           <div class="clear"></div>
            <p>&nbsp;</p>
                <p>&nbsp;</p>  <p>&nbsp;</p>
            <p>&nbsp;</p>
                <p>&nbsp;</p>  <p>&nbsp;</p>
            <p>&nbsp;</p>
                <p>&nbsp;</p>  <p>&nbsp;</p>
           
           </div>
           <div class="pop-right">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
             <select name="" class="items">
            <option>Monthly</option>
            <option>Annual</option>
            </select>
            <div class="full3"><h4><img src="<?php echo USER_SIDE_IMAGES;?>plan-details.png"> &nbsp; Plan Details</h4>
            <ul>
            <li>Business contact information</li>

<li>Customer ratings & reviews<br> w/prior verification</li>

<li>Competitive quotes with one request</li>

<li>Photos | 6 Max</li>

<li>Video</li>

<li>Business license verification</li>

<li>Certification | accolades in PDF format</li>

<li>Map</li>

<li>Social media site links</li>

<li>Monthly special | deals promotion</li>

<li>Multiple category listings | Unlimited</li>

<li>We’re hiring</li>

            </ul>
            </div>
         <h4><img src="<?php echo USER_SIDE_IMAGES;?>search2.png"> &nbsp; Got a promo code?</h4>
            <input name="" type="text" value="">   
             <div class="full3">
              <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment-details.png"> &nbsp; Payment Details</h4>
             
              
             <span class="price"><span class="super1">$</span> &nbsp;499<span class="super2">*</span></span> 
             </div>
             
             <!--<p class="note">* Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
             
           <div class="link-orange">  <a href="#">READ  FULL TERMS & CONDITIONS</a> </div>  -->   
           <!--<label> <input name="" type="checkbox" value=""> &nbsp;I agree to terms & conditions</label>
           <br>-->
            <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" href="#">CLICK TO STEP 2</a><br>
            <br><br>
            
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
            
            <h1>Premium Plan </h1>
           <h2> You are on step 2 out of 2 </h2>
              <div class="form2">
               <!--------------------------------------step2--------------------------------------------------->
            <form action="" method="get">
           <div class="pop-left">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Business Name</h4>
           <label>Name <span>(alphanumeric, no more than 32 characters)</span></label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
            <h4> &nbsp;</h4>
           <label>Contact Name</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
                     <div class="full">
          
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>home2.png"> &nbsp; Business Details</h4>
           <label>Address * </label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Address add on</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>City * </label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
     
           <label>Zip code *</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Phone</label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
      
           <label>Fax</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Web Address</label>
            <input name="" type="text" value="">
           </div>
           <div class="pop-left-second">
      
           <label>Contact Email Address</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
    
           <label>Business Category *  (2 Max)</label>
            <select name="" class="items">
            <option>Monthly</option>
            <option>Annual</option>
            </select>
           </div>
           <div class="pop-left-second">
    
           <label>Business License Number</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
           
           
            <div class="pop-left-first">
  <h4><img src="<?php echo USER_SIDE_IMAGES;?>lic.png"> &nbsp;Business License Certification </h4> 
            <div class="write-review2">
<a href="#"><span class="top-padd"><img src="<?php echo USER_SIDE_IMAGES;?>download.png"> </span>&nbsp;(Accolades) Download</a></div>
           </div>
           <div class="pop-left-second">
      <h4><img src="<?php echo USER_SIDE_IMAGES;?>media.png"> &nbsp;Upload Your Media copy </h4> 
           <div class="write-review2">
<a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>upload.png">&nbsp; UPLOAD PHOTOS</a>
<div class="centeralign"> <label> <span>(2 Max)</span></label></div>
</div>

           </div>
           <div class="clear"></div><br>
            <div class="full2">
          <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>add-info.png"> &nbsp; Additional Information</h4>
          <label> <input name="" type="checkbox" value=""> &nbsp;Click to receive competitive quotes</label>
           <input name="" type="text" value="(Enter Your Email Address)"  onFocus="if(this.value=='Enter Your Email Address')this.value=''" onBlur="if(this.value=='')this.value='Enter Your Email Address'">
           </div>
           <div class="pop-left-second">
            <h4> &nbsp;</h4>
          <label> <input name="" type="checkbox" value=""> &nbsp;Click to receive monthly deals & specials</label>
           <label> <input name="" type="checkbox" value=""> &nbsp;We’re Hiring</label>
           </div>
           <div class="clear"></div>
           </div>
             <div class="full2">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>social.png"> &nbsp; Social Media Channels</h4>
           <label>Please input your social media channels. </label>
           <br>
             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png"></div>
            <div class="pop-left-first-two"><input name="" type="text" value=""></div>
            <div class="clear"></div>
             <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png"></div>
            <div class="pop-left-first-two"><input name="" type="text" value=""></div>
            <div class="clear"></div>
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>&nbsp;</label><br>
            <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png"></div>
            <div class="pop-left-first-two"><input name="" type="text" value=""></div>
             <div class="clear"></div>
              <div class="pop-left-first-one"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png"></div>
            <div class="pop-left-first-two"><input name="" type="text" value=""></div>
             <div class="clear"></div>
           </div>
           <div class="clear"></div>
           </div>
           
           </div>
           <div class="pop-right">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
           <select name="" class="items">
            <option>Monthly</option>
            <option>Annual</option>
            </select>
            <div class="full3"><h4><img src="<?php echo USER_SIDE_IMAGES;?>plan-details.png"> &nbsp; Plan Details</h4>
            <ul>
<li> Business contact information</li>
<li> Customer ratings & reviews <br>w/prior verification</li>
<li> Photos | 2 Max</li>
<li> Business license verification</li>
<li> Map</li>
<li> Social media site links</li>
<li> Multiple category listings | 2 Max</li>
            </ul>
            </div>
         <h4><img src="<?php echo USER_SIDE_IMAGES;?>search2.png"> &nbsp; Got a promo code?</h4>
            <input name="" type="text" value="">   
             <div class="full3">
              <h4><img src="<?php echo USER_SIDE_IMAGES;?>payment-details.png"> &nbsp; Payment Details</h4>
             
                
             <span class="price"><span class="super1">$</span> &nbsp;299<span class="super2">*</span></span> 
             </div>
             
             <p class="note">* Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
             
           <div class="link-orange">  <a href="#">READ  FULL TERMS & CONDITIONS</a> </div>     
           <label> <input name="" type="checkbox" value=""> &nbsp;I agree to terms & conditions</label>
           <br>
            <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" href="#">PROCEED TO STEP 2</a><br>
            <br><br>
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
            <li><a href="<?php echo base_url()?>user/home/">» Home</a></li>
            <li><a href="<?php echo base_url()?>user/about_us/">» About Us</a></li>
            <li><a href="<?php echo base_url()?>user/how_it_works/">» How it Works</a></li>
            <li><a href="<?php echo base_url()?>services/">» Our Services</a></li>
            <li><a href="<?php echo base_url()?>user/deals_coupons/">» Deals & Coupons</a></li>
            <li><a href="<?php echo base_url()?>user/we_are_hiring/">»  We’re Hiring</a></li>
            <li><a href="<?php echo base_url()?>user/faq/">» FAQ</a></li>
            <li><a href="<?php echo base_url()?>contact_us/">» Contact Us</a></li>
          </ul>
        </div>
        <div class="line1"></div>
        <div class="videos">
          <h2>Some of Our Videos</h2>
          <ul>
            <li>
              <div class="promo"><a href="#" data-reveal-id="myModal"><img src="<?php echo USER_SIDE_IMAGES;?>player1.png" alt="video"></a>
                <p><span>Aenean  Pellentesque</span><br/>
                  Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Praesent commodo cursus magna.</p>
              </div>
              <div class="dating">
                <div class="calendar">5-21-13</div>
                <a href="#" class="button orange" style="width:85px;" >Read More</a></div>
              <div class="clear"></div>
            </li>
            <li>
              <div class="promo"><a href="#" data-reveal-id="myModal"><img src="<?php echo USER_SIDE_IMAGES;?>player2.png" alt="video"></a>
                <p><span>Aenean  Pellentesque</span><br/>
                  Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Praesent commodo cursus magna.</p>
              </div>
              <div class="dating">
                <div class="calendar">5-21-13</div>
                <a href="#" class="button orange" style="width:85px;" >Read More</a></div>
              <div class="clear"></div>
            </li>
            <li>
              <div class="promo"><a href="#" data-reveal-id="myModal"><img src="<?php echo USER_SIDE_IMAGES;?>player3.png" alt="video"></a>
                <p><span>Aenean  Pellentesque</span><br/>
                  Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Praesent commodo cursus magna.</p>
              </div>
              <div class="dating">
                <div class="calendar">5-21-13</div>
                <a href="#" class="button orange" style="width:85px;"  >Read More</a></div>
              <div class="clear"></div>
            </li>
          </ul>
        </div>
        <div class="line1"></div>
        <div class="stay">
          <h2>Stay Connected</h2>
          <div class="bottom-logo"><img src="<?php echo USER_SIDE_IMAGES;?>logo-bottom.png" alt="logo"></div>
          <div class="afew"><span>A Few Words We Have To Say:</span><br/>
            Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Aenean eu leo quam. Pellentesque ornare sem lacinia quam venenatis vestibulum. Vestibulum id ligula porta felis euismod semper. Donec id elit non mi porta gravida </div>
          <div class="social1">
            <ul>
              <li><a href="http://twitter.com/" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>twitt1.png" alt="twitter"></a></li>
              <li><a href="http://www.facebook.com/" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>facebook1.png" alt="facebook"></a></li>
              <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>printrest1.png" alt="printrest"></a></li>
              <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>linked-in1.png" alt="linked-in"></a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <div class="copy">© 2013 Word of Mouth, Inc. All rights reserved.</div>
          <div class="mail"><a href="#">info@wordofmouth.com</a></div>
          <div class="phone">1-888-234-2041</div>
        </div>
      </div>
    </footer>
  </div>
  <div class="clear"></div>
</div>
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
</script>
</body>
</html>