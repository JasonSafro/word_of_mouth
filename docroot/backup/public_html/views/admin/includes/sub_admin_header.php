<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Sub-Admin Panel</title>
<script>
var SITE_ROOT_JS_VARIABLE_IN_HEADER_FILE="<?php echo site_url(''); ?>";
</script>
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
echo js_asset('admin_functions.js');

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
        //$("#myTable").tablesorter(); 
    } 
); 
</script>
<script type="text/javascript" src="<?php echo base_url();?>assets/plugins/ckeditor/ckeditor.js"></script>
 </head>
	<body>
    <div id="wrapper">
        <?php $segnemt = ''; if(!empty($this->uri->segments[2])) { $segnemt = $this->uri->segments[2]; }?>
  	<!-- header -->
 		<div id="header">
			<!-- logo -->
			<div id="logo">			
                        <h1><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home', img(array('src' => 'assets/images/logo.png', 'border' => '0', 'width'=>'150','height'=>'50', 'alt' => ADMIN_FOLDER_NAME.'')), 'title="Sub-Admin"'); ?></h1>
			</div>
			<!-- end logo -->
			<!-- user -->
			<ul id="user">
				<li class="first"><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home','Account' , 'title="Account"'); ?></li>
 				<li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home','Messages (0)' , 'title="Messages"'); ?></li>
                                <li><?php echo anchor(ADMIN_FOLDER_NAME.'/welcome/sub_admin_logout','Logout' , 'title="Logout"'); ?></li>
				<li class="highlight last"><?php   $atts = array('title' => 'View Site','target' => '_blank'); echo anchor('welcome/', 'View Site', $atts); ?></li>
		 	</ul>
			<!-- end user -->
                        
			<div id="header-inner">
				<div id="home">
 					<?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home','&nbsp;' , 'title="Home"'); ?>
				</div>
				<!-- quick -->
				<div id="navigation">
        		<div id="smoothmenu1" class="ddsmoothmenu">
				<ul>
				<li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sub_admin_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home', 'Dashboard',array('title'=>'Dashboard','class'=>$cond)); 
                                     ?>
				</li>
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sub_admin_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home', 'Listing',array('title'=>'Listing','class'=>$cond)); 
                                     ?>
                                     <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home','Add Listing' , 'title="Add Listing"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home','View Listing' , 'title="View Listing"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home','Listing Claims' , 'title="Listing Claims"'); ?></li>
                                    </ul>
                                </li>
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sub_admin_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home', 'Disputed Reviews',array('title'=>'Disputed Reviews','class'=>$cond)); 
                                     ?>                                     
                                </li>
                                
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sub_admin_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home', 'Manage Members',array('title'=>'Manage Members','class'=>$cond)); 
                                     ?>                                     
                                </li>
                                
                                 <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sub_admin_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sub_admin_home', 'Manage ad sections',array('title'=>'Manage ad sections','class'=>$cond)); 
                                     ?>                                     
                                </li>
                                
                                
                              
				 </div>
	            </div>
				 <!-- end quick -->
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
		</div>
		<!-- end header -->