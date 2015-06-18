<!-- content -->

<div id="content"> 
  <!-- content / right -->
  <div id="right"> 
    <!-- table -->
    <div class="box"> 
     <!-- box / title -->
      <div class="title">
        <h5>Details of <?php echo $plan_name;?>&nbsp;Subscription Plan</h5>       
      </div>
     
      <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
     
      <!-- end box / title -->
	  
           <div class="table">
                <table width="100%" id="myTable" class="tablesorter" border="0" cellpadding="0" cellspacing="1">                   
                        <thead>                           
                                  <tr> 
                                      <th width="20%" align="center">
                                          </th>
                                 <th width="40%" align="center">
                                  Monthly                                 
                                </th>
                                <th width="40%" align="center">
                                 Annually                           
                                </th> 
                            </tr>
			</thead>
                          <tbody>
                               <tr>
                                   <td align="center"><b>
                                       Price
                                       </b></td>
                                       <td align="center">$<?php echo $mon_price;?>
                                           </td>
                                           <td align="center">$<?php echo $ann_price;?>
                                           </td>
                               </tr> 
                               <!--<tr>
                                   <td align="center"><b>
                                      Valid Period
                                       </b></td>
                                       <td align="center"><?php echo $mon_price_period;?>
                                           </td>
                                           <td align="center"><?php echo $ann_price_period;?>
                                           </td>
                               </tr>--> 
                               <tr>
                                   <td align="center"><b>
                                      Created Date
                                      </b></td>
                                       <td align="center"><?php echo $mon_price_created_date;?>
                                           </td>
                                           <td align="center"><?php echo $ann_price_created_date;?>
                                           </td>
                               </tr> 
                               <tr>
                                   <td align="center"><b>
                                       Updated Date
                                      </b></td>
                                       <td align="center"><?php echo $ann_price_updated_date;?>
                                           </td>
                                           <td align="center"><?php echo $mon_price_updated_date;?>
                                           </td>
                               </tr> 
                          
                                
                                </tbody>
                        </table>      
                 <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/subscription_plans";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/subscription_plans/', 'Back'); ?>
             
 
	  </div>
    </div>
	
    <!-- end table --> 
    <!-- end box / right --> 
  </div>
  <!-- end content / right --> 
</div>
<!-- end content --> 
