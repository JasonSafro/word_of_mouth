<!-- content -->
<?php echo js_asset('smooth.form.js');?>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=="New" ? 'New' : 'Edit'); ?> Plan</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php     
                     $attr1 = array('name' => 'frmEditPlan', 'id' => 'frmEditPlan', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url1 = ADMIN_FOLDER_NAME.'/manage_services/edit/'.$service_id;
                    echo form_open($form_url1, $attr1);
                    ?>
                <input class="input" name="service_id" type="hidden" value="<?php echo $service_id;?>"/>               
                 <div class="form">
                    <div class="fields">
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Service Name:</label>
                            </div>
                            <div class="input">
                                <input name="service_name" id="service_name" value="<?php echo set_value('service_name',$service_name);?>" type="text"  maxlength="100" size="100"/>
                                <?php echo form_error('service_name');?>
                            </div>
                        </div>  
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large"><?php echo $basic_plan_name;?>&nbsp;Plan Limit:</label>
                            </div>
                            <div class="input">
                               <input name="service_basic_limit" id="service_basic_limit" value="<?php echo set_value('service_basic_limit',$service_basic_limit);?>" type="text"  maxlength="100" size="100"/>
                               &nbsp;<span>(0 - means Unlimited)</span>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large"><?php echo $premium_plan_name;?>&nbsp;Plan Limit:</label>
                            </div>
                            <div class="input">
                                <input name="service_premium_limit" id="service_premium_limit" value="<?php echo set_value('service_premium_limit',$service_premium_limit);?>" type="text"  maxlength="100" size="100"/>
                              &nbsp;<span>(0 - means Unlimited)</span>
                            </div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Service Description:</label>
                            </div>
                            <div class="input">
                                <input name="service_description" id="service_description" value="<?php echo set_value('service_description',$service_description);?>" type="text"  maxlength="100" size="100"/>
                                <?php echo form_error('service_description');?>
                            </div>
                        </div> 
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_services";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_services/', 'Back'); ?>
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