<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Jobs</h5>
        <div class="search">
          
        </div> 
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- table action -->
            <div class="action" style="margin-bottom:10px;margin-right:20px;">
                <div class="button">
                
                    <div style="margin-top:-18px;">
                         <?php
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_jobs/add';                   
                    ?>
                   <input type="button" name="newJobBtn" class="ui-button custom-default-button" value="New Job" style="cursor:pointer;" onclick="javascript: location='<?php echo site_url($form_url1);?>'"/> </div>
                  
                </div>
            </div>
            <!-- end table action -->
     
     
     
      <!-- end box / title -->
	   <?php
            $attr = array('name' => 'frmJobs', 'id' => 'frmJobs', 'autocomplete' => 'off', 'method' => 'post');
            $form_url = ADMIN_FOLDER_NAME.'/manage_jobs/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr> 
                                <th width="5%" align="center" class="selected" style="background: #E6EEEE;"><input name="chkall" id="chkall" type="checkbox" class="checkall"/></th>
                                 <th width="5%" align="center" class="<?php echo ($sort_by=="jobId" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'jobId' && $sort_type == 'ASC' ? 'jobId/DESC/' . $newOffset : 'jobId/ASC/' . $newOffset);
                                    echo anchor($url, 'Sr.No');
                                    ?>                                   
                                </th>
                                <th width="10%" align="left" class="<?php echo ($sort_by=="jobType" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'jobType' && $sort_type == 'ASC' ? 'jobType/DESC/' . $newOffset : 'jobType/ASC/' . $newOffset);
                                    echo anchor($url, 'Job Type');
                                    ?>                                   
                                </th>
                               
                                <th width="10%" align="left" class="<?php echo ($sort_by=="buss_name" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'buss_name' && $sort_type == 'ASC' ? 'buss_name/DESC/' . $newOffset : 'buss_name/ASC/' . $newOffset);
                                     echo anchor($url, 'Business');								
                                    ?>     
                                </th>                                     
                                 <th width="10%" align="left" class="<?php echo ($sort_by=="jobTitle" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'jobTitle' && $sort_type == 'ASC' ? 'jobTitle/DESC/' . $newOffset : 'jobTitle/ASC/' . $newOffset);
                                    echo anchor($url, 'Job Title');								
                                    ?>     
                                </th>
                                <th width="8%" align="left" class="<?php echo ($sort_by=="jobExperiance" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'jobExperiance' && $sort_type == 'ASC' ? 'jobExperiance/DESC/' . $newOffset : 'jobExperiance/ASC/' . $newOffset);
                                    echo anchor($url, 'Experiance');								
                                    ?>     
                                </th>
                                <th width="28%" align="left" class="<?php echo ($sort_by=="jobDescription" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'jobDescription' && $sort_type == 'ASC' ? 'jobDescription/DESC/' . $newOffset : 'jobDescription/ASC/' . $newOffset);
                                    echo anchor($url, 'Job Description');								
                                    ?>     
                                </th>
                                
                                <th width="8%" align="left" class="<?php echo ($sort_by=="jobPostDate" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'jobPostDate' && $sort_type == 'ASC' ? 'jobPostDate/DESC/' . $newOffset : 'jobPostDate/ASC/' . $newOffset);
                                    echo anchor($url, 'Job post date');								
                                    ?>     
                                </th>
                                 <th width="6%" align="left" class="<?php echo ($sort_by=="jobStatus" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'jobStatus' && $sort_type == 'ASC' ? 'jobStatus/DESC/' . $newOffset : 'jobStatus/ASC/' . $newOffset);
                                    echo anchor($url, 'Status');								
                                    ?>     
                                </th>
                                <th width="10%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php                         
                        foreach($jobList as $key=>$val){ //echo '<pre>'; print_r($val); die;?>
                        <tbody>
                               <tr>   
                                   <td class="selected"><input name="chkmsg[]" type="checkbox" value="<?php echo $val['jobId'];?>" onclick="javascript:$('#chkall').removeAttr('checked');" class="chkmsg"/></td>
                                   <td align="center"><?php echo $val['jobId'];?></td>                                    
                                    <td><?php echo anchor(ADMIN_FOLDER_NAME."/manage_jobs/view/".$val['jobId'],$val['jobType'],array('title'=>'View Review'));?></td>                                    
                                    <td><?php echo anchor('home/business_details/'.$val['jobBusinessId'],$val['buss_name'],array('target'=>'_blanck','title'=>'View business details'));?></td>                                    
                                    <td><?php echo $val['jobTitle'];?></td>                                    
                                    <td><?php echo $val['jobExperiance'];?></td>
                                    <td><?php echo substr($val['jobDescription'],0,300);?></td>                                                            
                                    <td><?php echo $val['jobPostDate'];?></td>                                    
                                    <td><?php echo $val['jobStatus'];?></td>                                    
                                    <td>                                        
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/manage_jobs/view/' .$val['jobId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'alt' => 'View Job'))); ?> &nbsp;
                                        
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_jobs/edit/' .$val['jobId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'alt' => 'Edit Job'))); ?> &nbsp;
                                        
                                        <?php $delete_url=ADMIN_FOLDER_NAME.'/manage_jobs/delete/' .$val['jobId'].'/'.$sort_by.'/'.$sort_type.'/'.$newOffset;?>
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
