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
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/business_overview">Dashboard</a> | Business Overview
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">                  
                    <div class="dash-form">
                        <table width="100%">                            
                            <tr><th COLSPAN="2" class="t-top1" style="height: 30px;"><H1><strong>Business Information</strong></H1></th></tr>                            
                            <tr><td class="t-top1" width="40%">Business Name</td><td class="t-top1" width="60%"><?php echo $info['buss_name']; ?></td></tr>
                            <tr><td class="t-top1">Contact Name</td><td class="t-top1"><?php echo $info['buss_cont_name']; ?></td></tr>
                            <tr><td class="t-top1">Address</td><td class="t-top1"><?php echo $info['buss_address']; ?></td></tr>
                            <tr><td class="t-top1">Address add on</td><td class="t-top1"><?php echo $info['buss_addr_addon']; ?></td></tr>
                            <tr><td class="t-top1">City </td><td class="t-top1"><?php echo $info['buss_city']; ?></td></tr>
                            <tr><td class="t-top1">Zip code</td><td class="t-top1"><?php echo $info['buss_zip_code']; ?></td></tr>
                            <tr><td class="t-top1">Phone</td><td class="t-top1"><?php echo $info['buss_phone']; ?></td></tr>
                            <tr><td class="t-top1">Fax</td><td class="t-top1"><?php echo $info['buss_fax']; ?></td></tr>
                            <tr><td class="t-top1">Web Address</td><td class="t-top1"><?php echo $info['buss_web_address']; ?></td></tr>
                              <tr><td class="t-top1">Contact Email Address</td><td class="t-top1"><?php echo $info['buss_email']; ?></td></tr>
                              <tr><td class="t-top1">Business License Number</td><td class="t-top1"><?php echo $info['buss_license_num']; ?></td></tr>  
                             <tr><td class="t-top1">LOGO</td><td class="t-top1"><a href="<?php echo base_url()?>LOGO/<?php echo $info['user_id']."/".$info['buss_logo']; ?>"target="_blank" onmouseover="document.images['image'].src='<?php echo base_url()?>LOGO/<?php echo $info['user_id']."/".$info['buss_logo']; ?>';"onmouseout="document.getElementById('image').src='';"><?php echo $info['buss_logo']; ?></a><img src="" id="image" style="zindex: 100; position: absolute;height: 80px;width: 80px;" /></td></tr> 
                             <tr><td class="t-top1">Media Copy</td><td class="t-top1"><a href="<?php echo base_url()?>Media_Copy/<?php echo $info['user_id']."/".$info['buss_media_copy']; ?>"target="_blank" onmouseover="document.images['image1'].src='<?php echo base_url()?>Media_Copy/<?php echo $info['user_id']."/".$info['buss_media_copy']; ?>';"onmouseout="document.getElementById('image1').src='';"><?php echo $info['buss_media_copy']; ?></a><img src="" id="image1" style="zindex: 100; position: absolute;height: 80px;width: 80px;" /></td></tr>  
                              </table>
                        <table width="100%"> 
                             <tr><td COLSPAN="2" class="t-top1" style="height: 30px;"><img src="<?php echo USER_SIDE_IMAGES;?>social.png" style="margin-top: 4px;"> &nbsp;Social Media Channels</td></tr>
                              <tr><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png">&nbsp;<?php echo $info['buss_social_media_channel_1'];?></td><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png">&nbsp;<?php echo $info['buss_social_media_channel_2'];?></td></tr>  
                              <tr><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png">&nbsp;<?php echo $info['buss_social_media_channel_3'];?></td><td class="t-top1"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png">&nbsp;<?php echo $info['buss_social_media_channel_4'];?></td></tr>
                            <tr><td COLSPAN="2" align="center" class="dash-inner dashorange" style="width: auto;margin-top: 4%;"><?php echo anchor('dashboard/manage_business_info', 'Edit', 'title="Edit"');?></th></tr>
                            </table>
                                
                        
                                                       
                           
                    </div>
                </div>




            </section></div>






    </div>
</div>