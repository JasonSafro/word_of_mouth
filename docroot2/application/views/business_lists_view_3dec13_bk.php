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
        var xmlhttp=false;
        
        if (window.XMLHttpRequest)
        {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        }
        else
        {// code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function()
        {
            if (xmlhttp.readyState==4 && xmlhttp.status==200)
            {
                if(xmlhttp.responseText=="user_not_logged_in")
                {
                    alert("Please Login To give Ratings!");
                     window.location.href='<?php echo base_url() . 'business_lists/bus_list/'.$catId?>';
                }
                else{
                    alert("Ratings Added!");
                    window.location.href='<?php echo base_url() . 'business_lists/bus_list/'.$catId?>';
                    //document.getElementById("rated").innerHTML=xmlhttp.responseText;
                }
                
            }
        }
        xmlhttp.open("GET","<?php echo base_url(); ?>insert_ratings/insert_bus_ratings?rating=" + rating + "&busId=" + busId,true);
        xmlhttp.send("");
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
            
            <div class="zip-search">
              <div class="search-pro">
                <div class="bg-pro">
                    <form action="<?php echo base_url()?>home/business_list/<?php echo $catId;?>" method="post">                        
                  <input name="property" type="text"  class="textfield"  value="Search for your provider" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                    <input id="provider_name" type="submit" value="submit" name="provider_name">
                    </form>
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                  <input name="" type="submit" value="submit">
                  <input name="zipcode" type="text"  class="textfield"  value="Search by zipcode" onBlur="if(this.value=='')this.value='Search by zipcode';" onFocus="if(this.value=='Search by zipcode')this.value='';"/>
                </div>
              </div>
            </div>
            <div class="deal-box">                
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
                    <img src="<?php echo base_url()?>LOGO/<?php echo $val['user_id']."/".$val['buss_logo']; ?>" width="361px" height="214px"/>
                  <div class="pad-deal">    
                      
                  <div class="deal-tmain">
                      
                      <div class="deal-titlel">
                          <a href="#">Jiffy Lube</a>
                      </div>
                              <?php
                              
                              if (($this->session->userdata('user_id') == "")==$val['rat_uid'])
                              {
                                 //Show Average Ratings
                                  if($val['rat_stars']!=NULL)
                                  $currentRating = $val['rat_stars'];
                                  else
                                      $currentRating = $val['buss_avg_ratings'];
                                 // $currentRating = $val['buss_avg_ratings'];
                              }
                              else
                              {
                                  $currentRating = $val['buss_avg_ratings'];
                                //Show User Given Rating                                 
                               /*   if ($ratings_by_user != '')
                                  {
                                      foreach ($ratings_by_user as $key => $val1)
                                      {
                                          if ($val1['buss_id'] == $val['buss_id'])
                                          {
                                              echo $currentRating = $val1['rat_stars'];
                                          }
                                          else
                                          {
                                              $currentRating = 0;
                                          }
                                      }
                                  }*/
                              }
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
                      
                      
                  <div class="main-amc">
                      <div class="amc">                          
                          <strong><?php echo $val['buss_name'];?></strong>
                          <br/><?php echo $val['buss_address']?>, <?php echo $val['buss_city']?><br/>
                          <span>(1.4 Miles)</span>
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
            <?php $remaining_list=$total_count-$current_count;?>            
            <div class="showing">
                <span>
                  <?php if($total_count>9){?>
                    Showing <?php echo $current_count;?> of <?php echo $total_count;?>
                    <?php }else {?>
                    Showing  <?php echo $remaining_list;?> of <?php echo $current_count;}?>
                </span>
            </div>
             <div class="clear"></div>
             
            <div class="see-mone"> 
                <?php if($total_count>9 && $remaining_list!=0){
                    ?>                
                <a href="<?php echo base_url()?>home/business_list/<?php echo $catId;?>/<?php echo $current_count+9;?>" class="button3 orange1">SEE <?php if($remaining_list%9!=$remaining_list){?>9 <?php }else{ echo $remaining_list; }?> MORE PROVIDERS</a>       
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