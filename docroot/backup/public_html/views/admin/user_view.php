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
        <h5>Manage Registered User's</h5>
        <!--<div class="search">
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
            $attr = array('name' => 'frmUsers', 'id' => 'frmUsers', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/user/soft_delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
               <p><?php echo $total_users_count;?> registered users - TOTAL</p>
               
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            
                            <tr>
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                <th width="6%" align="left" class="<?php echo ($sort_by=="user_id" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'user_id' && $sort_type == 'ASC' ? 'user_id/DESC/' . $newOffset : 'user_id/ASC/' . $newOffset);
                                    echo anchor($url, 'User Id');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="user_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'user_name' && $sort_type == 'ASC' ? 'user_name/DESC/' . $newOffset : 'user_name/ASC/' . $newOffset);
                                    echo anchor($url, 'User Name');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="user_fname" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'user_fname' && $sort_type == 'ASC' ? 'user_fname/DESC/' . $newOffset : 'user_fname/ASC/' . $newOffset);
                                    echo anchor($url, 'First Name');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="userLastName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_lname' && $sort_type == 'ASC' ? 'user_lname/DESC/' . $newOffset : 'user_lname/ASC/' . $newOffset);
                                     echo anchor($url, 'Last Name');								
                                    ?>     
                                </th>
                                <th width="8%" align="left" class="<?php echo ($sort_by=="user_email" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_email' && $sort_type == 'ASC' ? 'user_email/DESC/' . $newOffset : 'user_email/ASC/' . $newOffset);
                                     echo anchor($url, 'Email Address');								
                                    ?>     
                                </th>      
                                
                                 <th width="4%" align="left" class="<?php echo ($sort_by=="user_zipcode" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_zipcode' && $sort_type == 'ASC' ? 'user_zipcode/DESC/' . $newOffset : 'user_zipcode/ASC/' . $newOffset);
                                    echo anchor($url, 'Zip code');								
                                    ?>     
                                </th>
                                
                                <th width="9%" align="left" class="<?php echo ($sort_by=="user_registered_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_registered_date' && $sort_type == 'ASC' ? 'user_registered_date/DESC/' . $newOffset : 'user_registered_date/ASC/' . $newOffset);
                                    echo anchor($url, 'Registered Date');								
                                    ?>     
                                </th>
                                <th width="11%" align="left" class="<?php echo ($sort_by=="user_last_login_on" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_last_login_on' && $sort_type == 'ASC' ? 'user_last_login_on/DESC/' . $newOffset : 'user_last_login_on/ASC/' . $newOffset);
                                     echo anchor($url, 'Last Login Date');								
                                    ?>     
                                </th> 
                                <th width="5%" align="left" class="<?php echo ($sort_by=="user_acc_status" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_acc_status' && $sort_type == 'ASC' ? 'user_acc_status/DESC/' . $newOffset : 'user_acc_status/ASC/' . $newOffset);
                                     echo anchor($url, 'Status');								
                                    ?>     
                                </th>          
                                 <th width="9%" align="left" class="<?php echo ($sort_by=="user_type" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_type' && $sort_type == 'ASC' ? 'user_type/DESC/' . $newOffset : 'user_type/ASC/' . $newOffset);
                                     echo anchor($url, 'User Type');								
                                    ?>     
                                </th> 
                                <th width="20%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($userList as $key=>$val){?>
                        <tbody>
                               <tr>
                                    <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['user_id'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                    <td><?php echo $val['user_id'];?></td>
                                    <td><?php echo $val['user_name'];?></td>
                                    <td><?php if($val['user_fname']=='')echo "--";else echo $val['user_fname'];?></td>
                                    <td><?php if($val['user_lname']=='')echo "--";else echo $val['user_lname'];?></td>
                                    <td><?php echo $val['user_email'];?></td>
                                    <td><?php echo $val['user_zipcode'];?></td>
                                    <td><?php echo $val['user_registered_date'];?></td>
                                    <td><?php if($val['user_last_login_on']=='0000-00-00 00:00:00')echo "--";else echo $val['user_last_login_on'];?></td>                                    
                                    <td><?php echo $val['user_acc_status'];?></td>
                                     <td><?php if($val['user_type']=='buss_user')echo "Bussiness User";else echo "Site User";?></td>    
                                    <td>
                                        <?php $user_id=$val['user_id'];?>
                                        
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/user/view_details/' .$val['user_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'View record'))); ?>
                                      
                                       <?php 
                                        $status_url=ADMIN_FOLDER_NAME.'/user/change_status/' .$sort_by.'/'.$sort_type.'/'.$newOffset;
                                        if($val['user_acc_status']=='A'){
                                            $statusAlertMessage="Do you want to Deactivate this user?";
                                            $status="I";
                                            $statusImg="active.gif";
                                        }  else {
                                            $statusAlertMessage="Do you want to Activate this user?";
                                            $status="A";
                                            $statusImg="deactive.gif";
                                        }
                                        echo anchor($status_url.'/'. $val['user_id'] . '/' . $status, img(array('src' => 'assets/images/' . $statusImg, 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Change status')),array("onclick" => "if(!confirm('".$statusAlertMessage."')) return false;"));
                                        ?>
                                        <?php $user_id=$val['user_id'];?>
                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/user/edit/' .$val['user_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;					
                                       
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/user/delete/' .$val['user_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
        
										<?php $listing_url=ADMIN_FOLDER_NAME.'/user/listing/' .$val['user_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                         <?php echo anchor($listing_url, img(array('src' => 'assets/images/lic.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Bussiness Listing'))); ?> &nbsp;						
                                        
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                
                                </tbody>
                        </table>
               
               
               
                <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','active.gif' => 'Deactivate a user','deactive.gif'=>'Activate a user', 'edit.png' => 'Edit details', 'delete.png' => 'Delete a user details','lic.png' => 'Bussiness Listing of user');
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
