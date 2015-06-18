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

<?php echo js_asset("jquery.selectbox-0.2.js");?>

<script type="text/javascript">  
	/*$(function () {
	$("#country_id").selectbox();
	});
	$(function () {
	$("#searchState").selectbox();
	});
	$(function () {
	$("#rating_id").selectbox();
	});*/
</script>


    <div id="page-wrap">

        <div id="main1">
          <section class="inside-title">
              <div class="inside-title-in"><div  id="main">
              <h1>Advance Search</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home/">Home</a> |  <?php echo anchor('home/dashboard','Dashboard'); ?> | Advance search</div></div>
              </div>
          </section>
        </div>
        <div class="clear"></div>
 
      <div id="section">
        <section id="main">
            <div class="contact-main">
            <article class="section-deals">
                 <div class="blank">
                  <h1>Advance Search</h1>
                </div>  
              </div>
            
            
            
        <div class="deal-box">
                <div class="main-search" id="show-hide">
              <h2>Advanced Search</h2>
              
              
              
              
              
              <?php 
                $attr = array('name' => 'frmAdvanceSearch', 'id' => 'frmAdvanceSearch', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateZipCode();");        
                echo form_open_multipart('advance_search/do_search', $attr);
                ?>
              
              <div style="display:none;">
                      <div class="box latlong">
                        <label for="lat">Latitude</label>
                        <input type="text" name="lat" id="lat" />

                        <label for="lng">Longitude</label>
                        <input type="text" name="lng" id="lng" />
                    </div>
             </div>
              <div id="latlongmap" style="width:100%; height:300px;"></div>
              <br/>
              <p>You can hold and move marker to anywhere you want to get the lat long of near places of your address. This geo process is also known as <em>geocode address</em>.</p>
              <br/>
              
              <div class="blanks-bg">
                <div class="ones">
                  <label>Zip Code</label>
                  <div class="bg-ins">
                    <input name="zipCode" id="advanceZipCode" type="text" value="<?php echo set_value('zipCode',$zipCode);?>"/>
                  </div>
                  <?php echo form_error('zipCode');?> 
                </div>
                  
                <div class="twos">
                  <label>Country</label>
                  <div class="bg-ins">
                      
                      
                      
                      <div class="select-style">
                          <select name="country" id="advanceSearchCountry" onchange="changeStateList(this.value);">
     <?php 
                        $countryList= _getCountryList();
                        foreach($countryList as $key=>$val){?>
                            <option value="<?php echo $key;?>" <?php if($key=='USA'){?> selected <?php }?>><?php echo $val;?></option>
                        <?php }
                        ?>       
  </select>
</div>

                      
                      
                      
                      
                      
                  </div>
                </div>
                <div class="twos">
                  <label>State</label>
                  <div class="bg-ins">
                      <div class="select-style">
                      <?php 
                        $xy='id="searchState" class="" ';
                        $stateArray=array('','Choose your state');// _getStateList()
                        echo form_dropdown('state',$stateArray,set_value('state'),$xy);
                    ?>
                      
                     </div> 
                      
                      
                      

                      
                      
                      
                  </div>
                </div>
                <div class="twos">
                  <label>City</label>
                  <div class="bg-ins">
                    <input name="city" type="text" value="<?php echo set_value('city',$city);?>"/>
                  </div>
                  <?php echo form_error('city');?> 
                </div>
                
                <div class="twos">
                  <label>Radius</label>
                  <div class="bg-ins">
                    <input name="radius" type="text" value="<?php echo set_value('radius',$radius);?>"/>
                  </div>
                  <?php echo form_error('radius');?> 
                </div>
                
                <div class="twos">
                  <label>Minimum Rating</label>
                  <div class="bg-ins">
                      <div class="select-style">
                      <?php 
                        $xy='id="rating_id" class=""';
                        $ratingArray=array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');// _getStateList()
                        echo form_dropdown('minRating',$ratingArray,set_value('minRating',$minRating),$xy);
                    ?>
                          </div>
                  </div>
                </div>
              </div>
              <div class="blanks-bg">
                  <div class="twos">
                      <label>Has images?</label>
                      <div class="l-div">
                          <input type="radio" name="hasImage" id="hasImage" value="yes" <?php echo set_radio('hasImage','yes');?>/> Yes
                          <input type="radio" name="hasImage" id="notHasImage" value="no" <?php echo set_radio('hasImage','no');?>/> No
                      </div>
                  </div>
                  
                  <div class="twos">
                      <label>Has video?</label>
                      <div class="l-div">
                        <input type="radio" name="hasVideo" id="hasVideo" value="yes" <?php echo set_radio('hasVideo','yes');?>/> Yes
                        <input type="radio" name="hasVideo" id="notHasVideo" value="no" <?php echo set_radio('hasVideo','no');?>/> No
                      </div>
                  </div>
                  
                  <div class="twos">
                      <label>Has additional info?</label>
                      <div class="l-div">
                          <input type="radio" name="hasAdditionalInfo" id="hasAdditionalInfo" value="yes" <?php echo set_radio('hasAdditionalInfo','yes');?>/> Yes
                          <input type="radio" name="hasAdditionalInfo" id="notFasAdditionalInfo" value="no" <?php echo set_radio('hasAdditionalInfo','no');?>/> No
                      </div>
                  </div>
                  
                  <div class="twos">
                    <label>Has offers?</label>
                    <div class="l-div">
                        <input type="radio" name="hasOffers" id="hasOffers" value="yes" <?php echo set_radio('hasOffers','yes');?>/> Yes
                        <input type="radio" name="hasOffers" id="notHasOffers" value="no" <?php echo set_radio('hasOffers','no');?>/> No
                    </div>
                  </div>
                  
                  
                  <div class="twos">
                  <input name="" type="submit" value="SEARCH"/>
                  </div>
              </div>
                </form>
            </div>                
            </div>  
        
        
        
        
        </article>
        
        </div>
        </section>
      </div>
    </div>
    
    
<script type="text/javascript">
    function validateZipCode()
    {
        var srhBussZipcode=$('#advanceZipCode').val();
        if(srhBussZipcode!="")
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

<script>
    
    if($('#advanceSearchCountry').val()!='')
        changeStateList($('#advanceSearchCountry').val())
    
    function changeStateList(countryCode)
    {       
        $.ajax({
                    type: "GET",                                        
                    url: '<?php echo base_url() ?>services/getStateList/'+countryCode,
                    dataType:"json",
                    success: function (data) {
                                var option_str = document.getElementById('searchState');
                                option_str.length=0;    // Fixed by Julian Woods
                                option_str.options[0] = new Option('Choose your state','');
                                option_str.selectedIndex = 0;                               
                               $.each(data, function(i, v) {
                                    option_str.options[option_str.length] = new Option(v.text,v.val);
                                });
                                //$('#p_userState').parent().children(':not(#p_userState)').remove();
                                //$('#p_userState').selectbox();
                    }
            });
    }
</script>  


<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
  
    var map;
    var geocoder;
    var marker;

    function initialize() {
        //var latlng = new google.maps.LatLng(1.10, 1.10);
        var latlng = new google.maps.LatLng(39.649689, -101.074219);
        var myOptions = {
            zoom: 5,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.ROADMAP 
        };
        map = new google.maps.Map(document.getElementById("latlongmap"),
        myOptions);
        geocoder = new google.maps.Geocoder();
        marker = new google.maps.Marker({
            position: latlng, 
            map: map
        });

        map.streetViewControl=false;

        google.maps.event.addListener(map, 'click', function(event) {
            marker.setPosition(event.latLng);

            var yeri = event.latLng;            
            document.getElementById('lat').value=yeri.lat().toFixed(6);
            document.getElementById('lng').value=yeri.lng().toFixed(6);
            getZipCode(yeri.lat().toFixed(6),yeri.lng().toFixed(6));
        });
    }
initialize();

function getZipCode(lat,lang)
{
    //$.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng=40.714224,-73.961452&sensor=true', function(data) {
    $.getJSON('http://maps.googleapis.com/maps/api/geocode/json?latlng='+lat+','+lang+'&sensor=true', function(data) {
       var obj = eval (data); 
      
       //var onj2=obj.results[1].address_components;
       //var zipCode=onj2[6].long_name;
       //$('#advanceZipCode').val(zipCode);
       
       $('#advanceZipCode').val("");
       $.each(obj.results, function(index,value){
           $.each(value, function(index2,value2){
               if(index2=="address_components")
               {
                   $.each(value2, function(index3,value3){                        
                        if(value3.types=="postal_code")
                        {   
                            // for multiple zip codes, if have you can user the following commented code
                            /*var zipcode=$('#advanceZipCode').val();
                            if(zipcode=="")
                                $('#advanceZipCode').val(value3.long_name);
                            else
                                $('#advanceZipCode').val(zipcode+","+value3.long_name);*/
                            $('#advanceZipCode').val(value3.long_name);
                            console.log("Zipcode: "+ value3.long_name);
                            return false;
                        }
                   });
               }    
               
           });
       });
        //alert(data['results']['address_components']);
        //return fb_count;
    }); 
}

</script>

