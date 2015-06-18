<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Business Detailed View </h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                     
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Business Representative:</label>
                            </div>
                            <div class="input"><?php if($info['businessRepresentative']=='')echo "--";else echo $info['businessRepresentative'];?></div>
                        </div> 
                        
                       <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input"><?php if($info['buss_name']=='')echo "--";else echo anchor('home/business_details/'.$info['buss_id'],$info['buss_name'],array('title'=>'View business details','target'=>'_blanck'));?></div>
                        </div>  
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business Category:</label>
                            </div>
                            <?php $cats=_getBusinessCategoryNameString($info['buss_id']);?>
                            <div class="input"><?php echo ($cats!=""?$cats:"--")?></div>
                        </div> 
                        
                       <div class="field">                           
                            <div class="label">
                                <label for="input-large">Contact Name:</label>
                            </div>
                            <div class="input"><?php if($info['buss_cont_name']=='')echo "--";else echo $info['buss_cont_name'];?></div>
                        </div>    
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Address:</label>
                            </div>
                            <div class="input"><?php if($info['buss_address']=='')echo "--";else echo $info['buss_address'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Address add On:</label>
                            </div>
                            <div class="input"><?php if($info['buss_addr_addon']=='')echo "--";else echo $info['buss_addr_addon'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Country:</label>
                            </div>
                            <div class="input"><?php if($info['countryName']=='')echo "--";else echo $info['countryName'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">State:</label>
                            </div>
                            <div class="input"><?php if($info['stateName']=='')echo "--";else echo $info['stateName'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">City:</label>
                            </div>
                            <div class="input"><?php if($info['buss_city']=='')echo "--";else echo $info['buss_city'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Zip code:</label>
                            </div>
                            <div class="input"><?php if($info['buss_zip_code']=='')echo "--";else echo $info['buss_zip_code'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Phone:</label>
                            </div>
                            <div class="input"><?php if($info['buss_phone']=='')echo "--";else echo $info['buss_phone'];?></div>
                        </div>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Fax:</label>
                            </div>
                            <div class="input"><?php if($info['buss_fax']=='')echo "--";else echo $info['buss_fax'];?></div>
                        </div>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Web Address:</label>
                            </div>
                            <div class="input"><?php if($info['buss_web_address']=='')echo "--";else echo $info['buss_web_address'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Contact Email Address:</label>
                            </div>
                            <div class="input"><?php if($info['buss_email']=='')echo "--";else echo $info['buss_email'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business License Number:</label>
                            </div>
                            <div class="input"><?php if($info['buss_license_num']=='')echo "--";else echo $info['buss_license_num'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">LOGO:</label>
                            </div>
                            <div class="input"><?php echo img(array('src'=>base_url().'LOGO/'.$info['buss_logo'],'style'=>'float:left; width:100px; height:100px;'));?></div>
                        </div>
                        <?php $buss_id=$info['buss_id'];?>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Media Copy:</label>
                            </div>
                            <div class="input"><div style="width:100%; float: left; height: auto;">
                                    
                                    <?php 
                                    $buss_media_copy=$info['buss_media_copy'];
                                    if($buss_media_copy!=""){
                                        $businessImages=explode(',',$buss_media_copy);                                        
                                        foreach($businessImages as $key=>$val){
                                            if($val!=""){
                                                 echo '<div id="imageDivId_'.$key.'" style="width:100px; height:auto; margin-right:5px; border:1px solid #ccc; float:left; text-align: center;">';
                                                 echo img(array('src'=>base_url().'Media_Copy/'.$val,'style'=>'float:left; width:100px; height:100px;'));                                            
                                                 echo '</div>';
                                            }
                                        }
                                    }
                                    else
                                    {
                                            echo "<br />  ";
                                    }
                                    ?>
                                </div></div>
                        </div>
                        
                        
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload Business License:</label>
                                </div>
                                <div class="input">                                                                       
                                    <div style="width:100%; float: left; height: auto;">

                                        <?php //echo $buss_license_docs;
                                        $buss_license_docs=$info['buss_license_docs'];
                                        if($buss_license_docs!=""){
                                            $businessDocs=explode(',',$buss_license_docs);                                        
                                            foreach($businessDocs as $key=>$val){
                                                if(trim($val)!=""){
                                                echo '<br/><p id="docsDivId_'.$key.'">'.$val.' '.
                                                    anchor('','Remove',array('onclick'=>"javascript: removeDoc(".$buss_id.",'docsDivId_".$key."','".$val."'); return false;")).' | '.
                                                    anchor('dashboard/business_listing/download_doc/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Doc')).
                                                    '</p>';
                                                }
                                            }
                                        }else{
                                            echo '--';
                                        }
                                        ?>
                                    </div>                    
                              </div> 
                        </div> 
                        
                        <div class="field">
                                <div class="label">
                                    <label for="input-large">Upload Video:</label>
                                </div>
                                <div class="input">                                    
                                    <div style="width:100%; float: left; height: auto;">

                                        <?php //echo $buss_license_docs;
                                        $buss_video=$info['buss_video'];
                                        if($buss_video!=""){
                                            $businessVideos=explode(',',$buss_video);                                        
                                            foreach($businessVideos as $key=>$val){
                                                if(trim($val)!=""){
                                                echo '<br/><p id="videoDivId_'.$key.'">'.$val.' '.
                                                    anchor('','Remove',array('onclick'=>"javascript: removeVideo(".$buss_id.",'videoDivId_".$key."','".$val."'); return false;")).' | '.
                                                    anchor('dashboard/business_listing/download_video/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Video')).
                                                    '</p>';
                                                }
                                            }
                                        }else{
                                            echo '--';
                                        }
                                        ?>
                                    </div>                   
                              </div> 
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large"><img src="<?php echo USER_SIDE_IMAGES;?>social.png" style="margin-top: 4px;"> &nbsp;Social Media Channels</label>
                            </div>
                            <div class="input"><table width="100%"> 
                            <tr><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png">&nbsp;<?php echo $info['buss_social_media_channel_1'];?></td><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png">&nbsp;<?php echo $info['buss_social_media_channel_2'];?></td></tr>  
                              <tr><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png">&nbsp;<?php echo $info['buss_social_media_channel_3'];?></td><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png">&nbsp;<?php echo $info['buss_social_media_channel_4'];?></td></tr>
                         </table></div>
                        </div>
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onClick="javascript:history.back()" /> 
                         					
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