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
<!-- Import CSS -->
<?php
/**
  1] css_asset - This function is use to call all css files from the folder
  2] js_asset - This function is use to call all css files from the folder
  3] img - this function is used for call or display images files from the folder
 */

//CSS
echo css_asset("reset.css");
//echo css_asset("fonts/stylesheet.css");	
echo css_asset("stylesheet.css");
echo css_asset("word-of-mouth.css");
echo css_asset("featuredcontentglider.css");
echo css_asset("flexslider.css");
echo css_asset("screen.css");
//JS
echo js_asset("jquery-1.8.3.min.js");
//for us of back to top function
echo js_asset("jquery.reveal.js");
echo js_asset("script.js");
?>
<script src="<?php echo base_url()?>assets/scripts/jquery.easing.1.2.js" type="text/javascript" charset="utf-8"></script>
<link rel="shortcut icon" href="<?php echo USER_SIDE_IMAGES;?>wom-20130603-favicon.ico.png"/>
<!--[if IE]>
<script src="<?php echo base_url()?>assets/scripts/html5.js"></script>
<![endif]-->
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
<?php echo js_asset("jquery.alerts.js");?>
<?php echo js_asset("jquery.MultiFile.js");?>
<?php echo js_asset("jquery.MultiFile.pack.js");?>
<?php echo js_asset("additional-methods.js");?>
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
        <div class="logo"><?php echo anchor('home/', img(array('src' => USER_SIDE_IMAGES.'logo.png','border'=>"0", 'alt' => 'logo'))); ?></div>
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
          Call Us Today: <?php echo _getHeaderPhoneNo();?> </div>
        <div class="clear"></div>
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

   