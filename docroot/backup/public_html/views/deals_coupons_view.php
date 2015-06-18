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
                        
                        
                        
    function moreDeals()
    {       
        var totalDeals      =$('#totalDeals').val();
        var dealLimit       =$('#dealLimit').val();
        var dealCurrentOffset=$('#dealCurrentOffset').val();
        var dealNextOffset  =$('#dealNextOffset').val();       
        
        $.ajax({
                type: "GET",                                        
                url: '<?php echo base_url() ?>deals_and_coupons/getNextDeals/'+dealNextOffset,
                dataType:"html",
                success: function (data){
                    $('#dealCurrentOffset').val(dealNextOffset);
                    var nextOff=(parseInt(dealNextOffset) + parseInt(dealLimit));
                    $('#dealNextOffset').val(nextOff);
                    $('#listContainner').append(data);
                    if(nextOff>=totalDeals)
                      $('#moreDeals').css('display','none');

                    $("#showingText").text("Showing " + nextOff +  " of " +totalDeals);
                }
            });
    }
</script>
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
          <div class="inside-title-in"><div  id="main">
          <h1>Deals &amp; Coupons</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home">Home</a> | Deals &amp; Coupons</div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>

      <div id="section">
        <section id="main">
          <article class="section-deals">
            <div class="blank">
              <h1>Choose Your Provider To See Deals & Coupons</h1>
            </div>
            <!--<div class="search">
             
              
              <input name="Search" type="text"  value="Cannot find your provider type? Search for your" onblur="if(this.value=='')this.value='Cannot find your provider type? Search for your';" onfocus="if(this.value=='Cannot find your provider type? Search for your')this.value='';"/>
            </div>-->
            
            <div class="zip-search">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearchForProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearch();");
                 echo form_open_multipart('deals_and_coupons/search/', $attr);
                 ?>
              <div class="search-pro">
                <div class="bg-pro">
                
                  <?php $previousSearchedProperty=$this->session->userdata('dealsPropertySearchText');?>
                  <input name="propertySearchText" id="propertySearchText" type="text"  class="textfield"  value="<?php echo ($previousSearchedProperty!=""?$previousSearchedProperty:"Search for your provider");?>" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                  <input id="provider_name" type="submit" value="submit" name="provider_name"/>
                
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                
                    <?php $previousSearchedZipCode=$this->session->userdata('dealsSrhBussZipCode');?>
                  <input name="zipSubmit" type="submit" value="submit"/>
                  <input name="srhBussZipcode" id="srhBussZipcode" type="text" class="textfield"  value="<?php echo ($previousSearchedZipCode!=""?$previousSearchedZipCode:"Search by zipcode");?>" onBlur="if(this.value=='')this.value='Search by zipcode';" onFocus="if(this.value=='Search by zipcode')this.value='';"/>
                  
                </div>
              </div>
                <?php echo form_close();?>  
            </div>
              
            <div class="deal-box"> 
              
                <div class="line-one1">
                  <?php if(!empty($categories)){?>
                  <ul><?php $cnt=1;
                  foreach($categories as $key=>$val){?>
                      <li <?php echo ($cnt%6==0?'class="last"':'');?>>
                          <a href="<?php echo site_url('deals_and_coupons/deals_by_category/'.$val['catId']);?>"><?php echo substr(trim($val['catName']),0,14);?><img src="<?php echo base_url()."category_images/".$val['catImageName'];?>" alt="images"height="13"width="30"></a>
                      </li>
                  <?php $cnt++; }
                  ?>    
                  </ul>
                  <?php }else{?>
                  <h1>No Providers Found!!</h1>
               <?php }?>
              </div>             
            </div>
            <div class="viewing">Viewing All Deals & Coupons</div>
            <div class="result-f"><?php echo $totalRecords;?> Results</div>
            <?php if(!empty($dealList)){?>
            <div class="result-view">
              <div class="result-images"><img src="<?php echo USER_SIDE_IMAGES.'deal_images/'.$dealList[0]['dealImage'];?>" alt="result"></div>
              <div class="resultr-f">
                <div class="shed">
                  <div class="le"><?php echo $dealList[0]['buss_name'];?></div>
                  <?php $ratingClasses=array(0=>'nostar',1=>'onestar',2=>'twostar',3=>'threestar',4=>'fourstar',5=>'fivestar'); 
                              if($this->session->userdata('user_id') == "")
                                   $currentRating = $dealList[0]['buss_avg_ratings'];
                              else{
                                  $currentRating=_getBusinessRating($this->session->userdata('user_id'),$dealList[0]['buss_id']);
                              }
                              //echo current_url();
                              ?>
                  <div class="rate">
                    <ul class="rating <?php echo $ratingClasses[$currentRating];?>">
                      <li class="one"><a href="#" onclick="saveratings(1,<?php echo $dealList[0]['buss_id'];?>)" title="1 Star">1</a></li>
                      <li class="two"><a href="#" onclick="saveratings(2,<?php echo $dealList[0]['buss_id'];?>)" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" onclick="saveratings(3,<?php echo $dealList[0]['buss_id'];?>)" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" onclick="saveratings(4,<?php echo $dealList[0]['buss_id'];?>)" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" onclick="saveratings(5,<?php echo $dealList[0]['buss_id'];?>)" title="5 Stars">5</a></li>
                    </ul>
                  </div>
                </div>
                <div class="kids-r"><?php echo substr(nl2br($dealList[0]['dealOverview']),150);?></div>
                <div class="k-content"><?php echo $dealList[0]['dealDetails'];?></div>
                <div class="miles">
                    <?php echo $dealList[0]['buss_address'].','.$dealList[0]['buss_city'].' - '.$dealList[0]['buss_zip_code'];?>
                    <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($dealList[0]['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span>
                </div>
                <div class="rate-mile"><span>$<?php echo $dealList[0]['dealValue'];?></span> $<?php echo $dealList[0]['dealFinalPrice'];?>
                  <div class="tabm"><a href="<?php echo site_url('deals_and_coupons/view/'.$dealList[0]['dealId']); ?>" class="button orange" style="font-size:14px; width:105px; margin:0 5px 10px 10px;">VIEW DEAL</a></div>
                </div>
              </div>
            </div>
            <?php }?>
            
            <?php if(!empty($dealList)){?>
            <div class="deals-main">
                <ul id="listContainner">
                    <?php 
                    $cnt=1;
                    foreach($dealList as $key=>$val){?>
                 <li class="<?php echo ($cnt%3==0 && $cnt!=0?'last':"");?>">
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$val['dealImage'];?>" >
                  <div class="pad-deal"><div class="deal-title"><a href="<?php echo site_url('deals_and_coupons/view/'.$val['dealId']);?>"><?php echo substr(nl2br($val['dealOverview']),0,100);?></a></div> 
                  
                  <div class="main-amc">
                      <div class="amc"><strong><?php echo $val['buss_name'];?></strong><br/>
                      <?php echo $val['buss_address'].','.$val['buss_city'].' - '.$val['buss_zip_code'];?><br/>
                      <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($val['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span>
                 </div>
                  
                  
                  <div class="rates-one">
                  <div class="fls"><div class="rate">
                    <ul class="rating <?php echo $ratingClasses[$currentRating];?>">
                      <li class="one"><a href="#" onclick="saveratings(1,<?php echo $dealList[0]['buss_id'];?>)" title="1 Star">1</a></li>
                      <li class="two"><a href="#" onclick="saveratings(2,<?php echo $dealList[0]['buss_id'];?>)" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" onclick="saveratings(3,<?php echo $dealList[0]['buss_id'];?>)" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" onclick="saveratings(4,<?php echo $dealList[0]['buss_id'];?>)" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" onclick="saveratings(5,<?php echo $dealList[0]['buss_id'];?>)" title="5 Stars">5</a></li>
                    </ul>
                  </div></div>
                  
                  <div class="rate-new"><span>$<?php echo $val['dealValue'];?></span>  $<?php echo $val['dealFinalPrice']?></div></div>
                  </div>
                  <div class="clear"></div></div>
                  <div class="tabm"><a href="<?php echo site_url('deals_and_coupons/view/'.$val['dealId']);?>" class="button orange" style="font-size:14px; width:105px; margin:0 15px 10px 11px;">VIEW DEAL</a></div>
                  </div>
                  <div class="clear"></div>
                </li>
                <?php 
                $cnt++;
                }?>
                </ul>
            </div>
            
                    <?php if($totalRecords<=$limit){
                     $limit=$totalRecords;
                    }
                    $nextOffset=($limit + $offset);
                    $showingRecords=sizeof($dealList);
                    ?>
                     <div class="showing"><span id="showingText"><?php echo "Showing $showingRecords of $totalRecords";?></span></div>
                     <div class="clear"></div>
                     <form autocomplete="off">
                     <input id="totalDeals" type="hidden" value="<?php echo $totalRecords;?>"/>                   
                     <input id="dealLimit" type="hidden" value="<?php echo $limit;?>"/>                   
                     <input id="dealCurrentOffset" type="hidden" value="<?php echo $offset;?>"/>
                     <input id="dealNextOffset" type="hidden" value="<?php echo $nextOffset;?>"/>
                     </form>
                     
                     <?php /*if($totalRecords>$nextOffset){
                         $nextLimit=($limit + $offset);*/
                         ?>
                     <?php if(($totalRecords-$showingRecords)>=1){                
                        $showingRecords=$showingRecords + 2;                        
                        ?>
                     <div class="see-m" id="moreDeals"><?php echo anchor("deals_and_coupons/index/$showingRecords","SEE $nextOffset MORE DEALS",array('class'=>'button2 orange1')); ?></div>
                     <!--<div class="see-m" id="moreDeals"><a class="button2 orange1" onclick="javascript: return moreDeals(); return false;"><?php echo "SEE $nextOffset MORE DEALS";?></a><?php //echo anchor("#","SEE $nextOffset MORE DEALS",array('class'=>'button2 orange1','onclick'=>"javascript: return moreDeals(); return false;")); ?></div>-->
                     <?php }?>
            <?php }?>
          </article>
          <div class="clear"></div>
        </section>
      </div>
    </div>

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
