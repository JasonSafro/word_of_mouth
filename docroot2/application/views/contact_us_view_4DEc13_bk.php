<style>
    .s-message {
    background: none repeat scroll 0 0 #E6E8B7;
    border: 1px solid #AFAB10;
    border-radius: 5px 5px 5px 5px;
    color: #000000;
    float: left;
    margin: 0 78px;
    padding: 10px;
    width: auto;
}
.s-message span {
    cursor: pointer;
    display: block;
    float: right;
    height: 16px;
    width: 16px;
    margin-left: 8px;
}
</style>
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
    <div id="page-wrap">

        <div id="main1">
          <section class="inside-title">
          <div class="inside-title-in"><div  id="main">
          <h1>Contact Us</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home/">Home</a> | Contact Us</div></div>
          </div>
          </section>
        
        <div class="map-contact">
          <div id="googleMap" style="width:100%;height:350px;"></div>
        </div>
        <div class="clear"></div>
    
        </div>
        <div class="clear"></div>
 
      <div id="section">
        <section id="main"><div class="contact-main">
        
        
        
        <article class="section-left-inside-contact top-mar">
            <div class="dash"><?php echo $this->load->view('success_error_message_area');?></div>
            <h3>It would be great to hear from you! </h3>
        <h4>Do you have any quetions? Fill out the form below and we'll make sure to get back to you within 24 hours. </h4>
        <div class="clear"></div>
         <?php 
                    $attr = array('name' => 'frmCotactus', 'id' => 'frmCotactus', 'autocomplete' => 'off', 'method' => 'post');        
                    echo form_open_multipart('contact_us', $attr);
                    ?>
        <label>First Name *</label><input name="cnt_fname" type="text" value="<?php echo set_value('cnt_fname');?>"/><?php echo form_error('cnt_fname');?> 
         <label>Last Name *</label><input name="cnt_lname" type="text" value="<?php echo set_value('cnt_lname');?>"/><?php echo form_error('cnt_lname');?> 
          <label>Email Address *</label><input name="cnt_email" type="text" value="<?php echo set_value('cnt_email');?>"/><?php echo form_error('cnt_email');?> 
           <label>What's On Your Mind?</label><textarea name="cnt_msg" cols="" rows="7"></textarea><?php echo form_error('cnt_msg');?>
        <div class="conntact-buttons">
            <div class="tabs-contact">
                <div class="tab">
                    <input class="button1 orange wid" name="reset"type="reset" value="CLEAR FORM"/>
                    <!--<a href="#" class="button1 white wid" >CLEAR FORM</a>-->
                </div>
            </div>
            <div class="tabs-contact">
                <div class="tab">
                    <!--<a href="#" class="button1 orange wid" >SEND MESSAGE</a>-->
                    <input class="button1 white wid" name="submit"type="submit" value="SEND MESSAGE"/>
                </div>
            </div>
        </div>
            </form>
        
        
        </article>
        
        
        <article class="section-right-inside-contact">
        <div class="location">
       <div class="location-left"><img src="<?php echo USER_SIDE_IMAGES;?>location.png" width="11" alt="location"> </div>
       <div class="location-right">
       <h3>Location</h3>  
       <h4> <?php echo nl2br($setting['contactusAddress']);?></h4>
       </div>
       <div class="clear"></div>
       
       <div class="location-left"><img src="<?php echo USER_SIDE_IMAGES;?>question.png" width="15" alt="location"> </div>
       <div class="location-right">
       <h3>Question?</h3>  
       <h4> 
p: <?php echo $setting['contactusPhoneNumber'];?><br>
f:  <?php echo $setting['contactusFAXNumber'];?><br>
e: <?php echo $setting['contactusEmailAddress'];?></h4>
       </div>
       <div class="clear"></div>
               </div>
        </article>
        
        
        
        
        
        </div></section>
        
        
        
        
        
        
        
        
        
      </div>
    </div>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
	  	<?php  	//$venue = $cause_data[$i]['e_venue_name']." ".$cause_data[$i]['e_venue_addr'];
				$venue = $setting['contactusAddress'];
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