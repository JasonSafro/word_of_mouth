<?php
//CSS
echo css_asset("address-popup.css");
echo css_asset("selectbox.css");



?>
<script src="<?php echo base_url()?>assets/scripts/jquery.wslide.js" type="text/javascript" charset="utf-8"></script>
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

<!--select-->
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" type="text/javascript" charset="utf-8"></script>-->
	<?php echo js_asset("jquery.selectbox-0.5.js");  ?>
	<script type="text/javascript">
	$(document).ready(function() {
		$('.items').selectbox();
	});
	</script>
        
<?php echo js_asset("jquery.min.js");?>
<script>
function saveratings(rating,busId)
    {
         var currentUrl="<?php echo current_url();?>";
         
     $.ajax({
        type: "GET",
        url : "<?php echo base_url(); ?>insert_ratings/insert_bus_ratings?rating=" + rating + "&busId=" + busId,
        datatype:'text',
        success : function(result) {
          if(result)
          {
            alert("Please Login To give Ratings!");
             window.location.href=currentUrl;
          }
          else
          {
            alert("Ratings Added!");
             window.location.href=currentUrl;
          }
        }
    }); 
   }
  </script>
    <div id="page-wrap">
      <div id="main1">
        <section class="inside-title">
          <div class="inside-title-in">
            <div  id="main">
              <h1>We're Hiring</h1>
              <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home">Home</a> | We're Hiring</div>
            </div>
          </div>
        </section>
      </div>
      <div class="clear"></div>
      <div id="section">
        <section id="main">
          <article class="section-deals">
            <div class="blank">
              <h1>Choose Your Provider To See Available Jobs</h1>
            </div>
            <!--<div class="search">
             
              
              <input name="Search" type="text"  value="Cannot find your provider type? Search for your" onblur="if(this.value=='')this.value='Cannot find your provider type? Search for your';" onfocus="if(this.value=='Cannot find your provider type? Search for your')this.value='';"/>
            </div>-->
            <div class="zip-search">
              <div class="search-pro">
                <div class="bg-pro">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearchForProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearchTest();");
                 echo form_open_multipart('we_are_hiring/search_by_provider/', $attr);
                 ?>
                  <?php $previousSearchedProperty=$this->session->userdata('jobsPropertySearchText');?>
                  <input name="propertySearchText" id="propertySearchText" type="text"  class="textfield"  value="<?php echo ($previousSearchedProperty!=""?$previousSearchedProperty:"Search for your provider");?>" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                  <input id="provider_name" type="submit" value="submit" name="provider_name"/>
                <?php echo form_close();?>  
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearch', 'id' => 'frmBusinessSearch', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateZipCode();");
                 echo form_open_multipart('we_are_hiring/search_by_zipcode/', $attr);
                 ?>
                    <?php $previousSearchedZipCode=$this->session->userdata('jobsSrhBussZipCode');?>
                  <input name="zipSubmit" type="submit" value="submit"/>
                  <input name="srhBussZipcode" id="srhBussZipcode" type="text" class="textfield"  value="<?php echo ($previousSearchedZipCode!=""?$previousSearchedZipCode:"Search by zipcode");?>" onBlur="if(this.value=='')this.value='Search by zipcode';" onFocus="if(this.value=='Search by zipcode')this.value='';"/>
                  <?php echo form_close();?>
                </div>
              </div>
            </div>
            <div class="deal-box2">
             
              <div class="line-one1">
                  <?php if(!empty($categories)){?>
                  <ul><?php $cnt=1;
                  foreach($categories as $key=>$val){?>
                      <li <?php echo ($cnt%6==0?'class="last"':'');?>><a href="<?php echo base_url()?>home/business_list/<?php echo $val['catId'];?>"><?php echo $val['catName'];?> <img src="<?php echo base_url()."category_images/".$val['catImageName'];?>" alt="images"height="13"width="30"></a></li>
                  <?php $cnt++; }
                  ?>    
                  </ul>
                  <?php }?>
                  
               
              </div>
            </div>
            <div class="result-f"></div>
            <div class="deals-main">
                <?php if(!empty($businessList)){ $cnt=1;?>
              <ul>
                  
                  <?php foreach($businessList as $key=>$val){?>
                   <li <?php echo ($cnt%3==0?'class="last"':'');?>>
                       <?php $businessImageUrl =base_url().'LOGO/'.$val['buss_logo']; ?>
                  <div class="deal-boxes"> <img src="<?php echo $businessImageUrl;?>">
                    <div class="pad-deal">
                      <div class="main-amc">
                        <div class="amc-n">
                          <div class="deal-title deal-title-n"><a href="#"><?php echo $val['buss_name'];?></a></div>
                        </div>
                        <?php $ratingClasses=array(0=>'nostar',1=>'onestar',2=>'twostar',3=>'threestar',4=>'fourstar',5=>'fivestar'); 
                        if($this->session->userdata('user_id') == "")
                           $currentRating = $val['buss_avg_ratings'];
                        else{
                          $currentRating=_getBusinessRating($this->session->userdata('user_id'),$val['buss_id']);
                        }
                        //echo current_url();
                            ?>
                        <div class="rates-one-n">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating <?php echo $ratingClasses[$currentRating];?>">                         
                                <li class="one"><a href="#" onclick="saveratings(1,<?php echo $val['buss_id'];?>)" title="1 Star">1</a></li>
                                <li class="two"><a href="#" onclick="saveratings(2,<?php echo $val['buss_id'];?>)" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" onclick="saveratings(3,<?php echo $val['buss_id'];?>)" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" onclick="saveratings(4,<?php echo $val['buss_id'];?>)" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" onclick="saveratings(5,<?php echo $val['buss_id'];?>)" title="5 Stars">5</a></li>                      
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="main-amc">
                        <div class="amc"><strong><?php echo $val['buss_name'];?></strong><br/>
                       <?php echo  $val['buss_address'].', '.$val['buss_city'].', '.$val['buss_zip_code']; ?><br>
                          <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($val['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span>
                        </div>
                        
                      <?php 
                      $businessId=$val['buss_id'];
                      $where="WHERE jobBusinessId=$businessId AND jobStatus!='Deleted'";
                       $jobList= $this->WGModel->getJobList($where);
                      ?>
                       <div class="rates-one">
                          <div class="fls">
                            <div class="rate2">
                              <div id="parent2-menu-n" class="wslide-menu slider_page_links_<?php echo $key;?>">
                                  <?php 
                                  $loopCount=sizeof($jobList);
                                  if($loopCount<=3)
                                      $loopCount=1;
                                  else
                                      $loopCount=ceil($loopCount/3);
                                  //echo $loopCount;
                                  for($i=1;$i<=$loopCount;$i++)
                                  {
                                      echo anchor('#','Page '.$i,array('class' => ($i==1?'wactive':'')));
                                  }
                                  ?>
                                    <!--a href="#parent2-1" class="wactive">1</a> <a href="#parent2-2" class="">2</a> <a href="#parent2-3">3</a> <a href="#parent2-4">4</a-->
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="clear"></div>
                      
                      <h1>Jobs</h1>
                      <?php 
                      $numOfJobs=sizeof($jobList);
                      $count=0;
                      foreach($jobList as $jKey=>$jVal){?>
                      
                      <div id="canadaprovinces_<?php echo $key;?>" class="post <?php echo ($jKey==$numOfJobs-1?"br0":"");?>">
                      <div class="post-left">
                        <h2><?php echo $jVal['jobTitle'];?></h2>
                        Posted: <?php echo $jVal['jobPostDate'];?>
                      </div>
                          <div class="post-right"><a class="button4" href="<?php echo site_url("home/job_view/".$jVal['jobId'])?>">VIEW</a></div>
                      <div class="clear"></div>
                      </div>
                      
                          
                      <?php $count++;?>
                      <?php }?>
                     
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                  <?php $cnt++;} //end of foreach?>
                 </ul> 
               <?php } //end of empty if ?>   
                  
               
            </div>
           <div class="showing"><span>Showing <?php echo $showingRecords;?> of <?php echo $totalRecotds;?></span></div>
            <div class="clear"></div>
            <?php if(($totalRecotds-$showingRecords)>=1){?>
            <div class="see-m"><a href="<?php echo site_url("we_are_hiring/index/".$showingRecords + 9);?>" class="button2 orange1">SEE 9 MORE JOBS</a></div>
            <?php }?>
          </article>
          <div class="clear"></div>
        </section>
      </div>
    </div>  
        
<?php echo js_asset("featuredcontentglider.js");?>

<script type="text/javascript">
 <?php //foreach($businessList as $key=>$val){    
          ?>
          
featuredcontentglider.init({
	gliderid: "canadaprovinces_<?php echo '1';?>", //ID of main glider container
	contentclass: "glidecontent", //Shared CSS class name of each glider content
	togglerid: "slider_page_links_<?php echo '1';?>", //ID of toggler container
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
<?php 
 //}?>

</script>    

<script type="text/javascript">
    function validateZipCode()
    {
        var srhBussZipcode=$('#srhBussZipcode').val();
        if(srhBussZipcode=="" || srhBussZipcode=="Search by zipcode")
        {
            alert('Please provide zipcode.');
            $('#srhBussZipcode').focus();
            return false;
        }else{
            if(isNaN(srhBussZipcode))
            {
               alert('Please provide valid zipcode.');
               $('#srhBussZipcode').focus();
               return false; 
            }    
        }
        
    }
    
    function validateProviderSearchTest()
    {
        var propertySearchText=$('#propertySearchText').val();
        if(propertySearchText=="" || propertySearchText=="Search for your provider")
        {
            alert('Please provide provider search text.');
            $('#propertySearchText').focus();
            return false;
        }
    }
</script>

