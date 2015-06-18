<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Claim Detailed View</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <?php $info=$request;?>
                        <?php
                            if($info['crStatus']!="Complete"){
                                $attr = array('name' => 'frmClaimRequest', 'id' => 'frmClaimRequest', 'autocomplete' => 'off', 'method' => 'post');
                                $form_url = ADMIN_FOLDER_NAME.'/manage_claims/save_satus/'.$info['crId'];
                                echo form_open($form_url, $attr);
                                ?>
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Does User has account:</label>
                            </div>
                            <div class="input"><?php if($info['userFullName']=='')echo "No";else echo 'Yes'.' ('.$info['userFullName'].')';?></div>
                        </div>    
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business phone number:</label>
                            </div>
                            <div class="input"><?php if($info['crBussPhoneNo']=='')echo "--";else echo $info['crBussPhoneNo'];?></div>
                        </div>                         
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business official address:</label>
                            </div>
                            <div class="input"><?php if($info['crBussOfficeAddress']=='')echo "--";else echo $info['crBussOfficeAddress'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business official email:</label>
                            </div>
                            <div class="input"><?php if($info['crBussOfficialEmail']=='')echo "--";else echo $info['crBussOfficialEmail'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Additional information:</label>
                            </div>
                            <div class="input"><?php if($info['crBussAdditionalInfo']=='')echo "--";else echo nl2br($info['crBussAdditionalInfo']);?></div>
                            
                        </div> 
                        
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Status:</label>
                            </div>
                            <div class="input">
                                <b><?php echo $info['crStatus'];?></b>
                            
                                <br/><br/>
                                <input type="radio" name="status" value="Approved" <?php if($info['crStatus']=='Approved'){?>checked="checked"<?php }?> /> Approve<br/><br/>
                                <input type="radio" name="status" value="Rejected" <?php if($info['crStatus']=='Rejected'){?>checked="checked"<?php }?> /> Reject<br/><br/>
                                
                                
                            </div>
                        </div> 
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="submit" class="ui-button custom-default-button" name="submit" value="Change Status" />
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_claims";?>'" /> 							
                     
                    <?php echo form_close();
                            }
                            ?>
                    </div>
                </div>
            </div>
            
        </div>                     
    </div>
    <!-- end content / right -->
</div>