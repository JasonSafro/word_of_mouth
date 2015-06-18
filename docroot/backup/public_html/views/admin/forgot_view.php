<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome </title>
<?php  

/**
* @package		CodeIgniter
* @author		Rajesh patil
* @copyright	Copyright (c) 2011, Ashore system Pvt. Ltd.
* @filesource

1] css_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\css) folder 
2] js_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\script) folder 
3] img - this function is used for call or display images files from  the (C:\xampp\htdocs\framework\assets\images) folder 
*/
echo css_asset('reset.css');
echo css_asset('style.css');
echo css_asset('colors/blue.css');

echo js_asset('jquery-1.6.4.min.js');
echo js_asset('jquery.validate.js');
echo js_asset('jquery-ui-1.8.16.custom.min.js');
echo js_asset('smooth.js');
?>
	<script type="text/javascript">

			$(document).ready(function ()
			 {
				style_path = "<?php echo SITE_ROOT; ?>assets/css/colors";
 				 

				$("input:submit, input:reset").button();
			});
		</script>     
<!-- Jquery form validations for login form starts -->        
	<script type="text/javascript">
  			$(document).ready(function() {
			var validator = $("#myform").validate({
				rules: {
                    	email:
                        {
                            required: true,
                            email: true
                        }
            	 },
   				 messages:
                 {
						email:
						{
							required: "Please enter email.",
							email: "Please enter valid email."
						}
                  },	
						success: function(label) {
						label.html("&nbsp;").addClass("error");
					}			
				});
			});
   </script>
<!-- Jquery form validations for login form ends -->            
</head>
<body>
 <div id="login">
			<!-- login -->
			<div class="title">
				<h5>Forgot Password</h5>
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
			<div class="messages">
				<div id="message-error" class="message message-error" style="display:none;">
					<div class="image">
                <?php echo img(array('src'=>ADMIN_SIDE_IMAGES.'icons/error.png','border'=>'0','height'=>'32','alt'=>'Error')); ?> 
					</div>
					<div class="text">
						<h6>Error Message</h6>
						<span>This is the error message.</span>
					</div>
					<div class="dismiss">
						<a href="#message-error"></a>
					</div>
				</div>
			</div>
			<div class="inner">
            <?php
				$attributes = array( 'name' => 'myform','id' => 'myform');
				echo form_open('admin/home/forgot', $attributes);
			?>
		   <div class="form">
					<!-- fields -->
 					<div class="fields">
						<div class="field">                       	  
							<div class="label"><label for="username">Email Address:</label></div>
							<div class="input"><input type="text" id="email" name="email" size="40"  /> </div>
                             <div class="label">&nbsp;</div>
							<div class="input">&nbsp;</div>
 							</div>                            
                           <div class="buttons"> <input type="submit" value="Send" /></div>
						</div>
					<!-- end fields -->
                    <div class="links">
					<?php echo anchor('admin/welcome/','Login' , 'title="Login"'); ?>
            		</div>
		 		</div>
                  <?php  echo form_close();	?>
            </div>
			<!-- end login -->			 
		</div>
	</body>
</html>