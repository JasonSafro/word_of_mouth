<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Contact Us</h5>
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
            //$form_url = ADMIN_FOLDER_NAME.'/channels/delete_selected/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);

            //echo form_open($form_url, $attr);
            ?>
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">
                    <?php $newOffset= ($offset -1);?>
                        <thead>
                            <tr>
                                <th width="13%" align="left" class="<?php echo ($sort_by=="cnt_fname" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'cnt_fname' && $sort_type == 'ASC' ? 'cnt_fname/DESC/' . $newOffset : 'cnt_fname/ASC/' . $newOffset);
                                    echo anchor($url, 'First Name');
                                    ?>                                   
                                </th>
                                
                                 <th width="13%" align="left" class="<?php echo ($sort_by=="cnt_lname" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php                                
                                    $url= $base_url_address.($sort_by == 'cnt_lname' && $sort_type == 'ASC' ? 'cnt_lname/DESC/' . $newOffset : 'cnt_lname/ASC/' . $newOffset);
                                    echo anchor($url, 'Last Name');
                                    ?>                                   
                                </th>
                                
                                <th width="13%" align="left" class="<?php echo ($sort_by=="cnt_email" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'cnt_email' && $sort_type == 'ASC' ? 'cnt_email/DESC/' . $newOffset : 'cnt_email/ASC/' . $newOffset);
                                    echo anchor($url, 'Email');								
                                    ?>     
                                </th>  
                             
                                <th width="19%" align="left" class="<?php echo ($sort_by=="cnt_msg" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'cnt_msg' && $sort_type == 'ASC' ? 'cnt_msg/DESC/' . $newOffset : 'cnt_msg/ASC/' . $newOffset);
                                    echo anchor($url, 'Message');								
                                    ?>     
                                </th>
                                <th>
                                <?php
                                    $url= $base_url_address.($sort_by == 'cnt_reason' && $sort_type == 'ASC' ? 'cnt_reason/DESC/' . $newOffset : 'cnt_reason/ASC/' . $newOffset);
                                    echo anchor($url, 'Reason');								
                                    ?>     
                                </th>
                               
                                <th width="10%" align="left" class="<?php echo ($sort_by=="cnt_date" ? ($sort_type=="ASC" ? "rowASC" : "rowDESC") : "");?>">
                                    <?php
                                    $url= $base_url_address.($sort_by == 'cnt_date' && $sort_type == 'ASC' ? 'cnt_date/DESC/' . $newOffset : 'cnt_date/ASC/' . $newOffset);
                                     echo anchor($url, 'Created On');								
                                    ?>     
                                </th>
                                
                                <th width="14%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($listContactus as $key=>$val){?>
                        <tbody>
                               <tr>                                 
                                    <td><?php echo $val['cnt_fname'];?></td>                                    
                                    <td><?php echo $val['cnt_lname'];?></td>                                    
                                    <td><?php echo $val['cnt_email'];?></td>                                    
                                    <td><?php echo $val['cnt_msg'];?></td>  
                                     <td><?php echo $val['reason_name'];?></td>                                    
                                    <td><?php echo $val['cnt_date'];?></td>
                                    <td><?php $delete_url=ADMIN_FOLDER_NAME.'/contact_us/delete_contact/' .$val['cnt_id'];?>
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
