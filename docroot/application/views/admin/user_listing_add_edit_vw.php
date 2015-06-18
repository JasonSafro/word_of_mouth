
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=='new'?"Create Bussiness listing":"Edit Bussiness Listing");?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
            <?php
            $attr = array('name' => 'frmaddlisting', 'id' => 'frmaddlisting', 'autocomplete' => 'off', 'method' => 'post');
			$sort_by='user_id';
			$sort_type='DESC';
			$offset=0;
            echo form_open_multipart(ADMIN_FOLDER_NAME.'/user/'.($action=='new'?"add_listing/$user_id/$sort_by/$sort_type/$offset":"edit_listing/$buss_id/$sort_by/$sort_type/$offset"), $attr);
            ?>
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Select Category *:</label>
                            </div>
                            <div class="input">
                                <?php 
                                    $xy='id="buss_category" class=""';
                                    echo form_dropdown('buss_category',_getCategoryList(),set_value('buss_category',$buss_category),$xy);
                                    echo form_error('buss_category');
                                ?>
                            </div>
                        </div> 
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Name *:</label>
                            </div>
                            <div class="input">
                                <input type="text" class="inp" name="buss_name" id="buss_name" value="<?php echo set_value('buss_name', $buss_name); ?>" maxlength="30"  size="50"/>
                                <input type="hidden" class="inp" name="user_id" id="user_id" value="<?php echo set_value('user_id', $user_id); ?>" maxlength="30"  size="50"/>
                                <?php echo form_error('buss_name');?>
                            </div>
                        </div> 

                         <div class="field">
                                <div class="label">
                                    <label for="input-large">Contact Name:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_cont_name" maxlength="30"  size="50" id="buss_cont_name" value="<?php echo set_value('buss_cont_name', $buss_cont_name); ?>"/> 
									<?php echo form_error('buss_cont_name'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Address*</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_address" id="buss_address" value="<?php echo set_value('buss_address', $buss_address); ?>" maxlength="30"  size="50"/>
                                <?php echo form_error('buss_address'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Address Add On:</label>
                                </div>
                                <div class="input">
                                  <input type="text" class="inp" name="buss_addr_addon" id="buss_addr_addon" value="<?php echo set_value('buss_addr_addon', $buss_addr_addon); ?>" maxlength="30"  size="50" />
                                 <?php echo form_error('buss_addr_addon'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">City *:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_city" id="buss_city" value="<?php echo set_value('buss_city', $buss_city); ?>" maxlength="30"  size="50" />
                                    <?php echo form_error('buss_city'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Zip Code*:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_zip_code" id="buss_zip_code" value="<?php echo set_value('buss_zip_code', $buss_zip_code); ?>" maxlength="30"  size="50" />
                                <?php echo form_error('buss_zip_code'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Phone *:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_phone" id="buss_phone" value="<?php echo set_value('buss_phone', $buss_phone); ?>" maxlength="30"  size="50" />
                                <?php echo form_error('buss_phone'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">FAX :</label>
                                </div>
                                <div class="input">
                                   <input type="text" class="inp" name="buss_fax" id="buss_fax" value="<?php echo set_value('buss_fax', $buss_fax); ?>" maxlength="30"  size="50" />
                                  <?php echo form_error('buss_fax'); ?>
                                </div>                            
                          </div> 
            			
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Web Address :</label>
                                </div>
                                <div class="input">
                              <input type="text" class="inp" name="buss_web_address" id="buss_web_address" value="<?php echo set_value('buss_web_address', $buss_web_address); ?>" maxlength="30"  size="50" />
                                <?php echo form_error('buss_web_address'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Email :</label>
                                </div>
                                <div class="input">
                            <input type="text" class="inp" name="buss_email" id="buss_email" value="<?php echo set_value('buss_email', $buss_email); ?>" maxlength="30"  size="50" />
                                <?php echo form_error('buss_email'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Business License Number :</label>
                                </div>
                                <div class="input">
                              <input type="text" class="inp" name="buss_license_num" id="buss_license_num" value="<?php echo set_value('buss_license_num', $buss_license_num); ?>" maxlength="30"  size="50" />
                                <?php echo form_error('buss_license_num'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload New Logo :</label>
                                </div>
                                <div class="input">
                              <input type="file" name="image_logo" id="image_logo"><br/>
                                <?php echo form_error('image_logo'); ?>
                                
                                 <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?> 
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload New Media Copy:</label>
                                </div>
                                <div class="input">
                            <input type="file" name="image_media[]" id="image_media" accept="image/*" multiple/><br/>
                                   <?php echo form_error('image_media[]'); ?>
                                   <div style="width:100%; float: left; height: auto;">
                                    
                                    <?php 
                                    if($buss_media_copy!=""){
                                        $businessImages=explode(',',$buss_media_copy);                                        
                                        foreach($businessImages as $key=>$val){
                                             echo '<div id="imageDivId_'.$key.'" style="width:100px; height:auto; margin-right:5px; border:1px solid #ccc; float:left; text-align: center;">';
                                             echo img(array('src'=>base_url().'Media_Copy/'.$val,'style'=>'float:left; width:100px; height:100px;'));
                                             echo anchor('','Remove Image',array('style'=>'float:left; width:100px; margin-top:5px;','onclick'=>"javascript: removeMediaImage(".$buss_id.",'imageDivId_".$key."','".$val."'); return false;"));
                                             echo '</div>';
                                        }
                                    }
                                    ?>
                                </div>
                                 <?php if ($error1 != '')
                                        echo '<br/><br/><span class="error">' . $error1.'</span>'; ?> 
                                </div>                            
                          </div> 
                          
                          
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Business Tag Line :</label>
                                </div>
                                <div class="input">
                              <input type="text" class="inp" name="buss_tag_line" id="buss_tag_line" value="<?php echo set_value('buss_tag_line', $buss_tag_line); ?>" maxlength="30"  size="50" />
                                <?php echo form_error('buss_tag_line'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Business Description :</label>
                                </div>
                                <div class="input">
                              <textarea name="buss_description" id="buss_description" class="txtarea" cols="60" rows="4"><?php echo set_value('buss_description', $buss_description); ?></textarea>
                                <?php echo form_error('buss_description'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Social Media Channels :</label>
                                </div>
                                <div class="input">
                              <img src="<?php echo USER_SIDE_IMAGES;?>h1.png"><input type="text" class="inp" name="buss_social_media_channel_1" id="buss_social_media_channel_1" value="<?php echo set_value('buss_social_media_channel_1', $buss_social_media_channel_1); ?>" maxlength="30"  size="50"/>
                               <br/> <img src="<?php echo USER_SIDE_IMAGES;?>h2.png"> <input type="text" class="inp" name="buss_social_media_channel_2" id="buss_social_media_channel_2" value="<?php echo set_value('buss_social_media_channel_2', $buss_social_media_channel_2); ?>" maxlength="30"  size="50"/>
                                 <br/><img src="<?php echo USER_SIDE_IMAGES;?>h3.png"><input type="text" class="inp" name="buss_social_media_channel_3" id="buss_social_media_channel_3" value="<?php echo set_value('buss_social_media_channel_3', $buss_social_media_channel_3); ?>" maxlength="30"  size="50"/>
                                 <br/><img src="<?php echo USER_SIDE_IMAGES;?>h4.png"><input type="text" class="inp" name="buss_social_media_channel_4" id="buss_social_media_channel_4" value="<?php echo set_value('buss_social_media_channel_4', $buss_social_media_channel_4); ?>" maxlength="30"  size="50"/>
                                <?php echo form_error('buss_email'); ?>
                                </div>                            
                          </div> 
                          
              <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="back" value="<?php echo ($action=='new'?"Save":"Save Changes");?>"/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onClick="javascript:history.back()" /> 							
                        </div>
                     </div>
                </div>
            </div>
            <?php echo form_close();?>
        </div>                     
    </div>
    <!-- end content / right -->
</div>

<script type="text/javascript">
function removeMediaImage(businessId,imageDivId,imageName)
{
    var siteUrl="<?php echo base_url();?>";
    if(confirm("Are you sure, you wants to remove this image?")){
        $.ajax({
            type: "post",
            data:{businessId: businessId,imageName:imageName},
            url: siteUrl+'admin/user/removeMediaImage',
            dataType: "html",
            success: 
                function (data) {
                    if(data=='success')
                    {
                        remove(imageDivId);
                    }    

                }
        });
    }
}

function remove(id)
{
    return (elem=document.getElementById(id)).parentNode.removeChild(elem);
}
</script>