<script type="text/javascript">
	var editor_data = CKEDITOR.instances.editor1.getData();
</script>

<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo "send Email to user";?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
            <?php
		   
            $attr = array('name' => 'frmemailnewsletter', 'id' => 'frmemailnewsletter', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open(ADMIN_FOLDER_NAME.'/manage_newsletter/send_news_mail/'.$newsId, $attr);
            ?>
           
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email Subject:</label>
                            </div>
                            <div class="input">
                                <input name="newsSubject" id="newsSubject" value="<?php echo set_value('newsSubject',$newsSubject);?>" type="text"  maxlength="30"  size="135"/>
                                <?php echo form_error('newsSubject');?>
                            </div>
                     </div> 

					<div class="field">
                            <div class="label">
                                <label for="input-large">Email Body:</label>
                            </div>
                            <div class="input">
                                <textarea id="newsMessageBody" name="newsMessageBody"><?php  echo set_value('newsMessageBody',$newsMessageBody); ?></textarea>
                                <?php echo form_error('newsMessageBody'); ?>
                                <script type="text/javascript">
                                        CKEDITOR.replace( 'newsMessageBody',
                                        {
                                                fullPage : true,
                                                extraPlugins : 'docprops',
                                                filebrowserBrowseUrl : '<?php echo base_url();?>'+'assets/plugins/ckfinder/ckfinder.html',
                                                filebrowserImageBrowseUrl : '<?php echo base_url();?>'+'assets/plugins/ckfinder/ckfinder.html?type=Images',
                                                filebrowserFlashBrowseUrl : '<?php echo base_url();?>'+'assets/plugins/ckfinder/ckfinder.html?type=Flash',
                                                filebrowserUploadUrl : '<?php echo base_url();?>'+'assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                                filebrowserImageUploadUrl : '<?php echo base_url();?>'+'assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                                filebrowserFlashUploadUrl : '<?php echo base_url();?>'+'assets/plugins/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'								
                                        });
                                </script>
                            </div>
                        </div>
                        
                     <div class="field">
                            <div class="label" >
                                <label for="input-large">send mail to existing Users?</label>
                            </div>
                            <div class="input">
                            Yes <input type="radio" name="status" value="Yes" />  <br/><br/>
                            NO <input type="radio" name="status" value="No" checked/> <br/><br/>
							</div>
                       </div>
                     
                                       
                        
                    <div class="field">
                            <div class="label">
                                <label for="input-large">Extra Emails:</label>
                            </div>
                           <div class="input">
                                <input name="Email" id="Email" value="" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('Email');?>
                            </div>                            
                       </div> 
            
              <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="send" value="send" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_newsletter";?>'"/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_newsletter";?>'" /> 							
                        </div>
                     </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>                     
    </div>
    <!-- end content / right -->
</div>



