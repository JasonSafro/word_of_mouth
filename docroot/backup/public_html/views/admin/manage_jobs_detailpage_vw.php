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
                        <?php $info=$jobInfo[0];?>
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input"><?php if($info['buss_name']=='')echo "--";else echo anchor('home/business_details/'.$info['jobBusinessId'],$info['buss_name'],array('target'=>'_blanck','title'=>'View business details'));;?></div>
                        </div>  
                        
                       <div class="field">                           
                            <div class="label">
                                <label for="input-large">Job Type:</label>
                            </div>
                            <div class="input"><?php if($info['jobType']=='')echo "--";else echo $info['jobType'];?></div>
                        </div>    
                        
                                               
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Job Title:</label>
                            </div>
                            <div class="input"><?php if($info['jobTitle']=='')echo "--";else echo $info['jobTitle'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Experiance:</label>
                            </div>
                            <div class="input"><?php if($info['jobExperiance']=='')echo "--";else echo $info['jobExperiance'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Date Posted:</label>
                            </div>
                            <div class="input"><?php if($info['jobPostDate']=='')echo "--";else echo $info['jobPostDate'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Job Description:</label>
                            </div>
                            <div class="input"><?php if($info['jobDescription']=='')echo "--";else echo nl2br($info['jobDescription']);?></div>
                        </div> 
                        
                         
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Duties and Responsibilities:</label>
                            </div>
                            <div class="input"><?php if($info['jobDutiesAndResponsibilities']=='')echo "--";else echo nl2br($info['jobDutiesAndResponsibilities']);?></div>
                        </div> 
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Required Qualification:</label>
                            </div>
                            <div class="input"><?php if($info['jobRequiredQualifications']=='')echo "--";else echo nl2br($info['jobRequiredQualifications']);?></div>
                        </div> 
                        
                
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Desired Qualification:</label>
                            </div>
                            <div class="input"><?php if($info['jobDesiredQualifications']=='')echo "--";else echo nl2br($info['jobDesiredQualifications']);?></div>
                        </div> 
                        
                       
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Additional Information:</label>
                            </div>
                            <div class="input"><?php if($info['jobAdditionalInformation']=='')echo "--";else echo $info['jobAdditionalInformation'];?></div>
                        </div>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Status:</label>
                            </div>
                            <div class="input"><?php if($info['jobStatus']=='')echo "--";else echo $info['jobStatus'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Created On:</label>
                            </div>
                            <div class="input"><?php if($info['jobCreatedOn']=='')echo "--";else echo $info['jobCreatedOn'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Updated On:</label>
                            </div>
                            <div class="input"><?php if($info['jobUpdatedOn']=='')echo "--";else echo $info['jobUpdatedOn'];?></div>
                        </div>
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_jobs";?>'" /> 							
                     </div>
                </div>
            </div>
            
        </div>                     
    </div>
    <!-- end content / right -->
</div>