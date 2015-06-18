<div id="page-wrap">
     <div id="main1">
          <section class="inside-title">
          <div class="inside-title-in">
              <div  id="main">
                  <h1><?php echo $dealInfo['catName'].' | '.$dealInfo['buss_name'];?> | Deals</h1> 
                  <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > 
                      <a href="<?php echo base_url();?>home">Home</a> | <a href="<?php echo base_url();?>deals_and_coupons">Deals &amp; Coupons</a> | Category | <?php echo $dealInfo['catName'].' | '.$dealInfo['buss_name'];?> | Deals
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
              <h1><?php echo $dealInfo['catName'].' | '.$dealInfo['buss_name'];?> | Deals </h1>
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
                    <span><?php echo $dealInfo['dealOverview'];?></span></h1>
                  <div class="ratel">
                    <ul class="rating nostar">
                      <li class="one"><a href="#" title="1 Star">1</a></li>
                      <li class="two"><a href="#" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" title="5 Stars">5</a></li>
                    </ul>
                  </div>
                  <div class="miles1">(2.1 Miles)</div>
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
                      <div class="download-deal"><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>download-deal.png" alt="download"></a></div>
                    </div>
                  </div>
                  <div class="sahre-deal">
                    <label>Share This Deal:</label>
                    <ul>
                      <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png" alt="twitter"></a></li>
                      <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png" alt="fb"></a></li>
                      <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>h3.png" alt="printrest"></a></li>
                      <li><a href="#"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png" alt="linkedin"></a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="section-deals1">
              <article class="deals-sl">
                <div class="overviews">
                  <h1>Deal & Coupon Overview</h1>
                  
                  <p><?php echo $dealInfo['dealOverview']?></p>
                </div>
                <div class="overviews1">
                  <h1><?php echo $dealInfo['buss_name'];?></h1>
                  <p><?php echo $dealInfo['dealDetails']?></p>
                </div>
              </article>
              <article class="deals-sr">
                <div class="overviews">
                  <h1>The Details</h1>
                  
                  <p><a href="#">Expires <?php echo date('F j, Y', strtotime($dealInfo['dealExpirationDate']));?></a><br/>
                    <?php echo $dealInfo['dealLimit']?></p>
                </div>
                <div class="overviews1">
                  <h1>Location & Information</h1>
                  <div class="map">
                    <div id="googleMap" style="width:100%;height:322px;"></div>
                  </div>
                  <div class="over-add">
                    <div class="address"><strong><?php echo $dealInfo['buss_name'];?></strong>&nbsp;&nbsp;<span>(2.1 Miles)</span><br/>
                      Address: <?php echo $dealInfo['buss_address'].','.$dealInfo['buss_city'].','.$dealInfo['buss_addr_addon'];?><br/>
                      Phone: <?php echo $dealInfo['buss_phone'];?></div>
                    <div class="addres-rate">
                      <ul class="rating nostar">
                        <li class="one"><a href="#" title="1 Star">1</a></li>
                        <li class="two"><a href="#" title="2 Stars">2</a></li>
                        <li class="three"><a href="#" title="3 Stars">3</a></li>
                        <li class="four"><a href="#" title="4 Stars">4</a></li>
                        <li class="five"><a href="#" title="5 Stars">5</a></li>
                      </ul>
                    </div>
                    <div class="directions"><a href="#">Get Directions Today</a>&nbsp;&nbsp; | &nbsp;&nbsp; <a href="#">Company Website</a>&nbsp;&nbsp; | &nbsp;&nbsp;<a href="#">Facebook Page</a></div>
                  </div>
                </div>
              </article>
            </div>
            <div class="viewing-cust">Customers also viewed</div>
            <div class="deals-main">
              <ul>
                <li>
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES;?>auto1.jpg" >
                    <div class="pad-deal">
                      <div class="deal-title"><a href="#">25% Off Four Brake Pad Services</a></div>
                      <div class="main-amc">
                        <div class="amc"><strong>Treadquarters</strong><br/>
                          Charleston, SC<br/>
                          <span>(1.8 Miles)</span></div>
                        <div class="rates-one">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating nostar">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="rate-new"><span>$599.99</span> $499.99</div>
                        </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                <li>
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES;?>auto2.jpg" >
                    <div class="pad-deal">
                      <div class="deal-title"><a href="#">50% Off a Premium Oil Change</a></div>
                      <div class="main-amc">
                        <div class="amc"><strong>Gerald's Tires & Brakes</strong><br/>
                          Summerville, SC<br/>
                          <span>(2.2 Miles)</span></div>
                        <div class="rates-one">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating nostar">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="rate-new"><span>$60</span> $30</div>
                        </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                <li class="last">
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES;?>auto3.jpg" >
                    <div class="pad-deal">
                      <div class="deal-title"><a href="#">20% Off Your Transmission Flush</a></div>
                      <div class="main-amc">
                        <div class="amc"><strong>McElveen Buick GMC</strong><br/>
                          Summerville, SC <br/>
                          <span>(2.5 Miles)</span></div>
                        <div class="rates-one">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating nostar">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="rate-new"><span>$100</span> $80</div>
                        </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                <li>
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES;?>auto4.jpg" >
                    <div class="pad-deal">
                      <div class="deal-title"><a href="#">40% Off Your A/C Re-charge</a></div>
                      <div class="main-amc">
                        <div class="amc"><strong>Firestone Complete Auto Care</strong><br/>
                          Goose Creek, SC<br/>
                          <span>(2.8 Miles)</span></div>
                        <div class="rates-one">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating nostar">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="rate-new"><span>$50</span> $30</div>
                        </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                <li>
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES;?>auto5.jpg" >
                    <div class="pad-deal">
                      <div class="deal-title"><a href="#">10% Off Your Raditor Flush</a></div>
                      <div class="main-amc">
                        <div class="amc"><strong>Marathon Automotive</strong><br/>
                          Summerville, SC <br/>
                          <span>(3.3 Miles)</span></div>
                        <div class="rates-one">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating nostar">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="rate-new"><span>$200</span> $100</div>
                        </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
                <li class="last">
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES;?>auto6.jpg" >
                    <div class="pad-deal">
                      <div class="deal-title"><a href="#">50% Off Auto Window Tinting</a></div>
                      <div class="main-amc">
                        <div class="amc"><strong>Clearview Auto Glass</strong><br/>
                          Moncks Corner, SC<br/>
                          <span>(4.1 Miles)</span></div>
                        <div class="rates-one">
                          <div class="fls">
                            <div class="rate">
                              <ul class="rating nostar">
                                <li class="one"><a href="#" title="1 Star">1</a></li>
                                <li class="two"><a href="#" title="2 Stars">2</a></li>
                                <li class="three"><a href="#" title="3 Stars">3</a></li>
                                <li class="four"><a href="#" title="4 Stars">4</a></li>
                                <li class="five"><a href="#" title="5 Stars">5</a></li>
                              </ul>
                            </div>
                          </div>
                          <div class="rate-new"><span>$300</span> $150</div>
                        </div>
                      </div>
                      <div class="clear"></div>
                    </div>
                  </div>
                  <div class="clear"></div>
                </li>
              </ul>
            </div>
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
                $lat = $response_a->results[0]->geometry->location->lat;
                $long= $response_a->results[0]->geometry->location->lng;
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