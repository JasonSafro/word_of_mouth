<!-- content -->
<?php echo js_asset('smooth.form.js');?>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php if($action == 'add'){ ?>Add <?php }else { ?>Edit <?php } ?>Promo code</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    <?php 
                    $attr1 = array('name' => 'frmNewUser', 'id' => 'frmNewUser', 'autocomplete' => 'off', 'method' => 'post');
                    if($action == 'add'){ 
					 $form_url1 = ADMIN_FOLDER_NAME.'/manage_promocodes/addPromocodes/';  
                    echo form_open($form_url1, $attr1);
					}else{
						$form_url2 = ADMIN_FOLDER_NAME.'/manage_promocodes/editPromocodes/'.$pc_id; 
					 echo form_open($form_url2, $attr1);
					 }
                    ?>                          
                 <div class="form">
                    <div class="fields">
                        
                         <!--div class="field">
                            <div class="label">
                                <label for="input-large">Plan Name:</label>
                            </div>
                            <div class="input">
                                 <select name="plan_name" id="plan_name">
									<option value="" >Select</option> 
									<?php if(!empty($plans)):
									foreach($plans as $plan):
									?>
									 <option value="<?php echo $plan['subs_plan_id']; ?>" <?php if($plan_name == $plan['subs_plan_id']){?> selected <?php } ?>><?php echo $plan['subs_plan_name']; ?></option> 
									<?php 
									endforeach; 
									endif; ?>	
								 </select>
                                <?php echo form_error('plan_name');?>
                            </div>
                        </div-->
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Plan Type:</label>
                            </div>
                            <div class="input">
                                 <select name="plan_type" id="plan_type">
								 <option value="" >Select</option> 
								 <?php if(!empty($plan_types)):
									foreach($plan_types as $plant):
									$str = $plant['subs_sub_plan_id']."_".$plant['subs_plan_id'];
									?>
									 <option value="<?php echo $plant['subs_sub_plan_id']."_".$plant['subs_plan_id']; ?>" <?php if($plan_type == $str){?> selected <?php } ?>><?php echo $plant['subs_plan_name']." ".$plant['subs_sub_plan_name']; ?></option> 
									<?php 
									endforeach; 
									endif; ?>	
								 </select>
                                <?php echo form_error('plan_type');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Discount:</label>
                            </div>
                            <div class="input">
                                $<input name="discount" id="discount"  value="<?php echo set_value('discount',$discount); ?>" type="text" maxlength="60" size="50"/>
                                <?php echo form_error('discount');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Promo Code:</label>
                            </div>
                            <div class="input">
                                <input name="promo_code" id="promo_code" value="<?php echo set_value('promo_code',$promo_code); ?>"  type="text" maxlength="60" size="50"/>
								<?php if($action == 'edit'): ?>
								<input name="promo_code_hidden" id="promo_code_hidden" value="<?php echo set_value('promo_code',$promo_code); ?>"  type="hidden" maxlength="60" size="50"/>
								<?php endif; ?>
                                <?php echo form_error('promo_code');?>
                            </div>
                        </div>
                        
                        <div style="clear:both;"></div>
                        
                        <div class="buttons"> 
                            <input name="submit" value="Submit" type="submit" />
							
                            <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_promocodes";?>'" /> 							
                            <!--div class="pagination">
                            <!--div class="results">
                                <span>
                            <?php echo anchor(ADMIN_FOLDER_NAME.'/manage_promocodes/', 'Back'); ?>
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