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
                  <h1><?php echo $dealInfo['buss_name'];?> | Deals</h1> 
                  <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > 
                      <a href="<?php echo base_url();?>home">Home</a> | <a href="<?php echo base_url();?>deals_and_coupons">Deals &amp; Coupons</a> | <?php echo anchor('home/business_details/'.$dealInfo['dealBusinessId'],$dealInfo['buss_name']);?>
                  </div>
              </div>
          </div>
          </section>
        </div>
        <div class="clear"></div>
      <div id="section">
        <section id="main">
          <article class="section-deals">
            <div class="blank">              
               <?php echo anchor('home/business_details/'.$dealInfo['dealBusinessId'],'<h1>'.$dealInfo['buss_name'].' | Deals</h1>');?>
            </div>
            <!--<div class="search">
             
              
              <input name="Search" type="text"  value="Cannot find your provider type? Search for your" onblur="if(this.value=='')this.value='Cannot find your provider type? Search for your';" onfocus="if(this.value=='Cannot find your provider type? Search for your')this.value='';"/>
            </div>-->
            
            <div class="deal-box"> </div>
            <div class="ntb-main">
              <div class="ntb"><img src="<?php echo USER_SIDE_IMAGES.'deal_images/'.$dealInfo['dealImage'];?>"></div>
              <div class="ntbr">
                <div class="full-des">
                  <h1><?php echo $dealInfo['buss_name'].' - '.$dealInfo['buss_city'].','.$dealInfo['buss_addr_addon'];?><br/>
                    <span><?php echo nl2br($dealInfo['dealOverview']);?></span></h1>

                    <?php $ratingClasses=array(0=>'nostar',1=>'onestar',2=>'twostar',3=>'threestar',4=>'fourstar',5=>'fivestar'); 
                          if($this->session->userdata('user_id') == "")
                               $currentRating = $dealInfo['buss_avg_ratings'];
                          else{
                              $currentRating=_getBusinessRating($this->session->userdata('user_id'),$dealInfo['buss_id']);
                          }
                              //echo current_url();
                      ?>
                  <div class="ratel">
                    <ul class="rating <?php echo $ratingClasses[$currentRating];?>">                         
                      <li class="one"><a href="#" onclick="saveratings(1,<?php echo $dealInfo['buss_id'];?>)" title="1 Star">1</a></li>
                      <li class="two"><a href="#" onclick="saveratings(2,<?php echo $dealInfo['buss_id'];?>)" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" onclick="saveratings(3,<?php echo $dealInfo['buss_id'];?>)" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" onclick="saveratings(4,<?php echo $dealInfo['buss_id'];?>)" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" onclick="saveratings(5,<?php echo $dealInfo['buss_id'];?>)" title="5 Stars">5</a></li>                      
                    </ul>
                  </div>
                  <div class="miles1"><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($dealInfo['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></div>
                  <div class="blue-bg">
                    <div class="dividerl">
                      <div class="value">Value<br/>
                        $<?php echo $dealInfo['dealValue']?></div>
                      <div class="discount">Discount<br/>
                         <?php echo $dealInfo['dealDiscounts']?>%</div>
                      <div class="you-save">You Save <br/>
                        $<?php echo $dealInfo['dealSavings']?></div>
                    </div>
                    <div class="down">
                      <div class="only">only<br/>
                        <span>$<?php echo $dealInfo['dealFinalPrice']?></span></div>
                      <div class="download-deal"><a href="<?php echo site_url('deals_and_coupons/download/'.$dealInfo['dealId']);?>" target="_blanck"><img src="<?php echo USER_SIDE_IMAGES;?>download-deal.png" alt="download"></a></div>
                    </div>
                  </div>
                  <div class="sahre-deal">
                    <label>Share This Deal:</label>
                    <?php 
                    $title=$dealInfo['dealOverview'];
                    $dealImages=USER_SIDE_IMAGES.'deal_images/'.$dealInfo['dealImage'];
                    $description=$dealInfo['dealDetails'];
                    $newDescription= str_replace("\n", "", $description);
                    ?>
                        <ul>
                            <li><a onClick="window.open('http://www.facebook.com/sharer.php?s=100&amp;p[title]=<?php echo urlencode($title); ?>&amp;p[images][0]=<?php echo urlencode($dealImages); ?>&amp;p[summary]=<?php echo urlencode($newDescription); ?>&amp;p[url]=<?php echo urlencode(current_url()); ?>','sharer','toolbar=0,status=0,width=548,height=325');" href="javascript: void(0)">
                            <img src="<?php echo USER_SIDE_IMAGES;?>h2.png" alt="fb"/>
                            </a></li>

                            <li><a href="https://twitter.com/share?url=<?php echo urlencode(current_url()); ?>" data-url="<?php echo urlencode(current_url());?>" data-text="<?php echo $title; ?>" data-count="none" target="_blank">
                            <img src="<?php echo USER_SIDE_IMAGES;?>h1.png" alt="twitter"/>
                            </a></li>


                            <li><a class="pin-it-button" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode(current_url()); ?>&amp;media=<?php echo $dealImages;?>&amp;description=<?php echo $description; ?>" target="_blank">
                            <img src="<?php echo USER_SIDE_IMAGES;?>h3.png" alt="printrest"/>
                            </a></li> 

                            <li><a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo urlencode(current_url()); ?>" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png" alt="linkedin"/></a></li>
                        </ul>
                   
                  </div>
                </div>
              </div>
            </div>
            <div class="section-deals1">
              <article class="deals-sl">
                <div class="overviews">
                  <h1>Deal & Coupon Overview</h1>
                  
                  <p><?php echo nl2br($dealInfo['dealOverview']);?></p>
                </div>
                <div class="overviews1">
                  <h1><?php echo $dealInfo['buss_name'];?></h1>
                  <p><?php echo nl2br($dealInfo['dealDetails']);?></p>
                </div>
              </article>
              <article class="deals-sr">
                <div class="overviews">
                  <h1>The Details</h1>
                  
                  <p><a href="#">Expires <?php echo date('F j, Y', strtotime($dealInfo['dealExpirationDate']));?></a><br/>
                    Limit: <?php echo $dealInfo['dealLimit']?></p>
                </div>
                <div class="overviews1">
                  <h1>Location & Information</h1>
                  <div class="map">
                    <div id="googleMap" style="width:100%;height:322px;"></div>
                  </div>
                  <div class="over-add">
                    <div class="address"><strong><?php echo $dealInfo['buss_name'];?></strong>&nbsp;&nbsp;<span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($dealInfo['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span><br/>
                      Address: <?php echo $dealInfo['buss_address'].','.$dealInfo['buss_city'].','.$dealInfo['buss_addr_addon'];?><br/>
                      Phone: <?php echo $dealInfo['buss_phone'];?></div>
                    <div class="addres-rate">
                      <ul class="rating <?php echo $ratingClasses[$currentRating];?>">                         
                      <li class="one"><a href="#" onclick="saveratings(1,<?php echo $dealInfo['buss_id'];?>)" title="1 Star">1</a></li>
                      <li class="two"><a href="#" onclick="saveratings(2,<?php echo $dealInfo['buss_id'];?>)" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" onclick="saveratings(3,<?php echo $dealInfo['buss_id'];?>)" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" onclick="saveratings(4,<?php echo $dealInfo['buss_id'];?>)" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" onclick="saveratings(5,<?php echo $dealInfo['buss_id'];?>)" title="5 Stars">5</a></li>                      
                    </ul>
                    </div>
                      <?php $tempAddress=$dealInfo['buss_name'].','.$dealInfo['buss_address'].','.$dealInfo['buss_city'].','.$dealInfo['buss_addr_addon'];?>
                    <div class="directions"><a href="https://maps.google.com/maps?saddr=&daddr=+<?php echo $tempAddress;?>" target="_blanck">Get Directions Today</a>&nbsp;&nbsp; 
                        <?php if($dealInfo['buss_web_address']!=""){?>| &nbsp;&nbsp; <a href="<?php echo prep_url($dealInfo['buss_web_address']);?>" target="_blanck">Company Website</a>&nbsp;&nbsp;<?php }?> 
                         <?php if($dealInfo['buss_social_media_channel_1']!=""){?>| &nbsp;&nbsp;<a href="<?php echo prep_url($dealInfo['buss_social_media_channel_1']);?>" target="_blanck">Twitter Page</a>&nbsp;&nbsp;<?php }?>
                         <?php if($dealInfo['buss_social_media_channel_2']!=""){?>| &nbsp;&nbsp;<a href="<?php echo prep_url($dealInfo['buss_social_media_channel_2']);?>" target="_blanck">Facebook Page</a>&nbsp;&nbsp;<?php }?>
                         <?php if($dealInfo['buss_social_media_channel_3']!=""){?>| &nbsp;&nbsp;<a href="<?php echo prep_url($dealInfo['buss_social_media_channel_3']);?>" target="_blanck">Pinterest Page</a>&nbsp;&nbsp;<?php }?>
                         <?php if($dealInfo['buss_social_media_channel_4']!=""){?>| &nbsp;&nbsp;<a href="<?php echo prep_url($dealInfo['buss_social_media_channel_4']);?>" target="_blanck">Linked in Page</a><?php }?></div>
                  </div>
                </div>
              </article>
            </div>
            <div class="viewing-cust">Customers also viewed</div>
             <?php if(!empty($dealList)){?>
            <div class="deals-main">
                <ul id="listContainner">
                    <?php 
                    $cnt=1;
                    foreach($dealList as $key=>$val){?>
                 <li class="<?php echo ($cnt%3==0 && $cnt!=0?'last':"");?>">
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$val['dealImage'];?>" >
                  <div class="pad-deal"><div class="deal-title"><a href="<?php echo site_url('deals_and_coupons/view/'.$val['dealId']);?>"><?php echo substr(nl2br($val['dealOverview']),0,100);?></a></div> 
                  
                  <div class="main-amc"><div class="amc"><strong><?php echo $val['buss_name'];?></strong><br/><?php echo $val['buss_city'].','.$val['buss_addr_addon'];?><br/>
                  <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($val['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span></div>
                  <?php $ratingClasses=array(0=>'nostar',1=>'onestar',2=>'twostar',3=>'threestar',4=>'fourstar',5=>'fivestar'); 
                              if($this->session->userdata('user_id') == "")
                                   $currentRating = $val['buss_avg_ratings'];
                              else{
                                  $currentRating=_getBusinessRating($this->session->userdata('user_id'),$val['dealBusinessId']);
                              }
                              //echo current_url();
                              ?>
                  
                  <div class="rates-one">
                  <div class="fls"><div class="rate">
                    <ul class="rating <?php echo ($currentRating!=""?$ratingClasses[$currentRating]:"");?>">                         
                      <li class="one"><a href="#" onclick="saveratings(1,<?php echo $val['dealBusinessId'];?>)" title="1 Star">1</a></li>
                      <li class="two"><a href="#" onclick="saveratings(2,<?php echo $val['dealBusinessId'];?>)" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" onclick="saveratings(3,<?php echo $val['dealBusinessId'];?>)" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" onclick="saveratings(4,<?php echo $val['dealBusinessId'];?>)" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" onclick="saveratings(5,<?php echo $val['dealBusinessId'];?>)" title="5 Stars">5</a></li>                      
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
            <?php } ?>
            <!--
            <div class="viewing-cust1">In & Around Charleston</div>
            <div class="north">
            <ul class="nul"><li><strong>North Charleston, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            <ul><li><strong>Mt Pleasant, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            <ul><li><strong>Folly Beach, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            <ul><li><strong>Orangeburg, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            <ul><li><strong>St Matthews, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            <ul><li><strong>Swansea, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            <ul class="last"><li><strong>Hampton, SA</strong></li>
            <li><span>Beauty & Spas</span></li>
            <li><span>Restaurants</span></li>
            <li><span>Things to Do</span></li>
            </ul>
            
            
            
            </div>
            -->
            
          </article>
          <div class="clear"></div>
        </section>
      </div>
    </div>

<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<?php           //$venue = $cause_data[$i]['e_venue_name']." ".$cause_data[$i]['e_venue_addr'];
                $venue = $dealInfo['buss_address'];
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
                //echo '<pre>'; print_r($response);
                if(isset($response_a->results[0])){
                    $lat = $response_a->results[0]->geometry->location->lat;
                    $long= $response_a->results[0]->geometry->location->lng;
                }
                else{
                    $lat="";
                    $long="";
                }
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