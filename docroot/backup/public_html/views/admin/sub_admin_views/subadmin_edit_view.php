<!-- content -->
<?php echo js_asset('smooth.form.js');?>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?> User</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmSubAdmin', 'id' => 'frmSubAdmin', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/user/add_new/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    if($action=='Edit')
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_subadmin/edit/'.$adm_id.'/'.$sort_by.'/'.$sort_type.'/'.$offset;
                    echo form_open($form_url1, $attr1);
                    ?>
                <input class="input" name="adm_id" type="hidden" value="<?php echo $adm_id;?>"/>               
                 <div class="form">
                    <div class="fields">
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Full Name:</label>
                            </div>
                            <div class="input">
                                <input name="adm_full_name" id="adm_full_name" value="<?php echo set_value('adm_full_name',$adm_full_name);?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('adm_full_name');?>
                            </div>
                        </div>     
                        
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">User Name:</label>
                            </div>
                            <div class="input">
                                <input name="adm_username" id="adm_username" value="<?php echo set_value('adm_username',$adm_username);?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('adm_username');?>
                            </div>
                        </div>     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email:</label>
                            </div>
                            <div class="input">
                                <input name="adm_email" id="adm_email" value="<?php echo set_value('adm_email',$adm_email);?>" type="text" maxlength="60" size="50"/>
                                <?php echo form_error('adm_email');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Password:</label>
                            </div>
                            <div class="input">
                                <input name="adm_password" id="adm_password" value="<?php echo set_value('adm_password',$adm_password);?>" type="password" maxlength="60" size="50"/>
                                <?php echo form_error('adm_password');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Contact Number:</label>
                            </div>
                            <div class="input">
                                <input name="adm_contactno" id="adm_contactno" value="<?php echo set_value('adm_contactno',$adm_contactno);?>" type="text" maxlength="10" size="50"/>
                                <?php echo form_error('adm_contactno');?>
                            </div>
                        </div>  
                        <div style="clear:both;"></div>
                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_subadmin";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_subadmin/', 'Back'); ?>
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