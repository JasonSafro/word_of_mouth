<!-- content -->
<?php echo js_asset('smooth.form.js');?>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>New User</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewUser', 'id' => 'frmNewUser', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/user/add_new/';                   
                    echo form_open($form_url1, $attr1);
                    ?>                          
                 <div class="form">
                    <div class="fields">
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">User Name:</label>
                            </div>
                            <div class="input">
                                <input name="user_name" id="user_name"  value="<?php echo set_value('user_name'); ?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('user_name');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email:</label>
                            </div>
                            <div class="input">
                                <input name="user_email" id="user_email"  value="<?php echo set_value('user_email'); ?>" type="text" maxlength="60" size="50"/>
                                <?php echo form_error('user_email');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Password:</label>
                            </div>
                            <div class="input">
                                <input name="user_password" id="user_password"  value="<?php echo set_value('user_password'); ?>" type="password" maxlength="60" size="50"/>
                                <?php echo form_error('user_password');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Confirm Password:</label>
                            </div>
                            <div class="input">
                                <input name="cuser_password" id="cuser_password" value="<?php echo set_value('cuser_password'); ?>"  type="password" maxlength="60" size="50"/>
                                <?php echo form_error('cuser_password');?>
                            </div>
                        </div>
                        
                        
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/user";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/user/', 'Back'); ?>
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