
<script type="text/javascript" charset="utf-8">
                        
    function moreDeals()
    {       
        var totalDeals      =$('#totalDeals').val();
        var dealLimit       =$('#dealLimit').val();
        var dealCurrentOffset=$('#dealCurrentOffset').val();
        var dealNextOffset  =$('#dealNextOffset').val();       
        
        $.ajax({
                type: "GET",                                        
                url: '<?php echo base_url() ?>deals_and_coupons/getNextDealsSearch/'+dealNextOffset,
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
          <h1>Deals &amp; Coupons</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home">Home</a> | <a href="<?php echo base_url();?>deals_and_coupons">Deals &amp; Coupons</a> | Search</div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>

      <div id="section">
        <section id="main">
          <article class="section-deals">
            <div class="blank">
              <h1>Viewing All Deals & Coupons </h1>
            </div>           
            
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
            </div>  
            <div class="result-f"><?php echo $totalRecords;?> Results</div>
            
            <?php if(!empty($dealList)){?>
            <div class="deals-main">
                <ul id="listContainner">
                    <?php 
                    $cnt=1;
                    foreach($dealList as $key=>$val){?>
                 <li class="<?php echo ($cnt%3==0 && $cnt!=0?'last':"");?>">
                  <div class="deal-boxes"> <img src="<?php echo USER_SIDE_IMAGES.'deal_images/thumbs/'.$val['dealImage'];?>" >
                  <div class="pad-deal"><div class="deal-title"><a href="<?php echo site_url('deals_and_coupons/view/'.$val['dealId']);?>"><?php echo substr(nl2br($val['dealOverview']),0,100);?></a></div> 
                  
                  <div class="main-amc"><div class="amc"><strong><?php echo $val['buss_name'];?></strong><br/><?php echo $val['buss_city'].','.$val['buss_addr_addon'];?><br/><span>(1.5 Miles)</span></div>
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
                             $nextLimit=($limit + $offset);*/
                         ?>
                     <?php if(($totalRecords-$showingRecords)>=1){                
                        $showingRecords=$showingRecords + 30;
                        $currentFunction=$this->uri->segment(2);
                        ?>
                     <div class="see-m" id="moreDeals"><?php echo anchor("deals_and_coupons/search/$showingRecords","SEE $nextOffset MORE DEALS",array('class'=>'button2 orange1')); ?></div>
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
































