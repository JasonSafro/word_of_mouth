<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Admin Panel</title>
<?php  
/**
* @package		CodeIgniter
* @author		Rajesh patil
* @copyright	Copyright (c) 2011, Ashore system Pvt. Ltd.
* @filesource

1] css_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\css) folder 
2] js_asset - This function is use to call all css files from the (C:\xampp\htdocs\framework\assets\images) folder 
3] img - this function is used for call or display images files from  the (C:\xampp\htdocs\framework\assets\images) folder 
*/

echo css_asset('reset.css');
echo css_asset('style.css');
echo css_asset('colors/blue.css');
echo css_asset('ddsmoothmenu.css');

echo js_asset('jquery-1.6.4.min.js');
echo js_asset('jquery-ui-1.8.16.custom.min.js');
echo js_asset('jquery.ui.selectmenu.js');
echo js_asset('jquery.flot.min.js');
echo js_asset('tiny_mce/tiny_mce.js');
echo js_asset('tiny_mce/jquery.tinymce.js');
echo js_asset('smooth.js');
echo js_asset('smooth.menu.js');
echo js_asset('smooth.table.js');
echo js_asset('smooth.form.js');
echo js_asset('smooth.dialog.js');
echo js_asset('smooth.autocomplete.js');
echo js_asset('ddsmoothmenu.js');
echo js_asset('jquery.tablesorter.js');

?>
<script type="text/javascript">
ddsmoothmenu.init({
	mainmenuid: "smoothmenu1", //menu DIV id
	orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu', //class added to menu's outer DIV
	//customtheme: ["#1c5a80", "#18374a"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

ddsmoothmenu.init({
	mainmenuid: "smoothmenu2", //Menu DIV id
	orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
	classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
	//customtheme: ["#804000", "#482400"],
	contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})

$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
); 
</script>
 </head>
	<body>
    <div id="wrapper">
  	<!-- header -->
 		<div id="header">
			<!-- logo -->
			<div id="logo">
			<h1><?php echo anchor('admin/home/', img(array('src'=>'assets/images/logo.png','border'=>'0','width'=>'150','height'=>'50','alt'=>'Admin')), 'title="Admin"'); ?></h1>
			</div>
			<!-- end logo -->
			<!-- user -->
			<ul id="user">
				<li class="first"><?php echo anchor('admin/home/','Account' , 'title="Account"'); ?></li>
 				<li><?php echo anchor('admin/home/','Messages (0)' , 'title="Messages"'); ?></li>
                <li><?php echo anchor('admin/welcome/logout','Logout' , 'title="Logout"'); ?></li>
				<li class="highlight last"><?php   $atts = array('title' => 'View Site','target' => '_blank'); echo anchor('welcome/', 'View Site', $atts); ?></li>
		 		</ul>
			<!-- end user -->
			<div id="header-inner">
				<div id="home">
 					<?php echo anchor('admin/home','&nbsp;' , 'title="Home"'); ?>
				</div>
				<!-- quick -->
				<div id="navigation">
        		<div id="smoothmenu1" class="ddsmoothmenu">
				<ul>
				<li><?php if($page_tab == 'dashboard') { echo anchor('admin/home', 'Dashboard',array('title'=>'Dashboard','class'=>'selected')); }
						  else { echo anchor('admin/home', 'Dashboard',array('title'=>'Dashboard','class'=>'')); } ?>
				</li>
				<li><?php if($page_tab == 'user'){ echo anchor('admin/user/userlist', 'Manage User\'s',array('title'=>'Manage User\'s','class'=>'selected')); }
						  else{ echo anchor('admin/home', 'Manage User\'s',array('title'=>'Manage User\'s','class'=>'')); } ?>
				</li>
				<li><?php echo anchor('admin/home','Manage Content' , 'title="Manage Content"'); ?></li>
				<li><?php echo anchor('admin/home','Manage Blog' , 'title="Manage Blog"'); ?></li>
				<li><?php echo anchor('admin/home','Manage Forum' , 'title="Manage Forum"'); ?></li>
				<li><?php echo anchor('admin/home','Manage Event\'s' , 'title="Manage Event\'s"'); ?></li>
				<li><?php echo anchor('admin/home','Manage Gallery' , 'title="Manage Gallery"'); ?></li>
				<li><?php echo anchor('admin/home','Manage Video\'s' , 'title="Manage Video\'s"'); ?></li>
				<li><?php echo anchor('admin/home','Manage Setting\'s' , 'title="Manage Setting\'s"'); ?></li>
				</ul>
				 </div>
	            </div>
				 <!-- end quick -->
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
		</div>
		<!-- end header -->