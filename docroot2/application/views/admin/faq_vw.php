<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage FAQ</h5>
        <div class="search">
          
        </div> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
                
                    <div style="margin-top:-18px;">
                         <?php
                    $attr1 = array('name' => 'frmNewFaq', 'id' => 'frmNewFaq', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_faq/add_new/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);
                    echo form_open($form_url1, $attr1);
                    ?>
                   <input type="button" name="newFaqBtn" class="ui-button custom-default-button" value="New Question" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                    <?php echo form_close(); ?>  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmFaq', 'id' => 'frmFaq', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_faq/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="5%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="5%" align="center" class="<?php echo ($sort_by=="faqId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'faqId' && $sort_type == 'ASC' ? 'faqId/DESC/' . $newOffset : 'faqId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
                                <th width="25%" align="left" class="<?php echo ($sort_by=="faqTitle" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'faqTitle' && $sort_type == 'ASC' ? 'faqTitle/DESC/' . $newOffset : 'faqTitle/ASC/' . $newOffset);
                                    echo anchor($url, 'Question');
                                    ?>                                   
                                </th>
                                
                                <th width="35%" align="left" class="<?php echo ($sort_by=="faqDescription" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'faqDescription' && $sort_type == 'ASC' ? 'faqDescription/DESC/' . $newOffset : 'faqDescription/ASC/' . $newOffset);
                                    echo anchor($url, 'Description');
                                    ?>                                   
                                </th>
                               
                                <th width="10%" align="left" class="<?php echo ($sort_by=="faqCreatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'faqCreatedOn' && $sort_type == 'ASC' ? 'faqCreatedOn/DESC/' . $newOffset : 'faqCreatedOn/ASC/' . $newOffset);
                                     echo anchor($url, 'Created On');								
                                    ?>     
                                </th>                                     
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="faqUpdatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'faqUpdatedOn' && $sort_type == 'ASC' ? 'faqUpdatedOn/DESC/' . $newOffset : 'faqUpdatedOn/ASC/' . $newOffset);
                                    echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($faqList as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['faqId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo ++$key;?></td>                                    
                                    <td><?php echo anchor(ADMIN_FOLDER_NAME."/manage_faq/edit/".$val['faqId'],$val['faqTitle'],array('title'=>'Edit Record'));?></td>                                    
                                    <td><?php echo $val['faqDescription'];?></td> 
                                    <td><?php echo $val['faqCreatedOn'];?></td>                                    
                                    <td><?php echo $val['faqUpdatedOn'];?></td>                                    
                                    <td>                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_faq/edit/' .$val['faqId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_faq/delete/' .$val['faqId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
        <?php                           echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
		
                                    </td>
		    		</tr>
                           <?php }?>    
                                
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
