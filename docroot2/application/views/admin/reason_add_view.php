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
                    $attr1 = array('name' => 'frmNewreason', 'id' => 'frmNewUser', 'autocomplete' => 'off', 'method' => 'post');
					
                    //$form_url1 = ADMIN_FOLDER_NAME.'/reasons/add_new/';                   
                    echo form_open($form_url1, $attr1);
                    ?>                          
                 <div class="form">
                    <div class="fields">
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Reason:</label>
                            </div>
                            <div class="input">
                            <?php if($action=='add'){ ?>
                                <input name="reason_name" id="reason_name"  value="<?php echo set_value('reason_name'); ?>" type="text"  maxlength="70" size="50"/>
                             <?php } else { ?>
                             <input name="reason_name" id="reason_name"  value="<?php echo $reason_info[0]['reason_name']; ?>" type="text"  maxlength="70" size="50"/>
                             <?php }?>
                             
                                <?php echo form_error('reason_name');?>
                            </div>
                        </div>
                        
                        
                        
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="<?php echo $btnName;?>" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onClick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/reasons";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/reasons/', 'Back'); ?>
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