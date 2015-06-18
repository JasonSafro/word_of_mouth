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
          <?php $info=$info[0];?>
          <h1><?php echo $info['buss_name']; ?> | Review </h1>
              <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <?php echo anchor('home','Home');?> | <?php echo anchor('home/business_details/'.$info['rvwBusinessId'],$info['buss_name']); ?></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>   
      <div id="section">
        <section id="main"><div class="contact-main">                
         
               
                <article class="section-deals">
          
          <div class="viewing">Reviews</div>
          
          <div class="reviews">
          <ul>
              <?php $ratingArray=array(1=>'Awful',2=>'Poor',3=>'Average',4=>'Good',5=>'Excellent');?>
          <li>
  <div class="review-l">
    <h2><a href="#"><?php echo $info['rvwReviewerName'];?></a></h2>
    <p><strong>Review Description:</strong><br/>
     <?php echo nl2br($info['rvwDetails']);?></p>
  </div>
  <div class="review-r">
    <p> <strong>Phone:</strong> <?php echo $info['rvwPhoneNo'];?><br/>
      <strong>Rating on Professionalism:</strong> <?php echo $ratingArray[$info['rvwRatingProfessionalism']];?><br/>
      <strong>Rating on Dependability:</strong> <?php echo $ratingArray[$info['rvwRatingDependability']];?><br/>
      <strong>Rating on Price:</strong> <?php echo $ratingArray[$info['rvwRatingPrice']];?><br/>
      <strong>Overall Rating:</strong> <?php echo $ratingArray[$info['rvwRatingOverall']];?><br/>
    
    </p>
  </div>
  <div class="clear"></div>
</li>

          
          </ul>
          
          </div>
          
          <!--<div class="showing"><span>Showing 10 of 100</span></div>
          <div class="clear"></div>
          <div class="see-m"><a class="button2 orange1" href="#">VIEW ALL REVIEWS</a></div>-->
          <div class="clear"></div>
             
            <div class="see-mone"> 
          <a href="javascript: window.history.go(-1);" class="button3 orange1">GO BACK</a>
          </div>
          </article>

  
        </div></section>
        
      </div>
        
    </div> 
