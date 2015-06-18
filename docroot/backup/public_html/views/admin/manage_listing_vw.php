<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Business Listing</h5>
        <div class="search">
          
        </div> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
                
                    <div style="margin-top:-18px;">
                         <?php
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_listing/add';                   
                    ?>
                   <input type="button" name="addnewsletterBtn" class="ui-button custom-default-button" value="Add Listing" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
             $attr = array('name' => 'frmaddlisting', 'id' => 'frmaddlisting', 'autocomplete' => 'off', 'method' => 'post');
             $form_url = ADMIN_FOLDER_NAME.'/manage_listing/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                               
                                 <th width="4%" align="center" class="<?php echo ($sort_by=="buss_id" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'buss_id' && $sort_type == 'ASC' ? 'buss_id/DESC/' . $newOffset : 'buss_id/ASC/' . $newOffset);
                                    echo anchor($url, '#');
                                    ?>                                   
                                </th>
                                <th width="4%" align="center" class="selected" style="background: #E6EEEE;">Logo</th>
                                <th width="8%" align="left" class="<?php echo ($sort_by=="businessRepresentative" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'businessRepresentative' && $sort_type == 'ASC' ? 'businessRepresentative/DESC/' . $newOffset : 'businessRepresentative/ASC/' . $newOffset);
                                    echo anchor($url, 'Representative');
                                    ?>                                   
                                </th>
                                <th width="8%" align="left" style="background: #E6EEEE;">Category</th>
                                <th width="8%" align="left" class="<?php echo ($sort_by=="userFullName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'userFullName' && $sort_type == 'ASC' ? 'userFullName/DESC/' . $newOffset : 'userFullName/ASC/' . $newOffset);
                                    echo anchor($url, 'User Full Name');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="buss_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'buss_name' && $sort_type == 'ASC' ? 'buss_name/DESC/' . $newOffset : 'buss_name/ASC/' . $newOffset);
                                    echo anchor($url, 'Business Name');
                                    ?>                                   
                                </th>
                               <th width="7%" align="left" class="<?php echo ($sort_by=="buss_city" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'buss_city' && $sort_type == 'ASC' ? 'buss_city/DESC/' . $newOffset : 'buss_city/ASC/' . $newOffset);
                                    echo anchor($url, 'City');
                                    ?>                                   
                                </th>
                                
                                <th width="3%" align="left" class="<?php echo ($sort_by=="buss_zip_code" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'buss_zip_code' && $sort_type == 'ASC' ? 'buss_zip_code/DESC/' . $newOffset : 'buss_zip_code/ASC/' . $newOffset);
                                    echo anchor($url, 'Zip Code');
                                    ?>                                   
                                </th>
                                
                                <th width="4%" align="left" class="<?php echo ($sort_by=="bussCreatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'bussCreatedOn' && $sort_type == 'ASC' ? 'bussCreatedOn/DESC/' . $newOffset : 'bussCreatedOn/ASC/' . $newOffset);
                                     echo anchor($url, 'Created On');								
                                    ?>     
                                </th>                                     
                                 <!--<th width="4%" align="left" class="<?php echo ($sort_by=="bussUpdatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'bussUpdatedOn' && $sort_type == 'ASC' ? 'bussUpdatedOn/DESC/' . $newOffset : 'bussUpdatedOn/ASC/' . $newOffset);
                                    echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>-->
                                
                                <th width="3%" align="left" class="<?php echo ($sort_by=="bussStatus" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'bussStatus' && $sort_type == 'ASC' ? 'bussStatus/DESC/' . $newOffset : 'bussStatus/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                
                                <th width="6%" align="left" style="background: #E6EEEE;">Do</th>
                            </tr>
			</thead>
                        <?php  $count=1;                       
                        foreach($business_info as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['buss_id'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo $val['buss_id'];?></td>
                                   <td  align="center"><?php echo anchor('home/business_details/'.$val['buss_id'],img(array('src'=>base_url().'LOGO/'.$val['buss_logo'],'style'=>'float:left; width:100px; height:100px;')),'title="View Ad" target="_blanck"');?></td>
                                   <td><?php echo $val['businessRepresentative'];?></td>                                    
                                   <td><?php echo _getBusinessCategoryNameString($val['buss_id']);?></td>                                    
                                   <td><?php echo $val['userFullName'];?></td>                                    
                                    <td><?php echo anchor('home/business_details/'.$val['buss_id'],$val['buss_name'],'title="View Ad" target="_blanck"');?></td>                                      
                                    <td><?php echo $val['buss_city'];?></td>                                    
                                    <td><?php echo $val['buss_zip_code'];?></td>                                    
                                    <td><?php echo $val['bussCreatedOn'];?></td>                                    
                                    <!--<td><?php echo $val['bussUpdatedOn'];?></td>-->
                                    <td><?php echo $val['bussStatus'];?></td>                                    
                                                         
                                    <td>                                        
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/manage_listing/view/' .$val['buss_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'alt' => 'View '))); ?> &nbsp;
                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_listing/edit/' .$val['buss_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'alt' => 'Edit'))); ?> &nbsp;
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_listing/delete/' .$val['buss_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'alt' => 'Delete')),array('onclick'=>"javascript: return confirm('Do you want to delete this record?');")); ?> &nbsp;
                                    </td>    
		    		</tr>
                           <?php $count++;
						    }?>    
                                
                                </tbody>
                        </table>
               
            <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','edit.png'=>'Edit','delete.png'=>'Delete record');
                echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                  
 <!-- pagination -->
                    <?php if ($totalrecords) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
                        <div style="width:100%; float: left;">
                                <input class="ui-button custom-default-button" type="button" name="delete" id="delete" value="Delete Selected" onclick="deleteRecords();" />
                        </div>
                        <?php echo $this->pagination->create_links(); ?>
                    </div>
                    <!-- end pagination -->

                    <!-- table action -->
                    <div class="pagination">
                        <div class="results" style="float: right;">
                            <span>showing results <?php echo $offset ?>-<?php echo $limit ?> of <?php echo $totalrecords ?></span>
                        </div>
                    </div>
                    <!-- end table action -->
                <?php } ?>
                    <!-- end table action -->
						<!-- end pagination -->
						<!-- table action -->
						
						<!-- end table action -->
 
	  </div>
      <input type="submit" name="delete_selected" id="delete_selected" value="Delete Selected" style="display: none;"/>
       <?php echo form_close(); ?>  
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 

</body>
</html>
