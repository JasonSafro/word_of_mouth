<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Manage Services</h5>       
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- end box / title -->
	  
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">                   
                        <thead>
                            <tr>                                
                                 <th width="5%" align="center">
                                   Service ID                                   
                                </th>
                                <th width="30%" align="center">
                                   Service Name                              
                                </th>                               
                                <th width="5%" align="center">
                                    For <?php echo $basic_plan_name;?>&nbsp;Plan   
                                </th>                                     
                                 <th width="5%" align="center">
                                      For <?php echo $premium_plan_name;?>&nbsp;Plan   
                                </th>
                                 <th width="5%" align="center">
                                     For <?php echo $basic_plan_name;?>&nbsp;Plan Limit
                                </th>
                                <th width="5%" align="center">
                                     For <?php echo $premium_plan_name;?>&nbsp;Plan Limit
                                </th>
                                <th width="30%" align="center">
                                    Service Description
                                </th>
                                <th width="9%" align="center">
                                   Service Created On
                                </th>
                                <th width="9%" align="center">
                                 Service Updated On
                                </th>
                                <th width="7%" align="center" style="background: #E6EEEE;">Action</th>
                            </tr>
			</thead>
                        <?php foreach($service_List as $key=>$val){?>
                        <tbody>
                               <tr>   
                                   <td align="center"><?php echo $val['service_id'];?></td>                                    
                                    <td><?php echo $val['service_name'];?></td>                                    
                                    <td align="center">
                                         <?php $status_url=ADMIN_FOLDER_NAME.'/manage_services/change_status_basic/';
                                    if($val['service_basic_status']=='A')
                                    {
                                        $statusAlertMessage="Do you want to Deactivate this Service?";
                                        $status="I";
                                        $statusImg="tick.png";}
                                       // echo img(array('src' => 'assets/images/tick.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Applicable'));
                                    else {
                                           $statusAlertMessage="Do you want to Activate this Plan?";
                                            $status="A";
                                            $statusImg="cross.png";
                                    }
                                        //echo img(array('src' => 'assets/images/cross.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Not Applicable'));
                                    echo anchor($status_url.'/'. $val['service_id'] . '/' . $status, img(array('src' => 'assets/images/' . $statusImg, 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Change status')),array("onclick" => "if(!confirm('".$statusAlertMessage."')) return false;"));
                                    ?>
                                    </td>                                    
                                    <td align="center">
                                    <?php 
                                  /*  if($val['service_premium_status']=='A')
                                        echo img(array('src' => 'assets/images/tick.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Applicable'));
                                    else 
                                        echo img(array('src' => 'assets/images/cross.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Not Applicable'));*/
                                    $status_url1=ADMIN_FOLDER_NAME.'/manage_services/change_status_premium/';
                                    if($val['service_premium_status']=='A')
                                    {
                                        $statusAlertMessage1="Do you want to Deactivate this Service?";
                                        $status1="I";
                                        $statusImg="tick.png";}
                                       // echo img(array('src' => 'assets/images/tick.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Applicable'));
                                    else {
                                           $statusAlertMessage1="Do you want to Activate this Plan?";
                                            $status1="A";
                                            $statusImg="cross.png";
                                    }
                                        //echo img(array('src' => 'assets/images/cross.png', 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Not Applicable'));
                                    echo anchor($status_url1.'/'. $val['service_id'] . '/' . $status1, img(array('src' => 'assets/images/' . $statusImg, 'border' => '0', 'width' => '16', 'height' => '16', 'alt' => 'Change status')),array("onclick" => "if(!confirm('".$statusAlertMessage1."')) return false;"));
                                    ?>
                                    </td> 
                                    <td align="center"><?php if($val['service_basic_limit']=='') echo "--";else if($val['service_basic_limit']=='0') echo "Unlimited"; else echo $val['service_basic_limit'];?></td>
                                    <td align="center"><?php if($val['service_premium_limit']=='')echo "--";else if($val['service_premium_limit']=='0') echo "Unlimited"; else echo $val['service_premium_limit'];?></td>
                                    <td><?php echo $val['service_description'];?></td>
                                    <td align="center"><?php echo $val['service_created_on'];?></td>
                                    <td align="center"><?php echo $val['service_updated_on'];?></td>
                                    <td> <?php $edit_url=ADMIN_FOLDER_NAME.'/manage_services/edit/' .$val['service_id'];?>
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
