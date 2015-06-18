<!-- content -->

<script type="text/ecmascript" language="javascript">
function add_user()
{
	window.location.href='<?php echo site_url().'/admin/manageuser/create_user'?>';
}

function no_records()
{
	document.userfrm.action="<?php echo base_url(); ?>index.php/admin/user/userlist";
	document.userfrm.submit();
}

</script>
<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Deleted User's</h5>
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
            $form_url = ADMIN_FOLDER_NAME.'/user/hard_delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr>
                                <th width="4%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                <th width="7%" align="left" class="<?php echo ($sort_by=="user_id" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'user_id' && $sort_type == 'ASC' ? 'user_id/DESC/' . $newOffset : 'user_id/ASC/' . $newOffset);
                                    echo anchor($url, 'User Id');
                                    ?>                                   
                                </th>
                                 <th width="11%" align="left" class="<?php echo ($sort_by=="user_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
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
                                <th width="11%" align="left" class="<?php echo ($sort_by=="user_lname" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_lname' && $sort_type == 'ASC' ? 'user_lname/DESC/' . $newOffset : 'user_lname/ASC/' . $newOffset);
                                     echo anchor($url, 'Last Name');								
                                    ?>     
                                </th>
                                <th width="19%" align="left" class="<?php echo ($sort_by=="user_email" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_email' && $sort_type == 'ASC' ? 'user_email/DESC/' . $newOffset : 'user_email/ASC/' . $newOffset);
                                     echo anchor($url, 'Email Address');								
                                    ?>     
                                </th>                            
                                <th width="11%" align="left" class="<?php echo ($sort_by=="user_registered_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_registered_date' && $sort_type == 'ASC' ? 'user_registered_date/DESC/' . $newOffset : 'user_registered_date/ASC/' . $newOffset);
                                    echo anchor($url, 'Registered Date');								
                                    ?>     
                                </th>
                                <th width="11%" align="left" class="<?php echo ($sort_by=="user_update_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_update_date' && $sort_type == 'ASC' ? 'user_update_date/DESC/' . $newOffset : 'user_update_date/ASC/' . $newOffset);
                                     echo anchor($url, 'Deleted Date');								
                                    ?>     
                                </th> 
                                <th width="9%" align="left" class="<?php echo ($sort_by=="user_acc_status" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'user_acc_status' && $sort_type == 'ASC' ? 'user_acc_status/DESC/' . $newOffset : 'user_acc_status/ASC/' . $newOffset);
                                     echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                <th width="7%" align="left" style="background: #E6EEEE;">Action</th>
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
                                    <td><?php echo $val['user_registered_date'];?></td>
                                    <td><?php echo $val['user_update_date'];?></td>                                    
                                    <td><?php echo $val['user_acc_status'];?></td>                                    
                                    <td>                                        
					<?php $delete_url=ADMIN_FOLDER_NAME.'/user/delete_from_system/' .$val['user_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this user from the system?')) return false;")); ?>
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
                <?php
                $legend_para['legend_options'] = array('delete.png' => 'Delete user details');
                echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                    <!-- pagination -->
                    <?php if ($totalrecords) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
                        <div style="width:200px; float: left;">
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
