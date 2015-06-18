<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Registered User Detailed View</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">  
                 <div class="form">
                    <div class="fields">

                       <div class="field">
                            <div class="label">
                                <label for="input-large">User Id:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_id']=='')echo "--";else echo $user_view[0]['user_id'];?></div>
                        </div>    
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">User Name:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_name']=='')echo "--";else echo $user_view[0]['user_name'];?></div>
                        </div>                         
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email Address:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_email']=='')echo "--";else echo $user_view[0]['user_email'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">First Name:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_fname']=='')echo "--";else echo $user_view[0]['user_fname'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Last Name:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_lname']=='')echo "--";else echo $user_view[0]['user_lname'];?></div>
                        </div>                         
                        
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Phone Number:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_phone']=='')echo "--";else echo $user_view[0]['user_phone'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">City:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_city']=='')echo "--";else echo $user_view[0]['user_city'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">State:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_state']=='')echo "--";else echo $state;?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Country:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_country']=='')echo "--";else echo $user_country;?></div>
                        </div> 
                
                        <div class="field">
                            <div class="label">
                                <label for="input-large">User Interested In:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_interest']=='')echo "--";else echo $user_view[0]['user_interest'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">News Letter Subscribe:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_newslet_sub']=='')echo "--";else echo $user_view[0]['user_newslet_sub'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">User Account Type:</label>
                            </div>
                            <div class="input"><?php if($user_view[0]['user_type']=='buss_user') echo "Bussiness User";else echo "Site User";?></div>
                        </div>
                        <?php if($user_view[0]['user_plan']!=''){?>
                            <div class="field">
                            <div class="label">
                                <label for="input-large">User Plan:</label>
                            </div>
                            <div class="input"><?php
                            if ($user_view[0]['user_plan'] == 'bm')
                                echo $basic_plan_name . " " . $basic_plan_monthly_name;
                            else if ($user_view[0]['user_plan'] == 'ba')
                                echo $basic_plan_name . " " . $basic_plan_annual_name;
                            else if ($user_view[0]['user_plan'] == 'pm')
                                echo $prem_plan_name . " " . $prem_plan_monthly_name;
                            else if ($user_view[0]['user_plan'] == 'pa')
                                echo $prem_plan_name . " " . $prem_plan_annual_name;
                            else
                                echo "N/A";
                            ?></div>
                        </div>
                        <?php }?>
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/user";?>'" /> 							
                     </div>
                </div>
            </div>
             <?php if($user_view[0]['user_type']=='buss_user'){?>
            <!-- Business Details -->
             <div class="form">
                <label for="input-large"><b>Business Information:</b></label>
            </div>
                        <div class="table">  
                 <div class="form">
                    <div class="fields">
                    <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input">
                               <?php if($businfo[0]['buss_name']=='')echo "--";else echo $businfo[0]['buss_name'];?>
                            </div>
                        </div>     

                        <div class="field">
                            <div class="label">
                                <label for="input-large">Contact Name:</label>
                            </div>
                            <div class="input">
                               <?php if($businfo[0]['buss_cont_name']=='')echo "--";else echo $businfo[0]['buss_cont_name'];?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Address:</label>
                            </div>
                            <div class="input">
                                 <?php if($businfo[0]['buss_address']=='')echo "--";else echo $businfo[0]['buss_address'];?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Address add on:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_addr_addon']=='')echo "--";else echo $businfo[0]['buss_addr_addon'];?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">City:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_city']=='')echo "--";else echo $businfo[0]['buss_city'];?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Zip code:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_zip_code']=='')echo "--";else echo $businfo[0]['buss_zip_code'];?>
                            </div>
                        </div>                                                
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Phone:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_phone']=='')echo "--";else echo $businfo[0]['buss_phone'];?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Fax:</label>
                            </div>
                            <div class="input">          
                                <?php if($businfo[0]['buss_fax']=='')echo "--";else echo $businfo[0]['buss_fax'];?>
                            </div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Web Address:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_web_address']=='')echo "--";else echo $businfo[0]['buss_web_address'];?>
                            </div>
                        </div>
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Contact Email Address:</label>
                            </div>
                            <div class="input">
                               <?php if($businfo[0]['buss_email']=='')echo "--";else echo $businfo[0]['buss_email'];?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business License Number:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_license_num']=='')echo "--";else echo $businfo[0]['buss_license_num'];?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Social Media Channels:</label>
                            </div>
                            <div class="input">
                                <?php if($businfo[0]['buss_social_media_channel_1']=='')echo "--";else echo $businfo[0]['buss_social_media_channel_1'];?>
                            </div><br/>
                            <div class="input">
                                 <?php if($businfo[0]['buss_social_media_channel_2']=='')echo "--";else echo $businfo[0]['buss_social_media_channel_2'];?>
                            </div><br/>
                            <div class="input">
                                 <?php if($businfo[0]['buss_social_media_channel_3']=='')echo "--";else echo $businfo[0]['buss_social_media_channel_3'];?>
                            </div><br/>
                            <div class="input">
                                <?php if($businfo[0]['buss_social_media_channel_4']=='')echo "--";else echo $businfo[0]['buss_social_media_channel_4'];?>
                            </div><br/>
                        </div>							
                     </div>
                </div>
            </div><?php }?>
            <!-- Business Details End -->
        </div>                     
    </div>
    <!-- end content / right -->
</div>