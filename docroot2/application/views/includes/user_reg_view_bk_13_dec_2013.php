<?php echo js_asset('jquery.validate.js'); ?>
<script language="javascript">       
$(document).ready(function() {
        $.validator.addMethod("loginRegex", function(value, element) {
         return this.optional(element) || /^[0-9a-zA-Z ]+$/.test(value);
    }, "Alphanumeric only.");
     $.validator.addMethod("unameRegex1", function(value, element) {
         return this.optional(element) || /^[0-9a-zA-Z ]{0,32}$/.test(value);
    }, "Alphanumeric only.");
    
       $.validator.addMethod("noSpace", function(value, element) { 
     return value.indexOf(" ") < 0 && value != ""; 
  }, "Space are not allowed");
  
          $.validator.addMethod("pwdRegex", function(value, element) {
         return this.optional(element) || /^[0-9a-zA-Z ]{6,12}$/.test(value);
    }, "Password field must be at least 6 to 12 characters in length.");
    
              
       	var validator = $("#frm_register").validate({
		rules: {
			uname: {
						required: true,noSpace:true,unameRegex1:true,
                                                                                                remote: {
                                                                                                    url: '<?php echo base_url() ?>user/check_uname_dup',
                                                                                                    type: "post",
                                                                                                    data: {
                                                                                                        uname: function() {
                                                                                                            return $("#uname").val();
                                                                                                        }
                                                                                                    }
                                                                                                }
			},
			email: {
						required: true,
                                                                                                email: true,
                                                                                                remote: {
                                                                                                    url: '<?php echo base_url() ?>user/check_email_dup',
                                                                                                    type: "post",
                                                                                                    data: {
                                                                                                        email: function() {
                                                                                                            return $("#email").val();
                                                                                                        }
                                                                                                    }
                                                                                                }
			},
                                                password:{
                                                                                                required: true,
                                                                                                loginRegex: true,
                                                                                                pwdRegex:true
                                                },
                                                cpassword:{
                                                                                                required: true,
                                                                                                loginRegex: true,
                                                                                                equalTo:'#password'
                                                }
		},
		messages: {	
				
			uname:{
						required :"Please enter UserName", unameRegex1:"Alphanumeric, 4 to 32 characters only",
                                                                                                remote:"This UserName is already in use."
			},
			email:{
						required :"Please enter Email",
                                                                                                email:"Please Enter Valid Email",
                                                                                                remote:"This email is already in use."
			},
                                                password:{
                                                                                                required :"Please enter Password"
                                                },
                                                cpassword:{
                                                                                                required :"Please enter Confirm Password",
                                                                                                equalTo :"The Repeat Password field does not match the Password field."
                                                }
                                                
                        
		},
		success: function(label) {                                        
			//label.html("&nbsp;").addClass("error");
		},
                 submitHandler: function() {
                     var uname = $('#uname').val();
                     var email=$('#email').val();
                     var password=$('#password').val();
                  $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('user/register')?>",
                            data: 'uname='+uname+'&email='+email+'&password='+password,
                            beforeSend: function() {
		$("#loder3").css("display","block");
                                //$("#loder2").html('<img src="<?php echo base_url()?>assets/images/ajax-loader.gif" style="margin:100px 175px 0 0"/>');
                            },
                            success: function(response){                               
                                var n=response.split(",");
                                if(n[0] == 'true'){
                                 document.getElementById('light1').style.display='none';
                                 document.getElementById('fade1').style.display='none';
                                 document.getElementById('light_step2').style.display='block';
                                 document.getElementById('fade2').style.display='block';
                                 $('#confirm_link').text(n[1]);
                                 
                                 }
                                 else if(n[0] == 'false'){
                                    alert('ERROR: Somthing Goes Wrong, Please Try Again!!');
                                    window.location.href='home';   
                                 }
                            }
                        });            
            }
	});
	
	var validator = $("#frm_register_step2").validate({
             errorElement: 'div',            
            highlight: function (element, errorClass, validClass) {
           return false;  // ensure this function stops
            },
             unhighlight: function (element, errorClass, validClass) {
           return false;  // ensure this function stops
            },
		rules: {
			fname: {
						required: true
			},
                                                lname: {
						required: true
			},uaddress:{
                                                                                                required: true
                                               },                                               
                                               uzipcode:{
                                                                                                required: true,
                                                                                                number:true
                                               },
			
                                               phone: {
						required: true,
                                                                                                number:true
                                                                                                
			},   
                                                city: {
                                                                                                required: true
                                                }, 
                                               state: {
                                                                                                required: true
                                                }, 
                                               country: {
                                                                                                required: true
                                                }
			
		},
		messages: {	
				
			fname:{
						required :"Please Enter First Name"
			},
                                                lname:{
                                                                                                required :"Please Enter Last Name"
                                                },
                                                 uaddress:{
                                                                                                required :"Please Enter Address"
                                                },
                                                 uzipcode:{
                                                                                                required :"Please Enter Zip Code",
                                                                                                number:"Please Enter Only Numbers."
                                                 },
                                                phone:{
                                                                                                required :"Please Enter Phone Number",
                                                                                                number:"Please Enter Only Numbers."
                                                },
                                                city:{
                                                                                                required :"Please Enter City Name"
                                                },
                                                state:{
                                                                                                required :"Please enter State Name"
                                                },
                                                country:{
                                                                                                required :"Please Select Country Name"
                                                }                                                
                        
		},
		success: function(label) {
			//label.html("&nbsp;").addClass("error");
		}
	});	
        
                                                                        
                                                                     
        /* $.validator.messages.required = "";
               $.validator.messages.remote = "";
               $.validator.messages.email = "";
               $.validator.messages.loginRegex = "";
                $.validator.messages.pwdRegex = "";
                 $.validator.messages.equalTo = "";  */                      
        //Login Form Validations
        var validator = $("#frm_login").validate({            
		rules: {
			uemail: {
						required: true                                                                                            
                                                                                               /* remote: {
                                                                                                    url: '<?php echo base_url() ?>user/check_user_present',
                                                                                                    type: "post",
                                                                                                    data: {
                                                                                                        uemail: function() {
                                                                                                            return $("#uemail").val();
                                                                                                        }
                                                                                                    }
                                                                                                }*/
			},
                                                upassword:{
                                                                                                required: true,
                                                                                                loginRegex: true
                                                                                               /* remote: {
                                                                                                    url: '<?php echo base_url() ?>user/check_user_password',
                                                                                                    type: "post",
                                                                                                    data: {
                                                                                                        upassword: function() {
                                                                                                            return $("#upassword").val();
                                                                                                        }
                                                                                                    }
                                                                                                }*/
                                                }
                                               
		},
		messages: {	
				
			uemail:{
						required :"Please enter Username OR Email"                                                                                             
                                                                                                /*remote:"User Not Present OR Account Not Activated Yet."*/
                                                                                                
			},			
                                                upassword:{
                                                                                                required :"Please enter Password"
                                                                                               /* remote:"Password Not Matches."*/
                                                }
                                               
                                                
                        
		},
		/*success: function(label) {                                        
			//label.html("&nbsp;").addClass("error");
		},   
                errorPlacement: function(error, element) { //just nothing, empty
                },*/
              submitHandler: function() {
                   var uemail=$('#uemail').val();
                   var upassword=$('#upassword').val();
                $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('user/login_user')?>",
                            data: 'uemail='+uemail+'&upassword='+upassword,
                            beforeSend: function() {
                                $("#loder2").css("display","block");
                                //$("#loder2").html('<img src="<?php echo base_url()?>assets/images/ajax-loader.gif" style="margin:100px 175px 0 0"/>');
                            },
                            success: function(response){  
                                $("#loder2").css("display","none");
                                var n=response.split(",");
                                if(n[0] == 'false'){
                                    var errortext="Your Password Not Matching!";  
                                    $("#upwd_error").css("display","block");
                                     document.getElementById("upwd_error").innerHTML=errortext;
                                 }
                                else if(n[0] == 'false1'){
                                     var errortext="Your Account is Not Acivated Yet!";  
                                     $("#uemail_error").css("display","block");
                                     document.getElementById("uemail_error").innerHTML=errortext;
                                 }
                                 else if(n[0] == 'false2'){                                     
                                     var errortext="Your User Name/Email Not Matching!";  
                                     $("#uemail_error").css("display","block");
                                     document.getElementById("uemail_error").innerHTML=errortext;
                                 }
                                   else if(n[0] == 'true_bus_user'){                                     
                                     window.location.href='<?php echo base_url() ?>dashboard/business_overview';  
                                 }
                                 else if(n[0] == 'true_site_user'){                                     
                                     window.location.href='<?php echo (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']; ?>';  
                                 }
                            }
                        });      
            }
	});  
        
        
         /* #################### Forgot Psssword Link Form Validation Functionality Start (views/home_vw.php) ###################### */ 
       var validator = $("#frm_forgot_pwd").validate({
            rules: {                	                   
                forg_email: {required :true,email: true, 
                    remote: {
                        url: '<?php echo base_url() ?>forgot_pwd/check_email',
                        type: "post",
                        data: {
                            forg_email: function() {
                                return $("#forg_email").val();
                            }
                        }
                    }
                }
            },
            messages: {                 
                forg_email: { required: "Email Address is required.", emailValidate: "Please enter a valid email address.", remote:"This email address doesn't exist in the system."}
               
                
            }, 
                success: function(label) { 
            },
            
            
              submitHandler: function() {
                   var forg_email=$('#forg_email').val();
                $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('forgot_pwd/submitForm')?>",
                            data: 'forg_email='+forg_email,
                            beforeSend: function() {
		$("#loder3").css("display","block");
                                //$("#loder2").html('<img src="<?php echo base_url()?>assets/images/ajax-loader.gif" style="margin:100px 175px 0 0"/>');
                            },
                            success: function(response){                              
                                var n=response.split(",");
                                if(n[0] == 'true'){                                 
                                 document.getElementById('light_forgot_pwd').style.display='block';
                                 document.getElementById('fade3').style.display='block';
                                 $('#forgot_pwd_link').text(n[1]);                                 
                                 }
                                 else if(n[0] == 'false'){
                                    alert('ERROR: Somthing Goes Wrong, Please Try Again!!');
                                    window.location.href='home';   
                                 }
                            }
                        });      
            }
            
            
        });
        /* #################### Forgot PssswordForm Validation Functionality End ###################### */
        
        
        
                
         /* #################### Forgot Username Link Form Validation Functionality Start (views/home_vw.php) ###################### */ 
       var validator = $("#frm_forgot_uname").validate({
            rules: {                	                   
                uname_forg_email: {required :true,email: true, 
                    remote: {
                        url: '<?php echo base_url() ?>forgot_uname/check_email',
                        type: "post",
                        data: {
                            uname_forg_email: function() {
                                return $("#uname_forg_email").val();
                            }
                        }
                    }
                }
            },
            messages: {                 
                uname_forg_email: { required: "Email Address is required.", emailValidate: "Please enter a valid email address.", remote:"This email address doesn't exist in the system."}
               
                
            }, 
                success: function(label) { 
            },
            
            
              submitHandler: function() {
                   var uname_forg_email=$('#uname_forg_email').val();
                $.ajax({
                            type: 'POST',
                            url: "<?php echo site_url('forgot_uname/submitForm')?>",
                            data: 'uname_forg_email='+uname_forg_email,
                            beforeSend: function() {
		$("#loder3").css("display","block");
                                //$("#loder2").html('<img src="<?php echo base_url()?>assets/images/ajax-loader.gif" style="margin:100px 175px 0 0"/>');
                            },
                            success: function(response){                              
                                var n=response.split(",");
                                if(n[0] == 'true'){                                 
                                 document.getElementById('light_forgot_uname').style.display='block';
                                 document.getElementById('fade4').style.display='block';
                                 $('#forgot_uname_link').text(n[1]);                                 
                                 }
                                 else if(n[0] == 'false'){
                                    alert('ERROR: Somthing Goes Wrong, Please Try Again!!');
                                    window.location.href='home';   
                                 }
                            }
                        });      
            }
            
            
        });
        /* #################### Forgot PssswordForm Validation Functionality End ###################### */
        
         $('#country').change(function(){            
              var e = document.getElementById("country");
                           var strUser = e.options[e.selectedIndex].value;                          
                           print_state_rege('state',strUser);
                        });
                        
                        
});


</script>
<script>
    function print_state_rege(state_id, countryCode){ 
             $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>user/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                   
                                });  
                                 $('#state').selectmenu();
                              /*  $('#userState').parent().children(':not(#userState)').remove();
                                $('#userState').selectbox();*/
                    }
            });
           
        }        
        </script>
<style>
    .error{
	font-style:italic;
	font-size:10px;
	color:#FF0000;
	font-weight: bold;
}
table.reg-table td {padding: 2px;}
</style>
<!--sign in lightbox popup-->
<div id="light" class="white_content">
  <div class="sign-mainb">
    <div class="close-light"><a href = "javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';location.reload()">Close</a></div>
    <div class="clear"></div>
    <div class="light-pad">
      <div class="main-light">
        <h1><img src="<?php echo USER_SIDE_IMAGES;?>shield1.png"  alt="shield"> Sign in to access your account</h1>
        <div id="loder2" style="height:100%; width:100%; text-align:center; position:absolute; background-color:#000000; opacity:0.50; left:0;top:0; display: none;">
            <div style="position:relative; left:0px; top:45%;"><?php echo img(array('src'=>USER_SIDE_IMAGES.'ajax-loader.gif'));?></div>
        </div>
        <?php $atr = array("name"=>"frm_login","id"=>"frm_login","method"=>"post");
	  echo form_open("user/login_user",$atr);
         ?><span id="frm_err"></span>
          <label>Enter your username or email address</label>
          <?php if($this->input->cookie('mem_login_info')!=''){                   
                  $user_info_arr = explode("/",$this->input->cookie('mem_login_info'));
                    ?>
          <input name="uemail" type="text" id="uemail" value="<?php echo $user_info_arr[0];?>">   
          <label class="error" id="uemail_error"></label>       
          <label>Enter your password</label>
          <input name="upassword" type="password" id="upassword" value="<?php echo $user_info_arr[1];?>">
           <label class="error" id="upwd_error"></label> <div class="blanks">
              <?php }else{?>
              <input name="uemail" type="text" id="uemail">  
              <label class="error" id="uemail_error"></label>        
          <label>Enter your password</label>
          <input name="upassword" type="password" id="upassword">
           <label class="error" id="upwd_error"></label> <div class="blanks">
              <?php }?>
            <input name="submit" type="submit" id="usubmit" value="Sign In">
            <input name="new_user" type="submit" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none'; document.getElementById('light1').style.display='block';document.getElementById('fade1').style.display='block'" value="New User? Register">
           
          </div>
          <div class="clear"></div>
          <div class="blanks1">
            <input name="rem_check" id="rem_check" type="checkbox">
            Remember Me</div>
          <div class="blanks2"> <a href="javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';document.getElementById('light_forgot_pwd').style.display='block';document.getElementById('fade3').style.display='block';">Forgot your password?</a><br/>
            <a href="javascript:void(0)" onclick = "document.getElementById('light').style.display='none';document.getElementById('fade').style.display='none';document.getElementById('light_forgot_uname').style.display='block';document.getElementById('fade4').style.display='block';">Forgot your username?</a> </div>
       <?php echo form_close(); ?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div id="fade" class="black_overlay"></div>
<!--sign in lightbox popup end--> 

<!--register lightbox popup-->
<div id="light1" class="white_content">
  <div class="sign-mainb">
    <div class="close-light"><a href = "javascript:void(0)" onclick = "document.getElementById('light1').style.display='none';document.getElementById('fade1').style.display='none';location.reload()">Close</a></div>
    <div class="clear"></div>
    <div class="light-pad">
      <div class="main-light">
          <h1><img src="<?php echo USER_SIDE_IMAGES;?>shield2.png"  alt="shield"> Register to create an account</h1>
         
           <div id="loder3" style="height:100%; width:100%; text-align:center; position:absolute; background-color:#000000; opacity:0.50; left:0;top:0; display: none;">
            <div style="position:relative; left:0px; top:45%;"><?php echo img(array('src'=>USER_SIDE_IMAGES.'ajax-loader.gif'));?></div>
        </div>
          
        <?php $atr = array("name"=>"frm_register","id"=>"frm_register","method"=>"post");
	  echo form_open("user/register",$atr);
         ?>
          <label>Create your username<span>(alphanumeric, no more than 32 characters)</span></label>
          <input name="uname" id="uname"type="text">
          <label>Email Address<span>(we won't spam you!)</span></label>
          <input name="email" id="email" type="text">
          <span id="u_mail_err"></span>
          <label>Password</label>
          <input name="password" id="password" type="password">
          <label>Repeat<span>(for confirmation)</span></label>
          <input name="cpassword" id="cpassword"type="password">
          <div class="blanks">
            <input name="submit" type="submit" id="submitbtn" value="CONTINUE">          
          </div>
        <?php echo form_close(); ?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div id="fade1" class="black_overlay"></div>
<!--register lightbox popup end-->


<?php
if($this->session->userdata('uname')!='')
{
?>
<script>
    document.getElementById('light_step2').style.display='block';
    document.getElementById('fade2').style.display='block';
</script>
<?php }?>

<!--register lightbox popup Step2-->
<div id="light_step2" class="white_content" style="top: 1%;">
  <div class="sign-mainb">    
    <div class="clear"></div>
    <div class="light-pad">
      <div class="main-light">
        <h1><img src="<?php echo USER_SIDE_IMAGES;?>shield2.png"  alt="shield"> You are Registered. Fill This form or Skip it.</h1>
        <?php $atr = array("name"=>"frm_register_step2","id"=>"frm_register_step2","method"=>"post");
	  echo form_open("user/register_step2",$atr);
         ?>
        <table width="100%" class="reg-table">
            <tr>
                <td width="50%"><label>First Name*</label>
          <input name="fname" id="fname"type="text"></td>
                <td width="50%"><label>Last Name*</label>
          <input name="lname" id="lname" type="text">  
          <!-- Dont Delete--></td>
            </tr>
            
             <tr>
                <td><label>Address*</label>
          <input name="uaddress" id="uaddress" type="text">    </td>
                <td><label>Address Add On</label>
          <input name="uaddressaddon" id="uaddressaddon" type="text">    </td>
            </tr>
            
            <tr>
                <td> <label>Zip Code*</label>
          <input name="uzipcode" id="uzipcode" type="text"> </td>
                <td><label>Phone*</label>
          <input name="phone" id="phone" type="text"></td>
            </tr>
            
            <tr>
                <td><label>City*</label>
          <input name="city" id="city" type="text"></td>
                <td> &nbsp;</td>
            </tr>
            <tr>            
                <td colspan="2"> 
                <label>Country*</label>         
          <select name="country" id="country" style="margin-bottom: 7px;">
              <?php
              $countryList = _getCountryList();
              foreach ($countryList as $key => $val)
              {
                  ?>
                  <option value="<?php echo $key; ?>" onclick="changeState('<?php echo $key; ?>');"><?php echo $val; ?></option>
              <?php } ?>                                   
          </select>          
         <br/>
          <label>State*</label>
          <select name="state" id="state">
              <option>Choose your state</option>
          </select><br/>      
          <label>Interested In</label>
          <input type="checkbox" name="inter[]" value="OF">Offers<br />
          <input type="checkbox" name="inter[]" value="GC">Gift Cards<br />
          <input type="checkbox" name="inter[]" value="RT">Restaurants<br />
           <input type="checkbox" name="inter[]" value="SP">Service providers<br />
            <input type="checkbox" name="inter[]" value="EV">Events<br /> <br/>        
           <input type="checkbox" name="subscr">Subscribe to news letter<br />  <br /><br />     
          <div class="blanks">
            <input name="submit" type="submit" value="Submit">
            <input name="skip" class="cancel" type="submit"  value="Skip">
            <label id="confirm_link"></label>                
                </td> </tr>
        </table>
          </div>
        <?php echo form_close(); ?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div id="fade2" class="black_overlay"></div>
<!--register lightbox popup Step2 end-->


<!--register lightbox popup Step2-->
<div id="light_forgot_pwd" class="white_content" style="top: 1%;">
  <div class="sign-mainb">    
      <div class="close-light"><a href = "javascript:void(0)" onclick = "document.getElementById('light_forgot_pwd').style.display='none';document.getElementById('fade3').style.display='none';location.reload()">Close</a></div>
    <div class="clear"></div>
    <div class="light-pad">
      <div class="main-light"> 
           <?php $atr = array("name"=>"frm_forgot_pwd","id"=>"frm_forgot_pwd","method"=>"post");
	  echo form_open("forgot_pwd/submitForm",$atr);
         ?>
          <label>Enter Your Email Address</label>
          <input name="forg_email" id="forg_email"type="text">            
          <div class="blanks">
            <input name="submit" type="submit" value="Submit">
             <label id="forgot_pwd_link"></label>
          </div> 
           <?php echo form_close(); ?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div id="fade3" class="black_overlay"></div>
<!--register lightbox popup Step2 end-->


<!--register lightbox popup Step2-->
<div id="light_forgot_uname" class="white_content" style="top: 1%;">
  <div class="sign-mainb">    
      <div class="close-light"><a href = "javascript:void(0)" onclick = "document.getElementById('light_forgot_uname').style.display='none';document.getElementById('fade4').style.display='none';location.reload()">Close</a></div>
    <div class="clear"></div>
    <div class="light-pad">
      <div class="main-light"> 
           <?php $atr = array("name"=>"frm_forgot_uname","id"=>"frm_forgot_uname","method"=>"post");
	  echo form_open("forgot_uname/submitForm",$atr);
         ?>
          <label>Enter Your Email Address</label>
          <input name="uname_forg_email" id="uname_forg_email"type="text">            
          <div class="blanks">
            <input name="submit" type="submit" value="Submit">
             <label id="forgot_uname_link"></label>
          </div> 
           <?php echo form_close(); ?>
      </div>
      <div class="clear"></div>
    </div>
    <div class="clear"></div>
  </div>
</div>
<div id="fade4" class="black_overlay"></div>
<!--register lightbox popup Step2 end-->
