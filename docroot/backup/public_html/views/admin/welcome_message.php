<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to CodeIgniter</title>

<?php  
/**
* @package		CodeIgniter
* @author		Rajesh patil
* @copyright	Copyright (c) 2011, Ashore system Pvt. Ltd.
* @filesource

1] css_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\css) folder 
2] js_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\images) folder 

*/
echo css_asset('reset.css');
echo css_asset('style.css');
echo css_asset('colors/blue.css');

echo js_asset('jquery-1.6.4.min.js"');
echo js_asset('jquery-ui-1.8.16.custom.min.js"');
echo js_asset('smooth.js"');
/*echo css_asset('admin.css');
echo css_asset('admin_left_menu.css');
echo css_asset('sdmenu.css');
echo css_asset('admin.css');

echo js_asset('runOnLoad.js');
echo js_asset('cjs.js');
echo js_asset('commonJs.js');
echo js_asset('sdmenu.js');*/


?>
<script type="text/javascript">
			$(document).ready(function () {
				style_path = <?php echo SITE_ROOT; ?>"assets/resources/css/colors";

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
</head>
<body>

		<div id="login">
			<!-- login -->
			<div class="title">
				<h5>Sign In to Admin</h5>
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
			<div class="messages">

				<div id="message-error" class="message message-error" style="display:none;">
					<div class="image">
						<img src="resources/images/icons/error.png" alt="Error" height="32" />
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
				<form action="index.html" method="get">
				<div class="form">
					<!-- fields -->
 <span  style="text-align:center; font-size:14px; color:#FF0000;"><?php if($this->session->flashdata('login_flash')) {echo $this->session->flashdata('login_flash'); } ?></span>  </tr>
					<div class="fields">
						<div class="field">
							<div class="label">
								<label for="username">Username:</label>
							</div>
							<div class="input">
								<input type="text" id="username" name="username" size="40" value="admin" class="focus" />
							</div>

						</div>
						<div class="field">
							<div class="label">
								<label for="password">Password:</label>
							</div>
							<div class="input">
								<input type="password" id="password" name="password" size="40" value="password" class="focus" />
							</div>

						</div>
						<div class="field">
							<div class="checkbox">
								<input type="checkbox" id="remember" name="remember" />
								<label for="remember">Remember me</label>
							</div>
						</div>
						<div class="buttons">

							<input type="submit" value="Sign In" />
						</div>
					</div>
					<!-- end fields -->
					<!-- links -->
					<div class="links">
						<a href="index.html">Forgot your password?</a>
					</div>

					<!-- end links -->
				</div>
				</form>
			</div>
			<!-- end login -->
			<div id="colors-switcher" class="color">
				<a href="" class="blue" title="Blue"></a>
				<a href="" class="green" title="Green"></a>
				<a href="" class="brown" title="Brown"></a>

				<a href="" class="purple" title="Purple"></a>
				<a href="" class="red" title="Red"></a>
				<a href="" class="greyblue" title="GreyBlue"></a>
			</div>
		</div>
	</body>
</html>