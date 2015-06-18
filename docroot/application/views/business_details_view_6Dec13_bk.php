<?php
echo css_asset("address-popup.css");
?>
<?php echo css_asset("selectbox.css");?>
<!-- script src="<?php echo base_url()?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script -->

<?php echo js_asset("jquery.min.js");?>
<?php echo js_asset("jquery.selectbox-0.5.js");?>
	<script type="text/javascript">
	$.noConflict();
	(document).ready(function() {
		$('.items').selectbox();
	});
	</script>


    <div id="page-wrap">
      <div id="main1">
        <section class="inside-title">
          <div class="inside-title-in">
            <div  id="main">
              <h1><?php echo $buss_category; ?>  | <?php echo $info['buss_name']; ?>  </h1>
              <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>dashboard/business_details">Home</a> |  <?php echo $buss_category; ?> | <?php echo $info['buss_name']; ?></div>
            </div>
          </div>
        </section>
      </div>
      <div id="section">
        <section id="main">
          <article class="section-deals">
            <div class="blank">
              <h1><?php echo $buss_category; ?>  | <?php echo $info['buss_name']; ?>  </h1>
            </div>
            <!--<div class="search">
              <input name="Search" type="text"  value="Cannot find your provider type? Search for your" onblur="if(this.value=='')this.value='Cannot find your provider type? Search for your';" onfocus="if(this.value=='Cannot find your provider type? Search for your')this.value='';"/>
            </div>-->
            <?php //if(count($fav_Info)!=0){?>
<!--            <div class="fav" id="fav"><a><img src="<?php //echo USER_SIDE_IMAGES;?>favou.png" > Favourite</a></div>
-->            <?php //}else{?>
            <div class="addfav" id="addfav"><a  id="add_favor" href="#" onclick="add_into_fav('<?php echo $bus_id;?>','<?php echo $info['user_id'];?>');"><img src="<?php echo USER_SIDE_IMAGES;?>add-favou.png"  id="favorite"> <span id="txt">Add To Favourite</span></a></div><?php// }?>
            
            <div class="deal-box"> </div>
            <div class="ntb-main1">
              <div class="ntb">
                <div class="miles11">(2.1 Miles)</div>
                <div class="ratel1">
                  <ul class="rating nostar">
                    <li class="one"><a href="#" title="1 Star">1</a></li>
                    <li class="two"><a href="#" title="2 Stars">2</a></li>
                    <li class="three"><a href="#" title="3 Stars">3</a></li>
                    <li class="four"><a href="#" title="4 Stars">4</a></li>
                    <li class="five"><a href="#" title="5 Stars">5</a></li>
                  </ul>
                </div>
                <img src="<?php echo base_url()?>LOGO/<?php echo "/".$info['buss_logo']; ?>">
                <div class="over-add">
                    <div class="address"><br><br/>
                      Address: <?php echo $info['buss_address']; ?>,<?php echo $info['buss_addr_addon']; ?>,<?php echo $info['buss_city']; ?><br/>
                      Phone: <?php echo $info['buss_phone']; ?></div>
                    
                    <div class="directions"><a href="#">Get Directions Today</a>&nbsp;&nbsp; | &nbsp;&nbsp; <a href="#">Company Website</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="#">Facebook Page</a></div>
                  </div>
                </div>
              <div class="ntbr">
                <div class="full-des">
                  <h2><?php echo $info['buss_name']; ?> | <?php echo $info['buss_address']; ?>,<?php echo $info['buss_city']; ?><br/>
                  <span><?php echo $info['buss_tag_line'];?> </span></h2>
                  <p><?php echo $info['buss_description'];?></p>
                  <br><br><br><br>
                <div class="book"> <img src="<?php echo USER_SIDE_IMAGES;?>down-load.png"> Business License Certification </div>
                <div class="write-review2"><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>down-l.png"> Download</a></div>
                <div class="write-review2"><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>review.png"> Review</a></div>
                </div>
              </div>
            </div>
            <div class="ntb-main1">
              <div class="ntb">
              <h1>Location & Information</h1><br>
               <div id="googleMap" class="gmap"></div></div>
              <div class="ntbr">
              <h1>View Photos & Videos</h1><br>
                 <!-- iframe  height="317" src="http://www.youtube.com/embed/wN3gueLT0D8?showinfo=0" frameborder="0" allowfullscreen></iframe -->
              </div>
            </div>
            <div class="deals-one">
              <h1>Deals</h1>
              <div class="deal-listing">
                <div id="canadaprovinces" class="glidecontentwrapperone">
                 <?php if(!empty($dealList)){?>   
                    <div class="glidecontent">
                    <div class="deals-p">
                      <ul>
                    <?php 
                    $cnt=0;
                    $loopCount=1;
                    $dealDivNotClosed=false;
                    foreach($dealList as $key=>$val){?>
                  
                        <li>
                          <div class="text-deal"><?php echo anchor('deals_and_coupons/view/'.$val['dealId'],substr(nl2br($val['dealOverview']),0,100));?><br/>
                            <span>Expries: <?php echo date('F j, Y', strtotime($val['dealExpirationDate']));?></span></div>
                          <div class="view-green"><?php echo anchor('deals_and_coupons/view/'.$val['dealId'],'VIEW');?></div>
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
                            $dealDivNotClosed=true;
                        }
                        ?>
                      
                <?php  }//closed for each
                
                if($dealDivNotClosed==true)
                {$loopCount++;
                    ?>   
                      </ul>
                    </div>
                  </div>
                <?php }?>    
                   
              <?php }//close empry if?>
                 
                </div>
                <div id="p-selectone" class="glidecontenttoggler pageCounter">
                  <!--<a href="#" class="prev">Prev</a> -->
                  <?php 
                  for($i=1;$i<=$loopCount;$i++)
                  {
                      echo anchor('#','Page '.$i,array('class'=>'toc'));
                  }
                  ?>
                  <!--<a href="#" class="toc">Page 1</a> <a href="#" class="toc">Page 2</a> <a href="#" class="toc">Page 3</a> <a href="#" class="toc">Page 4</a>-->
                  <!--<a href="#" class="next">Next</a>-->
                </div>
              </div>
            </div>
            <div class="deals-two">
              <h1>Reviews</h1>
              <div class="rating-text">
                <div id="canadaprovincesmid" class="glidecontentwrappertwo">
                    
                    <?php if(!empty($reviewList)){?>   
                    <div class="glidecontent">
                    <div class="deals-p">
                      <ul>
                    <?php 
                    $cnt=0;
                    $loopCount=1;
                    $dealDivNotClosed=false;
                    $ratingsArray=array(''=>'onestar','2'=>'twostar','3'=>'threestar','4'=>'fourstar','5'=>'fivestar');
                    foreach($reviewList as $key=>$val){?>
                  
                       <div class="rating-main">
                            <div class="rating-view"><img src="<?php echo USER_SIDE_IMAGES;?>steve.jpg"  alt="steve">
                              <h2><?php echo anchor('home/review_details/'.$val['rvwId'],$val['rvwReviewerName']);?><span><?php echo $val['buss_city'].','.$val['buss_addr_addon']?></span></h2>
                            </div>
                            <div class="rate-date">
                              <p> <?php echo date('F j, Y', strtotime($val['rvwCreatedOn']));?></p>
                              <ul class="rating <?php echo $ratingsArray[$val['rvwRatingOverall']]?>">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                           <div class="rate-dis"><?php echo substr(nl2br($val['rvwDetails']),0,200);?></div>
                          </div>
                          <div class="clear"></div>
                        
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
                            $dealDivNotClosed=true;
                        }
                        ?>
                      
                <?php  }//closed for each
                
                if($dealDivNotClosed==true)
                { $loopCount++;?>   
                      </ul>
                    </div>
                  </div>
                <?php }?>    
                   
              <?php }//close empry if?>
                
                </div>
                <div id="p-selectone2" class="glidecontenttoggler pageCounter">
                  <!--<a href="#" class="prev">Prev</a> -->
                   <?php 
                  for($i=1;$i<=$loopCount;$i++)
                  {
                      echo anchor('#','Page '.$i,array('class'=>'toc'));
                  }
                  ?>
                  <!--<a href="#" class="toc">Page 1</a> <a href="#" class="toc">Page 2</a> <a href="#" class="toc">Page 3</a> <a href="#" class="toc">Page 4</a>-->
                  <!--<a href="#" class="next">Next</a>-->
                </div>
                <div class="deals-p">
                  <div class="write-review"><a href="#address15" id="address_pop">WRITE A REVIEW</a></div>
                </div>
              </div>
            </div>
            <div class="deals-three">
              <h1>Jobs</h1>
              <div class="deal-listing">
                <div id="canadaprovincesnewone" class="glidecontentwrapperone">
                    <?php if(!empty($jobList)){?>   
                    <div class="glidecontent">
                    <div class="deals-p">
                      <ul>
                    <?php 
                    $cnt=0;
                    $loopCount=1;
                    $jobDivNotClosed=false;
                    foreach($jobList as $key=>$val){?>
                  
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
                      
                <?php  }//closed for each
                
                if($jobDivNotClosed==true)
                {$loopCount++;
                    ?>   
                      </ul>
                    </div>
                  </div>
                <?php }?>    
                   
              <?php }//close empry if?>
                  
                </div>
              </div>
              <div id="p-selectone3" class="glidecontenttoggler pageCounter">
                <!--<a href="#" class="prev">Prev</a> -->
                 <?php 
                  for($i=1;$i<=$loopCount;$i++)
                  {
                      echo anchor('#','Page '.$i,array('class'=>'toc'));
                  }
                  ?>
                <!-- <a href="#" class="toc">Page 1</a> <a href="#" class="toc">Page 2</a> <a href="#" class="toc">Page 3</a> <a href="#" class="toc">Page 4</a> -->
                <!--<a href="#" class="next">Next</a>-->
              </div>
            </div>
          </article>
          <div class="clear"></div>
        </section>
      </div>
    </div>
 <!-- first step------------->
  <div> <a href="#" class="overlay" id="address15"></a>
  <div class="address-popup">
    <div class="popup-title"><a class="close" href="#close"></a> </div>
    <div class="content-pop" align="center">
      <h1>Write a Review </h1>
      <h2> Your submission will go live within 24 hours following Verification</h2>
      <div class="form1">
        <?php
            $attr = array('name' => 'frmBusinessReview', 'id' => 'frmBusinessReview', 'autocomplete' => 'off', 'method' => 'post');
            echo form_open('home/add_business_review/'.$businessId.'#address15', $attr);
            ?>
          <!--input name="rvwBusinessId" id="rvwBusinessId" type="text" value="Enter Business Name To Be Reviewed" class="business" onFocus="if(this.value=='Enter Business Name To Be Reviewed')this.value=''" onBlur="if(this.value=='')this.value='Enter Business Name To Be Reviewed'"/-->
          <input name="rvwBusinessId" id="rvwBusinessId" type="text" value="<?php echo $info['buss_name'];?>" class="business" readonly="readonly"/>
          <?php echo form_error('rvwBusinessId');?>
          <input name="rvwReviewerName" id="rvwReviewerName" type="text" value="<?php echo set_value('rvwReviewerName', $rvwReviewerName); ?>" class="reviewer" onFocus="if(this.value=='Enter Reviewer Contact Name')this.value=''" onBlur="if(this.value=='')this.value='Enter Reviewer Contact Name'"/>
          <?php echo form_error('rvwReviewerName');?>
          <input name="rvwPhoneNo" id="rvwPhoneNo" type="text" value="<?php echo set_value('rvwPhoneNo', $rvwPhoneNo); ?>" class="cellphone" onFocus="if(this.value=='Enter Your Phone Number')this.value=''" onBlur="if(this.value=='')this.value='Enter Your Phone Number'"/>
          <?php echo form_error('rvwPhoneNo');?>
          <input name="rvwEmail" id="rvwEmail" type="text" value="<?php echo set_value('rvwEmail', $rvwEmail); ?>" class="email" onFocus="if(this.value=='Enter Reviewer Email Address')this.value=''" onBlur="if(this.value=='')this.value='Enter Reviewer Email Address'"/>
          <?php echo form_error('rvwEmail');?>
          <input name="rvwCategoryId" id="rvwCategoryId" class="detail" type="text" value="<?php echo $buss_category;?>" class="business" readonly="readonly"/>
          <?php echo form_error('rvwCategoryId');?>
          <!--<select name="rvwCategoryId" id="rvwCategoryId" class="items">
            <option>Choose Reviewer Business Category</option>
          </select>-->
          <div class="pop-box">
            <div class="pop-box-title">Professionalism</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="rvwRatingProfessionalism" type="radio" value="5" <?php echo set_radio('rvwRatingProfessionalism', '5'); ?>/>              
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="rvwRatingProfessionalism" type="radio" value="4" <?php echo set_radio('rvwRatingProfessionalism', '4'); ?>/>             
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="rvwRatingProfessionalism" type="radio" value="3" <?php echo set_radio('rvwRatingProfessionalism', '3'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="rvwRatingProfessionalism" type="radio" value="2" <?php echo set_radio('rvwRatingProfessionalism', '2'); ?>/>              
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="rvwRatingProfessionalism" type="radio" value="1" <?php echo set_radio('rvwRatingProfessionalism', '1'); ?>/>             
            </div>
            <div class="clear"></div>
             <?php echo form_error('rvwRatingProfessionalism');?>
          </div>
          <div class="pop-box">
            <div class="pop-box-title">Dependability</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="rvwRatingDependability" type="radio" value="5" <?php echo set_radio('rvwRatingDependability', '5'); ?>/>             
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="rvwRatingDependability" type="radio" value="4" <?php echo set_radio('rvwRatingDependability', '4'); ?>/>              
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
             <input name="rvwRatingDependability" type="radio" value="3" <?php echo set_radio('rvwRatingDependability', '3'); ?>/>            
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="rvwRatingDependability" type="radio" value="2" <?php echo set_radio('rvwRatingDependability', '2'); ?>/>              
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="rvwRatingDependability" type="radio" value="1" <?php echo set_radio('rvwRatingDependability', '1'); ?>/>             
            </div>
            <div class="clear"></div>
            <?php echo form_error('rvwRatingDependability');?>
          </div>
          <div class="pop-box">
            <div class="pop-box-title">Price</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="rvwRatingPrice" type="radio" value="5" <?php echo set_radio('rvwRatingPrice', '5'); ?>/>              
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="rvwRatingPrice" type="radio" value="4" <?php echo set_radio('rvwRatingPrice', '4'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="rvwRatingPrice" type="radio" value="3" <?php echo set_radio('rvwRatingPrice', '3'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="rvwRatingPrice" type="radio" value="2" <?php echo set_radio('rvwRatingPrice', '2'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="rvwRatingPrice" type="radio" value="1" <?php echo set_radio('rvwRatingPrice', '1'); ?>/>
            </div>
            <div class="clear"></div>
            <?php echo form_error('rvwRatingPrice'); ?>
          </div>
          <div class="pop-box last">
            <div class="pop-box-title">Overall</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="rvwRatingOverall" type="radio" value="5" <?php echo set_radio('rvwRatingOverall', '5'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="rvwRatingOverall" type="radio" value="4" <?php echo set_radio('rvwRatingOverall', '4'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="rvwRatingOverall" type="radio" value="3" <?php echo set_radio('rvwRatingOverall', '3'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="rvwRatingOverall" type="radio" value="2" <?php echo set_radio('rvwRatingOverall', '2'); ?>/>
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="rvwRatingOverall" type="radio" value="1" <?php echo set_radio('rvwRatingOverall', '1'); ?>/>
            </div>
            <div class="clear"></div>
            <?php echo form_error('rvwRatingOverall'); ?>
          </div>
          <div class="clear"></div>
          <label>
          <h3>Tell us about your experience</h3>
          </label>
          <textarea name="rvwDetails" id="rvwDetails" cols="" rows="6" onFocus="if(this.value=='Write your experience here')this.value=''" onBlur="if(this.value=='')this.value='Write your experience here'"><?php echo set_value('rvwDetails', $rvwDetails); ?></textarea>
          <?php echo form_error('rvwDetails'); ?>
          <input type="submit" id="submitBusinessReview" value="" style="display:none;"/>
          <div class="post-right"><a href="#" class="button5" onclick="javascript: $('#submitBusinessReview').click(); return false;">SUBMIT <img src="<?php echo USER_SIDE_IMAGES;?>submit2.png"></a></div>
        </form>
      </div>
    </div>
  </div>
  </div>
<div> <a href="#" class="overlay" id="address10"></a>
<div class="address-popup">
    <div class="popup-title"><a class="close" href="#close"></a> </div>
    <div class="content-pop" align="center">
      <h1>Write a Review </h1>
      <h2> Your submission will go live within 24 hours</h2>
      <div class="form1">
        <form action="" method="get">
          <div class="write">
           <div class="write-first">
           <h4>Business Review Information</h4>
           <label>Name </label>
            <input name="" type="text" value="">
           </div>
           <div class="write-second">
            <h4>&nbsp;</h4>
           <label>Address</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="write-first">
          
           <label>City </label>
            <input name="" type="text" value="">
           </div>
           <div class="write-second">
           
           <label>State</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="write-first">
           
           <label>Zip Code </label>
            <input name="" type="text" value="">
           </div>
           <div class="write-second">
           
           <label>Phone Number</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="write-first">
          
           <label>Fax </label>
            <input name="" type="text" value="">
           </div>
           <div class="write-second">
          
           <label>Email Address</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="write-first">
           <h4>Reviewer Information</h4>
           <label>Your Name </label>
            <input name="" type="text" value="">
           </div>
           <div class="write-second">
            <h4>&nbsp;</h4>
           <label>Your Email Address</label>
            <input name="" type="text" value="">
           </div>
           <div class="clear"></div>
            <div class="write-first">
             <h4>Business Rating</h4>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
           </div>
         
          <div class="pop-box">
            <div class="pop-box-title">Professionalism</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
          </div>
          <div class="pop-box">
            <div class="pop-box-title">Dependability</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
          </div>
          <div class="pop-box">
            <div class="pop-box-title">Price</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
          </div>
          <div class="pop-box last">
            <div class="pop-box-title">Overall</div>
            <div class="clear"></div>
            <div class="pop-box1"> Excellent</div>
            <div class="pop-box2">10+</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Good</div>
            <div class="pop-box2">8-10</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Average</div>
            <div class="pop-box2">5-7</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Poor</div>
            <div class="pop-box2">3-4</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
            <div class="pop-box1"> Awful</div>
            <div class="pop-box2">0-2</div>
            <div class="pop-box3">
              <input name="" type="checkbox" value="">
            </div>
            <div class="clear"></div>
          </div>
          <div class="clear"></div>
          <div class="write">
          <div class="write-first">
           <h4>Your Experience</h4>
           </div>
           <div class="write-second">
          &nbsp;
           </div>
           <div class="clear"></div>
          </div>
        
          <textarea name="" cols="" rows="6" class="top-mr" onFocus="if(this.value=='Write your experience here')this.value=''" onBlur="if(this.value=='')this.value='Write your experience here'">Write your experience here</textarea>
          <div class="post-right"><a href="#" class="button5">SUBMIT <img src="<?php echo USER_SIDE_IMAGES;?>submit2.png"></a></div>
        </form>
      </div>
    </div>
  </div>
 
</div>
 
<!--<script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyDY0kkJiTPVd2U7aTOAwhc9ySH6oHxOIYM&sensor=false">
</script>-->
<script>/*
function initialize()
{
var mapProp = {
  center:new google.maps.LatLng(51.508742,-0.120850),
  zoom:5,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };
var map=new google.maps.Map(document.getElementById("googleMap")
  ,mapProp);
}

google.maps.event.addDomListener(window, 'load', initialize);*/   
</script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	  	<?php  	//$venue = $cause_data[$i]['e_venue_name']." ".$cause_data[$i]['e_venue_addr'];
				$venue = $info['buss_city'].",".$info['buss_zip_code'];
				//$venue = "NH-4, hinjewadi, Pune, Maharashtra";
				$prepAddr =  preg_replace('~[\r\n]~', '',$venue);
				$prepAddr = str_replace(' ','+',$prepAddr);
				//echo $prepAddr;die;
				$url = "https://maps.google.com/maps/api/geocode/json?address=$prepAddr&sensor=false";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				$response = curl_exec($ch);
				curl_close($ch);
				$response_a = json_decode($response);
				$lat = $response_a->results[0]->geometry->location->lat;
				$long = $response_a->results[0]->geometry->location->lng;
				//echo $lat."<br />".$long;die;
		
		?>
		<script type="text/javascript">
       
        // Define the address we want to map.
        var address = "<?php echo trim(preg_replace('/\s+/', ' ', $venue));?>";
        var lat = "<?php echo $lat; ?>";
		var long = "<?php echo $long; ?>";
		//alert(lat);
		//alert(long);
		var latlng = new google.maps.LatLng(lat,long);
		
        // Create a new Geocoder
        var geocoder = new google.maps.Geocoder();
        
        // Locate the address using the Geocoder.
        geocoder.geocode( { 'latLng': latlng }, function(results, status) {
        
          // If the Geocoding was successful
          if (status == google.maps.GeocoderStatus.OK) {
        
            // Create a Google Map at the latitude/longitude returned by the Geocoder.
            var myOptions = {
              zoom: 13,
              center: results[0].geometry.location,
              mapTypeId: google.maps.MapTypeId.ROADMAP
			  
            };
            var map = new google.maps.Map(document.getElementById("googleMap"), myOptions);
        
            // Add a marker at the address.
            var marker = new google.maps.Marker({
              map: map,
              position: results[0].geometry.location,
			  title : "<?php echo trim(preg_replace('/\s+/', ' ', $venue));?>"
            });
        
          } else {
            try {
              console.error("Geocode was not successful for the following reason: " + status);
            } catch(e) {}
          }
        });
        </script>
<?php echo js_asset("featuredcontentglider.js");?>

<script type="text/javascript">

featuredcontentglider.init({
	gliderid: "canadaprovinces", //ID of main glider container
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
<script type="text/javascript">

featuredcontentglider.init({
	gliderid: "canadaprovincesnewone", //ID of main glider container
	contentclass: "glidecontent", //Shared CSS class name of each glider content
	togglerid: "p-selectone2", //ID of toggler container
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
<script type="text/javascript">

featuredcontentglider.init({
	gliderid: "canadaprovincesmid", //ID of main glider container
	contentclass: "glidecontent", //Shared CSS class name of each glider content
	togglerid: "p-selectone3", //ID of toggler container
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

function add_into_fav(bus_id,buss_user_id){


            $.ajax({
                type: "POST",
                url: '<?php echo site_url('home/add_into_favorite'); ?>',
                data: {business_id:bus_id,b_user_id:buss_user_id,send:'post'},
                dataType: 'json'
            }).done(function(res) {  //alert(res.frm_status.toString());
            if(res.frm_status.toString()=='true'){ 
                 var url="<?php echo USER_SIDE_IMAGES;?>";
               // window.location.replace(url+'/'+bus_id);
			    $('img#favorite').attr('src',url+'favou.png');
				$("#add_favor").removeAttr("onclick");
				$("#addfav").attr('class', 'fav');
				$('#txt').html('Favorite');
            }else{
                
            }
        }).fail(function() {alert("Something going in wrong way");location.reload(); 
        });
			
			<!--<div class="fav" id="fav"><a><img src="<?php //echo USER_SIDE_IMAGES;?>favou.png" > Favourite</a></div>
			-->
			
			
			
			
			
			
        }

</script>