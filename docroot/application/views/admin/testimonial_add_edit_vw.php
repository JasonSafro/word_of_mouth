<!-- content -->
<script type="text/javascript">
	var editor_data = CKEDITOR.instances.editor1.getData();
</script>

<style>
    .error p{color: #F00 !important;}
</style>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New ' : 'Edit '); ?>Testimonial</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewCat', 'id' => 'frmNewCat', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_testimonials/add_new/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_testimonials/edit/'.$tmlId.'/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    echo form_open_multipart($form_url1, $attr1); 
                    ?>
                <input class="input" name="tmlId" type="hidden" value="<?php echo $tmlId;?>"/>               
                 <div class="form">
                    <div class="fields">

                        <div class="field">
                            <div class="label">
                                <label for="input-large">Person Name:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="tmlPersonName" value="<?php echo set_value('tmlPersonName',$tmlPersonName);?>" size="50" id="tmlPersonName"/>
                                <?php echo form_error('tmlPersonName'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Designation:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="tmlDesignation" value="<?php echo set_value('tmlDesignation',$tmlDesignation);?>" size="50" id="tmlDesignation"/>
                                <?php echo form_error('tmlDesignation'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Description:</label>
                            </div>
                            <div class="input">
                                <textarea name="tmlDescription" rows="3" cols="40"><?php echo set_value('tmlDescription',$tmlDescription);?></textarea>                                
                                <?php echo form_error('tmlDescription'); ?>
                            </div>
                        </div>   
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Image:</label>                                 
                            </div>
                            <div class="input">
                                 <?php if($action=="New"){?>
                                <input name="tmlImage" id="tmlImage" type="file" required/>
                                <?php }else{ ?> 
                                <input name="tmlImage" id="tmlImage" type="file"/> 
                                <?php }?>
                                <br/><br/><br/> Recommended image upload size: width:330 and height:100
                                <?php echo form_error('tmlImage'); ?>
                                
                                 <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?> 
                            </div>                            
                        </div>    
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_testimonials";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_testimonials/', 'Back'); ?>
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