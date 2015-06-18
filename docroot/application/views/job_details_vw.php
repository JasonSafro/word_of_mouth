<?php
echo css_asset("address-popup.css");
?>
<?php //echo css_asset("selectbox.css");?>
<!-- script src="<?php echo base_url()?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script -->

<?php //echo js_asset("jquery.min.js");?>
<?php echo js_asset("jquery-1.8.3.min.js");?>



<?php //echo js_asset("jquery.selectbox-0.5.js");?>
<?php echo js_asset("jquery.maskedinput-1.3.js");?>
<script type="text/javascript">
  //store_phone phone_number
 
    jQuery(function($){
        $("#jAppApplicantPhone").mask("999-999-9999");        
    }); 
</script> 


<div id="page-wrap">
    <?php $info=$jobList[0];?>
    <?php $companyInfo=$companyInfo[0];?>
    <div id="main1">
          <section class="inside-title">
          <div class="inside-title-in"><div  id="main">
          <h1> Jobs</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="index.html">Home</a> |  <?php echo anchor('home/business_details/'.$companyInfo['buss_id'],$companyInfo['buss_name']);?> | Jobs</div></div>
          </div>
          </section>
        </div>
      <div id="section">
      
        <section id="main">
        <article class="section-deals">
            <?php echo $this->load->view('success_error_message_area');?>
             <div class="blank">
              <?php echo anchor('home/business_details/'.$info['jobBusinessId'],'<h1>'.$info['buss_name'].' Jobs</h1>');?>
            </div>
            <div class="deal-box2"> 
            
            <div class="deal-box-left">
            <div class="full-des">
                <?php //$businessImageUrl=$companyInfo['buss_logo'] jobUserId?>
                <?php $businessImageUrl =base_url().'LOGO/'.$companyInfo['buss_logo']; ?>
                <?php //$businessImageUrl=USER_SIDE_IMAGES."ntb1.jpg";?>
                  <h1><?php echo $info['jobTitle'];?> <br/>
                    <span><?php echo $companyInfo['buss_city'].' - '.$companyInfo['buss_address'] ?></span></h1>
                  <div class="sahre-deal">
                    <label>Share This Job:</label>
                        <ul>
                            <li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo $info['jobTitle']; ?>&amp;p[images][0]=<?php echo $businessImageUrl; ?>&amp;p[summary]=<?php echo $info['jobDescription']; ?>&amp;p[url]=<?php echo urlencode(current_url()); ?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)">
                            <img src="<?php echo USER_SIDE_IMAGES;?>h2.png" alt="fb"/>
                            </a></li>

                            <li><a href="https://twitter.com/share?url=<?php echo urlencode(current_url()); ?>" data-url="<?php echo urlencode(current_url());?>" data-text="<?php echo $info['jobTitle']; ?>" data-count="none" target="_blank">
                            <img src="<?php echo USER_SIDE_IMAGES;?>h1.png" alt="twitter"/>
                            </a></li>


                            <li><a class="pin-it-button" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(current_url()); ?>&amp;media=<?php echo $businessImageUrl;?>&amp;description=<?php echo $info['jobDescription']; ?>" target="_blank">
                            <img src="<?php echo USER_SIDE_IMAGES;?>h3.png" alt="printrest"/>
                            </a></li> 

                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(current_url()); ?>" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png" alt="linkedin"/></a></li>
                        </ul>
                  </div>
                </div>
            
            </div>
                <?php 
                    $userId=$this->session->userdata('user_id');
                    
                ?>
             <div class="deal-box-right"> <img src="<?php echo $businessImageUrl;?>" width="120" /><br> <div class="applynow">
            <a href="#address10" id="address_pop" <?php if ($this->session->userdata('user_id')==''){?> onclick="javascript: alert('Please login to apply this job.'); return false;" <?php }elseif($userId!='' && _isRecordExist('tbl_job_applications',array('jAppJobId'=>$info['jobId'],'jAppApplicantUserId'=>$userId))){?> onclick="javascript: alert('You have already applied for this job.'); return false;" <?php }?>><img src="<?php echo USER_SIDE_IMAGES;?>apply.png"></a>
<!--/*======================== popup start*=====================================*/ -->

 <div>
            <a href="#" class="overlay" id="address10"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a></div>
            <div class="content-pop" align="center">   
            
            <h1>Apply Today </h1>
           <h2> You will be contacted within 24 hours</h2>
           
             <div class="form1">
                 
            <?php //echo validation_errors(); ?>
             <?php
            $attr = array('name' => 'frmNewJobApplication', 'id' => 'frmNewJobApplication', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open_multipart('home/apply_today/'.$info['jobId'].'#address10', $attr);
            ?>
            <div class="write">
           <div class="write-first">
           <h4>Your Information</h4>
           
           <label>Full Name * </label>
            <input name="jAppApplicantFullName" id="jAppApplicantFullName" type="text" value="<?php echo set_value('jAppApplicantFullName', $jAppApplicantFullName); ?>"/>
            <?php echo form_error('jAppApplicantFullName');?>
           </div>
           <div class="write-second">
            <h4>&nbsp;</h4>
           <label>Address *</label>
            <input name="jAppApplicantAddress" id="jAppApplicantAddress" type="text" value="<?php echo set_value('jAppApplicantAddress', $jAppApplicantAddress); ?>"/>
            <?php echo form_error('jAppApplicantAddress');?>
           </div>
           <div class="clear"></div>
            <div class="write-first">
          
           <label>City *</label>
            <input name="jAppApplicantCity" id="jAppApplicantCity" type="text" value="<?php echo set_value('jAppApplicantCity', $jAppApplicantCity); ?>"/>
            <?php echo form_error('jAppApplicantCity');?>
           </div>
           <div class="write-second">
           
           <label>State *</label>
            <input name="jAppApplicantState" id="jAppApplicantState" type="text" value="<?php echo set_value('jAppApplicantState', $jAppApplicantState); ?>"/>
            <?php echo form_error('jAppApplicantState');?>
           </div>
           <div class="clear"></div>
            <div class="write-first">
           
           <label>Zip Code *</label>
            <input name="jAppApplicantZipCode" id="jAppApplicantAddress" type="text" value="<?php echo set_value('jAppApplicantZipCode', $jAppApplicantZipCode); ?>"/>
            <?php echo form_error('jAppApplicantZipCode');?>
           </div>
           
           <div class="write-second">           
           <label>Phone *</label>
            <input name="jAppApplicantPhone" id="jAppApplicantPhone" type="text" value="<?php echo set_value('jAppApplicantPhone', $jAppApplicantPhone); ?>"/>
            <?php echo form_error('jAppApplicantPhone');?>
           </div>
           
           <div class="clear"></div>
           
            <div class="write-first">          
                <label>Fax </label>
                <input name="jAppApplicantFax" id="jAppApplicantFax" type="text" value="<?php echo set_value('jAppApplicantFax', $jAppApplicantFax); ?>"/>
                <?php echo form_error('jAppApplicantFax');?>
            </div>
           
           <div class="write-second">          
                <label>Contact Email Address *</label>
                <input name="jAppApplicantEmail" id="jAppApplicantEmail" type="text" value="<?php echo set_value('jAppApplicantEmail', $jAppApplicantEmail); ?>"/>

                <?php echo form_error('jAppApplicantEmail');?>
           </div>
           <div class="clear"></div>
           </div>
              
                 
           <div class="write-review3 sip">
                  <input type="button" class="custom_resume red" value="UPLOAD RESUME"/>
				  <input type="file" class="multi hide" name="jAppApplicantResume_new" id="jAppApplicantResume_new" accept="pdf|PDF|doc|DOC|docx|DOCx" maxlen="1"/>                   
                   <?php echo form_error('jAppApplicantResume'); ?>
               </div>
           
           <div class="write-review3 sip">
                  <input type="button" class="custom_letter red" value="UPLOAD COVER LETTER"/><input type="file" class="multi hide" name="jAppApplicantCoverLetter" id="jAppApplicantCoverLetter" accept="pdf|PDF|doc|DOC|docx|DOCx" maxlen="1"/>                   
                   <?php echo form_error('jAppApplicantCoverLetter'); ?>
               </div>
           <!--<div class="write-review2">
               <a onclick="javascript: $('#jAppApplicantCoverLetter').click();"><img src="<?php echo USER_SIDE_IMAGES;?>letter.png"> UPLOAD COVER LETTER</a>
               <input  style="display:none;" name="jAppApplicantCoverLetter" id="jAppApplicantCoverLetter" type="file"/>
               <?php echo form_error('jAppApplicantCoverLetter');?>
           </div>-->
           <div class="post-right"><a href="#" onclick="javascript: $('#submitApplicationForm').click(); return false;">  <img src="<?php echo USER_SIDE_IMAGES;?>submit3.png"/></a></div>
           <input id="submitApplicationForm" type="submit" value="" style="display:none;"/>
            </form>
            </div>
            
               </div>
            </div>
</div>





           <!--first popup------------
           
           <div>
            <a href="#" class="overlay" id="address10"></a>
            <div class="address-popup">
            <div class="popup-title"><a class="close" href="#close"></a> </div>
            <div class="content-pop" align="center">   
            
            <h1>Apply Today </h1>
           <h2> You will be contacted within 24 hours</h2>
             <div class="form1">
            <form action="" method="get">
             <input name="" type="text" value="Enter Your Full Name" class="reviewer" onFocus="if(this.value=='Enter Your Full Name')this.value=''" onBlur="if(this.value=='')this.value='Enter Your Full Name'">
              <input name="" type="text" value="Enter Your Email Address" class="email" onFocus="if(this.value=='Enter Your Email Address')this.value=''" onBlur="if(this.value=='')this.value='Enter Your Email Address'">
              
            <input name="" type="text" value="Enter Your Address" class="home" onFocus="if(this.value=='Enter Your Address')this.value=''" onBlur="if(this.value=='')this.value='Enter Your Address'">
            
            
             
              <input name="" type="text" value="Enter Your Phone Number" class="cellphone" onFocus="if(this.value=='Enter Your Phone Number')this.value=''" onBlur="if(this.value=='')this.value='Enter Your Phone Number'">
              

           <div class="post-right"><a href="#">  <img src="<?php echo USER_SIDE_IMAGES;?>submit3.png"></a></div>
           <div class="write-review2"><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>resume.png"> UPLOAD RESUME</a></div>
           <div class="write-review2">
<a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>letter.png"> UPLOAD COVER LETTER</a></div>

            </form>
            </div>
            
               </div>
            </div>
            </div>-->
            <!--/*======================== popup end*=====================================*/--></div></div>
            
            </div>
          <article class="section-left">
          
          
            <div class="clear"></div>
           <div class="overviews1">
                  <h1>Job Description</h1>
                  <p><?php echo nl2br($info['jobDescription']);?></p><br><br>
                 <h1> Job Duties | Responsibilities may include, but are not limited to:</h1>
                  <p><?php echo nl2br($info['jobDutiesAndResponsibilities']);?></p><br/><br/>
                 <h1> Required Qualifications:</h1>
              <div class="left-bullets">
                  <p><?php echo nl2br($info['jobRequiredQualifications']);?></p>
                  <br><br>
                  
                  <h1>Desired Qualifications:</h1>
                <p> <?php echo nl2br($info['jobDesiredQualifications']);?></p>
<br><br>
<h1>Additional Information:</h1>
 <p> <?php echo nl2br($info['jobAdditionalInformation']);?></p>
 <br><br>
<p>Posted: <strong> <?php echo $info['jobPostDate'];?></strong><br>
Type:<strong> <?php echo $info['jobType'];?></strong><br>
Experience: <strong><?php echo $info['jobExperiance'];?></strong><br>
<!--Functions: <strong>Engineering</strong><br>
Industries: <strong>Automobile, Technology</strong>-->
</p>

<br><br>
<a href="#address10" id="address_pop" <?php if ($this->session->userdata('user_id')==''){?> onclick="javascript: alert('Please login to apply this job.'); return false;" <?php }elseif($userId!='' && _isRecordExist('tbl_job_applications',array('jAppJobId'=>$info['jobId'],'jAppApplicantUserId'=>$userId))){?> onclick="javascript: alert('You have already applied for this job.'); return false;" <?php }?>><img src="<?php echo USER_SIDE_IMAGES;?>apply.png"></a>
                  </div>
                </div>
          </article>
          <article class="section-right" style="position:relative;">
            
            <?php if(count($simillerJobs)>0){?>
            <div class="deals-three-n">
              <h1>View More Similar Jobs <?php //print_r($simillerJobs); ?></h1>
              <div id="p-selectone" class="glidecontenttoggler pageCounter" >              
                <?php //echo 'LoopCount:'.$loopCount.' JObs:'.count($jobList);
                
                 if(count($simillerJobs)>0){
                      for($i=1;$i<=ceil(count($simillerJobs)/5);$i++)
                      {                      
                          echo anchor('#','Job Page '.$i,array('class'=>'toc'));
                      }
                 }
                  ?>
                
              </div>
              <div class="deal-listing top-mar">
                  <div id="canadaprovincesnewone" class="glidecontentwrapperone">
                  <?php $loopCount=1; ?>  
                  <?php if(!empty($simillerJobs)){?>   
                    <div class="glidecontent">
                    <div class="deals-p">
                    <?php // echo $simillerJobs[0]['jobPostDate']."  ".date('Y-m-d'); ?>
                      <ul>
                    <?php 
                    $cnt=0;                    
                    $jobDivNotClosed=false;
                    foreach($simillerJobs as $key=>$val){
					$today = date('Y-m-d');
					if(strtotime($val['jobPostDate']) <= strtotime($today)){
					?>
                  
                        <li>
                          <div class="text-deal"><?php echo anchor('home/job_view/'.$val['jobId'],$val['jobTitle']);?><br/>
                            <span>Posted: <?php echo date('F j, Y', strtotime($val['jobCreatedOn']));?></span></div>
                          <div class="view-orange"><?php echo anchor('home/job_view/'.$val['jobId'],'VIEW');?></div>
                          <div class="clear"></div>
                        </li>
                        
                        <?php 
                        $cnt++;
                        if($cnt%5==0){
                        ?>
                             </ul>
                        </div>
                      </div>
                    
                    <div class="glidecontent">
                    <div class="deals-p">
                      <ul>
                        <?php }else{
                            $jobDivNotClosed=true;
                        }
                        ?>
                      
                <?php  }
				
		}//closed for each
                
                if($jobDivNotClosed==true)
                {$loopCount++;
                    ?>   
                      </ul>
                    </div>
                  </div>
                <?php }?>    
                   
              <?php }//close empry if?>
                  
                </div>
                <!--<div id="canadaprovincesnewone" class="glidecontentwrapperone">
                  <div class="glidecontent">
                    <div class="deals-p">
                      <ul>
                        <li>
                          <div class="text-deal"><a href="#">Store Manager</a><br/>
                            <span>Posted: 3-19-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">Service Manager</a><br/>
                            <span>Posted: 3-31-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">President of Sales<br>
                            & Technician Consultant</a><br/>
                            <span>Posted:4-05-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">Service Engineer <br>
                            & Senior Technician</a><br/>
                            <span>Posted: 4-25-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">Direcor of Technology <br>
                            & Lead Shop Manager</a><br/>
                            <span>Posted: 5-07-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                      </ul>
                    </div>
                      
                      
                      
                  </div>
                    
                    <div class="glidecontent">
                    <div class="deals-p">
                      <ul>
                        <li>
                          <div class="text-deal"><a href="#">001</a><br/>
                            <span>Posted: 3-19-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">002 Manager</a><br/>
                            <span>Posted: 3-31-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">003 of Sales<br>
                            & Technician Consultant</a><br/>
                            <span>Posted:4-05-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">004 Engineer <br>
                            & Senior Technician</a><br/>
                            <span>Posted: 4-25-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                        <li>
                          <div class="text-deal"><a href="#">0005 of Technology <br>
                            & Lead Shop Manager</a><br/>
                            <span>Posted: 5-07-13</span></div>
                          <div class="view-orange"><a href="#">VIEW</a></div>
                          <div class="clear"></div>
                        </li>
                      </ul>
                    </div>
                      
                      
                      
                  </div>
                  
                  
                  
                </div>-->
              </div>
              
              
            </div>
            <?php }?>
            <div class="right-cont">
             <h1>Company Description</h1>
                  <p><?php echo nl2br($companyInfo['buss_description']);?></p>
</div>
          </article>
          <div class="clear"></div>
        </section>
      </div>
    </div>

<script>
$('#jAppApplicantResume').on( 'change', function() {
   myfile= $( this ).val();
   var ext = myfile.split('.').pop();
   if(ext1!="pdf" || ext!="docx" || ext!="doc"){
       alert('Please upload only (.doc,.pdf) file.');
   }
});
</script>
<?php echo js_asset("featuredcontentglider.js");?>
<script type="text/javascript">

featuredcontentglider.init({
	gliderid: "canadaprovincesnewone", //ID of main glider container
	contentclass: "glidecontent", //Shared CSS class name of each glider content
	togglerid: "p-selectone", //ID of toggler container
	remotecontent: "", //Get gliding contents from external file on server? "filename" or "" to disable
	selected: 0, //Default selected content index (0=1st)
	persiststate: false, //Remember last content shown within browser session (true/false)?
	speed: 500, //Glide animation duration (in milliseconds)
	direction: "rightleft", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
	autorotate: true, //Auto rotate contents (true/false)?
	autorotateconfig: [3000, 2], //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
	onChange: function(previndex, curindex, $allcontents){ // fires when Glider changes slides
  		//custom code here
	}
})

</script>
