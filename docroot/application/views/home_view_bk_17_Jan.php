<div id="page-wrap">
      <div class="banner">
        <div id="main1">
          <section class="slider">
            <div class="flexslider">
              <ul class="slides">
                  <?php $homePageSliders=_getHomePageSliders();
                  foreach($homePageSliders as $key=>$val){
                  ?>
                <li>
                  <div class="banner-bg1"><div class="banner1">
                    <div class="banner-left"><img src="<?php echo SITE_ROOT_FOR_USER . 'sitedata/slider_images/' . $val['sldrImage']; ?>" alt="people"></div>
                    <div class="banner-right">
                      <h1><?php echo $val['sldrTitle'];?></h1>
                      <p><?php echo $val['sldrSubTitle'];?></p>
                      <div class="tab"><a href="<?php echo site_url('aboutus');?>" class="button1 orange" style="width:155px;" >Learn More Today</a></div>
                      <div class="medias">
                        <div class="blank">Sign In Socially:</div>
                        <div class="blank1">
                          <ul class="head_soc">
                            <li><a href="<?php echo base_url()?>tweet_test/"><img src="<?php echo USER_SIDE_IMAGES;?>h1.png" alt=""></a><span class="refl1"></span></li>
                            <li><a href="<?php echo base_url()?>user/connect/"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png" alt=""></a><span class="refl2"></span></li>
                            <li><!--<a href="http://www.pinterest.com/pin/create/button/
        ?url=http%3A%2F%2Fwww.flickr.com%2Fphotos%2Fkentbrew%2F6851755809%2F
        &media=http%3A%2F%2Ffarm8.staticflickr.com%2F7027%2F6851755809_df5b2051c9_z.jpg
        &description=Next%20stop%3A%20Pinterest">--><img src="<?php echo USER_SIDE_IMAGES;?>h3.png" alt=""><!--</a>--><span class="refl3"></span></li>
                            <li><a href="<?php echo base_url()?>linkedin_login/"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png" alt=""></a><span class="refl4"></span></li>
                          
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="clear"></div>
                  </div></div>
                </li>
                <?php }?>
               <!-- <li>
                  <div class="banner2">
                    <div class="banner-left"><img src="<?php echo USER_SIDE_IMAGES;?>people2.jpg" alt="people"></div>
                    <div class="banner-right">
                      <h1 class="blue">Sitato Tiaso</h1>
                      <p class="blue">Cras justo odio, dapibus ac facilisis in, egestas eget quam donec sed odio dui. Donec id elit non mi port gravida at eget metus. </p>
                      <div class="tab"><a href="#" class="button1 orange" style="width:155px;" >Learn More Today</a></div>
                      <div class="medias">
                        <div class="blank blue">Sign In Socially:</div>
                        <div class="blank1">
                          <ul class="head_soc">
                            <li><a href=""><img src="<?php echo USER_SIDE_IMAGES;?>h1.png" alt=""></a><span class="refl1"></span></li>
                            <li><a href="<?php echo base_url()?>user/connect/"><img src="<?php echo USER_SIDE_IMAGES;?>h2.png" alt=""></a><span class="refl2"></span></li>
                            <li><a href=""><img src="<?php echo USER_SIDE_IMAGES;?>h3.png" alt=""></a><span class="refl3"></span></li>
                            <li><a href="<?php echo base_url()?>linkedin_login/"><img src="<?php echo USER_SIDE_IMAGES;?>h4.png" alt=""></a><span class="refl4"></span></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="clear"></div>
                  </div>
                </li>-->
              </ul>
            </div>
          </section>
        </div>
        <div class="clear"></div>
      </div>
      <div id="section">
        <section id="main">
          <article class="section-left">
            <div class="blank">
              <h1>Choose Your Provider Type Below</h1>
            </div>
            <div class="zip-search">
              <div class="search-pro">
                <div class="bg-pro">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearchForProvider', 'id' => 'frmBusinessSearchForProvider', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateProviderSearchTest();");
                 echo form_open_multipart('home/search_by_provider', $attr);
                 ?>
                  <?php $previousSearchedProperty=$this->session->userdata('homePropertySearchText');?>
                  <input name="propertySearchText" id="propertySearchText" type="text"  class="textfield"  value="<?php echo ($previousSearchedProperty!=""?$previousSearchedProperty:"Search for your provider");?>" onBlur="if(this.value=='')this.value='Search for your provider';" onFocus="if(this.value=='Search for your provider')this.value='';"/>
                  <input id="provider_name" type="submit" value="submit" name="provider_name"/>
                <?php echo form_close();?>  
                   
                </div>
              </div>
               <?php //echo "data".$this->session->userdata('providername');?>
              <div class="search-pro1">
                <div class="bg-pro1">
                 <?php 
                 $attr = array('name' => 'frmBusinessSearch', 'id' => 'frmBusinessSearch', 'autocomplete' => 'off', 'method' => 'post','onsubmit'=>"javascript: return validateZipCode();");
                 echo form_open_multipart('home/search_by_zipcode', $attr);
                 ?>
                    <?php $previousSearchedZipCode=$this->session->userdata('homeSrhBussZipCode');?>
                  <input name="zipSubmit" type="submit" value="submit"/>
                  <input name="srhBussZipcode" id="srhBussZipcode" type="text" class="textfield"  value="<?php echo ($previousSearchedZipCode!=""?$previousSearchedZipCode:"Search by zipcode");?>" onBlur="if(this.value=='')this.value='Search by zipcode';" onFocus="if(this.value=='Search by zipcode')this.value='';"/>
                  <?php echo form_close();?>
                </div>
              </div>
            </div>
              
              <div class="box">
                  
              <?php if(!empty($categories))
                         {
                            $cnt=0;?>
                  <div class="line-one">
                        <ul>
                            <?php 
                            foreach($categories as $key=>$val)
                            {
                                $cnt++;?>
                                        <li><a href="<?php echo base_url()?>home/business_list/<?php echo $val['catId'];?>"><?php echo $val['catName'];?> <img src="<?php echo base_url()."category_images/".$val['catImageName'];?>" alt="images"height="16"width="21"></a></li>                                      
                                <?php 
                                if($cnt%4==0) {
                                ?>
                                  </ul>
                                  </div>
                                <div class="line-one">
                                <ul>
                                  <?php }?>  
                                
                <?php  } ?>
                
                    
                <?php }else{?>
                <div class="blank">
              <h1>No Providers Found!!</h1>
            </div>
                <?php }?>
            </div>
              
              
              
              
              
          </article>
          <!--<article class="section-right">
            <div class="blank">
              <h1> Testimonials </h1>
            </div>
            <div class="box1"> 
               <ul id="parent2">
                <li>
                  <div class="client"><img src="images/1.jpg"></div>
                  <div class="name">Kelly Anderson<br/>
                    <span>Director of Marketing | National Beauty Supplies</span></div>
                  <div class="text">Morbi leo risus, porta ac consectetur ac,
                    vestibulumad<br/> dawa<br/>at eros. Curabitur blandit tempus porttitor. Camsocfoc</div>
                </li>
                <li>
                  <div class="client"><img src="images/2.jpg"></div>
                  <div class="name">James Wattson<br/>
                    <span>Director of Marketing | National Beauty Supplies</span></div>
                  <div class="text">Morbi leo risus, porta ac consectetur ac,<br/>
                    vestibulumad dawa at eros. Curabitur blandit tempus porttitor. Camsocfoc</div>
                </li>
                <li>
                  <div class="client"><img src="images/1.jpg"></div>
                  <div class="name">Kelly Anderson<br/>
                    <span>Director of Marketing | National Beauty Supplies</span></div>
                  <div class="text">Morbi leo risus, porta ac consectetur ac,<br/>
                    vestibulumad dawa at eros. Curabitur blandit tempus porttitor. Camsocfoc</div>
                </li>
                <li>
                  <div class="client"><img src="images/2.jpg"></div>
                  <div class="name">James Wattson<br/>
                    <span>Director of Marketing | National Beauty Supplies</span></div>
                  <div class="text">Morbi leo risus, porta ac consectetur ac,<br/>
                    vestibulumad dawa at eros. Curabitur blandit tempus porttitor. Camsocfoc</div>
                </li>
              </ul>
            </div>
          </article>-->
          
          
          <article class="section-right"><div class="blank">
              <h1> Testimonials </h1>
            </div>
            
   
            <div id="canadaprovinces" class="glidecontentwrapper">
<?php if(!empty($testimonials)){
    foreach($testimonials as $key=>$val){
    ?>
<div class="glidecontent">
<div class="box1">
              <ul>
                <li>
                  <div class="client"><img width="329" height="100" src="<?php echo SITE_ROOT_FOR_USER;?>sitedata/testimonials_images/<?php echo $val['tmlImage'];?>"/></div>
                  <div class="name"><?php echo $val['tmlPersonName'];?><br/>
                    <span><?php echo $val['tmlDesignation'];?></span></div>
                  <div class="text"><?php echo nl2br($val['tmlDescription']);?></div>
                </li></ul></div>
</div>
<?php }
}?>
</div>
<?php if(!empty($testimonials)){?>
<div id="p-select" class="glidecontenttoggler">
<?php 
$cnt=1;
foreach($testimonials as $key=>$val){?>    
<!--<a href="#" class="prev">Prev</a> -->
<a href="#" class="toc">Page <?php echo $cnt;?></a>
<?php $cnt++; }?>
<!--<a href="#" class="next">Next</a>-->
</div>
<?php }?>
            </article>
          
          
          
          <div class="clear"></div>
        </section>
      </div>
    </div>
    
<script type="text/javascript" src="//assets.pinterest.com/js/pinit.js"></script>
<script type="text/javascript">
(function(d){
    var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
    p.type = 'text/javascript';
    p.async = true;
    p.src = '//assets.pinterest.com/js/pinit.js';
    f.parentNode.insertBefore(p, f);
}(document));
</script>




<script defer src="<?php echo base_url() ?>assets/scripts/jquery.flexslider.js"></script> 
<script type="text/javascript">
    $(function(){
      //SyntaxHighlighter.all();
    });
    $(window).load(function(){
      $('.flexslider').flexslider({
        animation: "slide",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });
</script>


<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

<?php
echo js_asset("featuredcontentglider.js");
?>
<script type="text/javascript">

featuredcontentglider.init({
	gliderid: "canadaprovinces", //ID of main glider container
	contentclass: "glidecontent", //Shared CSS class name of each glider content
	togglerid: "p-select", //ID of toggler container
	remotecontent: "", //Get gliding contents from external file on server? "filename" or "" to disable
	selected: 0, //Default selected content index (0=1st)
	persiststate: false, //Remember last content shown within browser session (true/false)?
	speed: 500, //Glide animation duration (in milliseconds)
	direction: "rightleft", //set direction of glide: "updown", "downup", "leftright", or "rightleft"
	autorotate: true, //Auto rotate contents (true/false)?
	autorotateconfig: [3000, 2], //if auto rotate enabled, set [milliseconds_btw_rotations, cycles_before_stopping]
	onChange: function(previndex, curindex, $allcontents){ // fires when Glider changes slides
  		//custom code here
	}
})

</script>

<script>
    jQuery.noConflict( true );
</script>