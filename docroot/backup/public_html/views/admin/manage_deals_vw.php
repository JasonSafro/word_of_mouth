<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Deals</h5>
        <div class="search">
          
        </div> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
                
                    <div style="margin-top:-18px;">
                         <?php
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_deals/add';                   
                    ?>
                   <input type="button" name="newDealBtn" class="ui-button custom-default-button" value="New Deal" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmDeals', 'id' => 'frmDeals', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_deals/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="5%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="5%" align="center" class="<?php echo ($sort_by=="dealId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'dealId' && $sort_type == 'ASC' ? 'dealId/DESC/' . $newOffset : 'dealId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
                                <th width="15%" align="center">
                                    Deal Image                                 
                                </th>
                               
                                <th width="10%" align="left" class="<?php echo ($sort_by=="buss_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'buss_name' && $sort_type == 'ASC' ? 'buss_name/DESC/' . $newOffset : 'buss_name/ASC/' . $newOffset);
                                     echo anchor($url, 'Business');								
                                    ?>     
                                </th>   
                                
                                <th width="29%" align="left" class="<?php echo ($sort_by=="dealOverview" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'dealOverview' && $sort_type == 'ASC' ? 'dealOverview/DESC/' . $newOffset : 'dealOverview/ASC/' . $newOffset);
                                    echo anchor($url, 'Deal Overview');
                                    ?>                                   
                                </th>
                                
                               
                                 <th width="5%" align="left" class="<?php echo ($sort_by=="dealValue" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'dealValue' && $sort_type == 'ASC' ? 'dealValue/DESC/' . $newOffset : 'dealValue/ASC/' . $newOffset);
                                    echo anchor($url, 'Value');								
                                    ?>     
                                </th>
                                <th width="5%" align="left" class="<?php echo ($sort_by=="dealDiscounts" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'dealDiscounts' && $sort_type == 'ASC' ? 'dealDiscounts/DESC/' . $newOffset : 'dealDiscounts/ASC/' . $newOffset);
                                    echo anchor($url, 'Discount');								
                                    ?>     
                                </th>
                                
                                
                                <th width="5%" align="left" class="<?php echo ($sort_by=="dealSavings" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'dealSavings' && $sort_type == 'ASC' ? 'dealSavings/DESC/' . $newOffset : 'dealSavings/ASC/' . $newOffset);
                                    echo anchor($url, 'Saving');								
                                    ?>     
                                </th>
                                <th width="5%" align="left" class="<?php echo ($sort_by=="dealFinalPrice" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'dealFinalPrice' && $sort_type == 'ASC' ? 'dealFinalPrice/DESC/' . $newOffset : 'dealFinalPrice/ASC/' . $newOffset);
                                    echo anchor($url, 'Final Price');								
                                    ?>     
                                </th>
                                 <th width="6%" align="left" class="<?php echo ($sort_by=="dealStatus" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'dealStatus' && $sort_type == 'ASC' ? 'dealStatus/DESC/' . $newOffset : 'dealStatus/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php                         
                        foreach($dealList as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['dealId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo $val['dealId'];?></td>                                    
                                   <td><img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$val['dealImage'];?>" height="100" width="150"/></td>
                                    <td><?php echo anchor('home/business_details/'.$val['dealBusinessId'],$val['buss_name'],array('target'=>'_blanck','title'=>'View business details'));?></td>                                    
                                    <td><?php echo $val['dealOverview'];?></td>                                     
                                    <td>$<?php echo $val['dealValue'];?></td>                                    
                                    <td><?php echo $val['dealDiscounts'];?>%</td>
                                                                                                
                                    <td>$<?php echo $val['dealSavings'];?></td>                                    
                                    <td>$<?php echo $val['dealFinalPrice'];?></td>                                    
                                    <td><?php echo $val['dealStatus'];?></td>                                    
                                    <td>                                        
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/manage_deals/view/' .$val['dealId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'alt' => 'View Job'))); ?> &nbsp;
                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_deals/edit/' .$val['dealId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'alt' => 'Edit Job'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_deals/delete/' .$val['dealId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
        <?php                           echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
		
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
                <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','edit.png'=>'Edit','delete.png' => 'Delete details');
                echo $this->load->view('admin/legend_view', $legend_para);
                ?>
                    <!-- pagination -->
                    <?php if ($totalrecords) { ?>
                    <!-- pagination -->
                    <div class="pagination pagination-left">
                        <div style="width:100%; float: left;">
                                <input class="ui-button custom-default-button" type="submit" name="delete" id="delete" value="Delete Selected" onclick="javascript: return deleteRecords();" />
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
       <?php echo form_close(); ?>  
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
