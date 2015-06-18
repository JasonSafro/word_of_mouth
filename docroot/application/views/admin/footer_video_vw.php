<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Footer Videos</h5>
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
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_footer_videos/add_new/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);
                    echo form_open($form_url1, $attr1);
                    ?>
                   <input type="button" name="newFaqBtn" class="ui-button custom-default-button" value="New Video" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                    <?php echo form_close(); ?>  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmFaq', 'id' => 'frmFaq', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_footer_videos/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="3%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="2%" align="center" class="<?php echo ($sort_by=="fvId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvId' && $sort_type == 'ASC' ? 'fvId/DESC/' . $newOffset : 'fvId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="fvImage" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvImage' && $sort_type == 'ASC' ? 'fvImage/DESC/' . $newOffset : 'fvImage/ASC/' . $newOffset);
                                    echo anchor($url, 'Image');
                                    ?>                                   
                                </th>
                                
                                <th width="10%" align="left" class="<?php echo ($sort_by=="fvPageName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvPageName' && $sort_type == 'ASC' ? 'fvPageName/DESC/' . $newOffset : 'fvPageName/ASC/' . $newOffset);
                                    echo anchor($url, 'Page');
                                    ?>                                   
                                </th>
                                
                                 <th width="15%" align="left" class="<?php echo ($sort_by=="fvTitle" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvTitle' && $sort_type == 'ASC' ? 'fvTitle/DESC/' . $newOffset : 'fvTitle/ASC/' . $newOffset);
                                    echo anchor($url, 'Title');
                                    ?>                                   
                                </th>
                                <th width="20%" align="left" class="<?php echo ($sort_by=="fvDescription" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvDescription' && $sort_type == 'ASC' ? 'fvDescription/DESC/' . $newOffset : 'fvDescription/ASC/' . $newOffset);
                                    echo anchor($url, 'Description');
                                    ?>                                   
                                </th>
                                <th width="20%" align="left" class="<?php echo ($sort_by=="fvYouTubeVideoLink" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvYouTubeVideoLink' && $sort_type == 'ASC' ? 'fvYouTubeVideoLink/DESC/' . $newOffset : 'fvYouTubeVideoLink/ASC/' . $newOffset);
                                    echo anchor($url, 'Video Link');
                                    ?>                                   
                                </th>
                                <!--<th width="15%" align="left" class="<?php echo ($sort_by=="fvReadMoreLink" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'fvReadMoreLink' && $sort_type == 'ASC' ? 'fvReadMoreLink/DESC/' . $newOffset : 'fvReadMoreLink/ASC/' . $newOffset);
                                    echo anchor($url, 'Read more link');
                                    ?>                                   
                                </th>-->
                               
                                <th width="8%" align="left" class="<?php echo ($sort_by=="fvCreatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'fvCreatedOn' && $sort_type == 'ASC' ? 'fvCreatedOn/DESC/' . $newOffset : 'fvCreatedOn/ASC/' . $newOffset);
                                     echo anchor($url, 'Created On');								
                                    ?>     
                                </th>                                     
                                 <?php /*?><th width="8%" align="left" class="<?php echo ($sort_by=="fvUpdatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'fvUpdatedOn' && $sort_type == 'ASC' ? 'fvUpdatedOn/DESC/' . $newOffset : 'fvUpdatedOn/ASC/' . $newOffset);
                                    echo anchor($url, 'Updated On');								
                                    ?>     
                                </th><?php */?>
                                <th width="4%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <tbody>
                        <?php 
                        $pageArray=array('home'=>'Home page','aboutus'=>'Aboutus page','how_it_works'=>'How it works page',
                                    'services'=>'Our services page','deals_and_coupons'=>'Deals & Coupons page','we_are_hiring'=>"We'are hiring page",
                                    'faq'=>'FAQ page','contact_us'=>'Contact us page');?>    
                        <?php foreach($sliderList as $key=>$val){?>
                               <tr>
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['fvId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo ++$key;?></td> 
                                   
                                   <td><?php echo anchor(ADMIN_FOLDER_NAME."/manage_footer_videos/edit/".$val['fvId'],img(array('src'=>SITE_ROOT_FOR_USER . 'sitedata/footer_videos_images/'.$val['fvImage'],'height'=>'75','width'=>'125')),array('title'=>'Edit Record'));?></td>                                    
                                   <td><?php echo $pageArray[$val['fvPageName']];?></td> 
                                   <td><?php echo $val['fvTitle'];?></td> 
                                   <td><?php echo $val['fvDescription'];?></td> 
                                   <td><?php echo anchor($val['fvYouTubeVideoLink'],$val['fvYouTubeVideoLink'],'target="_blanck"')?></td> 
                                   <!--<td><?php echo anchor($val['fvReadMoreLink'],$val['fvReadMoreLink'],'target="_blanck"')?></td> -->
                                   <td><?php echo $val['fvCreatedOn'];?></td>                                    
                                   <?php /*?><td><?php echo $val['fvUpdatedOn'];?></td>  <?php */?>                                  
                                   <td>                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_footer_videos/edit/' .$val['fvId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_footer_videos/delete/' .$val['fvId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
		
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
