<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Subscription Plans</h5>       
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- end box / title -->
	  
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">                   
                        <thead>
                            <tr>                                
                                 <th width="7%" align="center">
                                   Plan ID                                  
                                </th>
                                <th width="20%" align="left">
                                   Plan Name                              
                                </th>                               
                                <th width="11%" align="left">
                                    Plan Created On   
                                </th>                                     
                                 <th width="11%" align="left">
                                     Plan Updated On
                                </th>
                                <!-- <th width="11%" align="left">
                                     Plan Status
                                </th>-->
                                <th width="7%" align="left" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($plan_List as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td align="center"><?php echo $val['subs_plan_id'];?></td>                                    
                                    <td><?php echo $val['subs_plan_name'];?></td>                                    
                                    <td><?php echo $val['ubs_plan_created_on'];?></td>                                    
                                    <td><?php echo $val['subs_plan_updated_on'];?></td>   
                                   <!-- <td><?php if($val['subs_plan_status']=='A') echo "Active"; else echo "InActive";?></td>-->
                                    <td> 
                                         <?php $subs_plan_id=$val['subs_plan_id'];?>
                                        <?php $view_url=ADMIN_FOLDER_NAME.'/subscription_plans/view_details/' .$val['subs_plan_id'];?>
                                        <?php echo anchor($view_url, img(array('src' => 'assets/images/view_choose.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'View record'))); ?>
                                         <?php /*
                                        $status_url=ADMIN_FOLDER_NAME.'/subscription_plans/change_status/';
                                        if($val['subs_plan_status']=='A'){
                                            $statusAlertMessage="Do you want to Deactivate this Plan?";
                                            $status="I";
                                            $statusImg="active.gif";
                                        }  else {
                                            $statusAlertMessage="Do you want to Activate this Plan?";
                                            $status="A";
                                            $statusImg="deactive.gif";
                                        }
                                        echo anchor($status_url.'/'. $val['subs_plan_id'] . '/' . $status, img(array('src' => 'assets/images/' . $statusImg, 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Change status')),array("onclick" => "if(!confirm('".$statusAlertMessage."')) return false;"));
                                       */ ?>
                                        <?php $edit_url=ADMIN_FOLDER_NAME.'/subscription_plans/edit/' .$val['subs_plan_id'];?>
                                        <?php echo anchor($edit_url, img(array('src' => 'assets/images/edit.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Edit record'))); ?> &nbsp;                                        
                                    </td>
		    		</tr>
                           <?php }?>    
                                
                                </tbody>
                        </table>
               
                <?php
                $legend_para['legend_options'] = array('view_choose.png' => 'View details','edit.png' => 'Edit details');
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
