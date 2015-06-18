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
</style>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <?php $info=$review[0];?>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | <?php echo anchor('dashboard/reviews','Reviews');?> | Review details
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">                  
                    <div class="dash-form">
                        <table width="100%">
                            <tr><th COLSPAN="2" class="t-top1" style="height: 30px;"><H1><strong>Review Details</strong></H1></th></tr>                            
                            <tr><td class="t-top1" width="40%">Category Name</td><td class="t-top1" width="60%"><?php echo _getBusinessCategoryNameString($info['rvwBusinessId']); ?></td></tr>                            
                            <tr><td class="t-top1">Business Name </td><td class="t-top1"><?php echo $info['buss_name']; ?></td></tr>
                            <tr><td class="t-top1">Reviewer</td><td class="t-top1"><?php echo $info['rvwReviewerName']; ?></td></tr>
                            <tr><td class="t-top1">Phone Number</td><td class="t-top1"><?php echo $info['rvwPhoneNo']; ?></td></tr>
                            <tr><td class="t-top1">Email</td><td class="t-top1"><?php echo $info['rvwEmail']; ?></td></tr>
                            <?php $ratingNames=array('5'=>'Excellent','4'=>'Good','3'=>'Average','2'=>'Poor','1'=>'Awful'); ?>
                            <tr><td class="t-top1">Professionalism</td><td class="t-top1"><?php echo $ratingNames[$info['rvwRatingProfessionalism']];?></td></tr>
                            <tr><td class="t-top1">Dependability</td><td class="t-top1"><?php echo $ratingNames[$info['rvwRatingDependability']];?></td></tr>
                            <tr><td class="t-top1">Price</td><td class="t-top1"><?php echo $ratingNames[$info['rvwRatingPrice']];?></td></tr>
                            <tr><td class="t-top1">Overall</td><td class="t-top1"><?php echo $ratingNames[$info['rvwRatingOverall']];?></td></tr>
                            <tr><td class="t-top1">Details</td><td class="t-top1"><?php echo nl2br($info['rvwDetails']);?></td></tr>
                            <tr><td class="t-top1">Review Date</td><td class="t-top1"><?php echo $info['rvwCreatedOn'];?></td></tr>
                            <tr><td class="t-top1">Review Updated Date</td><td class="t-top1"><?php echo $info['rvwUpdatedOn'];?></td></tr>
                            <tr><td class="t-top1">Status</td><td class="t-top1"><?php echo $info['rvwStatus'];?></td></tr>
                            <?php if($this->session->userdata('user_id')==$info["rvwBusinessUserId"]){?>
                            <tr><td class="t-top1">Action</td>
                                <td class="t-top1">
                                    <?php
                                    
                                    $attr = array('name' => 'frmReviews', 'id' => 'frmReviews', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>'javascript:return checkDispute();');
                                    $form_url = 'dashboard/reviews/save_satus/'.$info['rvwId'];
                                    echo form_open($form_url, $attr);
                                    ?>
                                    <input type="radio" name="status" value="Published" <?php if($info['rvwStatus']=='Published'){?>checked="checked"<?php }?> onclick="showResone('Published');"/> Publish <br/>
                                    <input type="radio" name="status" id="disputedStatus" value="Disputed" <?php if($info['rvwStatus']=='Disputed'){?>checked="checked"<?php }?> onclick="showResone('Disputed');" /> Dispute<br/>
                                    <lable class="hideShowDisputeBox" style="clear:both; margin-bottom: 5px;"><span class="error"><sup>*</sup></span> Dispute Reason:</lable>
                                    <textarea class="hideShowDisputeBox" rows="4" cols="60" name="rvwDesputedReason" id="rvwDesputedReason" style="margin-bottom: 10px;"><?php echo $info['rvwDesputedReason'];?></textarea>
                                    <input type="radio" name="status" value="Delayed" <?php if($info['rvwStatus']=='Delayed'){?>checked="checked"<?php }?> onclick="showResone('Delayed');"/> Delay<br/>
                                    <input type="submit" name="submit" value="Change Status" />
                                    <?php echo form_close();
                                    ?>
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>
                </div>

            </section></div>






    </div>
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