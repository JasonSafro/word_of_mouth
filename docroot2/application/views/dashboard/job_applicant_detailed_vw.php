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
                <?php $info=$jobApplicationInfo[0];?>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | <?php echo anchor('dashboard/jobs','Jobs');?> | <?php echo anchor('dashboard/jobs/view_applicants/'.$info['jAppJobId'],'Applications');?> | Applicant details
                </div>
            </section></div>


        <div class="dash"><section id="main">
                <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">   
                    <?php echo $this->load->view('success_error_message_area');?>
                    <div class="dash-form">
                        <table width="100%">
                            <tr><th COLSPAN="2" class="t-top1" style="height: 30px;"><H1><strong>Application Information</strong></H1></th></tr>                            
                            <tr><td class="t-top1" width="40%">Business Name</td><td class="t-top1" width="60%"><?php echo $info['buss_name']; ?></td></tr>                            
                            <tr><td class="t-top1">Job Title</td><td class="t-top1"><?php echo $info['jobTitle']; ?></td></tr>                            
                            <tr><td class="t-top1">Applicant Name</td><td class="t-top1"><?php echo $info['jAppApplicantFullName']; ?></td></tr>                            
                            <tr><td class="t-top1">Address </td><td class="t-top1"><?php echo $info['jAppApplicantAddress']; ?></td></tr>
                            <tr><td class="t-top1">City</td><td class="t-top1"><?php echo $info['jAppApplicantCity']; ?></td></tr>
                            <tr><td class="t-top1">State</td><td class="t-top1"><?php echo $info['jAppApplicantState']; ?></td></tr>
                            <tr><td class="t-top1">Zip code</td><td class="t-top1"><?php echo $info['jAppApplicantZipCode']; ?></td></tr>
                            <tr><td class="t-top1">Phone</td><td class="t-top1"><?php echo $info['jAppApplicantPhone'];?></td></tr>
                            <tr><td class="t-top1">Fax</td><td class="t-top1"><?php echo $info['jAppApplicantFax'];?></td></tr>
                            <tr><td class="t-top1">Email</td><td class="t-top1"><?php echo $info['jAppApplicantEmail'];?></td></tr>
                            <tr><td class="t-top1">Resume</td><td class="t-top1"><?php echo ($info['jAppApplicantResume']==""?"No resume attached":anchor('dashboard/jobs/download_resume/'.$info['jAppId'].'/'.$info['jAppApplicantResume'],'Download resume'));?></td></tr>
                            <tr><td class="t-top1">Cover letter</td><td class="t-top1"><?php echo ($info['jAppApplicantCoverLetter']==""?"No coverletter attached":anchor('dashboard/jobs/download_coverlatter/'.$info['jAppId'].'/'.$info['jAppApplicantCoverLetter'],'Download cover letter'));?></td></tr>
                            <tr><td class="t-top1">Applied date</td><td class="t-top1"><?php echo $info['jAppCreatedOn'];?></td></tr>
                            <tr>
                                <td class="t-top1">Application Status</td>
                                <td class="t-top1">
                                  <?php
           			 $attr = array('name' => 'frmAppStattus', 'id' => 'frmAppStattus', 'autocomplete' => 'off', 'method' => 'post');
          			  echo form_open('dashboard/jobs/change_application_status/'.$info['jAppId'], $attr);
                                    $sArray=array('Pending'=>'Pending','Accepted'=>'Accept','Rejected'=>'Reject');
                                    echo form_dropdown('jAppStaus',$sArray,$info['jAppStaus']);?>
                                    <input type="submit" name="changeStatus" value="Update Status"/> 
                                  <?php echo form_close();
           			 ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <a class="button7" href="<?php echo site_url('dashboard/jobs/view_applicants/'.$info['jAppJobId']);?>" style="margin-top: 5px;">Back</a>



            </section></div>
        






    </div>
</div>