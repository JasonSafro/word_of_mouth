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
        <h5>Manage News Letters</h5>
        <div class="search">
          
        </div> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
                
                    <div style="margin-top:-18px;">
                         <?php
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_newsletter/add';                   
                    ?>
                   <input type="button" name="addnewsletterBtn" class="ui-button custom-default-button" value="New Newsletter" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
             $attr = array('name' => 'frmaddnewsletter', 'id' => 'frmaddnewsletter', 'autocomplete' => 'off', 'method' => 'post');
          //  $form_url = ADMIN_FOLDER_NAME.'/manage_newsletter/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);
		      $form_url=' ';

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="3%" align="center" class="<?php echo ($sort_by=="newsId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'newsId' && $sort_type == 'ASC' ? 'newsId/DESC/' . $newOffset : 'newsId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="newsSubject" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'newsSubject' && $sort_type == 'ASC' ? 'newsSubject/DESC/' . $newOffset : 'newsSubject/ASC/' . $newOffset);
                                    echo anchor($url, 'News Subject');
                                    ?>                                   
                                </th>
                               
                                <th width="20%" align="left" class="<?php echo ($sort_by=="newsMessageBody" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'newsMessageBody' && $sort_type == 'ASC' ? 'newsMessageBody/DESC/' . $newOffset : 'newsMessageBody/ASC/' . $newOffset);
                                     echo anchor($url, 'Message');								
                                    ?>     
                                </th>                                     
                                 <th width="5%" align="left" class="<?php echo ($sort_by=="newsSendStatus" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'newsSendStatus' && $sort_type == 'ASC' ? 'newsSendStatus/DESC/' . $newOffset : 'newsSendStatus/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                <th width="8%" align="left" class="<?php echo ($sort_by=="newsCreatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'newsCreatedOn' && $sort_type == 'ASC' ? 'newsCreatedOn/DESC/' . $newOffset : 'newsCreatedOn/ASC/' . $newOffset);
                                    echo anchor($url, 'Date');								
                                    ?>     
                                </th>
                                
                                <th width="10%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php                         
                        foreach($newsletterList as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['newsId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo $val['newsId'];?></td>                                    
                                    <td><?php echo $val['newsSubject'];?></td>                                    
                                    <td><?php echo $val['newsMessageBody'];?></td>                                    
                                    <td><?php if($val['newsSendStatus'] == 0){ echo "not sent"; }else{ echo "sent"; } ?></td>
                                    <td><?php echo $val['newsCreatedOn'];?></td>                                    
                                                         
                                    <td>                                        
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/manage_newsletter/view/' .$val['newsId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'alt' => 'View '))); ?> &nbsp;
                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_newsletter/edit/' .$val['newsId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'alt' => 'Edit'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_newsletter/delete/' .$val['newsId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
        <?php                           echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
        								
                                        <?php $email_url=ADMIN_FOLDER_NAME.'/manage_newsletter/send_news_mail/'.$val['newsId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($email_url, img(array('src' => 'assets/images/email.png', 'border' => '0', 'alt' => 'Email'))); ?> &nbsp;
		
                                    </td>    
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
            <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','edit.png'=>'Edit','delete.png' => 'Delete details','email.png' => 'Send mail');
                echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                  
 <!-- pagination -->
                    <?php if ($totalrecords) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
                        <div style="width:100%; float: left;">
                                <input class="ui-button custom-default-button" type="submit" name="delete" id="delete" value="Delete Selected" onclick="javascript: return 		   deleteRecords();" />
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
