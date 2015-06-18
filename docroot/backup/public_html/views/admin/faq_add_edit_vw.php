<!-- content -->

<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?> FAQ</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewFaq', 'id' => 'frmNewFaq', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_faq/add_new/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_faq/edit/'.$faqId.'/'.$sort_by.'/'.$sort_type.'/'.($offset - 1);
                    echo form_open($form_url1, $attr1);
                    ?>
                <input class="input" name="faqId" type="hidden" value="<?php echo $faqId;?>"/>               
                 <div class="form">
                    <div class="fields">

                        <div class="field">
                            <div class="label">
                                <label for="input-large">Question:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="faqTitle" value="<?php echo set_value('faqTitle',$faqTitle);?>" size="110" id="faqTitle"/>
                                <?php echo form_error('faqTitle'); ?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Description:</label>
                            </div>
                            <div class="input">
                                <textarea name="faqDescription" rows="5" cols="83"><?php echo set_value('faqDescription',$faqDescription);?></textarea>
                                
                                <?php echo form_error('faqDescription'); ?>                                
                            </div>
                        </div> 
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" class="ui-button custom-default-button"/>
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_faq";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_faq/', 'Back'); ?>
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