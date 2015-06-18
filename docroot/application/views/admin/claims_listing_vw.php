<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Claims</h5>
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
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmContactusList', 'id' => 'frmContactusList', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_claims/delete_selected';

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr>
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                <th width="3%" align="left">Sr.No</th>
                                <th width="5%" align="left">Registered User?</th>
                                <th width="5%" align="left" class="<?php echo ($sort_by=="crBussPhoneNo" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'crBussPhoneNo' && $sort_type == 'ASC' ? 'crBussPhoneNo/DESC/' . $newOffset : 'crBussPhoneNo/ASC/' . $newOffset);
                                    echo anchor($url, 'Business phone number');
                                    ?>                                   
                                </th>
                                
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="crBussOfficeAddress" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'crBussOfficeAddress' && $sort_type == 'ASC' ? 'crBussOfficeAddress/DESC/' . $newOffset : 'crBussOfficeAddress/ASC/' . $newOffset);
                                    echo anchor($url, 'Business official address');
                                    ?>                                   
                                </th>
                                
                                <th width="8%" align="left" class="<?php echo ($sort_by=="crBussOfficialEmail" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'crBussOfficialEmail' && $sort_type == 'ASC' ? 'crBussOfficialEmail/DESC/' . $newOffset : 'crBussOfficialEmail/ASC/' . $newOffset);
                                    echo anchor($url, 'Official email address');								
                                    ?>     
                                </th>  
                             
                                <!--<th width="20%" align="left" class="<?php echo ($sort_by=="crBussAdditionalInfo" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'crBussAdditionalInfo' && $sort_type == 'ASC' ? 'crBussAdditionalInfo/DESC/' . $newOffset : 'crBussAdditionalInfo/ASC/' . $newOffset);
                                    echo anchor($url, 'Additional information');								
                                    ?>     
                                </th>-->
                               
                                <th width="7%" align="left" class="<?php echo ($sort_by=="crCreatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'crCreatedOn' && $sort_type == 'ASC' ? 'crCreatedOn/DESC/' . $newOffset : 'crCreatedOn/ASC/' . $newOffset);
                                     echo anchor($url, 'Created On');								
                                    ?>     
                                </th>
                                
                                <th width="7%" align="left" class="<?php echo ($sort_by=="crUpdatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'crUpdatedOn' && $sort_type == 'ASC' ? 'crUpdatedOn/DESC/' . $newOffset : 'crUpdatedOn/ASC/' . $newOffset);
                                     echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>
                                
                                <th width="5%" align="left" class="<?php echo ($sort_by=="priority" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                <?php
                                    $url= $base_url_address.($sort_by == 'priority' && $sort_type == 'ASC' ? 'priority/DESC/' . $newOffset : 'priority/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                
                                <th width="15%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($claimList as $key=>$val){?>
                        <tbody>
                               <tr>                                 
                                    <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['crId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                    <td><?php echo ++$key;?></td>             
                                    <td><?php echo ($val['crRequesterUserId']=="" || $val['crRequesterUserId']==0?"No": anchor('admin/user/view_details/'.$val['crRequesterUserId'],'Yes'));?></td>
                                    <td><?php echo $val['crBussPhoneNo'];?></td>                                    
                                    <td><?php echo $val['crBussOfficeAddress'];?></td>                                    
                                    <td><?php echo $val['crBussOfficialEmail'];?></td>                                    
                                    <!--<td><?php //echo $val['crBussAdditionalInfo'];?></td>  -->
                                    <td><?php echo $val['crCreatedOn'];?></td>
                                    <td><?php echo $val['crUpdatedOn'];?></td>                                    
                                    <td><?php echo $val['crStatus'];?></td>
                                    <td>
                                    <?php $view_url=ADMIN_FOLDER_NAME.'/manage_claims/view/' .$val['crId'];?>
                                    <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'View details'))); ?>
                                    <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_claims/delete/' .$val['crId'];?>
                                    <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
                <?php
                $legend_para['legend_options'] = array('delete.png' => 'Delete details');
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
