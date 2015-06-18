<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        /*====================== Exemple basique ======================*/
        $("#parent1").wslide({
            width: 450,
            height: 200,
            duration: 2000,
            effect: 'easeOutBounce'
        });
        /*====================== Exemple 2 ======================*/
        $("#parent2").wslide({
            width: '100%',
            height: 284,
            //pos: 1,
            //horiz: true,
            autoplay: true ,
            fade: true,
            //delay: 2000,
            duration: 2000, 
            //type: 'sequence',
            //duration: 1000,
            //effect: 'easeOutElastic'
					
        });			
        /*====================== Exemple 3 ======================*/
        $("#parent3").wslide({
            width: 250,
            height: 300,
            col: 4,
            autolink: 'menu3',
            duration: 4000,
            effect: 'easeOutExpo'
        });
    });
</script>
<style>
    .t-top1 {
    background: none repeat scroll 0 0 #F9F9F9;
    border-bottom: 1px solid #D0D0D0;
    border-right: 1px solid #D0D0D0;    
    border-left: 1px solid #D0D0D0;
    color: #00537C;
    font-family: 'RobotoBlack';
    font-size: 15px;
    font-weight: normal;
    line-height: 27px;
    padding: 0 10px;    
    text-align: left;   
}
.t-top1:last-child {
    border-right: medium;
}
a{color: #00537C;}
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard">Dashboard</a> | <a href="<?php echo base_url() ?>dashboard/business_listing">Business Listing</a> | Business Overview
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="dash-form">
                        <table width="100%">                            
                            <tr><th COLSPAN="2" class="t-top1" style="height: 30px;"><H1><strong>Business Information</strong></H1></th></tr>                            
                            <tr><td class="t-top1" width="40%">Business Category</td><td class="t-top1" width="60%"><?php echo _getBusinessCategoryNameString($info['buss_id']); ?></td></tr>
                            <tr><td class="t-top1" width="40%">Business Name</td><td class="t-top1" width="60%"><?php echo $info['buss_name']; ?></td></tr>
                            <tr><td class="t-top1">Contact Name</td><td class="t-top1"><?php echo $info['buss_cont_name']; ?></td></tr>
                            <tr><td class="t-top1">Address</td><td class="t-top1"><?php echo $info['buss_address']; ?></td></tr>
                            <tr><td class="t-top1">Address add on</td><td class="t-top1"><?php echo $info['buss_addr_addon']; ?></td></tr>
                            <tr><td class="t-top1">Country</td><td class="t-top1"><?php echo $info['countryName']; ?></td></tr>
                            <tr><td class="t-top1">State</td><td class="t-top1"><?php echo $info['stateName']; ?></td></tr>
                            <tr><td class="t-top1">City </td><td class="t-top1"><?php echo $info['buss_city']; ?></td></tr>
                            <tr><td class="t-top1">Zip code</td><td class="t-top1"><?php echo $info['buss_zip_code']; ?></td></tr>
                            <tr><td class="t-top1">Phone</td><td class="t-top1"><?php echo $info['buss_phone']; ?></td></tr>
                            <tr><td class="t-top1">Fax</td><td class="t-top1"><?php echo $info['buss_fax']; ?></td></tr>
                            <tr><td class="t-top1">Web Address</td><td class="t-top1"><?php echo $info['buss_web_address']; ?></td></tr>
                              <tr><td class="t-top1">Contact Email Address</td><td class="t-top1"><?php echo $info['buss_email']; ?></td></tr>
                              <tr><td class="t-top1">Business License Number</td><td class="t-top1"><?php echo $info['buss_license_num']; ?></td></tr>  
                             <tr><td class="t-top1">LOGO</td>
                                 <td class="t-top1"><?php echo img(array('src'=>base_url().'LOGO/'.$info['buss_logo'],'style'=>'float:left; width:100px; height:100px;'));?>
                                     <!--<a href="<?php echo base_url()?>LOGO/<?php echo $info['user_id']."/".$info['buss_logo']; ?>"target="_blank" onmouseover="document.images['image'].src='<?php echo base_url()?>LOGO/<?php echo "/".$info['buss_logo']; ?>';"onmouseout="document.getElementById('image').src='';"><?php echo $info['buss_logo']; ?></a><img src="" id="image" style="zindex: 100; position: absolute;height: 80px;width: 80px;" />-->
                                 </td>
                             </tr> 
                             <tr>
                                 <td class="t-top1">Media Copy</td>
                                 <td class="t-top1">
                                   <div style="width:100%; float: left; height: auto;">
                                    
                                    <?php 
                                    $buss_media_copy=$info['buss_media_copy'];
                                    if($buss_media_copy!=""){
                                        $businessImages=explode(',',$buss_media_copy);                                        
                                        foreach($businessImages as $key=>$val){
                                            if(trim($val)!=""){
                                                 echo '<div id="imageDivId_'.$key.'" style="width:100px; height:auto; margin-right:5px; border:1px solid #ccc; float:left; text-align: center;">';
                                                 echo img(array('src'=>base_url().'Media_Copy/'.$val,'style'=>'float:left; width:100px; height:100px;'));                                            
                                                 echo '</div>';
                                            }
                                        }
                                    }
                                    ?>
                                    </div>
                                </td>
                             </tr>  
                             <tr>
                                 <td class="t-top1">Business License Certificates</td>
                                 <td class="t-top1">
                                   <div style="width:100%; float: left; height: auto;">
                                    
                                    <?php 
                                    $buss_license_docs=$info['buss_license_docs'];
                                    if($buss_license_docs!=""){
                                            $businessDocs=explode(',',$buss_license_docs);                                        
                                            foreach($businessDocs as $key=>$val){
                                                if(trim($val)!=""){
                                                echo '<br/><p id="docsDivId_'.$key.'">'.$val.' '.                                                    
                                                    anchor('dashboard/business_listing/download_doc/'.$info['buss_id'].'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Doc')).
                                                    '</p>';
                                                }
                                            }
                                        }
                                    ?>
                                    </div>
                                </td>
                             </tr>  
                             
                             <tr>
                                 <td class="t-top1">Videos</td>
                                 <td class="t-top1">
                                   <div style="width:100%; float: left; height: auto;">
                                    
                                    <?php 
                                    $buss_video=$info['buss_video'];
                                    if($buss_video!=""){
                                        $businessVideos=explode(',',$buss_video);                                        
                                        foreach($businessVideos as $key=>$val){
                                            if(trim($val)!=""){
                                            echo '<br/><p id="videoDivId_'.$key.'">'.$val.' '.                                               
                                                anchor('admin/manage_listing/download_video/'.$info['buss_id'].'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Video')).
                                                '</p>';
                                            }
                                        }
                                    }
                                    ?>
                                    </div>
                                </td>
                             </tr>  
                             
                              </table>
                        <table width="100%"> 
                             <tr><td COLSPAN="2" class="t-top1" style="height: 30px;"><img src="<?php echo USER_SIDE_IMAGES;?>social.png" style="margin-top: 4px;"> &nbsp;Social Media Channels</td></tr>
                              <tr><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png">&nbsp;<?php echo $info['buss_social_media_channel_1'];?></td><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png">&nbsp;<?php echo $info['buss_social_media_channel_2'];?></td></tr>  
                              <tr><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png">&nbsp;<?php echo $info['buss_social_media_channel_3'];?></td><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png">&nbsp;<?php echo $info['buss_social_media_channel_4'];?></td></tr>
                              <tr>
                                  <td COLSPAN="2" align="center" class="dash-inner" style="width: auto;margin-top: 4%;">
                                        <?php echo anchor('dashboard/business_listing/edit/'.$info['buss_id'], 'Edit', 'class="dashorange" title="Edit"');?>
                                        <?php echo anchor('dashboard/business_listing', 'Back','class="dashorange" title="Back"');?>
                                  </td>
                              </tr>
                            </table>
                                
                        
                                                       
                           
                    </div>
                </div>




            </section></div>






    </div>
</div>