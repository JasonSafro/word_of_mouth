<!--footer start from here-->
    <footer>
      <div class="footer-in">
        <div class="links">
          <h2>Quick Links</h2>
          <ul>
            <li><a href="<?php echo base_url()?>home/">» Home</a></li>
            <li><a href="<?php echo base_url()?>aboutus/">» About Us</a></li>
            <li><a href="<?php echo base_url()?>how_it_works/">» How it Works</a></li>
            <li><a href="<?php echo base_url()?>services/">» Our Services</a></li>
            <li><a href="<?php echo base_url()?>deals_and_coupons/">» Deals & Coupons</a></li>
            <li><a href="<?php echo base_url()?>we_are_hiring/">»  We’re Hiring</a></li>
            <li><a href="<?php echo base_url()?>faq/">» FAQ</a></li>
            <li><a href="<?php echo base_url()?>contact_us/">» Contact Us</a></li>
          </ul>
        </div>
        <div class="line1"></div>
        <div class="videos">
          <h2>Some of Our Videos</h2>
          <ul>
              <?php 
              $currentSeg=$this->uri->segment(1);
              $footerVideos=_getFooterVideos($currentSeg);?>
             <?php foreach($footerVideos as $key=>$val){?>
            <li>
              <div class="promo">
                  <a onclick="playFooterVideo('myFooterVideoModal_<?php echo $key;?>')" href="#" data-reveal-id="myFooterVideoModal_<?php echo $key;?>"><img src="<?php echo SITE_ROOT_FOR_USER.'sitedata/footer_videos_images/'.$val['fvImage'];?>" alt="video"></a>
                  <p><span><?php echo $val['fvTitle'];?></span><br/><?php echo $val['fvDescription'];?></p>
              </div>
              <div class="dating">
                <!--<div class="calendar"><?php echo substr($val['fvUpdatedOn'],0,10);?></div>-->
                <a href="<?php echo prep_url($val['fvReadMoreLink']);?>" class="button orange" style="width:85px;" target="_blanck">Read More</a></div>
              <div class="clear"></div>
            </li>
            <?php }?>
          </ul>
        </div>
        <div class="line1"></div>
        <div class="stay">
          <h2>Stay Connected</h2>
          <div class="bottom-logo"><img src="<?php echo USER_SIDE_IMAGES;?>logo-bottom.png" alt="logo"></div>
          <?php $footerRightContent=_getFooterRightContent();?>
          <div class="afew"><span><?php echo $footerRightContent[0]['pageHeading'];?></span><br/><?php echo $footerRightContent[0]['pageContent'];?></div>
          <div class="social1">
            <ul>
              <li><a href="https://twitter.com/WOMReferral" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>twitt1.png" alt="twitter"/></a></li>
              <li><a href="https://www.facebook.com/WordOfMouthReferral" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>facebook1.png" alt="facebook"/></a></li>
              <li><a href="http://www.pinterest.com/mouthreferral/" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>printrest1.png" alt="printrest"/></a></li>
              <li><a href="http://www.linkedin.com/pub/Keri-seay/12/632/544" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>linked-in1.png" alt="linked-in"/></a></li>
              <li><a href="http://www.youtube.com/channel/UChsAXAMLDVAewzhrAdevQ-w" target="_blank"><img src="<?php echo USER_SIDE_IMAGES;?>YouTube.png" alt="youtube" height="25"/></a></li>
            </ul>
          </div>
        </div>
        <div class="footer-bottom">
          <div class="copy">© 2013 Word of Mouth, Inc. All rights reserved.</div>
           <div class="mail"><a href="mailto:info@wordofmouthreferral.com" target="_top">info@wordofmouthreferral.com</a></div>
          <div class="phone"><?php echo _getHeaderPhoneNo();?></div>
        </div>
      </div>
    </footer>
  </div>
  <div class="clear"></div>
</div>


<!--lightbox vidfeo player appearing from here-->
<?php foreach($footerVideos as $key=>$val){?>
<div id="myFooterVideoModal_<?php echo $key;?>" class="reveal-modal" style="display:none;">
    <article class="p-marg">
        <div class="js-video [vimeo, widescreen]">
                <iframe allowfullscreen="" frameborder="0" height="317" src="<?php echo prep_url($val['fvYouTubeVideoLink']);?>" width="455"></iframe>
        </div>
    </article>
  <a class="close-reveal-modal">&#215;</a> 
</div>
<?php }?>
<!--lightbox vidfeo player end here-->


</div>
<p id="back-top"><a href="#top"><span></span></a> </p>
<!-- FlexSlider --> 
<script>
$(document).ready(function(){

	// hide #back-top first
	$("#back-top").hide();
	
	// fade in #back-top
	$(function () {
		$(window).scroll(function () {
			if ($(this).scrollTop() > 100) {
				$('#back-top').fadeIn();
			} else {
				$('#back-top').fadeOut();
			}
		});

		// scroll body to 0px on click
		$('#back-top a').click(function () {
			$('body,html').animate({
				scrollTop: 0
			}, 800);
			return false;
		});
	});

});

function playFooterVideo(footerVideoId){
    $('#'+footerVideoId).css('display','inline')
}
</script>


</body>
</html>