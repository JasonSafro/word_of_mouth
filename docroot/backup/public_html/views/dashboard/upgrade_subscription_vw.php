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
echo js_asset("jquery.min.js");
?>
<!--select-->

<!--script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script-->
<?php //echo js_asset("jquery.selectbox-0.5.js");  ?>

  <script type="text/javascript" charset="utf-8">
      function print_stateForCC(state_id, countryCode){            
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
                                    option_str.options[option_str.length] = new Option(v.text,v.text);                                   
                                });  
                                //$('#'+state_id).parent().children(':not(#'+state_id+')').remove();
                                //$('#userState').selectbox(); 
                    }
            });           
        } 
        
        function initialize(){
            
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
	
	<script type="text/javascript">
	$(document).ready(function() {
            initialize();
                    //Basic Plan Page 1 for price
                    $("#acc_type").change(function() {$('#promocode').val("");$("#pro_code_err").html("");
                               var e = document.getElementById("acc_type");
                                var acc_type = e.options[e.selectedIndex].value;  
                               // alert(acc_type);
                                if(acc_type=="bm")                                        
                                    $('#price').html('<?php echo $basic_plan_monthly_price;?>');
                                else
                                    $('#price').html('<?php echo $basic_plan_annual_price;?>');
                    });

                //Basic Plan Page 2 for price
                $("#b_acc_type").change(function() {$('#b_promocode').val("");$("#b_pro_code_err").html("");
                        var e = document.getElementById("b_acc_type");
                        var acc_type = e.options[e.selectedIndex].value;  
                        // alert(acc_type);
                        if(acc_type=="bm")
                            $('#b_price').html('<?php echo $basic_plan_monthly_price; ?>');
                        else
                            $('#b_price').html('<?php echo $basic_plan_annual_price; ?>');
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

</head>

<body id="top">
 <?php $this->load->view('includes/user_reg_view'); ?>
<div id="fade1" class="black_overlay"></div>
<!--register lightbox popup end-->

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
          <h1>Upgrade Subscription</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>dashboard/manage_subscription/">Manage Subscription</a> |  Upgrade</div></div>
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
     <a href="#address11" id="address_pop" class="button6 green" onclick="javascript: $('#back-top a').click();">Upgrade</a>   
     
    <!--/*======================== popup start1=====================================/-->
    
           
            </div>
            <!--/*======================== popup1 end*=====================================/-->
              
            
             <!--/*========================step 2 start=====================================/-->
    
           <div>
            <a href="#" class="overlay" id="address11"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
            
                          <!-- Remove this after email starts -->
            <?php  if ($this->session->userdata('activation_url') != ''){?>
                <h5>Account Activation Link : <?php echo $this->session->userdata('activation_url');?></h5>
                <?php }?>
            
            <h1>Basic Plan</h1>
           <?php if($error!=''){?>
           <br/><h2><?php echo $error;?></h2>
           <?php }?>
              <div class="form2">
     <!--------------------------------------step2--------------------------------------------------->
              <?php
        $attributes = array('name' => 'frmSignup_buss_basic', 'id' => 'frmSignup_buss_basic1', 'method' => 'post');
        echo form_open_multipart('dashboard/upgrade_subscription/index/basic#address11', $attributes);
        ?>
           <div class="pop-left ">
               
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
          
     <!--------------------------------------credit card------------------------------------------------- -->             
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
           <label>Address Line 2 </label>
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
           <label>Zip Code</label>
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
                                                $xm='id="expiryMonth"class="items_custom"';
                                                echo form_dropdown('expiryMonth', _getMonths(),set_value('expiryMonth'),$xm);
                                            ?>
                         </div>
                     <div class="year">
                                           <?php 
                                                $xy='id="expiryYear"class="items_custom"';
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
     <!--------------------------------------END CREDIT CARD--------------------------------------------->
     
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
<?php 
 $videoServiceInfo=array(); 
 foreach($service_limits as $key=>$val)
  {
    // get video info
    if($val['service_id']==5)
    {
        $videoServiceInfo=$val;
    }    
    ?>
    
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
                        var b_plan_price=$('#b_price').text();
                        
                        var e = document.getElementById("b_acc_type");
                        var acc_type = e.options[e.selectedIndex].value;                        
                        
                        if(acc_type=='bm')
                           acc_type="<?php echo $basic_plan_monthly_name;?>";
                       else
                           acc_type="<?php echo $basic_plan_annual_name;?>";
			if(b_promo_code!="")
			{
				$.ajax({
				url: '<?php echo base_url()?>change_price_by_promocode/check_promocode',
				type: 'post',                                                               
				data: 'pro_code='+b_promo_code+'&plan_type='+acc_type+'&plan_price='+b_plan_price,
				success: function(data){
                                                                                                 var n=data.split(",");
						if(data == "inactive")
						{
							$("#b_pro_code_err").addClass("error");
							$("#b_pro_code_err").html("This code is expired.");
							return false; 
						}
						else if(data == "invalid")
						{
							$("#b_pro_code_err").addClass("error");
							$("#b_pro_code_err").html("This code is invalid.");
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
                            if(acc_type=="ba")
                                $('#b_price').html("<?php echo $basic_plan_annual_price;?>");
                            else
                                $('#b_price').html("<?php echo $basic_plan_monthly_price;?>");
                            
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
                     <!--<p class="note">* Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>-->

                   <div class="link-orange">  
                       <a href="void(0)" onclick="JavaScript: return newPopup('<?php echo base_url()?>dashboard/upgrade_subscription/terms_and_condition');">READ  FULL TERMS & CONDITIONS</a> 
                   </div>     
                   <label> <input id="basicTerms" name="buss_cond" type="checkbox" required> &nbsp;I agree to terms & conditions</label>
                   <br>
                    <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" id="basicSubmit" onclick="javascript: $('#submitbtn13').click();">SUBMIT</a><br>
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
                   <a href="#address13" id="address_pop" class="button6 green" onclick="javascript: $('#back-top a').click();">Upgrade</a>    
       
    <!--/*======================== popup2 start*=====================================/-->
<!----------------step1----------- -->
          
            </div>
            
             <div>
            <a href="#" class="overlay" id="address13"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
                          <!-- Remove this after email starts -->
            <?php  if ($this->session->userdata('activation_url') != ''){?>
                <h5>Account Activation Link : <?php echo $this->session->userdata('activation_url');?></h5>
                <?php }?>
            
            <h1>Premium Plan </h1>           
            <?php if($p_error!=''){?>
           <br/><h2><?php echo $p_error;?></h2>
           <?php }?>
              <div class="form2">
               <!--------------------------------------step2--------------------------------------------------->
              <?php
        $attributes = array('name' => 'frmSignup_buss_prem', 'id' => 'frmSignup_buss_prem', 'method' => 'post');
        echo form_open_multipart('dashboard/upgrade_subscription/index/prem#address13', $attributes);
        ?>
           <div class="pop-left">
           
           
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
          
         <div class="form2" id="p_myDiv">
     <!--------------------------------------credit card------------------------------------------------- -->             
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
           echo form_dropdown('p_c_Items', _getCountryList(),set_value('p_c_Items','USA'),$xm);
           ?>
            <!--<select name="p_c_Items" id="p_c_userCountry" class="items_custom">
                <?php 
                $countryList= _getCountryList();
                foreach($countryList as $key=>$val){?>
                    <option value="<?php echo $key;?>" onclick="changeState('<?php echo $key;?>');"><?php echo $val;?></option>
                <?php }
                ?>           
            </select>-->
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
           <label>Zip Code</label>
            <input name="p_c_zip_code" id="p_c_zip_code"type="text"value="<?php echo set_value('p_c_zip_code');?>">
            <?php echo form_error('p_c_zip_code');?>
           </div>
           <div class="pop-left-second">     
           <label>CVV2 Number</label>
           <input name="p_c_cvv2_no" id="p_c_cvv2_no"type="text"value="<?php echo set_value('p_c_cvv2_no');?>">
            <?php echo form_error('p_c_cvv2_no');?>
           </div>
           
           <div class="clear"></div>
           
           
           <div class="pop-left-first">
  
           <label>Phone No </label>
            <input name="p_c_phone_no" id="p_c_phone_no"type="text"value="<?php echo set_value('p_c_phone_no');?>">
            <?php echo form_error('p_c_phone_no');?>
           </div>
            <div class="pop-left-second rel-position">
     
           <label>Expiration Date *</label>
           <div class="date">
          <?php 
                    $xm='id="p_expiryMonth"class="items_custom"';
                    echo form_dropdown('p_expiryMonth', _getMonths(),set_value('p_expiryMonth'),$xm);
                ?>
            </div>
            <div class="year">
               <?php 
                    $xy='id="p_expiryYear"class="items_custom"';
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
                        var p_plan_price1=$('#p_price2').text();   
                        
                        var e = document.getElementById("p_acc_type1");
                        var acc_type = e.options[e.selectedIndex].value;  
                       //  alert(acc_type);
                       
                       if(acc_type=='pm')
                           acc_type="<?php echo $prem_plan_monthly_name;?>";
                       else
                           acc_type="<?php echo $prem_plan_annual_name;?>";
                       
			if(p_promo_code1 != '')
			{
				$.ajax({
				url: '<?php echo base_url()?>change_price_by_promocode/check_promocode_p',
				type: 'post',                                                               
				data: 'pro_code='+p_promo_code1+'&plan_type='+acc_type+'&plan_price='+p_plan_price1,
				success: function(data){
                                                                                                 var n=data.split(",");
						if(data == "inactive")
						{
							$("#p_pro_code_err1").addClass("error");
							$("#p_pro_code_err1").html("This code is expired.");
							return false; 
						}
						else if(data == "invalid")
						{
							$("#p_pro_code_err1").addClass("error");
							$("#p_pro_code_err1").html("This code is invalid.");
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
                            if(acc_type=="pm")
                                $('#p_price2').html('<?php echo $prem_plan_monthly_price; ?>');
                            else
                                $('#p_price2').html('<?php echo $prem_plan_annual_price; ?>');
                        
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
                   <a href="void(0)" onclick="JavaScript: return newPopup('<?php echo base_url()?>dashboard/upgrade_subscription/terms_and_condition');">READ  FULL TERMS & CONDITIONS</a> 
               </div>     
               <label> <input name="p_buss_cond" type="checkbox" required> &nbsp;I agree to terms & conditions</label>
               <br>
               <span class="can"><a href="#">CANCEL</a> </span><a  class="button orange" onclick="javascript: $('#submitbtn15').click();">SUBMIT</a><br>
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
                  <a onclick="playFooterVideo('myFooterVideoModal_<?php echo $key;?>')" href="#" data-reveal-id="myFooterVideoModal_<?php echo $key;?>"><img src="<?php echo SITE_ROOT_FOR_USER.'sitedata/footer_videos_images/'.$val['fvImage'];?>" alt="video"></a>
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

<!--lightbox vidfeo player appearing from here-->
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