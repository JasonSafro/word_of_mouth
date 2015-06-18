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
/*echo css_asset('admin.css');
echo css_asset('admin_left_menu.css');
echo css_asset('sdmenu.css');
echo css_asset('admin.css');

echo js_asset('runOnLoad.js');
echo js_asset('cjs.js');
echo js_asset('commonJs.js');
echo js_asset('sdmenu.js');*/


?>
</head>
<body>

<div id="container">
 

	<div id="body">
		<?php echo img(array('src'=>'assets/images/Website-Under-Construction-template.jpg','border'=>'0','height'=>'560','width'=>'1360','alt'=>'Error')); ?>
	</div>

	<!--<p class="footer">Page rendered in <strong>{elapsed_time}</strong> seconds</p>-->
</div>

</body>
</html>