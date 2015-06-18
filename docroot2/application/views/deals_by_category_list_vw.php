
<script type="text/javascript" charset="utf-8">
                        
    function moreDeals(catId)
    {       
        var totalDeals      =$('#totalDeals').val();
        var dealLimit       =$('#dealLimit').val();
        var dealCurrentOffset=$('#dealCurrentOffset').val();
        var dealNextOffset  =$('#dealNextOffset').val();       
        
        $.ajax({
                type: "GET",                                        
                url: '<?php echo base_url() ?>deals_and_coupons/getNextDealsByCategory/'+catId+'/'+dealNextOffset,
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
          <h1>Deals &amp; Coupons | <?php echo $catagotyInfo[0]['catName'];?></h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home">Home</a> | <a href="<?php echo base_url();?>deals_and_coupons">Deals &amp; Coupons</a> | <?php echo $catagotyInfo[0]['catName'];?></div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>

      <div id="section">
        <section id="main">
          <article class="section-deals">
              <div class="blank">
              <h1>Choose Your Provider To See Deals & Coupons </h1>
            </div>
              <div class="zip-search">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearchForProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearch();");
                 echo form_open_multipart('deals_and_coupons/deals_by_category_search/'.$catId, $attr);
                 ?>
              <div class="search-pro">
                <div class="bg-pro">
                
                  <?php $previousSearchedProperty=$this->session->userdata('cat_dealsPropertySearchText');?>
                  <input name="propertySearchText" id="propertySearchText" type="text"  class="textfield"  value="<?php echo ($previousSearchedProperty!=""?$previousSearchedProperty:"Search for your provider");?>" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                  <input id="provider_name" type="submit" value="submit" name="provider_name"/>
                
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                
                    <?php $previousSearchedZipCode=$this->session->userdata('cat_dealsSrhBussZipCode');?>
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
           
            
            <!--<div class="viewing">Viewing All Deals & Coupons | <?php echo $catagotyInfo[0]['catName'];?></div>-->
            <div class="result-f"><?php //echo $totalRecords.' Results';?> </div>
            
            <?php if(!empty($dealList)){?>
            <div class="deals-main">
                <ul id="listContainner">
                    <?php 
                    $cnt=1;
                    foreach($dealList as $key=>$val){?>
                 <li class="<?php echo ($cnt%3==0 && $cnt!=0?'last':"");?>">
                  <div class="deal-boxes"><a href="<?php echo site_url('home/business_details/'.$val['dealBusinessId']); ?>"><img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$val['dealImage'];?>" ></a>
                  <div class="pad-deal"><div class="deal-title"><a href="<?php echo site_url('deals_and_coupons/view/'.$val['dealId']);?>"><?php echo substr(nl2br($val['dealOverview']),0,75).(strlen($val['dealOverview'])>75?"...":"");?></a></div> 
                  
                  <div class="main-amc">
                      <div class="amc"><a href="<?php echo site_url('home/business_details/'.$val['dealBusinessId']); ?>"><strong><?php echo $val['buss_name'];?></strong></a><br/>
                      <?php echo $val['buss_address'].','.$val['buss_city'].' - '.$val['buss_zip_code'];?><br/>
                      <span><?php if($myZipCode!=""){$distance=$this->geozip->get_distance($val['buss_zip_code'],$myZipCode); echo "($distance Miles)";}?></span>
                      </div>
                     <?php $ratingClasses=array(0=>'nostar',1=>'onestar',2=>'twostar',3=>'threestar',4=>'fourstar',5=>'fivestar'); 
                          if($this->session->userdata('user_id') == "")
                               $currentRating = $val['buss_avg_ratings'];
                          else{
                              $currentRating=_getBusinessRating($this->session->userdata('user_id'),$val['buss_id']);
                          }
                              //echo current_url();
                      ?>
                  
                  <div class="rates-one">
                  <div class="fls"><div class="rate">
                    <ul class="rating <?php echo $ratingClasses[$currentRating];?>">                         
                      <li class="one"><a href="#" onclick="saveratings(1,<?php echo $val['buss_id'];?>)" title="1 Star">1</a></li>
                      <li class="two"><a href="#" onclick="saveratings(2,<?php echo $val['buss_id'];?>)" title="2 Stars">2</a></li>
                      <li class="three"><a href="#" onclick="saveratings(3,<?php echo $val['buss_id'];?>)" title="3 Stars">3</a></li>
                      <li class="four"><a href="#" onclick="saveratings(4,<?php echo $val['buss_id'];?>)" title="4 Stars">4</a></li>
                      <li class="five"><a href="#" onclick="saveratings(5,<?php echo $val['buss_id'];?>)" title="5 Stars">5</a></li>                      
                    </ul>   
                  </div></div>
                  
                  <div class="rate-new"><span>$<?php echo $val['dealDiscounts'];?></span>  $<?php echo $val['dealValue']?></div></div>
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
                     <?php 
                         
                         /*if($totalRecords>$nextOffset){
                             $nextLimit=($limit + $offset);
                             $currentFunction=$this->uri->segment(2);*/
                         ?>
                      <?php if(($totalRecords-$showingRecords)>=1){                
                        $showingRecords=$showingRecords + 30;
                        $currentFunction=$this->uri->segment(2);
                        ?>
                     <div class="see-m" id="moreDeals"><?php echo anchor("deals_and_coupons/$currentFunction/$catId/$showingRecords","SEE $nextOffset MORE DEALS",array('class'=>'button2 orange1')); ?></div>
                     <!--<div class="see-m" id="moreDeals"><a class="button2 orange1" onclick="javascript: return moreDeals(<?php echo $catId;?>); return false;"><?php echo "SEE $nextOffset MORE DEALS";?></a></div>-->
                     <?php }?>
            <?php }?>
          </article>
          <div class="clear"></div>
        </section>
      </div>
    </div>

