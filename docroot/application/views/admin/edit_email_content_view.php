<!-- content -->
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
                <h5>Edit <?php echo $content[0]['emailName'];?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $att=array('name'=>'edit_content');
                    echo form_open(ADMIN_FOLDER_NAME.'/email_content/edit/'.$content[0]['emailId']);
                    ?>
                <input class="input" name="emailId" type="hidden" value="<?php echo $content[0]['emailId'];?>"/>
                <input name="emailName"  type="hidden" type="text" value="<?php echo $content[0]['emailName'];?>"/>
                 <div class="form">
                    <div class="fields">

                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email Subject:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="emailSubject" value="<?php echo set_value('emailSubject',$content[0]['emailSubject']);?>" size="135" id="emailSubject"/>
                                <?php echo form_error('emailSubject'); ?>
                            </div>
                        </div>
                        
			<div class="field">
                            <div class="label">
                                <label for="input-large">Email Body:</label>
                            </div>
                            <div class="input">
                                <textarea id="editor1" name="emailBody"><?php if(validation_errors()): echo set_value('emailBody'); else: echo $content[0]['emailBody']; endif;?></textarea>
                                <?php echo form_error('description'); ?>
                                <script type="text/javascript">
                                        CKEDITOR.replace( 'editor1',
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
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="Save Changes" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/email_content";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/static_pages/', 'Back'); ?>
                                </span>
                            </div>
                        </div-->
                        </div>
                    </div>
                </div>
					
				</form>
			
            </div>
        </div>
        <!-- end table -->
        <!-- end box / right -->
    </div>
    <!-- end content / right -->
</div>