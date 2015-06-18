<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Sales Representative Panel</title>
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
                        <h1><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', img(array('src' => 'assets/images/logo.png', 'border' => '0', 'width'=>'150','height'=>'50', 'alt' => ADMIN_FOLDER_NAME.'')), 'title="Sales Representative"'); ?></h1>
			</div>
			<!-- end logo -->
			<!-- user -->
			<ul id="user">
				<li class="first"><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','Account' , 'title="Account"'); ?></li>
 				<li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','Messages (0)' , 'title="Messages"'); ?></li>
                                <li><?php echo anchor(ADMIN_FOLDER_NAME.'/welcome/sales_rep_logout','Logout' , 'title="Logout"'); ?></li>
				<li class="highlight last"><?php   $atts = array('title' => 'View Site','target' => '_blank'); echo anchor('welcome/', 'View Site', $atts); ?></li>
		 	</ul>
			<!-- end user -->
                        
			<div id="header-inner">
				<div id="home">
 					<?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','&nbsp;' , 'title="Home"'); ?>
				</div>
				<!-- quick -->
				<div id="navigation">
        		<div id="smoothmenu1" class="ddsmoothmenu">
				<ul>
				<li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Dashboard',array('title'=>'Dashboard','class'=>$cond)); 
                                     ?>
				</li>
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Lead Details',array('title'=>'Lead Details','class'=>$cond)); 
                                     ?>
                                    <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','Add Lead Details' , 'title="Add Lead Details"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','Edit Lead Details' , 'title="Edit Lead Details"'); ?></li>                                       
                                    </ul>
				</li>
                                
                                 <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Assigned Leads',array('title'=>'Assigned Leads','class'=>$cond)); 
                                     ?>                                  
				</li>
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'New Tasks',array('title'=>'New Tasks','class'=>$cond)); 
                                     ?>                                  
				</li>
                                
                                 <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Add Notes',array('title'=>'Add Notes','class'=>$cond)); 
                                     ?>                                  
				</li>
                                
                                 <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Log Phone Call',array('title'=>'Log Phone Call','class'=>$cond)); 
                                     ?>                                  
				</li>
                                 
                                 <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Convert',array('title'=>'Convert','class'=>$cond)); 
                                     ?>                             
                                     <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','Lead To Opportunity' , 'title="Lead To Opportunity"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home','Opportunity To Member' , 'title="Opportunity To Member"'); ?></li>                                       
                                    </ul>
				</li>
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Listings and Reviews',array('title'=>'Listings and Reviews','class'=>$cond)); 
                                     ?>                                  
				</li>
                                
                                
                                
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'home/sales_rep_home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home/sales_rep_home', 'Add Credit Card Details ',array('title'=>'Add Credit Card Details ','class'=>$cond)); 
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