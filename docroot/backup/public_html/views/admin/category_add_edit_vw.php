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
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?>Category</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewCat', 'id' => 'frmNewCat', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/category/add_new/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/category/edit/'.$catId.'/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    echo form_open_multipart($form_url1, $attr1); 
                    ?>
                <input class="input" name="catId" type="hidden" value="<?php echo $catId;?>"/>               
                 <div class="form">
                    <div class="fields">

                        <div class="field">
                            <div class="label">
                                <label for="input-large">Category Name:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="catName" value="<?php echo set_value('catName',$catName);?>" size="50" id="catName"/>
                                <?php echo form_error('catName'); ?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Category Image:</label>                                 
                            </div>
                            <div class="input">
                                 <?php if($action=="New"){?>
                                <input name="catImageName" id="catImageName" type="file" required/> 
                                <?php }else{ ?> 
                                <input name="catImageName" id="catImageName" type="file"/> 
                                <?php }?>
                                <?php echo form_error('catImageName'); ?>
                                
                                 <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?> 
                            </div>                            
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Category Description:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="catDescription" value="<?php echo set_value('catDescription',$catDescription);?>" size="50" id="catDescription"/>
                                <?php echo form_error('catDescription'); ?>
                            </div>
                        </div>     
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/category";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/category/', 'Back'); ?>
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