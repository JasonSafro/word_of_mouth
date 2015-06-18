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
        
<?php //echo js_asset("jquery.min.js");?>
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
              <h1>We're Hiring | <?php echo $catInfo['catName'];?></h1>
              <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home">Home</a> | <a href="<?php echo base_url()?>we_are_hiring">We're Hiring</a> | <?php echo $catInfo['catName'];?></div>
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
                 <?php 
                 $attr = array('name' => 'frmBusinessSearchForProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearch();");
                 echo form_open_multipart('we_are_hiring/category_search/'.$catInfo['catId'], $attr);
                 ?>
              <div class="search-pro">
                <div class="bg-pro">
                 
                  <?php $previousSearchedProperty=$this->session->userdata('cat_jobsPropertySearchText');?>
                  <input name="propertySearchText" id="propertySearchText" type="text"  class="textfield"  value="<?php echo ($previousSearchedProperty!=""?$previousSearchedProperty:"Search for your provider");?>" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                  <input id="provider_name" type="submit" value="submit" name="provider_name"/>
                  
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                 
                    <?php $previousSearchedZipCode=$this->session->userdata('cat_jobsSrhBussZipCode');?>
                  <input name="zipSubmit" type="submit" value="submit"/>
                  <input name="srhBussZipcode" id="srhBussZipcode" type="text" class="textfield"  value="<?php echo ($previousSearchedZipCode!=""?$previousSearchedZipCode:"Search by zipcode");?>" onBlur="if(this.value=='')this.value='Search by zipcode';" onFocus="if(this.value=='Search by zipcode')this.value='';"/>
                 
                </div>
              </div>
                <?php echo form_close();?>
            </div>
            
            <div class="deal-box2">
             
              <div class="line-one1">
                  <?php if(!empty($categories)){?>
                  <ul><?php $cnt=1;
                  foreach($categories as $key=>$val){?>
                      <li <?php echo ($cnt%6==0?'class="last"':'');?>><a href="<?php echo base_url()?>we_are_hiring/jobs_by_category/<?php echo $val['catId'];?>"><?php echo $val['catName'];?> <img src="<?php echo base_url()."category_images/".$val['catImageName'];?>" alt="images"height="13"width="30"></a></li>
                  <?php $cnt++; }
                  ?>    
                  </ul>
                  <?php }?>
                  
               
              </div>
            </div>
            <div class="result-f"></div>
            
                <?php if(!empty($businessList)){ $cnt=1;?>
            <div class="deals-main">
              <ul>
                 <?php foreach($businessList as $key=>$val){?>
                   <li <?php echo ($cnt%3==0?'class="last"':'');?>>
                       <?php $businessImageUrl =base_url().'LOGO/'.$val['buss_logo']; ?>
                  <div class="deal-boxes"> <a href="<?php echo site_url('home/business_details/'.$val['buss_id']);?>"><img src="<?php echo $businessImageUrl;?>" width="361px" height="214px" title="View business details"/></a>
                    <div class="pad-deal">
                      <div class="main-amc">
                        <div class="amc-n">
                          <div class="deal-title deal-title-n"><?php echo anchor('home/business_details/'.$val['buss_id'],$val['buss_name'],array('title'=>'View business details'));?></div>
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
                        <div class="amc height"><strong><?php echo $val['buss_name'];?></strong><br/>
                           <?php echo  $val['buss_address'].', '.$val['buss_city'].', '.$val['buss_zip_code']; ?><br/>
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
                                <p id="mygallery<?php echo $key;?>-paginate" class="paginate1" >
                                <img src="<?php echo USER_SIDE_IMAGES;?>opencircle.png" data-over="<?php echo USER_SIDE_IMAGES;?>graycircle.png" data-select="<?php echo USER_SIDE_IMAGES;?>closedcircle.png" data-moveby="1" />

                                </p> 
                              <!--<div id="parent2-menu-n" class="wslide-menu"> <a href="#parent2-1" class="wactive">1</a> <a href="#parent2-2" class="">2</a> <a href="#parent2-3">3</a> <a href="#parent2-4">4</a></div>-->
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="clear"></div>
                      
                   <div class="sect-new"><h1>Jobs</h1>
                    <div id="mygallery<?php echo $key;?>" class="stepcarousel" >
                    <div class="belt">                          
                          <?php 
                      $numOfJobs=sizeof($jobList);
                      $inCount=0;
                      $isPanelOpen=false;
                      if($numOfJobs>=1){ $isPanelOpen=true; ?>
                       <div class="panelnew">
                       <div class="main-posts">
                      <?php foreach($jobList as $jKey=>$jVal){ $isPanelOpen=true; //$inCount+1%3==0) || ($jKey==$numOfJobs-1)?>
                   
                        
                      <?php  $inCount++;?>
                       <div class="post <?php echo ($inCount%3==0?"br0":"");?>">
                        <div class="post-left">
                          <h2><?php echo $jVal['jobTitle'];?></h2>
                          Posted: <?php echo $jVal['jobPostDate'];?>
                        </div>
                        <div class="post-right"> <a class="button4" href="<?php echo site_url("home/job_view/".$jVal['jobId'])?>" id="address_pop">VIEW</a> </div>
                        <div class="clear"></div>
                      </div>
                          
                           <?php
                      
                     if($inCount%3==0 && $inCount!=0){?>
                       </div>
                       </div> 
                       <div class="panelnew">
                       <div class="main-posts">
                    <?php }?> 
                           
                        <?php 
                       
                        }//end of foreach ?>
                        <?php if($isPanelOpen==true){?>    
                        </div>
                        </div>
                     <?php }?>   
                   <?php  } //end of if?>

                    </div>
                    </div> 

                    <div class="clear"></div>
                                        

                </div>
                      
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                <?php $cnt++; }?>
              </ul>
              
            </div>
           <div class="showing"><span>Showing <?php echo $showingRecords;?> of <?php echo $totalRecotds;?></span></div>
            <div class="clear"></div>
            <?php if(($totalRecotds-$showingRecords)>=1){
                $catId=$catInfo['catId'];
                $showingRecords=$showingRecords + 9;
                ?>
            <div class="see-m"><a href="<?php echo site_url("we_are_hiring/jobs_by_category/$catId/$showingRecords");?>" class="button2 orange1">SEE 9 MORE JOBS</a></div>
            <?php }?>
          </article>
             <?php  }?>
          <div class="clear"></div>
        </section>
      </div>
    </div>  
        


<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script-->
<?php echo js_asset("jquery-1.3.2.min.js");?>
<?php echo js_asset("stepcarousel.js");?>
<script type="text/javascript">
<?php foreach($businessList as $key=>$val){?>
stepcarousel.setup({
	galleryid: 'mygallery<?php echo $key;?>', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panelnew', //class of panel DIVs each holding content
	autostep: {enable:true, moveby:1, pause:3000},
	panelbehavior: {speed:500, wraparound:true, wrapbehavior:'slide', persist:true},
	defaultbuttons: {enable: true, moveby: 1, leftnav: [0, 0], rightnav: [0 , 0]},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['inline'] //content setting ['inline'] or ['ajax', 'path_to_external_file']
})
<?php }?>


</script>  

<script>
//homePropertySearchText homeSrhBussZipCode 
function validateProviderSearch(){
    var propertySearchText=$('#propertySearchText').val();
    var srhBussZipcode=$('#srhBussZipcode').val();
    
    
    if(propertySearchText=="Search for your provider" && srhBussZipcode=="Search by zipcode")
    {
        alert('Please provide provider search text.');
        $('#propertySearchText').focus();
        return false;
    }
    
    if(srhBussZipcode!="Search by zipcode")
    {            
        if(isNaN(srhBussZipcode))
        {
           alert('Please provide valid zipcode.');
           $('#srhBussZipcode').focus();
           return false; 
        }    
    }
}
</script>

