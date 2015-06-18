<!-- content -->

<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?> footer video</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewFaq', 'id' => 'frmNewFaq', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_footer_videos/add_new/'.$sort_by.'/'.$sort_type.'/'.($offset);
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_footer_videos/edit/'.$fvId.'/'.$sort_by.'/'.$sort_type.'/'.($offset);
                    echo form_open_multipart($form_url1, $attr1);
                    ?>
                <input class="input" name="fvId" type="hidden" value="<?php echo $fvId;?>"/>               
                 <div class="form">
                    <div class="fields">
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Select Page:</label>
                            </div>
                            <div class="input">
                                <?php 
                                $pageArray=array(''=>'Select Page','home'=>'Home page','aboutus'=>'Aboutus page','how_it_works'=>'How it works page',
                                    'services'=>'Our services page','deals_and_coupons'=>'Deals & Coupons page','we_are_hiring'=>"We'are hiring page",
                                    'faq'=>'FAQ page','contact_us'=>'Contact us page');
                                $attr='id="fvPageName"';
                                echo form_dropdown('fvPageName',$pageArray,set_value('fvPageName',$fvPageName),$attr);
                                ?>
                                <?php echo form_error('fvPageName'); ?>                                
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Slider Image:</label>
                            </div>
                            <div class="input">
                                <input type="file" name="fvImage" value="" id="fvImage"/>
                                <div style="clear:both; margin-bottom: 5px;"></div> 
                                <span>Note: Allowed Image Types:(gif|jpg|png), Recommended Height:75, width:125</span>
                                <?php if ($action == 'Edit') { ?>
                                   <div style="clear:both; margin-bottom: 5px;"></div> 
                                    <img src="<?php echo SITE_ROOT_FOR_USER . 'sitedata/footer_videos_images/' . $fvImage; ?>" width="125" height="75"/>	
                                <?php } ?>								
                                <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?>                                    
                                <?php //echo form_error('fvImage'); ?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Title:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="fvTitle" id="fvTitle" value="<?php echo set_value('fvTitle',$fvTitle);?>" maxlength="50" size="70"/>
                                <?php echo form_error('fvTitle'); ?>                                
                            </div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Description:</label>
                            </div>
                            <div class="input">
                                <textarea name="fvDescription" id="fvDescription" rows="3" cols="60"><?php echo set_value('fvDescription',$fvDescription);?></textarea>                                
                                <?php echo form_error('fvDescription'); ?>                                
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">YouTube video link:</label>
                            </div>
                            <div class="input">
                                <textarea name="fvYouTubeVideoLink" id="fvYouTubeVideoLink" rows="2" cols="60"><?php echo set_value('fvYouTubeVideoLink',$fvYouTubeVideoLink);?></textarea>                                
                                <?php echo form_error('fvYouTubeVideoLink'); ?>                                
                            </div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Read more link:</label>
                            </div>
                            <div class="input">
                                <textarea name="fvReadMoreLink" id="fvReadMoreLink" rows="2" cols="60"><?php echo set_value('fvReadMoreLink',$fvReadMoreLink);?></textarea>                                
                                <?php echo form_error('fvReadMoreLink'); ?>                                
                            </div>
                        </div> 
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" class="ui-button custom-default-button"/>
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_footer_videos";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_footer_videos/', 'Back'); ?>
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