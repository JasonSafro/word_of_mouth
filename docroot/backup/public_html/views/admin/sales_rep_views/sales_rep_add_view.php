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
                    $attr1 = array('name' => 'frmSalesRep', 'id' => 'frmSalesRep', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_sales_rep/add_new/';                   
                    echo form_open($form_url1, $attr1);
                    ?>                          
                 <div class="form">
                    <div class="fields">
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Employ Number:</label>
                            </div>
                            <div class="input">
                                <input name="employNo" id="employNo" value="<?php echo set_value('employNo',$employNo);?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('employNo');?>
                            </div>
                        </div>  
                        
                           <div class="field">
                            <div class="label">
                                <label for="input-large">Full Name:</label>
                            </div>
                            <div class="input">
                                <input name="adm_full_name" id="adm_full_name"  value="<?php echo set_value('adm_full_name'); ?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('adm_full_name');?>
                            </div>
                        </div>
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">User Name:</label>
                            </div>
                            <div class="input">
                                <input name="sal_username" id="sal_username"  value="<?php echo set_value('sal_username'); ?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('sal_username');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email:</label>
                            </div>
                            <div class="input">
                                <input name="sal_email" id="sal_email"  value="<?php echo set_value('sal_email'); ?>" type="text" maxlength="60" size="50"/>
                                <?php echo form_error('sal_email');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Password:</label>
                            </div>
                            <div class="input">
                                <input name="sal_password" id="sal_password"  value="<?php echo set_value('sal_password'); ?>" type="password" maxlength="60" size="50"/>
                                <?php echo form_error('sal_password');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Confirm Password:</label>
                            </div>
                            <div class="input">
                                <input name="csal_password" id="csal_password" value="<?php echo set_value('csal_password'); ?>"  type="password" maxlength="60" size="50"/>
                                <?php echo form_error('csal_password');?>
                            </div>
                        </div>
                        
                          <div class="field">
                            <div class="label">
                                <label for="input-large">Contact Number:</label>
                            </div>
                            <div class="input">
                                <input name="sal_contactno" id="sal_contactno" value="<?php echo set_value('sal_contactno');?>" type="text" maxlength="10" size="50"/>
                                <?php echo form_error('sal_contactno');?>
                            </div>
                        </div>  
                        
                        
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_sales_rep";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_sales_rep/', 'Back'); ?>
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