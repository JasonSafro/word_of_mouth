<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Welcome to Admin Panel</title>
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
<link rel="shortcut icon" href="<?php echo USER_SIDE_IMAGES;?>wom-20130603-favicon.ico.png"/>
 </head>
	<body>
    <div id="wrapper">
        <?php $segnemt = ''; if(!empty($this->uri->segments[2])) { $segnemt = $this->uri->segments[2]; }?>
  	<!-- header -->
 		<div id="header">
			<!-- logo -->
			<div id="logo">			
                        <h1><?php echo anchor(ADMIN_FOLDER_NAME.'/home/', img(array('src' => 'assets/images/logo.png', 'border' => '0', 'width'=>'150','height'=>'50', 'alt' => ADMIN_FOLDER_NAME.'')), 'title="Admin"'); ?></h1>
			</div>
			<!-- end logo -->
			<!-- user -->
			<ul id="user">
				<li class="first"><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_admin_account/','Account' , 'title="Account"'); ?></li>
 				<li><?php echo anchor(ADMIN_FOLDER_NAME.'/home/','Messages (0)' , 'title="Messages"'); ?></li>
                                <li><?php echo anchor(ADMIN_FOLDER_NAME.'/welcome/logout','Logout' , 'title="Logout"'); ?></li>
				<li class="highlight last"><?php   $atts = array('title' => 'View Site','target' => '_blank'); echo anchor('welcome/', 'View Site', $atts); ?></li>
		 	</ul>
			<!-- end user -->
                        
			<div id="header-inner">
				<div id="home">
 					<?php echo anchor(ADMIN_FOLDER_NAME.'/home','&nbsp;' , 'title="Home"'); ?>
				</div>
				<!-- quick -->
				<div id="navigation">
        		<div id="smoothmenu1" class="ddsmoothmenu">
				<ul>
				<li>
                                    <?php 
                                        $cond = ($segnemt == 'home' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/home', 'Dashboard',array('title'=>'Dashboard','class'=>$cond)); 
                                     ?>
				</li>
                                
                                <?php 
                                $adminType=$this->session->userdata('adm_type');
                                if($adminType=='AD'){//it means admin, not sub admin
                                ?>
                                <!-- Manage Sub-Admins-->
                                  <li>
                                    <?php 
                                        $cond = ($segnemt == 'manage_subadmin' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/manage_subadmin', 'Sub-Admin',array('title'=>'Sub-Admin','class'=>$cond)); 
                                     ?>   
                                       <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_subadmin/add_new','Add Sub-Admin' , 'title="Add Sub-Admin"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_subadmin/','View Sub-Admins' , 'title="View Sub-Admins"'); ?></li> 
                                          <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_subadmin/deleted_subadmins','Deleted Sub-Admins ' , 'title="Deleted Sub-Admins"'); ?></li>
                                    </ul>
                                    </li>
                                <?php 
                                }?>
                                    <!--Manage Sales Manager and Reps-->
                                <!--<li>
                                    <?php 
                                        $cond = ($segnemt == 'manage_sales_mgr' || $segnemt == 'manage_sales_rep'  ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/', 'Sales Manager and Reps',array('title'=>'Sales Manager','class'=>$cond)); 
                                     ?> 
                                    <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_mgr', 'Manage Sales Manager',array('title'=>'Manage Sales Manager','class'=>$cond));?></li>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_rep', 'Manage Sales Representatives',array('title'=>'Manage Sales Representatives','class'=>$cond));?></li>                                       
                                   </ul>
                                    </li>-->
                                
                                
                                 <!-- Manage Sales Manager-->
                                  <li>
                                    <?php 
                                        $cond = ($segnemt == 'manage_sales_mgr' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_mgr', 'Sales Manager',array('title'=>'Sales Manager','class'=>$cond)); 
                                     ?>   
                                       <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_mgr/add_new','Add Sales Manager' , 'title="Add Sales Manager"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_mgr/','View Sales Managers' , 'title="View Sales Managers"'); ?></li> 
                                          <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_mgr/deleted_salesmgrs','Deleted Sales Managers' , 'title="Deleted Sales Managers"'); ?></li>
                                    </ul>
                                    </li>
                                    
                                     <!-- Manage Reps-->
                                  <li>
                                    <?php 
                                        $cond = ($segnemt == 'manage_sales_rep' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_rep', 'Sales Representatives',array('title'=>'Sales Representatives','class'=>$cond)); 
                                     ?>   
                                       <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_rep/add_new','Add Sales Representative' , 'title="Add Sales Representative"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_rep/','View Sales Representatives' , 'title="View Sales Representatives"'); ?></li> 
                                          <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_rep/deleted_salesreps','Deleted Sales Representatives ' , 'title="Deleted Sales Representatives"'); ?></li>
                                    </ul>
                                    </li>
                                    
                                    
                                    
				<li>
                                    <?php 
                                        $cond = ($segnemt == 'user' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/user', 'Users',array('title'=>'Users','class'=>$cond)); 
                                     ?>
                                     <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/user/add_new','Add User' , 'title="Add User"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/user','Registered Users' , 'title="Registered Users"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/user/deleted_users','Deleted Users' , 'title="Deleted Users"'); ?></li>
                                    </ul>
                                </li>
				<li>
                                    <?php 
                                        $cond = ($segnemt == 'static_pages' || $segnemt == 'email_content' || $segnemt=='manage_testimonials' || $segnemt=='manage_slider' || $segnemt=='manage_footer_videos' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/static_pages', 'Site Contents',array('title'=>'Site Contents','class'=>$cond)); 
                                     ?>
                                    <ul>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/static_pages','Static Pages' , 'title="Static Pages"'); ?></li>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_faq','Manage FAQ' , 'title="Manage FAQ"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/email_content','Email Contents' , 'title="Email Contents"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_testimonials','Testimonials' , 'title="Testimonials"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_slider','Home page slider' , 'title="Manage home page slider"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_footer_videos','Footer videos' , 'title="Manage footer videos"'); ?></li>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/how_it_works_videos','How it works videos' , 'title="Manage how it works videos"'); ?></li>
                                    </ul>
                                </li>
                                
                                <!-- Manage Category-->
                                  <li>
                                    <?php 
                                        $cond = ($segnemt == 'category' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/category', 'Category',array('title'=>'Manage Category','class'=>$cond)); 
                                     ?>                                     
                                    </li>
                                    
                                 
                                
                                <!--Contact Us-->
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'contact_us' || $segnemt == 'setting' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/contact_us', 'Contact Us',array('title'=>'Contact Us','class'=>$cond)); 
                                     ?> 
                                    <ul>
                                        <li><?php echo anchor(ADMIN_FOLDER_NAME.'/contact_us', 'Contact Us Messages',array('title'=>'Contact Us','class'=>$cond));?></li>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/setting', 'Contact Us Address',array('title'=>'Contact Us Address','class'=>$cond));?></li>                                       
                                    </ul>
                                    </li>                                    
                                  
                                
				<li>
                               
                                 <!--SETTINGS-->
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'subscription_plans' || $segnemt == 'sub_subscription_plans' || $segnemt == 'manage_services' ? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/subscription_plans', 'Settings',array('title'=>'Settings','class'=>$cond)); 
                                     ?> 
                                    <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/subscription_plans', 'Subscription Plans',array('title'=>'Manage Subscription Plans','class'=>$cond));?></li>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/sub_subscription_plans', 'Monthly/Annually Plans',array('title'=>'Manage Monthly/Annually Plans','class'=>$cond));?></li>                                       
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_services', 'Services',array('title'=>'Manage Services','class'=>$cond));?></li> 
										 <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_promocodes', 'Promo Codes',array('title'=>'Manage Promo Codes','class'=>$cond));?></li> 
                                    </ul>
                                </li>
                                
                                 <!--MANAGE-->
                                <li>
                                    <?php 
                                        $cond = ($segnemt == 'manage_jobs' || $segnemt == 'manage_reviews' || $segnemt == 'manage_deals' || $segnemt == 'reasons' || $segnemt == 'manage_claims'? 'selected' : '');
                                        echo anchor(ADMIN_FOLDER_NAME.'/manage_jobs', 'Manage',array('title'=>'Manage','class'=>$cond)); 
                                     ?> 
                                    <ul>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_jobs', 'Manage Jobs',array('title'=>'Manage Jobs','class'=>$cond));?></li>
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_deals', 'Manage Deals',array('title'=>'Manage Deals','class'=>$cond));?></li>                                       
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_reviews', 'Manage Reviews',array('title'=>'Manage Reviews','class'=>$cond));?></li> 
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/reasons', 'Manage Reasons',array('title'=>'Manage Reasons','class'=>$cond));?></li> 
                                         <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_claims', 'Manage Claims',array('title'=>'Manage Claims','class'=>$cond));?></li> 
                                       <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_newsletter', 'Manage Newsletter',array('title'=>'Manage Newsletter','class'=>$cond));?></li> 									   <li><?php echo anchor(ADMIN_FOLDER_NAME.'/manage_listing', 'Manage Listing',array('title'=>'Manage Listing','class'=>$cond));?></li>
                                    </ul>
                                </li>
                                
                                
                                 
				</ul>
				 </div>
	            </div>
				 <!-- end quick -->
				<div class="corner tl"></div>
				<div class="corner tr"></div>
			</div>
		</div>
		<!-- end header -->