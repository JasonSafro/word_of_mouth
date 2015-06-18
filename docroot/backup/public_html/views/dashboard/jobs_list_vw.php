
<?php
//CSS
echo css_asset("address-popup.css");
echo css_asset("selectbox.css");
?>
<script src="<?php echo base_url() ?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
<?php echo js_asset("jquery.selectbox-0.5.js"); ?>



<link href="<?php echo base_url();?>assets/datepicker/jquery-ui.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url();?>assets/datepicker/jquery.min.1.5.js"></script>
<script src="<?php echo base_url();?>assets/datepicker/jquery-ui.js"></script>


<script type="text/javascript" charset="utf-8">
    $(document).ready(function(){
        
        $("#jobPostDate").datepicker({		
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
            changeYear: true
        });
        
        $("#EjobPostDate").datepicker({		
            dateFormat: "yy-mm-dd",
            minDate: new Date(),
            changeYear: true
        });
        
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
    
    function getJob(jobId)
    {
        $.ajax({
                type: "GET",                                        
                url: '<?php echo base_url() ?>dashboard/jobs/getJob/'+jobId,
                dataType:"json",
                success: function (data){
                        $('#EjobBusinessId').val(data['jobBusinessId']);
                        $('#EjobPostDate').val(data['jobPostDate']);
                        $('#EjobTypeId').val(data['jobTypeId']);
                        $('#EjobTitle').val(data['jobTitle']);
                        $('#EjobExperiance').val(data['jobExperiance']);
                        $('#EjobDescription').val(data['jobDescription']);
                        $('#EjobDutiesAndResponsibilities').val(data['jobDutiesAndResponsibilities']);
                        $('#EjobRequiredQualifications').val(data['jobRequiredQualifications']);
                        $('#EjobDesiredQualifications').val(data['jobDesiredQualifications']);
                        $('#EjobAdditionalInformation').val(data['jobAdditionalInformation']);
                        $('#EjobId').val(jobId);
                }
            });//EdealExpirationDate
    }
</script>
<div id="page-wrap">
    <div id="section">
        <div class="b-strip">
            <section id="main">
                <h1>Dashboard</h1>
                <div class="links">
                    <a href="<?php echo base_url() ?>">Home</a> | <a href="<?php echo base_url() ?>dashboard/account_overview">Dashboard</a> | Jobs
                </div>
            </section></div>


        <div class="dash"><section id="main">
            <?php $this->load->view('dashboard/dashbord_left_sidebar_view'); ?>
                <div class="dash-r">
                     <?php echo $this->load->view('success_error_message_area');?>
                    <?php if($this->session->userdata('user_type')!='site_user'){?>
                    <div class="post-right"><a class="button4" href="#newJob" id="newJob_pop">New Job</a></div>
                    <?php }?>

                    <div class="main-t">
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td width="20%" class="t-top3"align="center">Business Name</td>
                                <td width="30%" align="center" class="t-top3">Job Title</td>
                                <td width="15%" align="center" class="t-top3">Job Post Date</td>
                                <td width="10%" align="center" class="t-top3">Job Type</td> 
                                <td width="5%" align="center" class="t-top3">Action</td>
                            </tr>
                           <?php foreach($jobList as $key=>$val){?> 
                            <tr>
                                <td class="t-top1" align="left"><?php echo anchor('home/job_view/'.$val['jobId'],$val['buss_name'],array('title'=>'view job details','target'=>'_blanck'));?></td>
                                <td class="t-top1" align="left"><?php echo $val['jobTitle'];?></td>
                                <td class="t-top1" align="left"><?php echo $val['jobPostDate'];?></td>
                                <td class="t-top1" align="left"><?php echo $val['jobType'];?></td>
                                <td class="t-top1" align="center">
                                   <a class="" href="#jobEdit" id="jobEdit_pop" onclick="getJob(<?php echo $val['jobId'];?>);" title="Edit job"><img src="<?php echo USER_SIDE_IMAGES.'edit.png'?>" class="imgMiddleAlign"/></a>
                                   <a class="" href="<?php echo site_url('dashboard/jobs/view_applicants/'.$val['jobId']);?>" title="View applicants"><img src="<?php echo USER_SIDE_IMAGES.'peoples.png'?>" class="imgMiddleAlign"/></a>
                                </td>
                                <!--td class="t-top1"align="center"><div class="post-right"><a class="button4" href="#jobEdit" id="jobEdit_pop" onclick="getDeal(<?php echo $val['jobId'];?>);">Edit</a></div></td-->
                            </tr>
                            <?php }?>
                        </table>
                    </div>                   






<!-- popup start   -->             
<div> <a href="#" class="overlay" id="newJob"></a>
<div class="address-popup">
    <div class="popup-title"><a class="close" href="#close"></a> </div>
    <div class="content-pop" align="center">
      <h1>Post a Job</h1>
      <h2>Fill Out Job Details</h2>
      <div class="form1">
        <?php
            $attr = array('name' => 'frmNewJob', 'id' => 'frmNewJob', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open('dashboard/jobs/new_job', $attr);
            ?>
          
          <div class="write">
            <div class="write-first"><h4>Job Details</h4>
                <label>Business Name *</label>
            </div>
            <div class="write-second">
                &nbsp;
            </div>
            <div class="clear"></div>
             <?php echo form_dropdown('jobBusinessId',__myBusinessDropdown($user_id),set_value('jobBusinessId'),'id="jobBusinessId"');?>
             <?php echo form_error('jobBusinessId'); ?>
        </div>
           <div class="clear"></div>
          
          <div class="write">
           <div class="write-first">           
           <label>Job Post Date </label>
            <input name="jobPostDate" id="jobPostDate" type="text" value="<?php echo set_value('jobPostDate');?>" readonly="true"/>
            <?php echo form_error('jobPostDate'); ?>
           </div>
           <div class="write-second">
            
           <label>Job Type</label>
           <?php echo form_dropdown('jobTypeId',__myJobTypesDropdown(),set_value('jobTypeId'),'id="jobTypeId"');?>
           <?php echo form_error('jobTypeId'); ?>
            
           </div>
           <div class="clear"></div>
            <div class="write-first">
          
           <label>Job Title </label>
            <input name="jobTitle" id="jobTitle" type="text" value="<?php echo set_value('jobTitle');?>"/>
            <?php echo form_error('jobTitle'); ?>
           </div>
           <div class="write-second">
           
           <label>Years of Experience</label>
            <input name="jobExperiance" id="jobExperiance" type="text" value="<?php echo set_value('jobExperiance');?>"/>
            <?php echo form_error('jobExperiance'); ?>
           </div>
           <div class="clear"></div>
           
           
           </div>
            <div class="clear"></div>
             <div class="write">
          <div class="write-first">
           <label>Job Description</label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobDescription" id="jobDescription" cols="" rows="6" class="top-mr"><?php echo set_value('jobDescription');?></textarea>
          <?php echo form_error('jobDescription'); ?>
          
           <div class="write">
          <div class="write-first">
           <label>Job Duties | Responsibilities</label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobDutiesAndResponsibilities" id="jobDutiesAndResponsibilities" cols="" rows="6" class="top-mr" ><?php echo set_value('jobDutiesAndResponsibilities');?></textarea>
          <?php echo form_error('jobDutiesAndResponsibilities'); ?>
          
           <div class="write">
          <div class="write-first">
           <label>Required Qualifications </label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobRequiredQualifications" id="jobRequiredQualifications" cols="" rows="6" class="top-mr" ><?php echo set_value('jobRequiredQualifications');?></textarea>
          <?php echo form_error('jobRequiredQualifications'); ?>
          
           <div class="write">
          <div class="write-first">
           <label>Desired Qualifications</label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobDesiredQualifications" id="jobDesiredQualifications" cols="" rows="6" class="top-mr"><?php echo set_value('jobDesiredQualifications');?></textarea>
          <?php echo form_error('jobDesiredQualifications'); ?>
          
          <div class="write">
           <div class="write-first"><label>Additional Information</label></div>
           <div class="write-second">&nbsp;</div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobAdditionalInformation" id="jobAdditionalInformation" cols="" rows="6" class="top-mr" ><?php echo set_value('jobAdditionalInformation');?></textarea>
          <?php echo form_error('jobAdditionalInformation'); ?>
          
          <input type="submit" id="submitNewJobForm" value="" style="display:none;"/>
          <a href="#" class="button7" onclick="javascript: return $('#submitNewJobForm').click(); return false;">POST JOB</a>
        </form>
      </div>
    </div>
  </div>
 
</div>
<!--  popup end-->
                    
                    
 <!-- popup start FOR EDIT  -->             
<div> <a href="#" class="overlay" id="jobEdit"></a>
<div class="address-popup">
    <div class="popup-title"><a class="close" href="#close"></a> </div>
    <div class="content-pop" align="center">
      <h1>Post a Job</h1>
      <h2> Fill Out Job Details</h2>
      <div class="form1">
        <?php
            $attr = array('name' => 'frmEditJob', 'id' => 'frmEditJob', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open('dashboard/jobs/edit#jobEdit', $attr);
            ?>
          <input type="hidden" name="jobId" id="EjobId" value="<?php echo set_value('jobId');?>"/>
          <div class="write">
            <div class="write-first"><h4>Job Details</h4>
                <label>Business Name *</label>
            </div>
            <div class="write-second">
                &nbsp;
            </div>
            <div class="clear"></div>
             <?php echo form_dropdown('jobBusinessId',__myBusinessDropdown($user_id),set_value('jobBusinessId'),'id="EjobBusinessId"');?>
             <?php echo form_error('jobBusinessId'); ?>
        </div>
           <div class="clear"></div>
           
          <div class="write">
           <div class="write-first">           
           <label>Job Post Date </label>
            <input name="jobPostDate" id="EjobPostDate" type="text" value="<?php echo set_value('jobPostDate');?>" readonly="true" />
            <?php echo form_error('jobPostDate'); ?>
           </div>
           <div class="write-second">            
           <label>Job Type</label>
            <?php echo form_dropdown('jobTypeId',__myJobTypesDropdown(),set_value('jobTypeId'),'id="EjobTypeId"');?>
           <?php echo form_error('jobTypeId'); ?>
           </div>
           <div class="clear"></div>
            <div class="write-first">
          
           <label>Job Title </label>
            <input name="jobTitle" id="EjobTitle" type="text" value="<?php echo set_value('jobTitle');?>"/>
            <?php echo form_error('jobTitle'); ?>
           </div>
           <div class="write-second">
           
           <label>Years of Experience</label>
            <input name="jobExperiance" id="EjobExperiance" type="text" value="<?php echo set_value('jobExperiance');?>"/>
            <?php echo form_error('jobExperiance'); ?>
           </div>
           <div class="clear"></div>
           
           
           </div>
            <div class="clear"></div>
             <div class="write">
          <div class="write-first">
           <label>Job Description</label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobDescription" id="EjobDescription" cols="" rows="6" class="top-mr"><?php echo set_value('jobDescription');?></textarea>
          <?php echo form_error('jobDescription'); ?>
          
           <div class="write">
          <div class="write-first">
           <label>Job Duties | Responsibilities</label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobDutiesAndResponsibilities" id="EjobDutiesAndResponsibilities" cols="" rows="6" class="top-mr" ><?php echo set_value('jobDutiesAndResponsibilities');?></textarea>
          <?php echo form_error('jobDutiesAndResponsibilities'); ?>
          
           <div class="write">
          <div class="write-first">
           <label>Required Qualifications </label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobRequiredQualifications" id="EjobRequiredQualifications" cols="" rows="6" class="top-mr" ><?php echo set_value('jobRequiredQualifications');?></textarea>
          <?php echo form_error('jobRequiredQualifications'); ?>
          
           <div class="write">
          <div class="write-first">
           <label>Desired Qualifications</label>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobDesiredQualifications" id="EjobDesiredQualifications" cols="" rows="6" class="top-mr"><?php echo set_value('jobDesiredQualifications');?></textarea>
          <?php echo form_error('jobDesiredQualifications'); ?>
          
          <div class="write">
           <div class="write-first"><label>Additional Information</label></div>
           <div class="write-second">&nbsp;</div>
           <div class="clear"></div>
          </div>
        
          <textarea name="jobAdditionalInformation" id="EjobAdditionalInformation" cols="" rows="6" class="top-mr" ><?php echo set_value('jobAdditionalInformation');?></textarea>
          <?php echo form_error('jobAdditionalInformation'); ?>
          <input type="submit" id="submitEditJobForm" value="" style="display:none;"/>
          <a href="#" class="button7" onclick="javascript: return $('#submitEditJobForm').click(); return false;">POST JOB</a>
        </form>
      </div>
    </div>
  </div>
 
</div>
<!--  popup end-->                 








                </div>




            </section></div>






    </div>
</div>