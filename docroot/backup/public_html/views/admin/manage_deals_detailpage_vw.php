<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Job Detailed View</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <?php $info=$dealInfo[0];?>
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input"><?php if($info['buss_name']=='')echo "--";else echo anchor('home/business_details/'.$info['dealBusinessId'],$info['buss_name'],array('target'=>'_blanck','title'=>'View business details'));;?></div>
                        </div>  
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Image:</label>
                            </div>
                            <div class="input"><img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$info['dealImage'];?>" /></div>
                        </div>
                        
                       <div class="field">                           
                            <div class="label">
                                <label for="input-large">Deal Overview:</label>
                            </div>
                            <div class="input"><?php if($info['dealOverview']=='')echo "--";else echo nl2br($info['dealOverview']);?></div>
                        </div>    
                        
                                               
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Details:</label>
                            </div>
                            <div class="input"><?php if($info['dealDetails']=='')echo "--";else echo nl2br($info['dealDetails']);?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Values:</label>
                            </div>
                            <div class="input"><?php if($info['dealValue']=='')echo "--";else echo '$'.$info['dealValue'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Discount:</label>
                            </div>
                            <div class="input"><?php if($info['dealDiscounts']=='')echo "--";else echo $info['dealDiscounts'].'%';?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Saving:</label>
                            </div>
                            <div class="input"><?php if($info['dealSavings']=='')echo "--";else echo '$'.$info['dealSavings'];?></div>
                        </div> 
                        
                         
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Final Price:</label>
                            </div>
                            <div class="input"><?php if($info['dealFinalPrice']=='')echo "--";else echo '$'.$info['dealFinalPrice'];?></div>
                        </div> 
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Limits:</label>
                            </div>
                            <div class="input"><?php if($info['dealLimit']=='')echo "--";else echo nl2br($info['dealLimit']);?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Created Date:</label>
                            </div>
                            <div class="input"><?php if($info['dealCreatedOn']=='')echo "--";else echo $info['dealCreatedOn'];?></div>
                        </div>
                
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Updated Date:</label>
                            </div>
                            <div class="input"><?php if($info['dealUpdatedOn']=='')echo "--";else echo nl2br($info['dealUpdatedOn']);?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Status:</label>
                            </div>
                            <div class="input"><?php if($info['dealStatus']=='')echo "--";else echo $info['dealStatus'];?></div>
                        </div>
                        
                        
                       
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_deals";?>'" /> 							
                     </div>
                </div>
            </div>
            
        </div>                     
    </div>
    <!-- end content / right -->
</div>