  
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=='new'?"Create New Job":"Edit Job");?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
            <?php
            $attr = array('name' => 'frmNewJob', 'id' => 'frmNewJob', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open(ADMIN_FOLDER_NAME.'/manage_jobs/'.($action=='new'?'add':"edit/$jobId"), $attr);
            ?>
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input">
                                <?php echo form_dropdown('jobBusinessId',__myBusinessDropdown(),set_value('jobBusinessId',$jobBusinessId),'id="jobBusinessId"');?>
                                <?php echo form_error('jobBusinessId'); ?>
                                
                            </div>
                        </div>  
                        
                       <div class="field">                           
                            <div class="label">
                                <label for="input-large">Job Type:</label>
                            </div>
                           <div class="input">
                               <?php echo form_dropdown('jobTypeId',__myJobTypesDropdown(),set_value('jobTypeId',$jobTypeId),'id="jobTypeId"');?>
                               <?php echo form_error('jobTypeId'); ?>                                
                            </div>
                             
                        </div>    
                        
                           <div class="field">
                            <div class="label">
                                <label for="input-large">Date Posted:</label>
                            </div>
                            <div class="input">
                                <input name="jobPostDate" id="jobPostDate" value="<?php echo set_value('jobPostDate',$jobPostDate);?>" type="text"  maxlength="10"  size="30"/>
                                <?php echo form_error('jobPostDate');?>
                            </div>                              
                        </div>                     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Job Title:</label>
                            </div>
                            <div class="input">
                                <input name="jobTitle" id="jobTitle" value="<?php echo set_value('jobTitle',$jobTitle);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('jobTitle');?>
                            </div>
                            
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Experience:</label>
                            </div>
                            <div class="input">
                                <input name="jobExperiance" id="jobExperiance" value="<?php echo set_value('jobExperiance',$jobExperiance);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('jobExperiance');?>
                            </div>                            
                        </div> 
                        
                        
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Job Description:</label>
                            </div>
                            <div class="input">
                                <textarea name="jobDescription" id="jobDescription" cols="60" rows="4"><?php echo set_value('jobDescription',$jobDescription);?></textarea>                                
                                <?php echo form_error('jobDescription');?>
                            </div>                            
                        </div> 
                        
                         
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Duties and Responsibilities:</label>
                            </div>
                             <div class="input">
                                 <textarea name="jobDutiesAndResponsibilities" id="jobDutiesAndResponsibilities" cols="60" rows="4"><?php echo set_value('jobDutiesAndResponsibilities',$jobDutiesAndResponsibilities);?></textarea>                                
                                <?php echo form_error('jobDutiesAndResponsibilities');?>
                            </div>
                            
                        </div> 
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Required Qualification:</label>
                            </div>
                             <div class="input">
                                 <textarea name="jobRequiredQualifications" id="jobRequiredQualifications" cols="60" rows="4"><?php echo set_value('jobRequiredQualifications',$jobRequiredQualifications);?></textarea>                                
                                <?php echo form_error('jobRequiredQualifications');?>
                            </div>
                            
                        </div> 
                        
                
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Desired Qualification:</label>
                            </div>
                            <div class="input">
                                <textarea name="jobDesiredQualifications" id="jobDesiredQualifications" cols="60" rows="4"><?php echo set_value('jobDesiredQualifications',$jobDesiredQualifications);?></textarea>
                                <?php echo form_error('jobDesiredQualifications');?>
                            </div>
                            
                        </div> 
                        
                       
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Additional Information:</label>
                            </div>
                            <div class="input">
                                <textarea name="jobAdditionalInformation" id="jobAdditionalInformation" cols="60" rows="4"><?php echo set_value('jobAdditionalInformation',$jobAdditionalInformation);?></textarea>
                                <?php echo form_error('jobAdditionalInformation');?>
                            </div>
                            
                        </div>
                        
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="back" value="<?php echo ($action=='new'?"Save":"Save Changes");?>"/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_reviews";?>'" /> 							
                        </div>
                     </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>                     
    </div>
    <!-- end content / right -->
</div>

<link href="<?php echo base_url();?>assets/datepicker/jquery-ui.css" rel="stylesheet" type="text/css"/>
<!--script src="<?php echo base_url();?>assets/datepicker/jquery.min.1.5.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script-->


<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        
        $("#jobPostDate").datepicker({		
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
        
        $("#EjobPostDate").datepicker({		
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
    });
</script> 