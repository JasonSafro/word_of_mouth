<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Static Pages</h5>
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
     
      <!-- end box / title -->
	  
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr>                                
                                 <th width="7%" align="center" class="selected <?php echo ($sort_by=="pageId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'pageId' && $sort_type == 'ASC' ? 'pageId/DESC/' . $newOffset : 'pageId/ASC/' . $newOffset);
                                    echo anchor($url, 'Page Id');
                                    ?>                                   
                                </th>
                                <th width="20%" align="left" class="<?php echo ($sort_by=="pageName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'pageName' && $sort_type == 'ASC' ? 'pageName/DESC/' . $newOffset : 'pageName/ASC/' . $newOffset);
                                    echo anchor($url, 'Page Name');
                                    ?>                                   
                                </th>
                               
                                <th width="55%" align="left" class="<?php echo ($sort_by=="pageContent" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'pageContent' && $sort_type == 'ASC' ? 'pageContent/DESC/' . $newOffset : 'pageContent/ASC/' . $newOffset);
                                     echo anchor($url, 'Page Content');								
                                    ?>     
                                </th>                                     
                                 <th width="11%" align="left" class="<?php echo ($sort_by=="pageUpdatedOn" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'pageUpdatedOn' && $sort_type == 'ASC' ? 'pageUpdatedOn/DESC/' . $newOffset : 'pageUpdatedOn/ASC/' . $newOffset);
                                    echo anchor($url, 'Updated On');								
                                    ?>     
                                </th>
                                <th width="7%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($contentPages as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td align="center"><?php echo anchor(ADMIN_FOLDER_NAME."/static_pages/edit/".$val['pageId'],$val['pageId'],array('title'=>'Edit Record'));?></td>                                    
                                    <td><?php echo $val['pageName'];?></td>                                    
                                    <td><?php echo $val['pageContent'];?></td>                                    
                                    <td><?php echo $val['pageUpdatedOn'];?></td>                                    
                                    <td>                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/static_pages/edit/' .$val['pageId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;                                        
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
                <?php
                $legend_para['legend_options'] = array('edit.png' => 'Edit details');
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
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
