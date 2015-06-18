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
        <h5>Manage Contact reasons</h5>
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
           // $attr = array('name' => 'frmUsers', 'id' => 'frmUsers', 'autocomplete' => 'off', 'method' => 'post');
           // $form_url = ADMIN_FOLDER_NAME.'/user/soft_delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

           // echo form_open($form_url, $attr);
            ?>
           <div class="table">
               <p><?php echo $total_count;?> Contact reasons- TOTAL
               <a href="<?php echo site_url('admin/reasons/add_new');?>">
              <input class="ui-button custom-default-button" type="button" name="Add" id="delAddete" value="Add New"  style="float:right"/></a></p>
               <br>
                                <!--<input class="ui-button custom-default-button" type="button" name="emailList" id="emailList" value="Export Emails" onclick="javascript: location='<?php //echo base_url().ADMIN_FOLDER_NAME."/user/getEmailList";?>'" />-->
                        
               
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            
                            <tr>
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                <th width="6%" align="left" class="<?php echo ($sort_by=="reason_id" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                   $url= $base_url_address.($sort_by == 'reason_id' && $sort_type == 'ASC' ? 'reason_id/DESC/' . $newOffset : 'reason_id/ASC/' . $newOffset);
                                    echo anchor($url, 'Reason Id');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="reason_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                  
									$url= $base_url_address.($sort_by == 'reason_name' && $sort_type == 'ASC' ? 'reason_name/DESC/' . $newOffset : 'reason_name/ASC/' . $newOffset);
                                    echo anchor($url, 'Reason Name');
                                    ?>                                   
                                </th>
                               
                                <th width="14%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php
						if($total_count!=0)
						{
						  foreach($reasonList as $key=>$val){?>
                          <tbody>
                               <tr>
                                    <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['reason_id'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                    <td><?php echo $val['reason_id'];?></td>
                                    <td><?php echo $val['reason_name'];?></td>
                                    <td> <?php $reason_id=$val['reason_id'];?>
                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/reasons/add_new/' .$val['reason_id'];?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;					
                                       
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/reasons/delete/' .$val['reason_id'];?>
                                        <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?></td>
                               </tr>
                          </tbody>
                          <?php } 
						} else {?>  
                          <tbody>
                               <tr>
                                    <td class="selected" colspan="4">No Record Found</td>
                        		</tr>
                          </tbody>
                        <?php } ?>                            
                        </table>
               
               
               
                <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','edit.png' => 'Edit details', 'delete.png' => 'Delete a Reason details');
               echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                    <!-- pagination -->
                    <?php if ($total_count) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
                        <div style="width:100%; float: left;">
                                <!--<input class="ui-button custom-default-button" type="button" name="delete" id="delete" value="Delete Selected" onclick="" />-->
                                <!--<input class="ui-button custom-default-button" type="button" name="emailList" id="emailList" value="Export Emails" onclick="javascript: location='<?php //echo base_url().ADMIN_FOLDER_NAME."/user/getEmailList";?>'" />-->
                        </div>
                        <?php  echo $this->pagination->create_links(); ?>
                    </div>
                    <!-- end pagination -->

                    <!-- table action -->
                    <div class="pagination">
                        <div class="results" style="float: right;">
                            <!--<span>showing results <?php //echo $offset ?>-<?php //echo $limit ?> of <?php //echo $total_count ?></span>-->
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
