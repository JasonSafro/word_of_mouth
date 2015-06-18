<?php
//CSS
echo css_asset("address-popup.css");
echo css_asset("selectbox.css");

//JS
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
<!--select-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
    <?php echo js_asset("jquery.selectbox-0.5.js");  ?>
	
	<script type="text/javascript">
	$(document).ready(function() {
		$('.items').selectbox();
	});
	</script>
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
            
            <h1>Basic Plan</h1>
           <h2> You are on step 1 out of 2 </h2>
              <div class="form2">
     
              
              <!--------------------------------------step1------------------------------------------------- - -->
           <?php
        $attributes = array('name' => 'frmSignup_basic', 'id' => 'frmSignup_basic', 'method' => 'post');
        echo form_open('services/submitForm_basic', $attributes);
        ?>
           <div class="pop-left">
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>create.png"> &nbsp; Create your username</h4>
           <label>Username <span>(alphanumeric, no more than 32 characters)</span></label>
            <input name="username" id="username" type="text">
           </div>
           <div class="pop-left-second">
            <h4><img src="<?php echo USER_SIDE_IMAGES;?>passsword.png"> &nbsp; Choose a password</h4>
           <label>Password</label>
            <input name="user_password" id="user_password" type="password">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
          
           <label>Email Address <span>(we won't spam you!)</span></label>
            <input name="user_email" id="user_email" type="text">
           </div>
           <div class="pop-left-second">
           
           <label>Repeat <span>(for confirmation) </span></label>
            <input name="cpassword" id="cpassword" type="password">
           </div>
           <div class="clear"></div>
           <div class="full">
           <label> <input name="email_announc" type="checkbox" value=""> &nbsp;Receive important email announcements from Word of Mouth Referral</label>
           </div>
           <div class="pop-left-first">
           <h4><img src="<?php echo USER_SIDE_IMAGES;?>user.png"> &nbsp; Your Information</h4>
           <label>First Name fgdf*</label>
            <input name="fname" id="fname" type="text" value="">
           </div>
           <div class="pop-left-second">
            <h4>&nbsp; </h4>
           <label>Last Name *</label>
            <input name="lname" id="lname" type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
        
           <label>Address *  </label>
            <input name="address" id="address" type="text" value="">
           </div>
           <div class="pop-left-second">
     
           <label>Address add on</label>
            <input name="addr_addon" id="addr_addon"type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
  
           <label>Zip code *</label>
            <input name="zip_code" id="zip_code"type="text" value="">
           </div>
           <div class="pop-left-second">
      
           <label>City *</label>
            <input name="city" id="city"type="text" value="">
           </div>
           <div class="clear"></div>
           <div class="pop-left-first">
    
           <label>Country *</label>
            <select name="country" class="items">
            <option>United States</option>
             <option>United States</option>
              <option>United States</option>
            </select>
           </div>
           <div class="pop-left-second">
    
           <label>State</label>
           <select name="state" class="items">
            <option>Choose your state</option>
            </select>
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
             
           <!--  <p class="note">* Integer posuere erat a ante venenatis dapibus posuere velit aliquet. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit... </p>
             
           <div class="link-orange">  <a href="#">READ  FULL TERMS & CONDITIONS</a> </div>  -->   
           <!--<label> <input name="" type="checkbox" value=""> &nbsp;I agree to terms & conditions</label>-->
           <br>
            <span class="can"><a href="#">CANCEL</a> </span>
            <input class="button orange" id="submitbtn" value="PROCEED TO STEP 2"  type="submit"/><br>
            <!--<a  class="button orange" href="#">PROCEED TO STEP 2</a><br>-->
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
            <select name="Items" class="items">
            <option>Automotive</option>
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
           <div class="pop-right"><h4><h4><img src="<?php echo USER_SIDE_IMAGES;?>choose-plan.png"> &nbsp; Choose Your Plan</h4>
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
            <!--/*======================== step2 end*=====================================/-->
            
    
    </div>    </td>
    <td>
    <div class="l-p">
    $499.00 <br><h2>annually</h2>
    </div>
     <div class="r-p">
   $45.99 <h2>monthly</h2>
    </div>
    <div class="clear"></div>
    <div class="green-btn">
     <a href="#address12" id="address_pop" class="button6 green">SIGN UP</a>    
    <!--/*======================== popup2 start*=====================================/-->
<!----------------step1----------- -->
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
               <!--------------------------------------step2------------------------------------------------- -->
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
    
           <label>Business Category * </label>
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