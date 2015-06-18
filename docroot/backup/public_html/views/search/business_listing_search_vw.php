<?php 
echo css_asset("address-popup.css");
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
          <h1><?php echo $buss_category;?></h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>">Home</a> | Provider | <?php echo $buss_category;?> </div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>
      <div id="section">
        <section id="main">
          <article class="section-deals">
            <div class="blank">
              <h1><?php echo $buss_category;?>  Related Provider</h1>
            </div>           
             <div class="zip-search1">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearchProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearch();");
                 echo form_open_multipart('business_lists/category_search/'.$catId, $attr);
                 ?>
                <div class="adsearch-tab"> <?php echo anchor('advance_search','Advance Search');?></div>
              <div class="search-pro">
                <div class="bg-pro">
                 <?php 
                 //$attr = array('name' => 'frmBusinessSearchForProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearchTest();");
                 //echo form_open_multipart('business_lists/search_by_provider/'.$catId, $attr);
                 ?>
                  <?php $previousSearchedProperty=$this->session->userdata('propertySearchText');?>
                  <input name="propertySearchText" id="propertySearchText" type="text"  class="textfield"  value="<?php echo ($previousSearchedProperty!=""?$previousSearchedProperty:"Search for your provider");?>" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                  <input id="provider_name" type="submit" value="submit" name="provider_name"/>
                <?php //echo form_close();?>  
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                 <?php 
                 //$attr = array('name' => 'frmBusinessSearch', 'id' => 'frmBusinessSearch', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateZipCode();");
                 //echo form_open_multipart('business_lists/search_by_zipcode/'.$catId, $attr);
                 ?>
                    <?php $previousSearchedZipCode=$this->session->userdata('srhBussZipCode');?>
                  <input name="zipSubmit" type="submit" value="submit"/>
                  <input name="srhBussZipcode" id="srhBussZipcode" type="text" class="textfield"  value="<?php echo ($previousSearchedZipCode!=""?$previousSearchedZipCode:"Search by zipcode");?>" onBlur="if(this.value=='')this.value='Search by zipcode';" onFocus="if(this.value=='Search by zipcode')this.value='';"/>
                  <?php //echo form_close();?>
                </div>
              </div>
             <?php echo form_close();?>   
            </div>
              
            <div class="deal-box2">  
                <div class="line-one1">
                  <?php if(!empty($categories)){?>
                  <ul><?php $cnt=1;
                  foreach($categories as $key=>$val){?>
                      <li <?php echo ($cnt%6==0?'class="last"':'');?>>
                          <a href="<?php echo site_url('home/business_list/'.$val['catId']);?>"><?php echo substr(trim($val['catName']),0,14);?><img src="<?php echo base_url()."category_images/".$val['catImageName'];?>" alt="images"height="13"width="30"></a>
                      </li>
                  <?php $cnt++; }
                  ?>    
                  </ul>
                  <?php }else{?>
                  <h1>No Providers Found!!</h1>
               <?php }?>
              </div>   
            </div>               
             
            <div class="deals-mainnew">
                <?php if(!empty($bus_list))
                         {
                            $ratingClasses=array(0=>'nostar',1=>'onestar',2=>'twostar',3=>'threestar',4=>'fourstar',5=>'fivestar'); 
                            $cnt=0;?> 
              <ul>                 
                   <?php foreach($bus_list as $key=>$val)
                            { $cnt++;?>
                <li <?php echo ($cnt!=0 && $cnt%3==0?'class="last"':'')?>>                     
                  <div class="deal-boxes">
                      <a href="<?php echo site_url('home/business_details/'.$val['buss_id']);?>">
                    <img src="<?php echo base_url()?>LOGO/<?php echo "/".$val['buss_logo']; ?>" width="361px" height="214px" title="View business details"/></a>
                  <div class="pad-deal">    
                      
                  <div class="deal-tmain">
                      
                      <div class="deal-titlel">
                          <a href="<?php echo site_url('home/business_details/'.$val['buss_id']);?>" title="View business details"><?php echo $val['buss_name'];?></a>
                      </div>
                       <?php
                              if($this->session->userdata('user_id') == "")
                                   $currentRating = $val['buss_avg_ratings'];
                              else{
                                  $currentRating=_getBusinessRating($this->session->userdata('user_id'),$val['buss_id']);
                              }
                              //echo current_url();
                              ?>      
                                      
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
                      <?php //echo '<pre>'; print_r($val);?>
                      
                  <div class="main-amc">
                      <div class="amc">                          
                          <strong><?php echo $val['buss_name'];?></strong>
                          <br/><?php echo $val['buss_address'].', '.$val['buss_city'].', '.$val['stateName'].', '.$val['buss_zip_code']?><br/>
                          <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($val['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span>
                      </div>
                  <div class="rates-one">
                     <div class="rate-newr">
                         <a href="<?php echo base_url()?>home/business_details/<?php echo $val['buss_id'];?>">VIEW DETAILS</a>
                     </div>
                  <div class="fls"></div>                  
                  </div>
                  </div>
                  <div class="clear"></div></div>
                  </div>
                  <div class="clear"></div>
                </li>
                <?php }?>
              </ul>
                <?php }else{?>
                <div class="blank">
              <h1>No Providers Found!!</h1>
            </div>
                <?php }?>
            </div>
            <?php $remaining_list=$total_count-$current_count;
            //echo $total_count.' My Test';
            ?>            
            <div class="showing">
                <span>
                    Showing <?php echo $current_count;?> of <?php echo $total_count;?>
                </span>
            </div>
             <div class="clear"></div>
             
            <div class="see-mone"> 
                <?php if($total_count>9 && $remaining_list!=0){
                    ?>                
                <a href="<?php echo base_url()?>business_lists/search_by_zipcode/<?php echo $catId;?>/<?php echo $current_count+9;?>" class="button3 orange1">SEE <?php if($remaining_list>=9){?>9 <?php }else{ echo $remaining_list; }?> MORE PROVIDERS</a>       
                <?php }
                else
                {?>
                    <a href="<?php echo base_url()?>" class="button3 orange1">GO BACK</a>       
                <?php }?>                              
            </div>             
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
