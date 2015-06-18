<!-- content -->

<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?> Slider</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewFaq', 'id' => 'frmNewFaq', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_slider/add_new/'.$sort_by.'/'.$sort_type.'/'.($offset);
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_slider/edit/'.$sldrId.'/'.$sort_by.'/'.$sort_type.'/'.($offset);
                    echo form_open_multipart($form_url1, $attr1);
                    ?>
                <input class="input" name="sldrId" type="hidden" value="<?php echo $sldrId;?>"/>               
                 <div class="form">
                    <div class="fields">

                        <div class="field">
                            <div class="label">
                                <label for="input-large">Slider Image:</label>
                            </div>
                            <div class="input">
                                <input type="file" name="sldrImage" value="<?php echo set_value('sldrImage',$sldrImage);?>" size="110" id="sldrImage"/>
                                <div style="clear:both; margin-bottom: 5px;"></div> 
                                <span>Note: Allowed Image Types:(gif|jpg|png), Recommended Height:350, width:520</span>
                                <?php if ($action == 'Edit') { ?>
                                   <div style="clear:both; margin-bottom: 5px;"></div> 
                                    <img src="<?php echo SITE_ROOT_FOR_USER . 'sitedata/slider_images/' . $sldrImage; ?>" width="300" height="150"/>	
                                <?php } ?>								
                                <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?>                                    
                                <?php echo form_error('sldrImage'); ?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Title:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="sldrTitle" id="sldrTitle" value="<?php echo set_value('sldrTitle',$sldrTitle);?>" maxlength="20" size="50"/>
                                <?php echo form_error('sldrTitle'); ?>                                
                            </div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Sub Title:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="sldrSubTitle" id="sldrSubTitle" value="<?php echo set_value('sldrSubTitle',$sldrSubTitle);?>" maxlength="150" size="100"/>
                                <?php echo form_error('sldrSubTitle'); ?>                                
                            </div>
                        </div> 
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" class="ui-button custom-default-button"/>
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_slider";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_slider/', 'Back'); ?>
                                </span>
                            </div>
                        </div-->
                        </div>
                    </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>
        <!-- end table -->
        <!-- end box / right -->
    </div>
    <!-- end content / right -->
</div>