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
                <h5>Edit <?php echo $content[0]['pageName'];?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $att=array('name'=>'edit_content');
                    echo form_open(ADMIN_FOLDER_NAME.'/static_pages/edit/'.$content[0]['pageId']);
                    ?>
                <input class="input" name="pageId" type="hidden" value="<?php echo $content[0]['pageId'];?>"/>
                <input name="pageName"  type="hidden" type="text" value="<?php echo $content[0]['pageName'];?>"/>
                 <div class="form">
                    <div class="fields">
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Meta Title: <b class="require">*</b></label>
                            </div>
                            <div class="input">
                                <input type="text" id="pageMetaTitle" name="pageMetaTitle" value="<?php echo set_value('pageMetaTitle',$content[0]['pageMetaTitle']);?>" size="100"/>
                                <?php echo form_error('pageMetaTitle'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Meta Description:</label>
                            </div>
                            <div class="input">
                                <input type="text" id="pageMetaDescription" name="pageMetaDescription" value="<?php echo set_value('pageMetaDescription',$content[0]['pageMetaDescription']);?>" size="100"/>
                                <?php echo form_error('pageMetaDescription'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Meta Keywords:</label>
                            </div>
                            <div class="input">
                                <textarea id="pageMetaKeywords" name="pageMetaKeywords" rows="3" cols="75"><?php echo set_value('pageMetaKeywords',$content[0]['pageMetaKeywords']);?></textarea>
                                <p style="margin:0 !important;"><strong>Help Tip:</strong>The keyword tags should contain between 4 and 10 keywords. They should be listed with commas and should correspond to the major search phrases you are targeting. Every word in this tag should appear somewhere in the body, or you might get penalized for irrelevance. No single word should appear more than twice, or it may be considered spam.</p>
                                <?php echo form_error('pageMetaKeywords'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Page Heading: <b class="require">*</b></label>
                            </div>
                            <div class="input">
                                <input type="text" id="pageHeading" name="pageHeading" value="<?php echo set_value('pageHeading',$content[0]['pageHeading']);?>" size="100"/>
                                <?php echo form_error('pageHeading'); ?>
                            </div>
                        </div>

			<div class="field">
                            <div class="label">
                                <label for="input-large">Page Content: <b class="require">*</b></label>
                            </div>
                            <div class="input">
                                <textarea id="editor1" name="pageContent"><?php if(validation_errors()): echo set_value('pageContent'); else: echo $content[0]['pageContent']; endif;?></textarea>
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
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/static_pages";?>'" /> 							
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