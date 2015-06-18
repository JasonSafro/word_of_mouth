<!-- content -->
<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Manage Monthly/Annually Plans</h5>       
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- end box / title -->
	  
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">                   
                        <thead>
                            <tr>
                                <th width="11%" align="center">Plan</th>
                                 <th width="11%" align="center">
                                   Plan Type                                  
                                </th>
                                <th width="11%" align="center">
                                 Price                         
                                </th>                           
                               <!--  <th width="11%" align="center">
                                     Plan Period
                                </th>-->
                                 <th width="11%" align="center">
                                     Plan Created On
                                </th>
                                 <th width="11%" align="center">
                                     Plan Updated On
                                </th>                                 
                                <th width="11%" align="center" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($sub_plan_List as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td align="center"><b><?php echo $val['subs_sub_plan_name'];?></b></td>
                                   <td align="center"><?php if($val['subs_plan_id']==1)echo $basic_plan_name;else echo $premium_plan_name;?>
                                    <td align="center">$<?php echo $val['subs_sub_plan_price'];?></td>                                    
                                   <!-- <td align="center"><?php echo $val['subs_sub_plan_period'];?></td>   -->                               
                                    <td align="center"><?php echo $val['subs_sub_plan_created_on'];?></td>   
                                    <td align="center"><?php echo $val['subs_sub_plan_updated_on'];?></td>   
                                      <td align="center"> 
                                         <?php $subs_plan_id=$val['subs_sub_plan_id'];?>
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/sub_subscription_plans/edit/' .$val['subs_sub_plan_id'];?>
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
 
	  </div>
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
