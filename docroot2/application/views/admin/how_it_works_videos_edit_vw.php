<!-- content -->
<style>
.progress { position:relative; width:400px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
.bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
.percent { position:absolute; display:inline-block; top:3px; left:48%; }

.ajaxSuccess{background-color: #E6EFC2;border: 1px solid #C6D880; padding: 2px; border-radius: 3px; color: #4E6100; float: left; margin-top: 5px; }
.ajaxError{background-color: #FBE3E4; border: 1px solid #FBC2C4; padding: 2px; border-radius: 3px; color: #860006; float: left; margin-top: 5px;}
</style>
<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Manage how it works video</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">
                    
                <input class="input" name="fvId" type="hidden" value="<?php echo $hwId;?>"/>           
                 <div class="form">
                    <div class="fields">

                        <div class="field">
                            <?php 
                                $attr = array('name' => 'frmVdo1', 'id' => 'frmVdo1', 'autocomplete' => 'off', 'method' => 'post');
                                $form_url = ADMIN_FOLDER_NAME.'/how_it_works_videos/edit/hwVideo1';
                                echo form_open_multipart($form_url, $attr);
                             ?>
                            <div class="label">
                                <label for="input-large">Video1:</label>
                            </div>
                            <div class="input">
                                <input type="file" name="hwVideo1" value="" id="hwVideo1"/>
                                <div style="clear:both; margin-bottom: 5px;"></div> 
                                <span>Note: Allowed Video Types:(MP4)</span>
                                <div style="clear:both; margin-bottom: 5px;"></div> 
                                <?php echo $hwVideo1;?>
                                <?php if ($hwVideo1Error != '')
                                        echo '<br/><br/><span class="error">' . $hwVideo1Error.'</span>'; ?>                                    
                                <?php echo form_error('hwVideo1'); ?>
                                
                                <div class="progress" id="progress1">
                                    <div class="bar" id="bar1"></div >
                                    <div class="percent" id="percent1">0%</div >
                                </div>
                                <div id="status1"></div>
                                
                            </div>
                            
                             <div style="clear:both;"></div>
                            <div class="buttons"> 
                                <input name="submit" value="Update" type="submit" class="ui-button custom-default-button"/>
                            </div>
                             <?php echo form_close();?>
                        </div>  
                        
                        <div class="field">
                            <?php 
                                $attr = array('name' => 'frmVdo2', 'id' => 'frmVdo2', 'autocomplete' => 'off', 'method' => 'post');
                                $form_url = ADMIN_FOLDER_NAME.'/how_it_works_videos/edit/hwVideo2';
                                echo form_open_multipart($form_url, $attr);
                             ?>
                            <div class="label">
                                <label for="input-large">Video2:</label>
                            </div>
                            <div class="input">
                                <input type="file" name="hwVideo2" value="" id="hwVideo2"/>
                                <div style="clear:both; margin-bottom: 5px;"></div> 
                                <span>Note: Allowed Video Types:(MP4)</span>
                                <div style="clear:both; margin-bottom: 5px;"></div> 
                                <?php echo $hwVideo2;?>
                                <?php if ($hwVideo2Error != '')
                                        echo '<br/><br/><span class="error">' . $hwVideo2Error.'</span>'; ?>                                    
                                <?php echo form_error('hwVideo2'); ?>
                                
                                 <div class="progress" id="progress2">
                                    <div class="bar" id="bar2"></div >
                                    <div class="percent" id="percent2">0%</div >
                                </div>
                                <div id="status2"></div>
                            </div>
                            
                             <div style="clear:both;"></div>
                            <div class="buttons"> 
                                <input name="submit" value="Update" type="submit" class="ui-button custom-default-button"/>
                            </div>
                             <?php echo form_close();?>
                             
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- end table -->
        <!-- end box / right -->
    </div>
    <!-- end content / right -->
</div>


<!--<script src="http://malsup.github.com/jquery.form.js"></script>-->
<?php echo js_asset("custom_jequery_form.js");?>
<script>
(function() {

    //upload first video
    var bar1 = $('#bar1');
    var percent1 = $('#percent1');
    var status1 = $('#status1');
    $('#progress1').css('display','none');
    $('#frmVdo1').ajaxForm({
        url:       '<?php echo base_url().'admin/how_it_works_videos/ajajEdit/hwVideo1'?>',
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
            }    
            else{
                $('#progress1').css('display','none');
                status1.html('<span class="ajaxError">'+res[1]+'</span>');
                bar1.width("0%");
                percent1.html("0%");
            }
            
        }
    });
   
   //upload second video
    var bar2 = $('#bar2');
    var percent2 = $('#percent2');
    var status2 = $('#status2');
    $('#progress2').css('display','none');
    $('#frmVdo2').ajaxForm({
        url:       '<?php echo base_url().'admin/how_it_works_videos/ajajEdit/hwVideo2'?>',
        beforeSubmit:checkBeforeUpload2,
        beforeSend: function() {
            $('#progress2').css('display','block');
            status2.empty();            
            var percentVal = '0%';
            bar2.width(percentVal);
            percent2.html(percentVal);            
        },
        uploadProgress: function(event, position, total, percentComplete) {
            var percentVal = percentComplete + '%';
            bar2.width(percentVal)
            percent2.html(percentVal);
        },
        complete: function(xhr) {   
            var text=xhr.responseText;
            var res=text.split("=");
            if(res[0]=="success"){
                status2.html('<span class="ajaxSuccess">'+res[1]+'</span>');
                bar2.width("100%");
                percent2.html("100%");
            }    
            else{
                $('#progress2').css('display','none');
                status2.html('<span class="ajaxError">'+res[1]+'</span>');
                bar2.width("0%");
                percent2.html("0%");
            }
            
        }
    });
})(); 

function checkBeforeUpload1(){
    if(document.getElementById("hwVideo1").value=="")
    {
        alert("Please select file to upload");
        return false;
    }    
    else if(document.getElementById("hwVideo1").files[0].size > 88589934592)//8mb
    {
        alert("File is too big.");
        return false;
    }
    return true;
}

function checkBeforeUpload2(){

    if(document.getElementById("hwVideo2").value=="")
    {
        alert("Please select file to upload");
        return false;
    }    
    else if(document.getElementById("hwVideo2").files[0].size > 88589934592)//8mb
    {
        alert("File is too big.");
        return false;
    }
    return true;
}
</script>