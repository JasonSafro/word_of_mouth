
<?php
//CSS
echo css_asset("address-popup.css");
?>
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
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | <?php echo anchor('dashboard/jobs','Jobs');?> | Applicants
                </div>
            </section></div>


        <div class="dash"><section id="main">
        <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                    <div class="post-right"></div>
                    <p><h4>Business Name : <?php echo $jobInfo[0]['buss_name'];?></h4></p><br/>
                    <p><h4>Job Title : <?php echo $jobInfo[0]['jobTitle'];?></h4></p><br/>
                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>                                
                                <td align="center" class="t-top3">Applicant Name</td>
                                <td align="center" class="t-top3">Phone No</td>
                                <td align="center" class="t-top3">Applied Date</td>
                                <td align="center" class="t-top3">Status</td> 
                                <td align="center" class="t-top3">Action</td>
                            </tr>
                           <?php foreach($jobApplications as $key=>$val){?> 
                            <tr>                                
                                <td class="t-top1" align="center"><?php echo $val['jAppApplicantFullName'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['jAppApplicantPhone'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['jAppCreatedOn'];?></td>
                                <td class="t-top1" align="center"><?php echo $val['jAppStaus'];?></td>
                                <td class="t-top1" align="center">
                                   <a class="" href="<?php echo site_url('dashboard/jobs/view_applicant_details/'.$val['jAppId']);?>" title="View details"><img src="<?php echo USER_SIDE_IMAGES.'view_details.png'?>" class="imgMiddleAlign"/></a> | 
                                   <a class="" href="<?php echo site_url('dashboard/jobs/delete_job_application/'.$val['jAppId']);?>" title="Delete application"><img src="<?php echo USER_SIDE_IMAGES.'cross.png'?>" class="imgMiddleAlign" height="16" width="16"/></a>
                                </td>
                            </tr>
                            <?php }?>
                        </table>
                    </div>                   






<!-- popup start   -->             

<!--  popup end-->
                    
                    
 <!-- popup start FOR EDIT  -->             

<!--  popup end-->  
                </div>
            </section>
        </div>
    </div>
</div>