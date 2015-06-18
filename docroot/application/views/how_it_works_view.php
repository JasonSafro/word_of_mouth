<!--for us of back to top function-->
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
 <script type="text/javascript" src="<?php echo SITE_ROOT_FOR_USER?>assets/plugins/html5gallery/html5gallery.js"></script>
    <div id="page-wrap">

        <div id="main1">
          <section class="inside-title">
          <div class="inside-title-in"><div  id="main">
          <h1>How it Works</h1> <div class="breadcrums"> <img src="<?php echo USER_SIDE_IMAGES;?>arrow.png" > <a href="<?php echo base_url()?>home/">Home</a> | How it Works</div></div>
          </div>
          </section>
        </div>
        <div class="clear"></div>
 
      <div id="section">
       <?php 
       /*$heightG1="250";
       $widthG1="555";
       $heightG2="250";
       $widthG2="552";*/
       
       //$heightG1="320";
       $heightG1="";
       //$widthG1="570";
       $widthG1="";
       //$heightG2="324";
       $heightG2="";
       //$widthG2="570";
       $widthG2="";
       
       /*if($is_mobile=='Yes'){
           $heightG1="150";
           $widthG1="250";
           $heightG2="150";
           $widthG2="250";
       }*/
       ?>   
       <?php 
       /*$path=base_url().'sitedata/how_it_works_videos/';   
       $imgPath=base_url().'sitedata/images/videoPlayer.jpg';   
       $video1Content='<div style="display:none;" class="html5gallery" data-skin="vertical" id="myVideoGallaryT" data-width="'.$widthG1.'" data-height="'.$heightG1.'">'.
       '<a href="'.$path.$video1.'"><img src="" alt="'.$video1.'"></a>
        </div>';
        $video2Content='<div style="display:none;" class="html5gallery" data-skin="vertical" id="myVideoGallaryT2" data-width="'.$widthG2.'" data-height="'.$heightG1.'">'.
       '<a href="'.$path.$video2.'"><img src="" alt="'.$video2.'"></a>
        </div>';*/
        ?>  
          <?php $video1Content='<img alt="people" src="'.USER_SIDE_IMAGES.'iStock_000031359856_Medium.jpg" height="'.$heightG1.'" width="'.$widthG1.'">';?>
          <?php $video2Content='<img alt="people" src="'.USER_SIDE_IMAGES.'iStock_000019598070_Medium.jpg" height="'.$heightG2.'" width="'.$widthG2.'">';?>
        <?php $pageContent=  str_replace('[[FIRST_VIDEO_HERE]]', $video1Content, $info['pageContent']); ?>
        <?php $pageContent=  str_replace('[[SECOND_VIDEO_HERE]]', $video2Content, $pageContent); ?>
        <?php echo $pageContent;?>
       
        
      </div>
    </div>   

 <script>
 //myVideoGallaryT data-width data-height
                               /* var isMobile="<?php echo $is_mobile;?>";
                                if(isMobile=="Yes"){
                                    $('#myVideoGallaryT').attr('data-width','150');
                                    $('#myVideoGallaryT').attr('data-height','100');
                                    
                                    $('#myVideoGallaryT2').attr('data-width','150');
                                    $('#myVideoGallaryT2').attr('data-height','100');
                                }*/
 </script>