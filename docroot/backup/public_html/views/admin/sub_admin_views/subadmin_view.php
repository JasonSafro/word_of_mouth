<!-- content -->

<script type="text/javascript">
// Popup window code
function newPopup(url) {
	popupWindow = window.open(
		url,'popUpWindow','height=780,width=1380,left=10,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}

function adjustPoints(url) {
    
  var w=400;
  var h=300;  
  var left = (screen.width/2)-(w/2);
  var top = (screen.height/2)-(h/2);
  popupWindow= window.open(url, 'Adjust Points', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
  //popupWindow = window.open(url,'popUpWindow','height=400,width=400,left=00,top=10,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}
</script>

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Registered Sub-Admins</h5>
       <!-- <div class="search">
          <form action="#" method="post">
            <div class="input">
              <input type="text" id="search" name="search" />
            </div>
            <div class="button">
              <input type="submit" name="submit" value="Search" />
            </div>
          </form>
        </div> -->
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- end box / title -->
            <?php
            $attr = array('name' => 'frmSubAdmins', 'id' => 'frmSubAdmins', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_subadmin/soft_delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
               <p><?php echo $total_sub_admin_count;?> registered Sub-Admins - TOTAL</p>
               
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            
                            <tr>
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                <th width="10%" align="center" class="<?php echo ($sort_by=="adm_id" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_id' && $sort_type == 'ASC' ? 'adm_id/DESC/' . $newOffset : 'adm_id/ASC/' . $newOffset);
                                    echo anchor($url, 'Sub-Admin ID');
                                    ?>                                   
                                </th>
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="adm_full_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_full_name' && $sort_type == 'ASC' ? 'adm_full_name/DESC/' . $newOffset : 'adm_full_name/ASC/' . $newOffset);
                                    echo anchor($url, 'Full Name');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="adm_username" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_username' && $sort_type == 'ASC' ? 'adm_username/DESC/' . $newOffset : 'adm_username/ASC/' . $newOffset);
                                    echo anchor($url, 'User Name');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="adm_email" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_email' && $sort_type == 'ASC' ? 'adm_email/DESC/' . $newOffset : 'adm_email/ASC/' . $newOffset);
                                    echo anchor($url, 'Email');
                                    ?>                                   
                                </th>    
                                
                                <th width="10%" align="left" class="<?php echo ($sort_by=="adm_contactno" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_contactno' && $sort_type == 'ASC' ? 'adm_contactno/DESC/' . $newOffset : 'adm_contactno/ASC/' . $newOffset);
                                    echo anchor($url, 'Contact No.');
                                    ?>                                   
                                </th> 
                                <!--
                                <th width="11%" align="left" class="<?php echo ($sort_by=="adm_created_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_created_date' && $sort_type == 'ASC' ? 'adm_created_date/DESC/' . $newOffset : 'adm_created_date/ASC/' . $newOffset);
                                    echo anchor($url, 'Registered Date');								
                                    ?>     
                                </th>-->
                                <th width="11%" align="left" class="<?php echo ($sort_by=="adm_last_login_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_last_login_date' && $sort_type == 'ASC' ? 'adm_last_login_date/DESC/' . $newOffset : 'adm_last_login_date/ASC/' . $newOffset);
                                     echo anchor($url, 'Last Login Date');								
                                    ?>     
                                </th> 
                               <!-- <th width="11%" align="left" class="<?php echo ($sort_by=="adm_updated_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_updated_date' && $sort_type == 'ASC' ? 'adm_updated_date/DESC/' . $newOffset : 'adm_updated_date/ASC/' . $newOffset);
                                     echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>      -->                          
                                <th width="7%" align="left" class="<?php echo ($sort_by=="adm_status" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_status' && $sort_type == 'ASC' ? 'adm_status/DESC/' . $newOffset : 'adm_status/ASC/' . $newOffset);
                                     echo anchor($url, 'Status');								
                                    ?>     
                                </th>                               
                                <th width="14%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($sub_admin_List as $key=>$val){?>
                        <tbody>
                               <tr>
                                    <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['adm_id'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                    <td align="center"><?php echo $val['adm_id'];?></td>
                                    <td><?php echo $val['adm_full_name'];?></td>
                                    <td><?php echo $val['adm_username'];?></td>                                   
                                    <td><?php echo $val['adm_email'];?></td>
                                    <td><?php echo $val['adm_contactno'];?></td>
                                   <!-- <td><?php echo $val['adm_created_date'];?></td>-->
                                    <td><?php if($val['adm_last_login_date']=='0000-00-00 00:00:00')echo "--";else echo $val['adm_last_login_date'];?></td>   
                                    <!--<td><?php if($val['adm_updated_date']=='0000-00-00 00:00:00')echo "--";else echo $val['adm_updated_date'];?></td>-->
                                    <td><?php if($val['adm_status']=='A') echo "Active"; else echo "InActive";?></td>
                                    <td>                                        
                                        <?php 
                                        $status_url=ADMIN_FOLDER_NAME.'/manage_subadmin/change_status/' .$sort_by.'/'.$sort_type.'/'.$newOffset;
                                        if($val['adm_status']=='A'){
                                            $statusAlertMessage="Do you want to Deactivate this user?";
                                            $status="I";
                                            $statusImg="active.gif";
                                        }  else {
                                            $statusAlertMessage="Do you want to Activate this user?";
                                            $status="A";
                                            $statusImg="deactive.gif";
                                        }
                                        echo anchor($status_url.'/'. $val['adm_id'] . '/' . $status, img(array('src' => 'assets/images/' . $statusImg, 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Change status')),array("onclick" => "if(!confirm('".$statusAlertMessage."')) return false;"));
                                        ?>
                                        <?php $adm_id=$val['adm_id'];?>
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_subadmin/edit/' .$val['adm_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;					
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_subadmin/delete/' .$val['adm_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
        
		
                                        
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                
                                </tbody>
                        </table>
               
               
               
                <?php
                $legend_para['legend_options'] = array('active.gif' => 'Deactivate a user','deactive.gif'=>'Activate a user', 'edit.png' => 'Edit details', 'delete.png' => 'Delete a user details');
                echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                    <!-- pagination -->
                    <?php if ($totalrecords) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
                        <div style="width:100%; float: left;">
                                <input class="ui-button custom-default-button" type="button" name="delete" id="delete" value="Delete Selected" onclick="deleteRecords();" />
                                <!--<input class="ui-button custom-default-button" type="button" name="emailList" id="emailList" value="Export Emails" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/user/getEmailList";?>'" />-->
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
						<!-- end pagination -->
						<!-- table action -->
						
						<!-- end table action -->
 
	  </div>
    </div>
    
            <input type="submit" name="delete_selected" id="delete_selected" value="Delete Selected" style="display: none;"/>
            <input type="submit" name="activate_selected" id="activate_selected" value="Active Selected" style="display: none;"/>
            <input type="submit" name="deactivate_selected" id="deactivate_selected" value="Deactive Selected" style="display: none;"/>
	<?php echo form_close(); ?>
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
