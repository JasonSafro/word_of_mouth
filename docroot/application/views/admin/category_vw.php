<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Category</h5>
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
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
                
                    <div style="margin-top:-18px;">
                         <?php
                    $attr1 = array('name' => 'frmSearchCat', 'id' => 'frmSearchCat', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/category/add_new/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);
                    echo form_open($form_url1, $attr1);
                    ?>
                   <input type="button" name="newCatbtn" class="ui-button custom-default-button" value="New Category" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                    <?php echo form_close(); ?>  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php  
            $attr = array('name' => 'frmCategory', 'id' => 'frmCategory', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/category/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="5%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="7%" align="center" class="<?php echo ($sort_by=="catId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'catId' && $sort_type == 'ASC' ? 'catId/DESC/' . $newOffset : 'catId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
								<th width="10%" align="left" class="<?php echo ($sort_by=="catName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
									Category Image	
				                </th>                                  
                                <th width="18%" align="left" class="<?php echo ($sort_by=="catName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'catName' && $sort_type == 'ASC' ? 'catName/DESC/' . $newOffset : 'catName/ASC/' . $newOffset);
                                    echo anchor($url, 'Category Name');
                                    ?>                                   
                                </th>
                                
                                 <th width="20%" align="left" class="<?php echo ($sort_by=="catDescription" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'catDescription' && $sort_type == 'ASC' ? 'catDescription/DESC/' . $newOffset : 'catDescription/ASC/' . $newOffset);
                                    echo anchor($url, 'Category Description');
                                    ?>                                   
                                </th>                             
                                <th width="15%" align="left" class="<?php echo ($sort_by=="catCreatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'catCreatedOn' && $sort_type == 'ASC' ? 'catCreatedOn/DESC/' . $newOffset : 'catCreatedOn/ASC/' . $newOffset);
                                     echo anchor($url, 'Created On');								
                                    ?>     
                                </th>                                     
                                 <th width="15%" align="left" class="<?php echo ($sort_by=="catUpdatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'catUpdatedOn' && $sort_type == 'ASC' ? 'catUpdatedOn/DESC/' . $newOffset : 'catUpdatedOn/ASC/' . $newOffset);
                                    echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($listCategory as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['catId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo ++$key;?></td>  
                                    <td><img src="<?php echo SITE_ROOT_FOR_USER.'category_images/'.$val['catImageName'];?>" width="75"/></td>                                                                    
                                    <td><?php echo anchor(ADMIN_FOLDER_NAME."/category/edit/".$val['catId'],$val['catName'],array('title'=>'Edit Record'));?></td>
                                    <td><?php echo $val['catDescription'];?></td>
                                    <td><?php echo $val['catCreatedOn'];?></td>                                    
                                    <td><?php echo $val['catUpdatedOn'];?></td>                                    
                                    <td>                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/category/edit/' .$val['catId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/category/delete/' .$val['catId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
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
       <?php echo form_close(); ?>  
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
