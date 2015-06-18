<?php echo js_asset("jquery.maskedinput-1.3.js");?>
<script type="text/javascript">
  //store_phone phone_number
 
    jQuery(function($){
        $("#buss_phone").mask("999-999-9999");        
    }); 
    
    $(document).ready(function() {
        
            initialize();
            
            <?php //if(validation_errors()==""){?>
            
            /*
            //var tmp_cats="<?php echo implode(',',$buss_category);?>";
            //alert(tmp_cats);
            var selected_cats=tmp_cats.split(',');            
            $('#userCategory').val(selected_cats);
            alert(selected_cats);*/
            <?php //}?>
                
            $("#userCategory").change(function() {
                var flag=false;
               $('#userCategory :selected').each(function(i, selected){ 
                   //alert($(selected).val());
                  if($(selected).val()=='other')
                      flag=true;
                });

               if(flag==true)
                    $("#otherCatDiv").css('display','block');
                else
                    $("#otherCatDiv").css('display','none');  
                            
            });
            
                //when page load again with the error then it will works 
               var e = document.getElementById("userCategory");
                if(e!=''){                  
                   var flag=false;
                   $('#userCategory :selected').each(function(i, selected){ 
                      if($(selected).val()=='other')
                          flag=true;
                    });
                   if(flag==true)
                        $("#otherCatDiv").css('display','block');
                    else
                        $("#otherCatDiv").css('display','none'); 
                }
                
                //When Country Changes, Change State 
                    $('#buss_country').change(function(){
                           var e = document.getElementById("buss_country");
                           var strUser = e.options[e.selectedIndex].value;
                           print_state('buss_state',strUser);
                    });
                    
    $("#buss_description").keyup(function(){
        updateRemainingCharacters();
    });
            
            
    var updateRemainingCharacters = function () {
         var textObj= $('#buss_description');
         var limit = 255;
         var left = limit - textObj.val().length;
         if(left<0)
         {
             $('#remaining').html('Description text should not excide more than '+limit+' characters.');
             $('#remaining').attr('class','color-red');
         }   
         else
         {
             $('#remaining').text(left);
             $('#remaining').attr('class','color-green');
         }   
    };
    updateRemainingCharacters();      
            
    });
    
    
    
    function print_state(state_id, countryCode){
             $.ajax({
                    type: "GET",
                    url: '<?php echo base_url() ?>admin/manage_listing/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) { 
                                var option_str = document.getElementById(state_id);
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                //option_str.selectedIndex = 1;
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);                                   
                                });  
                                //$('#buss_state').parent().children(':not(#buss_state)').remove();
                                
                                
                    }
            });           
        }  
    
    function initialize(){
        
        
        $("#bussStatus-button").css('display','none');
        $("#bussStatus").css('display','block');
        $("#bussStatus").css('width','330px');
        
        $("#userCategory-button").css('display','none');
        $("#userCategory").css('display','block');
        $("#userCategory").css('width','330px');
        
        $("#buss_state-button").css('display','none');
        $("#buss_state").css('display','block');
        $("#buss_state").css('width','330px');
        
        $("#buss_country-button").css('display','none');
        $("#buss_country").css('display','block');
        $("#buss_country").css('width','330px');
    }
</script>
  
<!--style>
    select[multiple=multiple] option[selected=selected]{
        background-color: #316AC5;
        color: #fff;
    }
</style-->

<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5><?php echo ($action=='new'?"Create listing":"Edit Lising");?></h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
            
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <?php
            $attr = array('name' => 'frmaddlisting', 'id' => 'frmaddlisting', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open_multipart(ADMIN_FOLDER_NAME.'/manage_listing/'.($action=='new'?'add':"edit/$buss_id"), $attr);
            ?>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business Representative:</label>
                            </div>
                            <div class="input">
                                <input type="text" class="inp" name="businessRepresentative" id="businessRepresentative" value="<?php echo set_value('businessRepresentative', $businessRepresentative); ?>" maxlength="30"  size="50"/>
                                <?php echo form_error('businessRepresentative');?>
                            </div>
                        </div>
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Business Status:</label>
                                </div>
                                <div class="input">
                                    <?php 
                                    $attr='id="bussStatus" class=""';
                                    $statusArray=array('Pending'=>'Pending','Active'=>'Active','Inactive'=>'Inactive');
                                    echo form_dropdown('bussStatus',$statusArray,set_value('bussStatus',$bussStatus),$attr);
                                    echo form_error('bussStatus');
                                    ?>
                                </div>                            
                          </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Select Category *:</label>
                            </div>
                            <div class="input"> 
                                <!--select name="buss_category[]" id="userCategory"  multiple style="background:none; border:1px solid #ccc; width:38%; margin:2% 0;">
                                <?php 
                                $categoryList= _getCategoryList();                                
                                foreach($categoryList as $key=>$val){?>
                                    <option value="<?php echo $key;?>" <?php echo set_select('buss_category[]',$key); ?>><?php echo $val;?></option>
                                <?php }?>
                                    <option value="other" <?php echo set_select('buss_category[]', 'other'); ?>>Other category</option>
                            </select-->
                                <?php 
                                //if($action=='new') //multiple
                                    $xy='id="userCategory" style="background:none; border:1px solid #ccc; width:38%; margin:2% 0;"';
                                //else
                                 //   $xy='id="userCategory" class=""';
                                //echo '<pre>'; print_r($buss_category);
                                    $categoryList= _getCategoryList();
                                    $categoryList['other']="Other category";
                                    //$buss_category=array('22','23');
                                    echo form_multiselect('buss_category[]',$categoryList,set_value('buss_category[]',$buss_category),$xy);
                                    //echo form_multiselect('buss_category[]',$categoryList,$buss_category,$xy);
                                    
                                    echo form_error('buss_category[]');
                                ?>
                            </div>
                        </div> 
                        
                        <div class="field" id="otherCatDiv" style="display:none">
                            <div class="label">
                                <label for="input-large">Other Category:*</label>
                            </div>
                            <div class="input">
                                <input name="otherCategory" id="otherCategory" type="text" value="<?php echo set_value('otherCategory'); ?>"/>
                                <?php echo form_error('otherCategory');?>
                            </div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Name *:</label>
                            </div>
                            <div class="input">
                                <input type="text" class="inp" name="buss_name" id="buss_name" value="<?php echo set_value('buss_name', $buss_name); ?>" maxlength="125"  size="50"/>
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
                                    <input type="text" class="inp" name="buss_address" id="buss_address" value="<?php echo set_value('buss_address', $buss_address); ?>" size="50"/>
                                <?php echo form_error('buss_address'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Address Add On:</label>
                                </div>
                                <div class="input">
                                  <input type="text" class="inp" name="buss_addr_addon" id="buss_addr_addon" value="<?php echo set_value('buss_addr_addon', $buss_addr_addon); ?>" size="50" />
                                 <?php echo form_error('buss_addr_addon'); ?>
                                </div>                            
                          </div> 
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Country*:</label>
                                </div>
                                <div class="input">
                                   <?php 
                                    $st='id="buss_country"';
                                    echo form_dropdown('buss_country', _getCountryList(),set_value('buss_country',$buss_country),$st);
                                    $selectedCountry=set_value('buss_country',$buss_country);
                                  ?>
                                 <?php echo form_error('buss_country'); ?>
                                </div>                            
                          </div> 
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">State*:</label>
                                </div>
                                <div class="input">
                                  <?php 
                                    $st='id="buss_state"';
                                    echo form_dropdown('buss_state', _getStateList($selectedCountry),set_value('buss_state',$buss_state),$st);
                                  ?>
                                 <?php echo form_error('buss_state'); ?>
                                </div>                            
                          </div> 
                         
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">City *:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_city" id="buss_city" value="<?php echo set_value('buss_city', $buss_city); ?>" maxlength="50"  size="50" />
                                    <?php echo form_error('buss_city'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Zip Code*:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_zip_code" id="buss_zip_code" value="<?php echo set_value('buss_zip_code', $buss_zip_code); ?>" maxlength="10"  size="50" />
                                <?php echo form_error('buss_zip_code'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Phone *:</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="inp" name="buss_phone" id="buss_phone" value="<?php echo set_value('buss_phone', $buss_phone); ?>" size="50" />
                                <?php echo form_error('buss_phone'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">FAX :</label>
                                </div>
                                <div class="input">
                                   <input type="text" class="inp" name="buss_fax" id="buss_fax" value="<?php echo set_value('buss_fax', $buss_fax); ?>" maxlength="15"  size="50" />
                                  <?php echo form_error('buss_fax'); ?>
                                </div>                            
                          </div> 
            			
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Web Address :</label>
                                </div>
                                <div class="input">
                              <input type="text" class="inp" name="buss_web_address" id="buss_web_address" value="<?php echo set_value('buss_web_address', $buss_web_address); ?>" size="50" />
                                <?php echo form_error('buss_web_address'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Email :</label>
                                </div>
                                <div class="input">
                            <input type="text" class="inp" name="buss_email" id="buss_email" value="<?php echo set_value('buss_email', $buss_email); ?>" size="50" />
                                <?php echo form_error('buss_email'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Business License Number :</label>
                                </div>
                                <div class="input">
                              <input type="text" class="inp" name="buss_license_num" id="buss_license_num" value="<?php echo set_value('buss_license_num', $buss_license_num); ?>" size="50" />
                                <?php echo form_error('buss_license_num'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload New Logo :</label>
                                </div>
                                <div class="input">
                              <input type="file" name="image_logo" id="image_logo"><br/>
                              <div style="width:100%; margin-bottom: 5px; clear: both;"></div>
                              Size : up-to 3mb, Dimension : up-to 1024 X 768 with extention:jpg,png <br/>
                                <?php echo form_error('image_logo'); ?>
                                
                                 <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?> 
                              
                              <div style="width:100%; float: left; height: auto; margin-top: 5px;">
                                    <?php 
                                    if($buss_logo!=""){
                                             echo '<div style="width:100px; height:auto; margin-right:5px; border:1px solid #ccc; float:left; text-align: center;">';
                                             echo img(array('src'=>base_url().'LOGO/'.$buss_logo,'style'=>'float:left; width:100px; height:100px;'));
                                             echo '</div>';
                                    }
                                    ?>
                                </div>
                              
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload New Media Copy:</label>
                                </div>
                                <div class="input">
                            <input type="file" name="image_media[]" id="image_media" accept="image/*" multiple/><br/>
                            <div style="width:100%; margin-bottom: 5px; clear: both;"></div>
                              Size : up-to 3mb, Dimension : up-to 1024 X 768 with extention:jpg,png <br/>
                                   <?php echo form_error('image_media[]'); ?>
                              <?php if ($error1 != '')
                                        echo '<span class="error">' . $error1.'</span><br/>'; ?> 
                                   <div style="width:100%; float: left; height: auto; margin-top: 5px;">
                                    
                                    <?php 
                                    if($buss_media_copy!=""){
                                        $businessImages=explode(',',$buss_media_copy);                                        
                                        foreach($businessImages as $key=>$val){
                                            if($val!=""){
                                             echo '<div id="imageDivId_'.$key.'" style="width:100px; height:auto; margin-right:5px; border:1px solid #ccc; float:left; text-align: center;">';
                                             echo img(array('src'=>base_url().'Media_Copy/'.$val,'style'=>'float:left; width:100px; height:100px;'));
                                             echo anchor('','Remove Image',array('style'=>'float:left; width:100px; margin-top:5px;','onclick'=>"javascript: removeMediaImage(".$buss_id.",'imageDivId_".$key."','".$val."'); return false;"));
                                             echo '</div>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                 
                                </div>                            
                          </div> 
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload Business License:</label>
                                </div>
                                <div class="input">
                                    <input type="file" name="buss_license_docs[]" id="buss_license_docs" multiple/><br/>
                                   <?php echo form_error('buss_license_docs[]'); ?>
                                    <div style="width:100%; float: left; height: auto;">

                                        <?php //echo $buss_license_docs;
                                        if($buss_license_docs!=""){
                                            $businessDocs=explode(',',$buss_license_docs);                                        
                                            foreach($businessDocs as $key=>$val){
                                                if(trim($val)!=""){
                                                echo '<br/><p id="docsDivId_'.$key.'">'.$val.' '.
                                                    anchor('','Remove',array('onclick'=>"javascript: removeDoc(".$buss_id.",'docsDivId_".$key."','".$val."'); return false;")).' | '.
                                                    anchor('admin/manage_listing/download_doc/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Doc')).
                                                    '</p>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>                    
                              </div> 
                        </div>  
                          
                        <!--  <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload Video:</label>
                                </div>
                                <div class="input">
                                    <input type="file" name="buss_video[]" id="buss_video"  accept="video/*"/><br/>
                                    <?php echo form_error('buss_video[]'); ?>
                                    <div style="width:100%; float: left; height: auto;">

                                        <?php //echo $buss_license_docs;
                                        if($buss_video!=""){
                                            $businessVideos=explode(',',$buss_video);                                        
                                            foreach($businessVideos as $key=>$val){
                                                if(trim($val)!=""){
                                                echo '<br/><p id="videoDivId_'.$key.'">'.$val.' '.
                                                    anchor('','Remove',array('onclick'=>"javascript: removeVideo(".$buss_id.",'videoDivId_".$key."','".$val."'); return false;")).' | '.
                                                    anchor('admin/manage_listing/download_video/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Video')).
                                                    '</p>';
                                                }
                                            }
                                        }
                                        ?>
                                    </div>                   
                              </div> 
                        </div> -->
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Business Tag Line :</label>
                                </div>
                                <div class="input">
                              <input type="text" class="inp" name="buss_tag_line" id="buss_tag_line" value="<?php echo set_value('buss_tag_line', $buss_tag_line); ?>" size="50" />
                                <?php echo form_error('buss_tag_line'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Business Description:</label>
                                </div>
                                <div class="input">
                                    Note: Only 255 characters allowed. <b class="color-red">(Remaining Characters: <span id="remaining"></span>)</b><br/>
                              <textarea name="buss_description" id="buss_description" class="txtarea" cols="60" rows="4"><?php echo set_value('buss_description', $buss_description); ?></textarea>
                                <?php echo form_error('buss_description'); ?>
                                </div>                            
                          </div> 
                          
                          <div class="field">
                                <div class="label">
                                    <label for="input-large">Social Media Channels :</label>
                                </div>
                                <div class="input">
                                <img src="<?php echo USER_SIDE_IMAGES;?>h1.png">
                                <input type="text" class="inp" name="buss_social_media_channel_1" id="buss_social_media_channel_1" value="<?php echo set_value('buss_social_media_channel_1', $buss_social_media_channel_1); ?>" size="50"/>
                                <?php echo form_error('buss_social_media_channel_1'); ?>
                                
                                <br/><img src="<?php echo USER_SIDE_IMAGES;?>h2.png">
                                <input type="text" class="inp" name="buss_social_media_channel_2" id="buss_social_media_channel_2" value="<?php echo set_value('buss_social_media_channel_2', $buss_social_media_channel_2); ?>" size="50"/>
                                <?php echo form_error('buss_social_media_channel_2'); ?>
                                
                                <br/><img src="<?php echo USER_SIDE_IMAGES;?>h3.png">
                                <input type="text" class="inp" name="buss_social_media_channel_3" id="buss_social_media_channel_3" value="<?php echo set_value('buss_social_media_channel_3', $buss_social_media_channel_3); ?>" size="50"/>
                                <?php echo form_error('buss_social_media_channel_3'); ?>
                                
                                <br/><img src="<?php echo USER_SIDE_IMAGES;?>h4.png">
                                <input type="text" class="inp" name="buss_social_media_channel_4" id="buss_social_media_channel_4" value="<?php echo set_value('buss_social_media_channel_4', $buss_social_media_channel_4); ?>" size="50"/>
                                <?php echo form_error('buss_social_media_channel_4'); ?>
                                </div>                            
                          </div> 
                        
                        
                          
                        <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="back" value="<?php echo ($action=='new'?"Save":"Save Changes");?>"/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onClick="javascript:history.back()" /> 							
                        </div>
                        <?php echo form_close();?>
                        
                        <div style="width:100%; float: left; margin-top: 10px; clear: both;"></div>
                            
                        <?php 
                        if($action=='edit'){//user_plan?>
                        <div style="width:100%; border-bottom: 1px #ccc solid; clear: both; margin-bottom: 5px;"></div>
                        <?php echo form_open_multipart(ADMIN_FOLDER_NAME.'/manage_listing/ajaxVideoUpload/'.$buss_id, array('id'=>'frmVideo','name'=>'frmVideo'));?>
                        
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload Video:</label>
                                </div>
                                <div class="input">
                                    <input type="file"  name="ajax_buss_video" id="ajax_buss_video"  accept="video/*"/><br/>
                                    <div style="width:100%; float: left; margin-top: 5px; clear: both;">
                                    <div class="progress" id="progress1">
                                    <div class="bar" id="bar1"></div >
                                    <div class="percent" id="percent1">0%</div >
                                    </div>
                                    <div id="status1"></div>
                                    
                                    <div style="width:100%; float: left; height: auto;">

                                        <?php //echo $buss_license_docs;
                                        $numOfVideos=0;
                                        if($buss_video!=""){
                                            $businessVideos=explode(',',$buss_video);                                        
                                            foreach($businessVideos as $key=>$val){
                                                if(trim($val)!=""){
                                                ++$numOfVideos;
                                                echo '<br/><p id="videoDivId_'.$key.'">'.$val.' '.
                                                    anchor('','Remove',array('onclick'=>"javascript: removeVideo(".$buss_id.",'videoDivId_".$key."','".$val."'); return false;")).' | '.
                                                    anchor('admin/manage_listing/download_video/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Video')).
                                                    '</p>';
                                                }
                                            }
                                        }
                                        ?>
                                        <input type="hidden" id="numOfVideos" value="<?php echo $numOfVideos;?>"/>
                                    </div>                   
                              </div> 
                        </div> 
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <div style="float:left; width:81%; margin-left: 19%;">
                        <input type="submit" class="ui-button custom-default-button" name="back" value="Upload Video"/>
                        </div>
                         <?php echo form_close();?>
                       <?php }?> 
                        
                        
                        
                     </div>
                </div>
            </div>
            
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
            url: siteUrl+'admin/manage_listing/removeMediaImage',
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

function removeDoc(businessId,docsDivId,docName)
{
    var siteUrl="<?php echo base_url();?>";
    if(confirm("Are you sure, you wants to remove this document?")){
        $.ajax({
            type: "post",
            data:{businessId: businessId,docName:docName},
            url: siteUrl+'admin/manage_listing/removeBusinessDoc',
            dataType: "html",
            success: 
                function (data) {
                    if(data=='success')
                    {
                        remove(docsDivId);
                    }    

                }
        });
    }
}

function removeVideo(businessId,videoDivId,videoName)
{
    var siteUrl="<?php echo base_url();?>";
    if(confirm("Are you sure, you wants to remove this video?")){
        $.ajax({
            type: "post",
            data:{businessId: businessId,videoName:videoName},
            url: siteUrl+'admin/manage_listing/removeVideo',
            dataType: "html",
            success: 
                function (data) {
                    if(data=='success')
                    {
                        var no=document.getElementById("numOfVideos").value;
                        document.getElementById("numOfVideos").value = no-1;
                        remove(videoDivId);
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

<?php echo js_asset("custom_jequery_form.js");?>
<script>
(function() {

    //upload first video
    var bar1 = $('#bar1');
    var percent1 = $('#percent1');
    var status1 = $('#status1');
    $('#progress1').css('display','none');
    $('#frmVideo').ajaxForm({       
        beforeSubmit:checkBeforeUpload1,
        beforeSend: function() {
            $('#progress1').css('display','block');
            status1.empty();            
            var percentVal = '0%';
            bar1.width(percentVal);
            percent1.html(percentVal);            
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar1.width(percentVal)
            percent1.html(percentVal);
        },
        complete: function(xhr) {   
            var text=xhr.responseText;
            var res=text.split("=");
            if(res[0]=="success"){
                status1.html('<span class="ajaxSuccess">'+res[1]+'</span>');
                bar1.width("100%");
                percent1.html("100%");
                location.reload();
            }    
            else{
                $('#progress1').css('display','none');
                status1.html('<span class="ajaxError">'+res[1]+'</span>');
                bar1.width("0%");
                percent1.html("0%");                
            }
            
        }
    });
  })();  
    function checkBeforeUpload1(){
        //3alert('here'); return false;
        if(document.getElementById("numOfVideos").value>="2")//
        {
            $('#status1').html('<span class="ajaxError">Sorry! You can not upload more than two videos.</span>');            
            return false;
        }    
        
        if(document.getElementById("ajax_buss_video").value=="")
        {
            $('#status1').html('<span class="ajaxError">Please select file to upload.</span>');            
            return false;
        }    
        else if(document.getElementById("ajax_buss_video").files[0].size > 88589934592)//8mb
        {
            $('#status1').html('<span class="ajaxError">File is too big. YOu can upload video up to 8MB</span>');            
            return false;
        }
        return true;
    }
</script>