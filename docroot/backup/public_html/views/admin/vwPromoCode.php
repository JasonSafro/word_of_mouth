<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Promo Codes</h5>
       <!-- <div class="search">
          <form action="#" method="post">
            <div class="input">
              <input type="text" id="search" name="search" />
            </div>
            <div class="button">
              <input type="submit" name="submit" value="Search" />
            </div>
          </form>
        </div>--> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
				<div style="margin-top:-18px;">
                     <input type="button" onclick="javascript: location='<?php echo base_url();?>admin/manage_promocodes/addPromocodes'" style="cursor:pointer;" value="New Promo code" class="ui-button custom-default-button" name="newCatbtn">
				 </div>
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmContactusList', 'id' => 'frmContactusList', 'autocomplete' => 'off', 'method' => 'post');
            //$form_url = ADMIN_FOLDER_NAME.'/channels/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            //echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr>
                                <th width="3%" align="left" >
									Sr. No
                                </th>
								<th width="13%" align="left" class="<?php echo ($sort_by=="subs_plan_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'subs_plan_name' && $sort_type == 'ASC' ? 'subs_plan_name/DESC/' . $newOffset : 'subs_plan_name/ASC/' . $newOffset);
                                    echo anchor($url, 'Plan Name');
                                    ?>                                   
                                </th>
                                
                                 <th width="13%" align="left" class="<?php echo ($sort_by=="subs_sub_plan_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'subs_sub_plan_name' && $sort_type == 'ASC' ? 'subs_sub_plan_name/DESC/' . $newOffset : 'subs_sub_plan_name/ASC/' . $newOffset);
                                    echo anchor($url, 'Plan Type');
                                    ?>                                   
                                </th>
                                
                                <th width="13%" align="left" class="<?php echo ($sort_by=="pc_code" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'pc_code' && $sort_type == 'ASC' ? 'pc_code/DESC/' . $newOffset : 'pc_code/ASC/' . $newOffset);
                                    echo anchor($url, 'Promo Code');								
                                    ?>     
                                </th>  
								 <th width="13%" align="left" class="<?php echo ($sort_by=="pc_discount" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'pc_discount' && $sort_type == 'ASC' ? 'pc_discount/DESC/' . $newOffset : 'pc_discount/ASC/' . $newOffset);
                                    echo anchor($url, 'Discount');								
                                    ?>     
                                </th>  
								 <th width="13%" align="left" class="<?php echo ($sort_by=="pc_status" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'pc_status' && $sort_type == 'ASC' ? 'pc_status/DESC/' . $newOffset : 'pc_status/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>  
                               <th width="10%" align="left" class="<?php echo ($sort_by=="pc_updated_on" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'pc_updated_on' && $sort_type == 'ASC' ? 'pc_updated_on/DESC/' . $newOffset : 'pc_updated_on/ASC/' . $newOffset);
                                     echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>
                                
                                <th width="14%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php $i = 1; foreach($records as $key=>$val){?>
                        <tbody>
                               <tr>                                 
                                     <td><?php echo $i;?></td>
									<td><?php echo $val['subs_plan_name'];?></td>                                    
                                    <td><?php echo $val['subs_sub_plan_name'];?></td>                                    
                                    <td><?php echo $val['pc_code'];?></td>                                    
                                    <td><?php echo '$'.$val['pc_discount'];?></td>                                    
                                    <td><?php echo $val['pc_status'] == 'A'? 'Active': 'Inactive';
									?></td>
									<td><?php echo $val['pc_updated_on'];?></td>
                                    <td>
									<?php 
									$status_url=ADMIN_FOLDER_NAME.'/manage_promocodes/change_status/' .$sort_by.'/'.$sort_type.'/'.$newOffset;
									if($val['pc_status']=='A'){
										$statusAlertMessage="Do you want to Deactivate this user?";
										$status="I";
										$statusImg="active.gif";
									}  else {
										$statusAlertMessage="Do you want to Activate this user?";
										$status="A";
										$statusImg="deactive.gif";
									}
									echo anchor($status_url.'/'. $val['pc_id'] . '/' . $status, img(array('src' => 'assets/images/' . $statusImg, 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Change status')),array("onclick" => "if(!confirm('".$statusAlertMessage."')) return false;"));
									echo "&nbsp;|&nbsp;";
									$edit_url = ADMIN_FOLDER_NAME.'/manage_promocodes/editPromocodes/' .$val['pc_id'];
                                    echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record'))); 
									echo "&nbsp;|&nbsp;";
									 $delete_url=ADMIN_FOLDER_NAME.'/manage_promocodes/delete/' .$val['pc_id'];
                                     echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
                                    </td>
		    		</tr>
                           <?php $i++; } ?>    
                                
                                </tbody>
                        </table>
               
                <?php
				
                $legend_para['legend_options'] = array('edit.png' => 'Edit details','delete.png' => 'Delete details');
				
                echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                    <!-- pagination -->
                    <?php if ($totalrecords) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
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
       <?php echo form_close(); ?>  
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
