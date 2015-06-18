<!-- content -->
<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Deleted Sales Representative's</h5>
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
            $attr = array('name' => 'frmSalesRep', 'id' => 'frmSalesRep', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_sales_rep/hard_delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr>
                                <th width="5%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                <th width="7%" align="left" class="<?php echo ($sort_by=="adm_id" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_id' && $sort_type == 'ASC' ? 'adm_id/DESC/' . $newOffset : 'adm_id/ASC/' . $newOffset);
                                    echo anchor($url, 'Sales Rep ID');
                                    ?>                                   
                                </th>
                                <th width="8%" align="left" class="<?php echo ($sort_by=="employNo" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'employNo' && $sort_type == 'ASC' ? 'employNo/DESC/' . $newOffset : 'employNo/ASC/' . $newOffset);
                                    echo anchor($url, 'Employ Number');
                                    ?>                                   
                                </th>
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="adm_full_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_full_name' && $sort_type == 'ASC' ? 'adm_full_name/DESC/' . $newOffset : 'adm_full_name/ASC/' . $newOffset);
                                    echo anchor($url, 'Full Name');
                                    ?>                                   
                                </th>
                                
                                 <th width="13%" align="left" class="<?php echo ($sort_by=="adm_username" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'adm_username' && $sort_type == 'ASC' ? 'adm_username/DESC/' . $newOffset : 'adm_username/ASC/' . $newOffset);
                                    echo anchor($url, 'User Name');
                                    ?>                                   
                                </th>
                               
                                <th width="20%" align="left" class="<?php echo ($sort_by=="adm_email" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
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
                                
                                
                               <!-- <th width="11%" align="left" class="<?php echo ($sort_by=="adm_created_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_created_date' && $sort_type == 'ASC' ? 'adm_created_date/DESC/' . $newOffset : 'adm_created_date/ASC/' . $newOffset);
                                    echo anchor($url, 'Registered Date');								
                                    ?>     
                                </th>-->
                                <th width="9%" align="left" class="<?php echo ($sort_by=="adm_last_login_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_last_login_date' && $sort_type == 'ASC' ? 'adm_last_login_date/DESC/' . $newOffset : 'adm_last_login_date/ASC/' . $newOffset);
                                     echo anchor($url, 'Last Login Date');								
                                    ?>     
                                </th> 
                                <th width="9%" align="left" class="<?php echo ($sort_by=="adm_updated_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_updated_date' && $sort_type == 'ASC' ? 'adm_updated_date/DESC/' . $newOffset : 'adm_updated_date/ASC/' . $newOffset);
                                     echo anchor($url, 'Deleted Date');								
                                    ?>     
                                </th> 
                                <th width="6%" align="left" class="<?php echo ($sort_by=="adm_status" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'adm_status' && $sort_type == 'ASC' ? 'adm_status/DESC/' . $newOffset : 'adm_status/ASC/' . $newOffset);
                                     echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                <th width="8%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($salesrepList as $key=>$val){?>
                        <tbody>
                               <tr>
                                    <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['adm_id'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                    <td><?php echo $val['adm_id'];?></td>
                                    <td><?php echo $val['employNo'];?></td>
                                    <td><?php echo $val['adm_full_name'];?></td>
                                    <td><?php echo $val['adm_username'];?></td>
                                    <td><?php echo $val['adm_email'];?></td>
                                    <td><?php echo $val['adm_contactno'];?></td>
                                    <!--<td><?php echo $val['adm_created_date'];?></td>-->
                                    <td><?php if($val['adm_last_login_date']=='0000-00-00 00:00:00')echo "--";else echo $val['adm_last_login_date'];?></td>   
                                    <td><?php if($val['adm_updated_date']=='0000-00-00 00:00:00')echo "--";else echo $val['adm_updated_date'];?></td>                                                                
                                    <td><?php if($val['adm_status']=='D') echo "Deleted"; else echo "--";?></td>                                    
                                    <td><?php $delete_url=ADMIN_FOLDER_NAME.'/manage_sales_rep/delete_from_system/' .$val['adm_id'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
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
