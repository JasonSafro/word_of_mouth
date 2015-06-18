  
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=='new'?"Create New Deals":"Edit Deals");?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
            <?php echo validation_errors(); ?>
            <?php
            $attr = array('name' => 'frmNewDeal', 'id' => 'frmNewDeal', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open_multipart(ADMIN_FOLDER_NAME.'/manage_deals/'.($action=='new'?'add':"edit/$dealId"), $attr);
            ?>
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input">
                                <?php echo form_dropdown('dealBusinessId',__myBusinessDropdown(),set_value('dealBusinessId',$dealBusinessId),'id="dealBusinessId"');?>
                                <?php echo form_error('dealBusinessId'); ?>
                            </div>
                        </div>  
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Overview:</label>
                            </div>
                            <div class="input">
                                <textarea name="dealOverview" id="dealOverview" cols="60" rows="4"><?php echo set_value('dealOverview',$dealOverview);?></textarea>                                
                                <?php echo form_error('dealOverview');?>
                            </div>                            
                        </div> 
                         
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Description:</label>
                            </div>
                             <div class="input">
                                 <textarea name="dealDetails" id="dealDetails" cols="60" rows="4"><?php echo set_value('dealDetails',$dealDetails);?></textarea>                                
                                <?php echo form_error('dealDetails');?>
                            </div>
                        </div> 
                        
                           <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Value:</label>
                            </div>
                            <div class="input">
                                <input name="dealValue" id="dealValue" value="<?php echo set_value('dealValue',$dealValue);?>" type="text"  maxlength="10"  size="30"/>
                                <?php echo form_error('dealValue');?>
                            </div>                              
                        </div>                     
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Discount:</label>
                            </div>
                            <div class="input">
                                <input name="dealDiscounts" id="dealDiscounts" value="<?php echo set_value('dealDiscounts',$dealDiscounts);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('dealDiscounts');?>
                            </div>
                        </div> 
                                             
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Saving:</label>
                            </div>
                            <div class="input">
                                <input name="dealSavings" id="dealSavings" value="<?php echo set_value('dealSavings',$dealSavings);?>" type="text"  maxlength="10"  size="30"/>
                                <?php echo form_error('dealSavings');?>
                            </div>                              
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Final Price:</label>
                            </div>
                            <div class="input">
                                <input name="dealFinalPrice" id="dealFinalPrice" value="<?php echo set_value('dealFinalPrice',$dealFinalPrice);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('dealFinalPrice');?>
                            </div>                            
                        </div> 
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Limits:</label>
                            </div>
                             <div class="input">
                                 <textarea name="dealLimit" id="dealLimit" cols="60" rows="4"><?php echo set_value('dealLimit',$dealLimit);?></textarea>                                
                                <?php echo form_error('dealLimit');?>                                 
                            </div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Deal Expiration Date:</label>
                            </div>
                             <div class="input">
                                 <input name="dealExpirationDate" id="dealExpirationDate" value="<?php echo set_value('dealExpirationDate',$dealExpirationDate);?>" type="text"  maxlength="30"  size="50"/>
                                <?php echo form_error('dealExpirationDate');?>                                 
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Select Image:</label>
                            </div>
                             <div class="input">
                                 <input type="file" value="" id="dealImage" name="dealImage"/>
                                 <div style="float:left; clear:both; width: 100%; margin-top: 10px;">
                                  (Tip:Min Width:361,Min Height:214)   
                                <?php echo ($newImageError!=''?$newImageError:'');?>
                                 <?php if($dealImage!=""){?>
                                 <div style="float:left; clear:both; width: 100%; margin-top: 10px;">
                                 <img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$dealImage;?>" />
                                 </div>
                                 <?php }?>
                            </div>
                        </div> 
                        
                        
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="back" value="<?php echo ($action=='new'?"Save":"Save Changes");?>"/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_deals";?>'" /> 							
                        </div>
                     </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>                     
    </div>
    <!-- end content / right -->
</div>

<link href="<?php echo base_url();?>assets/datepicker/jquery-ui.css" rel="stylesheet" type="text/css"/>
<!--script src="<?php echo base_url();?>assets/datepicker/jquery.min.1.5.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script-->


<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        
        $("#dealExpirationDate").datepicker({		
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
        
        $("#dealExpirationDate").datepicker({		
            dateFormat: "yy-mm-dd",
            changeYear: true
        });
    });
</script> 