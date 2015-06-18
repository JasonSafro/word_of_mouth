<div id="content">
    <!-- content / right -->
    <div id="right">
        <!-- table -->
        <div class="box">
            <!-- box / title -->
            <div class="title">
                <h5>Review Detailed View</h5>              
            </div>

            <?php echo $this->load->view('admin/display_admin_status_messages'); ?>
			
            <div class="table">  
                 <div class="form">
                    <div class="fields">
                        <?php $info=$review[0];?>
                       <!--<div class="field">
                            <div class="label">
                                <label for="input-large">Category Name:</label>
                            </div>
                            <div class="input"><?php if($info['catName']=='')echo "--";else echo $info['catName'];?></div>
                        </div>-->    
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Business Name:</label>
                            </div>
                            <div class="input"><?php if($info['buss_name']=='')echo "--";else echo anchor("/home/business_details/".$info['rvwBusinessId'],$info['buss_name'],array('title'=>'View business details page.','target'=>'_blanck'));;?></div>
                        </div>                         
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Reviewer:</label>
                            </div>
                            <div class="input"><?php if($info['rvwReviewerName']=='')echo "--";else echo $info['rvwReviewerName'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Phone Number:</label>
                            </div>
                            <div class="input"><?php if($info['rvwPhoneNo']=='')echo "--";else echo $info['rvwPhoneNo'];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Email:</label>
                            </div>
                            <div class="input"><?php if($info['rvwEmail']=='')echo "--";else echo $info['rvwEmail'];?></div>
                        </div> 
                        <?php $ratingNames=array('5'=>'Excellent','4'=>'Good','3'=>'Average','2'=>'Poor','1'=>'Awful'); ?>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Professionalism:</label>
                            </div>
                            <div class="input"><?php echo $ratingNames[$info['rvwRatingProfessionalism']];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Dependability:</label>
                            </div>
                            <div class="input"><?php echo $ratingNames[$info['rvwRatingDependability']];?></div>
                        </div>                         
                        
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Price:</label>
                            </div>
                            <div class="input"><?php echo $ratingNames[$info['rvwRatingPrice']];?></div>
                        </div> 
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Overall:</label>
                            </div>
                            <div class="input"><?php echo $ratingNames[$info['rvwRatingOverall']];?></div>
                        </div> 
                        
                        
                
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Details:</label>
                            </div>
                            <div class="input"><?php if($info['rvwDetails']=='')echo "--";else echo nl2br($info['rvwDetails']);?></div>
                        </div> 
                        
                       
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Review Date:</label>
                            </div>
                            <div class="input"><?php if($info['rvwCreatedOn']=='')echo "--";else echo $info['rvwCreatedOn'];?></div>
                        </div>
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Review Updated Date:</label>
                            </div>
                            <div class="input"><?php if($info['rvwUpdatedOn']=='')echo "--";else echo $info['rvwUpdatedOn'];?></div>
                        </div>
                        
                        <div class="field">
                            <div class="label">
                                <label for="input-large">Review Status:</label>
                            </div>
                            <div class="input"><?php echo $info['rvwStatus'];?></div>
                        </div>
                        
                         <div class="field">
                            <div class="label">
                                <label for="input-large">Action:</label>
                            </div>
                            <div class="input">
                            <?php
                            $attr = array('name' => 'frmReviews', 'id' => 'frmReviews', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>'javascript:return checkDispute();');
                            $form_url = ADMIN_FOLDER_NAME.'/manage_reviews/save_satus/'.$info['rvwId'];
                            echo form_open($form_url, $attr);
                            ?>
                            <input type="radio" name="status" value="Published" <?php if($info['rvwStatus']=='Published'){?>checked="checked"<?php }?> onclick="showResone('Published');"/> Publish <br/><br/>
                            <input type="radio" name="status" id="disputedStatus" value="Disputed" <?php if($info['rvwStatus']=='Disputed'){?>checked="checked"<?php }?> onclick="showResone('Disputed');" /> Dispute<br/><br/>
                            <lable class="hideShowDisputeBox" style="clear:both; margin-bottom: 5px;">* Dispute Reason:</lable>
                            <textarea class="hideShowDisputeBox" rows="4" cols="60" name="rvwDesputedReason" id="rvwDesputedReason" style="margin-bottom: 10px;"><?php echo $info['rvwDesputedReason'];?></textarea>
                            <input type="radio" name="status" value="Delayed" <?php if($info['rvwStatus']=='Delayed'){?>checked="checked"<?php }?> onclick="showResone('Delayed');"/> Delay<br/><br/>
                            <input type="submit" name="submit" value="Change Status" />
                            <?php echo form_close();?>
                            </div>
                        </div> 
                        
                        <div style="clear:both;"></div>
                        <br/>
                        <input type="button" class="ui-button custom-default-button" name="back" value="Back" onclick="javascript: location='<?php echo base_url().ADMIN_FOLDER_NAME."/manage_reviews";?>'" /> 							
                     </div>
                </div>
            </div>
            
        </div>                     
    </div>
    <!-- end content / right -->
</div>
<script>
    showResone("<?php echo $info['rvwStatus'];?>");
    function showResone(status){
        if(status=="Disputed")
            $('.hideShowDisputeBox').css('display','block');
        else
            $('.hideShowDisputeBox').css('display','none');
        /*if ($("#disputedStatus").is(':checked')) {
            alert('yes');
        }else
            alert('no');*/
       
    }
    
    function checkDispute()
    {
        
        if($("input[name='status']").is(':checked'))
        {
            if ($("#disputedStatus").is(':checked') && $('#rvwDesputedReason').val()==""){
                alert('Please enter the disputed reson.');
                $('#rvwDesputedReason').focus();
                return false;
            }
        }
        else{
            alert('Please select the action.');
            return false;
        }
    }
</script>  