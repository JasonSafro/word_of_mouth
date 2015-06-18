<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome</title>
<?php  
/**
* @package		CodeIgniter
* @author		Rajesh patil
* @copyright	Copyright (c) 2011, Ashore system Pvt. Ltd.
* @filesource

1] css_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\css) folder 
2] js_asset - This function is use to call all js  files from the (C:\xampp\htdocs\framework\assets\scripts) folder 
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
 				$("input.focus").focus(function () {
					if (this.value == this.defaultValue) {
						this.value = "";
					}
					else {
						this.select();
					}
				});

				$("input.focus").blur(function () {
					if ($.trim(this.value) == "") {
						this.value = (this.defaultValue ? this.defaultValue : "");
					}
				});

				$("input:submit, input:reset").button();
			});
		</script>
<script language="javascript"  type="text/javascript">
 
function validateForm(contact)
{
	if(""==document.forms.myform.username.value)
	{
		document.getElementById('un').innerHTML = 'Please enter Username.';
		document.forms.myform.username.focus();
		return false;
	}
	else
	{
		document.getElementById('un').innerHTML = '';
	}
	
	if(""==document.forms.myform.password.value)
	{
		document.getElementById('pw').innerHTML = 'Please enter Password.';
		document.forms.myform.password.focus();
		return false;
	}
	else
	{
		document.getElementById('pw').innerHTML = '';
	}
 
}
 
</script>
<!-- Jquery form validations for login form ends -->
<?php @$javascript ?>
</head>
<body>
<div id="login">
  <!-- login -->
  <div class="title">
    <h5>Sign In to Admin</h5>
    <div class="corner tl"></div>
    <div class="corner tr"></div>
  </div>
  <?php  if($this->session->flashdata('item') != '') {	 ?>
  <div class="messages">
    <div id="message-error" class="message message-error" >
      <div class="image"> <?php echo img(array('src'=>'assets/images/icons/error.png','border'=>'0','height'=>'32','alt'=>'Error')); ?> </div>
      <div class="text">
        <!--<h6>Error Message</h6>-->
        <span><?php echo $this->session->flashdata('item'); ?></span> </div>
      <div class="dismiss"><script>$('#message-error').fadeOut(2000);</script><a href="#message-error"></a> </div>
    </div>
  </div>
  <?php } ?>
  <div class="inner"> <span  style="text-align:center; font-size:12px; color:#FF0000;"><?php echo validation_errors(); ?></span> <br/>
<?php $attributes = array( 'name' => 'myform','id' => 'myform','onSubmit' => 'return validateForm(myform);');
	  echo form_open('admin/welcome/login', $attributes);
?>
    <div class="form">
      <!-- fields -->
      <div class="fields">
        <div class="field">
          <div class="label">
            <label for="username">Username:</label>
          </div>
          <div class="input">
            <input type="text" id="username" maxlength="12" name="username" size="40" onBlur="return validateForm(myform);" tabindex="1" />
			 <div id="un" style="color:#FF0000;"></div>
          </div>
        </div>
        <div class="field">
          <div class="label">
            <label for="password">Password:</label>
          </div>
          <div class="input">
            <input type="password" id="password" name="password" maxlength="12" size="40" onBlur="return validateForm(myform);" tabindex="2" />
			 <div id="pw" style="color:#FF0000;"></div>
            <!--value="password" class="focus" -->
          </div>
        </div>
        <div class="field">
          <div class="checkbox">
            <input type="checkbox" id="remember" name="remember" />
            <label for="remember">Remember me</label>
          </div>
        </div>
        <div class="buttons">
          <input type="submit" value="Sign In" name="submitlogin" />
        </div>
      </div>
      <!-- end fields -->
      <!-- links -->
      <div class="links"> <?php echo anchor('admin/forgot/','Forgot your password?' , 'title="Forgot password"'); ?> </div>
      <!-- end links -->
    </div>
    <?php  echo form_close();	?>
  </div>
  <!-- end login -->
</div>
</body>
</html>
