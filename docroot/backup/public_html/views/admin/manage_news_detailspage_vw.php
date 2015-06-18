<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>News Letter Detailed View</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <?php $info=$newsInfo[0];?>
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Subject</label>
                            </div>
                            <div class="input"><?php if($info['newsSubject']=='')echo "--";else echo $info['newsSubject'];?></div>
                        </div>  
                        
                       <div class="field">                           
                            <div class="label">
                                <label for="input-large">Message:</label>
                            </div>
                            <div class="input"><?php if($info['newsMessageBody']=='')echo "--";else echo $info['newsMessageBody'];?></div>
                        </div>    
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Status:</label>
                            </div>
                            <div class="input"><?php if($info['newsStatus']=='')echo "--";else echo $info['newsStatus'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Created On:</label>
                            </div>
                            <div class="input"><?php if($info['newsCreatedOn']=='')echo "--";else echo $info['newsCreatedOn'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Updated On:</label>
                            </div>
                            <div class="input"><?php if($info['newsUpdatedOn']=='')echo "--";else echo $info['newsUpdatedOn'];?></div>
                        </div>
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onClick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_newsletter";?>'" /> 
                         <input type="button" class="ui-button custom-default-button" name="mail_sent" value="Send Email" onClick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_newsletter/send_news_mail/".$info['newsId'];?>'"/>							
                     </div>
                </div>
            </div>
            
        </div>                     
    </div>
    <!-- end content / right -->
</div>