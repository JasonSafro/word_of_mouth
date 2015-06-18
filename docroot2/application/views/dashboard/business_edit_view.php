<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<?php echo js_asset("jquery.maskedinput-1.3.js");?>
<script type="text/javascript" charset="utf-8">
     jQuery(function($){
        $("#buss_phone").mask("999-999-9999");        
    }); 
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
        
        //When Country Changes, Change State 
        $('#buss_country').change(function(){
               var e = document.getElementById("buss_country");
               var strUser = e.options[e.selectedIndex].value;
               print_state('buss_state',strUser);
        });
        
        
        //for basic business user
         var arr = new Array();
        $("#userCategory").change(function() {
            <?php if($subscriptionPlan=='bm' || $subscriptionPlan=='ba'){?>
            $(this).find("option:selected");
            if ($(this).find("option:selected").length > 2) {
                $(this).find("option").removeAttr("selected");
                alert('You can only choose two categories.');
                $(this).val(arr);
            }
            else {
                arr = new Array();
                $(this).find("option:selected").each(function(index, item) {
                    arr.push($(item).val());
                });
            }
            <?php }?>
                    
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
        
        //remaining charachers counter
        $("#buss_description").keyup(function(){updateRemainingCharacters();});
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
                    url: '<?php echo base_url() ?>dashboard/business_listing/getStateList/'+countryCode,
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
</script>
<style>
    .red {
    color: #FF0000;
    font-size: 10px;
    font-style: italic;
    font-weight: bold;
}
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard">Dashboard</a> | <a href="<?php echo base_url() ?>dashboard/business_listing">Business Listing</a> | Edit Business
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">    
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="dash-form">
                        <?php
                    $attr = array('name' => 'frmBusInfoEdit', 'id' => 'frmBusInfoEdit', 'autocomplete' => 'off', 'method' => 'post');
                    if($action=='edit')
                        echo form_open_multipart('dashboard/business_listing/edit/'.$buss_id, $attr);
                    else
                        echo form_open_multipart('dashboard/business_listing/add', $attr);
                    ?>
                        <div class="dash-area">	
                            <div class="dash-inner">
                                <label>Name *</label>
                                <input type="text" class="inp" name="buss_name" id="buss_name" value="<?php echo set_value('buss_name', $buss_name); ?>"/>
                                  <?php echo form_error('buss_name'); ?>
                            </div>
                            
                            <div class="dash-inner">
                                <label>Category *</label>
                                <?php 
                                $xy='id="userCategory" style="background:none; border:1px solid #ccc; width:100%; margin:2% 0;"';
                                $categoryList= _getCategoryList();
                                $categoryList['other']="Other category";
                                echo form_multiselect('buss_category[]',$categoryList,set_value('buss_category[]',$buss_category),$xy);
                                //echo form_multiselect('buss_category[]',$categoryList,$buss_category,$xy);
                                echo form_error('buss_category[]');
                                ?>
                            </div>
                            
                            <div class="dash-inner" id="otherCatDiv" style="display:none">
                                <label>Other Category:*</label>
                                <input class="inp" name="otherCategory" id="otherCategory" type="text" value="<?php echo set_value('otherCategory'); ?>"/>
                                <?php echo form_error('otherCategory');?>
                            </div>
                            
                            <div class="dash-inner">
                                <label>Contact Name</label>
                                <input type="text" class="inp" name="buss_cont_name" id="buss_cont_name" value="<?php echo set_value('buss_cont_name', $buss_cont_name); ?>"/>
                                <?php echo form_error('buss_cont_name'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Address*</label>
                                <input type="text" class="inp" name="buss_address" id="buss_address" value="<?php echo set_value('buss_address', $buss_address); ?>"/>
                                <?php echo form_error('buss_address'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Address Add On</label>
                                <input type="text" class="inp" name="buss_addr_addon" id="buss_addr_addon" value="<?php echo set_value('buss_addr_addon', $buss_addr_addon); ?>"/>
                             <?php echo form_error('buss_addr_addon'); ?>
                            </div>
                            
                            <div class="dash-inner">
                                <label>Country*</label>
                                 <?php 
                                    $st='id="buss_country" class="items_custom" style="margin-bottom:5px;"';
                                    echo form_dropdown('buss_country', _getCountryList(),set_value('buss_country',$buss_country),$st);
                                    $selectedCountry=set_value('buss_country',$buss_country);
                                  ?>
                                 <?php echo form_error('buss_country'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>State*</label>
                                <?php 
                                    $st='id="buss_state" class="items_custom" style="margin-bottom:5px;"';
                                    echo form_dropdown('buss_state', _getStateList($selectedCountry),set_value('buss_state',$buss_state),$st);
                                  ?>
                                 <?php echo form_error('buss_state'); ?>
                            </div>
                            
                              <div class="dash-inner">
                                <label>City *</label>
                                <input type="text" class="inp" name="buss_city" id="buss_city" value="<?php echo set_value('buss_city', $buss_city); ?>"/>
                                <?php echo form_error('buss_city'); ?>
                            </div>
                            <div class="dash-inner">
                                <label>Zip Code*</label>
                                <input type="text" class="inp" name="buss_zip_code" id="buss_zip_code" value="<?php echo set_value('buss_zip_code', $buss_zip_code); ?>"/>
                                <?php echo form_error('buss_zip_code'); ?>
                            </div> 
                             <div class="dash-inner">
                                <label>Phone *</label>
                                <input type="text" class="inp" name="buss_phone" id="buss_phone" value="<?php echo set_value('buss_phone', $buss_phone); ?>"/>
                                <?php echo form_error('buss_phone'); ?>
                            </div>                          
                             <div class="dash-inner">
                                  <label>FAX</label>
                                  <input type="text" class="inp" name="buss_fax" id="buss_fax" value="<?php echo set_value('buss_fax', $buss_fax); ?>"/>
                                  <?php echo form_error('buss_fax'); ?>
                             </div>                           
                            <div class="dash-inner">
                                <label>Web Address</label>
                                <input type="text" class="inp" name="buss_web_address" id="buss_web_address" value="<?php echo set_value('buss_web_address', $buss_web_address); ?>"/>
                                <?php echo form_error('buss_web_address'); ?>
                            </div>
                              <div class="dash-inner">
                                <label>Email</label>
                                <input type="text" class="inp" name="buss_email" id="buss_email" value="<?php echo set_value('buss_email', $buss_email); ?>"/>
                                <?php echo form_error('buss_email'); ?>
                            </div>
                             <div class="dash-inner">
                                <label>Business License Number</label>
                                <input type="text" class="inp" name="buss_license_num" id="buss_license_num" value="<?php echo set_value('buss_license_num', $buss_license_num); ?>"/>
                                <?php echo form_error('buss_license_num'); ?>
                            </div>
                            
                            <?php if(($my['user_type']=='buss_user') && ($my['user_plan']=='pm' || $my['user_plan']=='pa')){//user_plan?>
                            <div class="dash-inner">
                                <label>Additional Information:</label>
                                <fieldset style="border:1px #ccc solid; padding: 5px;">
                                    <?php //echo (validation_errors()==""?($mon_d_and_s==1?"checked":""):set_checkbox('mon_d_and_s', '1')); ?>
                                    
                                    <label><input type="checkbox" name="buss_comp_quot" value="1" <?php echo (validation_errors()==""?($buss_comp_quot==1?"checked":""):set_checkbox('buss_comp_quot', '1')); ?>/>&nbsp;Click to receive competitive quotes</label>
                                    
                                    <label>Email Address to receive competitive quotes:</label>
                                    <input type="text" class="inp" name="buss_comp_email" id="buss_comp_email" value="<?php echo set_value('buss_comp_email', $buss_comp_email); ?>"/>
                                    <?php echo form_error('buss_comp_email');?>
                                    
                                    <label><input type="checkbox" name="mon_d_and_s" value="1" <?php echo (validation_errors()==""?($mon_d_and_s==1?"checked":""):set_checkbox('mon_d_and_s', '1')); ?>/>&nbsp;Click to submit monthly deals & specials</label>
                                    <label><input type="checkbox" name="we_r_hir" value="1" <?php echo (validation_errors()==""?($we_r_hir==1?"checked":""):set_checkbox('we_r_hir', '1')); ?>/>&nbsp;We’re Hiring</label>
                                </fieldset>
                                
                            </div>    
                            <?php }?>
                            <div class="dash-inner">                        
                                <label for="image_logo">Upload New Logo:</label>
                                <input type="file" name="image_logo" id="image_logo" accept="image/*"/><br/>
                                Size : up-to 3mb, Dimension : up-to 1024 X 768 with extention:jpg,png <br/>
                                <?php echo form_error('image_logo'); ?>
                                
                                 <?php if ($error != '')
                                        echo '<br/><br/><span class="error">' . $error.'</span>'; ?> 
                            </div>
                                
                            <div class="dash-inner">                        
                                <label for="image_logo">Upload New Media Copy:</label>
                                <input type="file" name="image_media[]" id="image_media" accept="image/*" multiple/><br/>
                                Size : up-to 3mb, Dimension : up-to 1024 X 768 with extention:jpg,png <br/>
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
                             
                                <div class="dash-inner">                        
                                <label for="buss_license_docs">Upload Business License Certification:</label>
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
                                                anchor('dashboard/business_listing/download_doc/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Doc')).
                                                '</p>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                 
                            </div>
                            
                           <!-- <div class="dash-inner">                        
                                <label for="buss_video">Upload Video:</label>
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
                                                anchor('dashboard/business_listing/download_video/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Video')).
                                                '</p>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                 
                            </div>-->

                            
                            <div class="dash-inner">
                                <label>Business Tag Line</label>
                                <input type="text" class="inp" name="buss_tag_line" id="buss_tag_line" value="<?php echo set_value('buss_tag_line', $buss_tag_line); ?>"/>
                                <?php echo form_error('buss_tag_line'); ?>
                            </div>
                            <!--<div class="dash-inner">
                                <label>Business Description</label>
                                <input type="text" class="inp" name="buss_description" id="buss_description" value="<?php echo set_value('buss_description', $buss_description); ?>"/>
                                <?php echo form_error('buss_tag_line'); ?>
                            </div>-->
                            <div class="dash-inner">
                                <label>Business Description</label>
                                Note: Only 255 characters allowed. <b class="color-red">(Remaining Characters: <span id="remaining"></span>)</b><br/>
                                <textarea name="buss_description" id="buss_description" class="txtarea" rows="5"><?php echo set_value('buss_description', $buss_description); ?></textarea>
                                <?php echo form_error('buss_description'); ?>
                            </div>
                            
                             <div class="dash-inner">
                                <label>Social Media Channels</label>
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
                             
                                                        
                            <div class="dash-inner" style="margin-top: 10px;">
                                <!--<input type="button" class="dash-button" value="CLEAR FORM">-->
                                <input type="submit" id="submitMe" class="dashorange" value="submit" style="display:none;"/>
                                <a class="dashorange" onclick="javascript:$('#submitMe').click();">Submit</a>
                                <?php echo anchor('dashboard/business_listing', 'Back','class="dashorange" title="Back"');?>
                            </div>
                            
                        </div>
                        </form>
                        
                        <?php 
                        $userId=$this->session->userdata('user_id');
                        
                        //echo '<pre';
                        
                        if(($my['user_type']=='buss_user') && ($my['user_plan']=='pm' || $my['user_plan']=='pa')){//user_plan?>
                        <div style="width:100%; border-bottom: 1px #ccc solid; clear: both; margin-bottom: 5px;"></div>
                        <?php echo form_open_multipart('dashboard/business_listing/ajaxVideoUpload/'.$buss_id, array('id'=>'frmVideo','name'=>'frmVideo'));?>
                        
                        <div class="dash-inner">                        
                                <label for="buss_video">Upload Video ( .mp4 format ) :</label>
                                <input type="file" name="ajax_buss_video" id="ajax_buss_video"  accept="video/*"/><br/>
                                
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
                                                anchor('dashboard/business_listing/download_video/'.$buss_id.'/'.$val,'Download',array('target'=>"_blanck",'title'=>'Download Video')).
                                                '</p>';
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                                <input type="hidden" id="numOfVideos" value="<?php echo $numOfVideos;?>"/>
                                <div class="dash-inner" style="margin-top: 10px;">                                
                                <input type="submit" id="submitVideo" class="dashorange" value="Upload Video"/>
                            </div>
                            </div>
                                
                        <?php echo form_close();?>
                       <?php }?> 
                    </div>
                </div>




            </section></div>
    </div>
</div>


<script type="text/javascript">
function removeMediaImage(businessId,imageDivId,imageName)
{
    var siteUrl="<?php echo base_url();?>";
    if(confirm("Are you sure, you wants to remove this image?")){
        $.ajax({
            type: "post",
            data:{businessId: businessId,imageName:imageName},
            url: siteUrl+'dashboard/business_listing/removeMediaImage',
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
            url: siteUrl+'dashboard/business_listing/removeBusinessDoc',
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
            url: siteUrl+'dashboard/business_listing/removeVideo',
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