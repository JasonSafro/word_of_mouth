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
                    $form_url1 = ADMIN_FOLDER_NAME.'/subscription_plans/edit/'.$subs_plan_id;
                    echo form_open($form_url1, $attr1);
                    ?>
                <input class="input" name="subs_plan_id" type="hidden" value="<?php echo $subs_plan_id;?>"/>               
                 <div class="form">
                    <div class="fields">
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Plan Name:</label>
                            </div>
                            <div class="input">
                                <input name="subs_plan_name" id="subs_plan_name" value="<?php echo set_value('subs_plan_name',$subs_plan_name);?>" type="text"  maxlength="30" size="50"/>
                                <?php echo form_error('subs_plan_name');?>
                            </div>
                        </div>                           
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/subscription_plans";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/subscription_plans/', 'Back'); ?>
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