<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Reviews</h5>
        <div class="search">
          
        </div> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
           
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmReviews', 'id' => 'frmReviews', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_reviews/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="5%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="5%" align="center" class="<?php echo ($sort_by=="rvwId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'rvwId' && $sort_type == 'ASC' ? 'rvwId/DESC/' . $newOffset : 'rvwId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
                                <!--<th width="10%" align="left" class="<?php echo ($sort_by=="catName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'catName' && $sort_type == 'ASC' ? 'catName/DESC/' . $newOffset : 'catName/ASC/' . $newOffset);
                                    echo anchor($url, 'Category Name');
                                    ?>                                   
                                </th>-->2
                               
                                <th width="20%" align="left" class="<?php echo ($sort_by=="buss_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'buss_name' && $sort_type == 'ASC' ? 'buss_name/DESC/' . $newOffset : 'buss_name/ASC/' . $newOffset);
                                     echo anchor($url, 'Business');								
                                    ?>     
                                </th>                                     
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="rvwReviewerName" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'rvwReviewerName' && $sort_type == 'ASC' ? 'rvwReviewerName/DESC/' . $newOffset : 'rvwReviewerName/ASC/' . $newOffset);
                                    echo anchor($url, 'Reviewer');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="rvwRatingProfessionalism" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'rvwRatingProfessionalism' && $sort_type == 'ASC' ? 'rvwRatingProfessionalism/DESC/' . $newOffset : 'rvwRatingProfessionalism/ASC/' . $newOffset);
                                    echo anchor($url, 'Professionalism');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="rvwRatingDependability" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'rvwRatingDependability' && $sort_type == 'ASC' ? 'rvwRatingDependability/DESC/' . $newOffset : 'rvwRatingDependability/ASC/' . $newOffset);
                                    echo anchor($url, 'Dependability');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="rvwRatingPrice" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'rvwRatingPrice' && $sort_type == 'ASC' ? 'rvwRatingPrice/DESC/' . $newOffset : 'rvwRatingPrice/ASC/' . $newOffset);
                                    echo anchor($url, 'Price');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="rvwRatingOverall" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'rvwRatingOverall' && $sort_type == 'ASC' ? 'rvwRatingOverall/DESC/' . $newOffset : 'rvwRatingOverall/ASC/' . $newOffset);
                                    echo anchor($url, 'Overall');								
                                    ?>     
                                </th>
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="rvwStatus" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'rvwStatus' && $sort_type == 'ASC' ? 'rvwStatus/DESC/' . $newOffset : 'rvwStatus/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php 
                        $ratingNames=array('5'=>'Excellent','4'=>'Good','3'=>'Average','2'=>'Poor','1'=>'Awful');
                        foreach($reviewList as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['rvwId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo ++$key;?></td>                                    
                                    <!--<td><?php echo anchor(ADMIN_FOLDER_NAME."/manage_reviews/view/".$val['rvwId'],$val['catName'],array('title'=>'View Review'));?></td>-->
                                    <td><?php echo anchor("/home/business_details/".$val['rvwBusinessId'],$val['buss_name'],array('title'=>'View business details page.','target'=>'_blanck'));?></td>                                                                        
                                    <td><?php echo $val['rvwReviewerName'];?></td>                                    
                                    <td><?php echo $ratingNames[$val['rvwRatingProfessionalism']];?></td>
                                    <td><?php echo $ratingNames[$val['rvwRatingDependability']];?></td>                                    
                                    <td><?php echo $ratingNames[$val['rvwRatingPrice']];?></td>                                    
                                    <td><?php echo $ratingNames[$val['rvwRatingOverall']];?></td>                                    
                                    <td><?php echo $val['rvwStatus'];?></td>                                    
                                    <td>                                        
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/manage_reviews/view/' .$val['rvwId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'alt' => 'View Review'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_reviews/delete/' .$val['rvwId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
        <?php                           echo anchor($delete_url, img(array('src' => 'assets/images/delete.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Delete record')), array("onclick" => "if(!confirm('Do you want to delete this?')) return false;")); ?>
		
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
                <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','delete.png' => 'Delete details');
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
