<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Contact us address setting</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr = array('name' => 'frmUpdateContactus', 'id' => 'frmUpdateContactus', 'autocomplete' => 'off', 'method' => 'post');
                    $form_url = ADMIN_FOLDER_NAME.'/setting';
                    echo form_open($form_url, $attr);
                    ?>
                <input class="input" name="settingId" type="hidden" value="<?php echo $setting['settingId'];?>"/>               
                 <div class="form">
                    <div class="fields">
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Address:</label>
                            </div>
                            <div class="input">
                                <textarea name="contactusAddress" id="contactusAddress" rows="4" cols="30"><?php echo set_value('contactusAddress',$setting['contactusAddress']);?></textarea>                                
                                <?php echo form_error('contactusAddress'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Phone Number:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="contactusPhoneNumber" value="<?php echo set_value('contactusPhoneNumber',$setting['contactusPhoneNumber']);?>" size="40" id="contactusPhoneNumber"/>
                                <?php echo form_error('contactusPhoneNumber'); ?>
                            </div>
                        </div>
                        
                          <div class="field">
                            <div class="label">
                                <label for="input-large">FAX Number:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="contactusFAXNumber" value="<?php echo set_value('contactusFAXNumber',$setting['contactusFAXNumber']);?>" size="40" id="contactusFAXNumber"/>
                                <?php echo form_error('contactusFAXNumber'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email Address:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="contactusEmailAddress" value="<?php echo set_value('contactusEmailAddress',$setting['contactusEmailAddress']);?>" size="40" id="contactusEmailAddress"/>
                                <?php echo form_error('contactusEmailAddress'); ?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Header Footer Phone:</label>
                            </div>
                            <div class="input">
                                <input type="text" name="headerFooterPhoneNo" value="<?php echo set_value('headerFooterPhoneNo',$setting['headerFooterPhoneNo']);?>" size="40" id="headerFooterPhoneNo"/>
                                <?php echo form_error('headerFooterPhoneNo'); ?>
                            </div>
                        </div>
			
                        <div style="clear:both;"></div>
                                               

                        <div class="buttons"> 
                            <input name="submit" value="Save Setting" type="submit" />
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